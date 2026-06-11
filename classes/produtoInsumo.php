<?php
require_once 'conexao.php';

class ProdutoInsumo
{
    protected $id;
    protected $produto_id;
    protected $insumo_id;
    protected $quantidade_utilizada;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()                  { return $this->id; }
    public function getProdutoId()           { return $this->produto_id; }
    public function getInsumoId()            { return $this->insumo_id; }
    public function getQuantidadeUtilizada() { return $this->quantidade_utilizada; }

    // ─── Ações ───────────────────────────────────────────────
    public function vincular($produto_id, $insumo_id, $quantidade_utilizada)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "INSERT INTO produto_insumos (produto_id, insumo_id, quantidade_utilizada)
                 VALUES (:produto_id, :insumo_id, :quantidade_utilizada)
                 ON DUPLICATE KEY UPDATE quantidade_utilizada = :quantidade_utilizada"
            );
            $sql->bindParam(':produto_id',           $produto_id,          PDO::PARAM_INT);
            $sql->bindParam(':insumo_id',            $insumo_id,           PDO::PARAM_INT);
            $sql->bindParam(':quantidade_utilizada', $quantidade_utilizada);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function desvincular($produto_id, $insumo_id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "DELETE FROM produto_insumos
                 WHERE produto_id = :produto_id AND insumo_id = :insumo_id"
            );
            $sql->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $sql->bindParam(':insumo_id',  $insumo_id,  PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    // ─── Buscas ──────────────────────────────────────────────
    public function buscarPorProduto($produto_id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT pi.*, i.nome AS insumo_nome, i.unidade
                 FROM produto_insumos pi
                 JOIN insumos i ON i.id = pi.insumo_id
                 WHERE pi.produto_id = :produto_id"
            );
            $sql->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
