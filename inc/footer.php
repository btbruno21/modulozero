<footer>
  <div class="container">
    <div class="foot-grid">
      <div class="foot-brand">
        <a href="#inicio" class="logo">
          <svg width="36" height="36" viewBox="0 0 64 64" fill="none" aria-hidden="true">
            <path d="M8 50V20l8-6h10v8H18v28h-8z" fill="#3d8bff"/>
            <path d="M24 14h6l4 4v10h-8V22h-2v-8z" fill="#3d8bff" opacity=".85"/>
            <path d="M44 12 58 20v18L44 46 30 38V20L44 12zm0 9-7 4v10l7 4 7-4V25l-7-4z" fill="#3d8bff"/>
          </svg>
          <span class="logo-text">MÓDULO <em>ZERO</em></span>
        </a>
        <p>Conectamos ideias. Entregamos soluções.</p>
      </div>
      <div class="foot-col">
        <h4>Navegação</h4>
        <ul>
          <li><a href="#solucoes">Soluções</a></li>
          <li><a href="#modulos">Módulos</a></li>
          <li><a href="#sobre">Sobre</a></li>
          <li><a href="#contato">Contato</a></li>
        </ul>
      </div>
      <div class="foot-col">
        <h4>Módulos</h4>
        <ul>
          <li><a href="#modulos">Gestão de Pedidos</a></li>
          <li><a href="#modulos">Estoque Inteligente</a></li>
          <li><a href="#modulos">Financeiro</a></li>
          <li><a href="#modulos">Delivery & CRM</a></li>
        </ul>
      </div>
      <div class="foot-col">
        <h4>Contato</h4>
        <ul>
          <li><a class="ic" href="https://wa.me/5542999999999" target="_blank" rel="noopener"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M21 11.5a8.5 8.5 0 0 1-12.6 7.4L3 21l2.2-5.2A8.5 8.5 0 1 1 21 11.5z"/></svg> WhatsApp</a></li>
          <li><a class="ic" href="mailto:contato@modulozero.com.br"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg> E-mail</a></li>
          <li><a class="ic" href="https://linkedin.com" target="_blank" rel="noopener"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M8 11v6M8 7.5v.01M12 17v-4a2 2 0 0 1 4 0v4"/></svg> LinkedIn</a></li>
          <li><a class="ic" href="https://github.com" target="_blank" rel="noopener"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-1.8c-2.8.6-3.4-1.3-3.4-1.3-.4-1.1-1.1-1.4-1.1-1.4-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.5 2.4 1.1 3 .8.1-.6.3-1.1.6-1.3-2.2-.3-4.6-1.1-4.6-5a3.9 3.9 0 0 1 1-2.7 3.6 3.6 0 0 1 .1-2.7s.9-.3 2.8 1a9.6 9.6 0 0 1 5 0c1.9-1.3 2.8-1 2.8-1a3.6 3.6 0 0 1 .1 2.7 3.9 3.9 0 0 1 1 2.7c0 3.9-2.4 4.7-4.6 5 .4.3.7.9.7 1.8V21c0 .3.2.6.7.5A10 10 0 0 0 12 2z"/></svg> GitHub</a></li>
        </ul>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© 2026 Módulo Zero · Software house nascida no SENAC</span>
      <span class="mono">design system v1.0 · feito com módulos ▰▰▰</span>
    </div>
  </div>
</footer>
<script>
// ---------- header scroll ----------
const header = document.getElementById('header');
const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 24);
window.addEventListener('scroll', onScroll, {passive:true});
onScroll();

// ---------- mobile menu ----------
const toggle = document.getElementById('menuToggle');
const links = document.getElementById('navLinks');
toggle.addEventListener('click', () => {
  const open = links.classList.toggle('open');
  toggle.setAttribute('aria-expanded', open);
});
links.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
  links.classList.remove('open');
  toggle.setAttribute('aria-expanded', 'false');
}));

// ---------- scroll reveal ----------
const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const io = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
  });
}, {threshold:.14, rootMargin:'0px 0px -40px 0px'});
document.querySelectorAll('.reveal').forEach(el => reduced ? el.classList.add('in') : io.observe(el));

// ---------- contadores ----------
const fmtMoney = n => n.toLocaleString('pt-BR');
const animateCount = el => {
  const target = parseFloat(el.dataset.target);
  const decimals = parseInt(el.dataset.decimals || 0);
  const money = el.dataset.format === 'money';
  if (reduced) { el.textContent = money ? fmtMoney(target) : target.toFixed(decimals).replace('.', ','); return; }
  const dur = 1600, t0 = performance.now();
  const tick = now => {
    const p = Math.min((now - t0) / dur, 1);
    const eased = 1 - Math.pow(1 - p, 3);
    const v = target * eased;
    el.textContent = money ? fmtMoney(Math.round(v)) : v.toFixed(decimals).replace('.', ',');
    if (p < 1) requestAnimationFrame(tick);
  };
  requestAnimationFrame(tick);
};
const ioCount = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) { animateCount(e.target); ioCount.unobserve(e.target); }
  });
}, {threshold:.6});
document.querySelectorAll('.count').forEach(el => ioCount.observe(el));

// ---------- spotlight nos cards (segue o mouse) ----------
document.querySelectorAll('.glass-card').forEach(card => {
  card.addEventListener('pointermove', e => {
    const r = card.getBoundingClientRect();
    card.style.setProperty('--mx', (e.clientX - r.left) + 'px');
    card.style.setProperty('--my', (e.clientY - r.top) + 'px');
  });
});

// ---------- partículas do hero ----------
if (!reduced) {
  const wrap = document.getElementById('particles');
  const N = window.innerWidth < 680 ? 14 : 28;
  for (let i = 0; i < N; i++) {
    const p = document.createElement('i');
    p.style.left = Math.random() * 100 + '%';
    p.style.bottom = '-5%';
    p.style.animationDuration = (9 + Math.random() * 14) + 's';
    p.style.animationDelay = (-Math.random() * 18) + 's';
    p.style.opacity = (.2 + Math.random() * .4).toFixed(2);
    const s = (2 + Math.random() * 2.4).toFixed(1);
    p.style.width = s + 'px'; p.style.height = s + 'px';
    wrap.appendChild(p);
  }
}

// ---------- pedidos "ao vivo" no mockup do hero ----------
if (!reduced) {
  const strip = document.querySelector('.orders-strip');
  const states = [['prep','Preparo'],['out','Entrega'],['ok','Concluído']];
  let n = 1043;
  setInterval(() => {
    if (!strip) return;
    const [cls, lbl] = states[Math.floor(Math.random() * states.length)];
    const chip = document.createElement('span');
    chip.className = 'order-chip';
    chip.innerHTML = `<i class="st ${cls}"></i>#${n++} · ${lbl}`;
    chip.style.opacity = '0';
    chip.style.transition = 'opacity .6s';
    strip.prepend(chip);
    requestAnimationFrame(() => chip.style.opacity = '1');
    if (strip.children.length > 4) strip.lastElementChild.remove();
  }, 4200);
}
</script>
</body>
</html>