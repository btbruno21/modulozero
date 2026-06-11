<?php
require_once 'conexao.php';

class Mesa
{
    protected $id;
    protected $numero;
    protected $status;
    protected $data_abertura;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()           { return $this->id; }
    public function getNumero()       { return $this->numero; }
    public function getStatus()       { return $this->status; }
    public function getDataAbertura() { return $this->data_abertura; }

    // ─── CRUD ────────────────────────────────────────────────
    public function criar($numero)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "INSERT INTO mesas (numero) VALUES (:numero)"
            );
            $sql->bindParam(':numero', $numero, PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function abrir($id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE mesas
                 SET status = 'OCUPADA', data_abertura = NOW()
                 WHERE id = :id AND status = 'LIVRE'"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function fechar($id)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE mesas
                 SET status = 'LIVRE', data_abertura = NULL
                 WHERE id = :id"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function setStatus($id, $status)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE mesas SET status = :status WHERE id = :id"
            );
            $sql->bindParam(':status', $status, PDO::PARAM_STR);
            $sql->bindParam(':id',     $id,     PDO::PARAM_INT);

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
                "SELECT * FROM mesas WHERE id = :id LIMIT 1"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : null;

        } catch (PDOException $e) {
            return null;
        }
    }

    public function buscarPorNumero($numero)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM mesas WHERE numero = :numero LIMIT 1"
            );
            $sql->bindParam(':numero', $numero, PDO::PARAM_INT);
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
                "SELECT * FROM mesas ORDER BY numero"
            );
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarLivres()
    {
        return $this->buscarPorStatus('LIVRE');
    }

    public function buscarOcupadas()
    {
        return $this->buscarPorStatus('OCUPADA');
    }

    public function buscarPorStatus($status)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM mesas WHERE status = :status ORDER BY numero"
            );
            $sql->bindParam(':status', $status, PDO::PARAM_STR);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
