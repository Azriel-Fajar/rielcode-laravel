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
        :root {
            --rc-cream: #f4f1ea;
            --rc-cream-elev: #ebe7dc;
            --rc-ink: #1a1a1a;
            --rc-forest: #2d4a3a;
            --rc-forest-mid: #4a6b58;
            --rc-bg: var(--rc-cream);
            --rc-bg-elev: var(--rc-cream-elev);
            --rc-text: var(--rc-ink);
            --rc-text-muted: rgba(26, 26, 26, 0.72);
            --rc-text-faint: rgba(26, 26, 26, 0.62);
            --rc-accent: var(--rc-forest);
            --rc-accent-hover: var(--rc-forest-mid);
            --rc-on-accent: var(--rc-cream);
            --rc-border: rgba(26, 26, 26, 0.12);
            --rc-border-strong: rgba(26, 26, 26, 0.24);
        }
        *, *::before, *::after { box-sizing: border-box; }
        body { background: var(--rc-bg); color: var(--rc-text); font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif; margin: 0; }
        .brief-wrap { max-width: 720px; margin: 0 auto; padding: 56px 22px 80px; }
        .brief-eyebrow { font-family: 'JetBrains Mono', ui-monospace, Menlo, monospace; font-size: 12px; letter-spacing: .12em; color: var(--rc-accent); text-transform: uppercase; }
        .brief-title { font-family: 'Fraunces', Georgia, 'Times New Roman', serif; font-size: 40px; line-height: 1.15; margin: 8px 0 12px; font-weight: 700; color: var(--rc-text); }
        .brief-sub { color: var(--rc-text-muted); margin: 0 0 28px; }
        .brief-order { background: var(--rc-bg-elev); border: 1px solid var(--rc-border); border-radius: 8px; padding: 14px 18px; margin-bottom: 32px; display: flex; gap: 18px; flex-wrap: wrap; font-size: 14px; }
        .brief-order b { color: var(--rc-text); }
        .brief-q { margin-bottom: 26px; }
        .brief-q label { display: block; font-weight: 600; margin-bottom: 8px; color: var(--rc-text); }
        .brief-q .hint { display: block; font-size: 13px; color: var(--rc-text-faint); margin-bottom: 10px; }
        .brief-q textarea { width: 100%; background: #fff; border: 1px solid var(--rc-border-strong); border-radius: 8px; padding: 12px 14px; color: var(--rc-text); font-family: inherit; font-size: 15px; line-height: 1.55; resize: vertical; min-height: 110px; }
        .brief-q textarea:focus { outline: none; border-color: var(--rc-accent); box-shadow: 0 0 0 3px rgba(45,74,58,.18); }
        .brief-submit { display: inline-flex; align-items: center; background: var(--rc-accent); color: var(--rc-on-accent); border: 2px solid var(--rc-accent); border-radius: 8px; padding: 13px 28px; font-size: 16px; font-weight: 600; cursor: pointer; font-family: inherit; transition: background .15s, border-color .15s; }
        .brief-submit:hover { background: var(--rc-accent-hover); border-color: var(--rc-accent-hover); }
        .brief-submit:disabled { opacity: .75; cursor: progress; }
        .brief-spinner { width: 16px; height: 16px; margin-right: 10px; border: 2px solid rgba(244,241,234,.4); border-top-color: var(--rc-on-accent); border-radius: 50%; animation: brief-spin .6s linear infinite; }
        @keyframes brief-spin { to { transform: rotate(360deg); } }
        .brief-err { background: #fbe9ec; border: 1px solid #e0a4ad; color: #8a2335; padding: 12px 16px; border-radius: 8px; margin-bottom: 22px; font-size: 14px; }
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
