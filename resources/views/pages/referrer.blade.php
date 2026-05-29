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
    @vite(['resources/css/pages/referrer.css'])
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
