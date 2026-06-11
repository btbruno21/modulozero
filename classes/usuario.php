<?php
require_once 'conexao.php';

class Usuario
{
    protected $id;
    protected $nome;
    protected $email;
    protected $senha;
    protected $tipo;
    protected $ativo;

    protected $con;

    public function __construct()
    {
        $this->con = new Conexao();
    }

    // ─── Getters ────────────────────────────────────────────
    public function getId()        { return $this->id; }
    public function getNome()      { return $this->nome; }
    public function getEmail()     { return $this->email; }
    public function getTipo()      { return $this->tipo; }
    public function getAtivo()     { return $this->ativo; }

    // ─── Verificações internas ───────────────────────────────
    protected function existeEmail($email)
    {
        $sql = $this->con->conectar()->prepare(
            "SELECT id FROM usuarios WHERE email = :email LIMIT 1"
        );
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        return $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : [];
    }

    // ─── Autenticação ────────────────────────────────────────
    public function login($email, $senha)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "SELECT id, nome, email, senha, tipo, ativo
                 FROM usuarios
                 WHERE email = :email
                 LIMIT 1"
            );
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
            $sql->execute();

            if ($sql->rowCount() == 0) {
                return false;
            }

            $usuario = $sql->fetch(PDO::FETCH_ASSOC);

            if (!$usuario['ativo']) {
                return false; // Usuário desativado
            }

            if (password_verify($senha, $usuario['senha'])) {
                unset($usuario['senha']);
                return $usuario;
            }

            return false;

        } catch (PDOException $e) {
            return false;
        }
    }

    // ─── CRUD ────────────────────────────────────────────────
    public function criar($nome, $email, $senha, $tipo)
    {
        try {
            if ($this->existeEmail($email)) {
                return false; // E-mail já cadastrado
            }

            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = $this->con->conectar()->prepare(
                "INSERT INTO usuarios (nome, email, senha, tipo)
                 VALUES (:nome, :email, :senha, :tipo)"
            );
            $sql->bindParam(':nome',  $nome,      PDO::PARAM_STR);
            $sql->bindParam(':email', $email,     PDO::PARAM_STR);
            $sql->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
            $sql->bindParam(':tipo',  $tipo,      PDO::PARAM_STR);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function atualizar($id, $nome, $email, $tipo)
    {
        try {
            $sql = $this->con->conectar()->prepare(
                "UPDATE usuarios
                 SET nome = :nome, email = :email, tipo = :tipo
                 WHERE id = :id"
            );
            $sql->bindParam(':id',    $id,    PDO::PARAM_INT);
            $sql->bindParam(':nome',  $nome,  PDO::PARAM_STR);
            $sql->bindParam(':email', $email, PDO::PARAM_STR);
            $sql->bindParam(':tipo',  $tipo,  PDO::PARAM_STR);

            return $sql->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function alterarSenha($id, $novaSenha)
    {
        try {
            $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

            $sql = $this->con->conectar()->prepare(
                "UPDATE usuarios SET senha = :senha WHERE id = :id"
            );
            $sql->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
            $sql->bindParam(':id',    $id,        PDO::PARAM_INT);

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
                "UPDATE usuarios SET ativo = :ativo WHERE id = :id"
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
                "SELECT id, nome, email, tipo, ativo, created_at
                 FROM usuarios
                 WHERE id = :id
                 LIMIT 1"
            );
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            $sql->execute();

            return $sql->rowCount() > 0 ? $sql->fetch(PDO::FETCH_ASSOC) : null;

        } catch (PDOException $e) {
            return null;
        }
    }

    // public function buscarTodos()
    // {
    //     try {
    //         $sql = $this->con->conectar()->prepare(
    //             "SELECT id, nome, email, tipo, ativo, created_at
    //              FROM usuarios
    //              ORDER BY nome"
    //         );
    //         $sql->execute();

    //         return $sql->fetchAll(PDO::FETCH_ASSOC);

    //     } catch (PDOException $e) {
    //         return [];
    //     }
    // }

    // public function buscarPorTipo($tipo)
    // {
    //     try {
    //         $sql = $this->con->conectar()->prepare(
    //             "SELECT id, nome, email, tipo, ativo
    //              FROM usuarios
    //              WHERE tipo = :tipo AND ativo = 1
    //              ORDER BY nome"
    //         );
    //         $sql->bindParam(':tipo', $tipo, PDO::PARAM_STR);
    //         $sql->execute();

    //         return $sql->fetchAll(PDO::FETCH_ASSOC);

    //     } catch (PDOException $e) {
    //         return [];
    //     }
    // }

    // public function getTipoPorId($id)
    // {
    //     try {
    //         $sql = $this->con->conectar()->prepare(
    //             "SELECT tipo FROM usuarios WHERE id = :id LIMIT 1"
    //         );
    //         $sql->bindParam(':id', $id, PDO::PARAM_INT);
    //         $sql->execute();

    //         if ($sql->rowCount() > 0) {
    //             $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    //             return $usuario['tipo'];
    //         }

    //         return null;

    //     } catch (PDOException $e) {
    //         return null;
    //     }
    // }
}
