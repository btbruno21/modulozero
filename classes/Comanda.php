<?php
require_once __DIR__ . '/Conexao.php';

class Comanda
{
    private $id;
    private $mesaId;
    private $usuarioAberturaId;
    private $status; // ABERTA, AGUARDANDO_PAGAMENTO, FINALIZADA, CANCELADA
    private $abertaEm;
    private $fechadaEm;
    private $pdo;

    public function __construct(array $dados = [])
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->conectar();

        if (!empty($dados)) {
            $this->id                = $dados['id'] ?? null;
            $this->mesaId            = $dados['mesa_id'] ?? null;
            $this->usuarioAberturaId = $dados['usuario_abertura_id'] ?? null;
            $this->status            = $dados['status'] ?? 'ABERTA';
            $this->abertaEm          = $dados['aberta_em'] ?? null;
            $this->fechadaEm         = $dados['fechada_em'] ?? null;
        }
    }

    // ------------------- Getters -------------------
    public function getId() { return $this->id; }
    public function getMesaId() { return $this->mesaId; }
    public function getUsuarioAberturaId() { return $this->usuarioAberturaId; }
    public function getStatus() { return $this->status; }
    public function getAbertaEm() { return $this->abertaEm; }
    public function getFechadaEm() { return $this->fechadaEm; }

    // ------------------- Setters -------------------
    public function setMesaId($v) { $this->mesaId = $v; }
    public function setUsuarioAberturaId($v) { $this->usuarioAberturaId = $v; }
    public function setStatus($v) { $this->status = $v; }

    /**
     * Abre uma nova comanda. Se houver mesa vinculada, marca a mesa como OCUPADA.
     */
    public function abrir()
    {
        $this->pdo->beginTransaction();

        try {
            $sql = "INSERT INTO comanda (mesa_id, usuario_abertura_id, status)
                    VALUES (:mesa_id, :usuario_abertura_id, 'ABERTA')";

            $stmt = $this->pdo->prepare($sql);

            if ($this->mesaId) {
                $stmt->bindValue(':mesa_id', $this->mesaId, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':mesa_id', null, PDO::PARAM_NULL);
            }

            $stmt->bindValue(':usuario_abertura_id', $this->usuarioAberturaId, PDO::PARAM_INT);
            $stmt->execute();

            $this->id     = $this->pdo->lastInsertId();
            $this->status = 'ABERTA';

            if ($this->mesaId) {
                $sqlMesa = "UPDATE mesa SET status = 'OCUPADA' WHERE id = :mesa_id";
                $stmtMesa = $this->pdo->prepare($sqlMesa);
                $stmtMesa->bindValue(':mesa_id', $this->mesaId, PDO::PARAM_INT);
                $stmtMesa->execute();
            }

            $this->pdo->commit();
            return $this->id;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function alterarStatus($status)
    {
        $sql = "UPDATE comanda SET status = :status WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $resultado = $stmt->execute();
        $this->status = $status;

        return $resultado;
    }

    /**
     * Finaliza a comanda e libera a mesa vinculada (se houver).
     */
    public function finalizar()
    {
        $this->pdo->beginTransaction();

        try {
            $sql = "UPDATE comanda SET status = 'FINALIZADA', fechada_em = NOW() WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();

            if ($this->mesaId) {
                $sqlMesa = "UPDATE mesa SET status = 'LIVRE' WHERE id = :mesa_id";
                $stmtMesa = $this->pdo->prepare($sqlMesa);
                $stmtMesa->bindValue(':mesa_id', $this->mesaId, PDO::PARAM_INT);
                $stmtMesa->execute();
            }

            $this->pdo->commit();
            $this->status = 'FINALIZADA';

            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function cancelar()
    {
        return $this->alterarStatus('CANCELADA');
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM comanda WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarAbertas()
    {
        $sql = "SELECT c.*, m.numero AS mesa_numero
                FROM comanda c
                LEFT JOIN mesa m ON m.id = c.mesa_id
                WHERE c.status IN ('ABERTA', 'AGUARDANDO_PAGAMENTO')
                ORDER BY c.aberta_em";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorMesa($mesaId)
    {
        $sql = "SELECT * FROM comanda WHERE mesa_id = :mesa_id ORDER BY aberta_em DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':mesa_id', $mesaId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Soma o valor de todos os itens não cancelados da comanda.
     */
    public function calcularTotal($comandaId = null)
    {
        $id = $comandaId ?? $this->id;

        $sql = "SELECT COALESCE(SUM(pi.quantidade * pi.preco_unitario), 0) AS total
                FROM pedido_item pi
                JOIN pedido p ON p.id = pi.pedido_id
                WHERE p.comanda_id = :comanda_id
                AND pi.status <> 'CANCELADO'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':comanda_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
