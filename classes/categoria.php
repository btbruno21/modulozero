<?php
require_once 'conexao.php';

class Categoria
{
    protected $id;
    protected $nome;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()   { return $this->id; }
    public function getNome() { return $this->nome; }

    // ─── CRUD ────────────────────────────────────────────────
    public function criar($nome)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "INSERT INTO categorias (nome) VALUES (:nome)"
            );
            $sql->bindParam(':nome', $nome, PDO::PARAM_STR);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizar($id, $nome)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE categorias SET nome = :nome WHERE id = :id"
            );
            $sql->bindParam(':nome', $nome, PDO::PARAM_STR);
            $sql->bindParam(':id',   $id,   PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function excluir($id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "DELETE FROM categorias WHERE id = :id"
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
                "SELECT * FROM categorias WHERE id = :id LIMIT 1"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : null;

        } catch (PDOException $e) {
            return null;
        }
    }

    public function buscarTodas()
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM categorias ORDER BY nome"
            );
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarComProdutos()
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT c.*, COUNT(p.id) AS total_produtos
                 FROM categorias c
                 LEFT JOIN produtos p ON p.categoria_id = c.id AND p.ativo = 1
                 GROUP BY c.id
                 ORDER BY c.nome"
            );
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
