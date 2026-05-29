<x-layouts.base title="Custom Plan | Rielcode"
    description="Build your own custom website plan with Rielcode. Choose exactly what you need: pages, chatbot, CMS, login system, maintenance, and more."
    bodyClass="rc-redesign"
    :hideChatbot="true">
    @push('head')
        <meta name="robots" content="noindex, nofollow">
    @endpush

    <div class="cp-page">

        @if ($incompleteOrder)
            <div class="popup-background" role="dialog" aria-modal="true" aria-labelledby="popup-title">
                <div class="popup-container">
                    <h3 id="popup-title">Incomplete Order</h3>
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
                    <form method="post" action="{{ route('custom-plan.resume') }}">
                        @csrf
                        <button type="submit" name="continue" value="1" class="rc-btn rc-btn--fill">Yes</button>
                        <button type="submit" class="rc-btn rc-btn--outline">No</button>
                    </form>
                </div>
            </div>
        @endif

        <a href="/" class="back-btn">&#8592; Back</a>

        <div class="cp-wrapper">
            <div class="cp-header">
                <div><span class="rc-eyebrow">custom plan</span></div>
                <h1 class="rc-h1">Build Your Own Website</h1>
                <p class="rc-body-lg">Pick a starting point, then customize. Your price updates live as you configure.
                </p>
            </div>

            <div class="cp-presets">
                <a href="{{ route('custom-plan.create', ['preset' => 'blank']) }}"
                    class="cp-preset-card {{ $activePreset === 'blank' ? 'is-active' : '' }}" data-preset="blank"
                    {{ $activePreset === 'blank' ? 'aria-current="true"' : '' }}>
                    <div class="cp-preset-card__icon"><i class="bi bi-file-earmark"></i></div>
                    <div class="cp-preset-card__name">Blank</div>
                    <div class="cp-preset-card__price">from Rp500.000</div>
                    <div class="cp-preset-card__desc">Start from scratch, full control.</div>
                </a>
                <a href="{{ route('custom-plan.create', ['preset' => 'copy']) }}"
                    class="cp-preset-card {{ $activePreset === 'copy' ? 'is-active' : '' }}" data-preset="copy"
                    {{ $activePreset === 'copy' ? 'aria-current="true"' : '' }}>
                    <div class="cp-preset-card__icon"><i class="bi bi-files"></i></div>
                    <div class="cp-preset-card__name">Copy Website</div>
                    <div class="cp-preset-card__price">from Rp500.000</div>
                    <div class="cp-preset-card__desc">Match a reference site's layout, your brand.</div>
                </a>
            </div>

            <div class="cp-layout">
                <div class="cp-options">
                    <div class="cp-section cp-base-info">
                        <div class="cp-section-title"><i class="bi bi-box-seam"></i> Base Package: <span
                                id="base-price-label">Rp500.000</span></div>
                        <div class="cp-base-list" id="base-items-list"></div>
                    </div>

                    <div class="cp-section">
                        <div class="cp-section-title"><i class="bi bi-toggles"></i> Features</div>
                        <div class="cp-toggles">
                            @foreach ($addons->where('type', 'one_time') as $a)
                                @php $hasTiers = !empty($a->tiers); @endphp
                                @if (!$hasTiers)
                                    <label class="cp-toggle-item" data-feature="{{ $a->slug }}">
                                        <input type="checkbox" id="feat-{{ $a->slug }}" onchange="cpCalc()">
                                        <div class="cp-toggle-body">
                                            <div class="cp-toggle-name">{{ $a->name }}</div>
                                            <div class="cp-toggle-desc">{{ $a->description }}</div>
                                            <div class="cp-toggle-price" id="{{ $a->slug }}-price-label"
                                                data-price-idr="{{ $a->price_idr }}"
                                                data-price-usd="{{ $a->price_usd }}">+ Rp{{ number_format($a->price_idr, 0, ',', '.') }}</div>
                                        </div>
                                    </label>
                                @else
                                    <div class="cp-toggle-item cp-toggle-item--expandable" data-feature="{{ $a->slug }}"
                                        id="{{ $a->slug }}-toggle-item" role="checkbox" aria-checked="false"
                                        aria-labelledby="{{ $a->slug }}-toggle-name" tabindex="0">
                                        <input type="checkbox" id="feat-{{ $a->slug }}" onchange="cpCalc()" tabindex="-1">
                                        <div class="cp-toggle-body">
                                            <div class="cp-toggle-name" id="{{ $a->slug }}-toggle-name">{{ $a->name }}</div>
                                            <div class="cp-toggle-desc">{{ $a->description }}</div>
                                            <div class="cp-toggle-price" id="{{ $a->slug }}-price-label"></div>
                                            <div class="cp-difficulty-row" id="{{ $a->slug }}-difficulty"
                                                style="display:none;">
                                                <span class="cp-difficulty-label">Difficulty:</span>
                                                <div class="cp-difficulty-options">
                                                    @foreach ($a->tiers as $i => $tier)
                                                        <label class="cp-diff-opt"><input type="radio"
                                                                name="{{ $a->slug }}-diff" value="{{ $tier['price_idr'] }}"
                                                                data-price-idr="{{ $tier['price_idr'] }}"
                                                                data-price-usd="{{ $tier['price_usd'] }}"
                                                                {{ $i === 0 ? 'checked' : '' }} onchange="cpCalc()"><span
                                                                class="cp-diff-name">{{ $tier['name'] }}</span><span
                                                                class="cp-diff-info">{{ $tier['info'] }}</span><span
                                                                class="cp-diff-price"
                                                                data-tier-price>Rp{{ number_format($tier['price_idr'], 0, ',', '.') }}</span></label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="cp-section">
                        <div class="cp-section-title"><i class="bi bi-file-earmark-code"></i> Number of Pages</div>
                        <div class="cp-stepper-row">
                            <button type="button" class="cp-stepper-btn" onclick="cpStep('pages', -1)"
                                aria-label="Remove a page">&#8722;</button>
                            <span class="cp-stepper-val" id="val-pages">1</span>
                            <button type="button" class="cp-stepper-btn" onclick="cpStep('pages', 1)"
                                aria-label="Add a page">+</button>
                            <span class="cp-stepper-label">page(s) · <span class="cp-unit-price"
                                    id="pages-unit-price">Rp{{ number_format(optional($addons->firstWhere('slug', 'extra-page'))->price_idr ?? 0, 0, ',', '.') }} / page</span></span>
                        </div>
                        <div class="cp-preset-btns">
                            <span class="cp-preset-label">Quick:</span>
                            <button type="button" class="cp-preset-btn active" data-pages="1"
                                onclick="cpSetPages(1)">1</button>
                            <button type="button" class="cp-preset-btn" data-pages="3"
                                onclick="cpSetPages(3)">3</button>
                            <button type="button" class="cp-preset-btn" data-pages="5"
                                onclick="cpSetPages(5)">5</button>
                            <button type="button" class="cp-preset-btn" data-pages="10"
                                onclick="cpSetPages(10)">10</button>
                            <button type="button" class="cp-preset-btn" data-pages="20"
                                onclick="cpSetPages(20)">20</button>
                        </div>
                    </div>

                    <div class="cp-section">
                        <div class="cp-section-title"><i class="bi bi-tools"></i> Maintenance Support</div>
                        <div class="cp-stepper-row">
                            <button type="button" class="cp-stepper-btn" onclick="cpStep('maintenance', -1)"
                                aria-label="Remove a maintenance month">&#8722;</button>
                            <span class="cp-stepper-val" id="val-maintenance">0</span>
                            <button type="button" class="cp-stepper-btn" onclick="cpStep('maintenance', 1)"
                                aria-label="Add a maintenance month">+</button>
                            <span class="cp-stepper-label">month(s) · <span class="cp-unit-price"
                                    id="maintenance-unit-price">Rp{{ number_format(optional($addons->firstWhere('slug', 'maintenance'))->price_idr ?? 0, 0, ',', '.') }} / month</span></span>
                        </div>
                        <div class="cp-preset-btns">
                            <span class="cp-preset-label">Quick:</span>
                            <button type="button" class="cp-maint-btn active" data-months="0" onclick="cpSetMaintenance(0)">0</button>
                            <button type="button" class="cp-maint-btn" data-months="1" onclick="cpSetMaintenance(1)">1</button>
                            <button type="button" class="cp-maint-btn" data-months="3" onclick="cpSetMaintenance(3)">3</button>
                            <button type="button" class="cp-maint-btn" data-months="6" onclick="cpSetMaintenance(6)">6</button>
                            <button type="button" class="cp-maint-btn" data-months="12" onclick="cpSetMaintenance(12)">12</button>
                        </div>
                    </div>

                    <div class="cp-hosting-note" id="hosting-note">
                        <i class="bi bi-globe"></i>
                        <div>
                            <strong>Free Hosting &amp; Domain (.com, .id, etc.)</strong>
                            <span id="hosting-status">Spend at least Rp1.000.000 to unlock this bonus.</span>
                        </div>
                        <span class="cp-hosting-badge" id="hosting-badge">Locked</span>
                    </div>
                </div>

                <div class="cp-summary">
                    <div class="cp-summary-inner">
                        <div class="cp-summary-title">
                            Your Custom Plan
                            <button type="button" class="cp-currency-toggle" id="currencyToggle"
                                onclick="toggleCurrency()" aria-label="Switch to USD">$ USD</button>
                        </div>
                        <div class="cp-summary-lines" id="summary-lines"></div>
                        <div class="cp-summary-divider"></div>
                        <div class="cp-summary-total-row">
                            <span>Total</span>
                            <span class="cp-summary-total" id="summary-total" aria-live="polite">Rp500.000</span>
                        </div>
                        <div id="plan-cap-badge" class="cp-plan-cap-badge" style="display:none;"></div>
                        <div class="cp-hosting-unlock" id="hosting-unlock-bar"></div>
                        <button type="button" class="rc-btn rc-btn--fill" onclick="scrollToOrderForm()">Fill In Details &rarr;</button>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="err-banner">
                    @foreach ($errors->all() as $err)
                        <p>{{ $err }}</p>
                    @endforeach
                </div>
            @endif

            <div class="cp-order-form" id="cp-order-form">
                <div class="cp-form-recap" id="cp-form-recap" aria-label="Your selected plan summary"></div>

                <div class="cp-form-header">
                    <div class="cp-tag">// Your Details</div>
                    <h2>Complete Your Order</h2>
                    <p>Your plan is locked in above. Fill in your contact info below.</p>
                </div>

                <form method="post" action="{{ route('custom-plan.store') }}" id="customOrderForm">
                    @csrf
                    <input type="hidden" name="package" value="Custom Plan">
                    <input type="hidden" name="custom_total" id="form-custom-total" value="500000">
                    <input type="hidden" name="custom_preset" id="form-custom-preset" value="{{ $activePreset }}">
                    <input type="hidden" name="custom_config" id="form-custom-config" value="">

                    <div class="cp-copy-url-row {{ $activePreset === 'copy' ? 'is-visible' : '' }}"
                        id="cp-copy-url-row">
                        <label for="cf-copy-url">Reference website URL <span style="color:#f87171">*</span></label>
                        <input type="url" name="copy_source_url" id="cf-copy-url"
                            placeholder="https://example.com" autocomplete="url" {{ $activePreset === 'copy' ? 'required' : '' }}>
                        <div class="cp-copy-url-hint">We'll match the layout of this site with your branding and
                            content.</div>
                    </div>

                    <div class="cp-form-grid">
                        <div class="cp-form-group">
                            <label for="cf-nama">Name</label>
                            <input type="text" name="nama" id="cf-nama" placeholder="Your full name"
                                value="{{ old('nama') }}" autocomplete="name" required>
                        </div>
                        <div class="cp-form-group">
                            <label for="cf-email">Email</label>
                            <input type="email" name="email" id="cf-email" placeholder="your@email.com"
                                value="{{ old('email') }}" autocomplete="email" required>
                        </div>
                        <div class="cp-form-group">
                            <label for="cf-phone">Phone / WhatsApp</label>
                            <input type="tel" name="phone" id="cf-phone" placeholder="e.g. 081289328493"
                                value="{{ old('phone') }}" autocomplete="tel" required>
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
                        <label for="cf-additional">Additional Notes <span
                                class="cp-form-optional">(optional)</span></label>
                        <textarea name="additional" id="cf-additional" rows="4"
                            autocomplete="off"
                            placeholder="Any extra requirements or details about your project?">{{ old('additional') }}</textarea>
                    </div>

                    <div class="cp-form-submit-row">
                        <div class="cp-form-total-preview">
                            Order total: <strong id="form-total-display">Rp500.000</strong>
                        </div>
                        <button type="submit" name="action" value="checkout"
                            class="rc-btn rc-btn--fill rc-btn--lg">Proceed to Checkout &rarr;</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            (function() {
                const ACTIVE_PRESET = @json($activePreset);
                const ADDONS = @json($addons);
                const bySlug = {};
                ADDONS.forEach(function(a) {
                    a.price_idr = parseInt(a.price_idr);
                    a.price_usd = parseFloat(a.price_usd) || 0;
                    if (a.tiers) a.tiers.forEach(function(t) {
                        t.price_idr = parseInt(t.price_idr);
                        t.price_usd = parseFloat(t.price_usd) || 0;
                    });
                    bySlug[a.slug] = a;
                });

                // one_time addons with no tiers = simple checkbox features
                const SIMPLE_FEATURES = ADDONS.filter(function(a) {
                    return a.type === 'one_time' && (!a.tiers || !a.tiers.length);
                });
                // one_time addons with tiers = expandable difficulty features
                const TIERED_FEATURES = ADDONS.filter(function(a) {
                    return a.type === 'one_time' && a.tiers && a.tiers.length;
                });

                function priceOf(slug) {
                    return bySlug[slug] ? bySlug[slug].price_idr : 0;
                }

                const PRESET_BASE = {
                    blank: { idr: 500000, usd: 29 },
                    copy: { idr: 500000, usd: 29 }
                };
                const BASE = PRESET_BASE[ACTIVE_PRESET].idr;
                const BASE_USD = PRESET_BASE[ACTIVE_PRESET].usd;
                const HOSTING_MIN_USD = 58;
                const USD_RATE = 17000;
                let currency = 'IDR';
                const state = {
                    pages: 1,
                    maintenance: 0
                };
                const HOSTING_MIN = 1000000;

                function fmt(n, usd) {
                    if (currency === 'USD') {
                        const v = (usd && usd > 0) ? usd : Math.ceil(n / USD_RATE);
                        return '$' + v.toLocaleString('en-US');
                    }
                    return 'Rp' + n.toLocaleString('id-ID');
                }

                function fmtRange(minT, maxT) {
                    return fmt(minT.price_idr, minT.price_usd) + ' – ' + fmt(maxT.price_idr, maxT.price_usd);
                }

                function priceUsdOf(slug) {
                    return bySlug[slug] ? bySlug[slug].price_usd : 0;
                }

                function getTier(slug) {
                    const a = bySlug[slug];
                    if (!a || !a.tiers || !a.tiers.length) return null;
                    const s = document.querySelector('input[name="' + slug + '-diff"]:checked');
                    if (!s) return a.tiers[0];
                    const idx = a.tiers.findIndex(function(t) { return t.price_idr === parseInt(s.value); });
                    return idx >= 0 ? a.tiers[idx] : a.tiers[0];
                }

                function getTierPrice(slug) {
                    const t = getTier(slug);
                    return t ? t.price_idr : 0;
                }

                function getDiffLabel(name) {
                    const s = document.querySelector('input[name="' + name + '"]:checked');
                    if (!s) return '';
                    const n = s.closest('label').querySelector('.cp-diff-name');
                    return n ? n.textContent.trim() : '';
                }

                TIERED_FEATURES.forEach(function(a) {
                    const cb = document.getElementById('feat-' + a.slug);
                    const row = document.getElementById(a.slug + '-difficulty');
                    if (cb && row) cb.addEventListener('change', function() {
                        row.style.display = this.checked ? 'flex' : 'none';
                    });
                    const item = document.getElementById(a.slug + '-toggle-item');
                    if (!item || !cb) return;

                    function toggleItem() {
                        cb.checked = !cb.checked;
                        item.setAttribute('aria-checked', cb.checked);
                        cb.dispatchEvent(new Event('change'));
                    }
                    item.addEventListener('click', function(e) {
                        if (e.target.tagName === 'INPUT' && e.target.type === 'checkbox') return;
                        if (e.target.closest('.cp-difficulty-row')) return;
                        toggleItem();
                    });
                    item.addEventListener('keydown', function(e) {
                        if (e.key === ' ' || e.key === 'Enter') {
                            e.preventDefault();
                            toggleItem();
                        }
                    });
                    cb.addEventListener('change', function() {
                        item.setAttribute('aria-checked', cb.checked);
                    });
                });

                function updateStepperDisabled(key) {
                    const mins = {
                            pages: 1,
                            maintenance: 0
                        },
                        maxs = {
                            pages: 50,
                            maintenance: 24
                        };
                    const row = document.getElementById('val-' + key).closest('.cp-stepper-row');
                    if (!row) return;
                    const [decBtn, , incBtn] = row.querySelectorAll('.cp-stepper-btn');
                    if (decBtn) decBtn.disabled = state[key] <= mins[key];
                    if (incBtn) incBtn.disabled = state[key] >= maxs[key];
                }
                window.cpStep = function(key, delta) {
                    const mins = {
                            pages: 1,
                            maintenance: 0
                        },
                        maxs = {
                            pages: 50,
                            maintenance: 24
                        };
                    state[key] = Math.max(mins[key], Math.min(maxs[key], state[key] + delta));
                    document.getElementById('val-' + key).textContent = state[key];
                    updateStepperDisabled(key);
                    if (key === 'pages') updatePresetBtns();
                    if (key === 'maintenance') updateMaintBtns();
                    cpCalc();
                };
                window.cpSetPages = function(n) {
                    state.pages = n;
                    document.getElementById('val-pages').textContent = n;
                    updateStepperDisabled('pages');
                    updatePresetBtns();
                    cpCalc();
                };
                window.cpSetMaintenance = function(n) {
                    state.maintenance = n;
                    document.getElementById('val-maintenance').textContent = n;
                    updateStepperDisabled('maintenance');
                    updateMaintBtns();
                    cpCalc();
                };

                function updatePresetBtns() {
                    document.querySelectorAll('.cp-preset-btn').forEach(function(btn) {
                        btn.classList.toggle('active', parseInt(btn.dataset.pages) === state.pages);
                    });
                }
                function updateMaintBtns() {
                    document.querySelectorAll('.cp-maint-btn').forEach(function(btn) {
                        btn.classList.toggle('active', parseInt(btn.dataset.months) === state.maintenance);
                    });
                }
                window.toggleCurrency = function() {
                    currency = currency === 'IDR' ? 'USD' : 'IDR';
                    const btn = document.getElementById('currencyToggle');
                    if (currency === 'IDR') {
                        btn.textContent = '$ USD';
                        btn.setAttribute('aria-label', 'Switch to USD');
                    } else {
                        btn.textContent = 'Rp IDR';
                        btn.setAttribute('aria-label', 'Switch to IDR');
                    }
                    cpCalc();
                };

                function updateStaticPrices() {
                    SIMPLE_FEATURES.forEach(function(a) {
                        const el = document.getElementById(a.slug + '-price-label');
                        if (el) el.textContent = '+ ' + fmt(a.price_idr, a.price_usd);
                    });
                    const bEl = document.getElementById('base-price-label');
                    if (bEl) bEl.textContent = fmt(BASE, BASE_USD);
                    const pu = document.getElementById('pages-unit-price');
                    if (pu) pu.textContent = fmt(priceOf('extra-page'), priceUsdOf('extra-page')) + ' / page';
                    const mu = document.getElementById('maintenance-unit-price');
                    if (mu) mu.textContent = fmt(priceOf('maintenance'), priceUsdOf('maintenance')) + ' / month';
                    TIERED_FEATURES.forEach(function(a) {
                        const label = document.getElementById(a.slug + '-price-label');
                        if (label) {
                            label.textContent = '+ ' + fmtRange(a.tiers[0], a.tiers[a.tiers.length - 1]);
                        }
                        document.querySelectorAll('#' + a.slug + '-difficulty [data-tier-price]').forEach(function(el) {
                            const radio = el.closest('label').querySelector('input[type="radio"]');
                            if (radio) el.textContent = fmt(parseInt(radio.dataset.priceIdr), parseFloat(radio.dataset.priceUsd) || 0);
                        });
                    });
                }

                window.cpCalc = function() {
                    let total = BASE;
                    const lines = [{
                        label: 'Base price',
                        amount: BASE,
                        usd: BASE_USD
                    }];
                    if (state.pages > 1) {
                        const e = (state.pages - 1) * priceOf('extra-page');
                        total += e;
                        lines.push({
                            label: state.pages + ' pages (' + (state.pages - 1) + ' extra)',
                            amount: e,
                            usd: (state.pages - 1) * priceUsdOf('extra-page')
                        });
                    } else lines.push({
                        label: '1 page (included)',
                        amount: 0,
                        usd: 0
                    });
                    if (state.maintenance > 0) {
                        const m = state.maintenance * priceOf('maintenance');
                        total += m;
                        lines.push({
                            label: state.maintenance + ' month(s) maintenance',
                            amount: m,
                            usd: state.maintenance * priceUsdOf('maintenance')
                        });
                    }
                    SIMPLE_FEATURES.forEach(function(a) {
                        const cb = document.getElementById('feat-' + a.slug);
                        if (cb && cb.checked) {
                            total += a.price_idr;
                            lines.push({
                                label: a.name,
                                amount: a.price_idr,
                                usd: a.price_usd
                            });
                        }
                    });
                    TIERED_FEATURES.forEach(function(a) {
                        const cb = document.getElementById('feat-' + a.slug);
                        if (cb && cb.checked) {
                            const t = getTier(a.slug);
                            const p = t ? t.price_idr : 0;
                            total += p;
                            lines.push({
                                label: a.name + ' (' + getDiffLabel(a.slug + '-diff') + ')',
                                amount: p,
                                usd: t ? t.price_usd : 0
                            });
                        }
                    });

                    const totalUsd = lines.reduce(function(s, l) {
                        return s + ((l.usd && l.usd > 0) ? l.usd : Math.ceil(l.amount / USD_RATE));
                    }, 0);

                    document.getElementById('summary-lines').innerHTML = lines.map(function(l) {
                        return '<div class="cp-line' + (l.amount === 0 ? ' cp-line-free' : '') + '"><span>' + l
                            .label + '</span><span>' + (l.amount === 0 ? 'Free' : fmt(l.amount, l.usd)) +
                            '</span></div>';
                    }).join('');

                    const unlocked = total >= HOSTING_MIN;
                    const badge = document.getElementById('hosting-badge'),
                        status = document.getElementById('hosting-status'),
                        note = document.getElementById('hosting-note'),
                        bar = document.getElementById('hosting-unlock-bar'),
                        dh = document.getElementById('cp-form-dh');
                    document.getElementById('summary-total').textContent = fmt(total, totalUsd);
                    document.getElementById('plan-cap-badge').style.display = 'none';
                    if (unlocked) {
                        badge.textContent = 'Unlocked ✓';
                        badge.className = 'cp-hosting-badge unlocked';
                        status.textContent = 'Free hosting & domain included!';
                        note.className = 'cp-hosting-note unlocked';
                        bar.innerHTML =
                        '<span class="cp-unlock-pill">🎉 Free Hosting &amp; Domain (.com, .id, etc.) included</span>';
                        if (dh) dh.style.display = 'none';
                    } else {
                        badge.textContent = 'Locked';
                        badge.className = 'cp-hosting-badge';
                        const remainIdr = HOSTING_MIN - total;
                        const remainUsd = HOSTING_MIN_USD - totalUsd;
                        status.textContent = 'Add ' + fmt(remainIdr, remainUsd > 0 ? remainUsd : 0) +
                            ' more to unlock free hosting & domain.';
                        note.className = 'cp-hosting-note';
                        bar.innerHTML = '';
                        if (dh) dh.style.display = 'flex';
                    }

                    const hiddenTotal = document.getElementById('form-custom-total');
                    if (hiddenTotal) hiddenTotal.value = total;
                    const configField = document.getElementById('form-custom-config');
                    if (configField) {
                        const allFeatures = [];
                        SIMPLE_FEATURES.forEach(function(a) {
                            const cb = document.getElementById('feat-' + a.slug);
                            if (cb && cb.checked) allFeatures.push(a.name);
                        });
                        TIERED_FEATURES.forEach(function(a) {
                            const cb = document.getElementById('feat-' + a.slug);
                            if (cb && cb.checked) allFeatures.push(a.name + ' (' + getDiffLabel(a.slug + '-diff') + ')');
                        });
                        configField.value = JSON.stringify({
                            pages: state.pages,
                            maintenance: state.maintenance,
                            features: allFeatures
                        });
                    }
                    const td = document.getElementById('form-total-display');
                    if (td) td.textContent = fmt(total, totalUsd);

                    const recap = document.getElementById('cp-form-recap');
                    if (recap) {
                        const featureChips = lines.slice(1).filter(function(l) { return l.amount > 0; }).map(function(l) {
                            return '<span class="cp-recap-chip">' + l.label + ' · ' + fmt(l.amount, l.usd) + '</span>';
                        });
                        recap.innerHTML = '<div class="cp-recap-label">Your plan</div><div class="cp-recap-chips">' +
                            (featureChips.length ? featureChips.join('') : '<span class="cp-recap-chip cp-recap-chip--base">Base package only</span>') +
                            '</div><div class="cp-recap-total">' + fmt(total, totalUsd) + '</div>';
                    }
                    ADDONS.forEach(function(a) {
                        const cb = document.getElementById('feat-' + a.slug);
                        const item = cb ? cb.closest('.cp-toggle-item') : null;
                        if (item) item.classList.toggle('active', cb.checked);
                    });
                    updateStaticPrices();
                };

                window.scrollToOrderForm = function() {
                    const form = document.getElementById('cp-order-form');
                    if (form) {
                        form.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        setTimeout(function() {
                            const f = form.querySelector('input[name="nama"]');
                            if (f) f.focus();
                        }, 600);
                    }
                };

                (function renderBaseItems() {
                    const items = {
                        blank: ['1 custom-designed page', 'Mobile responsive layout', 'Contact form',
                            'Basic SEO setup'
                        ],
                        copy: ['Layout matched to your reference site',
                            'Your branding, colors &amp; content applied', 'Mobile responsive layout',
                            'Contact form &amp; basic SEO setup'
                        ]
                    };
                    const list = document.getElementById('base-items-list');
                    if (!list) return;
                    list.innerHTML = (items[ACTIVE_PRESET] || items.blank).map(function(t) {
                        return '<span class="cp-base-item"><i class="bi bi-check2"></i> ' + t + '</span>';
                    }).join('');
                })();

                cpCalc();
                updatePresetBtns();
                updateMaintBtns();
                updateStepperDisabled('pages');
                updateStepperDisabled('maintenance');
            })();
        </script>
    @endpush
</x-layouts.base>
