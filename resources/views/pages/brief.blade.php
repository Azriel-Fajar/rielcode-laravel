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
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { background: #0b0d12; color: #e7e9ee; font-family: 'Inter', system-ui, sans-serif; margin: 0; }
        .brief-wrap { max-width: 720px; margin: 0 auto; padding: 56px 22px 80px; }
        .brief-eyebrow { font-family: 'JetBrains Mono', ui-monospace, Menlo, monospace; font-size: 12px; letter-spacing: .12em; color: #8ab4ff; text-transform: uppercase; }
        .brief-title { font-size: 38px; line-height: 1.1; margin: 8px 0 12px; font-weight: 700; }
        .brief-sub { color: #a8adba; margin: 0 0 28px; }
        .brief-order { background: #141822; border: 1px solid #232838; border-radius: 10px; padding: 14px 18px; margin-bottom: 32px; display: flex; gap: 18px; flex-wrap: wrap; font-size: 14px; }
        .brief-order b { color: #fff; }
        .brief-q { margin-bottom: 26px; }
        .brief-q label { display: block; font-weight: 600; margin-bottom: 8px; color: #fff; }
        .brief-q .hint { display: block; font-size: 13px; color: #8a90a0; margin-bottom: 10px; }
        .brief-q textarea { width: 100%; background: #141822; border: 1px solid #2a3043; border-radius: 8px; padding: 12px 14px; color: #e7e9ee; font-family: inherit; font-size: 15px; line-height: 1.55; resize: vertical; min-height: 110px; }
        .brief-q textarea:focus { outline: none; border-color: #3a7bff; box-shadow: 0 0 0 3px rgba(58,123,255,.18); }
        .brief-submit { display: inline-flex; align-items: center; background: #2d4a3a; color: #f4f1ea; border: 2px solid #2d4a3a; border-radius: 8px; padding: 13px 28px; font-size: 16px; font-weight: 600; cursor: pointer; font-family: inherit; transition: background .15s, border-color .15s; }
        .brief-submit:hover { background: #4a6b58; border-color: #4a6b58; }
        .brief-err { background: #3a1722; border: 1px solid #6b2235; color: #ffb3c1; padding: 12px 16px; border-radius: 8px; margin-bottom: 22px; font-size: 14px; }
    </style>
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

    <form method="POST" action="{{ route('brief.store') }}" autocomplete="off">
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

        <button type="submit" class="brief-submit">Submit brief</button>
    </form>
</div>
</body>
</html>
