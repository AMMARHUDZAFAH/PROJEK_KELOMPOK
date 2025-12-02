document.addEventListener("DOMContentLoaded", function() {
    
    // --- 1. ANIMASI PRODUK MUNCUL BERGANTIAN ---
    const products = document.querySelectorAll('.product-card-anim');
    
    if (products.length > 0) {
        products.forEach((product, index) => {
            // Set delay: produk pertama 100ms, kedua 200ms, dst.
            setTimeout(() => {
                product.classList.add('show');
            }, index * 100); 
        });
    }
    // --- 3. DARK MODE LOGIC ---
document.addEventListener("DOMContentLoaded", function() {
    const htmlRoot = document.getElementById('htmlRoot');
    const toggleBtn = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    
    // Cek apakah user pernah simpan preferensi
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Terapkan tema saat web dibuka
    applyTheme(currentTheme);
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            // Cek tema sekarang apa?
            const theme = htmlRoot.getAttribute('data-bs-theme');
            // Tukar
            const newTheme = theme === 'light' ? 'dark' : 'light';
            
            applyTheme(newTheme);
            // Simpan ke memori browser
            localStorage.setItem('theme', newTheme);
        });
    }

    function applyTheme(theme) {
        // Ubah atribut HTML (ini yang bikin bootstrap berubah otomatis)
        htmlRoot.setAttribute('data-bs-theme', theme);
        
        // Ubah Ikon
        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.classList.remove('bi-moon-fill');
                themeIcon.classList.add('bi-sun-fill'); // Jadi matahari
            } else {
                themeIcon.classList.remove('bi-sun-fill');
                themeIcon.classList.add('bi-moon-fill'); // Jadi bulan
            }
        }
    }
});
});

document.addEventListener('DOMContentLoaded', function(){

    // 1. SETUP ELEMENT BACKGROUND (Jika belum ada, buat otomatis)
    // Ini jaga-jaga kalau lupa pasang div di HTML
    let bgCheck = document.querySelector('.page-bg');
    if(!bgCheck) {
        console.warn("Background wrapper .page-bg tidak ditemukan di layout!");
    }

    // 2. STARS ANIMATION
    var pageStarsWrap = document.querySelector('.page-stars');
    if(pageStarsWrap) {
        var pageStarCount = 40; // Jumlah bintang
        for (var j = 0; j < pageStarCount; j++) {
            var s = document.createElement('span');
            s.className = 'star';
            s.style.left = Math.random() * 100 + '%';
            s.style.top = Math.random() * 100 + '%';
            s.style.opacity = Math.random() * 0.9;
            s.style.transform = 'scale(' + (Math.random()*1.5+0.4) + ')';
            pageStarsWrap.appendChild(s);
        }
    }

    // 3. COMET ANIMATION
    const comet = document.querySelector('.comet');
    if(comet) {
        function summonComet() {
            if(document.body.classList.contains('day-mode')) {
                setTimeout(summonComet, 5000); 
                return; 
            }
            let delay = Math.random() * 5000 + 5000; 
            comet.style.animation = 'none';
            void comet.offsetWidth;
            comet.style.animation = `cometFly 3s ease-out`;
            setTimeout(summonComet, delay);
        }
        summonComet();
    }

    // 4. CLOUD ANIMATION
    const cloudLayer = document.querySelector('.cloud-layer');
    if(cloudLayer) {
        function createCloud() {
            let cloud = document.createElement('div');
            cloud.className = 'cloud';
            let size = Math.random()*80 + 70; 
            cloud.style.width = size + 'px';
            cloud.style.height = (size*0.6) + 'px';
            cloud.style.top = Math.random()*40 + '%';
            cloud.style.left = '-200px';
            cloud.style.animation = `cloudMove ${20 + Math.random()*25}s linear infinite`;
            cloudLayer.appendChild(cloud);
            setTimeout(()=>cloud.remove(), 45000); // Hapus awan lama biar memori gak penuh
        }
        function cloudLoop() {
            if (document.body.classList.contains('day-mode')) {
                createCloud();
            }
            setTimeout(cloudLoop, 3000);
        }
        cloudLoop();
    }

    // 5. TOGGLE LOGIC (Global)
    const toggleBtn = document.getElementById('modeToggle');
    const toggleIcon = document.getElementById('toggleIcon'); // Kita kasih ID ke iconnya
    
    // Cek LocalStorage saat load
    if (localStorage.getItem('mode') === 'day') {
        document.body.classList.add('day-mode');
        if(toggleIcon) toggleIcon.innerText = "🌞"; // Matahari
    }

    if(toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            document.body.classList.toggle('day-mode');
            
            if (document.body.classList.contains('day-mode')) {
                if(toggleIcon) toggleIcon.innerText = "🌞";
                localStorage.setItem('mode','day');
            } else {
                if(toggleIcon) toggleIcon.innerText = "🌙";
                localStorage.setItem('mode','night');
            }
        });
    }

    // --- 6. DRAGGABLE TOGGLE BUTTON (Fitur Baru) ---
    const dragItem = document.getElementById("modeToggleWrapper");
    let active = false;
    let currentX;
    let currentY;
    let initialX;
    let initialY;
    let xOffset = 0;
    let yOffset = 0;

    if (dragItem) {
        dragItem.addEventListener("mousedown", dragStart, false);
        dragItem.addEventListener("mouseup", dragEnd, false);
        dragItem.addEventListener("mousemove", drag, false);

        // Support Touchscreen (HP)
        dragItem.addEventListener("touchstart", dragStart, false);
        dragItem.addEventListener("touchend", dragEnd, false);
        dragItem.addEventListener("touchmove", drag, false);
    }

    function dragStart(e) {
        if (e.type === "touchstart") {
            initialX = e.touches[0].clientX - xOffset;
            initialY = e.touches[0].clientY - yOffset;
        } else {
            initialX = e.clientX - xOffset;
            initialY = e.clientY - yOffset;
        }

        if (e.target === dragItem || dragItem.contains(e.target)) {
            active = true;
        }
    }

    function dragEnd(e) {
        initialX = currentX;
        initialY = currentY;
        active = false;
    }

    function drag(e) {
        if (active) {
            e.preventDefault();
        
            if (e.type === "touchmove") {
                currentX = e.touches[0].clientX - initialX;
                currentY = e.touches[0].clientY - initialY;
            } else {
                currentX = e.clientX - initialX;
                currentY = e.clientY - initialY;
            }

            xOffset = currentX;
            yOffset = currentY;

            setTranslate(currentX, currentY, dragItem);
        }
    }

    function setTranslate(xPos, yPos, el) {
        el.style.transform = "translate3d(" + xPos + "px, " + yPos + "px, 0)";
    }
});