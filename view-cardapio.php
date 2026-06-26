<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'classes/Alimento.php';
require_once 'classes/Categoria.php';

$cat_id     = (int) ($_GET['cat_id']     ?? 0);
$busca      = trim($_GET['busca'] ?? '');

$produtoObj   = new Alimento();
$categoriaObj = new Categoria();

$categorias = $categoriaObj->listarTodos();

if ($cat_id) {
    $produtos = $produtoObj->listarPorCategoria($cat_id);
} else {
    $produtos = $produtoObj->buscarAtivos();
}

if ($busca !== '') {
    $produtos = array_filter($produtos, fn($p) => stripos($p['nome'], $busca) !== false);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Cardápio · Visualização</title>
    <link rel="icon" type="image/x-icon" href="img/mdzero.ico">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; padding-bottom: 24px; }

        .top {
            background: #14402F; color: #F5EEDF;
            padding: 14px 18px; display: flex; align-items: center; gap: 12px;
        }
        .top a.back { color: #E9A13B; text-decoration: none; font-size: 1.3rem; }
        .top h1 { font-size: 1.1rem; flex: 1; }
        .top small { font-size: .8rem; opacity: .7; }

        .search { margin: 14px 18px 4px; }
        .search form { display: flex; gap: 8px; }
        .search input {
            flex: 1; min-height: 48px; border-radius: 12px;
            border: 1px solid rgba(0,0,0,.14); background: #fff;
            padding: 0 16px; font-size: 1rem; font-family: inherit;
        }
        .search button {
            min-height: 48px;
            padding: 0px 16px;
            border-radius: 12px;
            background: #14402F;
            color: #F5EEDF;
            border: none;
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
        }

        .cats {
            display: flex; gap: 10px; overflow-x: auto;
            padding: 12px 18px; scrollbar-width: none;
        }
        .cats::-webkit-scrollbar { display: none; }
        .cat {
            white-space: nowrap; padding: 10px 18px; border-radius: 999px;
            background: #fff; border: 1px solid rgba(0,0,0,.12);
            font-weight: 700; font-size: .86rem; text-decoration: none; color: inherit;
            min-height: 44px; display: inline-flex; align-items: center;
        }
        .cat.active { background: #14402F; color: #F5EEDF; border-color: #14402F; }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 14px;
            padding: 6px 18px 24px;
        }

        .card {
            background: #fff; border-radius: 12px; padding: 16px;
            border: 1px solid #ddd; display: flex; flex-direction: column; gap: 8px;
        }
        .card .nome { font-size: 1rem; font-weight: 700; }
        .card .desc { font-size: .82rem; color: #7A715F; line-height: 1.4; min-height: 36px; }
        .card .cat-tag { font-size: .7rem; color: #E9A13B; font-weight: 800; text-transform: uppercase; letter-spacing: .05em; }
        .card .preco { font-size: 1.25rem; font-weight: 800; color: #14402F; margin-top: 4px; }

        .btn-add {
            display: block; width: 100%; min-height: 48px; border-radius: 10px;
            background: #d4edda; border: 1px solid #b8d8be; color: #000;
            font-weight: 700; font-size: .95rem; text-align: center;
            text-decoration: none; display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-family: inherit;
        }
        .btn-add:hover { background: #c3e6cb; }

        .empty { text-align: center; padding: 40px 18px; color: #7A715F; }
        .lupa {
            width: 20px;
        }
    </style>
</head>
<body>

<div class="top">
    <h1>Cardápio</h1>
</div>

<div class="search">
    <form method="GET" action="">
        <input type="search" name="busca" placeholder="Buscar item…" value="<?= htmlspecialchars($busca) ?>">
        <button type="submit"><img class="lupa" src="./img/lupa.png"></button>
    </form>
</div>

<div class="cats">
    <a
        href="view-cardapio.php"
        class="cat <?= !$cat_id ? 'active' : '' ?>"
    >Tudo</a>
    <?php foreach ($categorias as $cat): ?>
        <a
            href="?cat_id=<?= $cat['id'] ?>"
            class="cat <?= $cat_id === (int)$cat['id'] ? 'active' : '' ?>"
        ><?= htmlspecialchars($cat['nome']) ?></a>
    <?php endforeach; ?>
</div>

<div class="grid">
    <?php if (empty($produtos)): ?>
        <div class="empty" style="grid-column:1/-1">
            <p>Nenhum produto encontrado.</p>
        </div>
    <?php else: ?>
        <?php foreach ($produtos as $p): ?>
            <div class="card">
                <div class="cat-tag"><?= htmlspecialchars($p['categoria_nome'] ?? '') ?></div>
                <div class="nome"><?= htmlspecialchars($p['nome']) ?></div>
                <?php if (!empty($p['descricao'])): ?>
                    <div class="desc"><?= htmlspecialchars($p['descricao']) ?></div>
                <?php endif; ?>
                <div class="preco">R$ <?= number_format($p['preco'], 2, ',', '.') ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'inc/footer-func.php'; ?>
</body>
</html>