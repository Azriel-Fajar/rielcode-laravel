<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Brief | Rielcode</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico">
    <link rel="preload" href="/fonts/Inter-VariableFont.woff2" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="/fonts/Fraunces-VariableFont.woff2" as="font" type="font/woff2" crossorigin />
    @vite(['resources/css/pages/brief.css'])
</head>
<body>
<div class="brief-wrap">
    <span class="brief-eyebrow">// step 1: discovery</span>
    <h1 class="brief-title">Tell us about your project.</h1>
    <p class="brief-sub">Five short questions. Answer in your own words. No character limits, no perfect wording needed. The clearer you are, the better the site we build.</p>

    <div class="brief-order">
        <span><b>Client:</b> {{ $order->order_name }}</span>
        <span><b>Package:</b> {{ $order->package }}</span>
        <span><b>Order #:</b> {{ $order->id }}</span>
    </div>

    @if ($errors->any())
        <div class="brief-err">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('brief.store', ['t' => $token]) }}" autocomplete="off">
        @csrf
        <input type="hidden" name="t" value="{{ $token }}">

        <div class="brief-q">
            <label for="business">1. What does your business do?</label>
            <span class="hint">One paragraph. What you sell, who you sell to, what makes you you.</span>
            <textarea id="business" name="business" required maxlength="5000">{{ old('business') }}</textarea>
        </div>

        <div class="brief-q">
            <label for="goals">2. What do you want this website to achieve?</label>
            <span class="hint">More leads, sales, credibility, bookings, downloads. Pick whichever fits.</span>
            <textarea id="goals" name="goals" required maxlength="5000">{{ old('goals') }}</textarea>
        </div>

        <div class="brief-q">
            <label for="audience">3. Who is this website for?</label>
            <span class="hint">Age, role, location, what they care about, what they're trying to solve.</span>
            <textarea id="audience" name="audience" required maxlength="5000">{{ old('audience') }}</textarea>
        </div>

        <div class="brief-q">
            <label for="success">4. Six months from launch, what would make you say "this website worked"?</label>
            <span class="hint">Be specific if you can: number of leads, sales, sign-ups, anything measurable.</span>
            <textarea id="success" name="success" required maxlength="5000">{{ old('success') }}</textarea>
        </div>

        <div class="brief-q">
            <label for="brand_style">5. Brand style &amp; inspiration</label>
            <span class="hint">Brand colors, fonts, logo files, and 1–3 reference websites you love (paste URLs).</span>
            <textarea id="brand_style" name="brand_style" required maxlength="5000">{{ old('brand_style') }}</textarea>
        </div>

        <button type="submit" class="brief-submit" id="briefSubmit"><span class="brief-label">Submit brief</span></button>
    </form>
</div>
<script>
    (function () {
        var form = document.querySelector('form');
        var btn = document.getElementById('briefSubmit');
        if (!form || !btn) return;
        form.addEventListener('submit', function () {
            if (btn.disabled) return;
            btn.disabled = true;
            btn.innerHTML = '<span class="brief-spinner"></span><span class="brief-label">Submitting&hellip;</span>';
        });
    })();
</script>
</body>
</html>
