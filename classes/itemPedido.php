<?php
require_once 'conexao.php';

class ItemPedido
{
    protected $id;
    protected $pedido_id;
    protected $produto_id;
    protected $quantidade;
    protected $valor_unitario;
    protected $observacao;
    protected $status;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()            { return $this->id; }
    public function getPedidoId()      { return $this->pedido_id; }
    public function getProdutoId()     { return $this->produto_id; }
    public function getQuantidade()    { return $this->quantidade; }
    public function getValorUnitario() { return $this->valor_unitario; }
    public function getObservacao()    { return $this->observacao; }
    public function getStatus()        { return $this->status; }

    // ─── Ações ───────────────────────────────────────────────
    public function adicionar($pedido_id, $produto_id, $quantidade = 1, $observacao = null)
    {
        try {
            // Busca o preço atual do produto
            $sqlProduto = $this->con->conectar()->prepare(
                "SELECT preco FROM produtos WHERE id = :id AND ativo = 1 LIMIT 1"
            );
            $sqlProduto->bindParam(':id', $produto_id, PDO::PARAM_INT);
            $sqlProduto->execute();

            if ($sqlProduto->rowCount() == 0) {
                return false; // Produto não encontrado ou inativo
            }

            $produto = $sqlProduto->fetch(PDO::FETCH_ASSOC);
            $valor_unitario = $produto['preco'];

            $sql = $this->con->conectar()->prepare(
                "INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, valor_unitario, observacao)
                 VALUES (:pedido_id, :produto_id, :quantidade, :valor_unitario, :observacao)"
            );
            $sql->bindParam(':pedido_id',      $pedido_id,      PDO::PARAM_INT);
            $sql->bindParam(':produto_id',     $produto_id,     PDO::PARAM_INT);
            $sql->bindParam(':quantidade',     $quantidade,     PDO::PARAM_INT);
            $sql->bindParam(':valor_unitario', $valor_unitario);
            $sql->bindParam(':observacao',     $observacao,     PDO::PARAM_STR);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizarStatus($id, $status)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE itens_pedido SET status = :status WHERE id = :id"
            );
            $sql->bindParam(':status', $status, PDO::PARAM_STR);
            $sql->bindParam(':id',     $id,     PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    // ─── Buscas ──────────────────────────────────────────────
    public function buscarPorPedido($pedido_id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT ip.*, p.nome AS produto_nome, p.envia_cozinha
                 FROM itens_pedido ip
                 JOIN produtos p ON p.id = ip.produto_id
                 WHERE ip.pedido_id = :pedido_id"
            );
            $sql->bindParam(':pedido_id', $pedido_id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
