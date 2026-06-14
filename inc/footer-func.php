<?php
$paginaAtual = basename($_SERVER['PHP_SELF']);
?>

<style>
.footer-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;

    height: 70px;
    background: #14402F;
    border-top: 1px solid rgba(255,255,255,.1);

    display: flex;
    z-index: 999;
}

.footer-nav a {
    flex: 1;

    color: #F5EEDF;
    text-decoration: none;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    gap: 4px;

    font-size: .95rem;
    font-weight: 700;
}

.footer-nav a.active {
    color: #E9A13B;
}

.footer-nav a:hover {
    background: rgba(255,255,255,.05);
}

.footer-nav span {
    font-size: .72rem;
}

body {
    padding-bottom: 80px;
}

.ic {
  font-size: 1.5rem !important;
  line-height: 1;
}
</style>

<footer class="footer-nav">

    <a href="mesas.php"
       class="<?= $paginaAtual === 'mesas.php' ? 'active' : '' ?>">
        <span class="ic">🍽️</span>
        <span>Mesas</span>
    </a>

    <a href="view-cardapio.php"
       class="<?= $paginaAtual === 'view-cardapio.php' ? 'active' : '' ?>">
        <span class="ic">📋</span>
        <span>Cardápio</span>
    </a>

    <a href="pedidos.php"
       class="<?= $paginaAtual === 'pedidos.php' ? 'active' : '' ?>">
        <span class="ic">🔔</span>
        <span>Pedidos</span>
    </a>

</footer>