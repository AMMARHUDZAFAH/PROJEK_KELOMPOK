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

    // --- 2. ANIMASI 3D TILT LOGIN CARD ---
    const loginCard = document.querySelector('.login-card');
    const loginContainer = document.querySelector('.login-body');

    if (loginCard && loginContainer) {
        loginContainer.addEventListener('mousemove', (e) => {
            const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            
            // Gerakkan kartu
            loginCard.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });

        // Saat mouse keluar, kembalikan posisi kartu
        loginContainer.addEventListener('mouseleave', () => {
            loginCard.style.transform = `rotateY(0deg) rotateX(0deg)`;
            loginCard.style.transition = 'all 0.5s ease';
        });

        // Hapus transisi saat mouse masuk supaya gerakan smooth
        loginContainer.addEventListener('mouseenter', () => {
            loginCard.style.transition = 'none';
        });
    }

});