<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'classes/Mesa.php';

// Autenticação básica
if (empty($_SESSION['id']) || empty($_SESSION['tipo'])) {
    header('Location: login.php');
    exit();
}

$mesa = new Mesa();
$mesas = $mesa->listarTodas();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Mesas</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }

        .top {
            background: #14402F;
            color: #F5EEDF;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .top h1 { font-size: 1.1rem; }
        .top .spacer { flex: 1; }
        .top .garcom { font-size: .85rem; opacity: .8; }
        .top a { color: #E9A13B; font-size: .8rem; }

        .shead { padding: 20px 18px 10px; }
        .shead h2 { font-size: 1.3rem; color: #14402F; margin-bottom: 4px; }
        .shead p { font-size: .8rem; color: #7A715F; }

        .legend { display: flex; gap: 14px; padding: 0 18px 12px; font-size: .72rem; color: #7A715F; flex-wrap: wrap; }
        .legend i { display: inline-block; width: 10px; height: 10px; border-radius: 3px; margin-right: 5px; vertical-align: -1px; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
            /* padding: 6px 18px 24px; */
            padding: 6px 18px 10px 18px;
        }

        .mesa {
            aspect-ratio: 1/1;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 4px;
            text-decoration: none;
            border: 2px solid transparent;
            transition: transform .12s;
        }
        .mesa:active { transform: scale(.95); }
        .mesa .n { font-size: 2rem; font-weight: 700; }
        .mesa .st { font-size: .75rem; letter-spacing: .08em; text-transform: uppercase; font-weight: 800; }

        .mesa.LIVRE    { background: #fff; color: #7A715F; border-color: rgba(0,0,0,.1); }
        .mesa.LIVRE .st { color: #2E8B57; }
        .mesa.OCUPADA  { background: #14402F; color: #F5EEDF; }
        .mesa.OCUPADA .st { color: #E9A13B; }
        .mesa.RESERVADA { background: #fff3cd; color: #555; border-color: #ffc107; }
    </style>
</head>
<body>

<div class="top">
    <h1>Botequim · Mesas</h1>
    <div class="spacer"></div>
    <span class="garcom">Garçom: <strong><?= htmlspecialchars($_SESSION['nome'] ?? 'Usuário') ?></strong></span>
    <a href="login.php?logout=1">Sair</a>
</div>

<div class="shead">
    <h2>Mapa do salão</h2>
    <p>
        <?= count(array_filter($mesas, fn($m) => $m['status'] === 'OCUPADA')) ?> mesa(s) ocupada(s)
        · toque para abrir a comanda
    </p>
</div>

<div class="legend">
    <span><i style="background:#fff;border:1px solid #ccc"></i>Livre</span>
    <span><i style="background:#14402F"></i>Ocupada</span>
    <span><i style="background:#fff3cd;border:1px solid #ffc107"></i>Reservada</span>
</div>

<div class="grid">
    <?php foreach ($mesas as $m): ?>
        <a
            href="mesa.php?id=<?= $m['id'] ?>"
            class="mesa <?= htmlspecialchars($m['status']) ?>"
        >
            <span class="n"><?= $m['numero'] ?></span>
            <span class="st"><?= htmlspecialchars($m['status']) ?></span>
            <!-- <span class="st">MESA</span> -->
        </a>
    <?php endforeach; ?>
</div>

<?php include 'inc/footer-func.php'; ?>
</body>
</html>