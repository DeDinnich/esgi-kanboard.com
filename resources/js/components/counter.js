export default function initKeyNumberCounters() {
    const counters = document.querySelectorAll('.counter');
    let animated = false;

    const animate = () => {
        if (animated) return;
        animated = true;

        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const duration = 1000;
            const startTime = performance.now();

            const step = (now) => {
                const progress = Math.min((now - startTime) / duration, 1);
                const value = Math.floor(progress * target);
                counter.innerText = value.toLocaleString('fr-FR');
                if (progress < 1) requestAnimationFrame(step);
                else counter.innerText = target.toLocaleString('fr-FR');
            };

            requestAnimationFrame(step);
        });
    };

    // Animation au scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) animate();
        });
    }, { threshold: 0.6 });

    counters.forEach(counter => observer.observe(counter));
}
