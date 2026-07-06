// Auto hide navbar dropdown on mobile scroll
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
    document.querySelectorAll('img[loading="lazy"]').forEach(img => {
        img.addEventListener('error', function() {
            this.src = 'https://via.placeholder.com/300x300?text=No+Image';
        });
    });
});