<?php
require_once __DIR__ . '/Conexao.php';

class Setor
{
    private $id;
    private $nome;
    private $ativo;
    private $pdo;

    public function __construct(array $dados = [])
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->conectar();

        if (!empty($dados)) {
            $this->id    = $dados['id'] ?? null;
            $this->nome  = $dados['nome'] ?? null;
            $this->ativo = $dados['ativo'] ?? true;
        }
    }

    // ------------------- Getters -------------------
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getAtivo() { return $this->ativo; }

    // ------------------- Setters -------------------
    public function setNome($nome) { $this->nome = $nome; }
    public function setAtivo($ativo) { $this->ativo = $ativo; }

    // ------------------- CRUD -------------------

    public function salvar()
    {
        $sql = "INSERT INTO setor (nome, ativo) VALUES (:nome, :ativo)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':ativo', $this->ativo ?? true, PDO::PARAM_BOOL);
        $stmt->execute();

        $this->id = $this->pdo->lastInsertId();
        return $this->id;
    }

    public function atualizar()
    {
        $sql = "UPDATE setor SET nome = :nome, ativo = :ativo WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':ativo', $this->ativo, PDO::PARAM_BOOL);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function inativar()
    {
        $sql = "UPDATE setor SET ativo = 0 WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM setor WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarTodos($apenasAtivos = true)
    {
        $sql = "SELECT * FROM setor";
        if ($apenasAtivos) {
            $sql .= " WHERE ativo = 1";
        }
        $sql .= " ORDER BY nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
