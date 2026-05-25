<x-layouts.base
    title="Order Form | Rielcode"
    description="Fill out the order form to get started with your Rielcode web development project."
    bodyClass="rc-redesign w-full"
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
                        @else
                            <span class="plan-label-badge badge-starter">{{ ucfirst($pkg->badge_color ?? '') }}</span>
                        @endif
                    </label>
                    @endforeach
                </div>

                <div class="landing-notice" id="landingNotice" style="display:{{ $defaultPlan === 'Student Plan' ? 'block' : 'none' }};">
                    &#9888; Note: The Student Plan does not include free hosting or domain.
                    This package covers website design only. Perfect for students &amp; personal projects.
                </div>

                <div class="promo-banner" id="promoBanner" style="display:{{ ($defaultPlan && $defaultPlan !== 'Student Plan') ? 'block' : 'none' }};">
                    <span class="promo-banner__pill">&#10003; Free hosting + .COM domain included with this plan</span>
                </div>

                <div class="promo-check mt-3" id="promoCheckWrap" style="display:{{ in_array($defaultPlan, ['Student Plan', '']) ? 'none' : '' }};">
                    <input type="checkbox" id="free_promo" name="free_promo" value="1">
                    <label for="free_promo">&#127881; Claim Free Hosting &amp; .COM Domain</label>
                </div>

                <div class="domain-hosting-wrap" id="domainHostingWrap">
                    <h4>Do you have a domain?</h4>
                    <div class="domain-container">
                        <input type="radio" name="domain" id="domain-yes" value="Yes" required checked>
                        <label for="domain-yes">Yes</label>
                        <input type="radio" name="domain" id="domain-no" value="No" required>
                        <label for="domain-no">No</label>
                    </div>
                    <h4>Do you have hosting?</h4>
                    <div class="domain-container">
                        <input type="radio" name="hosting" id="hosting-yes" value="Yes" required checked>
                        <label for="hosting-yes">Yes</label>
                        <input type="radio" name="hosting" id="hosting-no" value="No" required>
                        <label for="hosting-no">No</label>
                    </div>
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
                        <tr>
                            <td>
                                {{ $addon->name }}
                                @if ($addon->description)
                                    <span class="rc-addons-table__desc">{{ $addon->description }}</span>
                                @endif
                            </td>
                            <td class="rc-addons-table__type">{{ str_replace('_', ' ', $addon->type) }}</td>
                            <td class="rc-addons-table__price">IDR {{ number_format($addon->price_idr / 1000) }}k</td>
                            <td class="rc-addons-table__price">${{ number_format($addon->price_usd) }}</td>
                            <td>
                                <input type="checkbox" name="addons[]" value="{{ $addon->id }}" id="addon_{{ $addon->id }}">
                                <label for="addon_{{ $addon->id }}" class="sr-only">Add {{ $addon->name }}</label>
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
                <button type="submit" name="submit" value="1" class="rc-btn rc-btn--fill rc-btn--lg">Checkout</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const plans = document.querySelectorAll('input[name="package"]');
    const landingNotice = document.getElementById('landingNotice');
    const promoBanner = document.getElementById('promoBanner');
    const promoWrap = document.getElementById('promoCheckWrap');
    const domainHostingWrap = document.getElementById('domainHostingWrap');
    const domainRadios = document.querySelectorAll('input[name="domain"]');
    const hostingRadios = document.querySelectorAll('input[name="hosting"]');

    function updatePlanUI() {
        const selected = document.querySelector('input[name="package"]:checked');
        if (!selected) return;
        const isLanding = selected.value === 'Student Plan';
        const hasFreeHosting = selected.dataset.freeHosting === '1';
        landingNotice.style.display = isLanding ? 'block' : 'none';
        if (promoBanner) promoBanner.style.display = hasFreeHosting ? 'block' : 'none';
        promoWrap.style.display = (isLanding || !hasFreeHosting) ? 'none' : '';
        domainHostingWrap.classList.toggle('hidden', isLanding);
        domainRadios.forEach(r => r.required = !isLanding);
        hostingRadios.forEach(r => r.required = !isLanding);
    }
    plans.forEach(p => p.addEventListener('change', updatePlanUI));
    updatePlanUI();
</script>
@endpush
</x-layouts.base>
