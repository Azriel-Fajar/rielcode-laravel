<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Progress · Rielcode</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        :root { --bg: #0b0d12; --surface: #141822; --border: #232838; --text: #e7e9ee; --muted: #a8adba; --accent: #3a7bff; --green: #4ade80; --yellow: #fbbf24; }
        body { background: var(--bg); color: var(--text); font-family: 'Poppins', system-ui, sans-serif; margin: 0; }
        .pp-header { display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; border-bottom: 1px solid var(--border); }
        .pp-brand img { height: 32px; }
        .pp-pill { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .pp-pill--live { background: rgba(74,222,128,.12); border: 1px solid rgba(74,222,128,.35); color: var(--green); }
        .pp-pill--archived { background: rgba(168,173,186,.1); border: 1px solid rgba(168,173,186,.3); color: var(--muted); }
        .pp-pill--ready { background: rgba(74,222,128,.12); border: 1px solid rgba(74,222,128,.35); color: var(--green); }
        .pp-pill--pending { background: rgba(251,191,36,.12); border: 1px solid rgba(251,191,36,.3); color: var(--yellow); }
        .pp-pill--count { background: var(--surface); border: 1px solid var(--border); color: var(--muted); }
        .pp-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--green); display: inline-block; animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: .4; } }
        .pp-main { max-width: 860px; margin: 0 auto; padding: 40px 20px 80px; }
        .pp-hero { margin-bottom: 32px; }
        .pp-eyebrow { font-size: 11px; text-transform: uppercase; letter-spacing: .1em; color: var(--muted); font-family: 'JetBrains Mono', monospace; }
        .pp-hero h1 { font-size: 1.8rem; font-weight: 700; margin: 8px 0 8px; }
        .pp-hero__sub { color: var(--muted); font-size: 14px; }
        .pp-sep { margin: 0 6px; color: var(--border); }
        .pp-mono { font-family: 'JetBrains Mono', monospace; }
        .pp-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 22px; margin-bottom: 20px; }
        .pp-card__head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
        .pp-card__head h2 { font-size: 1rem; font-weight: 600; margin: 0; }
        .pp-card__body { color: var(--muted); font-size: 14px; margin: 0 0 16px; }
        .pp-stage-label { font-size: 13px; font-weight: 600; color: var(--accent); }
        .pp-stage-desc { color: var(--muted); font-size: 14px; margin: 0 0 20px; }
        .pp-stepper { display: flex; align-items: center; flex-wrap: wrap; gap: 0; }
        .pp-step { display: flex; flex-direction: column; align-items: center; gap: 6px; min-width: 60px; }
        .pp-step__dot { width: 32px; height: 32px; border-radius: 50%; border: 2px solid var(--border); background: var(--bg); display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600; color: var(--muted); }
        .pp-step.is-done .pp-step__dot { border-color: var(--green); background: rgba(74,222,128,.15); color: var(--green); }
        .pp-step.is-active .pp-step__dot { border-color: var(--accent); background: rgba(58,123,255,.15); color: var(--accent); }
        .pp-step__label { font-size: 11px; color: var(--muted); text-align: center; white-space: nowrap; }
        .pp-step.is-active .pp-step__label { color: var(--text); font-weight: 600; }
        .pp-step__bar { flex: 1; height: 2px; background: var(--border); min-width: 20px; }
        .pp-step__bar.is-done { background: var(--green); }
        .pp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        @media (max-width: 600px) { .pp-grid { grid-template-columns: 1fr; } }
        .pp-url-box { background: var(--bg); border: 1px solid var(--border); border-radius: 8px; padding: 10px 14px; display: flex; align-items: center; gap: 10px; font-size: 13px; color: var(--muted); margin-bottom: 14px; overflow: hidden; }
        .pp-url-box .pp-mono { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text); }
        .pp-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; }
        .pp-btn--primary { background: var(--accent); color: #fff; }
        .pp-btn--primary:hover { background: #2c66e0; }
        .pp-empty { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 24px; color: var(--muted); font-size: 13px; }
        .pp-empty--lg { padding: 40px 24px; }
        .pp-empty i { font-size: 28px; opacity: .4; }
        .pp-summary { font-size: 14px; }
        .pp-summary__row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--border); }
        .pp-summary__row--addon { padding-left: 12px; color: var(--muted); }
        .pp-summary__divider { color: var(--muted); font-size: 11px; text-transform: uppercase; letter-spacing: .08em; padding: 10px 0 4px; }
        .pp-summary__total { display: flex; justify-content: space-between; padding: 12px 0 0; font-weight: 700; font-size: 15px; }
        .pp-qty { color: var(--muted); font-size: 12px; margin-left: 4px; }
        .pp-feed { list-style: none; margin: 0; padding: 0; }
        .pp-feed__item { display: flex; gap: 14px; padding: 14px 0; border-bottom: 1px solid var(--border); }
        .pp-feed__item:last-child { border-bottom: none; }
        .pp-feed__dot { width: 10px; height: 10px; border-radius: 50%; background: var(--accent); margin-top: 5px; flex-shrink: 0; }
        .pp-feed__body { flex: 1; }
        .pp-feed__time { display: block; font-size: 12px; color: var(--muted); margin-bottom: 4px; }
        .pp-feed__body p { margin: 0; font-size: 14px; line-height: 1.6; }
        .pp-foot { margin-top: 40px; padding-top: 24px; border-top: 1px solid var(--border); color: var(--muted); font-size: 13px; text-align: center; }
        .pp-foot__small { font-size: 11px; opacity: .5; margin-top: 4px; }
    </style>
</head>
<body>

<header class="pp-header">
    <a href="https://rielcode.com" class="pp-brand">
        <img src="https://rielcode.com/IMG/Rielcode%20Logo%20Transparent.png" alt="Rielcode">
    </a>
    <div>
        @if ($archived)
            <span class="pp-pill pp-pill--archived"><i class="bi bi-archive"></i> Archived</span>
        @else
            <span class="pp-pill pp-pill--live"><span class="pp-dot"></span> Live</span>
        @endif
    </div>
</header>

<main class="pp-main">

    <section class="pp-hero">
        <span class="pp-eyebrow">project progress</span>
        <h1>Hi {{ explode(' ', $order->order_name)[0] ?? 'there' }}, here's where we are.</h1>
        <p class="pp-hero__sub">
            {{ $order->package }}
            @if ($order->invoice_number)
                <span class="pp-sep">·</span><span class="pp-mono">{{ $order->invoice_number }}</span>
            @endif
            @if ($order->created_at)
                <span class="pp-sep">·</span>Started {{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}
            @endif
        </p>
    </section>

    <section class="pp-card pp-stage-card">
        <div class="pp-card__head">
            <h2>Current Stage</h2>
            <span class="pp-stage-label">{{ $stages[$currentStage]['label'] }}</span>
        </div>
        <p class="pp-stage-desc">{{ $stages[$currentStage]['desc'] }}</p>

        <div class="pp-stepper">
            @foreach ($stageKeys as $i => $key)
                @php
                    $cls = 'pp-step';
                    if ($i < $currentIndex) $cls .= ' is-done';
                    elseif ($i === $currentIndex) $cls .= ' is-active';
                @endphp
                <div class="{{ $cls }}">
                    <div class="pp-step__dot">
                        @if ($i < $currentIndex)
                            <i class="bi bi-check-lg"></i>
                        @else
                            <span>{{ $i + 1 }}</span>
                        @endif
                    </div>
                    <div class="pp-step__label">{{ $stages[$key]['label'] }}</div>
                </div>
                @if ($i < count($stageKeys) - 1)
                    <div class="pp-step__bar{{ $i < $currentIndex ? ' is-done' : '' }}"></div>
                @endif
            @endforeach
        </div>
    </section>

    <div class="pp-grid">

        <section class="pp-card pp-preview-card">
            <div class="pp-card__head">
                <h2>Preview</h2>
                @if ($order->staging_url)
                    <span class="pp-pill pp-pill--ready"><i class="bi bi-broadcast"></i> Ready</span>
                @else
                    <span class="pp-pill pp-pill--pending"><i class="bi bi-hourglass-split"></i> Not yet</span>
                @endif
            </div>
            @if ($order->staging_url)
                <p class="pp-card__body">Your staging site is live. Click below to preview.</p>
                <div class="pp-url-box">
                    <i class="bi bi-globe2"></i>
                    <span class="pp-mono">{{ $order->staging_url }}</span>
                </div>
                <a href="{{ $order->staging_url }}" target="_blank" rel="noopener" class="pp-btn pp-btn--primary">
                    <i class="bi bi-box-arrow-up-right"></i> Open Preview
                </a>
            @else
                <p class="pp-card__body">Your staging preview link will appear here once design is ready.</p>
                <div class="pp-empty">
                    <i class="bi bi-eye-slash"></i>
                    <span>Preview will appear here</span>
                </div>
            @endif
        </section>

        <section class="pp-card pp-summary-card">
            <div class="pp-card__head">
                <h2>Order Summary</h2>
            </div>
            <div class="pp-summary">
                <div class="pp-summary__row">
                    <span>Plan</span>
                    <b>{{ $order->package }}</b>
                </div>
                <div class="pp-summary__row">
                    <span>Package price</span>
                    <span>
                        @if (($order->invoice_currency ?? 'IDR') === 'USD')
                            ${{ number_format($order->package_price ?? 0, 2) }}
                        @else
                            Rp{{ number_format($order->package_price ?? 0, 0, ',', '.') }}
                        @endif
                    </span>
                </div>
                <div class="pp-summary__total">
                    <span>Total</span>
                    <b>
                        @if (($order->invoice_currency ?? 'IDR') === 'USD')
                            ${{ number_format($order->final_price ?? 0, 2) }}
                        @else
                            Rp{{ number_format($order->final_price ?? 0, 0, ',', '.') }}
                        @endif
                    </b>
                </div>
            </div>
        </section>

    </div>

    <section class="pp-card pp-notes-card">
        <div class="pp-card__head">
            <h2>Latest Updates</h2>
            <span class="pp-pill pp-pill--count">{{ $notes->count() }}</span>
        </div>
        @if ($notes->isEmpty())
            <div class="pp-empty pp-empty--lg">
                <i class="bi bi-chat-square-text"></i>
                <span>No updates yet. We'll post here as work progresses.</span>
            </div>
        @else
            <ol class="pp-feed">
                @foreach ($notes as $note)
                    <li class="pp-feed__item">
                        <div class="pp-feed__dot"></div>
                        <div class="pp-feed__body">
                            <time class="pp-feed__time">{{ \Carbon\Carbon::parse($note->created_at)->format('M j, Y · H:i') }}</time>
                            <p>{{ nl2br(e($note->note)) }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        @endif
    </section>

    <footer class="pp-foot">
        <p>Need to reach us? Reply to your order email or message Rielcode on WhatsApp.</p>
        <p class="pp-foot__small">Private link · do not share publicly</p>
    </footer>

</main>

</body>
</html>
