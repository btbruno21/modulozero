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
$item   = new PedidoItem();
$pedidos = $pedido->listarTodos();
$filtro  = $_GET['status'] ?? '';
$busca   = trim($_GET['q'] ?? '');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pedidos · Botequim</title>
<link rel="icon" type="image/x-icon" href="img/mdzero.ico">
<style>
/* ── reset & base ── */
*, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

:root {
    --verde:   #14402F;
    --verde2:  #1d5c44;
    --creme:   #F5EEDF;
    --cinza:   #7A715F;
    --bg:      #f0ede8;
    --branco:  #ffffff;
    --radius:  14px;
    --shadow:  0 2px 10px rgba(0,0,0,.09);
}

body {
    font-family: 'Segoe UI', Arial, sans-serif;
    background: var(--bg);
    color: #222;
    min-height: 100vh;
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

/* ── search bar ── */
.search-wrap {
    display: flex;
    align-items: center;
    background: var(--verde2);
    border-radius: 12px;
    padding: 0 14px;
    gap: 10px;
}

.search-wrap input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: var(--creme);
    font-size: .95rem;
    padding: 13px 0;
}

.search-wrap input::placeholder { color: rgba(245,238,223,.45); }

.search-wrap button {
    background: var(--verde);
    border: none;
    border-radius: 9px;
    width: 36px;
    height: 36px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background .15s;
}

.search-wrap button:hover { background: #0d2d20; }

.search-wrap button svg { width: 16px; height: 16px; fill: var(--creme); }

/* ── chips / filtros ── */
.chips-row {
    display: flex;
    gap: 8px;
    overflow-x: auto;
    padding: 16px 20px 20px;
    scrollbar-width: none;
}
.chips-row::-webkit-scrollbar { display: none; }

.chip {
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    padding: 8px 18px;
    border-radius: 999px;
    font-size: .78rem;
    font-weight: 700;
    letter-spacing: .03em;
    white-space: nowrap;
    background: var(--branco);
    color: var(--verde);
    border: 1.5px solid transparent;
    box-shadow: var(--shadow);
    transition: background .15s, color .15s, box-shadow .15s;
}
.chip:hover { box-shadow: 0 4px 14px rgba(0,0,0,.13); }
.chip.ativo  { background: var(--verde); color: var(--creme); }

/* ── section header ── */
.sec-head {
    padding: 18px 20px 6px;
    display: flex;
    align-items: baseline;
    gap: 8px;
}
.sec-head h2 { font-size: 1.05rem; color: var(--verde); font-weight: 700; }
.sec-head span { font-size: .8rem; color: var(--cinza); }

/* ── cards ── */
.cards { padding: 6px 16px 20px; display: flex; flex-direction: column; gap: 12px; max-width: 860px; margin: 0 auto; }

.card {
    background: var(--branco);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.card-head {
    padding: 13px 18px;
    border-bottom: 1px solid #ede9e1;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-head .badge-mesa {
    background: var(--verde);
    color: var(--creme);
    font-size: .72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 999px;
    letter-spacing: .04em;
}

.card-head .pedido-num {
    font-size: .78rem;
    color: var(--cinza);
    font-weight: 600;
}

/* ── itens ── */
.item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 13px 18px;
    border-bottom: 1px dashed #ede9e1;
    transition: background .1s;
}
.item:last-child { border-bottom: none; }
.item:hover { background: #faf8f4; }

.qtd {
    background: #ede9e1;
    min-width: 38px;
    height: 38px;
    border-radius: 9px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .85rem;
    font-weight: 700;
    color: var(--verde);
    flex-shrink: 0;
}

.info { flex: 1; min-width: 0; }
.info strong { display: block; font-size: .9rem; font-weight: 700; color: #1a1a1a; }
.obs { font-size: .75rem; color: var(--cinza); margin-top: 3px; }

.status {
    padding: 5px 13px;
    border-radius: 999px;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .04em;
    color: #fff;
    white-space: nowrap;
    flex-shrink: 0;
}
.status.FILA       { background: #e67e22; }
.status.PREPARANDO { background: #2980b9; }
.status.PRONTO     { background: #27ae60; }
.status.ENTREGUE   { background: #7f8c8d; }
.status.CANCELADO  { background: #c0392b; }

/* ── empty state ── */
.empty {
    text-align: center;
    padding: 48px 20px;
    color: var(--cinza);
}
.empty svg { opacity: .3; margin-bottom: 12px; }
.empty p { font-size: .9rem; }

/* ── responsive ── */
@media (max-width: 480px) {
    .cards { padding: 6px 10px 20px; }
    .item { flex-wrap: wrap; }
    .status { margin-left: 52px; }
}
</style>
</head>
<body>

<!-- Header com busca -->
<div class="top">
    <h1>Botequim · Pedidos</h1>
    <div class="spacer"></div>
</div>

<?php
// Monta lista filtrada
$visibles = [];
foreach ($pedidos as $p) {
    $itens = $item->listarPorPedido($p['id']);
    $fil = [];
    foreach ($itens as $i) {
        if ($filtro && $i['status'] !== $filtro) continue;
        if ($busca && stripos($i['alimento_nome'], $busca) === false) continue;
        $fil[] = $i;
    }
    if ($fil) $visibles[] = ['pedido' => $p, 'itens' => $fil];
}
?>

<!-- Section header -->
<div class="sec-head">
    <h2>Fila de preparo</h2>
    <span><?= count($visibles) ?> pedido(s)</span>
</div>

<!-- Chips de filtro -->
<div class="chips-row">
<?php
$labels = [
    ''          => 'Tudo',
    'FILA'      => 'Fila',
    'PREPARANDO'=> 'Preparando',
    'PRONTO'    => 'Pronto',
    'ENTREGUE'  => 'Entregue',
    'CANCELADO' => 'Cancelado',
];
foreach ($labels as $k => $v):
    $href = $k === '' ? '?' : '?status=' . $k;
    if ($busca) $href .= '&q=' . urlencode($busca);
    $ativo = $filtro === $k ? 'ativo' : '';
?>
    <a class="chip <?= $ativo ?>" href="<?= $href ?>"><?= $v ?></a>
<?php endforeach; ?>
</div>

<div class="cards">
<?php if (empty($visibles)): ?>
    <div class="empty">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#7A715F" stroke-width="1.5">
            <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
            <rect x="9" y="3" width="6" height="4" rx="1"/>
        </svg>
        <p>Nenhum pedido encontrado.</p>
    </div>
<?php else: ?>
    <?php foreach ($visibles as $v): $p = $v['pedido']; ?>
    <div class="card">
        <div class="card-head">
            <span class="badge-mesa">Mesa <?= htmlspecialchars($p['mesa']) ?></span>
            <span class="pedido-num">Pedido #<?= $p['id'] ?></span>
        </div>
        <?php foreach ($v['itens'] as $i): ?>
        <div class="item">
            <div class="qtd"><?= (int)$i['quantidade'] ?>x</div>
            <div class="info">
                <strong><?= htmlspecialchars($i['alimento_nome']) ?></strong>
                <?php if (!empty($i['observacao_livre'])): ?>
                    <div class="obs">📝 <?= htmlspecialchars($i['observacao_livre']) ?></div>
                <?php endif; ?>
            </div>
            <span class="status <?= htmlspecialchars($i['status']) ?>"><?= htmlspecialchars($i['status']) ?></span>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<?php include 'inc/footer-func.php'; ?>
</body>
</html>