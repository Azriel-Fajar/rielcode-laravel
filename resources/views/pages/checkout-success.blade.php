<x-layouts.base
    title="Checkout Successful | Rielcode"
    description="Your Rielcode order has been confirmed."
    bodyClass="rc-redesign"
>
@push('head')
<meta name="robots" content="noindex, nofollow">
@endpush

<div class="popup">
    <div class="circle" role="img" aria-label="Order confirmed">
        <div class="checkmark"></div>
    </div>
    <span class="rc-eyebrow" style="margin-bottom:8px;">checkout complete</span>
    <h2 class="rc-h2">Order Completed!</h2>
    <p class="rc-body">Thank you for your purchase. Your order has been successfully processed.</p>

    @if ($progressUrl)
    <div class="progress-reveal">
        <span class="progress-reveal__label">your private project link</span>
        <h3>Track your project progress</h3>
        <p>This link is unique to your order. Use it anytime to see your current stage, latest updates from the team, and your preview site when it's ready.</p>
        <div class="progress-reveal__urlbox">
            <input id="progressUrl" type="text" readonly value="{{ $progressUrl }}">
            <button type="button" class="progress-reveal__copy" id="progressCopyBtn">Copy</button>
        </div>
        <a class="progress-reveal__open" href="{{ $progressUrl }}" target="_blank" rel="noopener">
            Open Progress Portal
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
        </a>
        <p class="progress-reveal__warn">Save this link — we've also sent it to your email. Anyone with this link can view your project status.</p>
    </div>
    @endif

    <a href="/" class="btn" style="margin-top:18px;"><span class="btn-arrow" aria-hidden="true">&#8592;</span> Back to Home</a>
</div>

@push('scripts')
<script>
(function(){
    var btn = document.getElementById('progressCopyBtn');
    var inp = document.getElementById('progressUrl');
    if (!btn || !inp) return;
    btn.addEventListener('click', function(){
        inp.select(); inp.setSelectionRange(0, 9999);
        var done = function(){ btn.textContent = 'Copied'; setTimeout(function(){ btn.textContent = 'Copy'; }, 1800); };
        if (navigator.clipboard) { navigator.clipboard.writeText(inp.value).then(done).catch(function(){ document.execCommand('copy'); done(); }); }
        else { document.execCommand('copy'); done(); }
    });
})();
</script>
@endpush
</x-layouts.base>
