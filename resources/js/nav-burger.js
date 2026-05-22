const links = document.querySelector('[data-rc-nav-links]');
const burger = document.querySelector('[data-rc-burger]');

if (burger && links) {
    burger.addEventListener('click', () => {
        const open = links.getAttribute('data-open') === 'true';
        links.setAttribute('data-open', open ? 'false' : 'true');
        burger.setAttribute('aria-expanded', open ? 'false' : 'true');
    });
}
