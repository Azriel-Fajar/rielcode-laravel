<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Payment Overdue | Rielcode</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f5;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f5;padding:40px 20px;">
<tr><td align="center">
<table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,0.08);">
    <tr>
        <td style="background:#7f1d1d;padding:24px 32px;text-align:center;">
            <p style="margin:0;font-size:20px;font-weight:700;color:#fef2f2;">Rielcode</p>
        </td>
    </tr>
    <tr>
        <td style="padding:32px;">
            <p style="margin:0 0 16px;font-size:16px;color:#111;">Hi <strong>{{ $payment->order->order_name }}</strong>,</p>
            <p style="margin:0 0 16px;font-size:15px;color:#333;line-height:1.6;">
                Your invoice <strong>{{ $payment->invoice_number }}</strong> ({{ $payment->stageLabel() }}) was due on
                <strong>{{ $payment->due_date->format('d M Y') }}</strong> and is now overdue.
            </p>
            <p style="margin:0 0 16px;font-size:15px;color:#333;line-height:1.6;">
                Please complete your payment of <strong>{{ $payment->amountFormatted() }}</strong> as soon as possible.
            </p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px;">
                <tr>
                    <td align="center">
                        <a href="{{ route('invoice.show', $payment->invoice_number) }}"
                           style="display:inline-block;background:#7f1d1d;color:#fef2f2;font-weight:600;font-size:14px;padding:12px 28px;border-radius:8px;text-decoration:none;">
                            View Invoice
                        </a>
                    </td>
                </tr>
            </table>

            <p style="margin:0 0 8px;font-size:13px;color:#555;">
                Questions? Reply to this email or message us on WhatsApp.
            </p>

            <p style="margin:24px 0 0;font-size:14px;color:#333;">
                Regards,<br>
                <strong>Rielcode</strong><br>
                <a href="https://rielcode.com" style="color:#7f1d1d;">rielcode.com</a>
            </p>
        </td>
    </tr>
    <tr>
        <td style="background:#f8fafc;padding:16px 32px;text-align:center;border-top:1px solid #e2e8f0;">
            <p style="margin:0;font-size:11px;color:#94a3b8;">Sent by Rielcode automated billing system.</p>
        </td>
    </tr>
</table>
</td></tr>
</table>
</body>
</html>
