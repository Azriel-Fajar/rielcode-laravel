# Admin Panel Skeleton Loading Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** When a sidebar nav item is clicked in the Filament admin panel, the page transitions instantly and shows shimmer skeleton placeholders while the real content loads.

**Architecture:** Enable Filament SPA mode so sidebar clicks use `wire:navigate` (no full page reload). Hook into Livewire's `livewire:navigating` / `livewire:navigated` DOM events via a small JS module injected through a custom Filament render hook. On `navigating`, detect the target page type from the URL and inject a matching shimmer skeleton overlay into the main content area. On `navigated`, remove the overlay. Shimmer CSS lives in `theme.css`.

**Tech Stack:** Filament 3, Livewire 3, vanilla JS, CSS custom properties (already in `theme.css`)

---

## File Map

| File | Action | Responsibility |
|---|---|---|
| `app/Providers/Filament/AdminPanelProvider.php` | Modify | Enable SPA mode + register render hook |
| `resources/views/filament/admin/skeleton-loader.blade.php` | Create | Blade partial rendered by hook |
| `resources/js/filament-skeleton.js` | Create | Livewire nav event listener + skeleton logic |
| `resources/css/filament/admin/theme.css` | Modify | Shimmer keyframe + skeleton CSS classes |
| `vite.config.js` | Check only | No change expected — JS file is inlined via Blade |

---

## Task 1: Enable Filament SPA Mode

**Files:**
- Modify: `app/Providers/Filament/AdminPanelProvider.php`

SPA mode makes Filament use `wire:navigate` on sidebar links, so Livewire handles navigation without a full browser page reload. This is the prerequisite for intercepting navigation events.

- [ ] **Step 1: Add `->spa()` to the panel chain**

In `app/Providers/Filament/AdminPanelProvider.php`, add `->spa()` after `->darkMode(false)`:

```php
->darkMode(false)
->spa()
->theme(asset('css/filament/admin/theme.css'))
```

- [ ] **Step 2: Verify admin panel still loads**

Open `http://localhost/admin` in browser. Sidebar links should now navigate without a full page reload (no browser loading spinner in the tab). Console should show no JS errors.

- [ ] **Step 3: Commit**

```bash
git add app/Providers/Filament/AdminPanelProvider.php
git commit -m "feat(admin): enable Filament SPA mode for sidebar navigation"
```

---

## Task 2: Add Shimmer CSS to Theme

**Files:**
- Modify: `resources/css/filament/admin/theme.css`

Add the shimmer keyframe animation and skeleton block classes. These classes are applied dynamically by JS in Task 4.

- [ ] **Step 1: Append shimmer styles to `resources/css/filament/admin/theme.css`**

Add at the very end of the file:

```css
/* ============================================================
   Skeleton / shimmer loading
   ============================================================ */

@keyframes rc-shimmer {
    0%   { background-position: -400px 0; }
    100% { background-position: 400px 0; }
}

.rc-skeleton-block {
    background: linear-gradient(
        90deg,
        rgba(200, 200, 200, 0.15) 25%,
        rgba(200, 200, 200, 0.30) 50%,
        rgba(200, 200, 200, 0.15) 75%
    );
    background-size: 800px 100%;
    animation: rc-shimmer 1.4s ease-in-out infinite;
    border-radius: 6px;
}

/* Overlay container that replaces page content during navigation */
.rc-skeleton-overlay {
    position: absolute;
    inset: 0;
    z-index: 50;
    padding: 1.5rem;
    background: var(--fi-body-bg, #f9fafb);
    display: flex;
    flex-direction: column;
    gap: 1rem;
    pointer-events: none;
}

/* Skeleton variants */
.rc-skeleton-header {
    height: 2rem;
    width: 35%;
}

.rc-skeleton-toolbar {
    height: 2.5rem;
    width: 100%;
}

/* Table skeleton */
.rc-skeleton-table-row {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.rc-skeleton-table-cell {
    height: 1.25rem;
    flex: 1;
}

.rc-skeleton-table-cell.narrow {
    flex: 0 0 6rem;
}

/* Form skeleton */
.rc-skeleton-form-section {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1.25rem;
    border: 1px solid rgba(0,0,0,0.08);
    border-radius: 0.5rem;
}

.rc-skeleton-label {
    height: 0.85rem;
    width: 8rem;
}

.rc-skeleton-input {
    height: 2.5rem;
    width: 100%;
}

/* Widget / dashboard skeleton */
.rc-skeleton-widgets {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1rem;
}

.rc-skeleton-widget-card {
    height: 8rem;
    border-radius: 0.75rem;
}
```

- [ ] **Step 2: Rebuild Filament theme CSS**

```bash
npm run build
```

Expected: no errors, `public/css/filament/admin/theme.css` updated.

- [ ] **Step 3: Commit**

```bash
git add resources/css/filament/admin/theme.css public/css/filament/admin/theme.css
git commit -m "feat(admin): add shimmer skeleton CSS classes to theme"
```

---

## Task 3: Create the Skeleton Blade Partial

**Files:**
- Create: `resources/views/filament/admin/skeleton-loader.blade.php`

This Blade file is rendered once via a Filament render hook and injects a `<script>` tag + empty `<div id="rc-skeleton-root">` into the admin body. The JS (Task 4) targets this root div.

- [ ] **Step 1: Create `resources/views/filament/admin/skeleton-loader.blade.php`**

```blade
{{-- Skeleton loader root — populated/cleared by filament-skeleton.js --}}
<div id="rc-skeleton-root" aria-hidden="true" style="position:relative;"></div>

<script>
    (function () {
        // Inline the skeleton JS so it runs before Livewire boots
        // Actual logic is in resources/js/filament-skeleton.js (bundled separately)
        // This script tag is a placeholder; the real module is loaded below.
    })();
</script>

@once
    <script type="module" src="{{ asset('js/filament-skeleton.js') }}"></script>
@endonce
```

- [ ] **Step 2: Commit**

```bash
git add resources/views/filament/admin/skeleton-loader.blade.php
git commit -m "feat(admin): add skeleton loader blade partial"
```

---

## Task 4: Write the Skeleton JS Module

**Files:**
- Create: `resources/js/filament-skeleton.js`

This module listens to Livewire's navigation events and swaps a skeleton overlay into the main content area. It detects page type from the navigation URL to pick the right skeleton shape.

- [ ] **Step 1: Create `resources/js/filament-skeleton.js`**

```js
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
```

- [ ] **Step 2: Commit**

```bash
git add resources/js/filament-skeleton.js
git commit -m "feat(admin): add Livewire navigation skeleton JS module"
```

---

## Task 5: Register the Render Hook + Copy JS to Public

**Files:**
- Modify: `app/Providers/Filament/AdminPanelProvider.php`

Filament render hooks inject Blade into specific panel slots. `PanelsRenderHook::BODY_END` injects just before `</body>` — ideal for our script + root div.

The JS file needs to be accessible at `public/js/filament-skeleton.js`. Since it uses no build-step syntax (no imports, no JSX), copy it directly rather than routing through Vite bundling.

- [ ] **Step 1: Add render hook registration to `AdminPanelProvider.php`**

Add this import at the top:

```php
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
```

Add this line inside the `panel()` method chain, after `->spa()`:

```php
->renderHook(
    PanelsRenderHook::BODY_END,
    fn () => view('filament.admin.skeleton-loader')
)
```

Full updated chain (relevant excerpt):

```php
return $panel
    ->default()
    ->id('admin')
    ->path('admin')
    ->login()
    ->profile(isSimple: false)
    ->brandName('Rielcode Studio')
    ->brandLogo(asset('IMG/Rielcode Logo Square Transparent.svg'))
    ->brandLogoHeight('2rem')
    ->favicon(asset('favicon.ico'))
    ->darkMode(false)
    ->spa()
    ->theme(asset('css/filament/admin/theme.css'))
    ->renderHook(
        PanelsRenderHook::BODY_END,
        fn () => view('filament.admin.skeleton-loader')
    )
    // ... rest of chain unchanged
```

- [ ] **Step 2: Copy the JS to public**

```bash
cp resources/js/filament-skeleton.js public/js/filament-skeleton.js
```

- [ ] **Step 3: Verify file is accessible**

Open `http://localhost/js/filament-skeleton.js` in browser. Should return the JS source, not a 404.

- [ ] **Step 4: Commit**

```bash
git add app/Providers/Filament/AdminPanelProvider.php public/js/filament-skeleton.js
git commit -m "feat(admin): register skeleton render hook and publish JS to public"
```

---

## Task 6: Manual QA

No automated tests for visual behaviour — verify manually.

- [ ] **Step 1: Start dev server**

```bash
php artisan serve
```

- [ ] **Step 2: Open admin and throttle network**

1. Go to `http://localhost/admin`
2. Open DevTools → Network → set throttling to **Slow 3G**

- [ ] **Step 3: Click each sidebar section and verify skeleton**

| Sidebar item | Expected skeleton |
|---|---|
| Dashboard | 4 widget cards shimmer |
| Any list page (Orders, Projects…) | Header + toolbar + 8 table rows shimmer |
| Any edit/create page | Header + 2 form sections shimmer |

- [ ] **Step 4: Remove throttle and verify skeleton disappears promptly**

On fast network skeleton should appear briefly (< 200ms) then real content replaces it.

- [ ] **Step 5: Check no console errors**

DevTools Console should be clean. Check specifically for:
- `Cannot read properties of null (reading 'appendChild')` → means `.fi-main-ctn` selector is wrong; inspect DOM and update `MAIN_SELECTOR` in `filament-skeleton.js` + re-copy to public.

- [ ] **Step 6: Commit QA sign-off**

```bash
git commit --allow-empty -m "chore(admin): QA skeleton loading — all page types verified"
```

---

## Notes

- `MAIN_SELECTOR` (`'.fi-main-ctn'`) targets Filament 3's main content container. If Filament is upgraded and the class changes, update both `filament-skeleton.js` and `public/js/filament-skeleton.js`.
- The JS is served as a plain file from `public/js/`. If you later add a Vite pipeline for admin-specific JS, move it there and update the `asset()` path in `skeleton-loader.blade.php`.
- Shimmer colours use semi-transparent grey — works on both light Filament themes and the custom `--rc-cream` body background.
