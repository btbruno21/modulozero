<?php
require_once 'conexao.php';

class Produto
{
    protected $id;
    protected $categoria_id;
    protected $nome;
    protected $descricao;
    protected $preco;
    protected $envia_cozinha;
    protected $ativo;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()           { return $this->id; }
    public function getCategoriaId()  { return $this->categoria_id; }
    public function getNome()         { return $this->nome; }
    public function getDescricao()    { return $this->descricao; }
    public function getPreco()        { return $this->preco; }
    public function getEnviaCozinha() { return $this->envia_cozinha; }
    public function getAtivo()        { return $this->ativo; }

    // ─── CRUD ────────────────────────────────────────────────
    public function criar($nome, $preco, $categoria_id = null, $descricao = null, $envia_cozinha = true)
    {
        try {
            $enviaCozinhaInt = $envia_cozinha ? 1 : 0;

            $sql = $this->con->conectar()->prepare(
                "INSERT INTO produtos (categoria_id, nome, descricao, preco, envia_cozinha)
                 VALUES (:categoria_id, :nome, :descricao, :preco, :envia_cozinha)"
            );
            $sql->bindParam(':categoria_id',  $categoria_id,   PDO::PARAM_INT);
            $sql->bindParam(':nome',          $nome,           PDO::PARAM_STR);
            $sql->bindParam(':descricao',     $descricao,      PDO::PARAM_STR);
            $sql->bindParam(':preco',         $preco);
            $sql->bindParam(':envia_cozinha', $enviaCozinhaInt, PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizar($id, $nome, $preco, $categoria_id = null, $descricao = null, $envia_cozinha = true)
    {
        try {
            $enviaCozinhaInt = $envia_cozinha ? 1 : 0;

            $sql = $this->con->conectar()->prepare(
                "UPDATE produtos
                 SET categoria_id = :categoria_id,
                     nome = :nome,
                     descricao = :descricao,
                     preco = :preco,
                     envia_cozinha = :envia_cozinha
                 WHERE id = :id"
            );
            $sql->bindParam(':id',           $id,             PDO::PARAM_INT);
            $sql->bindParam(':categoria_id', $categoria_id,   PDO::PARAM_INT);
            $sql->bindParam(':nome',         $nome,           PDO::PARAM_STR);
            $sql->bindParam(':descricao',    $descricao,      PDO::PARAM_STR);
            $sql->bindParam(':preco',        $preco);
            $sql->bindParam(':envia_cozinha', $enviaCozinhaInt, PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function ativar($id)
    {
        return $this->setAtivo($id, 1);
    }

    public function desativar($id)
    {
        return $this->setAtivo($id, 0);
    }

    private function setAtivo($id, $ativo)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE produtos SET ativo = :ativo WHERE id = :id"
            );
            $sql->bindParam(':ativo', $ativo, PDO::PARAM_INT);
            $sql->bindParam(':id',    $id,    PDO::PARAM_INT);

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
                "SELECT p.*, c.nome AS categoria_nome
                 FROM produtos p
                 LEFT JOIN categorias c ON c.id = p.categoria_id
                 WHERE p.id = :id
                 LIMIT 1"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : null;

        } catch (PDOException $e) {
            return null;
        }
    }

    public function buscarAtivos()
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT p.*, c.nome AS categoria_nome
                 FROM produtos p
                 LEFT JOIN categorias c ON c.id = p.categoria_id
                 WHERE p.ativo = 1
                 ORDER BY c.nome, p.nome"
            );
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarPorCategoria($categoria_id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM produtos
                 WHERE categoria_id = :categoria_id AND ativo = 1
                 ORDER BY nome"
            );
            $sql->bindParam(':categoria_id', $categoria_id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarDaCozinha()
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM produtos WHERE envia_cozinha = 1 AND ativo = 1 ORDER BY nome"
            );
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
