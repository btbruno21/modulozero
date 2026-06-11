<?php
require_once 'conexao.php';

class LogSistema
{
    protected $id;
    protected $usuario_id;
    protected $tabela_afetada;
    protected $acao;
    protected $descricao;
    protected $data_log;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()            { return $this->id; }
    public function getUsuarioId()     { return $this->usuario_id; }
    public function getTabelaAfetada() { return $this->tabela_afetada; }
    public function getAcao()          { return $this->acao; }
    public function getDescricao()     { return $this->descricao; }
    public function getDataLog()       { return $this->data_log; }

    // ─── Ações ───────────────────────────────────────────────
    public function registrar($tabela, $acao, $descricao, $usuario_id = null)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "INSERT INTO logs_sistema (usuario_id, tabela_afetada, acao, descricao)
                 VALUES (:usuario_id, :tabela, :acao, :descricao)"
            );
            $sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $sql->bindParam(':tabela',     $tabela,     PDO::PARAM_STR);
            $sql->bindParam(':acao',       $acao,       PDO::PARAM_STR);
            $sql->bindParam(':descricao',  $descricao,  PDO::PARAM_STR);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    // ─── Buscas ──────────────────────────────────────────────
    public function buscarRecentes($limite = 100)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT l.*, u.nome AS usuario_nome
                 FROM logs_sistema l
                 LEFT JOIN usuarios u ON u.id = l.usuario_id
                 ORDER BY l.data_log DESC
                 LIMIT :limite"
            );
            $sql->bindParam(':limite', $limite, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarPorTabela($tabela, $limite = 50)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT l.*, u.nome AS usuario_nome
                 FROM logs_sistema l
                 LEFT JOIN usuarios u ON u.id = l.usuario_id
                 WHERE l.tabela_afetada = :tabela
                 ORDER BY l.data_log DESC
                 LIMIT :limite"
            );
            $sql->bindParam(':tabela', $tabela, PDO::PARAM_STR);
            $sql->bindParam(':limite', $limite, PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarPorUsuario($usuario_id, $limite = 50)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT * FROM logs_sistema
                 WHERE usuario_id = :usuario_id
                 ORDER BY data_log DESC
                 LIMIT :limite"
            );
            $sql->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $sql->bindParam(':limite',     $limite,     PDO::PARAM_INT);
            $sql->execute();

            return $sql->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [];
        }
    }
}
