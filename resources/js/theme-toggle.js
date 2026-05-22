document.querySelectorAll('[data-rc-theme-toggle]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const current = document.documentElement.getAttribute('data-theme') || 'light';
        const next = current === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        try { localStorage.setItem('rc-theme', next); } catch {}
    });
});
