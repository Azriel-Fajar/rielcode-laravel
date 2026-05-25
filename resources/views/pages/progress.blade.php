<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Progress · Rielcode</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..900;1,9..144,300..900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --cream:        #1a1a1a;
            --cream-elev:   #242424;
            --ink:          #f4f1ea;
            --muted:        rgba(244,241,234,0.78);
            --faint:        rgba(244,241,234,0.70);
            --forest:       #4a6b58;
            --forest-mid:   #6b8f7a;
            --forest-pale:  rgba(74,107,88,0.18);
            --border:       rgba(244,241,234,0.14);
            --border-strong:rgba(244,241,234,0.28);
            --shadow-card:  0 8px 24px rgba(0,0,0,0.40);
            --radius:       10px;
            --font-display: 'Fraunces', Georgia, serif;
            --font-body:    'Inter', system-ui, sans-serif;
        }

        html {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: var(--cream);
            color: var(--ink);
        }

        body {
            margin: 0;
            font-family: var(--font-body);
            font-size: 15px;
            line-height: 1.6;
            background: var(--cream);
            color: var(--ink);
        }

        /* ── Nav ── */
        .pp-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 32px;
            border-bottom: 1px solid var(--border);
            background: var(--cream);
        }
        .pp-nav__brand {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            color: var(--ink);
        }
        .pp-nav__num {
            font-family: var(--font-body);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.08em;
            color: var(--muted);
        }
        .pp-nav__name {
            font-family: var(--font-display);
            font-size: 17px;
            font-weight: 500;
            color: var(--ink);
        }
        .pp-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.03em;
            border: 1px solid var(--border-strong);
            color: var(--muted);
            background: transparent;
        }
        .pp-badge--live {
            border-color: rgba(45,74,58,0.30);
            color: var(--forest);
            background: var(--forest-pale);
        }
        .pp-badge--archived {
            color: var(--muted);
        }
        .pp-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--forest);
            animation: blink 2.4s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{ opacity:1; } 50%{ opacity:.3; } }

        /* ── Layout ── */
        .pp-main {
            max-width: 840px;
            margin: 0 auto;
            padding: 56px 24px 100px;
        }

        /* ── Hero ── */
        .pp-hero {
            margin-bottom: 48px;
        }
        .pp-eyebrow {
            display: block;
            font-family: var(--font-body);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 12px;
        }
        .pp-hero__title {
            font-family: var(--font-display);
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 400;
            line-height: 1.12;
            letter-spacing: -0.015em;
            color: var(--ink);
            margin: 0 0 14px;
        }
        .pp-hero__title em { font-style: italic; }
        .pp-hero__meta {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--muted);
        }
        .pp-hero__sep { color: var(--border-strong); }
        .pp-hero__mono {
            font-family: 'JetBrains Mono', ui-monospace, monospace;
            font-size: 12px;
        }

        /* ── Cards ── */
        .pp-card {
            background: var(--cream-elev);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            box-shadow: var(--shadow-card);
        }
        .pp-card + .pp-card { margin-top: 16px; }
        .pp-card__head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .pp-card__title {
            font-family: var(--font-body);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--muted);
            margin: 0;
        }
        .pp-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.04em;
        }
        .pp-pill--stage {
            background: var(--forest-pale);
            color: var(--forest);
            border: 1px solid rgba(45,74,58,0.22);
        }
        .pp-pill--ready {
            background: var(--forest-pale);
            color: var(--forest);
            border: 1px solid rgba(45,74,58,0.22);
        }
        .pp-pill--pending {
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border-strong);
        }
        .pp-pill--count {
            background: var(--cream-elev);
            color: var(--muted);
            border: 1px solid var(--border);
        }

        /* ── Stage description ── */
        .pp-stage-desc {
            font-size: 14px;
            color: var(--muted);
            margin: 0 0 24px;
        }

        /* ── Stepper ── */
        .pp-stepper {
            display: flex;
            align-items: flex-start;
        }
        .pp-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 0 0 auto;
        }
        .pp-step__node {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1.5px solid var(--border-strong);
            background: var(--cream);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            transition: all 200ms ease;
        }
        .pp-step.is-done .pp-step__node {
            border-color: var(--forest);
            background: var(--forest);
            color: var(--cream);
        }
        .pp-step.is-active .pp-step__node {
            border-color: var(--forest);
            background: var(--forest-pale);
            color: var(--forest);
            font-weight: 700;
        }
        .pp-step__label {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: var(--faint);
            text-align: center;
            white-space: nowrap;
        }
        .pp-step.is-active .pp-step__label { color: var(--ink); font-weight: 600; }
        .pp-step.is-done .pp-step__label { color: var(--muted); }

        .pp-step__bar {
            flex: 1;
            height: 1.5px;
            background: var(--border);
            margin-top: 16px; /* align with center of node */
            min-width: 20px;
        }
        .pp-step__bar.is-done { background: var(--forest); }

        /* ── Grid ── */
        .pp-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 16px;
        }
        @media (max-width: 640px) {
            .pp-grid { grid-template-columns: 1fr; }
        }

        /* ── Preview card ── */
        .pp-url-row {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--cream);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 9px 12px;
            margin-bottom: 14px;
            overflow: hidden;
        }
        .pp-url-row svg { flex-shrink: 0; color: var(--muted); }
        .pp-url-row span {
            font-family: ui-monospace, monospace;
            font-size: 12px;
            color: var(--ink);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .pp-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: background 180ms ease, color 180ms ease;
        }
        .pp-btn--primary {
            background: var(--forest);
            color: var(--cream);
        }
        .pp-btn--primary:hover { background: var(--forest-mid); color: var(--cream); }
        .pp-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 16px;
            color: var(--faint);
            font-size: 13px;
            text-align: center;
        }
        .pp-empty--lg { padding: 24px 16px; }
        .pp-empty__icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0.35;
        }

        /* ── Summary ── */
        .pp-summary { font-size: 14px; }
        .pp-summary__row {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 9px 0;
            border-bottom: 1px solid var(--border);
            color: var(--muted);
        }
        .pp-summary__row b { color: var(--ink); font-weight: 600; }
        .pp-summary__total {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding: 14px 0 0;
            font-weight: 700;
            font-size: 15px;
            color: var(--ink);
        }

        /* ── Updates feed ── */
        .pp-feed { list-style: none; margin: 0; padding: 0; }
        .pp-feed__item {
            display: flex;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }
        .pp-feed__item:last-child { border-bottom: none; }
        .pp-feed__track {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
            padding-top: 5px;
            flex-shrink: 0;
        }
        .pp-feed__dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--forest);
            flex-shrink: 0;
        }
        .pp-feed__line {
            width: 1px;
            flex: 1;
            background: var(--border);
            margin-top: 4px;
        }
        .pp-feed__item:last-child .pp-feed__line { display: none; }
        .pp-feed__body { flex: 1; }
        .pp-feed__time {
            display: block;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--faint);
            margin-bottom: 6px;
        }
        .pp-feed__text {
            margin: 0;
            font-size: 14px;
            line-height: 1.65;
            color: var(--ink);
        }

        /* ── Footer ── */
        .pp-foot {
            margin-top: 56px;
            padding-top: 28px;
            border-top: 1px solid var(--border);
            text-align: center;
            color: var(--muted);
            font-size: 13px;
        }
        .pp-foot p { margin: 0 0 4px; }
        .pp-foot__private {
            font-size: 11px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            opacity: 0.55;
        }

        /* ── Check icon ── */
        .pp-check {
            display: inline-block;
            width: 14px;
            height: 14px;
            position: relative;
        }
        .pp-check::after {
            content: '';
            display: block;
            width: 5px;
            height: 9px;
            border-right: 2px solid currentColor;
            border-bottom: 2px solid currentColor;
            transform: rotate(45deg) translate(-1px, -1px);
            position: absolute;
            top: 1px;
            left: 4px;
        }

        @media (max-width: 480px) {
            .pp-nav { padding: 14px 16px; }
            .pp-main { padding: 36px 16px 80px; }
        }
    </style>
</head>
<body>

<nav class="pp-nav" role="navigation" aria-label="Site navigation">
    <a href="https://rielcode.com" class="pp-nav__brand" aria-label="Rielcode home">
        <span class="pp-nav__num">N°01</span>
        <span class="pp-nav__name">Rielcode</span>
    </a>
</nav>

<main class="pp-main">

    <header class="pp-hero" data-reveal>
        <span class="pp-eyebrow">Project Progress</span>
        <h1 class="pp-hero__title">Hi <em>{{ explode(' ', $order->order_name)[0] ?? 'there' }}</em>, here's where we are.</h1>
        <div class="pp-hero__meta">
            <span>{{ $order->package }}</span>
            @if ($order->invoice_number)
                <span class="pp-hero__sep" aria-hidden="true">·</span>
                <span class="pp-hero__mono">{{ $order->invoice_number }}</span>
            @endif
            @if ($order->created_at)
                <span class="pp-hero__sep" aria-hidden="true">·</span>
                <span>Started {{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</span>
            @endif
        </div>
    </header>

    {{-- Current Stage --}}
    <section class="pp-card" aria-labelledby="stage-heading" data-reveal>
        <div class="pp-card__head">
            <h2 class="pp-card__title" id="stage-heading">Current Stage</h2>
            <span class="pp-pill pp-pill--stage">{{ $stages[$currentStage]['label'] }}</span>
        </div>
        <p class="pp-stage-desc">{{ $stages[$currentStage]['desc'] }}</p>

        <div class="pp-stepper" role="list" aria-label="Project stages">
            @foreach ($stageKeys as $i => $key)
                @php
                    $isDone   = $i < $currentIndex;
                    $isActive = $i === $currentIndex;
                    $cls      = 'pp-step' . ($isDone ? ' is-done' : ($isActive ? ' is-active' : ''));
                    $label    = $stages[$key]['label'];
                    $aria     = $isDone ? "$label: completed" : ($isActive ? "$label: current stage" : "$label: upcoming");
                @endphp
                <div class="{{ $cls }}" role="listitem" aria-label="{{ $aria }}">
                    <div class="pp-step__node" aria-hidden="true">
                        @if ($isDone)
                            <span class="pp-check"></span>
                        @else
                            <span>{{ $i + 1 }}</span>
                        @endif
                    </div>
                    <div class="pp-step__label">{{ $label }}</div>
                </div>
                @if ($i < count($stageKeys) - 1)
                    <div class="pp-step__bar{{ $isDone ? ' is-done' : '' }}" aria-hidden="true"></div>
                @endif
            @endforeach
        </div>
    </section>

    <div class="pp-grid">

        {{-- Preview --}}
        <section class="pp-card" aria-labelledby="preview-heading" data-reveal>
            <div class="pp-card__head">
                <h2 class="pp-card__title" id="preview-heading">Preview</h2>
                @if ($order->staging_url)
                    <span class="pp-pill pp-pill--ready">
                        <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="12"/></svg>
                        Ready
                    </span>
                @else
                    <span class="pp-pill pp-pill--pending">Not yet</span>
                @endif
            </div>

            @if ($order->staging_url)
                <p class="pp-stage-desc">Your staging site is live. Preview it below.</p>
                <div class="pp-url-row" aria-label="Staging URL">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    <span>{{ $order->staging_url }}</span>
                </div>
                <a href="{{ $order->staging_url }}" target="_blank" rel="noopener noreferrer" class="pp-btn pp-btn--primary">
                    Open Preview
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
                </a>
            @else
                <div class="pp-empty" role="status" aria-live="polite">
                    <div class="pp-empty__icon" aria-hidden="true">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </div>
                    <span>Preview will appear once design is ready</span>
                </div>
            @endif
        </section>

        {{-- Order Summary --}}
        <section class="pp-card" aria-labelledby="summary-heading" data-reveal>
            <div class="pp-card__head">
                <h2 class="pp-card__title" id="summary-heading">Order Summary</h2>
            </div>
            <dl class="pp-summary">
                <div class="pp-summary__row">
                    <dt>Plan</dt>
                    <dd style="margin:0"><b>{{ $order->package }}</b></dd>
                </div>
                <div class="pp-summary__row">
                    <dt>Package price</dt>
                    <dd style="margin:0">
                        @if (($order->invoice_currency ?? 'IDR') === 'USD')
                            ${{ number_format($order->package_price ?? 0, 2) }}
                        @else
                            Rp{{ number_format($order->package_price ?? 0, 0, ',', '.') }}
                        @endif
                    </dd>
                </div>
                @if (isset($order->addons) && $order->addons && count($order->addons) > 0)
                    <div class="pp-summary__row" style="padding-left:12px;font-size:13px;">
                        <dt style="color:var(--faint);font-size:11px;font-weight:500;letter-spacing:.06em;text-transform:uppercase;padding-top:10px;padding-bottom:2px;border:none;" colspan="2">Add-ons</dt>
                    </div>
                    @foreach ($order->addons as $addon)
                        <div class="pp-summary__row" style="padding-left:12px;">
                            <dt>{{ $addon->name }}</dt>
                            <dd style="margin:0">
                                @if (($order->invoice_currency ?? 'IDR') === 'USD')
                                    ${{ number_format($addon->price ?? 0, 2) }}
                                @else
                                    Rp{{ number_format($addon->price ?? 0, 0, ',', '.') }}
                                @endif
                            </dd>
                        </div>
                    @endforeach
                @endif
                <div class="pp-summary__total">
                    <span>Total</span>
                    <span>
                        @if (($order->invoice_currency ?? 'IDR') === 'USD')
                            ${{ number_format($order->final_price ?? 0, 2) }}
                        @else
                            Rp{{ number_format($order->final_price ?? 0, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
            </dl>
        </section>

    </div>

    {{-- Latest Updates --}}
    <section class="pp-card" style="margin-top:16px;" aria-labelledby="updates-heading" data-reveal>
        <div class="pp-card__head">
            <h2 class="pp-card__title" id="updates-heading">Latest Updates</h2>
            <span class="pp-pill pp-pill--count" aria-label="{{ $notes->count() }} updates">{{ $notes->count() }}</span>
        </div>
        @if ($notes->isEmpty())
            <div class="pp-empty pp-empty--lg" role="status">
                <div class="pp-empty__icon" aria-hidden="true">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <span>No updates yet — we'll post here as work progresses.</span>
            </div>
        @else
            <ol class="pp-feed" aria-label="Project update timeline">
                @foreach ($notes as $note)
                    <li class="pp-feed__item">
                        <div class="pp-feed__track" aria-hidden="true">
                            <div class="pp-feed__dot"></div>
                            <div class="pp-feed__line"></div>
                        </div>
                        <div class="pp-feed__body">
                            <time class="pp-feed__time" datetime="{{ \Carbon\Carbon::parse($note->created_at)->toIso8601String() }}">
                                {{ \Carbon\Carbon::parse($note->created_at)->format('M j, Y · H:i') }}
                            </time>
                            <p class="pp-feed__text">{{ nl2br(e($note->note)) }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        @endif
    </section>

    <footer class="pp-foot" data-reveal>
        <p>Need to reach us? Reply to your order email or message Rielcode on WhatsApp.</p>
        <p class="pp-foot__private">Private link · do not share publicly</p>
    </footer>

</main>

<script>
(function () {
    var els = document.querySelectorAll('[data-reveal]');
    if (!els.length) return;
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.setAttribute('data-reveal', 'in'); io.unobserve(e.target); }
        });
    }, { threshold: 0.08 });
    els.forEach(function (el) {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 500ms cubic-bezier(0.22,0.61,0.36,1), transform 500ms cubic-bezier(0.22,0.61,0.36,1)';
        io.observe(el);
    });
    document.addEventListener('DOMContentLoaded', function () {
        els.forEach(function (el) {
            if (el.getBoundingClientRect().top < window.innerHeight) {
                el.setAttribute('data-reveal', 'in');
                el.style.opacity = '1';
                el.style.transform = 'none';
                io.unobserve(el);
            }
        });
    });
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        els.forEach(function (el) { el.style.opacity = '1'; el.style.transform = 'none'; el.style.transition = 'none'; });
    }
})();
</script>

</body>
</html>
