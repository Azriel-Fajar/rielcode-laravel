/**
 * Admin skeleton loader — hooks into Livewire SPA navigation.
 *
 * Page type detection uses URL path segments:
 *   /admin              → dashboard (widgets)
 *   /admin/*/create     → form (create)
 *   /admin/*/edit       → form (edit)
 *   /admin/*            → table (list)
 */

const MAIN_SELECTOR = '.fi-main-ctn';

function detectPageType(url) {
    const path = new URL(url, window.location.origin).pathname;
    if (path.match(/\/admin\/?$/)) return 'dashboard';
    if (path.match(/\/create$/)) return 'form';
    if (path.match(/\/edit$/)) return 'form';
    return 'table';
}

function buildTableSkeleton() {
    const rows = Array.from({ length: 8 }, () => `
        <div class="rc-skeleton-table-row">
            <div class="rc-skeleton-block rc-skeleton-table-cell narrow"></div>
            <div class="rc-skeleton-block rc-skeleton-table-cell"></div>
            <div class="rc-skeleton-block rc-skeleton-table-cell"></div>
            <div class="rc-skeleton-block rc-skeleton-table-cell narrow"></div>
            <div class="rc-skeleton-block rc-skeleton-table-cell narrow"></div>
        </div>
    `).join('');

    return `
        <div class="rc-skeleton-overlay">
            <div class="rc-skeleton-block rc-skeleton-header"></div>
            <div class="rc-skeleton-block rc-skeleton-toolbar"></div>
            ${rows}
        </div>
    `;
}

function buildFormSkeleton() {
    const fields = Array.from({ length: 3 }, () => `
        <div>
            <div class="rc-skeleton-block rc-skeleton-label" style="margin-bottom:0.4rem;"></div>
            <div class="rc-skeleton-block rc-skeleton-input"></div>
        </div>
    `).join('');

    return `
        <div class="rc-skeleton-overlay">
            <div class="rc-skeleton-block rc-skeleton-header"></div>
            <div class="rc-skeleton-form-section">
                ${fields}
            </div>
            <div class="rc-skeleton-form-section">
                ${fields}
            </div>
        </div>
    `;
}

function buildDashboardSkeleton() {
    const cards = Array.from({ length: 4 }, () =>
        `<div class="rc-skeleton-block rc-skeleton-widget-card"></div>`
    ).join('');

    return `
        <div class="rc-skeleton-overlay">
            <div class="rc-skeleton-block rc-skeleton-header"></div>
            <div class="rc-skeleton-widgets">${cards}</div>
            <div class="rc-skeleton-widgets">${cards}</div>
        </div>
    `;
}

function buildSkeleton(type) {
    switch (type) {
        case 'form':      return buildFormSkeleton();
        case 'dashboard': return buildDashboardSkeleton();
        default:          return buildTableSkeleton();
    }
}

let skeletonEl = null;

function showSkeleton(targetUrl) {
    const main = document.querySelector(MAIN_SELECTOR);
    if (!main) return;

    // Position relative so overlay sits inside content area
    main.style.position = 'relative';

    const type = detectPageType(targetUrl);
    skeletonEl = document.createElement('div');
    skeletonEl.innerHTML = buildSkeleton(type);
    skeletonEl = skeletonEl.firstElementChild;
    main.appendChild(skeletonEl);
}

function hideSkeleton() {
    if (skeletonEl && skeletonEl.parentNode) {
        skeletonEl.parentNode.removeChild(skeletonEl);
        skeletonEl = null;
    }
}

// Livewire 3 SPA navigation events
document.addEventListener('livewire:navigating', (event) => {
    const targetUrl = event.detail?.url ?? window.location.href;
    showSkeleton(targetUrl);
});

document.addEventListener('livewire:navigated', () => {
    hideSkeleton();
});

// Safety net: clear on any Livewire component update (catches edge cases)
document.addEventListener('livewire:update', () => {
    hideSkeleton();
});
