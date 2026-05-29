<x-layouts.base
    title="Order Form | Rielcode"
    description="Fill out the order form to get started with your Rielcode web development project."
    bodyClass="rc-redesign w-full"
    :hideChatbot="true"
>
@push('head')
<meta name="robots" content="noindex, nofollow">
@endpush

<div class="background w-full">

    {{-- Incomplete order popup --}}
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
            <form method="post" action="{{ route('order.resume') }}">
                @csrf
                <button type="submit" name="continue" value="1" class="rc-btn rc-btn--fill">Yes</button>
                <button type="submit" class="rc-btn rc-btn--outline">No</button>
            </form>
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="err-banner">
        @foreach ($errors->all() as $err)
            <p>{{ $err }}</p>
        @endforeach
    </div>
    @endif

    <a href="/" class="btn"><span class="btn-arrow" aria-hidden="true">&#8592;</span> Back to Home</a>

    <div class="form-container">
        <form method="post" action="{{ route('order.store') }}" id="orderForm">
            @csrf

            <div class="title flex justify-center items-center">
                <span class="rc-eyebrow">checkout step 01</span>
                <h1 class="rc-h1 text-white">Order Form</h1>
                <p class="rc-body">Fill out the form below to confirm your purchase</p>
            </div>

            <div class="customer-info-container">
                <h2>Customer Information</h2>
                <input type="text" name="nama" id="nama" placeholder="Name" aria-label="Full name" value="{{ old('nama') }}" required>
                <input type="email" name="email" id="email" placeholder="Email address" aria-label="Email address" value="{{ old('email') }}" required>
                <input type="tel" name="phone" id="phone" placeholder="ex. 081289328493" maxlength="13" aria-label="Phone number" value="{{ old('phone') }}" required>
            </div>

            <div class="package-details-container">
                <h2>Package Detail</h2>

                <div class="plan-container">
                    @foreach ($packages as $pkg)
                    <input type="radio" name="package" id="pkg_{{ $pkg->slug }}" value="{{ $pkg->package_name }}"
                        data-slug="{{ $pkg->slug }}"
                        data-free-hosting="{{ $pkg->includes_free_hosting ? '1' : '0' }}"
                        data-price="{{ $pkg->idr_price }}"
                        data-included-addons="{{ json_encode($pkg->included_addons ?? []) }}"
                        data-included-tiers="{{ json_encode($pkg->included_tiers ?? (object) []) }}"
                        {{ $defaultPlan === $pkg->package_name || ($selectedSlug === $pkg->slug) ? 'checked' : '' }} required>
                    <label for="pkg_{{ $pkg->slug }}">
                        <h3 class="plan-label-name">{{ $pkg->package_name }}</h3>
                        <span class="plan-label-price">
                            IDR {{ number_format($pkg->idr_price / 1000) }}k
                            @if ($pkg->us_price) / ${{ number_format($pkg->us_price) }} @endif
                        </span>
                        @if ($pkg->is_popular)
                            <span class="plan-label-badge badge-pro">Most Popular</span>
                        @elseif ($pkg->badge_color === 'green')
                            <span class="plan-label-badge badge-landing">For Students</span>
                        @elseif ($pkg->badge_color === 'amber')
                            <span class="plan-label-badge badge-business">Best Value</span>
                        @endif
                    </label>
                    @endforeach
                </div>

                <div class="landing-notice" id="landingNotice" style="display:{{ $defaultPlan === 'Student Plan' ? 'block' : 'none' }};">
                    &#9888; Note: The Student Plan does not include free hosting or domain.
                    This package covers website design only. Perfect for students &amp; personal projects.
                </div>

                <div class="promo-banner" id="promoBanner" style="display:{{ ($defaultPlan && $defaultPlan !== 'Student Plan') ? 'block' : 'none' }};">
                    <span class="promo-banner__pill">&#10003; Free hosting + domain (.com, .id, etc.) included with this plan</span>
                </div>

            </div>

            {{-- Add-ons --}}
            @if ($addons->isNotEmpty())
            <div class="package-details-container" id="addonsSection">
                <h2>Add-ons <span style="font-weight:400;font-size:.9em;">(optional)</span></h2>
                <div class="rc-addons-table-wrap">
                <table class="rc-addons-table rc-addons-table--order">
                    <thead>
                        <tr>
                            <th>Add-on</th>
                            <th>Type</th>
                            <th>IDR</th>
                            <th>USD</th>
                            <th>Include?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addons as $addon)
                        @php $hasQty = in_array($addon->slug, ['extra-page', 'maintenance']); @endphp
                        <tr data-addon-slug="{{ $addon->slug }}"
                            @if (!empty($addon->tiers)) data-tiers='{!! json_encode($addon->tiers) !!}' @endif>
                            <td>
                                {{ $addon->name }}
                                @if ($addon->description)
                                    <span class="rc-addons-table__desc">{{ $addon->description }}</span>
                                @endif
                                <span class="rc-addons-table__included" style="display:none;color:#3ecf8e;font-size:.85em;">Included in plan</span>
                            </td>
                            <td class="rc-addons-table__type">{{ str_replace('_', ' ', $addon->type) }}</td>
                            @if (!empty($addon->tiers))
                            <td class="rc-addons-table__price" colspan="2">
                                <select name="addon_tier[{{ $addon->id }}]" class="rc-addon-tier" data-addon-id="{{ $addon->id }}">
                                    <option value="" data-price-idr="0" data-price-usd="0">Choose tier…</option>
                                    @foreach ($addon->tiers as $tier)
                                    <option value="{{ $tier['name'] }}" data-price-idr="{{ $tier['price_idr'] }}" data-price-usd="{{ $tier['price_usd'] }}">{{ $tier['name'] }} - IDR {{ number_format($tier['price_idr'] / 1000) }}k</option>
                                    @endforeach
                                </select>
                            </td>
                            @elseif ($hasQty)
                            <td class="rc-addons-table__price" data-price-idr="{{ $addon->price_idr }}" data-unit-idr="{{ $addon->price_idr }}">IDR {{ number_format($addon->price_idr / 1000) }}k</td>
                            <td class="rc-addons-table__price">${{ number_format($addon->price_usd) }}</td>
                            @else
                            <td class="rc-addons-table__price" data-price-idr="{{ $addon->price_idr }}">IDR {{ number_format($addon->price_idr / 1000) }}k</td>
                            <td class="rc-addons-table__price">${{ number_format($addon->price_usd) }}</td>
                            @endif
                            <td>
                                <input type="checkbox" name="addons[]" value="{{ $addon->id }}" id="addon_{{ $addon->id }}">
                                <label for="addon_{{ $addon->id }}" class="sr-only">Add {{ $addon->name }}</label>
                                @if ($hasQty)
                                <span class="rc-addon-qty" style="display:none;align-items:center;gap:6px;margin-top:6px;">
                                    <button type="button" class="rc-qty-btn" data-qty-dir="-1" aria-label="Decrease">−</button>
                                    <input type="number" name="addon_qty[{{ $addon->id }}]" class="rc-qty-input" value="1" min="1" readonly style="width:40px;text-align:center;">
                                    <button type="button" class="rc-qty-btn" data-qty-dir="1" aria-label="Increase">+</button>
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            @endif

            <div class="additional-container">
                <h2>Additional Information</h2>
                <textarea name="additional" id="additional" rows="5"
                    placeholder="Anything else you want to tell us? (Optional)">{{ old('additional') }}</textarea>
            </div>

            <div class="submit-container flex justify-center items-center">
                <button type="submit" name="submit" value="1" class="rc-btn rc-btn--fill rc-btn--lg" id="orderBtn" style="width:100%;">
                    <span id="orderBtnLabel">Checkout</span>
                    <svg id="orderSpinner" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="display:none;animation:rc-spin 0.7s linear infinite;vertical-align:middle;margin-left:8px;">
                        <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                    </svg>
                </button>
            </div>
        </form>
        <style>
        @keyframes rc-spin { to { transform: rotate(360deg); } }
        #orderBtn:disabled { opacity: 0.7; cursor: not-allowed; }
        </style>
        <script>
        document.getElementById('orderForm').addEventListener('submit', function() {
            var btn = document.getElementById('orderBtn');
            btn.disabled = true;
            document.getElementById('orderBtnLabel').textContent = 'Processing…';
            document.getElementById('orderSpinner').style.display = 'inline';
        });
        </script>
    </div>

    <div class="rc-total-widget" id="orderTotal" hidden></div>
</div>

@push('scripts')
<script>
    const plans = document.querySelectorAll('input[name="package"]');
    const landingNotice = document.getElementById('landingNotice');
    const promoBanner = document.getElementById('promoBanner');

    function updatePlanUI() {
        const selected = document.querySelector('input[name="package"]:checked');
        if (!selected) return;
        const isLanding = selected.value === 'Student Plan';
        const hasFreeHosting = selected.dataset.freeHosting === '1';
        landingNotice.style.display = isLanding ? 'block' : 'none';
        if (promoBanner) promoBanner.style.display = hasFreeHosting ? 'block' : 'none';
    }

    const addonRows = document.querySelectorAll('tr[data-addon-slug]');
    const orderTotal = document.getElementById('orderTotal');

    function planData() {
        const selected = document.querySelector('input[name="package"]:checked');
        let included = [], tiers = {};
        if (selected) {
            try { included = JSON.parse(selected.dataset.includedAddons || '[]'); } catch (e) {}
            try { tiers = JSON.parse(selected.dataset.includedTiers || '{}'); } catch (e) {}
        }
        return { included, tiers };
    }

    // Rebuild a tiered add-on's <select> for the current plan.
    // baselineTier: the tier name the plan already includes (or null).
    // Options below the baseline are dropped; the baseline option is priced 0
    // and labelled "Included"; higher tiers are priced as the difference.
    function buildTierSelect(row, baselineTier) {
        const select = row.querySelector('.rc-addon-tier');
        if (!select) return;
        let tiers = [];
        try { tiers = JSON.parse(row.dataset.tiers || '[]'); } catch (e) {}
        const baseIndex = baselineTier ? tiers.findIndex(t => t.name === baselineTier) : -1;
        const basePrice = baseIndex >= 0 ? tiers[baseIndex].price_idr : 0;
        const prev = select.value;
        select.innerHTML = '';

        if (baseIndex < 0) {
            const o = document.createElement('option');
            o.value = ''; o.dataset.priceIdr = '0'; o.textContent = 'Choose tier…';
            select.appendChild(o);
        }
        tiers.forEach((t, i) => {
            if (baseIndex >= 0 && i < baseIndex) return;
            const o = document.createElement('option');
            o.value = t.name;
            const diff = Math.max(0, t.price_idr - basePrice);
            o.dataset.priceIdr = String(diff);
            if (baseIndex >= 0 && i === baseIndex) {
                o.textContent = t.name + ' (Included)';
            } else if (diff === 0) {
                o.textContent = t.name + ' - IDR 0';
            } else {
                o.textContent = t.name + ' - +IDR ' + Math.round(diff / 1000) + 'k';
            }
            select.appendChild(o);
        });

        // Keep previous selection if still valid, else default to baseline.
        if ([...select.options].some(o => o.value === prev)) {
            select.value = prev;
        } else if (baselineTier) {
            select.value = baselineTier;
        }
    }

    function applyPlan() {
        const { included, tiers } = planData();
        addonRows.forEach(row => {
            const slug = row.dataset.addonSlug;
            const cb = row.querySelector('input[type="checkbox"]');
            const incLabel = row.querySelector('.rc-addons-table__included');
            const isTiered = !!row.querySelector('.rc-addon-tier');

            if (included.includes(slug)) {
                // Fully included (non-upgradable) -> hide and uncheck.
                row.style.display = 'none';
                if (cb) cb.checked = false;
                if (incLabel) incLabel.style.display = 'none';
                return;
            }

            row.style.display = '';

            if (isTiered) {
                const baseline = tiers[slug] || null;
                buildTierSelect(row, baseline);
                if (baseline) {
                    // Always-on: checked and locked (can't be unticked), but still submits.
                    if (cb) { cb.checked = true; cb.dataset.locked = '1'; }
                    if (incLabel) incLabel.style.display = 'inline';
                } else {
                    if (cb) { cb.checked = false; delete cb.dataset.locked; }
                    if (incLabel) incLabel.style.display = 'none';
                }
            } else if (incLabel) {
                incLabel.style.display = 'none';
            }
            syncQty(row);
        });
    }

    function syncQty(row) {
        const cb = row.querySelector('input[type="checkbox"]');
        const qty = row.querySelector('.rc-addon-qty');
        if (qty) qty.style.display = (cb && cb.checked) ? 'inline-flex' : 'none';
    }

    function recalcTotal() {
        const selected = document.querySelector('input[name="package"]:checked');
        let total = selected ? (parseInt(selected.dataset.price, 10) || 0) : 0;
        addonRows.forEach(row => {
            if (row.style.display === 'none') return;
            const cb = row.querySelector('input[type="checkbox"]');
            if (!cb || !cb.checked) return;
            const tier = row.querySelector('.rc-addon-tier');
            if (tier) {
                const opt = tier.options[tier.selectedIndex];
                total += opt ? (parseInt(opt.dataset.priceIdr, 10) || 0) : 0;
            } else {
                const priceCell = row.querySelector('[data-price-idr]');
                const unit = priceCell ? (parseInt(priceCell.dataset.priceIdr, 10) || 0) : 0;
                const qtyInput = row.querySelector('.rc-qty-input');
                const qty = qtyInput ? (parseInt(qtyInput.value, 10) || 1) : 1;
                total += unit * qty;
            }
        });
        if (orderTotal) {
            if (total > 0) {
                orderTotal.innerHTML = '<span class="rc-total-widget__label">Total</span>'
                    + '<span class="rc-total-widget__value">IDR ' + total.toLocaleString('id-ID') + '</span>';
                orderTotal.hidden = false;
            } else {
                orderTotal.hidden = true;
            }
        }
    }

    plans.forEach(p => p.addEventListener('change', () => { updatePlanUI(); applyPlan(); recalcTotal(); }));
    addonRows.forEach(row => {
        const cb = row.querySelector('input[type="checkbox"]');
        if (cb) cb.addEventListener('change', () => {
            if (cb.dataset.locked === '1') { cb.checked = true; }
            syncQty(row); recalcTotal();
        });
        const tier = row.querySelector('.rc-addon-tier');
        if (tier) tier.addEventListener('change', recalcTotal);
        row.querySelectorAll('.rc-qty-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = row.querySelector('.rc-qty-input');
                if (!input) return;
                const next = (parseInt(input.value, 10) || 1) + parseInt(btn.dataset.qtyDir, 10);
                input.value = Math.max(1, next);
                recalcTotal();
            });
        });
    });

    updatePlanUI();
    applyPlan();
    recalcTotal();
</script>
@endpush
</x-layouts.base>
