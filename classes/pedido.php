<?php
require_once 'conexao.php';

class Pedido
{
    protected $id;
    protected $comanda_id;
    protected $status;
    protected $data_pedido;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()         { return $this->id; }
    public function getComandaId()  { return $this->comanda_id; }
    public function getStatus()     { return $this->status; }
    public function getDataPedido() { return $this->data_pedido; }

    // ─── Ações ───────────────────────────────────────────────

    /**
     * Cria o pedido junto com os seus itens.
     * $itens = [['produto_id' => 1, 'quantidade' => 2, 'observacao' => '...'], ...]
     */
    public function criar($comanda_id, $itens)
    {
        if (empty($itens)) {
            return false;
        }

        try {
            $pdo = $this->con->conectar();
            $pdo->beginTransaction();

            $sql = $pdo->prepare(
                "INSERT INTO pedidos (comanda_id) VALUES (:comanda_id)"
            );
            $sql->bindParam(':comanda_id', $comanda_id, PDO::PARAM_INT);
            $sql->execute();

            $pedido_id = $pdo->lastInsertId();

            // Insere cada item do pedido
            $itemPedido = new ItemPedido();

            foreach ($itens as $item) {
                $resultado = $itemPedido->adicionar(
                    $pedido_id,
                    $item['produto_id'],
                    $item['quantidade']  ?? 1,
                    $item['observacao']  ?? null
                );

                if (!$resultado) {
                    $pdo->rollBack();
                    return false;
                }
            }

            $pdo->commit();

            return $pedido_id;

        } catch (PDOException $e) {
            $pdo->rollBack();
            return false;
        }
    }

    public function avancarStatus($id)
    {
        try {
            $pedido = $this->buscarPorId($id);

            if (!$pedido) {
                return false;
            }

            $fluxo = [
                'PENDENTE'   => 'EM_PREPARO',
                'EM_PREPARO' => 'PRONTO',
                'PRONTO'     => 'ENTREGUE',
            ];

            if (!isset($fluxo[$pedido['status']])) {
                return false; // Já está no status final
            }

            $novoStatus = $fluxo[$pedido['status']];

            $sql = $this->con->conectar()->prepare(
                "UPDATE pedidos SET status = :status WHERE id = :id"
            );
            $sql->bindParam(':status', $novoStatus, PDO::PARAM_STR);
            $sql->bindParam(':id',     $id,         PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    // ─── Buscas ──────────────────────────────────────────────
    public function buscarPorId($id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM pedidos WHERE id = :id LIMIT 1"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : null;

        } catch (PDOException $e) {
            return null;
        }
    }

    public function buscarPorComanda($comanda_id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT p.*
                 FROM pedidos p
                 WHERE p.comanda_id = :comanda_id
                 ORDER BY p.data_pedido"
            );
            $sql->bindParam(':comanda_id', $comanda_id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarPendentesCozinha()
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT p.id AS pedido_id,
                        p.status,
                        p.data_pedido,
                        m.numero AS mesa_numero,
                        ip.id AS item_id,
                        pr.nome AS produto,
                        ip.quantidade,
                        ip.observacao
                 FROM pedidos p
                 JOIN comandas c  ON c.id  = p.comanda_id
                 JOIN mesas m     ON m.id  = c.mesa_id
                 JOIN itens_pedido ip ON ip.pedido_id = p.id
                 JOIN produtos pr  ON pr.id = ip.produto_id
                 WHERE p.status IN ('PENDENTE', 'EM_PREPARO')
                   AND pr.envia_cozinha = 1
                 ORDER BY p.data_pedido"
            );
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
