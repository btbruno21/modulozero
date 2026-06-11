<?php
require_once 'conexao.php';

class Comanda
{
    protected $id;
    protected $mesa_id;
    protected $garcom_id;
    protected $qtd_pessoas;
    protected $status;
    protected $valor_total;
    protected $data_abertura;
    protected $data_fechamento;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()             { return $this->id; }
    public function getMesaId()         { return $this->mesa_id; }
    public function getGarcomId()       { return $this->garcom_id; }
    public function getQtdPessoas()     { return $this->qtd_pessoas; }
    public function getStatus()         { return $this->status; }
    public function getValorTotal()     { return $this->valor_total; }
    public function getDataAbertura()   { return $this->data_abertura; }
    public function getDataFechamento() { return $this->data_fechamento; }

    // ─── Ações ───────────────────────────────────────────────
    public function abrir($mesa_id, $garcom_id = null, $qtd_pessoas = 1)
    {
        try {
            $pdo = $this->con->conectar();
            $pdo->beginTransaction();

            $sql = $pdo->prepare(
                "INSERT INTO comandas (mesa_id, garcom_id, qtd_pessoas)
                 VALUES (:mesa_id, :garcom_id, :qtd_pessoas)"
            );
            $sql->bindParam(':mesa_id',     $mesa_id,    PDO::PARAM_INT);
            $sql->bindParam(':garcom_id',   $garcom_id,  PDO::PARAM_INT);
            $sql->bindParam(':qtd_pessoas', $qtd_pessoas, PDO::PARAM_INT);
            $sql->execute();

            // Marca a mesa como ocupada
            $sqlMesa = $pdo->prepare(
                "UPDATE mesas SET status = 'OCUPADA', data_abertura = NOW() WHERE id = :id"
            );
            $sqlMesa->bindParam(':id', $mesa_id, PDO::PARAM_INT);
            $sqlMesa->execute();

            $pdo->commit();

            return $pdo->lastInsertId();

        } catch (PDOException $e) {
            $pdo->rollBack();
            return false;
        }
    }

    public function fechar($id)
    {
        try {
            $pdo = $this->con->conectar();
            $pdo->beginTransaction();

            $comanda = $this->buscarPorId($id);

            if (!$comanda || $comanda['status'] !== 'ABERTA') {
                return false;
            }

            $sql = $pdo->prepare(
                "UPDATE comandas
                 SET status = 'FECHADA', data_fechamento = NOW()
                 WHERE id = :id"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();

            // Libera a mesa
            $sqlMesa = $pdo->prepare(
                "UPDATE mesas SET status = 'LIVRE', data_abertura = NULL WHERE id = :mesa_id"
            );
            $sqlMesa->bindParam(':mesa_id', $comanda['mesa_id'], PDO::PARAM_INT);
            $sqlMesa->execute();

            $pdo->commit();

            return true;

        } catch (PDOException $e) {
            $pdo->rollBack();
            return false;
        }
    }

    public function cancelar($id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE comandas
                 SET status = 'CANCELADA', data_fechamento = NOW()
                 WHERE id = :id AND status = 'ABERTA'"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizarTotal($id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE comandas c
                 SET valor_total = (
                     SELECT COALESCE(SUM(ip.quantidade * ip.valor_unitario), 0)
                     FROM pedidos p
                     JOIN itens_pedido ip ON ip.pedido_id = p.id
                     WHERE p.comanda_id = c.id
                 )
                 WHERE c.id = :id"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);

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
                "SELECT c.*, m.numero AS mesa_numero, u.nome AS garcom_nome
                 FROM comandas c
                 JOIN mesas m ON m.id = c.mesa_id
                 LEFT JOIN usuarios u ON u.id = c.garcom_id
                 WHERE c.id = :id
                 LIMIT 1"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : null;

        } catch (PDOException $e) {
            return null;
        }
    }

    public function buscarAbertas()
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT c.*, m.numero AS mesa_numero, u.nome AS garcom_nome
                 FROM comandas c
                 JOIN mesas m ON m.id = c.mesa_id
                 LEFT JOIN usuarios u ON u.id = c.garcom_id
                 WHERE c.status = 'ABERTA'
                 ORDER BY c.data_abertura"
            );
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarPorMesa($mesa_id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM comandas
                 WHERE mesa_id = :mesa_id AND status = 'ABERTA'
                 ORDER BY data_abertura DESC
                 LIMIT 1"
            );
            $sql->bindParam(':mesa_id', $mesa_id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : null;

        } catch (PDOException $e) {
            return null;
        }
    }
}
