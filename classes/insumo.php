<?php
require_once 'conexao.php';

class Insumo
{
    protected $id;
    protected $nome;
    protected $unidade;
    protected $quantidade_estoque;
    protected $estoque_minimo;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()                { return $this->id; }
    public function getNome()              { return $this->nome; }
    public function getUnidade()           { return $this->unidade; }
    public function getQuantidadeEstoque() { return $this->quantidade_estoque; }
    public function getEstoqueMinimo()     { return $this->estoque_minimo; }

    // ─── CRUD ────────────────────────────────────────────────
    public function criar($nome, $unidade, $quantidade_inicial = 0, $estoque_minimo = 0)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "INSERT INTO insumos (nome, unidade, quantidade_estoque, estoque_minimo)
                 VALUES (:nome, :unidade, :quantidade_estoque, :estoque_minimo)"
            );
            $sql->bindParam(':nome',               $nome,              PDO::PARAM_STR);
            $sql->bindParam(':unidade',            $unidade,           PDO::PARAM_STR);
            $sql->bindParam(':quantidade_estoque', $quantidade_inicial);
            $sql->bindParam(':estoque_minimo',     $estoque_minimo);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizar($id, $nome, $unidade, $estoque_minimo)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE insumos
                 SET nome = :nome, unidade = :unidade, estoque_minimo = :estoque_minimo
                 WHERE id = :id"
            );
            $sql->bindParam(':nome',           $nome,           PDO::PARAM_STR);
            $sql->bindParam(':unidade',        $unidade,        PDO::PARAM_STR);
            $sql->bindParam(':estoque_minimo', $estoque_minimo);
            $sql->bindParam(':id',             $id,             PDO::PARAM_INT);

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
                "SELECT * FROM insumos WHERE id = :id LIMIT 1"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : null;

        } catch (PDOException $e) {
            return null;
        }
    }

    public function buscarTodos()
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM insumos ORDER BY nome"
            );
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarAbaixoMinimo()
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM insumos
                 WHERE quantidade_estoque <= estoque_minimo
                 ORDER BY nome"
            );
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
