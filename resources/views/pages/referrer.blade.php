<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referrer Dashboard | Rielcode</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { background: #0b0d12; color: #e7e9ee; font-family: 'Outfit', system-ui, sans-serif; margin: 0; }
        .ref-wrap { max-width: 860px; margin: 0 auto; padding: 40px 20px 80px; }
        .ref-logo { height: 36px; margin-bottom: 32px; }
        .ref-card { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 12px; padding: 24px; }
        .ref-label { font-size: 11px; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 4px; font-family: 'JetBrains Mono', monospace; }
        .ref-name { font-size: 1.6rem; font-weight: 700; margin: 0 0 4px; }
        .ref-meta { color: rgba(255,255,255,.4); font-size: 14px; }
        .ref-code { font-family: 'JetBrains Mono', monospace; font-weight: 600; color: #60a5fa; }
        .ref-rate { color: #4ade80; }
        .ref-stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; margin: 28px 0; }
        .ref-stat { background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 10px; padding: 18px 20px; }
        .ref-stat__label { font-size: 11px; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 6px; font-family: 'JetBrains Mono', monospace; }
        .ref-stat__value { font-size: 1.4rem; font-weight: 700; }
        .ref-h2 { font-size: 1rem; font-weight: 600; color: rgba(255,255,255,.7); margin-bottom: 16px; }
        .ref-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .ref-table th { text-align: left; padding: 10px 14px; color: rgba(255,255,255,.4); font-size: 11px; text-transform: uppercase; letter-spacing: .08em; border-bottom: 1px solid rgba(255,255,255,.08); font-family: 'JetBrains Mono', monospace; }
        .ref-table td { padding: 12px 14px; border-bottom: 1px solid rgba(255,255,255,.05); color: rgba(255,255,255,.8); }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge--pending   { background: rgba(251,191,36,.12); border: 1px solid rgba(251,191,36,.35); color: #fbbf24; }
        .badge--paid      { background: rgba(34,197,94,.12);  border: 1px solid rgba(34,197,94,.35);  color: #4ade80; }
        .badge--cancelled { background: rgba(239,68,68,.10);  border: 1px solid rgba(239,68,68,.30);  color: #f87171; }
        .ref-empty { color: rgba(255,255,255,.3); font-size: 14px; }
        .ref-foot { margin-top: 40px; font-size: 11px; color: rgba(255,255,255,.2); text-align: center; }
        .overflow-x { overflow-x: auto; }
    </style>
</head>
<body>
<div class="ref-wrap">

    <img src="https://rielcode.com/IMG/Rielcode%20Logo%20Transparent.png" alt="Rielcode" class="ref-logo">

    <div class="ref-card" style="margin-bottom: 0;">
        <p class="ref-label">Referrer Dashboard</p>
        <h1 class="ref-name">{{ $referrer->name }}</h1>
        <p class="ref-meta">
            Code: <span class="ref-code">{{ $referrer->code }}</span>
            &nbsp;&middot;&nbsp;
            Commission rate: <span class="ref-rate">{{ number_format((float) $referrer->commission_rate, 2) }}%</span>
        </p>
    </div>

    <div class="ref-stat-grid">
        <div class="ref-stat">
            <div class="ref-stat__label">Total Referrals</div>
            <div class="ref-stat__value">{{ (int) ($stats->total_referrals ?? 0) }}</div>
        </div>
        <div class="ref-stat">
            <div class="ref-stat__label">Commission Earned</div>
            <div class="ref-stat__value" style="color:#4ade80;">Rp{{ number_format((float) ($stats->total_earned ?? 0), 0, ',', '.') }}</div>
        </div>
        <div class="ref-stat">
            <div class="ref-stat__label">Pending Payout</div>
            <div class="ref-stat__value" style="color:#fbbf24;">Rp{{ number_format((float) ($stats->total_pending ?? 0), 0, ',', '.') }}</div>
        </div>
    </div>

    <h2 class="ref-h2">Commission History</h2>

    @if ($commissions->isEmpty())
        <p class="ref-empty">No commissions yet. Share your referral code to get started.</p>
    @else
        <div class="overflow-x">
            <table class="ref-table">
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
                        <td style="color:rgba(255,255,255,.5);font-size:12px;">{{ \Carbon\Carbon::parse($com->created_at)->format('Y-m-d') }}</td>
                        <td>{{ $com->package_name }}</td>
                        <td>Rp{{ number_format((float) $com->order_amount, 0, ',', '.') }}</td>
                        <td style="font-weight:600;color:#4ade80;">Rp{{ number_format((float) $com->commission_amount, 0, ',', '.') }}</td>
                        <td><span class="badge badge--{{ $com->status }}">{{ ucfirst($com->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <p class="ref-foot">This dashboard is read-only. Contact Rielcode for any questions about your commissions.</p>

</div>
</body>
</html>
