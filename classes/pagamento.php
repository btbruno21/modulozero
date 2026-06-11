<?php
require_once 'conexao.php';

class Pagamento
{
    protected $id;
    protected $comanda_id;
    protected $valor;
    protected $forma_pagamento;
    protected $data_pagamento;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()             { return $this->id; }
    public function getComandaId()      { return $this->comanda_id; }
    public function getValor()          { return $this->valor; }
    public function getFormaPagamento() { return $this->forma_pagamento; }
    public function getDataPagamento()  { return $this->data_pagamento; }

    // ─── Ações ───────────────────────────────────────────────
    public function registrar($comanda_id, $valor, $forma_pagamento)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "INSERT INTO pagamentos (comanda_id, valor, forma_pagamento)
                 VALUES (:comanda_id, :valor, :forma_pagamento)"
            );
            $sql->bindParam(':comanda_id',      $comanda_id,      PDO::PARAM_INT);
            $sql->bindParam(':valor',           $valor);
            $sql->bindParam(':forma_pagamento', $forma_pagamento, PDO::PARAM_STR);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    // ─── Buscas ──────────────────────────────────────────────
    public function buscarPorComanda($comanda_id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM pagamentos
                 WHERE comanda_id = :comanda_id
                 ORDER BY data_pagamento"
            );
            $sql->bindParam(':comanda_id', $comanda_id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function totalPago($comanda_id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT COALESCE(SUM(valor), 0) AS total
                 FROM pagamentos
                 WHERE comanda_id = :comanda_id"
            );
            $sql->bindParam(':comanda_id', $comanda_id, PDO::PARAM_INT);
            $sql->execute();

            $row = $sql->fetch(PDO::FETCH_ASSOC);

            return (float) $row['total'];

        } catch (PDOException $e) {
            return 0.0;
        }
    }

    public function totalDia($data = null)
    {
        try {
            $dataStr = $data ?? date('Y-m-d');

            $sql = $this->con->conectar()->prepare(
                "SELECT forma_pagamento, SUM(valor) AS total, COUNT(*) AS qtd
                 FROM pagamentos
                 WHERE DATE(data_pagamento) = :data
                 GROUP BY forma_pagamento"
            );
            $sql->bindParam(':data', $dataStr, PDO::PARAM_STR);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
