<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'classes/conexao.php';
// require_once 'classes/models.php';
// require_once 'classes/enums.php';
require_once 'classes/usuario.php';

use Database\Connection;
use PDO;

//$a = Connection::getInstance();
$usuario = new Usuario;
$a = $usuario->criar('bruno', 'bruno@email.com', '1234', 'ADMIN');
var_dump($a);