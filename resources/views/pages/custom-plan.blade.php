<x-layouts.base
    title="Custom Plan | Rielcode"
    description="Build your own custom website plan with Rielcode. Choose exactly what you need — pages, chatbot, CMS, login system, maintenance, and more."
    bodyClass="rc-redesign"
>
@push('head')
<meta name="robots" content="noindex, nofollow">
@endpush

<div class="cp-page">

    @if ($incompleteOrder)
    <div class="popup-background">
        <div class="popup-container">
            <h3>Incomplete Order</h3>
            <div class="personal-info">
                <div class="order-name">
                    <p>Billed to: <b>{{ strtoupper($incompleteOrder->order_name) }}</b></p>
                    <span>{{ $incompleteOrder->email }}</span>
                </div>
                <div class="package-type">
                    <p>Package type: <b>{{ $incompleteOrder->package }}</b></p>
                    <span>{{ $incompleteOrder->phone_number }}</span>
                </div>
            </div>
            <p>Do you wish to continue this order?</p>
            <form method="post" action="{{ route('custom-plan.store') }}">
                @csrf
                <button type="submit" name="continue" class="cp-popup-btn">Yes</button>
                <button type="submit" name="no" class="cp-popup-btn">No</button>
            </form>
        </div>
    </div>
    @endif

    <a href="/" class="back-btn">Back</a>

    <div class="cp-wrapper">
        <div class="cp-header">
            <div><span class="rc-eyebrow">custom plan</span></div>
            <h1 class="rc-h1">Build Your Own Website</h1>
            <p class="rc-body-lg">Pick a starting point, then customize. Your price updates live as you configure.</p>
        </div>

        <div class="cp-presets">
            <a href="{{ route('custom-plan.create', ['preset' => 'blank']) }}" class="cp-preset-card {{ $activePreset === 'blank' ? 'is-active' : '' }}" data-preset="blank">
                <div class="cp-preset-card__icon"><i class="bi bi-file-earmark"></i></div>
                <div class="cp-preset-card__name">Blank</div>
                <div class="cp-preset-card__price">from Rp500.000</div>
                <div class="cp-preset-card__desc">Start from scratch, full control.</div>
            </a>
            <a href="{{ route('custom-plan.create', ['preset' => 'copy']) }}" class="cp-preset-card {{ $activePreset === 'copy' ? 'is-active' : '' }}" data-preset="copy">
                <div class="cp-preset-card__icon"><i class="bi bi-files"></i></div>
                <div class="cp-preset-card__name">Copy Website</div>
                <div class="cp-preset-card__price">from Rp500.000</div>
                <div class="cp-preset-card__desc">Match a reference site's layout, your brand.</div>
            </a>
        </div>

        <div class="cp-layout">
            <div class="cp-options">
                <div class="cp-section cp-base-info">
                    <div class="cp-section-title"><i class="bi bi-box-seam"></i> Base Package — <span id="base-price-label">Rp500.000</span></div>
                    <div class="cp-base-list" id="base-items-list"></div>
                </div>

                <div class="cp-section">
                    <div class="cp-section-title"><i class="bi bi-toggles"></i> Features</div>
                    <div class="cp-toggles">
                        <label class="cp-toggle-item" data-feature="priority">
                            <input type="checkbox" id="feat-priority" onchange="cpCalc()">
                            <div class="cp-toggle-body">
                                <div class="cp-toggle-name">Priority Delivery</div>
                                <div class="cp-toggle-desc">50% faster turnaround</div>
                                <div class="cp-toggle-price" id="priority-price-label">+ Rp400.000</div>
                            </div>
                        </label>
                        <label class="cp-toggle-item" data-feature="chatbot">
                            <input type="checkbox" id="feat-chatbot" onchange="cpCalc()">
                            <div class="cp-toggle-body">
                                <div class="cp-toggle-name">AI Chatbot</div>
                                <div class="cp-toggle-desc">AI-powered chat widget on your site</div>
                                <div class="cp-toggle-price" id="chatbot-price-label">+ Rp1.500.000</div>
                            </div>
                        </label>
                        <div class="cp-toggle-item cp-toggle-item--expandable" data-feature="cms" id="cms-toggle-item">
                            <input type="checkbox" id="feat-cms" onchange="cpCalc()">
                            <div class="cp-toggle-body">
                                <div class="cp-toggle-name">CMS / Admin Panel</div>
                                <div class="cp-toggle-desc">Manage your content from a dashboard</div>
                                <div class="cp-toggle-price" id="cms-price-label">+ Rp800.000 – Rp1.600.000</div>
                                <div class="cp-difficulty-row" id="cms-difficulty" style="display:none;">
                                    <span class="cp-difficulty-label">Difficulty:</span>
                                    <div class="cp-difficulty-options">
                                        <label class="cp-diff-opt"><input type="radio" name="cms-diff" value="800000" checked onchange="cpCalc()"><span class="cp-diff-name">Basic</span><span class="cp-diff-info">Text &amp; image content editor</span><span class="cp-diff-price" data-cms-price="800000">Rp800.000</span></label>
                                        <label class="cp-diff-opt"><input type="radio" name="cms-diff" value="1200000" onchange="cpCalc()"><span class="cp-diff-name">Standard</span><span class="cp-diff-info">+ Media library &amp; user roles</span><span class="cp-diff-price" data-cms-price="1200000">Rp1.200.000</span></label>
                                        <label class="cp-diff-opt"><input type="radio" name="cms-diff" value="1600000" onchange="cpCalc()"><span class="cp-diff-name">Advanced</span><span class="cp-diff-info">+ Custom modules &amp; API access</span><span class="cp-diff-price" data-cms-price="1600000">Rp1.600.000</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label class="cp-toggle-item" data-feature="login">
                            <input type="checkbox" id="feat-login" onchange="cpCalc()">
                            <div class="cp-toggle-body">
                                <div class="cp-toggle-name">Login / Member System</div>
                                <div class="cp-toggle-desc">User registration, login &amp; profile pages</div>
                                <div class="cp-toggle-price" id="login-price-label">+ Rp500.000</div>
                            </div>
                        </label>
                        <div class="cp-toggle-item cp-toggle-item--expandable" data-feature="ecom" id="ecom-toggle-item">
                            <input type="checkbox" id="feat-ecom" onchange="cpCalc()">
                            <div class="cp-toggle-body">
                                <div class="cp-toggle-name">E-Commerce</div>
                                <div class="cp-toggle-desc">Product catalog, cart &amp; order management</div>
                                <div class="cp-toggle-price" id="ecom-price-label">+ Rp1.000.000 – Rp3.000.000</div>
                                <div class="cp-difficulty-row" id="ecom-difficulty" style="display:none;">
                                    <span class="cp-difficulty-label">Difficulty:</span>
                                    <div class="cp-difficulty-options">
                                        <label class="cp-diff-opt"><input type="radio" name="ecom-diff" value="1000000" checked onchange="cpCalc()"><span class="cp-diff-name">Basic</span><span class="cp-diff-info">Product catalog, cart &amp; checkout</span><span class="cp-diff-price" data-ecom-price="1000000">Rp1.000.000</span></label>
                                        <label class="cp-diff-opt"><input type="radio" name="ecom-diff" value="2000000" onchange="cpCalc()"><span class="cp-diff-name">Standard</span><span class="cp-diff-info">+ Payment gateway &amp; order tracking</span><span class="cp-diff-price" data-ecom-price="2000000">Rp2.000.000</span></label>
                                        <label class="cp-diff-opt"><input type="radio" name="ecom-diff" value="3000000" onchange="cpCalc()"><span class="cp-diff-name">Advanced</span><span class="cp-diff-info">+ Multi-category, coupons &amp; analytics</span><span class="cp-diff-price" data-ecom-price="3000000">Rp3.000.000</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label class="cp-toggle-item" data-feature="seo">
                            <input type="checkbox" id="feat-seo" onchange="cpCalc()">
                            <div class="cp-toggle-body">
                                <div class="cp-toggle-name">Advanced SEO</div>
                                <div class="cp-toggle-desc">Full meta, schema markup &amp; sitemap setup</div>
                                <div class="cp-toggle-price" id="seo-price-label">+ Rp300.000</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="cp-section">
                    <div class="cp-section-title"><i class="bi bi-file-earmark-code"></i> Number of Pages</div>
                    <div class="cp-stepper-row">
                        <button type="button" class="cp-stepper-btn" onclick="cpStep('pages', -1)">&#8722;</button>
                        <span class="cp-stepper-val" id="val-pages">1</span>
                        <button type="button" class="cp-stepper-btn" onclick="cpStep('pages', 1)">+</button>
                        <span class="cp-stepper-label">page(s) &mdash; <span class="cp-unit-price" id="pages-unit-price">Rp150.000 / page</span></span>
                    </div>
                    <div class="cp-preset-btns">
                        <span class="cp-preset-label">Quick:</span>
                        <button type="button" class="cp-preset-btn active" data-pages="1" onclick="cpSetPages(1)">1</button>
                        <button type="button" class="cp-preset-btn" data-pages="3" onclick="cpSetPages(3)">3</button>
                        <button type="button" class="cp-preset-btn" data-pages="5" onclick="cpSetPages(5)">5</button>
                        <button type="button" class="cp-preset-btn" data-pages="10" onclick="cpSetPages(10)">10</button>
                        <button type="button" class="cp-preset-btn" data-pages="20" onclick="cpSetPages(20)">20</button>
                    </div>
                </div>

                <div class="cp-section">
                    <div class="cp-section-title"><i class="bi bi-tools"></i> Maintenance Support</div>
                    <div class="cp-stepper-row">
                        <button type="button" class="cp-stepper-btn" onclick="cpStep('maintenance', -1)">&#8722;</button>
                        <span class="cp-stepper-val" id="val-maintenance">0</span>
                        <button type="button" class="cp-stepper-btn" onclick="cpStep('maintenance', 1)">+</button>
                        <span class="cp-stepper-label">month(s) &mdash; <span class="cp-unit-price" id="maintenance-unit-price">Rp300.000 / month</span></span>
                    </div>
                </div>

                <div class="cp-hosting-note" id="hosting-note">
                    <i class="bi bi-globe"></i>
                    <div>
                        <strong>Free Hosting &amp; .COM Domain</strong>
                        <span id="hosting-status">Spend at least Rp2.000.000 to unlock this bonus.</span>
                    </div>
                    <span class="cp-hosting-badge" id="hosting-badge">Locked</span>
                </div>
            </div>

            <div class="cp-summary">
                <div class="cp-summary-inner">
                    <div class="cp-summary-title">
                        Your Custom Plan
                        <button type="button" class="cp-currency-toggle" id="currencyToggle" onclick="toggleCurrency()">$ USD</button>
                    </div>
                    <div class="cp-currency-hint">Click to switch currency</div>
                    <div class="cp-summary-lines" id="summary-lines"></div>
                    <div class="cp-summary-divider"></div>
                    <div class="cp-summary-total-row">
                        <span>Total</span>
                        <span class="cp-summary-total" id="summary-total">Rp500.000</span>
                    </div>
                    <div id="plan-cap-badge" style="display:none;margin-top:8px;margin-bottom:8px;padding:6px 10px;background:rgba(58,123,255,0.12);border:1px solid rgba(58,123,255,0.3);border-radius:6px;font-size:12px;color:#6fa3ff;line-height:1.4;"></div>
                    <div class="cp-hosting-unlock" id="hosting-unlock-bar"></div>
                    <button type="button" class="cp-order-btn" onclick="scrollToOrderForm()">Fill In Your Details &rarr;</button>
                    <p class="cp-order-note">Happy with your plan? Scroll down to complete your order.</p>
                </div>
            </div>
        </div>

        <div class="cp-order-form" id="cp-order-form">
            <div class="cp-form-header">
                <div class="cp-tag">// Your Details</div>
                <h2>Complete Your Order</h2>
                <p>Your plan is locked in above &mdash; just fill in your contact info.</p>
            </div>

            <form method="post" action="{{ route('custom-plan.store') }}" id="customOrderForm">
                @csrf
                <input type="hidden" name="package" value="Custom Plan">
                <input type="hidden" name="custom_total" id="form-custom-total" value="500000">
                <input type="hidden" name="custom_preset" id="form-custom-preset" value="{{ $activePreset }}">
                <input type="hidden" name="custom_config" id="form-custom-config" value="">

                <div class="cp-copy-url-row {{ $activePreset === 'copy' ? 'is-visible' : '' }}" id="cp-copy-url-row">
                    <label for="cf-copy-url">Reference website URL <span style="color:#f87171">*</span></label>
                    <input type="url" name="copy_source_url" id="cf-copy-url" placeholder="https://example.com" {{ $activePreset === 'copy' ? 'required' : '' }}>
                    <div class="cp-copy-url-hint">We'll match the layout of this site with your branding and content.</div>
                </div>

                <div class="cp-form-grid">
                    <div class="cp-form-group">
                        <label for="cf-nama">Name</label>
                        <input type="text" name="nama" id="cf-nama" placeholder="Your full name" value="{{ old('nama') }}" required>
                    </div>
                    <div class="cp-form-group">
                        <label for="cf-email">Email</label>
                        <input type="email" name="email" id="cf-email" placeholder="your@email.com" value="{{ old('email') }}" required>
                    </div>
                    <div class="cp-form-group">
                        <label for="cf-phone">Phone / WhatsApp</label>
                        <input type="tel" name="phone" id="cf-phone" placeholder="e.g. 081289328493" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <div class="cp-form-dh" id="cp-form-dh">
                    <div class="cp-form-dh-group">
                        <h4>Do you have a domain?</h4>
                        <div class="cp-dh-radios">
                            <input type="radio" name="domain" id="domain-yes" value="Yes" checked>
                            <label for="domain-yes">Yes</label>
                            <input type="radio" name="domain" id="domain-no" value="No">
                            <label for="domain-no">No</label>
                        </div>
                    </div>
                    <div class="cp-form-dh-group">
                        <h4>Do you have hosting?</h4>
                        <div class="cp-dh-radios">
                            <input type="radio" name="hosting" id="hosting-yes" value="Yes" checked>
                            <label for="hosting-yes">Yes</label>
                            <input type="radio" name="hosting" id="hosting-no" value="No">
                            <label for="hosting-no">No</label>
                        </div>
                    </div>
                </div>

                <div class="cp-form-group cp-form-group--full">
                    <label for="cf-additional">Additional Notes <span class="cp-form-optional">(optional)</span></label>
                    <textarea name="additional" id="cf-additional" rows="4" placeholder="Any extra requirements or details about your project?">{{ old('additional') }}</textarea>
                </div>

                <div class="cp-form-submit-row">
                    <div class="cp-form-total-preview">
                        Order total: <strong id="form-total-display">Rp500.000</strong>
                    </div>
                    <button type="submit" name="submit" value="1" class="cp-submit-btn">Proceed to Checkout &rarr;</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const ACTIVE_PRESET = @json($activePreset);
    const PRESET_BASE = { blank: 500000, copy: 500000 };
    const BASE = PRESET_BASE[ACTIVE_PRESET];
    const PRICES = { pages: 85000, maintenance: 300000, priority: 400000, chatbot: 1500000, login: 550000, seo: 300000 };
    const USD_RATE = 17000;
    let currency = 'IDR';
    const state = { pages: 1, maintenance: 0 };
    const HOSTING_MIN = 1000000;

    function fmt(n) {
        return currency === 'USD' ? '$' + Math.ceil(n / USD_RATE).toLocaleString('en-US') : 'Rp' + n.toLocaleString('id-ID');
    }
    function fmtRange(min, max) { return fmt(min) + ' – ' + fmt(max); }
    function getCmsDiff() { const s = document.querySelector('input[name="cms-diff"]:checked'); return s ? parseInt(s.value) : 800000; }
    function getEcomDiff() { const s = document.querySelector('input[name="ecom-diff"]:checked'); return s ? parseInt(s.value) : 1000000; }
    function getDiffLabel(name) { const s = document.querySelector('input[name="' + name + '"]:checked'); if (!s) return ''; const n = s.closest('label').querySelector('.cp-diff-name'); return n ? n.textContent.trim() : ''; }

    document.getElementById('feat-cms').addEventListener('change', function () { document.getElementById('cms-difficulty').style.display = this.checked ? 'flex' : 'none'; });
    document.getElementById('feat-ecom').addEventListener('change', function () { document.getElementById('ecom-difficulty').style.display = this.checked ? 'flex' : 'none'; });
    ['cms-toggle-item','ecom-toggle-item'].forEach(function (id) {
        const item = document.getElementById(id);
        const cb = item.querySelector('input[type="checkbox"]');
        item.addEventListener('click', function (e) {
            if (e.target.tagName === 'INPUT' && e.target.type === 'checkbox') return;
            if (e.target.closest('.cp-difficulty-row')) return;
            cb.checked = !cb.checked; cb.dispatchEvent(new Event('change'));
        });
    });

    window.cpStep = function (key, delta) {
        const mins = { pages: 1, maintenance: 0 }, maxs = { pages: 50, maintenance: 24 };
        state[key] = Math.max(mins[key], Math.min(maxs[key], state[key] + delta));
        document.getElementById('val-' + key).textContent = state[key];
        if (key === 'pages') updatePresetBtns();
        cpCalc();
    };
    window.cpSetPages = function (n) { state.pages = n; document.getElementById('val-pages').textContent = n; updatePresetBtns(); cpCalc(); };
    function updatePresetBtns() { document.querySelectorAll('.cp-preset-btn').forEach(function (btn) { btn.classList.toggle('active', parseInt(btn.dataset.pages) === state.pages); }); }
    window.toggleCurrency = function () { currency = currency === 'IDR' ? 'USD' : 'IDR'; document.getElementById('currencyToggle').textContent = currency === 'IDR' ? '$ USD' : 'Rp IDR'; cpCalc(); };

    function updateStaticPrices() {
        const ids = [{ id: 'priority-price-label', p: PRICES.priority }, { id: 'chatbot-price-label', p: PRICES.chatbot }, { id: 'login-price-label', p: PRICES.login }, { id: 'seo-price-label', p: PRICES.seo }];
        ids.forEach(function (i) { const el = document.getElementById(i.id); if (el) el.textContent = '+ ' + fmt(i.p); });
        const bEl = document.getElementById('base-price-label'); if (bEl) bEl.textContent = fmt(BASE);
        const pu = document.getElementById('pages-unit-price'); if (pu) pu.textContent = fmt(PRICES.pages) + ' / page';
        const mu = document.getElementById('maintenance-unit-price'); if (mu) mu.textContent = fmt(PRICES.maintenance) + ' / month';
        const cl = document.getElementById('cms-price-label'); if (cl) cl.textContent = '+ ' + fmtRange(800000, 1600000);
        const el2 = document.getElementById('ecom-price-label'); if (el2) el2.textContent = '+ ' + fmtRange(1000000, 3000000);
        document.querySelectorAll('[data-cms-price]').forEach(function (el) { el.textContent = fmt(parseInt(el.dataset.cmsPrice)); });
        document.querySelectorAll('[data-ecom-price]').forEach(function (el) { el.textContent = fmt(parseInt(el.dataset.ecomPrice)); });
    }

    window.cpCalc = function () {
        let total = BASE;
        const lines = [{ label: 'Base price', amount: BASE }];
        if (state.pages > 1) { const e = (state.pages - 1) * PRICES.pages; total += e; lines.push({ label: state.pages + ' pages (' + (state.pages - 1) + ' extra)', amount: e }); }
        else lines.push({ label: '1 page (included)', amount: 0 });
        if (state.maintenance > 0) { const m = state.maintenance * PRICES.maintenance; total += m; lines.push({ label: state.maintenance + ' month(s) maintenance', amount: m }); }
        [{ id: 'priority', label: 'Priority delivery' }, { id: 'chatbot', label: 'AI Chatbot' }, { id: 'login', label: 'Login / Member system' }, { id: 'seo', label: 'Advanced SEO' }].forEach(function (f) {
            const cb = document.getElementById('feat-' + f.id);
            if (cb && cb.checked) { total += PRICES[f.id]; lines.push({ label: f.label, amount: PRICES[f.id] }); }
        });
        const cmsCb = document.getElementById('feat-cms');
        if (cmsCb && cmsCb.checked) { const p = getCmsDiff(); total += p; lines.push({ label: 'CMS / Admin Panel (' + getDiffLabel('cms-diff') + ')', amount: p }); }
        const ecomCb = document.getElementById('feat-ecom');
        if (ecomCb && ecomCb.checked) { const p = getEcomDiff(); total += p; lines.push({ label: 'E-Commerce (' + getDiffLabel('ecom-diff') + ')', amount: p }); }

        document.getElementById('summary-lines').innerHTML = lines.map(function (l) {
            return '<div class="cp-line' + (l.amount === 0 ? ' cp-line-free' : '') + '"><span>' + l.label + '</span><span>' + (l.amount === 0 ? 'Free' : fmt(l.amount)) + '</span></div>';
        }).join('');

        const isCopy = ACTIVE_PRESET === 'copy';
        const unlocked = isCopy ? true : total >= HOSTING_MIN;
        const badge = document.getElementById('hosting-badge'), status = document.getElementById('hosting-status'), note = document.getElementById('hosting-note'), bar = document.getElementById('hosting-unlock-bar'), dh = document.getElementById('cp-form-dh');
        document.getElementById('summary-total').textContent = fmt(total);
        document.getElementById('plan-cap-badge').style.display = 'none';
        if (unlocked) {
            badge.textContent = 'Unlocked ✓'; badge.className = 'cp-hosting-badge unlocked';
            status.textContent = 'Free hosting & .COM domain included!'; note.className = 'cp-hosting-note unlocked';
            bar.innerHTML = '<span class="cp-unlock-pill">🎉 Free Hosting &amp; .COM Domain included</span>';
            if (dh) dh.style.display = 'none';
        } else {
            badge.textContent = 'Locked'; badge.className = 'cp-hosting-badge';
            status.textContent = 'Add ' + fmt(HOSTING_MIN - total) + ' more to unlock free hosting & domain.';
            note.className = 'cp-hosting-note'; bar.innerHTML = '';
            if (dh) dh.style.display = 'flex';
        }

        const hiddenTotal = document.getElementById('form-custom-total'); if (hiddenTotal) hiddenTotal.value = total;
        const configField = document.getElementById('form-custom-config');
        if (configField) {
            const allFeatures = [];
            [{ id: 'priority', label: 'Priority delivery' }, { id: 'chatbot', label: 'AI Chatbot' }, { id: 'login', label: 'Login / Member system' }, { id: 'seo', label: 'Advanced SEO' }].forEach(function (f) {
                const cb = document.getElementById('feat-' + f.id); if (cb && cb.checked) allFeatures.push(f.label);
            });
            if (cmsCb && cmsCb.checked) allFeatures.push('CMS / Admin Panel (' + getDiffLabel('cms-diff') + ')');
            if (ecomCb && ecomCb.checked) allFeatures.push('E-Commerce (' + getDiffLabel('ecom-diff') + ')');
            configField.value = JSON.stringify({ pages: state.pages, maintenance: state.maintenance, features: allFeatures });
        }
        const td = document.getElementById('form-total-display'); if (td) td.textContent = fmt(total);
        ['priority','chatbot','cms','login','ecom','seo'].forEach(function (id) {
            const cb = document.getElementById('feat-' + id);
            const item = cb ? cb.closest('.cp-toggle-item') : null;
            if (item) item.classList.toggle('active', cb.checked);
        });
        updateStaticPrices();
    };

    window.scrollToOrderForm = function () {
        const form = document.getElementById('cp-order-form');
        if (form) { form.scrollIntoView({ behavior: 'smooth', block: 'start' }); setTimeout(function () { const f = form.querySelector('input[name="nama"]'); if (f) f.focus(); }, 600); }
    };

    (function renderBaseItems() {
        const items = { blank: ['1 custom-designed page','Mobile responsive layout','Contact form','Basic SEO setup'], copy: ['Layout matched to your reference site','Your branding, colors &amp; content applied','Mobile responsive layout','Contact form &amp; basic SEO setup'] };
        const list = document.getElementById('base-items-list');
        if (!list) return;
        list.innerHTML = (items[ACTIVE_PRESET] || items.blank).map(function (t) { return '<span class="cp-base-item"><i class="bi bi-check2"></i> ' + t + '</span>'; }).join('');
    })();

    cpCalc();
    updatePresetBtns();
})();
</script>
@endpush
</x-layouts.base>
