<?php
require_once __DIR__ . '/Conexao.php';

class PedidoItem
{
    private $id;
    private $pedidoId;
    private $alimentoId;
    private $quantidade;
    private $precoUnitario;
    private $observacaoLivre;
    private $status; // FILA, PREPARANDO, PRONTO, ENTREGUE, CANCELADO
    private $pdo;

    public function __construct(array $dados = [])
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->conectar();

        if (!empty($dados)) {
            $this->id              = $dados['id'] ?? null;
            $this->pedidoId        = $dados['pedido_id'] ?? null;
            $this->alimentoId      = $dados['alimento_id'] ?? null;
            $this->quantidade      = $dados['quantidade'] ?? 1;
            $this->precoUnitario   = $dados['preco_unitario'] ?? null;
            $this->observacaoLivre = $dados['observacao_livre'] ?? null;
            $this->status          = $dados['status'] ?? 'FILA';
        }
    }

    // ------------------- Getters -------------------
    public function getId() { return $this->id; }
    public function getPedidoId() { return $this->pedidoId; }
    public function getAlimentoId() { return $this->alimentoId; }
    public function getQuantidade() { return $this->quantidade; }
    public function getPrecoUnitario() { return $this->precoUnitario; }
    public function getObservacaoLivre() { return $this->observacaoLivre; }
    public function getStatus() { return $this->status; }

    // ------------------- Setters -------------------
    public function setPedidoId($v) { $this->pedidoId = $v; }
    public function setAlimentoId($v) { $this->alimentoId = $v; }
    public function setQuantidade($v) { $this->quantidade = $v; }
    public function setPrecoUnitario($v) { $this->precoUnitario = $v; }
    public function setObservacaoLivre($v) { $this->observacaoLivre = $v; }
    public function setStatus($v) { $this->status = $v; }

    // ------------------- CRUD -------------------

    public function salvar()
    {
        $sql = "INSERT INTO pedido_item
                    (pedido_id, alimento_id, quantidade, preco_unitario, observacao_livre, status)
                VALUES
                    (:pedido_id, :alimento_id, :quantidade, :preco_unitario, :observacao_livre, :status)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':pedido_id', $this->pedidoId, PDO::PARAM_INT);
        $stmt->bindValue(':alimento_id', $this->alimentoId, PDO::PARAM_INT);
        $stmt->bindValue(':quantidade', $this->quantidade, PDO::PARAM_INT);
        $stmt->bindValue(':preco_unitario', $this->precoUnitario);
        $stmt->bindValue(':observacao_livre', $this->observacaoLivre);
        $stmt->bindValue(':status', $this->status ?? 'FILA');

        $stmt->execute();
        $this->id = $this->pdo->lastInsertId();

        return $this->id;
    }

    public function atualizarStatus($status)
    {
        $sql = "UPDATE pedido_item SET status = :status WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        $resultado = $stmt->execute();
        $this->status = $status;

        return $resultado;
    }

    public function cancelar()
    {
        return $this->atualizarStatus('CANCELADO');
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM pedido_item WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listarPorPedido($pedidoId)
    {
        $sql = "SELECT pi.*, a.nome AS alimento_nome, a.setor_id
                FROM pedido_item pi
                JOIN alimento a ON a.id = pi.alimento_id
                WHERE pi.pedido_id = :pedido_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorComanda($comandaId)
    {
        $sql = "SELECT pi.*, a.nome AS alimento_nome, a.setor_id
                FROM pedido_item pi
                JOIN pedido p ON p.id = pi.pedido_id
                JOIN alimento a ON a.id = pi.alimento_id
                WHERE p.comanda_id = :comanda_id
                AND pi.status <> 'CANCELADO'
                ORDER BY pi.id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':comanda_id', $comandaId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Útil para as telas de cozinha/bar: lista itens de um setor,
     * opcionalmente filtrando por status (ex: FILA, PREPARANDO).
     */
    public function listarPorSetor($setorId, $status = null)
    {
        $sql = "SELECT pi.*, a.nome AS alimento_nome
                FROM pedido_item pi
                JOIN alimento a ON a.id = pi.alimento_id
                WHERE a.setor_id = :setor_id";

        if ($status) {
            $sql .= " AND pi.status = :status";
        }
        $sql .= " ORDER BY pi.id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':setor_id', $setorId, PDO::PARAM_INT);

        if ($status) {
            $stmt->bindValue(':status', $status);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ------------------------------------------------------
    // Observações escolhidas (tabela pedido_item_observacao)
    // ------------------------------------------------------

    public function adicionarObservacao($observacaoId)
    {
        $sql = "INSERT INTO pedido_item_observacao (pedido_item_id, observacao_id) VALUES (:item_id, :observacao_id)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':item_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':observacao_id', $observacaoId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function removerObservacao($observacaoId)
    {
        $sql = "DELETE FROM pedido_item_observacao WHERE pedido_item_id = :item_id AND observacao_id = :observacao_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':item_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':observacao_id', $observacaoId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function listarObservacoes($itemId = null)
    {
        $id = $itemId ?? $this->id;

        $sql = "SELECT o.* FROM observacao o
                JOIN pedido_item_observacao pio ON pio.observacao_id = o.id
                WHERE pio.pedido_item_id = :item_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':item_id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
