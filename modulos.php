<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Módulos — Módulo Zero · Plataforma completa para restaurantes</title>
<meta name="description" content="Cozinha, Garçom, Estoque, Caixa e Administrativo. 5 módulos integrados em tempo real.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="icon" type="image/x-icon" href="img/mdzero.ico">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
:root{
  --blue:#0057D9;--blue-2:#0A2E8A;--blue-l:#3D8BFF;
  --navy:#04143A;--navy-deep:#020A22;
  --glass:rgba(255,255,255,.045);--glass-border:rgba(139,177,255,.14);
  --grey-tech:#CBD5E1;--grey-mid:#8DA2C0;
  --cz:#F97316;--cz-d:rgba(249,115,22,.10);--cz-m:rgba(249,115,22,.22);
  --gc:#8B5CF6;--gc-d:rgba(139,92,246,.10);--gc-m:rgba(139,92,246,.22);
  --es:#14B8A6;--es-d:rgba(20,184,166,.10);--es-m:rgba(20,184,166,.22);
  --cx:#22C55E;--cx-d:rgba(34,197,94,.10);--cx-m:rgba(34,197,94,.22);
  --adm:#3D8BFF;--adm-d:rgba(61,139,255,.10);--adm-m:rgba(61,139,255,.22);
  --radius:18px;--maxw:1180px;
  --font-display:'Space Grotesk',sans-serif;
  --font-body:'Inter',sans-serif;
  --font-mono:'JetBrains Mono',monospace;
  --nav-h:76px;--tabs-h:58px;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:var(--font-body);background:var(--navy-deep);color:#fff;line-height:1.65;overflow-x:hidden;-webkit-font-smoothing:antialiased}
::selection{background:var(--blue);color:#fff}
img,svg{display:block;max-width:100%;height:auto}
a{color:inherit;text-decoration:none}
ul{list-style:none}
button{font-family:inherit;cursor:pointer;border:none;background:none}
:focus-visible{outline:2px solid var(--blue-l);outline-offset:3px;border-radius:4px}
.container{max-width:var(--maxw);margin:0 auto;padding-inline:clamp(1rem,5vw,1.75rem)}
h1,h2,h3,h4{font-family:var(--font-display);line-height:1.1;letter-spacing:-.02em}

/* HEADER */
header{position:fixed;top:0;left:0;right:0;z-index:300;transition:background .3s,border-color .3s;border-bottom:1px solid transparent}
header.scrolled{background:rgba(2,10,34,.9);backdrop-filter:blur(18px);-webkit-backdrop-filter:blur(18px);border-bottom-color:rgba(139,177,255,.1)}
.nav{display:flex;align-items:center;justify-content:space-between;height:var(--nav-h);padding-left:max(clamp(1rem,5vw,1.75rem),env(safe-area-inset-left));padding-right:max(clamp(1rem,5vw,1.75rem),env(safe-area-inset-right))}
.logo{display:inline-flex;align-items:center;gap:12px;min-height:44px}
.logo-text{font-family:var(--font-display);font-weight:700;font-size:1.1rem}
.logo-text em{font-style:normal;color:var(--blue-l)}
.nav-links{display:flex;gap:28px;align-items:center}
.nav-links a{font-size:.88rem;color:var(--grey-tech);font-weight:500;position:relative;transition:color .2s;min-height:44px;display:inline-flex;align-items:center}
.nav-links a::after{content:"";position:absolute;left:0;bottom:-4px;width:0;height:2px;background:var(--blue-l);border-radius:2px;transition:width .25s}
.nav-links a:hover{color:#fff}
.nav-links a:hover::after{width:100%}
.nav-links a.back{color:var(--blue-l);font-weight:600}
.btn{display:inline-flex;align-items:center;gap:9px;font-family:var(--font-display);font-weight:600;font-size:.93rem;padding:13px 26px;border-radius:12px;min-height:44px;transition:transform .25s cubic-bezier(.2,.8,.3,1),box-shadow .25s,background .25s,border-color .25s;will-change:transform}
.btn-primary{background:linear-gradient(135deg,#1f7bff 0%,var(--blue) 45%,var(--blue-2) 100%);color:#fff;box-shadow:0 8px 28px rgba(0,87,217,.42),inset 0 1px 0 rgba(255,255,255,.22)}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 14px 40px rgba(0,87,217,.55)}
.btn-ghost{background:rgba(255,255,255,.04);border:1px solid var(--glass-border);color:var(--grey-tech);backdrop-filter:blur(8px)}
.btn-ghost:hover{border-color:rgba(139,177,255,.4);color:#fff;transform:translateY(-2px)}
.btn .arrow{transition:transform .25s}
.btn:hover .arrow{transform:translateX(4px)}
.menu-toggle{display:none;flex-direction:column;gap:5px;padding:8px;min-height:44px;min-width:44px;align-items:center;justify-content:center}
.menu-toggle span{width:22px;height:1.5px;background:#fff;border-radius:2px;transition:.3s}
.nav-cta-wrap .btn{padding:10px 20px;font-size:.86rem}

/* MODULE TABS */
.tabs-bar{position:sticky;top:var(--nav-h);z-index:200;background:rgba(2,10,34,.93);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-bottom:1px solid rgba(139,177,255,.1);overflow-x:auto;scrollbar-width:none;-webkit-overflow-scrolling:touch}
.tabs-bar::-webkit-scrollbar{display:none}
.tabs{display:flex;align-items:stretch;height:var(--tabs-h);min-width:max-content;padding-inline:clamp(1rem,5vw,1.75rem)}
.tab{display:inline-flex;align-items:center;gap:9px;padding:0 22px;font-family:var(--font-display);font-weight:600;font-size:.83rem;color:var(--grey-mid);position:relative;border-bottom:2px solid transparent;transition:color .25s,border-color .25s;white-space:nowrap;cursor:pointer}
.tab .tico{width:28px;height:28px;border-radius:7px;display:flex;align-items:center;justify-content:center;transition:background .25s;flex-shrink:0}
.tab .tico svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:1.9;stroke-linecap:round;stroke-linejoin:round}
.tab:hover{color:#fff}
.tab[data-m="cz"]:hover,.tab[data-m="cz"].on{color:var(--cz);border-color:var(--cz)}
.tab[data-m="cz"].on .tico{background:var(--cz-d)}
.tab[data-m="gc"]:hover,.tab[data-m="gc"].on{color:var(--gc);border-color:var(--gc)}
.tab[data-m="gc"].on .tico{background:var(--gc-d)}
.tab[data-m="es"]:hover,.tab[data-m="es"].on{color:var(--es);border-color:var(--es)}
.tab[data-m="es"].on .tico{background:var(--es-d)}
.tab[data-m="cx"]:hover,.tab[data-m="cx"].on{color:var(--cx);border-color:var(--cx)}
.tab[data-m="cx"].on .tico{background:var(--cx-d)}
.tab[data-m="adm"]:hover,.tab[data-m="adm"].on{color:var(--adm);border-color:var(--adm)}
.tab[data-m="adm"].on .tico{background:var(--adm-d)}

/* HERO */
.hero{min-height:100svh;display:flex;align-items:center;position:relative;overflow:hidden;padding:calc(var(--nav-h) + 60px) 0 80px;background:radial-gradient(900px 600px at 80% 10%,rgba(0,87,217,.18),transparent 65%),radial-gradient(600px 500px at 10% 80%,rgba(10,46,138,.25),transparent 65%),linear-gradient(180deg,#020A22 0%,#04143A 55%,#031030 100%)}
.hex-bg{position:absolute;inset:0;pointer-events:none;opacity:.4;background-image:url("data:image/svg+xml,%3Csvg width='84' height='96' viewBox='0 0 84 96' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M42 2 78 22v40L42 82 6 62V22z' fill='none' stroke='%231a3a78' stroke-opacity='.22' stroke-width='1'/%3E%3C/svg%3E");mask-image:radial-gradient(ellipse 80% 70% at 50% 30%,#000 30%,transparent 75%);-webkit-mask-image:radial-gradient(ellipse 80% 70% at 50% 30%,#000 30%,transparent 75%)}
.hero-inner{position:relative;z-index:2;text-align:center;max-width:820px;margin:0 auto}
.eyebrow{font-family:var(--font-mono);font-size:.75rem;letter-spacing:.22em;text-transform:uppercase;color:var(--blue-l);display:inline-flex;align-items:center;gap:10px;margin-bottom:20px}
.eyebrow::before{content:"";width:24px;height:1px;background:linear-gradient(90deg,transparent,var(--blue-l))}
.hero h1{font-size:clamp(2.2rem,5.5vw,4.2rem);font-weight:700;margin-bottom:20px}
.grad{background:linear-gradient(100deg,#5ea0ff 0%,#1f7bff 50%,#7db4ff 100%);-webkit-background-clip:text;background-clip:text;color:transparent}
.hero .sub{color:var(--grey-mid);font-size:clamp(.95rem,2vw,1.1rem);max-width:600px;margin:0 auto 36px}
.hero .sub strong{color:#cfe0ff;font-weight:500}
.hero-badges{display:flex;flex-wrap:wrap;justify-content:center;gap:9px;margin-bottom:38px}
.hb{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-mono);font-size:.7rem;letter-spacing:.06em;padding:6px 13px;border-radius:100px;border:1px solid}
.hb.cz{color:var(--cz);background:var(--cz-d);border-color:var(--cz-m)}
.hb.gc{color:var(--gc);background:var(--gc-d);border-color:var(--gc-m)}
.hb.es{color:var(--es);background:var(--es-d);border-color:var(--es-m)}
.hb.cx{color:var(--cx);background:var(--cx-d);border-color:var(--cx-m)}
.hb.adm{color:var(--adm);background:var(--adm-d);border-color:var(--adm-m)}
.hb .dot{width:5px;height:5px;border-radius:50%;background:currentColor}

/* FLOW */
.flow-sec{padding:clamp(3.5rem,8vw,6rem) 0;background:linear-gradient(180deg,#031030,#020A22);position:relative;overflow:hidden}
.flow-sec::before{content:"";position:absolute;inset:0;background:radial-gradient(600px 300px at 50% 50%,rgba(0,87,217,.08),transparent 70%);pointer-events:none}
.section-title{font-size:clamp(1.9rem,4vw,2.9rem);font-weight:700;margin-bottom:14px}
.section-sub{color:var(--grey-mid);font-size:1.04rem;max-width:640px}
.flow-diagram{display:flex;align-items:center;justify-content:center;gap:0;flex-wrap:nowrap;overflow-x:auto;scrollbar-width:none;-webkit-overflow-scrolling:touch;padding:24px clamp(1rem,5vw,1.75rem) 30px}
.flow-diagram::-webkit-scrollbar{display:none}
.fnode{display:flex;flex-direction:column;align-items:center;gap:11px;flex:0 0 auto;min-width:110px;position:relative;z-index:2}
.fnc{width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;position:relative;transition:transform .3s}
.fnc::before{content:"";position:absolute;inset:-3px;border-radius:50%;border:1px solid;opacity:.3;transition:opacity .3s}
.fnode:hover .fnc{transform:translateY(-5px)}
.fnode:hover .fnc::before{opacity:.7}
.fnc svg{width:26px;height:26px;stroke:currentColor;fill:none;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round}
.fnc.cz{background:var(--cz-d);color:var(--cz)}.fnc.cz::before{border-color:var(--cz)}
.fnc.gc{background:var(--gc-d);color:var(--gc)}.fnc.gc::before{border-color:var(--gc)}
.fnc.es{background:var(--es-d);color:var(--es)}.fnc.es::before{border-color:var(--es)}
.fnc.cx{background:var(--cx-d);color:var(--cx)}.fnc.cx::before{border-color:var(--cx)}
.fnc.adm{background:var(--adm-d);color:var(--adm)}.fnc.adm::before{border-color:var(--adm)}
.fn-label{font-family:var(--font-display);font-weight:600;font-size:.79rem;text-align:center;color:#cfe0ff}
.fn-sub{font-family:var(--font-mono);font-size:.61rem;color:var(--grey-mid);text-align:center}
.farrow{flex:0 0 auto;display:flex;align-items:center;padding:0 3px;margin-top:-22px}
.farrow svg{width:34px;height:14px;stroke:rgba(139,177,255,.28);fill:none;stroke-width:1.4}

/* MODULE SECTION */
.mod-sec{padding:clamp(4rem,9vw,6.5rem) 0;position:relative;overflow:hidden;scroll-margin-top:calc(var(--nav-h) + var(--tabs-h))}
.mod-sec.dark{background:linear-gradient(180deg,#031030 0%,#04143A 50%,#031030 100%)}
.mgrid{display:grid;grid-template-columns:1fr 1fr;gap:clamp(2.5rem,6vw,5rem);align-items:center}
.mgrid.rev{direction:rtl}
.mgrid.rev>*{direction:ltr}
.mbadge{display:inline-flex;align-items:center;gap:7px;font-family:var(--font-mono);font-size:.69rem;letter-spacing:.1em;text-transform:uppercase;padding:5px 11px;border-radius:100px;border:1px solid;margin-bottom:13px}
.mtitle{font-size:clamp(1.7rem,3.5vw,2.4rem);font-weight:700;margin-bottom:9px}
.mdesc{color:var(--grey-mid);font-size:.96rem;line-height:1.78;margin-bottom:22px}
.mwho{display:inline-flex;align-items:center;gap:8px;font-size:.81rem;color:var(--grey-mid);padding:8px 13px;border-radius:8px;background:rgba(255,255,255,.03);border:1px solid rgba(139,177,255,.1);margin-bottom:26px}
.mwho svg{width:13px;height:13px;stroke:var(--grey-mid);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0}
.feat-list{display:flex;flex-direction:column;gap:9px;margin-bottom:26px}
.feat{display:flex;align-items:flex-start;gap:9px;font-size:.87rem;color:var(--grey-tech);line-height:1.5}
.fcheck{width:17px;height:17px;border-radius:5px;flex-shrink:0;display:flex;align-items:center;justify-content:center;margin-top:.1rem}
.fcheck svg{width:9px;height:9px;stroke:#fff;fill:none;stroke-width:3;stroke-linecap:round;stroke-linejoin:round}
.mstats{display:flex;gap:22px;flex-wrap:wrap}
.ms .msv{font-family:var(--font-display);font-size:1.55rem;font-weight:700;line-height:1}
.ms .msl{font-family:var(--font-mono);font-size:.62rem;color:var(--grey-mid);letter-spacing:.08em;text-transform:uppercase;margin-top:3px}

/* MOCKUP FRAME */
.mframe{background:linear-gradient(160deg,rgba(13,30,72,.9),rgba(3,12,38,.95));border:1px solid rgba(139,177,255,.15);border-radius:20px;box-shadow:0 40px 80px rgba(0,0,0,.5);overflow:hidden}
.mfbar{display:flex;align-items:center;gap:7px;padding:11px 16px;border-bottom:1px solid rgba(139,177,255,.1);background:rgba(255,255,255,.02)}
.mfbar i{width:9px;height:9px;border-radius:50%;background:#22335f}
.mfbar i:first-child{background:#1a4abd}
.mftitle{margin-left:8px;font-family:var(--font-mono);font-size:.63rem;color:rgba(139,177,255,.55)}
.mfbody{padding:16px;display:flex;flex-direction:column;gap:11px}

/* KDS */
.kds-grid{display:grid;grid-template-columns:1fr 1fr;gap:9px}
.kticket{background:rgba(255,255,255,.03);border:1px solid;border-radius:11px;padding:11px}
.kticket.n{border-color:rgba(74,222,128,.3)}
.kticket.w{border-color:rgba(251,191,36,.3)}
.kticket.c{border-color:rgba(248,113,113,.35)}
.kth{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.ktbl{font-family:var(--font-display);font-weight:700;font-size:.86rem}
.ktimer{font-family:var(--font-mono);font-size:.61rem;padding:2px 7px;border-radius:4px}
.ktimer.n{background:rgba(74,222,128,.14);color:#4ade80}
.ktimer.w{background:rgba(251,191,36,.11);color:#fbbf24}
.ktimer.c{background:rgba(248,113,113,.11);color:#f87171;animation:blt .9s step-end infinite}
@keyframes blt{0%,100%{opacity:1}50%{opacity:.35}}
.kitems{display:flex;flex-direction:column;gap:4px;margin-bottom:9px}
.kitem{font-size:.7rem;color:#9db4dd;display:flex;align-items:center;gap:5px}
.kitem::before{content:"";width:3px;height:3px;border-radius:50%;background:var(--grey-mid);flex-shrink:0}
.kbump{width:100%;padding:6px;border-radius:6px;font-family:var(--font-mono);font-size:.62rem;letter-spacing:.04em;border:1px solid;transition:background .2s;cursor:pointer;text-align:center}
.kticket.n .kbump{background:rgba(74,222,128,.09);border-color:rgba(74,222,128,.28);color:#4ade80}
.kticket.w .kbump{background:rgba(251,191,36,.09);border-color:rgba(251,191,36,.28);color:#fbbf24}
.kticket.c .kbump{background:rgba(248,113,113,.09);border-color:rgba(248,113,113,.3);color:#f87171}
.kds-bar{display:flex;align-items:center;justify-content:space-between;padding:9px 11px;background:rgba(249,115,22,.06);border:1px solid rgba(249,115,22,.2);border-radius:9px;font-family:var(--font-mono);font-size:.63rem;color:#fdba74}
.klive{display:flex;align-items:center;gap:6px}
.klive i{width:6px;height:6px;border-radius:50%;background:#f97316;box-shadow:0 0 8px #f97316;animation:pls 2s infinite}
@keyframes pls{0%,100%{opacity:1}50%{opacity:.3}}

/* GARCOM */
.tmap{display:grid;grid-template-columns:repeat(4,1fr);gap:7px;margin-bottom:9px}
.ttable{aspect-ratio:1;border-radius:9px;border:1px solid;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:2px;font-family:var(--font-display);font-weight:700;font-size:.8rem;cursor:pointer;transition:transform .2s}
.ttable:hover{transform:scale(1.04)}
.ttable.free{background:rgba(255,255,255,.03);border-color:rgba(139,177,255,.14);color:#5f7bb0}
.ttable.occ{background:rgba(139,92,246,.1);border-color:rgba(139,92,246,.28);color:#a78bfa}
.ttable.attn{background:rgba(249,115,22,.09);border-color:rgba(249,115,22,.28);color:#fb923c}
.tts{font-family:var(--font-mono);font-size:.53rem;font-weight:400;opacity:.7}
.tleg{display:flex;gap:14px;margin-bottom:9px}
.tli{display:flex;align-items:center;gap:5px;font-family:var(--font-mono);font-size:.61rem;color:var(--grey-mid)}
.tdot{width:7px;height:7px;border-radius:2px}
.tdot.f{background:rgba(139,177,255,.28)}.tdot.o{background:var(--gc)}.tdot.a{background:var(--cz)}
.oq{padding:10px 11px;background:rgba(139,92,246,.06);border:1px solid rgba(139,92,246,.18);border-radius:9px}
.oqt{font-family:var(--font-mono);font-size:.63rem;color:#a78bfa;margin-bottom:7px}
.oqcats{display:flex;gap:6px;margin-bottom:7px}
.oqcat{font-family:var(--font-mono);font-size:.59rem;padding:3px 8px;border-radius:5px;background:rgba(255,255,255,.04);border:1px solid rgba(139,177,255,.11);color:var(--grey-mid);cursor:pointer}
.oqcat.on{background:rgba(139,92,246,.14);border-color:rgba(139,92,246,.32);color:#c4b5fd}
.oqitems{display:grid;grid-template-columns:1fr 1fr;gap:4px}
.oqi{font-size:.67rem;color:#9db4dd;padding:5px 7px;background:rgba(255,255,255,.03);border:1px solid rgba(139,177,255,.07);border-radius:5px;cursor:pointer;transition:background .2s}
.oqi:hover{background:rgba(139,92,246,.1)}

/* ESTOQUE */
.sth{display:flex;justify-content:space-between;align-items:center;margin-bottom:9px}
.stitle{font-family:var(--font-display);font-size:.77rem;font-weight:600;color:#cfe0ff}
.stalert{display:flex;align-items:center;gap:5px;font-family:var(--font-mono);font-size:.61rem;color:#fbbf24;background:rgba(251,191,36,.09);border:1px solid rgba(251,191,36,.22);padding:3px 8px;border-radius:5px}
.stlist{display:flex;flex-direction:column;gap:6px}
.sti{display:flex;align-items:center;gap:7px;padding:7px 9px;background:rgba(255,255,255,.03);border:1px solid rgba(139,177,255,.07);border-radius:8px}
.sin{font-size:.74rem;color:#cfe0ff;flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.siq{font-family:var(--font-mono);font-size:.67rem;margin-left:auto;flex-shrink:0}
.siq.ok{color:#4ade80}.siq.low{color:#fbbf24}.siq.crit{color:#f87171}
.sibar{height:4px;border-radius:3px;background:rgba(255,255,255,.07);width:56px;flex-shrink:0;overflow:hidden}
.sifill{height:100%;border-radius:3px}
.sifill.ok{background:linear-gradient(90deg,#14b8a6,#4ade80)}
.sifill.low{background:linear-gradient(90deg,#f97316,#fbbf24)}
.sifill.crit{background:#f87171}
.autodebit{display:flex;align-items:center;gap:7px;padding:7px 10px;background:rgba(20,184,166,.07);border:1px solid rgba(20,184,166,.2);border-radius:7px;font-family:var(--font-mono);font-size:.61rem;color:#5eead4}
.autodebit svg{width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0}

/* CAIXA */
.blist{display:flex;flex-direction:column;gap:4px;margin-bottom:11px}
.bitem{display:flex;justify-content:space-between;align-items:center;font-size:.73rem;color:#9db4dd;padding:5px 0;border-bottom:1px dashed rgba(139,177,255,.07)}
.bitem:last-child{border:none}
.bname{flex:1}.bqty{font-family:var(--font-mono);font-size:.64rem;color:var(--grey-mid);margin:0 10px}.bval{font-family:var(--font-mono);font-size:.68rem;color:#cfe0ff}
.btotal{display:flex;justify-content:space-between;align-items:center;padding:9px 11px;border-radius:9px;background:rgba(34,197,94,.07);border:1px solid rgba(34,197,94,.2);margin-bottom:11px}
.btlbl{font-family:var(--font-display);font-weight:600;font-size:.8rem}
.btval{font-family:var(--font-mono);font-size:1.08rem;color:#4ade80;font-weight:500}
.pmethods{display:grid;grid-template-columns:repeat(3,1fr);gap:6px}
.pm{padding:8px 0;border-radius:7px;text-align:center;font-family:var(--font-mono);font-size:.63rem;letter-spacing:.04em;border:1px solid;cursor:pointer;transition:all .2s}
.pm.pix{background:rgba(34,197,94,.09);border-color:rgba(34,197,94,.28);color:#4ade80}
.pm.card{background:rgba(61,139,255,.09);border-color:rgba(61,139,255,.28);color:#7db4ff}
.pm.cash{background:rgba(251,191,36,.07);border-color:rgba(251,191,36,.22);color:#fbbf24}
.pm.on{transform:scale(1.04);box-shadow:0 4px 14px rgba(0,0,0,.3)}
.splitbtn{width:100%;padding:7px;border-radius:7px;text-align:center;font-family:var(--font-mono);font-size:.61rem;color:var(--grey-mid);background:rgba(255,255,255,.03);border:1px solid rgba(139,177,255,.1);margin-top:7px;cursor:pointer}

/* ADMIN */
.adkpis{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:9px}
.adkpi{padding:10px 11px;background:rgba(255,255,255,.03);border:1px solid rgba(139,177,255,.09);border-radius:10px}
.adkpi .kl{font-size:.59rem;color:#7d94c2;text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px}
.adkpi .kv{font-family:var(--font-display);font-weight:700;font-size:1.02rem}
.adkpi .kd{font-family:var(--font-mono);font-size:.57rem;margin-top:2px}
.adkpi .kd.up{color:#4ade80}.adkpi .kd.dn{color:#60a5fa}
.adcharts{display:grid;grid-template-columns:1.5fr 1fr;gap:8px}
.ac{background:rgba(255,255,255,.03);border:1px solid rgba(139,177,255,.09);border-radius:10px;padding:11px}
.act{font-size:.65rem;color:#9db4dd;font-weight:600;margin-bottom:8px;display:flex;justify-content:space-between;align-items:center}
.actag{font-family:var(--font-mono);font-size:.57rem;color:var(--blue-l);background:rgba(0,87,217,.14);padding:2px 6px;border-radius:3px}
.mbars{display:flex;align-items:flex-end;gap:5px;height:68px}
.mbars b{flex:1;border-radius:4px 4px 1px 1px;background:linear-gradient(180deg,#1f7bff,#0A2E8A);opacity:.8;transform-origin:bottom;animation:gBar 1.1s cubic-bezier(.2,.8,.3,1) both}
.mbars b:nth-child(odd){background:linear-gradient(180deg,#3d8bff,#13408f)}
@keyframes gBar{from{transform:scaleY(0)}to{transform:scaleY(1)}}
.tdishes{display:flex;flex-direction:column;gap:5px}
.tditem{display:flex;align-items:center;gap:5px;font-size:.66rem;color:#c4d3ef}
.tdpos{font-family:var(--font-mono);font-size:.57rem;color:#3d8bff;width:14px;flex-shrink:0}
.tdbw{flex:1;height:4px;background:rgba(139,177,255,.09);border-radius:3px;overflow:hidden}
.tdb{height:100%;border-radius:3px;background:linear-gradient(90deg,#0A2E8A,#3d8bff);animation:gH 1.2s cubic-bezier(.2,.8,.3,1) both}
@keyframes gH{from{width:0}}

/* MATRIX */
.matrix-sec{padding:clamp(4rem,9vw,6rem) 0;background:linear-gradient(180deg,#020A22,#031030)}
.mwrap{overflow-x:auto;scrollbar-width:thin;scrollbar-color:rgba(139,177,255,.14) transparent;margin-top:2.5rem}
.mwrap::-webkit-scrollbar{height:4px}
.mwrap::-webkit-scrollbar-thumb{background:rgba(139,177,255,.18);border-radius:2px}
.mtable{border-collapse:collapse;min-width:540px;width:100%}
.mtable th,.mtable td{padding:14px 16px;text-align:left;border-bottom:1px solid rgba(139,177,255,.07);vertical-align:middle}
.mtable thead th{font-family:var(--font-mono);font-size:.67rem;letter-spacing:.1em;text-transform:uppercase;color:var(--grey-mid);background:rgba(255,255,255,.02);padding-block:16px;white-space:nowrap}
.mtable thead th:first-child{min-width:155px}
.mrh{display:flex;align-items:center;gap:9px;font-family:var(--font-display);font-weight:600;font-size:.86rem}
.mhdot{width:8px;height:8px;border-radius:50%;flex-shrink:0}
.mcheck{display:flex;align-items:center;justify-content:center}
.mcheck svg.yes{width:18px;height:18px;stroke:var(--blue-l);fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}
.mcheck svg.no{width:15px;height:15px;stroke:rgba(139,177,255,.18);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
.mcheck .partial{width:15px;height:3px;border-radius:2px;background:rgba(139,177,255,.28)}
.mtable tbody tr:hover td{background:rgba(255,255,255,.012)}

/* CTA */
.cta-sec{position:relative;text-align:center;overflow:hidden;padding:clamp(5rem,10vw,8rem) 0;background:radial-gradient(800px 400px at 50% 0%,rgba(0,87,217,.28),transparent 70%),linear-gradient(180deg,#031030,#020A22)}
.cta-glow{position:absolute;left:50%;top:-140px;transform:translateX(-50%);width:500px;height:260px;border-radius:50%;background:radial-gradient(ellipse,rgba(0,87,217,.38),transparent 70%);filter:blur(40px);pointer-events:none}
.cta-sec h2{font-size:clamp(1.9rem,4vw,3rem);max-width:700px;margin:0 auto 16px}
.cta-sec p{color:var(--grey-mid);font-size:1.04rem;max-width:520px;margin:0 auto 36px}
.cta-btns{display:flex;flex-wrap:wrap;justify-content:center;gap:13px}

/* FOOTER */
footer{background:#01081d;border-top:1px solid rgba(139,177,255,.07);padding:clamp(1.8rem,5vw,3rem) 0;padding-bottom:max(clamp(1.2rem,4vw,2rem),env(safe-area-inset-bottom))}
.frow{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:14px;padding-top:clamp(.8rem,2.5vw,1.5rem);border-top:1px solid rgba(139,177,255,.06);color:#4f648f;font-size:.78rem}
.frow .mono{font-family:var(--font-mono);font-size:.68rem}
.fback{display:inline-flex;align-items:center;gap:7px;font-size:.83rem;color:var(--grey-mid);transition:color .2s}
.fback svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;transition:transform .2s}
.fback:hover{color:#fff}
.fback:hover svg{transform:translateX(-3px)}

/* REVEAL */
.reveal{opacity:0;transform:translateY(24px);transition:opacity .75s cubic-bezier(.2,.8,.3,1),transform .75s cubic-bezier(.2,.8,.3,1)}
.reveal.in{opacity:1;transform:none}
.reveal[data-d="1"]{transition-delay:.1s}
.reveal[data-d="2"]{transition-delay:.2s}
.reveal[data-d="3"]{transition-delay:.3s}
.reveal[data-d="4"]{transition-delay:.4s}

/* RESPONSIVE */
.btn{min-height:44px}
.tab{min-height:var(--tabs-h)}
.menu-toggle{min-height:44px;min-width:44px}

@media(max-width:1024px){
  .mgrid{grid-template-columns:1fr;gap:2.5rem}
  .mgrid.rev{direction:ltr}
  .adcharts{grid-template-columns:1fr}
  .nav-links{gap:18px}
}
@media(max-width:768px){
  :root{--tabs-h:52px}
  .tab{padding:0 14px;font-size:.77rem;gap:7px}
  .tab .tico{width:24px;height:24px;border-radius:6px}
  .kds-grid{grid-template-columns:1fr}
  .adkpis{grid-template-columns:1fr 1fr}
  .adkpis .adkpi:last-child{grid-column:1/-1}
}
@media(max-width:640px){
  :root{--nav-h:66px;--tabs-h:48px}
  .nav{height:66px}
  .nav-links{position:fixed;inset:66px 0 auto 0;flex-direction:column;gap:0;background:rgba(2,10,34,.97);backdrop-filter:blur(22px);-webkit-backdrop-filter:blur(22px);border-bottom:1px solid rgba(139,177,255,.1);max-height:0;overflow:hidden;transition:max-height .42s cubic-bezier(.2,.85,.3,1)}
  .nav-links.open{max-height:500px}
  .nav-links a{padding:15px 22px;width:100%;border-bottom:1px solid rgba(139,177,255,.06);font-size:.93rem;min-height:50px}
  .nav-links a::after{display:none}
  .nav-cta-wrap{display:none}
  .menu-toggle{display:flex}
  .hero .sub{font-size:.93rem}
  .tab span.tl{display:none}
  .tab{padding:0 15px;gap:0}
  .fnode{min-width:78px}
  .fnc{width:54px;height:54px}
  .fnc svg{width:20px;height:20px}
  .fn-label{font-size:.69rem}
  .fn-sub{display:none}
  .farrow svg{width:22px}
  .mtitle{font-size:clamp(1.5rem,5.5vw,2rem)}
  .mstats{gap:15px}
  .ms .msv{font-size:1.3rem}
  .cta-btns{flex-direction:column;align-items:center}
  .cta-btns .btn{width:100%;max-width:360px;justify-content:center}
  .frow{flex-direction:column;text-align:center}
}
@media(max-width:480px){
  .adkpis{grid-template-columns:1fr 1fr 1fr}
  .adkpi .kv{font-size:.88rem}
  .adkpi:last-child{grid-column:auto}
  .mtable th,.mtable td{padding:11px 11px}
}
@media(max-width:900px) and (orientation:landscape){
  .hero{min-height:auto;padding-top:100px;padding-bottom:56px}
}
@media(prefers-reduced-motion:reduce){
  *,*::before,*::after{animation-duration:.01ms!important;transition-duration:.01ms!important}
  .reveal{opacity:1;transform:none}
}
</style>
</head>
<body>

<!-- HEADER -->
<header id="hdr">
  <div class="nav container">
    <a href="/" class="logo" aria-label="Módulo Zero — Início">
      <svg width="36" height="36" viewBox="0 0 64 64" fill="none"><defs><linearGradient id="lg" x1="0" y1="0" x2="64" y2="64"><stop offset="0" stop-color="#3d8bff"/><stop offset="1" stop-color="#0A2E8A"/></linearGradient></defs><path d="M8 50V20l8-6h10v8H18v28h-8z" fill="url(#lg)"/><path d="M24 14h6l4 4v10h-8V22h-2v-8z" fill="url(#lg)" opacity=".85"/><path d="M44 12 58 20v18L44 46 30 38V20L44 12zm0 9-7 4v10l7 4 7-4V25l-7-4z" fill="url(#lg)"/></svg>
      <span class="logo-text">MÓDULO <em>ZERO</em></span>
    </a>
    <nav class="nav-links" id="navLinks" aria-label="Navegação">
      <!-- <a href="#cozinha">Cozinha</a>
      <a href="#garcom">Garçom</a>
      <a href="#estoque">Estoque</a>
      <a href="#caixa">Caixa</a>
      <a href="#administrativo">Admin</a> -->
        <div class="tabs">
            <button class="tab" data-m="cz" data-s="cozinha">
            <div class="tico"><svg viewBox="0 0 24 24"><path d="M8 3v6M12 3v4M16 3v6"/><rect x="5" y="9" width="14" height="4" rx="1"/></svg></div>
            <span class="tl">Cozinha</span>
            </button>
            <button class="tab" data-m="gc" data-s="garcom">
            <div class="tico"><svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg></div>
            <span class="tl">Garçom</span>
            </button>
            <button class="tab" data-m="es" data-s="estoque">
            <div class="tico"><svg viewBox="0 0 24 24"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><line x1="12" y1="22" x2="12" y2="12"/></svg></div>
            <span class="tl">Estoque</span>
            </button>
            <button class="tab" data-m="cx" data-s="caixa">
            <div class="tico"><svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div>
            <span class="tl">Caixa</span>
            </button>
            <button class="tab" data-m="adm" data-s="administrativo">
            <div class="tico"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
            <span class="tl">Administrativo</span>
            </button>
        </div>
    </nav>
    <div class="nav-cta-wrap">
      <a href="mailto:contato@modulozero.com.br" class="btn btn-primary" style="padding:10px 20px;font-size:.86rem">Demonstração</a>
    </div>
    <button class="menu-toggle" id="mToggle" aria-label="Abrir menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<!-- TABS -->
<!-- <div class="tabs-bar" id="tabsBar" role="navigation" aria-label="Módulos">
  <div class="tabs">
    <button class="tab" data-m="cz" data-s="cozinha">
      <div class="tico"><svg viewBox="0 0 24 24"><path d="M8 3v6M12 3v4M16 3v6"/><rect x="5" y="9" width="14" height="4" rx="1"/></svg></div>
      <span class="tl">Cozinha</span>
    </button>
    <button class="tab" data-m="gc" data-s="garcom">
      <div class="tico"><svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg></div>
      <span class="tl">Garçom</span>
    </button>
    <button class="tab" data-m="es" data-s="estoque">
      <div class="tico"><svg viewBox="0 0 24 24"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><line x1="12" y1="22" x2="12" y2="12"/></svg></div>
      <span class="tl">Estoque</span>
    </button>
    <button class="tab" data-m="cx" data-s="caixa">
      <div class="tico"><svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div>
      <span class="tl">Caixa</span>
    </button>
    <button class="tab" data-m="adm" data-s="administrativo">
      <div class="tico"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
      <span class="tl">Administrativo</span>
    </button>
  </div>
</div> -->

<!-- HERO -->
<section class="hero" id="inicio">
  <div class="hex-bg"></div>
  <div class="container hero-inner">
    <div class="eyebrow reveal">Plataforma Módulo Zero</div>
    <h1 class="reveal" data-d="1">5 módulos. 1 plataforma.<br><span class="grad">0 gargalos.</span></h1>
    <p class="sub reveal" data-d="2">Cada módulo resolve um papel do restaurante. Juntos criam um <strong>fluxo contínuo e inteligente</strong> — do pedido ao relatório, em tempo real.</p>
    <div class="hero-badges reveal" data-d="3">
      <div class="hb cz"><span class="dot"></span>Cozinha</div>
      <div class="hb gc"><span class="dot"></span>Garçom</div>
      <div class="hb es"><span class="dot"></span>Estoque</div>
      <div class="hb cx"><span class="dot"></span>Caixa</div>
      <div class="hb adm"><span class="dot"></span>Administrativo</div>
    </div>
    <div class="reveal" data-d="4">
      <a href="mailto:contato@modulozero.com.br" class="btn btn-primary">Solicitar demonstração <span class="arrow">&#8594;</span></a>
    </div>
  </div>
</section>

<!-- FLOW -->
<section class="flow-sec">
  <div class="container">
    <div style="text-align:center">
      <div class="eyebrow reveal" style="justify-content:center">Como tudo se conecta</div>
      <h2 class="section-title reveal" data-d="1" style="text-align:center">O fluxo do pedido, passo a passo</h2>
      <p style="font-family:var(--font-mono);font-size:.67rem;color:var(--grey-mid);letter-spacing:.1em;text-transform:uppercase;margin-bottom:clamp(1.5rem,4vw,2.5rem)" class="reveal" data-d="2">Do garçom ao dashboard — cada módulo alimenta o próximo em tempo real</p>
    </div>
    <div class="flow-diagram reveal" data-d="3" role="img" aria-label="Fluxo: Garçom registra pedido, Cozinha recebe, Estoque debita, Caixa fecha conta, Administrativo analisa">
      <div class="fnode"><div class="fnc gc"><svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg></div><div class="fn-label">Garçom</div><div class="fn-sub">Registra pedido</div></div>
      <div class="farrow" aria-hidden="true"><svg viewBox="0 0 34 14"><path d="M0 7h27M21 1.5l6 5.5-6 5.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
      <div class="fnode"><div class="fnc cz"><svg viewBox="0 0 24 24"><path d="M8 3v6M12 3v4M16 3v6"/><rect x="5" y="9" width="14" height="4" rx="1"/></svg></div><div class="fn-label">Cozinha</div><div class="fn-sub">Recebe na tela</div></div>
      <div class="farrow" aria-hidden="true"><svg viewBox="0 0 34 14"><path d="M0 7h27M21 1.5l6 5.5-6 5.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
      <div class="fnode"><div class="fnc es"><svg viewBox="0 0 24 24"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><line x1="12" y1="22" x2="12" y2="12"/></svg></div><div class="fn-label">Estoque</div><div class="fn-sub">Débito automático</div></div>
      <div class="farrow" aria-hidden="true"><svg viewBox="0 0 34 14"><path d="M0 7h27M21 1.5l6 5.5-6 5.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
      <div class="fnode"><div class="fnc cx"><svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg></div><div class="fn-label">Caixa</div><div class="fn-sub">Fecha a conta</div></div>
      <div class="farrow" aria-hidden="true"><svg viewBox="0 0 34 14"><path d="M0 7h27M21 1.5l6 5.5-6 5.5" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
      <div class="fnode"><div class="fnc adm"><svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div><div class="fn-label">Administrativo</div><div class="fn-sub">Analisa tudo</div></div>
    </div>
  </div>
</section>

<!-- COZINHA -->
<section class="mod-sec dark" id="cozinha">
  <div class="container">
    <div class="mgrid">
      <div class="reveal">
        <div class="mbadge" style="color:var(--cz);background:var(--cz-d);border-color:var(--cz-m)">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v6M12 3v4M16 3v6"/><rect x="5" y="9" width="14" height="4" rx="1"/></svg> Módulo 01
        </div>
        <h2 class="mtitle">Módulo <span style="color:var(--cz)">Cozinha</span></h2>
        <p class="mdesc">KDS (Kitchen Display System) que exibe pedidos em tempo real eliminando comandas de papel. Cronômetros de preparo por ticket mantêm o ritmo mesmo no pico do serviço, com alertas visuais e sonoros para pedidos críticos.</p>
        <div class="mwho"><svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg> Usado por: chefe, cozinheiros, expedidor</div>
        <ul class="feat-list">
          <li class="feat"><div class="fcheck" style="background:var(--cz-d);border:1px solid var(--cz-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Fila de pedidos em tempo real com prioridade visual por cor</li>
          <li class="feat"><div class="fcheck" style="background:var(--cz-d);border:1px solid var(--cz-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Cronômetro por ticket — verde, amarelo e vermelho por urgência</li>
          <li class="feat"><div class="fcheck" style="background:var(--cz-d);border:1px solid var(--cz-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Bump bar digital — marque pronto com um toque</li>
          <li class="feat"><div class="fcheck" style="background:var(--cz-d);border:1px solid var(--cz-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Alertas sonoros e visuais para pedidos críticos</li>
          <li class="feat"><div class="fcheck" style="background:var(--cz-d);border:1px solid var(--cz-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Integração direta com o Garçom — sem digitação dupla</li>
          <li class="feat"><div class="fcheck" style="background:var(--cz-d);border:1px solid var(--cz-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Relatório de tempo médio de preparo por prato</li>
        </ul>
        <div class="mstats">
          <div class="ms"><div class="msv" style="color:var(--cz)">-64%</div><div class="msl">Erros de pedido</div></div>
          <div class="ms"><div class="msv" style="color:var(--cz)">8min</div><div class="msl">Redução no preparo</div></div>
          <div class="ms"><div class="msv" style="color:var(--cz)">0</div><div class="msl">Papel na cozinha</div></div>
        </div>
      </div>
      <div class="reveal" data-d="2">
        <div class="mframe">
          <div class="mfbar"><i></i><i style="background:#22335f"></i><i style="background:#22335f"></i><span class="mftitle">KDS · Cozinha Principal</span></div>
          <div class="mfbody">
            <div class="kds-bar"><div class="klive"><i></i>AO VIVO</div><span>7 pedidos · 2 urgentes</span></div>
            <div class="kds-grid">
              <div class="kticket n"><div class="kth"><span class="ktbl">Mesa 4</span><span class="ktimer n">02:14</span></div><ul class="kitems"><li class="kitem">2× Filé ao molho</li><li class="kitem">1× Frango grelhado</li><li class="kitem">1× Risoto funghi</li></ul><button class="kbump" onclick="bumpTicket(this)">MARCAR PRONTO &#8593;</button></div>
              <div class="kticket w"><div class="kth"><span class="ktbl">Mesa 9</span><span class="ktimer w">07:45</span></div><ul class="kitems"><li class="kitem">1× Pizza Margherita</li><li class="kitem">2× Salada César</li></ul><button class="kbump" onclick="bumpTicket(this)">MARCAR PRONTO &#8593;</button></div>
              <div class="kticket c"><div class="kth"><span class="ktbl">Mesa 2</span><span class="ktimer c">12:08</span></div><ul class="kitems"><li class="kitem">3× Costela assada</li><li class="kitem">1× Massa bolonhesa</li></ul><button class="kbump" onclick="bumpTicket(this)">MARCAR PRONTO &#8593;</button></div>
              <div class="kticket n"><div class="kth"><span class="ktbl">Mesa 7</span><span class="ktimer n">00:48</span></div><ul class="kitems"><li class="kitem">2× Salmão grelhado</li><li class="kitem">1× Ceviche</li></ul><button class="kbump" onclick="bumpTicket(this)">MARCAR PRONTO &#8593;</button></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- GARCOM -->
<section class="mod-sec" id="garcom">
  <div class="container">
    <div class="mgrid rev">
      <div class="reveal" data-d="1">
        <div class="mframe">
          <div class="mfbar"><i></i><i style="background:#22335f"></i><i style="background:#22335f"></i><span class="mftitle">App Garçom · Salão</span></div>
          <div class="mfbody">
            <div class="sth"><div class="stitle">Mapa do Salão</div><div class="stalert"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>Mesa 2 aguarda</div></div>
            <div class="tmap">
              <div class="ttable occ">2<span class="tts">45min</span></div>
              <div class="ttable free">3<span class="tts">livre</span></div>
              <div class="ttable occ">4<span class="tts">18min</span></div>
              <div class="ttable attn">5<span class="tts">chamar</span></div>
              <div class="ttable free">6<span class="tts">livre</span></div>
              <div class="ttable occ">7<span class="tts">22min</span></div>
              <div class="ttable free">8<span class="tts">livre</span></div>
              <div class="ttable occ">9<span class="tts">35min</span></div>
            </div>
            <div class="tleg"><div class="tli"><div class="tdot f"></div>Livre</div><div class="tli"><div class="tdot o"></div>Ocupada</div><div class="tli"><div class="tdot a"></div>Atenção</div></div>
            <div class="oq">
              <div class="oqt">Novo pedido · Mesa 4</div>
              <div class="oqcats"><div class="oqcat on">Pratos</div><div class="oqcat">Bebidas</div><div class="oqcat">Sobremesas</div></div>
              <div class="oqitems"><div class="oqi">+ Filé ao molho</div><div class="oqi">+ Frango grelhado</div><div class="oqi">+ Risoto funghi</div><div class="oqi">+ Salmão grelhado</div></div>
            </div>
          </div>
        </div>
      </div>
      <div class="reveal" data-d="2">
        <div class="mbadge" style="color:var(--gc);background:var(--gc-d);border-color:var(--gc-m)">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg> Módulo 02
        </div>
        <h2 class="mtitle">Módulo <span style="color:var(--gc)">Garçom</span></h2>
        <p class="mdesc">App para tablet ou smartphone com mapa do salão, registro de pedidos e notificação quando o prato fica pronto. O pedido chega na cozinha em menos de 1 segundo — sem deslocamento até o balcão. Funciona offline.</p>
        <div class="mwho"><svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg> Usado por: garçons, maîtres, hostess</div>
        <ul class="feat-list">
          <li class="feat"><div class="fcheck" style="background:var(--gc-d);border:1px solid var(--gc-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Mapa visual do salão com status em tempo real por mesa</li>
          <li class="feat"><div class="fcheck" style="background:var(--gc-d);border:1px solid var(--gc-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Pedidos por categorias com foto dos pratos e observações</li>
          <li class="feat"><div class="fcheck" style="background:var(--gc-d);border:1px solid var(--gc-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Alerta quando pedido da cozinha está pronto para servir</li>
          <li class="feat"><div class="fcheck" style="background:var(--gc-d);border:1px solid var(--gc-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Transferência de mesa e divisão de conta no próprio app</li>
          <li class="feat"><div class="fcheck" style="background:var(--gc-d);border:1px solid var(--gc-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Funciona offline — sincroniza quando a conexão volta</li>
          <li class="feat"><div class="fcheck" style="background:var(--gc-d);border:1px solid var(--gc-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Compatível com Android, iOS e navegador web</li>
        </ul>
        <div class="mstats">
          <div class="ms"><div class="msv" style="color:var(--gc)">&lt;1s</div><div class="msl">Pedido na cozinha</div></div>
          <div class="ms"><div class="msv" style="color:var(--gc)">+28%</div><div class="msl">Giro de mesa</div></div>
          <div class="ms"><div class="msv" style="color:var(--gc)">0</div><div class="msl">Comandas de papel</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ESTOQUE -->
<section class="mod-sec dark" id="estoque">
  <div class="container">
    <div class="mgrid">
      <div class="reveal">
        <div class="mbadge" style="color:var(--es);background:var(--es-d);border-color:var(--es-m)">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg> Módulo 03
        </div>
        <h2 class="mtitle">Módulo <span style="color:var(--es)">Estoque</span></h2>
        <p class="mdesc">Controle inteligente de insumos com débito automático a cada prato vendido. Alerta quando item atinge o nível mínimo e gera ordens de compra sugeridas com base no consumo histórico. Chega de descobrir que o ingrediente acabou depois de vender o prato.</p>
        <div class="mwho"><svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg> Usado por: gerentes de compras, responsáveis de estoque, sócios</div>
        <ul class="feat-list">
          <li class="feat"><div class="fcheck" style="background:var(--es-d);border:1px solid var(--es-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Débito automático de insumos a cada venda confirmada</li>
          <li class="feat"><div class="fcheck" style="background:var(--es-d);border:1px solid var(--es-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Alertas de nível crítico com sugestão de compra automática</li>
          <li class="feat"><div class="fcheck" style="background:var(--es-d);border:1px solid var(--es-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Ficha técnica por prato — custo real calculado em tempo real</li>
          <li class="feat"><div class="fcheck" style="background:var(--es-d);border:1px solid var(--es-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Cadastro de fornecedores com histórico de preços e prazos</li>
          <li class="feat"><div class="fcheck" style="background:var(--es-d);border:1px solid var(--es-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Inventário com contagem parcial ou geral assistida</li>
          <li class="feat"><div class="fcheck" style="background:var(--es-d);border:1px solid var(--es-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Relatório de desperdício e variação de consumo por período</li>
        </ul>
        <div class="mstats">
          <div class="ms"><div class="msv" style="color:var(--es)">-31%</div><div class="msl">Desperdício</div></div>
          <div class="ms"><div class="msv" style="color:var(--es)">100%</div><div class="msl">Visibilidade de custo</div></div>
          <div class="ms"><div class="msv" style="color:var(--es)">auto</div><div class="msl">Débito por venda</div></div>
        </div>
      </div>
      <div class="reveal" data-d="2">
        <div class="mframe">
          <div class="mfbar"><i></i><i style="background:#22335f"></i><i style="background:#22335f"></i><span class="mftitle">Estoque · Controle de Insumos</span></div>
          <div class="mfbody">
            <div class="sth"><div class="stitle">Insumos cadastrados</div><div class="stalert"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/></svg>3 críticos</div></div>
            <div class="stlist">
              <div class="sti"><div class="sin">Filé Mignon (kg)</div><div class="sibar"><div class="sifill ok" style="width:72%"></div></div><div class="siq ok">7,2 kg</div></div>
              <div class="sti"><div class="sin">Salmão (kg)</div><div class="sibar"><div class="sifill low" style="width:28%"></div></div><div class="siq low">1,4 kg</div></div>
              <div class="sti"><div class="sin">Farinha de trigo (kg)</div><div class="sibar"><div class="sifill ok" style="width:85%"></div></div><div class="siq ok">17 kg</div></div>
              <div class="sti"><div class="sin">Funghi seco (g)</div><div class="sibar"><div class="sifill crit" style="width:9%"></div></div><div class="siq crit">90 g &#9888;</div></div>
              <div class="sti"><div class="sin">Azeite extra virgem (L)</div><div class="sibar"><div class="sifill low" style="width:35%"></div></div><div class="siq low">1,7 L</div></div>
              <div class="sti"><div class="sin">Arroz arbóreo (kg)</div><div class="sibar"><div class="sifill ok" style="width:60%"></div></div><div class="siq ok">6 kg</div></div>
            </div>
            <div class="autodebit"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>Débito automático ativo · última baixa há 2min</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CAIXA -->
<section class="mod-sec" id="caixa">
  <div class="container">
    <div class="mgrid rev">
      <div class="reveal" data-d="1">
        <div class="mframe">
          <div class="mfbar"><i></i><i style="background:#22335f"></i><i style="background:#22335f"></i><span class="mftitle">Caixa · Mesa 4 · Fechar conta</span></div>
          <div class="mfbody">
            <div class="blist">
              <div class="bitem"><span class="bname">Filé ao molho</span><span class="bqty">×2</span><span class="bval">R$ 119,80</span></div>
              <div class="bitem"><span class="bname">Frango grelhado</span><span class="bqty">×1</span><span class="bval">R$ 48,90</span></div>
              <div class="bitem"><span class="bname">Risoto funghi</span><span class="bqty">×1</span><span class="bval">R$ 62,00</span></div>
              <div class="bitem"><span class="bname">Cerveja artesanal</span><span class="bqty">×4</span><span class="bval">R$ 71,60</span></div>
              <div class="bitem"><span class="bname">Água mineral</span><span class="bqty">×2</span><span class="bval">R$ 14,00</span></div>
              <div class="bitem" style="color:#7d94c2"><span class="bname">Couvert artístico</span><span class="bqty">×4</span><span class="bval">R$ 36,00</span></div>
            </div>
            <div class="btotal"><span class="btlbl">Total (4 pessoas)</span><span class="btval">R$ 352,30</span></div>
            <div class="pmethods">
              <div class="pm pix on">PIX</div>
              <div class="pm card">CARTÃO</div>
              <div class="pm cash">DINHEIRO</div>
            </div>
            <div class="splitbtn">Dividir em 4 × R$ 88,08</div>
          </div>
        </div>
      </div>
      <div class="reveal" data-d="2">
        <div class="mbadge" style="color:var(--cx);background:var(--cx-d);border-color:var(--cx-m)">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg> Módulo 04
        </div>
        <h2 class="mtitle">Módulo <span style="color:var(--cx)">Caixa</span></h2>
        <p class="mdesc">Fechamento de conta em menos de 30 segundos. A conta já chega montada com todos os itens do pedido. Aceita PIX, cartão e dinheiro na mesma conta, divide entre comensais e emite cupom fiscal integrado.</p>
        <div class="mwho"><svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg> Usado por: caixas, gerentes, operadores de frente</div>
        <ul class="feat-list">
          <li class="feat"><div class="fcheck" style="background:var(--cx-d);border:1px solid var(--cx-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Conta montada automaticamente a partir dos pedidos do garçom</li>
          <li class="feat"><div class="fcheck" style="background:var(--cx-d);border:1px solid var(--cx-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>PIX, cartão de crédito/débito e dinheiro na mesma conta</li>
          <li class="feat"><div class="fcheck" style="background:var(--cx-d);border:1px solid var(--cx-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Divisão de conta por número de pessoas ou por item</li>
          <li class="feat"><div class="fcheck" style="background:var(--cx-d);border:1px solid var(--cx-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Descontos, promoções e programa de fidelidade integrado</li>
          <li class="feat"><div class="fcheck" style="background:var(--cx-d);border:1px solid var(--cx-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Emissão de NFC-e e cupom fiscal integrado</li>
          <li class="feat"><div class="fcheck" style="background:var(--cx-d);border:1px solid var(--cx-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Fechamento de caixa com conferência automática de valores</li>
        </ul>
        <div class="mstats">
          <div class="ms"><div class="msv" style="color:var(--cx)">&lt;30s</div><div class="msl">Fechamento de conta</div></div>
          <div class="ms"><div class="msv" style="color:var(--cx)">3</div><div class="msl">Formas de pagamento</div></div>
          <div class="ms"><div class="msv" style="color:var(--cx)">100%</div><div class="msl">Sem erro de conta</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ADMINISTRATIVO -->
<section class="mod-sec dark" id="administrativo">
  <div class="container">
    <div class="mgrid">
      <div class="reveal">
        <div class="mbadge" style="color:var(--adm);background:var(--adm-d);border-color:var(--adm-m)">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg> Módulo 05
        </div>
        <h2 class="mtitle">Módulo <span style="color:var(--adm)">Administrativo</span></h2>
        <p class="mdesc">Dashboard executivo que consolida dados de todos os módulos em tempo real. Faturamento, ticket médio, CMV, coberturas e alertas de performance — tudo em uma tela, acessível de qualquer dispositivo, a qualquer hora.</p>
        <div class="mwho"><svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg> Usado por: proprietários, sócios, diretores, contadores</div>
        <ul class="feat-list">
          <li class="feat"><div class="fcheck" style="background:var(--adm-d);border:1px solid var(--adm-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Dashboard em tempo real com KPIs de faturamento e cobertura</li>
          <li class="feat"><div class="fcheck" style="background:var(--adm-d);border:1px solid var(--adm-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Ranking de pratos por margem de contribuição, não só volume</li>
          <li class="feat"><div class="fcheck" style="background:var(--adm-d);border:1px solid var(--adm-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>DRE automatizado com custos de insumos do módulo Estoque</li>
          <li class="feat"><div class="fcheck" style="background:var(--adm-d);border:1px solid var(--adm-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Comparativo por período — dia, semana, mês, ano</li>
          <li class="feat"><div class="fcheck" style="background:var(--adm-d);border:1px solid var(--adm-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Relatórios exportáveis em PDF e CSV para contabilidade</li>
          <li class="feat"><div class="fcheck" style="background:var(--adm-d);border:1px solid var(--adm-m)"><svg viewBox="0 0 10 10"><polyline points="1.5 5 4 7.5 8.5 2.5"/></svg></div>Alertas inteligentes — estoque crítico, metas e anomalias</li>
        </ul>
        <div class="mstats">
          <div class="ms"><div class="msv" style="color:var(--adm)">360°</div><div class="msl">Visão do negócio</div></div>
          <div class="ms"><div class="msv" style="color:var(--adm)">real</div><div class="msl">Dados em tempo real</div></div>
          <div class="ms"><div class="msv" style="color:var(--adm)">+18%</div><div class="msl">Margem média</div></div>
        </div>
      </div>
      <div class="reveal" data-d="2">
        <div class="mframe">
          <div class="mfbar"><i></i><i style="background:#22335f"></i><i style="background:#22335f"></i><span class="mftitle">Administrativo · Dashboard</span></div>
          <div class="mfbody">
            <div class="adkpis">
              <div class="adkpi"><div class="kl">Faturamento hoje</div><div class="kv">R$&nbsp;4.820</div><div class="kd up">&#8593; +12%</div></div>
              <div class="adkpi"><div class="kl">Ticket médio</div><div class="kv">R$&nbsp;87,60</div><div class="kd up">&#8593; +5%</div></div>
              <div class="adkpi"><div class="kl">Coberturas</div><div class="kv">55</div><div class="kd dn">&#8595; -3 meta</div></div>
            </div>
            <div class="adcharts">
              <div class="ac">
                <div class="act">Faturamento semanal <span class="actag">R$</span></div>
                <div class="mbars">
                  <b style="height:45%"></b><b style="height:62%"></b><b style="height:38%"></b>
                  <b style="height:80%"></b><b style="height:55%"></b><b style="height:91%"></b>
                  <b style="height:70%"></b>
                </div>
                <div style="display:flex;gap:4px;margin-top:5px">
                  <span style="flex:1;text-align:center;font-family:var(--font-mono);font-size:.51rem;color:#5f7bb0">Seg</span>
                  <span style="flex:1;text-align:center;font-family:var(--font-mono);font-size:.51rem;color:#5f7bb0">Ter</span>
                  <span style="flex:1;text-align:center;font-family:var(--font-mono);font-size:.51rem;color:#5f7bb0">Qua</span>
                  <span style="flex:1;text-align:center;font-family:var(--font-mono);font-size:.51rem;color:#5f7bb0">Qui</span>
                  <span style="flex:1;text-align:center;font-family:var(--font-mono);font-size:.51rem;color:#5f7bb0">Sex</span>
                  <span style="flex:1;text-align:center;font-family:var(--font-mono);font-size:.51rem;color:#5f7bb0">Sab</span>
                  <span style="flex:1;text-align:center;font-family:var(--font-mono);font-size:.51rem;color:#3d8bff">Dom</span>
                </div>
              </div>
              <div class="ac">
                <div class="act">Top pratos</div>
                <div class="tdishes">
                  <div class="tditem"><span class="tdpos">01</span><span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.66rem">Filé ao molho</span><div class="tdbw"><div class="tdb" style="width:95%"></div></div></div>
                  <div class="tditem"><span class="tdpos">02</span><span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.66rem">Salmão grelhado</span><div class="tdbw"><div class="tdb" style="width:78%;animation-delay:.1s"></div></div></div>
                  <div class="tditem"><span class="tdpos">03</span><span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.66rem">Risoto funghi</span><div class="tdbw"><div class="tdb" style="width:64%;animation-delay:.2s"></div></div></div>
                  <div class="tditem"><span class="tdpos">04</span><span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.66rem">Pizza Margherita</span><div class="tdbw"><div class="tdb" style="width:51%;animation-delay:.3s"></div></div></div>
                  <div class="tditem"><span class="tdpos">05</span><span style="flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.66rem">Costela assada</span><div class="tdbw"><div class="tdb" style="width:40%;animation-delay:.4s"></div></div></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MATRIX -->
<section class="matrix-sec">
  <div class="container">
    <div class="eyebrow reveal" style="justify-content:center">Integração entre módulos</div>
    <h2 class="section-title reveal" data-d="1" style="text-align:center">Todos falam entre si</h2>
    <p class="section-sub reveal" data-d="2" style="text-align:center;margin:0 auto">Nenhum módulo trabalha isolado. Cada ação atualiza os demais em tempo real.</p>
    <div class="mwrap reveal" data-d="3">
      <table class="mtable" role="table" aria-label="Matriz de integração">
        <thead><tr>
          <th scope="col">Módulo</th>
          <th scope="col" style="color:var(--cz)">Cozinha</th>
          <th scope="col" style="color:var(--gc)">Garçom</th>
          <th scope="col" style="color:var(--es)">Estoque</th>
          <th scope="col" style="color:var(--cx)">Caixa</th>
          <th scope="col" style="color:var(--adm)">Adm.</th>
        </tr></thead>
        <tbody>
          <tr><td><div class="mrh"><div class="mhdot" style="background:var(--cz)"></div>Cozinha</div></td><td><div class="mcheck"><span class="partial"></span></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><svg class="no" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td></tr>
          <tr><td><div class="mrh"><div class="mhdot" style="background:var(--gc)"></div>Garçom</div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><span class="partial"></span></div></td><td><div class="mcheck"><svg class="no" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td></tr>
          <tr><td><div class="mrh"><div class="mhdot" style="background:var(--es)"></div>Estoque</div></td><td><div class="mcheck"><svg class="no" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><span class="partial"></span></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td></tr>
          <tr><td><div class="mrh"><div class="mhdot" style="background:var(--cx)"></div>Caixa</div></td><td><div class="mcheck"><svg class="no" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><svg class="no" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></div></td><td><div class="mcheck"><span class="partial"></span></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td></tr>
          <tr><td><div class="mrh"><div class="mhdot" style="background:var(--adm)"></div>Administrativo</div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><svg class="yes" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div></td><td><div class="mcheck"><span class="partial"></span></div></td></tr>
        </tbody>
      </table>
    </div>
    <p style="text-align:center;margin-top:14px;font-family:var(--font-mono);font-size:.68rem;color:var(--grey-mid)">
      <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="var(--blue-l)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:4px"><polyline points="20 6 9 17 4 12"/></svg> Integração direta &nbsp;&#183;&nbsp;
      <span style="display:inline-block;width:14px;height:3px;background:rgba(139,177,255,.28);border-radius:2px;vertical-align:middle;margin-right:4px"></span> Próprio módulo
    </p>
  </div>
</section>

<!-- CTA -->
<section class="cta-sec" id="contato">
  <div class="cta-glow" aria-hidden="true"></div>
  <div class="container" style="position:relative;z-index:2">
    <div class="eyebrow reveal" style="justify-content:center">Pronto para começar?</div>
    <h2 class="reveal" data-d="1">Ative os módulos que<br>sua operação precisa.</h2>
    <p class="reveal" data-d="2">Implantação em dias, não meses. Comece com um módulo e expanda conforme crescer. Sem taxa de adesão nos primeiros 3 meses.</p>
    <div class="cta-btns reveal" data-d="3">
      <a href="mailto:contato@modulozero.com.br" class="btn btn-primary">Agendar demonstração <span class="arrow">&#8594;</span></a>
      <a href="modulo-zero.html" class="btn btn-ghost">&#8592; Voltar ao início</a>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="container">
    <div class="frow">
      <a href="modulo-zero.html" class="fback"><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>Módulo Zero · Voltar ao início</a>
      <span class="mono">&#169; 2026 Módulo Zero · Software house · SENAC PG</span>
    </div>
  </div>
</footer>

<script>
/* HEADER */
const hdr = document.getElementById('hdr');
window.addEventListener('scroll', () => hdr.classList.toggle('scrolled', scrollY > 24), {passive:true});

/* MOBILE NAV */
const mToggle = document.getElementById('mToggle');
const navLinks = document.getElementById('navLinks');
mToggle.addEventListener('click', () => {
  const o = navLinks.classList.toggle('open');
  mToggle.setAttribute('aria-expanded', o);
});
navLinks.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
  navLinks.classList.remove('open');
  mToggle.setAttribute('aria-expanded', 'false');
}));

/* SCROLL REVEAL */
const reduced = window.matchMedia('(prefers-reduced-motion:reduce)').matches;
const io = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }});
}, {threshold:.1, rootMargin:'0px 0px -40px 0px'});
document.querySelectorAll('.reveal').forEach(el => reduced ? el.classList.add('in') : io.observe(el));

/* TABS active on scroll */
const tabs = document.querySelectorAll('.tab');
const secs = ['cozinha','garcom','estoque','caixa','administrativo'].map(id => document.getElementById(id));
const navH = () => parseInt(getComputedStyle(document.documentElement).getPropertyValue('--nav-h'))||76;
const tabH = () => parseInt(getComputedStyle(document.documentElement).getPropertyValue('--tabs-h'))||58;

function setTab(id) {
  tabs.forEach(t => t.classList.toggle('on', t.dataset.s === id));
  const at = document.querySelector('.tab[data-s="' + id + '"]');
  if (at) at.scrollIntoView({behavior:'smooth',block:'nearest',inline:'center'});
}

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    const el = document.getElementById(tab.dataset.s);
    if (el) { const y = el.getBoundingClientRect().top + scrollY - navH() - tabH(); window.scrollTo({top:y,behavior:'smooth'}); }
  });
});

const so = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) setTab(e.target.id); });
}, {rootMargin: `-${navH() + tabH()}px 0px -55% 0px`, threshold:0});
secs.forEach(s => s && so.observe(s));

/* KDS BUMP */
function bumpTicket(btn) {
  const t = btn.closest('.kticket');
  t.style.cssText += 'opacity:0;transform:scale(.93);transition:opacity .4s,transform .4s';
  setTimeout(() => t.remove(), 420);
}

/* PAYMENT METHODS */
document.querySelectorAll('.pmethods').forEach(g => {
  g.querySelectorAll('.pm').forEach(pm => {
    pm.addEventListener('click', () => {
      g.querySelectorAll('.pm').forEach(p => p.classList.remove('on'));
      pm.classList.add('on');
    });
  });
});

/* GARCOM CATEGORY TABS */
document.querySelectorAll('.oqcats').forEach(g => {
  g.querySelectorAll('.oqcat').forEach(c => {
    c.addEventListener('click', () => {
      g.querySelectorAll('.oqcat').forEach(x => x.classList.remove('on'));
      c.classList.add('on');
    });
  });
});
</script>
</body>
</html>