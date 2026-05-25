<x-layouts.base
    title="Checkout | Rielcode"
    description="Review and confirm your Rielcode order."
    bodyClass="rc-redesign"
>
@push('head')
<meta name="robots" content="noindex, nofollow">
@endpush

<div class="checkout-container p-6">
    <div class="checkout-heading flex flex-col items-center" style="gap:10px;margin-bottom:24px;">
        <span class="rc-eyebrow">checkout step 02</span>
        <h1 class="rc-h1 text-white font-bold">Checkout Confirmation</h1>
        <p class="rc-body" style="margin:0;">Review your order before confirming.</p>
    </div>

    <div class="info-container">
        <div class="personal-info">
            <div class="order-name">
                <p>Billed to: <b>{{ strtoupper($order->order_name) }}</b></p>
                <span>{{ $order->email }}</span>
            </div>
            <div class="package-type">
                <p>Package type: <b>{{ $order->package }}</b></p>
                <span>{{ $order->phone_number }}</span>
            </div>
        </div>

        @php
            $isStudentPlan    = $order->package === 'Student Plan';
            $claimedFreePromo = str_contains($order->description ?? '', 'Free Hosting') && str_contains($order->description ?? '', 'Promo');
            $needsDomainWarning  = !$isStudentPlan && !$claimedFreePromo && $order->owns_domain === 'No';
            $needsHostingWarning = !$isStudentPlan && !$claimedFreePromo && $order->owns_hosting === 'No';
        @endphp

        @if ($isStudentPlan)
            <div class="landing-note">&#9888; Note: Student Plan does not include free hosting or domain. Website design only.</div>
        @elseif ($claimedFreePromo)
            <div class="landing-note" style="background:rgba(62,207,142,0.08);border-color:rgba(62,207,142,0.25);color:#3ecf8e;">
                &#10003; Free hosting &amp; .COM domain included via promo.
            </div>
        @elseif ($needsHostingWarning || $needsDomainWarning)
            <div class="landing-note">
                &#9888; Note: You indicated you don't have {{ collect(['hosting' => $needsHostingWarning, 'domain' => $needsDomainWarning])->filter()->keys()->implode(' or ') }}.
                Rielcode will help set up free {{ collect(['hosting' => $needsHostingWarning, 'domain' => $needsDomainWarning])->filter()->keys()->implode(' &amp; ') }} based on your package.
            </div>
        @endif

        <div class="purchase-info">
            <h3>Purchase Information</h3>
            <div class="package-price">
                <p>Package price{{ $order->package !== 'Custom Plan' ? ' (before discount)' : '' }}</p>
                <span>Rp{{ number_format($order->package !== 'Custom Plan' ? $displayOriginal : $packagePrice, 0, ',', '.') }}</span>
            </div>

            @if ($order->package === 'Custom Plan' && $order->custom_config)
            @php $cfg = $order->custom_config; @endphp
            <div class="custom-specs" style="margin-top:14px;padding:12px 14px;background:rgba(58,123,255,0.07);border:1px solid rgba(58,123,255,0.2);border-radius:10px;">
                <p style="font-size:13px;font-weight:600;color:#6fa3ff;margin:0 0 8px;">Custom Plan Specifications</p>
                <ul style="margin:0;padding:0 0 0 16px;font-size:13px;color:rgba(255,255,255,0.8);line-height:1.8;">
                    <li>Type: <b>{{ ucfirst($order->custom_preset) }} Website</b></li>
                    @if ($order->custom_preset === 'copy' && $order->copy_source_url)
                    <li>Reference URL: <b>{{ $order->copy_source_url }}</b></li>
                    @endif
                    @if (!empty($cfg['pages']))<li>Pages: <b>{{ (int) $cfg['pages'] }}</b></li>@endif
                    @if (!empty($cfg['maintenance']))<li>Maintenance: <b>{{ (int) $cfg['maintenance'] }} month{{ (int) $cfg['maintenance'] > 1 ? 's' : '' }}</b></li>@endif
                    @if (!empty($cfg['features']))<li>Features: <b>{{ implode(', ', $cfg['features']) }}</b></li>@endif
                </ul>
            </div>
            @endif
        </div>

        @if ($order->package !== 'Custom Plan')
        <div class="discount-info">
            <h3>Discount</h3>
            <div class="discount-price">
                <p>Introductory Price (<b>50%</b>)</p>
                <span>-Rp{{ number_format($discountPrice, 0, ',', '.') }}</span>
            </div>
            @if (!$isStudentPlan)
            <div class="discount-price" style="color:#3ecf8e;">
                <p>Free hosting (1 year) + free .com/.id domain</p>
                <span>Included</span>
            </div>
            @endif
        </div>
        @endif

        <div class="total-info">
            <h3>Total</h3>
            <div class="total-price">
                <p>Grand Total</p>
                <span>Rp{{ number_format($packagePrice, 0, ',', '.') }}</span>
            </div>
        </div>

        @if (session('referralError'))
        <div style="color:#f87171;font-size:13px;margin-bottom:10px;">{{ session('referralError') }}</div>
        @endif

        <form method="post" action="{{ route('checkout.confirm') }}" id="checkoutForm">
            @csrf
            <div style="margin-bottom:16px;">
                <label for="referral_code" style="display:block;font-size:13px;color:rgba(255,255,255,0.6);margin-bottom:6px;">Referral Code (optional)</label>
                <input type="text" name="referral_code" id="referral_code" class="referral-input" placeholder="e.g. BUDI10" value="{{ old('referral_code', $rawCode) }}">
                <p style="color:rgba(255,255,255,0.45);font-size:12px;margin-top:6px;">Code applied at confirmation.</p>
            </div>
            <div class="checkbox">
                <input type="checkbox" name="terms" id="terms" required>
                <label for="terms">I agree to the <a href="{{ route('terms') }}">terms &amp; conditions</a> as set out by the user agreement.</label>
            </div>
            <button class="rc-btn rc-btn--fill rc-btn--lg" id="checkoutBtn" type="submit">Confirm</button>
        </form>
        <script>
        document.getElementById('checkoutForm').addEventListener('submit', function() {
            var btn = document.getElementById('checkoutBtn');
            btn.disabled = true;
            btn.textContent = 'Processing…';
        });
        </script>
    </div>
</div>
</x-layouts.base>
