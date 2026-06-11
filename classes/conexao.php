<?php
require_once __DIR__ . '/../env.php';

loadEnv(__DIR__ . '/../.env');

class Conexao
{
    private $usuario;
    private $senha;
    private $banco;
    private $servidor;
    private $port;

    private static $pdo;

    public function __construct()
    {
        $this->servidor = getenv('DB_HOST');
        $this->banco = getenv('DB_NAME');
        $this->usuario = getenv('DB_USER');
        $this->senha = getenv('DB_PASS');
        $this->port = getenv('DB_PORT');
    }

    public function conectar()
    {
        try {
            if (is_null(self::$pdo)) {
                self::$pdo = new PDO("mysql:host=" . $this->servidor . ";port=" . $this->port . ";dbname=" . $this->banco, $this->usuario, $this->senha);
            }
            // echo "Conectou!!";
            return self::$pdo;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
}
