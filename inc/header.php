<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Módulo Zero — Sistemas modulares para gestão de restaurantes</title>
<meta name="description" content="A Módulo Zero centraliza pedidos, estoque, financeiro, delivery e indicadores estratégicos em uma única plataforma modular e escalável.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{
  --blue:#0057D9;
  --blue-2:#0A2E8A;
  --navy:#04143A;
  --navy-deep:#020A22;
  --white:#FFFFFF;
  --grey-light:#F8FAFC;
  --grey-tech:#CBD5E1;
  --grey-mid:#8DA2C0;
  --glass:rgba(255,255,255,.045);
  --glass-border:rgba(139,177,255,.14);
  --radius:18px;
  --font-display:'Space Grotesk',sans-serif;
  --font-body:'Inter',sans-serif;
  --font-mono:'JetBrains Mono',monospace;
  --shadow-glow:0 0 60px rgba(0,87,217,.35);
  --maxw:1180px;
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{
  font-family:var(--font-body);
  background:var(--navy-deep);
  color:var(--white);
  line-height:1.65;
  overflow-x:hidden;
  -webkit-font-smoothing:antialiased;
}
::selection{background:var(--blue);color:#fff}
img,svg{display:block;max-width:100%}
a{color:inherit;text-decoration:none}
ul{list-style:none}
button{font-family:inherit;cursor:pointer;border:none}

.container{max-width:var(--maxw);margin:0 auto;padding:0 28px}

/* ---------- typography ---------- */
h1,h2,h3{font-family:var(--font-display);line-height:1.12;letter-spacing:-.02em}
.eyebrow{
  font-family:var(--font-mono);
  font-size:.78rem;
  letter-spacing:.22em;
  text-transform:uppercase;
  color:var(--blue);
  display:inline-flex;
  align-items:center;
  gap:10px;
  margin-bottom:18px;
}
.eyebrow::before{content:"";width:26px;height:1px;background:linear-gradient(90deg,transparent,var(--blue))}
.section-title{font-size:clamp(1.9rem,4vw,2.9rem);font-weight:700;margin-bottom:16px}
.section-sub{color:var(--grey-mid);font-size:1.06rem;max-width:640px}
.section{padding:110px 0;position:relative}

/* ---------- hex background ---------- */
.hex-bg{
  position:absolute;inset:0;pointer-events:none;opacity:.5;
  background-image:url("data:image/svg+xml,%3Csvg width='84' height='96' viewBox='0 0 84 96' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M42 2 78 22v40L42 82 6 62V22z' fill='none' stroke='%231a3a78' stroke-opacity='.22' stroke-width='1'/%3E%3C/svg%3E");
  -webkit-mask-image:radial-gradient(ellipse 80% 70% at 50% 30%,#000 30%,transparent 75%);
  mask-image:radial-gradient(ellipse 80% 70% at 50% 30%,#000 30%,transparent 75%);
}

/* ---------- buttons ---------- */
.btn{
  display:inline-flex;align-items:center;gap:10px;
  font-family:var(--font-display);font-weight:600;font-size:.95rem;
  padding:14px 28px;border-radius:12px;
  transition:transform .25s cubic-bezier(.2,.8,.3,1),box-shadow .25s,background .25s,border-color .25s;
  will-change:transform;
}
.btn-primary{
  background:linear-gradient(135deg,#1f7bff 0%,var(--blue) 45%,var(--blue-2) 100%);
  color:#fff;
  box-shadow:0 8px 28px rgba(0,87,217,.42), inset 0 1px 0 rgba(255,255,255,.25);
}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 14px 40px rgba(0,87,217,.55), inset 0 1px 0 rgba(255,255,255,.3)}
.btn-ghost{
  background:rgba(255,255,255,.04);
  border:1px solid var(--glass-border);
  color:var(--grey-tech);
  backdrop-filter:blur(8px);
}
.btn-ghost:hover{border-color:rgba(139,177,255,.4);color:#fff;transform:translateY(-2px)}
.btn .arrow{transition:transform .25s}
.btn:hover .arrow{transform:translateX(4px)}

/* ---------- header ---------- */
header{
  position:fixed;top:0;left:0;right:0;z-index:100;
  transition:background .35s,border-color .35s,backdrop-filter .35s;
  border-bottom:1px solid transparent;
}
header.scrolled{
  background:rgba(2,10,34,.72);
  backdrop-filter:blur(18px);
  -webkit-backdrop-filter:blur(18px);
  border-bottom-color:rgba(139,177,255,.1);
}
.nav{display:flex;align-items:center;justify-content:space-between;height:76px}
.logo{display:flex;align-items:center;gap:12px}
.logo-text{font-family:var(--font-display);font-weight:700;font-size:1.18rem;letter-spacing:.01em}
.logo-text em{font-style:normal;color:var(--blue);font-weight:600}
.nav-links{display:flex;gap:36px;align-items:center}
.nav-links a{
  font-size:.92rem;color:var(--grey-tech);font-weight:500;
  position:relative;transition:color .25s;
}
.nav-links a::after{
  content:"";position:absolute;left:0;bottom:-6px;width:0;height:2px;
  background:var(--blue);border-radius:2px;transition:width .25s;
}
.nav-links a:hover{color:#fff}
.nav-links a:hover::after{width:100%}
.nav-cta{padding:11px 22px;font-size:.88rem}
.menu-toggle{display:none;background:none;flex-direction:column;gap:5px;padding:8px}
.menu-toggle span{width:24px;height:2px;background:#fff;border-radius:2px;transition:.3s}

/* ---------- hero ---------- */
.hero{
  min-height:100vh;
  display:flex;align-items:center;
  position:relative;
  padding:150px 0 90px;
  background:
    radial-gradient(900px 500px at 75% 8%,rgba(0,87,217,.22),transparent 65%),
    radial-gradient(700px 600px at 10% 90%,rgba(10,46,138,.3),transparent 65%),
    linear-gradient(180deg,#020A22 0%,#04143A 60%,#031030 100%);
}
.hero-grid{
  display:grid;grid-template-columns:1.05fr .95fr;gap:60px;align-items:center;
  position:relative;z-index:2;
}
.hero h1{
  font-size:clamp(2.3rem,4.6vw,3.7rem);
  font-weight:700;
  margin-bottom:22px;
}
.hero h1 .grad{
  background:linear-gradient(100deg,#5ea0ff 0%,#1f7bff 50%,#7db4ff 100%);
  -webkit-background-clip:text;background-clip:text;color:transparent;
}
.hero-sub{color:var(--grey-mid);font-size:1.12rem;max-width:540px;margin-bottom:34px}
.hero-ctas{display:flex;gap:16px;flex-wrap:wrap;margin-bottom:40px}
.hero-checks{display:flex;flex-wrap:wrap;gap:10px 26px}
.hero-checks li{
  display:flex;align-items:center;gap:8px;
  font-size:.88rem;color:var(--grey-tech);
}
.hero-checks svg{flex:none}
.hero-badge{
  display:inline-flex;align-items:center;gap:10px;
  font-family:var(--font-mono);font-size:.74rem;letter-spacing:.08em;
  color:#8fb8ff;
  background:rgba(0,87,217,.12);
  border:1px solid rgba(0,87,217,.35);
  padding:7px 16px;border-radius:100px;margin-bottom:26px;
}
.hero-badge .dot{width:7px;height:7px;border-radius:50%;background:#3d8bff;box-shadow:0 0 10px #3d8bff;animation:pulse 2.4s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.35}}

/* particles */
.particles{position:absolute;inset:0;overflow:hidden;pointer-events:none}
.particles i{
  position:absolute;width:3px;height:3px;border-radius:50%;
  background:#3d8bff;opacity:.5;
  animation:floatUp linear infinite;
  box-shadow:0 0 8px rgba(61,139,255,.8);
}
@keyframes floatUp{
  from{transform:translateY(20vh);opacity:0}
  12%{opacity:.55}
  88%{opacity:.4}
  to{transform:translateY(-110vh);opacity:0}
}
</style>
<style>
/* ---------- dashboard mockup ---------- */
.mock-wrap{position:relative;perspective:1400px}
.mock{
  background:linear-gradient(160deg,rgba(15,33,75,.92),rgba(4,16,48,.96));
  border:1px solid rgba(139,177,255,.18);
  border-radius:20px;
  box-shadow:0 40px 90px rgba(0,0,0,.55), var(--shadow-glow);
  transform:rotateY(-8deg) rotateX(4deg);
  transition:transform .6s cubic-bezier(.2,.8,.3,1);
  overflow:hidden;
  backdrop-filter:blur(10px);
}
.mock-wrap:hover .mock{transform:rotateY(-3deg) rotateX(1.5deg)}
.mock-bar{
  display:flex;align-items:center;gap:8px;
  padding:13px 18px;border-bottom:1px solid rgba(139,177,255,.12);
  background:rgba(255,255,255,.025);
}
.mock-bar i{width:10px;height:10px;border-radius:50%;background:#22335f}
.mock-bar i:first-child{background:#3d6ad1}
.mock-bar .url{
  margin-left:10px;font-family:var(--font-mono);font-size:.68rem;color:#5f7bb0;
  background:rgba(2,10,34,.6);padding:4px 14px;border-radius:6px;flex:1;
}
.mock-body{padding:20px;display:grid;gap:14px}
.kpi-row{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
.kpi{
  background:rgba(255,255,255,.035);
  border:1px solid rgba(139,177,255,.1);
  border-radius:12px;padding:14px 15px;
}
.kpi .lbl{font-size:.66rem;color:#7d94c2;text-transform:uppercase;letter-spacing:.08em;margin-bottom:5px}
.kpi .val{font-family:var(--font-display);font-weight:700;font-size:1.22rem}
.kpi .delta{font-family:var(--font-mono);font-size:.64rem;color:#4ade80;margin-top:3px}
.kpi .delta.down{color:#60a5fa}
.mock-mid{display:grid;grid-template-columns:1.5fr 1fr;gap:12px}
.chart-card,.list-card{
  background:rgba(255,255,255,.035);
  border:1px solid rgba(139,177,255,.1);
  border-radius:12px;padding:15px;
}
.card-title{font-size:.72rem;color:#9db4dd;font-weight:600;margin-bottom:12px;display:flex;justify-content:space-between;align-items:center}
.card-title .tag{font-family:var(--font-mono);font-size:.6rem;color:#3d8bff;background:rgba(0,87,217,.15);padding:2px 8px;border-radius:4px}
.bars{display:flex;align-items:flex-end;gap:7px;height:92px}
.bars b{
  flex:1;border-radius:5px 5px 2px 2px;
  background:linear-gradient(180deg,#1f7bff,#0A2E8A);
  opacity:.85;
  transform-origin:bottom;
  animation:growBar 1.2s cubic-bezier(.2,.8,.3,1) both;
}
.bars b:nth-child(odd){background:linear-gradient(180deg,#3d8bff,#13408f)}
@keyframes growBar{from{transform:scaleY(0)}to{transform:scaleY(1)}}
.list-card li{
  display:flex;justify-content:space-between;align-items:center;
  font-size:.72rem;color:#aebfdd;
  padding:7px 0;border-bottom:1px dashed rgba(139,177,255,.1);
}
.list-card li:last-child{border:none}
.list-card .pct{font-family:var(--font-mono);color:#3d8bff;font-size:.66rem}
.orders-strip{display:flex;gap:10px;overflow:hidden}
.order-chip{
  flex:none;display:flex;align-items:center;gap:8px;
  font-family:var(--font-mono);font-size:.62rem;color:#9db4dd;
  background:rgba(0,87,217,.1);border:1px solid rgba(0,87,217,.25);
  padding:6px 12px;border-radius:100px;white-space:nowrap;
}
.order-chip .st{width:6px;height:6px;border-radius:50%}
.st.prep{background:#fbbf24}.st.out{background:#3d8bff}.st.ok{background:#4ade80}

/* floating glass chips around mock */
.float-chip{
  position:absolute;z-index:3;
  background:rgba(10,30,75,.65);
  border:1px solid rgba(139,177,255,.25);
  backdrop-filter:blur(14px);
  border-radius:14px;padding:12px 16px;
  box-shadow:0 18px 40px rgba(0,0,0,.4);
  animation:floaty 6s ease-in-out infinite;
}
.float-chip .fc-l{font-size:.62rem;color:#8fa9d6;text-transform:uppercase;letter-spacing:.1em}
.float-chip .fc-v{font-family:var(--font-display);font-weight:700;font-size:1.05rem;color:#fff}
.float-chip .fc-v span{color:#4ade80;font-size:.72rem;font-family:var(--font-mono)}
.chip-1{top:-22px;right:8%}
.chip-2{bottom:-18px;left:-4%;animation-delay:-3s}
@keyframes floaty{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}

/* ---------- sobre ---------- */
.sobre{background:linear-gradient(180deg,#031030 0%,#020A22 100%)}
.sobre-grid{display:grid;grid-template-columns:1fr 1fr;gap:70px;align-items:center}
.sobre-text p{color:var(--grey-mid);margin-bottom:18px;font-size:1.04rem}
.sobre-text strong{color:#cfe0ff;font-weight:600}
.timeline{display:grid;gap:0;position:relative;padding-left:30px}
.timeline::before{
  content:"";position:absolute;left:7px;top:14px;bottom:14px;width:1px;
  background:linear-gradient(180deg,var(--blue),rgba(0,87,217,.05));
}
.tl-item{position:relative;padding:16px 0 16px 14px}
.tl-item::before{
  content:"";position:absolute;left:-30px;top:24px;
  width:15px;height:15px;border-radius:4px;transform:rotate(45deg);
  background:var(--navy);border:2px solid var(--blue);
  box-shadow:0 0 14px rgba(0,87,217,.6);
}
.tl-item h4{font-family:var(--font-display);font-size:1.02rem;margin-bottom:4px}
.tl-item span{font-family:var(--font-mono);font-size:.68rem;color:var(--blue);letter-spacing:.1em}
.tl-item p{color:var(--grey-mid);font-size:.9rem;margin-top:4px}

/* ---------- cards genéricos (diferenciais / módulos / benefícios) ---------- */
.cards-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:54px}
.glass-card{
  position:relative;
  background:var(--glass);
  border:1px solid var(--glass-border);
  border-radius:var(--radius);
  padding:30px 28px;
  backdrop-filter:blur(10px);
  transition:transform .35s cubic-bezier(.2,.8,.3,1),border-color .35s,box-shadow .35s,background .35s;
  overflow:hidden;
}
.glass-card::before{
  content:"";position:absolute;inset:0;border-radius:inherit;
  background:radial-gradient(420px 200px at var(--mx,50%) var(--my,0%),rgba(0,87,217,.16),transparent 60%);
  opacity:0;transition:opacity .35s;pointer-events:none;
}
.glass-card:hover{transform:translateY(-6px);border-color:rgba(139,177,255,.32);box-shadow:0 22px 50px rgba(0,20,70,.5)}
.glass-card:hover::before{opacity:1}
.card-icon{
  width:52px;height:52px;border-radius:14px;
  display:grid;place-items:center;margin-bottom:20px;
  background:linear-gradient(135deg,rgba(0,87,217,.25),rgba(10,46,138,.35));
  border:1px solid rgba(0,87,217,.35);
  color:#5ea0ff;
  box-shadow:inset 0 1px 0 rgba(255,255,255,.08);
}
.glass-card h3{font-size:1.16rem;margin-bottom:9px;font-weight:600}
.glass-card p{color:var(--grey-mid);font-size:.93rem}
.card-num{
  position:absolute;top:24px;right:26px;
  font-family:var(--font-mono);font-size:.66rem;color:#3a5288;letter-spacing:.12em;
}
</style>
<style>
/* ---------- módulos ---------- */
.modulos{background:linear-gradient(180deg,#020A22,#04143A 55%,#020A22)}
.mod-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:54px}
.mod-card{padding:34px 30px}
.mod-card .link{
  display:inline-flex;align-items:center;gap:7px;margin-top:18px;
  font-size:.84rem;font-weight:600;color:#5ea0ff;
  transition:gap .25s;
}
.mod-card:hover .link{gap:12px}
.mod-connector{
  position:absolute;inset:0;pointer-events:none;opacity:.35;
}

/* ---------- seção visual / dashboard grande ---------- */
.visual{padding-bottom:140px}
.big-dash{
  margin-top:60px;
  background:linear-gradient(165deg,rgba(13,30,72,.85),rgba(3,12,38,.95));
  border:1px solid rgba(139,177,255,.16);
  border-radius:24px;
  box-shadow:0 50px 110px rgba(0,0,0,.6), 0 0 90px rgba(0,87,217,.18);
  overflow:hidden;
}
.dash-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:18px 26px;border-bottom:1px solid rgba(139,177,255,.1);
  background:rgba(255,255,255,.02);
}
.dash-head .dh-title{display:flex;align-items:center;gap:12px;font-family:var(--font-display);font-weight:600;font-size:.95rem}
.dash-head .live{
  display:flex;align-items:center;gap:7px;
  font-family:var(--font-mono);font-size:.66rem;color:#4ade80;letter-spacing:.1em;
}
.dash-head .live i{width:7px;height:7px;border-radius:50%;background:#4ade80;box-shadow:0 0 10px #4ade80;animation:pulse 2s infinite}
.dash-body{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;padding:24px}
.dash-kpi{
  background:rgba(255,255,255,.035);border:1px solid rgba(139,177,255,.1);
  border-radius:14px;padding:20px;
}
.dash-kpi .lbl{font-size:.7rem;color:#7d94c2;text-transform:uppercase;letter-spacing:.1em;margin-bottom:8px;display:flex;justify-content:space-between}
.dash-kpi .val{font-family:var(--font-display);font-weight:700;font-size:1.7rem;letter-spacing:-.02em}
.dash-kpi .sub{font-family:var(--font-mono);font-size:.66rem;margin-top:6px;color:#4ade80}
.dash-kpi .sub.warn{color:#fbbf24}
.spark{margin-top:12px;height:34px}
.dash-low{display:grid;grid-template-columns:1.6fr 1fr 1fr;gap:16px;padding:0 24px 24px}
.dash-panel{
  background:rgba(255,255,255,.035);border:1px solid rgba(139,177,255,.1);
  border-radius:14px;padding:20px;
}
.dash-panel h5{font-size:.78rem;color:#9db4dd;font-weight:600;margin-bottom:14px;display:flex;justify-content:space-between;align-items:center}
.big-bars{display:flex;align-items:flex-end;gap:10px;height:130px}
.big-bars b{flex:1;border-radius:6px 6px 2px 2px;background:linear-gradient(180deg,#1f7bff,#0A2E8A);animation:growBar 1.3s cubic-bezier(.2,.8,.3,1) both}
.big-bars b:nth-child(2n){background:linear-gradient(180deg,#3d8bff,#123a85)}
.bar-lbls{display:flex;gap:10px;margin-top:8px}
.bar-lbls span{flex:1;text-align:center;font-family:var(--font-mono);font-size:.58rem;color:#5f7bb0}
.rank li{display:flex;align-items:center;gap:10px;font-size:.8rem;color:#c4d3ef;padding:8px 0;border-bottom:1px dashed rgba(139,177,255,.08)}
.rank li:last-child{border:none}
.rank .pos{font-family:var(--font-mono);font-size:.62rem;color:#3d8bff;width:18px}
.rank .meter{margin-left:auto;width:64px;height:5px;border-radius:4px;background:rgba(139,177,255,.12);overflow:hidden}
.rank .meter i{display:block;height:100%;border-radius:4px;background:linear-gradient(90deg,#0A2E8A,#3d8bff)}
.stock li{display:flex;justify-content:space-between;align-items:center;font-size:.78rem;color:#c4d3ef;padding:8px 0;border-bottom:1px dashed rgba(139,177,255,.08)}
.stock li:last-child{border:none}
.badge{font-family:var(--font-mono);font-size:.58rem;padding:3px 9px;border-radius:100px;letter-spacing:.06em}
.badge.ok{background:rgba(74,222,128,.12);color:#4ade80;border:1px solid rgba(74,222,128,.3)}
.badge.low{background:rgba(251,191,36,.12);color:#fbbf24;border:1px solid rgba(251,191,36,.3)}
.badge.crit{background:rgba(96,165,250,.12);color:#60a5fa;border:1px solid rgba(96,165,250,.3)}

/* ---------- benefícios ---------- */
.bene-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:54px}
.bene-card{display:flex;gap:18px;align-items:flex-start;padding:26px}
.bene-emoji{font-size:1.6rem;line-height:1;filter:drop-shadow(0 0 12px rgba(0,87,217,.5))}
.bene-card h3{font-size:1.05rem;margin-bottom:6px}

/* ---------- processo ---------- */
.processo{background:linear-gradient(180deg,#020A22,#031030)}
.steps{
  display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:64px;
  position:relative;
}
.steps::before{
  content:"";position:absolute;top:34px;left:12%;right:12%;height:1px;
  background:linear-gradient(90deg,transparent,var(--blue) 20%,var(--blue) 80%,transparent);
  opacity:.5;
}
.step{text-align:center;padding:0 18px;position:relative}
.step-n{
  width:68px;height:68px;margin:0 auto 22px;
  display:grid;place-items:center;
  font-family:var(--font-display);font-weight:700;font-size:1.3rem;
  color:#fff;position:relative;z-index:2;
  background:linear-gradient(160deg,#0d2a66,#04143A);
  border:1px solid rgba(0,87,217,.5);
  clip-path:polygon(50% 0,93% 25%,93% 75%,50% 100%,7% 75%,7% 25%);
  box-shadow:0 0 30px rgba(0,87,217,.35);
  transition:transform .3s, box-shadow .3s;
}
.step:hover .step-n{transform:translateY(-5px) scale(1.05)}
.step h3{font-size:1.08rem;margin-bottom:8px}
.step p{color:var(--grey-mid);font-size:.88rem}

/* ---------- depoimentos / métricas ---------- */
.metrics{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin:60px 0 70px}
.metric{
  text-align:center;padding:36px 20px;
}
.metric .num{
  font-family:var(--font-display);font-weight:700;
  font-size:clamp(2.4rem,5vw,3.4rem);letter-spacing:-.03em;
  background:linear-gradient(120deg,#7db4ff,#1f7bff);
  -webkit-background-clip:text;background-clip:text;color:transparent;
}
.metric .lbl{color:var(--grey-mid);font-size:.92rem;margin-top:8px}
.depo-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.depo{padding:30px 28px;display:flex;flex-direction:column;gap:18px}
.stars{color:#3d8bff;letter-spacing:3px;font-size:.85rem}
.depo p{color:#c4d3ef;font-size:.94rem;font-style:italic}
.depo-author{display:flex;align-items:center;gap:13px;margin-top:auto}
.avatar{
  width:44px;height:44px;border-radius:12px;
  display:grid;place-items:center;
  font-family:var(--font-display);font-weight:700;font-size:.9rem;
  background:linear-gradient(135deg,var(--blue),var(--blue-2));
  box-shadow:0 6px 16px rgba(0,87,217,.4);
}
.depo-author .name{font-weight:600;font-size:.9rem}
.depo-author .role{color:var(--grey-mid);font-size:.76rem}

/* ---------- CTA final ---------- */
.cta-final{
  position:relative;
  background:
    radial-gradient(800px 400px at 50% 0%,rgba(0,87,217,.3),transparent 70%),
    linear-gradient(180deg,#04143A,#020A22);
  text-align:center;
  padding:130px 0;
  overflow:hidden;
}
.cta-final h2{font-size:clamp(2rem,4.4vw,3.2rem);max-width:760px;margin:0 auto 22px}
.cta-final p{color:var(--grey-mid);max-width:560px;margin:0 auto 40px;font-size:1.08rem}
.cta-glow{
  position:absolute;left:50%;top:-140px;transform:translateX(-50%);
  width:560px;height:280px;border-radius:50%;
  background:radial-gradient(ellipse,rgba(0,87,217,.4),transparent 70%);
  filter:blur(40px);pointer-events:none;
}

/* ---------- footer ---------- */
footer{
  background:#01081d;
  border-top:1px solid rgba(139,177,255,.08);
  padding:70px 0 34px;
}
.foot-grid{display:grid;grid-template-columns:1.4fr 1fr 1fr 1fr;gap:48px;margin-bottom:50px}
.foot-brand p{color:var(--grey-mid);font-size:.88rem;margin-top:16px;max-width:280px}
.foot-col h4{font-family:var(--font-display);font-size:.86rem;letter-spacing:.06em;text-transform:uppercase;color:#9db4dd;margin-bottom:18px}
.foot-col li{margin-bottom:11px}
.foot-col a{color:var(--grey-mid);font-size:.9rem;transition:color .25s,padding-left .25s}
.foot-col a:hover{color:#fff;padding-left:5px}
.foot-col .ic{display:inline-flex;align-items:center;gap:9px}
.foot-bottom{
  display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap;
  padding-top:28px;border-top:1px solid rgba(139,177,255,.07);
  color:#4f648f;font-size:.8rem;
}
.foot-bottom .mono{font-family:var(--font-mono);font-size:.7rem}

/* ---------- reveal ---------- */
.reveal{opacity:0;transform:translateY(34px);transition:opacity .8s cubic-bezier(.2,.8,.3,1),transform .8s cubic-bezier(.2,.8,.3,1)}
.reveal.in{opacity:1;transform:none}
.reveal[data-delay="1"]{transition-delay:.1s}
.reveal[data-delay="2"]{transition-delay:.2s}
.reveal[data-delay="3"]{transition-delay:.3s}
.reveal[data-delay="4"]{transition-delay:.4s}
.reveal[data-delay="5"]{transition-delay:.5s}

/* ---------- responsive ---------- */
@media (max-width:1020px){
  .hero-grid{grid-template-columns:1fr;gap:70px}
  .mock{transform:none}
  .cards-grid,.mod-grid,.bene-grid,.depo-grid{grid-template-columns:repeat(2,1fr)}
  .dash-body{grid-template-columns:repeat(2,1fr)}
  .dash-low{grid-template-columns:1fr 1fr}
  .sobre-grid{grid-template-columns:1fr;gap:50px}
  .steps{grid-template-columns:repeat(2,1fr);gap:44px 0}
  .steps::before{display:none}
  .foot-grid{grid-template-columns:1fr 1fr}
  .metrics{grid-template-columns:repeat(3,1fr)}
}
@media (max-width:680px){
  .section{padding:80px 0}
  .nav-links{
    position:fixed;inset:76px 0 auto 0;
    flex-direction:column;gap:0;
    background:rgba(2,10,34,.97);backdrop-filter:blur(20px);
    border-bottom:1px solid rgba(139,177,255,.1);
    max-height:0;overflow:hidden;transition:max-height .4s ease;
  }
  .nav-links.open{max-height:420px}
  .nav-links a{padding:18px 28px;width:100%;border-bottom:1px solid rgba(139,177,255,.06)}
  .nav-links a::after{display:none}
  .nav-cta-wrap{display:none}
  .menu-toggle{display:flex}
  .cards-grid,.mod-grid,.bene-grid,.depo-grid,.dash-body,.dash-low{grid-template-columns:1fr}
  .metrics{grid-template-columns:1fr}
  .steps{grid-template-columns:1fr}
  .float-chip{display:none}
  .hero{padding-top:120px}
  .hero-ctas .btn{width:100%;justify-content:center}
  .foot-grid{grid-template-columns:1fr;gap:36px}
}
@media (prefers-reduced-motion:reduce){
  *,*::before,*::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}
  html{scroll-behavior:auto}
  .reveal{opacity:1;transform:none}
}
</style>
</head>
<body>

<!-- ============ HEADER ============ -->
<header id="header">
  <div class="container nav">
    <a href="#inicio" class="logo" aria-label="Módulo Zero — Início">
      <svg width="40" height="40" viewBox="0 0 64 64" fill="none" aria-hidden="true">
        <defs>
          <linearGradient id="lgM" x1="0" y1="0" x2="64" y2="64">
            <stop offset="0" stop-color="#3d8bff"/><stop offset="1" stop-color="#0A2E8A"/>
          </linearGradient>
        </defs>
        <path d="M8 50V20l8-6h10v8H18v28h-8z" fill="url(#lgM)"/>
        <path d="M24 14h6l4 4v10h-8V22h-2v-8z" fill="url(#lgM)" opacity=".85"/>
        <path d="M44 12 58 20v18L44 46 30 38V20L44 12zm0 9-7 4v10l7 4 7-4V25l-7-4z" fill="url(#lgM)"/>
      </svg>
      <span class="logo-text">MÓDULO <em>ZERO</em></span>
    </a>
    <nav class="nav-links" id="navLinks" aria-label="Navegação principal">
      <a href="#inicio">Início</a>
      <a href="#solucoes">Soluções</a>
      <a href="#modulos">Módulos</a>
      <a href="#sobre">Sobre</a>
      <a href="#contato">Contato</a>
    </nav>
    <div class="nav-cta-wrap">
      <a href="#contato" class="btn btn-primary nav-cta">Solicitar Demonstração</a>
    </div>
    <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>