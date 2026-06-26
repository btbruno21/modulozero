<?php
session_start();

require_once 'classes/Mesa.php';
require_once 'classes/Comanda.php';
require_once 'classes/PedidoItem.php';

if (empty($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    header('Location: mesas.php');
    exit();
}

$mesaObj = new Mesa();
$comandaObj = new Comanda();
$pedidoItem = new PedidoItem();

$mesa = $mesaObj->buscarPorId($id);
$mesaObj->ocupar($id);

if (!$mesa) {
    header('Location: mesas.php');
    exit();
}

/*
|--------------------------------------------------------------------------
| Buscar comanda aberta
|--------------------------------------------------------------------------
*/

$comanda = null;

$comandas = $comandaObj->listarPorMesa($id);

foreach ($comandas as $c) {
    if (
        $c['status'] != 'FINALIZADA' &&
        $c['status'] != 'CANCELADA'
    ) {
        $comanda = $c;
        break;
    }
}

/*
|--------------------------------------------------------------------------
| Liberar mesa
|--------------------------------------------------------------------------
*/

if (isset($_GET['liberar'])) {
    if ($comanda) {
        $obj = new Comanda([
            'id' => $comanda['id'],
            'mesa_id' => $comanda['mesa_id']
        ]);
        $obj->finalizar();
    } else {
        $mesaObj->liberar($id);
    }
    header('Location: mesas.php');
    exit();
}

/*
|--------------------------------------------------------------------------
| Itens e Total
|--------------------------------------------------------------------------
*/

$total = 0;
$itens = [];

if ($comanda) {
    $total = $comandaObj->calcularTotal(
        $comanda['id']
    );

    $itens = $pedidoItem->listarPorComanda(
        $comanda['id']
    );
}

if (isset($_GET['cancelar_item'])) {

    $item = new PedidoItem([
        'id' => (int)$_GET['cancelar_item']
    ]);

    $item->cancelar();

    header("Location: mesa.php?id=".$id);
    exit;
}
?>

<!DOCTYPE html>
    <html lang="pt-br">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/mdzero.ico">
    <title>Mesa <?= htmlspecialchars($mesa['numero']) ?></title>
    <style>
        *{
            box-sizing:border-box;
            margin:0;
            padding:0;
        }

        body{
            font-family:Arial,sans-serif;
            background:#f5f5f5;
        }

        .top{
            background:#14402F;
            color:#F5EEDF;
            padding:14px 18px;
            display:flex;
            align-items:center;
            gap:12px;
        }

        .back{
            color:#E9A13B;
            text-decoration:none;
            font-size:1.3rem;
        }

        .top h1{
            flex:1;
            font-size:1.1rem;
        }

        .total{
            font-weight:bold;
            color:#E9A13B;
        }

        .sub{
            padding:12px 18px;
            background:white;
            border-bottom:1px solid #eee;
        }

        .lista{
            padding:16px;
            margin-inline: 20%;
        }

        .item{
            background:white;
            padding:16px;
            margin-bottom:12px;
            border-radius:12px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .item small{
            display:block;
            margin-top:4px;
            color:#777;
        }

        .empty{
            padding:40px;
            text-align:center;
            color:#777;
        }

        .big{
            font-size:2rem;
            margin-bottom:10px;
        }

        .acts{
            display:flex;
            gap:12px;
            padding:6px;
            margin-inline: 40%;
        }

        .btn{
            flex:1;
            padding:16px;
            border-radius:12px;
            text-decoration:none;
            text-align:center;
            font-weight:bold;
        }

        .primary{
            background:#E9A13B;
            color:black;
        }

        .outline{
            background:white;
            border:1px solid #ddd;
            color:black;
        }

        .fechar{
            background:#1F5A3A;
            color:white;
        }

        @media (max-width: 1000px){
            .acts{
                margin-inline: 30%;
            }
        }

        @media (max-width: 768px){
            .lista{
                margin-inline: 0;
            }
        }

        @media (max-width: 480px){
            .acts{
                margin-inline: 20%;
            }
        }

        .valor-acoes{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .trash{
            text-decoration:none;
            font-size:24px;
            transition:transform .2s ease;
            display:inline-block;
        }

        .trash:hover{
            animation:shake .4s ease-in-out;
        }

        @keyframes shake{
            0%,100%{transform:rotate(0deg);}
            25%{transform:rotate(-15deg);}
            50%{transform:rotate(15deg);}
            75%{transform:rotate(-10deg);}
        }

    </style>
</head>

<body>
    <div class="top">
        <a class="back" href="mesas.php">←</a>
        <h1>Mesa <?= htmlspecialchars($mesa['numero']) ?></h1>
        <span class="total">R$ <?= number_format($total,2,',','.') ?></span>
    </div>

    <?php if(empty($itens)): ?>
    <div class="sub">Comanda vazia</div>
        <div class="empty">
            <div class="big">🍺</div>
            <p>Comanda vazia.<br>Toque em <strong>Lançar pedido</strong></p>
        </div>
    <?php else: ?>
    <div class="sub"><?= count($itens) ?> itens</div>
        <div class="lista">
            <?php foreach($itens as $item): ?>
        <div class="item">
        <div>
            <strong>
            <?= $item['quantidade'] ?>x
            <?= htmlspecialchars($item['alimento_nome']) ?>
            </strong>
            <?php if(!empty($item['observacao_livre'])): ?>
            <small><?= htmlspecialchars($item['observacao_livre']) ?></small>
            <?php endif; ?>
        </div>
            <div class="valor-acoes">
                <span>
                    R$<?= number_format($item['quantidade']*$item['preco_unitario'],2,',','.') ?>
                </span>
                <a href="?id=<?= $id ?>&cancelar_item=<?= $item['id'] ?>"
                    class="trash"
                    onclick="return confirm('Remover item?')">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#e74c3c">
                        <path d="M9 3h6l1 2h4v2H4V5h4l1-2zm1 6h2v8h-2V9zm4 0h2v8h-2V9zM7 9h2v8H7V9zm-1 11h12l1-12H5l1 12z"/>
                    </svg>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="acts">
        <a
            href="cardapio.php?mesa_id=<?= $id ?>"
            class="btn primary">
            + Lançar pedido
            </a>
    </div>
    <?php if(empty($itens)):?>
    <div class="acts">
        <a href="?id=<?= $id ?>&liberar=1" class="btn outline" onclick="return confirm('Liberar mesa?')">Liberar mesa</a>
    </div>
    <?php endif;?>

    <?php if(!empty($itens)):?>
    <div class="acts">
        <a class="btn fechar" href="pagamento.php?id=<?= $id ?>" class="btn outline"">Fechar conta</a>
    </div>
    <?php endif;?>
</body>
</html>