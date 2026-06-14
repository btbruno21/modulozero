<?php
session_start();

require_once 'classes/Mesa.php';
require_once 'classes/Comanda.php';

if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$id = (int) ($_GET['id'] ?? 0);

if (!$id) {
    header('Location: mesas.php');
    exit();
}

$mesaObj = new Mesa();
$comandaObj = new Comanda();
$mesaObj->ocupar($id);

$mesa = $mesaObj->buscarPorId($id);

if (!$mesa) {
    header('Location: mesas.php');
    exit();
}
/*
|--------------------------------------------------------------------------
| Buscar comanda aberta da mesa
|--------------------------------------------------------------------------
*/
$comanda = null;
$comandas = $comandaObj->listarPorMesa($id);
foreach ($comandas as $c) {
    if (
        $c['status'] !== 'FINALIZADA' &&
        $c['status'] !== 'CANCELADA'
    ) {
        $comanda = $c;
        break;
    }
}
/*
|--------------------------------------------------------------------------
| Liberar mesa sem consumo
|--------------------------------------------------------------------------
*/
if (isset($_GET['liberar'])) {

    if ($comanda) {

        $comandaObj = new Comanda([
            'id'      => $comanda['id'],
            'mesa_id' => $comanda['mesa_id']
        ]);

        $comandaObj->finalizar();

    } else {

        $mesaObj->liberar($id);
    }

    header('Location: mesas.php');
    exit();
}

$total = 0;

if ($comanda) {
    $total = $comandaObj->calcularTotal($comanda['id']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesa <?= htmlspecialchars($mesa['numero']) ?></title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding-bottom: 100px;
        }

        .top {
            background: #14402F;
            color: #F5EEDF;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .top a.back {
            color: #E9A13B;
            text-decoration: none;
            font-size: 1.3rem;
        }

        .top h1 {
            font-size: 1.1rem;
            flex: 1;
        }

        .top .total {
            font-size: 1rem;
            font-weight: 700;
            color: #E9A13B;
        }

        .sub {
            padding: 12px 18px;
            background: #fff;
            border-bottom: 1px solid #eee;
            font-size: .8rem;
            color: #7A715F;
        }

        .empty {
            text-align: center;
            padding: 40px 18px;
            color: #7A715F;
        }

        .empty .big {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .acts {
            display: flex;
            gap: 12px;
            padding: 0 18px;
            margin-top: 14px;
        }

        .btn {
            flex: 1;
            min-height: 56px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        .btn.primary {
            background: #E9A13B;
            color: #19140F;
        }

        .btn.outline {
            background: #fff;
            border: 2px solid rgba(0,0,0,.15);
            color: #19140F;
        }
    </style>
</head>
<body>
<div class="top">
    <a class="back" href="mesas.php">←</a>
    <h1>Mesa <?= htmlspecialchars($mesa['numero']) ?></h1>
    <span class="total">
        R$ 0,00
    </span>
</div>

<div class="sub">
    Comanda vazia
</div>

<div class="empty">
    <div class="big">🍺</div>
    <p>
        Comanda vazia.<br>
        Toque em <strong>Lançar pedido</strong> para abrir o cardápio.
    </p>
</div>

<div class="acts">
    <a
        href="cardapio.php?mesa_id=<?= $id ?>"
        class="btn primary"
    >
        + Lançar pedido
    </a>
</div>

<div class="acts" style="margin-top:12px;">
    <a
        href="?id=<?= $id ?>&liberar=1"
        class="btn outline"
        onclick="return confirm('Liberar mesa sem consumo?')"
    >
        Liberar mesa (sem consumo)
    </a>
</div>

</body>
</html>