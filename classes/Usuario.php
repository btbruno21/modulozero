<?php
require_once __DIR__ . '/Conexao.php';

class Usuario
{
    private $id;
    private $nome;
    private $login;
    private $senha;
    private $tipo; // ADMIN, GARCOM, CAIXA
    private $ativo;
    private $criadoEm;
    private $pdo;

    public function __construct(array $dados = [])
    {
        $conexao = new Conexao();
        $this->pdo = $conexao->conectar();

        if (!empty($dados)) {
            $this->id       = $dados['id'] ?? null;
            $this->nome     = $dados['nome'] ?? null;
            $this->login    = $dados['login'] ?? null;
            $this->senha    = $dados['senha'] ?? null;
            $this->tipo     = $dados['tipo'] ?? null;
            $this->ativo    = $dados['ativo'] ?? true;
            $this->criadoEm = $dados['criado_em'] ?? null;
        }
    }

    // ------------------- Getters -------------------
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getLogin() { return $this->login; }
    public function getTipo() { return $this->tipo; }
    public function getAtivo() { return $this->ativo; }
    public function getCriadoEm() { return $this->criadoEm; }

    // ------------------- Setters -------------------
    public function setNome($nome) { $this->nome = $nome; }
    public function setLogin($login) { $this->login = $login; }
    public function setSenha($senha) { $this->senha = $senha; }
    public function setTipo($tipo) { $this->tipo = $tipo; }
    public function setAtivo($ativo) { $this->ativo = $ativo; }

    // ------------------- CRUD -------------------

    public function salvar()
    {
        $senhaHash = password_hash($this->senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuario (nome, login, senha, tipo, ativo)
                VALUES (:nome, :login, :senha, :tipo, :ativo)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':login', $this->login);
        $stmt->bindValue(':senha', $senhaHash);
        $stmt->bindValue(':tipo', $this->tipo);
        $stmt->bindValue(':ativo', $this->ativo ?? true, PDO::PARAM_BOOL);

        $stmt->execute();
        $this->id = $this->pdo->lastInsertId();

        return $this->id;
    }

    public function atualizar()
    {
        $sql = "UPDATE usuario
                SET nome = :nome, login = :login, tipo = :tipo, ativo = :ativo
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':login', $this->login);
        $stmt->bindValue(':tipo', $this->tipo);
        $stmt->bindValue(':ativo', $this->ativo, PDO::PARAM_BOOL);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function alterarSenha($novaSenha)
    {
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

        $sql = "UPDATE usuario SET senha = :senha WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':senha', $senhaHash);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function inativar()
    {
        $sql = "UPDATE usuario SET ativo = 0 WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM usuario WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarPorLogin($login)
    {
        $sql = "SELECT * FROM usuario WHERE login = :login";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':login', $login);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Valida login e senha. Retorna os dados do usuário se autenticado, ou false.
     */
    public function autenticar($login, $senha)
    {
        $usuario = $this->buscarPorLogin($login);

        if ($usuario && password_verify($senha, $usuario['senha']) && $usuario['ativo']) {
            return $usuario;
        }

        return false;
    }

    public function listarTodos($apenasAtivos = true)
    {
        $sql = "SELECT * FROM usuario";
        if ($apenasAtivos) {
            $sql .= " WHERE ativo = 1";
        }
        $sql .= " ORDER BY nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
