<?php
require_once __DIR__ . '/Conexao.php';

class Alimento
{
    private $id;
    private $categoriaId;
    private $setorId;
    private $nome;
    private $descricao;
    private $preco;
    private $imagem;
    private $tempoPreparo;
    private $ativo;
    private $criadoEm;
    private $pdo;

    public function __construct(array $dados = [])
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->conectar();

        if (!empty($dados)) {
            $this->id           = $dados['id'] ?? null;
            $this->categoriaId  = $dados['categoria_id'] ?? null;
            $this->setorId      = $dados['setor_id'] ?? null;
            $this->nome         = $dados['nome'] ?? null;
            $this->descricao    = $dados['descricao'] ?? null;
            $this->preco        = $dados['preco'] ?? null;
            $this->imagem       = $dados['imagem'] ?? null;
            $this->tempoPreparo = $dados['tempo_preparo'] ?? null;
            $this->ativo        = $dados['ativo'] ?? true;
            $this->criadoEm     = $dados['criado_em'] ?? null;
        }
    }

    // ------------------- Getters -------------------
    public function getId() { return $this->id; }
    public function getCategoriaId() { return $this->categoriaId; }
    public function getSetorId() { return $this->setorId; }
    public function getNome() { return $this->nome; }
    public function getDescricao() { return $this->descricao; }
    public function getPreco() { return $this->preco; }
    public function getImagem() { return $this->imagem; }
    public function getTempoPreparo() { return $this->tempoPreparo; }
    public function getAtivo() { return $this->ativo; }
    public function getCriadoEm() { return $this->criadoEm; }

    // ------------------- Setters -------------------
    public function setCategoriaId($v) { $this->categoriaId = $v; }
    public function setSetorId($v) { $this->setorId = $v; }
    public function setNome($v) { $this->nome = $v; }
    public function setDescricao($v) { $this->descricao = $v; }
    public function setPreco($v) { $this->preco = $v; }
    public function setImagem($v) { $this->imagem = $v; }
    public function setTempoPreparo($v) { $this->tempoPreparo = $v; }
    public function setAtivo($v) { $this->ativo = $v; }

    // ------------------- CRUD -------------------

    public function salvar()
    {
        $sql = "INSERT INTO alimento
                    (categoria_id, setor_id, nome, descricao, preco, imagem, tempo_preparo, ativo)
                VALUES
                    (:categoria_id, :setor_id, :nome, :descricao, :preco, :imagem, :tempo_preparo, :ativo)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':categoria_id', $this->categoriaId, PDO::PARAM_INT);
        $stmt->bindValue(':setor_id', $this->setorId, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':descricao', $this->descricao);
        $stmt->bindValue(':preco', $this->preco);
        $stmt->bindValue(':imagem', $this->imagem);
        $stmt->bindValue(':tempo_preparo', $this->tempoPreparo, PDO::PARAM_INT);
        $stmt->bindValue(':ativo', $this->ativo ?? true, PDO::PARAM_BOOL);

        $stmt->execute();
        $this->id = $this->pdo->lastInsertId();

        return $this->id;
    }

    public function atualizar()
    {
        $sql = "UPDATE alimento SET
                    categoria_id = :categoria_id,
                    setor_id = :setor_id,
                    nome = :nome,
                    descricao = :descricao,
                    preco = :preco,
                    imagem = :imagem,
                    tempo_preparo = :tempo_preparo,
                    ativo = :ativo
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':categoria_id', $this->categoriaId, PDO::PARAM_INT);
        $stmt->bindValue(':setor_id', $this->setorId, PDO::PARAM_INT);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':descricao', $this->descricao);
        $stmt->bindValue(':preco', $this->preco);
        $stmt->bindValue(':imagem', $this->imagem);
        $stmt->bindValue(':tempo_preparo', $this->tempoPreparo, PDO::PARAM_INT);
        $stmt->bindValue(':ativo', $this->ativo, PDO::PARAM_BOOL);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function inativar()
    {
        $sql = "UPDATE alimento SET ativo = 0 WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM alimento WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarTodos($apenasAtivos = true)
    {
        $sql = "SELECT a.*, c.nome AS categoria_nome, s.nome AS setor_nome
                FROM alimento a
                JOIN categoria c ON c.id = a.categoria_id
                JOIN setor s ON s.id = a.setor_id";

        if ($apenasAtivos) {
            $sql .= " WHERE a.ativo = 1";
        }
        $sql .= " ORDER BY a.nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorCategoria($categoriaId)
    {
        $sql = "SELECT * FROM alimento WHERE categoria_id = :categoria_id AND ativo = 1 ORDER BY nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ------------------------------------------------------
    // Observações permitidas (tabela alimento_observacao)
    // ------------------------------------------------------

    public function adicionarObservacao($observacaoId)
    {
        $sql = "INSERT INTO alimento_observacao (alimento_id, observacao_id) VALUES (:alimento_id, :observacao_id)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':alimento_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':observacao_id', $observacaoId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function removerObservacao($observacaoId)
    {
        $sql = "DELETE FROM alimento_observacao WHERE alimento_id = :alimento_id AND observacao_id = :observacao_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':alimento_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':observacao_id', $observacaoId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function listarObservacoes($alimentoId = null)
    {
        $id = $alimentoId ?? $this->id;

        $sql = "SELECT o.* FROM observacao o
                JOIN alimento_observacao ao ON ao.observacao_id = o.id
                WHERE ao.alimento_id = :alimento_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':alimento_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarAtivos()
    {
        $sql = "SELECT a.*, c.nome AS categoria_nome, s.nome AS setor_nome
                FROM alimento a
                JOIN categoria c ON c.id = a.categoria_id
                JOIN setor s ON s.id = a.setor_id
                WHERE a.ativo = 1
                ORDER BY a.nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
