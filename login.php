<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'classes/Usuario.php';

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Já logado?
if (!empty($_SESSION['id'])) {
    if ($_SESSION['tipo'] === 'ADMIN') {
        header('Location: dashboard.php');
    } else {
        header('Location: mesas.php');
    }
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if ($login === '' || $senha === '') {
        $erro = 'Preencha todos os campos.';
    } else {
        $usuario = new Usuario();
        $dados   = $usuario->autenticar($login, $senha);

        if ($dados) {
            $_SESSION['id']   = $dados['id'];
            $_SESSION['tipo'] = $dados['tipo'];
            $_SESSION['nome'] = $dados['nome'] ?? $login;

            if ($dados['tipo'] === 'ADMIN') {
                header('Location: dashboard.php');
            } else {
                header('Location: mesas.php');
            }
            exit();
        } else {
            $erro = 'Login ou senha incorretos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: Arial, sans-serif;
            background: #14402F;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .box {
            width: 100%;
            max-width: 400px;
            background: #0C2B20;
            border-radius: 20px;
            padding: 40px 32px;
            color: #F5EEDF;
        }

        .logo { text-align: center; margin-bottom: 36px; }
        .logo h1 { font-size: 1.8rem; font-weight: 700; }
        .logo p { font-size: .72rem; letter-spacing: .3em; text-transform: uppercase; color: #E9A13B; margin-top: 6px; }

        .erro {
            background: rgba(192,57,43,.25); border: 1px solid #C0392B;
            border-radius: 8px; padding: 12px; margin-bottom: 16px;
            font-size: .88rem; color: #f5a5a5; text-align: center;
        }

        label {
            display: block; font-size: .78rem; font-weight: 700;
            letter-spacing: .1em; text-transform: uppercase;
            color: rgba(245,238,223,.6); margin-bottom: 6px;
        }
        .field { margin-bottom: 18px; }
        input[type=text], input[type=password] {
            width: 100%; min-height: 52px; border-radius: 12px;
            border: 1px solid rgba(245,238,223,.2); background: rgba(255,255,255,.08);
            color: #F5EEDF; padding: 0 16px; font-size: 1rem; font-family: inherit;
        }
        input::placeholder { color: rgba(245,238,223,.3); }

        .btn {
            width: 100%; min-height: 54px; border-radius: 12px;
            background: #E9A13B; color: #19140F;
            font-weight: 800; font-size: 1rem; border: none;
            cursor: pointer; font-family: inherit; margin-top: 8px;
        }
        .btn:hover { background: #C77F1E; }
    </style>
</head>
<body>

<div class="box">
    <div class="logo">
        <h1>Módulo Zero</h1>
        <p>Sistema de Gestão</p>
    </div>

    <?php if ($erro): ?>
        <div class="erro"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="field">
            <label for="login">Login</label>
            <input type="text" id="login" name="login"
                   value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                   placeholder="Seu usuário" required autofocus>
        </div>

        <div class="field">
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" placeholder="••••••" required>
        </div>

        <button type="submit" class="btn">Entrar</button>
    </form>
</div>

</body>
</html>
