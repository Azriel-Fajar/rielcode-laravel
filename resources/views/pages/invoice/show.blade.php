<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $payment->invoice_number }} | Rielcode</title>
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css'])
    <style>
        body {
            background: var(--rc-ink-900, #0a0a0a);
            color: #fff;
            font-family: var(--rc-font-body, 'Inter', sans-serif);
            min-height: 100vh;
            margin: 0;
            padding: 24px 16px 60px;
        }
        .invoice-wrap {
            max-width: 640px;
            margin: 0 auto;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 32px;
        }
        .brand-name {
            font-family: var(--rc-font-display, 'Fraunces', serif);
            font-size: 22px;
            color: var(--rc-cream, #f4f1ea);
        }
        .brand-sub { color: rgba(255,255,255,.35); font-size: 12px; margin-top: 2px; }
        .inv-number { font-family: 'JetBrains Mono', monospace; font-size: 12px; color: rgba(255,255,255,.5); }
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .badge-paid    { background: #16a34a20; color: #4ade80; border: 1px solid #16a34a60; }
        .badge-overdue { background: #dc262620; color: #f87171; border: 1px solid #dc262660; }
        .badge-sent, .badge-draft { background: rgba(255,255,255,.08); color: rgba(255,255,255,.6); border: 1px solid rgba(255,255,255,.15); }
        .stage-banner {
            background: rgba(45,74,58,.3);
            border: 1px solid rgba(45,74,58,.6);
            color: #a8d5b5;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
        }
        .card-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,.35); margin-bottom: 4px; }
        .total-card {
            background: rgba(45,74,58,.25);
            border: 1px solid rgba(45,74,58,.5);
            border-radius: 12px;
            padding: 28px 20px;
            text-align: center;
            margin-bottom: 16px;
        }
        .total-label { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: rgba(255,255,255,.4); margin-bottom: 10px; }
        .total-amount {
            font-family: var(--rc-font-display, 'Fraunces', serif);
            font-size: 36px;
            color: var(--rc-cream, #f4f1ea);
        }
        .bank-card { background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07); border-radius: 12px; padding: 20px; margin-bottom: 16px; }
        .bank-row { padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,.06); }
        .bank-row:last-child { border-bottom: none; }
        .bank-k { font-size: 11px; color: rgba(255,255,255,.4); margin-bottom: 2px; }
        .bank-v { font-weight: 600; font-size: 14px; }
        .qris-box { text-align: center; margin: 20px 0; }
        .qris-box img { max-width: 200px; display: block; margin: 0 auto; border-radius: 8px; border: 1px solid rgba(255,255,255,.1); }
        .divider { text-align: center; color: rgba(255,255,255,.3); font-size: 12px; margin: 16px 0; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-outline { border: 1px solid rgba(255,255,255,.2); color: rgba(255,255,255,.7); background: transparent; }
        .btn-paypal { background: #0070ba; color: #fff; border: none; padding: 12px 28px; font-size: 15px; }
        .paid-msg { color: #4ade80; font-weight: 600; margin-top: 16px; }
        .hint { color: rgba(255,255,255,.35); font-size: 12px; margin-top: 12px; }
        .no-print-note { color: rgba(255,255,255,.4); font-size: 12px; margin-top: 20px; }
        .btn-dl { display: inline-flex; align-items: center; gap: 8px; }
        .btn-dl.is-loading { opacity: .75; pointer-events: none; }
        .dl-spin { width: 14px; height: 14px; border: 2px solid rgba(255,255,255,.25); border-top-color: rgba(255,255,255,.85); border-radius: 50%; animation: dl-spin .7s linear infinite; }
        @keyframes dl-spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body>
<div class="invoice-wrap">

    <div class="invoice-header">
        <div>
            <div class="brand-name">Rielcode</div>
            <div class="brand-sub">rielcode.com</div>
        </div>
        <div style="text-align:right">
            <div class="inv-number">{{ $payment->invoice_number }}</div>
            @if($payment->status === 'paid')
                <span class="badge badge-paid">Paid</span>
            @elseif($payment->status === 'overdue')
                <span class="badge badge-overdue">Overdue</span>
            @else
                <span class="badge badge-sent">Unpaid</span>
            @endif
        </div>
    </div>

    <div class="stage-banner">
        <strong>{{ $payment->stageLabel() }}</strong>: {{ $payment->stageTagline() }}
    </div>

    <div class="card">
        <div style="display:flex;justify-content:space-between">
            <div>
                <div class="card-label">Bill To</div>
                <strong>{{ $payment->order->order_name }}</strong>
                <div style="color:rgba(255,255,255,.5);font-size:13px;">{{ $payment->order->email }}</div>
            </div>
            <div style="text-align:right">
                <div class="card-label">Due Date</div>
                <strong>{{ $payment->due_date->format('d M Y') }}</strong>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-label">Project</div>
        <strong>{{ $payment->order->package }}</strong>
        @if($payment->order->description)
            <div style="color:rgba(255,255,255,.5);font-size:13px;margin-top:6px;">{{ $payment->order->description }}</div>
        @endif
        <div style="border-top:1px solid rgba(255,255,255,.07);margin-top:14px;padding-top:14px;color:rgba(255,255,255,.4);font-size:13px;">
            Total project value:
            <strong style="color:#fff;">
                {{ $payment->currency === 'IDR'
                    ? 'Rp ' . number_format($payment->order->final_price, 0, ',', '.')
                    : '$' . number_format($payment->order->final_price, 2) }}
            </strong>
        </div>
    </div>

    <div class="total-card">
        <div class="total-label">Amount Due ({{ $payment->stageLabel() }})</div>
        <div class="total-amount">{{ $payment->amountFormatted() }}</div>

        @if($payment->status === 'paid')
            <div class="paid-msg">Payment received. Thank you!</div>
        @else
            @if($payment->currency === 'IDR')
                <div class="qris-box">
                    <div style="color:rgba(255,255,255,.35);font-size:11px;margin-bottom:12px;">Scan QRIS</div>
                    <img src="{{ asset('IMG/QRIS.jpeg') }}" alt="QRIS"
                         onerror="this.parentElement.style.display='none'">
                    <div style="color:rgba(255,255,255,.3);font-size:11px;margin-top:8px;">GoPay, OVO, DANA, BCA, and all banking apps</div>
                </div>
                <div class="divider">or pay via bank transfer</div>
            @else
                <div style="margin-top:20px;">
                    <a href="{{ $cfg['paypal_me'] }}/{{ number_format($payment->amount, 2, '.', '') }}"
                       target="_blank" rel="noopener" class="btn btn-paypal">Pay with PayPal</a>
                    <div style="color:rgba(255,255,255,.35);font-size:12px;margin-top:10px;">Amount pre-filled. After payment, send confirmation via WhatsApp.</div>
                </div>
            @endif
        @endif
    </div>

    @if($payment->status !== 'paid')
        @if($payment->currency === 'IDR')
            <div class="bank-card">
                <div class="card-label" style="margin-bottom:12px;">Bank Transfer (Indonesia)</div>
                <div class="bank-row">
                    <div class="bank-k">Bank Name</div>
                    <div class="bank-v">{{ $cfg['bank_name'] }}</div>
                </div>
                <div class="bank-row">
                    <div class="bank-k">Account Number</div>
                    <div class="bank-v" style="font-size:18px;letter-spacing:2px;">{{ $cfg['bank_number'] }}</div>
                </div>
                <div class="bank-row">
                    <div class="bank-k">Account Name</div>
                    <div class="bank-v">{{ $cfg['bank_name_account'] }}</div>
                </div>
            </div>
        @endif

        <div class="hint">After payment, send proof via WhatsApp to confirm. Once verified, this invoice will be marked Paid.</div>
    @endif

    <div class="no-print-note" style="margin-top:24px;">
        <a id="dlPdf" href="{{ route('invoice.pdf', $payment->invoice_number) }}" class="btn btn-outline btn-dl">
            <span class="dl-label">Download PDF</span>
        </a>
    </div>

</div>
<script>
    (function () {
        var btn = document.getElementById('dlPdf');
        if (!btn) return;
        var label = btn.querySelector('.dl-label');
        var original = label.textContent;
        btn.addEventListener('click', function () {
            if (btn.classList.contains('is-loading')) return;
            btn.classList.add('is-loading');
            label.textContent = 'Preparing PDF…';
            var spin = document.createElement('span');
            spin.className = 'dl-spin';
            btn.insertBefore(spin, label);
            setTimeout(function () {
                btn.classList.remove('is-loading');
                spin.remove();
                label.textContent = original;
            }, 4000);
        });
    })();
</script>
</body>
</html>
