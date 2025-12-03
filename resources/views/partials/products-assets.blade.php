<style>
/* CORE LAYOUT */
.page-bg { min-height: 100vh; position: relative; overflow: hidden; transition: background 1s ease; }
.page-bg::before { content: ''; position: absolute; inset: 0; pointer-events: none; z-index: 0; }

/* DEFAULT NIGHT VIEW */
.page-bg { background: linear-gradient(180deg,#001b33 0%, #00264d 40%, #003366 100%); }
.page-bg, .page-bg * { color: #fff !important; }

/* STARS & COMET */
.page-stars .star { position:absolute; width:3px; height:3px; border-radius:50%; background: rgba(255,255,255,0.95); box-shadow:0 0 8px rgba(255,255,255,0.7); transition: opacity 1s; }
.comet { position:absolute; top:-50px; left:-200px; width:4px; height:4px; background:white; border-radius:50%; box-shadow:0 0 10px white, 0 0 20px white; opacity:0; transform: rotate(45deg); z-index:20; }
@keyframes cometFly { 0%{opacity:0; transform:translate(-100px,-100px) scale(.6) rotate(45deg);} 5%{opacity:1;} 40%{transform:translate(800px,600px) scale(1.2) rotate(45deg); opacity:1;} 60%{opacity:0;} 100%{transform:translate(900px,700px) scale(1.2) rotate(45deg);} }

/* CLOUDS */
.cloud-layer { position:absolute; inset:0; z-index:0; pointer-events:none; overflow:hidden; }
.cloud { position:absolute; background: rgba(255,255,255,0.75); filter: blur(10px); border-radius:999px; opacity:.6; }
@keyframes cloudMove { 0%{transform:translateX(-10%);} 100%{transform:translateX(120%);} }

/* HERO */
.products-hero { background: linear-gradient(135deg, #0d6efd 0%, #2b8cff 40%, #7ec8ff 100%); border-radius:14px; padding:1.5rem; box-shadow:0 18px 50px rgba(13,110,253,0.14); color:#fff; overflow:hidden; }
.products-hero .card { background: rgba(255,255,255,0.95); }
.products-stars .star{ position:absolute; top:-10px; width:6px; height:6px; border-radius:50%; background: rgba(255,255,255,0.98); box-shadow: 0 0 12px rgba(13,110,253,0.65); opacity:0.98; mix-blend-mode:screen; }

/* Toggle */
#modeToggle { font-size: 20px; position: fixed; top: 12px; right: 12px; z-index: 999; }

/* Mode badge */
.hero-mode-badge { display:inline-flex; align-items:center; font-size:.9rem; padding:.25rem .6rem; background:rgba(255,255,255,0.06); border-radius:.5rem; border:1px solid rgba(255,255,255,0.04); z-index:3; color: #fff; }
body.day-mode .hero-mode-badge { background: rgba(0,0,0,0.06); border-color: rgba(0,0,0,0.06); color: #000 !important; }

/* Cards */
.hover-top { transition: transform .3s ease, box-shadow .3s ease; }
.hover-top:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

/* Dark-mode override: keep stars bright & text white */
@media (prefers-color-scheme: dark) {
    body, .page-bg { background: linear-gradient(180deg,#05071a 0%, #07122a 45%, #071a2b 100%); color:#fff; }
    .products-hero { background: linear-gradient(135deg, #02102a 0%, #022444 50%, #083057 100%); box-shadow:0 22px 64px rgba(3,18,45,0.6); }
    .products-hero .card { background: rgba(255,255,255,0.04); color: #fff; border: 1px solid rgba(255,255,255,0.04); }
}

/* Day-mode override via toggle */
body.day-mode .page-bg { background: linear-gradient(180deg,#bfe8ff 0%, #e9f7ff 40%, #ffffff 100%); }
/* Day-mode overrides (strong) to ensure toggle wins over system prefs */
body.day-mode, body.day-mode .page-bg { background: linear-gradient(180deg,#bfe8ff 0%, #e9f7ff 40%, #ffffff 100%) !important; }
body.day-mode .page-bg, body.day-mode .page-bg * { color: #000 !important; }
body.day-mode .page-bg::before { background: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.5), transparent 40%), radial-gradient(circle at 80% 70%, rgba(255,255,255,0.4), transparent 40%); }
body.day-mode .page-stars .star { opacity: 0; }
body.day-mode .comet { opacity:0 !important; }
body.day-mode .products-hero { background: linear-gradient(135deg,#4dabff 0%, #74c0ff 40%, #a5d8ff 100%); }

</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
    // Create stars
    var pageStarsWrap = document.querySelector('.page-stars');
    if(pageStarsWrap){
        var pageStarCount = 30; for(var j=0;j<pageStarCount;j++){var s = document.createElement('span'); s.className='star'; s.style.left=Math.random()*100+'%'; s.style.top = Math.random()*100+'%'; s.style.opacity = Math.random()*0.9; s.style.transform = 'scale('+ (Math.random()*1.5+0.4) +')'; pageStarsWrap.appendChild(s); }
    }

    // comet
    const comet = document.querySelector('.comet');
    function summonComet(){ if(!comet) return; let delay = Math.random()*5000 + 5000; comet.style.animation='none'; void comet.offsetWidth; comet.style.animation=`cometFly 3s ease-out`; setTimeout(summonComet, delay); }
    summonComet();

    // clouds
    const cloudLayer = document.querySelector('.cloud-layer');
    function createCloud(){ if(!cloudLayer) return; let cloud = document.createElement('div'); cloud.className='cloud'; let size = Math.random()*80 +70; cloud.style.width = size+'px'; cloud.style.height = (size*0.6)+'px'; cloud.style.top = Math.random()*40+'%'; cloud.style.left = '-200px'; cloud.style.animation = `cloudMove ${20 + Math.random()*25}s linear infinite`; cloudLayer.appendChild(cloud); setTimeout(()=>cloud.remove(), 30000);} 
    function cloudLoop(){ if(document.body.classList.contains('day-mode')){ createCloud(); } setTimeout(cloudLoop, 3000); }
    cloudLoop();

    // Mode toggle & badge update
    const toggleBtn = document.getElementById('modeToggle');
    var modeBadge = document.querySelector('.hero-mode-badge');
    if(localStorage.getItem('mode') === 'day'){ document.body.classList.add('day-mode'); toggleBtn.innerHTML = '🌚'; }
    function updateModeBadge(){ if(!modeBadge) return; if(document.body.classList.contains('day-mode')){ modeBadge.textContent = 'Mode Siang Aktif'; }else{ modeBadge.textContent = 'Mode Malam Aktif'; } }
    updateModeBadge();
    toggleBtn.addEventListener('click', () => { document.body.classList.toggle('day-mode'); if(document.body.classList.contains('day-mode')){ toggleBtn.innerHTML='🌚'; localStorage.setItem('mode','day'); } else { toggleBtn.innerHTML='🌙'; localStorage.setItem('mode','night'); } updateModeBadge(); });

});
</script>
