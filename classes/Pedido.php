<?php
require_once __DIR__ . '/Conexao.php';

class Pedido
{
    private $id;
    private $comandaId;
    private $usuarioId;
    private $criadoEm;
    private $pdo;

    public function __construct(array $dados = [])
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->conectar();

        if (!empty($dados)) {
            $this->id        = $dados['id'] ?? null;
            $this->comandaId = $dados['comanda_id'] ?? null;
            $this->usuarioId = $dados['usuario_id'] ?? null;
            $this->criadoEm  = $dados['criado_em'] ?? null;
        }
    }

    // ------------------- Getters -------------------
    public function getId() { return $this->id; }
    public function getComandaId() { return $this->comandaId; }
    public function getUsuarioId() { return $this->usuarioId; }
    public function getCriadoEm() { return $this->criadoEm; }

    // ------------------- Setters -------------------
    public function setComandaId($v) { $this->comandaId = $v; }
    public function setUsuarioId($v) { $this->usuarioId = $v; }

    // ------------------- CRUD -------------------

    public function salvar()
    {
        $sql = "INSERT INTO pedido (comanda_id, usuario_id) VALUES (:comanda_id, :usuario_id)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':comanda_id', $this->comandaId, PDO::PARAM_INT);
        $stmt->bindValue(':usuario_id', $this->usuarioId, PDO::PARAM_INT);
        $stmt->execute();

        $this->id = $this->pdo->lastInsertId();
        return $this->id;
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM pedido WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarPorComanda($comandaId)
    {
        $sql = "SELECT p.*, u.nome AS usuario_nome
                FROM pedido p
                JOIN usuario u ON u.id = p.usuario_id
                WHERE p.comanda_id = :comanda_id
                ORDER BY p.criado_em";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':comanda_id', $comandaId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodos()
    {
        $sql = "SELECT
                    p.id,
                    p.comanda_id,
                    p.criado_em,
                    c.mesa_id,
                    m.numero AS mesa
                FROM pedido p

                JOIN comanda c
                    ON c.id = p.comanda_id

                LEFT JOIN mesa m
                    ON m.id = c.mesa_id

                ORDER BY p.criado_em DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPendentesPorSetor($setor)
    {
        $sql = "SELECT DISTINCT
                    p.id,
                    p.comanda_id,
                    p.criado_em,
                    c.mesa_id,
                    m.numero AS mesa
                FROM pedido p

                JOIN comanda c
                    ON c.id = p.comanda_id

                LEFT JOIN mesa m
                    ON m.id = c.mesa_id

                JOIN pedido_item pi
                    ON pi.pedido_id = p.id

                JOIN alimento a
                    ON a.id = pi.alimento_id

                JOIN setor s
                    ON s.id = a.setor_id

                WHERE s.nome = :setor
                AND pi.status IN ('FILA', 'PREPARANDO')

                ORDER BY p.criado_em";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':setor', $setor);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
