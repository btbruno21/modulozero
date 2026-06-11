<?php
require_once 'conexao.php';

class MovimentacaoEstoque
{
    protected $id;
    protected $insumo_id;
    protected $tipo;
    protected $quantidade;
    protected $referencia;
    protected $data_movimentacao;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()                { return $this->id; }
    public function getInsumoId()          { return $this->insumo_id; }
    public function getTipo()              { return $this->tipo; }
    public function getQuantidade()        { return $this->quantidade; }
    public function getReferencia()        { return $this->referencia; }
    public function getDataMovimentacao()  { return $this->data_movimentacao; }

    // ─── Ações ───────────────────────────────────────────────
    public function registrar($insumo_id, $tipo, $quantidade, $referencia = null)
    {
        try {
            $pdo = $this->con->conectar();
            $pdo->beginTransaction();

            $sql = $pdo->prepare(
                "INSERT INTO movimentacoes_estoque (insumo_id, tipo, quantidade, referencia)
                 VALUES (:insumo_id, :tipo, :quantidade, :referencia)"
            );
            $sql->bindParam(':insumo_id',  $insumo_id,  PDO::PARAM_INT);
            $sql->bindParam(':tipo',       $tipo,       PDO::PARAM_STR);
            $sql->bindParam(':quantidade', $quantidade);
            $sql->bindParam(':referencia', $referencia, PDO::PARAM_STR);
            $sql->execute();

            // Atualiza o estoque do insumo
            $sinal  = ($tipo === 'SAIDA') ? '-' : '+';

            $sqlInsumo = $pdo->prepare(
                "UPDATE insumos
                 SET quantidade_estoque = quantidade_estoque {$sinal} :quantidade
                 WHERE id = :id"
            );
            $sqlInsumo->bindParam(':quantidade', $quantidade);
            $sqlInsumo->bindParam(':id',         $insumo_id, PDO::PARAM_INT);
            $sqlInsumo->execute();

            $pdo->commit();

            return true;

        } catch (PDOException $e) {
            $pdo->rollBack();
            return false;
        }
    }

    public function entrada($insumo_id, $quantidade, $referencia = null)
    {
        return $this->registrar($insumo_id, 'ENTRADA', $quantidade, $referencia);
    }

    public function saida($insumo_id, $quantidade, $referencia = null)
    {
        return $this->registrar($insumo_id, 'SAIDA', $quantidade, $referencia);
    }

    public function ajuste($insumo_id, $nova_quantidade)
    {
        try {
            $insumo = (new Insumo())->buscarPorId($insumo_id);

            if (!$insumo) {
                return false;
            }

            $referencia = "Ajuste: {$insumo['quantidade_estoque']} → {$nova_quantidade}";
            $diferenca  = abs($nova_quantidade - $insumo['quantidade_estoque']);

            $this->registrar($insumo_id, 'AJUSTE', $diferenca, $referencia);

            // Corrige o estoque para o valor exato
            $sql = $this->con->conectar()->prepare(
                "UPDATE insumos SET quantidade_estoque = :quantidade WHERE id = :id"
            );
            $sql->bindParam(':quantidade', $nova_quantidade);
            $sql->bindParam(':id',         $insumo_id, PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    // ─── Buscas ──────────────────────────────────────────────
    public function buscarPorInsumo($insumo_id, $limite = 50)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM movimentacoes_estoque
                 WHERE insumo_id = :insumo_id
                 ORDER BY data_movimentacao DESC
                 LIMIT :limite"
            );
            $sql->bindParam(':insumo_id', $insumo_id, PDO::PARAM_INT);
            $sql->bindParam(':limite',    $limite,    PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
