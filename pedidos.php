<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require_once 'classes/Pedido.php';
require_once 'classes/PedidoItem.php';

if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$pedido = new Pedido();
$item = new PedidoItem();

$pedidos = $pedido->listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<title>Pedidos</title>
<meta charset="UTF-8">

<style>
    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }

    body{
        font-family:Arial;
        background:#f5f5f5;
    }

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

    .spacer{
        flex:1;
    }

    .btn-sair{
        color:#F5EEDF;
        text-decoration:none;
        padding:8px 14px;
        border-radius:8px;
        border:1px solid #E9A13B;
    }

    .shead{
        padding:20px 18px 10px;
    }

    .shead h2{
        color:#14402F;
    }

    .shead p{
        color:#7A715F;
    }


    .card{
        background:white;
        margin:16px;
        padding:18px;
        border-radius:14px;
        box-shadow:0 3px 12px rgba(0,0,0,.08);
    }

    .card h3{
        color:#7A715F;
        font-size:.8rem;
        margin-bottom:15px;
    }

    .item{
        display:flex;
        gap:10px;
        padding:10px 0;
        border-bottom:1px dashed #ddd;
    }

    .qtd{
        background:#eee;
        min-width:35px;
        height:35px;
        border-radius:8px;
        display:flex;
        justify-content:center;
        align-items:center;
        font-weight:bold;
    }

    .info{
        flex:1;
    }

    .obs{
        color:#7A715F;
        font-size:.8rem;
        margin-top:4px;
    }

    .status{
        background:#E9A13B;
        padding: 10px 16px;
        border-radius:20px;
        font-size:.75rem;
        font-weight:bold;
        align-self:center;
    }
</style>
</head>
<body>
    <div class="top">
        <h1>Botequim · Pedidos</h1>
        <div class="spacer"></div>
    </div>

    <div class="shead">
        <h2>Fila de preparo</h2>
        <p><?= count($pedidos) ?> pedido(s)</p>
    </div>
    <?php foreach($pedidos as $p): ?>
        <div class="card">
            <h3>PEDIDO #<?= $p['id'] ?> • Mesa <?= $p['mesa'] ?></h3>
        <?php
        $itens = $item->listarPorPedido($p['id']);
        foreach($itens as $i):
        ?>
        <div class="item">
            <div class="qtd">
            <?= $i['quantidade'] ?>x
            </div>
            <div class="info">
                <b><?= $i['alimento_nome'] ?></b>
                <?php if($i['observacao_livre']): ?>
                <div class="obs">📝<?= $i['observacao_livre'] ?></div>
                <?php endif; ?>
            </div>
            <span class="status"><?= $i['status'] ?></span>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
    <?php include 'inc/footer-func.php'; ?>
</body>
</html>