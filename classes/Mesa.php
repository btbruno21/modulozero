<?php
require_once __DIR__ . '/Conexao.php';

class Mesa
{
    private $id;
    private $numero;
    private $status; // LIVRE, OCUPADA
    private $pdo;

    public function __construct(array $dados = [])
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->conectar();

        if (!empty($dados)) {
            $this->id     = $dados['id'] ?? null;
            $this->numero = $dados['numero'] ?? null;
            $this->status = $dados['status'] ?? 'LIVRE';
        }
    }

    // ------------------- Getters -------------------
    public function getId() { return $this->id; }
    public function getNumero() { return $this->numero; }
    public function getStatus() { return $this->status; }

    // ------------------- Setters -------------------
    public function setNumero($numero) { $this->numero = $numero; }
    public function setStatus($status) { $this->status = $status; }

    // ------------------- CRUD -------------------

    public function salvar()
    {
        $sql = "INSERT INTO mesa (numero, status) VALUES (:numero, :status)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':numero', $this->numero, PDO::PARAM_INT);
        $stmt->bindValue(':status', $this->status ?? 'LIVRE');
        $stmt->execute();

        $this->id = $this->pdo->lastInsertId();
        return $this->id;
    }

    public function atualizar()
    {
        $sql = "UPDATE mesa SET numero = :numero, status = :status WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':numero', $this->numero, PDO::PARAM_INT);
        $stmt->bindValue(':status', $this->status);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function ocupar($id)
    {
        return $this->alterarStatus($id, 'OCUPADA');
    }

    public function liberar($id)
    {
        return $this->alterarStatus($id, 'LIVRE');
    }

    private function alterarStatus($id, $status)
    {
        $sql = "UPDATE mesa SET status = :status WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM mesa WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorNumero($numero)
    {
        $sql = "SELECT * FROM mesa WHERE numero = :numero";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':numero', $numero, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarTodas()
    {
        $sql = "SELECT * FROM mesa ORDER BY numero";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarLivres()
    {
        $sql = "SELECT * FROM mesa WHERE status = 'LIVRE' ORDER BY numero";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
