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

});