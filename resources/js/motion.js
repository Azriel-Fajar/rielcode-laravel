const REDUCED = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function setupReveal() {
    if (REDUCED) return;
    const targets = document.querySelectorAll('[data-reveal]');
    if (!targets.length) return;

    const io = new IntersectionObserver(
        (entries) => {
            for (const entry of entries) {
                if (entry.isIntersecting) {
                    entry.target.setAttribute('data-reveal', 'in');
                    io.unobserve(entry.target);
                }
            }
        },
        { rootMargin: '0px 0px -10% 0px', threshold: 0.1 }
    );

    targets.forEach((el) => io.observe(el));
}

function setupNav() {
    const nav = document.querySelector('[data-nav]');
    if (!nav) return;

    let lastY = window.scrollY;
    let ticking = false;

    const update = () => {
        const y = window.scrollY;
        nav.classList.toggle('is-scrolled', y > 8);
        if (!REDUCED) {
            nav.classList.toggle('is-hidden', y > lastY && y > 120);
        }
        lastY = y;
        ticking = false;
    };

    window.addEventListener(
        'scroll',
        () => {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        },
        { passive: true }
    );
    update();
}

setupReveal();
setupNav();
