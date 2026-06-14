<?php
require_once __DIR__ . '/Conexao.php';

class Observacao
{
    private $id;
    private $descricao;
    private $ativo;
    private $pdo;

    public function __construct(array $dados = [])
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->conectar();

        if (!empty($dados)) {
            $this->id        = $dados['id'] ?? null;
            $this->descricao = $dados['descricao'] ?? null;
            $this->ativo     = $dados['ativo'] ?? true;
        }
    }

    // ------------------- Getters -------------------
    public function getId() { return $this->id; }
    public function getDescricao() { return $this->descricao; }
    public function getAtivo() { return $this->ativo; }

    // ------------------- Setters -------------------
    public function setDescricao($descricao) { $this->descricao = $descricao; }
    public function setAtivo($ativo) { $this->ativo = $ativo; }

    // ------------------- CRUD -------------------

    public function salvar()
    {
        $sql = "INSERT INTO observacao (descricao, ativo) VALUES (:descricao, :ativo)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':descricao', $this->descricao);
        $stmt->bindValue(':ativo', $this->ativo ?? true, PDO::PARAM_BOOL);
        $stmt->execute();

        $this->id = $this->pdo->lastInsertId();
        return $this->id;
    }

    public function atualizar()
    {
        $sql = "UPDATE observacao SET descricao = :descricao, ativo = :ativo WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':descricao', $this->descricao);
        $stmt->bindValue(':ativo', $this->ativo, PDO::PARAM_BOOL);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function inativar()
    {
        $sql = "UPDATE observacao SET ativo = 0 WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM observacao WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarTodos($apenasAtivos = true)
    {
        $sql = "SELECT * FROM observacao";
        if ($apenasAtivos) {
            $sql .= " WHERE ativo = 1";
        }
        $sql .= " ORDER BY descricao";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function observacaoAlimento($id)
    {
        $sql = "SELECT o.*
                FROM observacao o
                JOIN alimento_observacao ao ON ao.observacao_id = o.id
                JOIN alimento a ON a.id = ao.alimento_id
                WHERE a.id = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
