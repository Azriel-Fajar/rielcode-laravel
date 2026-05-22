<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Invoice {{ $payment->invoice_number }} | Rielcode</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f5;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f5;padding:40px 20px;">
<tr><td align="center">
<table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,0.08);">
    <tr>
        <td style="background:#2d4a3a;padding:24px 32px;text-align:center;">
            <p style="margin:0;font-size:20px;font-weight:700;color:#f4f1ea;letter-spacing:-0.3px;">Rielcode</p>
        </td>
    </tr>
    <tr>
        <td style="padding:32px;">
            <p style="margin:0 0 16px;font-size:16px;color:#111;">Hi <strong>{{ $payment->order->order_name }}</strong>,</p>
            <p style="margin:0 0 16px;font-size:15px;color:#333;line-height:1.6;">
                Your invoice for <strong>{{ $payment->stageLabel() }}</strong> is ready.
            </p>

            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8faf8;border:1px solid #d1e7d9;border-radius:8px;padding:16px 20px;margin:20px 0;">
                <tr><td style="font-size:13px;color:#64748b;padding-bottom:8px;">Invoice details</td></tr>
                <tr><td style="font-size:14px;color:#111;padding-bottom:4px;"><strong>Invoice:</strong> {{ $payment->invoice_number }}</td></tr>
                <tr><td style="font-size:14px;color:#111;padding-bottom:4px;"><strong>Stage:</strong> {{ $payment->stageLabel() }}</td></tr>
                <tr><td style="font-size:14px;color:#111;padding-bottom:4px;"><strong>Amount:</strong> {{ $payment->amountFormatted() }}</td></tr>
                <tr><td style="font-size:14px;color:#111;padding-bottom:4px;"><strong>Due:</strong> {{ $payment->due_date->format('d M Y') }}</td></tr>
            </table>

            <p style="margin:0 0 8px;font-size:15px;color:#333;line-height:1.6;">View and pay your invoice:</p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px;">
                <tr>
                    <td align="center">
                        <a href="{{ route('invoice.show', $payment->invoice_number) }}"
                           style="display:inline-block;background:#2d4a3a;color:#f4f1ea;font-weight:600;font-size:14px;padding:12px 28px;border-radius:8px;text-decoration:none;">
                            View Invoice
                        </a>
                    </td>
                </tr>
            </table>

            <p style="margin:0 0 8px;font-size:13px;color:#555;">
                Or copy this link: <a href="{{ route('invoice.show', $payment->invoice_number) }}" style="color:#2d4a3a;">{{ route('invoice.show', $payment->invoice_number) }}</a>
            </p>

            <p style="margin:24px 0 0;font-size:14px;color:#333;">
                Warm regards,<br>
                <strong>Rielcode</strong><br>
                <a href="https://rielcode.com" style="color:#2d4a3a;">rielcode.com</a>
            </p>
        </td>
    </tr>
    <tr>
        <td style="background:#f8fafc;padding:16px 32px;text-align:center;border-top:1px solid #e2e8f0;">
            <p style="margin:0;font-size:11px;color:#94a3b8;">Sent by Rielcode. If this is unexpected, ignore it.</p>
        </td>
    </tr>
</table>
</td></tr>
</table>
</body>
</html>
