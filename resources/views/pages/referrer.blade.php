<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referrer Dashboard · Rielcode</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="/IMG/Rielcode Logo Square Transparent Icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..900;1,9..144,300..900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --bg:           #1a1a1a;
            --bg-elev:      #242424;
            --ink:          #f4f1ea;
            --muted:        rgba(244, 241, 234, 0.78);
            --faint:        rgba(244, 241, 234, 0.48);
            --forest:       #4a6b58;
            --forest-mid:   #6b8f7a;
            --forest-pale:  rgba(74, 107, 88, 0.18);
            --gold:         #c9a84c;
            --gold-pale:    rgba(201, 168, 76, 0.14);
            --red:          #c0392b;
            --red-pale:     rgba(192, 57, 43, 0.12);
            --border:       rgba(244, 241, 234, 0.10);
            --border-mid:   rgba(244, 241, 234, 0.18);
            --shadow:       0 8px 24px rgba(0,0,0,.40);
            --radius:       10px;
            --font-display: 'Fraunces', Georgia, serif;
            --font-body:    'Inter', system-ui, sans-serif;
            --font-mono:    'JetBrains Mono', ui-monospace, monospace;
        }

        html { -webkit-font-smoothing: antialiased; background: var(--bg); color: var(--ink); }
        body  { margin: 0; font-family: var(--font-body); font-size: 15px; line-height: 1.6; background: var(--bg); }

        /* ── Nav ── */
        .nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 32px;
            border-bottom: 1px solid var(--border);
            background: var(--bg);
        }
        .nav__brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav__logo  { height: 28px; }
        .nav__label {
            font-size: 11px; font-weight: 500; letter-spacing: 0.10em;
            text-transform: uppercase; color: var(--faint);
        }
        .nav__pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 5px 12px; border-radius: 999px; font-size: 12px;
            font-weight: 500; letter-spacing: 0.03em;
            border: 1px solid rgba(74,107,88,.35);
            color: var(--forest-mid); background: var(--forest-pale);
        }
        .nav__dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: var(--forest-mid);
            animation: blink 2.4s ease-in-out infinite;
        }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

        /* ── Layout ── */
        .main { max-width: 860px; margin: 0 auto; padding: 56px 24px 100px; }

        /* ── Hero ── */
        .eyebrow {
            display: block; font-size: 11px; font-weight: 500;
            letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--faint); margin-bottom: 12px;
        }
        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(28px, 4vw, 40px); font-weight: 400;
            line-height: 1.12; letter-spacing: -0.015em;
            color: var(--ink); margin: 0 0 14px;
        }
        .hero-title em { font-style: italic; }
        .hero-meta { display: flex; flex-wrap: wrap; gap: 6px 16px; font-size: 13px; color: var(--muted); margin-top: 4px; }
        .hero-meta__code { font-family: var(--font-mono); font-size: 12px; color: var(--forest-mid); font-weight: 500; }
        .hero-meta__rate { color: var(--forest-mid); font-weight: 600; }

        /* ── Stat grid ── */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; margin: 40px 0 48px; }
        .stat-card {
            background: var(--bg-elev); border: 1px solid var(--border);
            border-radius: var(--radius); padding: 20px 22px;
        }
        .stat-card__label {
            font-size: 10px; font-weight: 600; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--faint); margin-bottom: 8px;
        }
        .stat-card__value { font-size: 1.5rem; font-weight: 600; color: var(--ink); }
        .stat-card__value--green  { color: var(--forest-mid); }
        .stat-card__value--gold   { color: var(--gold); }

        /* ── Section heading ── */
        .section-label {
            font-size: 11px; font-weight: 600; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--faint);
            margin: 0 0 20px;
        }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        thead th {
            text-align: left; padding: 10px 14px;
            font-size: 10px; font-weight: 600; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--faint);
            border-bottom: 1px solid var(--border-mid);
        }
        tbody td {
            padding: 13px 14px; border-bottom: 1px solid var(--border);
            color: var(--muted); vertical-align: middle;
        }
        tbody tr:last-child td { border-bottom: none; }
        .td-date  { font-size: 12px; font-family: var(--font-mono); color: var(--faint); }
        .td-pkg   { color: var(--ink); font-weight: 500; }
        .td-amt   { font-family: var(--font-mono); font-size: 13px; }
        .td-comm  { font-family: var(--font-mono); font-size: 13px; font-weight: 600; color: var(--forest-mid); }

        /* ── Badges ── */
        .badge {
            display: inline-block; padding: 3px 10px; border-radius: 999px;
            font-size: 11px; font-weight: 600; letter-spacing: 0.04em;
        }
        .badge--pending  { background: var(--gold-pale);  border: 1px solid rgba(201,168,76,.30);  color: var(--gold); }
        .badge--paid     { background: var(--forest-pale); border: 1px solid rgba(74,107,88,.35);  color: var(--forest-mid); }
        .badge--cancelled{ background: var(--red-pale);   border: 1px solid rgba(192,57,43,.25);   color: #e05c4f; }

        /* ── Empty ── */
        .empty { padding: 40px 0; font-size: 14px; color: var(--faint); }

        /* ── Footer ── */
        .foot {
            margin-top: 48px; padding-top: 24px;
            border-top: 1px solid var(--border);
            font-size: 12px; color: var(--faint);
            display: flex; align-items: center; gap: 8px;
        }

        @media (max-width: 600px) {
            .nav { padding: 16px 20px; }
            .main { padding: 40px 20px 80px; }
            .stat-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

<nav class="nav">
    <a href="https://rielcode.com" class="nav__brand">
        <img src="https://rielcode.com/IMG/Rielcode%20Logo%20Transparent.png" alt="Rielcode" class="nav__logo">
        <span class="nav__label">Referrer Portal</span>
    </a>
    <span class="nav__pill">
        <span class="nav__dot"></span>
        Active
    </span>
</nav>

<main class="main">

    <span class="eyebrow">Referrer Dashboard</span>
    <h1 class="hero-title"><em>{{ $referrer->name }}</em></h1>
    <div class="hero-meta">
        <span>Code: <span class="hero-meta__code">{{ $referrer->code }}</span></span>
        <span>Commission: <span class="hero-meta__rate">{{ number_format((float) $referrer->commission_rate, 2) }}%</span></span>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-card__label">Total Referrals</div>
            <div class="stat-card__value">{{ (int) ($stats->total_referrals ?? 0) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__label">Commission Earned</div>
            <div class="stat-card__value stat-card__value--green">Rp{{ number_format((float) ($stats->total_earned ?? 0), 0, ',', '.') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card__label">Pending Payout</div>
            <div class="stat-card__value stat-card__value--gold">Rp{{ number_format((float) ($stats->total_pending ?? 0), 0, ',', '.') }}</div>
        </div>
    </div>

    <p class="section-label">Commission History</p>

    @if ($commissions->isEmpty())
        <p class="empty">No commissions yet — share your referral code to get started.</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Package</th>
                        <th>Order Amount</th>
                        <th>Commission</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($commissions as $com)
                    <tr>
                        <td class="td-date">{{ \Carbon\Carbon::parse($com->created_at)->format('Y-m-d') }}</td>
                        <td class="td-pkg">{{ $com->package_name }}</td>
                        <td class="td-amt">Rp{{ number_format((float) $com->order_amount, 0, ',', '.') }}</td>
                        <td class="td-comm">Rp{{ number_format((float) $com->commission_amount, 0, ',', '.') }}</td>
                        <td><span class="badge badge--{{ $com->status }}">{{ ucfirst($com->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <footer class="foot">
        <span>This dashboard is read-only.</span>
        <span>·</span>
        <span>Contact Rielcode for commission questions.</span>
    </footer>

</main>

</body>
</html>
