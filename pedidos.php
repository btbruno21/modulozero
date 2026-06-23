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

$filtro = $_GET['status'] ?? '';
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

/* TOP */
.top {
    background: #14402F;
    color: #F5EEDF;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.top h1 { font-size: 1.1rem; }
.spacer{ flex:1; }

/* HEADER */
.shead{
    padding:20px 18px 10px;
}

.shead h2{
    color:#14402F;
}

.shead p{
    color:#7A715F;
}

/* FILTROS */
.filtros{
    display:flex;
    gap:8px;
    flex-wrap:wrap;
    margin:10px 18px;
}

.filtro{
    text-decoration:none;
    background:white;
    color:#14402F;
    border:1px solid #ddd;
    padding:8px 12px;
    border-radius:20px;
    font-size:.8rem;
    font-weight:bold;
}

.filtro.ativo{
    background:#14402F;
    color:white;
}

/* CARD */
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

/* ITEM */
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

/* STATUS */
.status{
    padding:10px 16px;
    border-radius:20px;
    font-size:.75rem;
    font-weight:bold;
    align-self:center;
    color:white;
}

.status.FILA{ background:#f39c12; }
.status.PREPARANDO{ background:#3498db; }
.status.PRONTO{ background:#27ae60; }
.status.ENTREGUE{ background:#7f8c8d; }
.status.CANCELADO{ background:#e74c3c; }

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

<!-- FILTROS -->
<div class="filtros">
    <a class="filtro <?= $filtro==='' ? 'ativo' : '' ?>" href="?">TODOS</a>
    <a class="filtro <?= $filtro==='FILA' ? 'ativo' : '' ?>" href="?status=FILA">FILA</a>
    <a class="filtro <?= $filtro==='PREPARANDO' ? 'ativo' : '' ?>" href="?status=PREPARANDO">PREPARANDO</a>
    <a class="filtro <?= $filtro==='PRONTO' ? 'ativo' : '' ?>" href="?status=PRONTO">PRONTO</a>
    <a class="filtro <?= $filtro==='ENTREGUE' ? 'ativo' : '' ?>" href="?status=ENTREGUE">ENTREGUE</a>
    <a class="filtro <?= $filtro==='CANCELADO' ? 'ativo' : '' ?>" href="?status=CANCELADO">CANCELADO</a>
</div>

<?php foreach($pedidos as $p): ?>

<?php
$itens = $item->listarPorPedido($p['id']);

$itensFiltrados = [];

foreach ($itens as $i) {
    if ($filtro && $i['status'] !== $filtro) {
        continue;
    }
    $itensFiltrados[] = $i;
}

// se não tem itens após filtro, não mostra o card
if (count($itensFiltrados) === 0) {
    continue;
}
?>

<div class="card">
    <h3>PEDIDO #<?= $p['id'] ?> • Mesa <?= $p['mesa'] ?></h3>

    <?php foreach($itensFiltrados as $i): ?>

        <div class="item">
            <div class="qtd">
                <?= $i['quantidade'] ?>x
            </div>

            <div class="info">
                <b><?= $i['alimento_nome'] ?></b>

                <?php if(!empty($i['observacao_livre'])): ?>
                    <div class="obs">📝 <?= $i['observacao_livre'] ?></div>
                <?php endif; ?>
            </div>

            <span class="status <?= $i['status'] ?>">
                <?= $i['status'] ?>
            </span>
        </div>

    <?php endforeach; ?>

</div>

<?php endforeach; ?>

<?php include 'inc/footer-func.php'; ?>

</body>
</html>