<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'classes/Alimento.php';
require_once 'classes/PedidoItem.php';
require_once 'classes/Pedido.php';
require_once 'classes/Observacao.php';

if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$mesa_id    = (int) ($_GET['mesa_id']    ?? $_POST['mesa_id']    ?? 0);
$comanda_id = (int) ($_GET['comanda_id'] ?? $_POST['comanda_id'] ?? 0);
$produto_id = (int) ($_GET['produto_id'] ?? $_POST['produto_id'] ?? 0);

if (!$mesa_id || !$comanda_id || !$produto_id) {
    header('Location: mesas.php');
    exit();
}

$produtoObj = new Alimento();
$produto    = $produtoObj->buscarPorId($produto_id);

if (!$produto || !$produto['ativo']) {
    header("Location: cardapio.php?mesa_id=$mesa_id&comanda_id=$comanda_id");
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $quantidade = max(1, (int)($_POST['quantidade'] ?? 1));
    $observacao = trim($_POST['observacao'] ?? '');
    try {
        $pedido = new Pedido();
        $pedido->setComandaId($comanda_id);
        $pedido->setUsuarioId($_SESSION['id']);

        $pedidoId = $pedido->salvar();

        $item = new PedidoItem();

        $item->setPedidoId($pedidoId);
        $item->setAlimentoId($produto_id);
        $item->setQuantidade($quantidade);
        $item->setPrecoUnitario($produto['preco']);
        $item->setObservacaoLivre(
            !empty($observacao)
                ? $observacao
                : null
        );
        $itemId = $item->salvar();
        if ($itemId) {
            header("Location: mesa.php?id=$mesa_id");
            exit();
        }
        $erro = 'Erro ao registrar pedido.';
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

$Observacao = new Observacao;
$objObservacao = $Observacao->observacaoAlimento($produto_id);

$OBS_RAPIDAS = array_column($objObservacao, 'descricao');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Adicionar · <?= htmlspecialchars($produto['nome']) ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }

        .top {
            background: #14402F; color: #F5EEDF;
            padding: 14px 18px; display: flex; align-items: center; gap: 12px;
        }
        .top a.back { color: #E9A13B; text-decoration: none; font-size: 1.3rem; }
        .top h1 { font-size: 1.1rem; }

        .sheet {
            max-width: 560px; margin: 24px auto;
            background: #fff; border-radius: 16px; padding: 24px;
            border: 1px solid #ddd;
        }
        .sheet h2 { font-size: 1.2rem; color: #14402F; margin-bottom: 4px; }
        .sheet .preco { font-weight: 800; color: #C77F1E; font-size: 1.05rem; margin-bottom: 20px; }

        .erro { background: #f8d7da; color: #721c24; border-radius: 8px; padding: 12px; margin-bottom: 16px; }

        label {
            display: block; font-size: .78rem; font-weight: 800;
            letter-spacing: .1em; text-transform: uppercase; color: #7A715F;
            margin: 14px 0 8px;
        }

        .qty-ctrl { display: flex; align-items: center; gap: 20px; }
        .qty-ctrl button {
            width: 56px; height: 56px; border-radius: 14px;
            background: #f5f5f5; border: 1px solid #ddd;
            font-size: 1.5rem; font-weight: 800; cursor: pointer; font-family: inherit;
        }
        .qty-ctrl .v { font-size: 1.8rem; font-weight: 700; min-width: 50px; text-align: center; }

        .chips { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 4px; }
        .chips label {
            margin: 0; text-transform: none; letter-spacing: 0;
            font-size: .85rem; font-weight: 600;
            display: flex; align-items: center; gap: 6px;
            background: #f0ede6; padding: 8px 14px; border-radius: 999px;
            cursor: pointer;
        }
        .chips input[type=checkbox] { display: none; }
        .chips input[type=checkbox]:checked + span {
            /* handled by wrapping label background — override via JS or use :has */
        }
        .chip-label { background: #f0ede6; padding: 8px 14px; border-radius: 999px; cursor: pointer; font-size: .85rem; font-weight: 600; border: 1px solid transparent; }
        .chip-label:has(input:checked) { background: #14402F; color: #F5EEDF; }

        textarea {
            width: 100%; border-radius: 12px;
            border: 1px solid rgba(0,0,0,.14); background: #fff;
            padding: 14px; font-family: inherit; font-size: .95rem;
            min-height: 80px; resize: vertical; margin-top: 4px;
        }

        .acts { display: flex; gap: 12px; margin-top: 20px; }
        .btn {
            flex: 1; min-height: 56px; border-radius: 12px; font-weight: 800; font-size: 1rem;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none; border: none; cursor: pointer; font-family: inherit;
        }
        .btn.primary { background: #E9A13B; color: #19140F; }
        .btn.outline { background: #fff; border: 2px solid rgba(0,0,0,.15); color: #19140F; }
    </style>
</head>
<body>

<div class="top">
    <a class="back" href="cardapio.php?mesa_id=<?= $mesa_id ?>&comanda_id=<?= $comanda_id ?>">←</a>
    <h1>Adicionar item</h1>
</div>

<form method="POST" action="">
    <input type="hidden" name="mesa_id"    value="<?= $mesa_id ?>">
    <input type="hidden" name="comanda_id" value="<?= $comanda_id ?>">
    <input type="hidden" name="produto_id" value="<?= $produto_id ?>">

    <div class="sheet">

        <?php if ($erro): ?>
            <div class="erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <h2><?= htmlspecialchars($produto['nome']) ?></h2>
        <div class="preco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
            <?php if (!empty($produto['categoria_nome'])): ?>
                · <?= htmlspecialchars($produto['categoria_nome']) ?>
            <?php endif; ?>
        </div>

        <label>Quantidade</label>
        <div class="qty-ctrl">
            <button type="button" onclick="changeQty(-1)">−</button>
            <span class="v" id="qtyDisplay">1</span>
            <button type="button" onclick="changeQty(1)">＋</button>
        </div>
        <input type="hidden" name="quantidade" id="qtyInput" value="1">
        
        <!-- <div class="chips">
            <label class="chip-label">Adicionar Observações</label>
        </div> -->
        <?php if(!empty($OBS_RAPIDAS)):?>
        <label>Observações rápidas</label>
        <div class="chips">
            <?php foreach ($OBS_RAPIDAS as $obs): ?>
                <label class="chip-label">
                    <input type="checkbox" name="obs_rapidas[]" value="<?= htmlspecialchars($obs) ?>">
                    <?= htmlspecialchars($obs) ?>
                </label>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <label>Observação livre</label>
        <textarea name="obs_livre" placeholder="Ex.: metade sem pimenta…"></textarea>

        <div class="acts">
            <a
                href="cardapio.php?mesa_id=<?= $mesa_id ?>&comanda_id=<?= $comanda_id ?>"
                class="btn outline"
            >Cancelar</a>
            <button type="submit" class="btn primary" id="btnAdd">
                Adicionar
            </button>
        </div>

    </div>
</form>

<script>
let qty = 1;
const preco = <?= (float)$produto['preco'] ?>;

function changeQty(d) {
    qty = Math.max(1, qty + d);
    document.getElementById('qtyDisplay').textContent = qty;
    document.getElementById('qtyInput').value = qty;
    document.getElementById('btnAdd').textContent =
        'Adicionar · R$ ' + (qty * preco).toLocaleString('pt-BR', {minimumFractionDigits:2});
}
changeQty(0); // init label

// Merge obs_rapidas checkboxes into observacao on submit
document.querySelector('form').addEventListener('submit', function() {
    const checked = [...document.querySelectorAll('input[name="obs_rapidas[]"]:checked')]
        .map(el => el.value);
    const livre = document.querySelector('textarea[name="obs_livre"]').value.trim();
    const final = [...checked, livre].filter(Boolean).join(' · ');
    // inject merged value
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'observacao';
    hidden.value = final;
    this.appendChild(hidden);
});
</script>

</body>
</html>