<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmed | Rielcode</title>
</head>
<body style="margin:0;padding:0;background:#f4f4f5;font-family:Poppins,Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f5;padding:40px 20px;">
<tr><td align="center">
<table width="560" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 16px rgba(0,0,0,0.08);">
    <tr>
        <td style="background:#0a0a0a;padding:24px 32px;text-align:center;">
            <p style="margin:0;font-size:20px;font-weight:700;color:#ffffff;letter-spacing:-0.3px;">Rielcode</p>
        </td>
    </tr>
    <tr>
        <td style="padding:32px;">
            <p style="margin:0 0 16px;font-size:16px;color:#111;">Hi <strong>{{ $order->order_name }}</strong>,</p>
            <p style="margin:0 0 16px;font-size:15px;color:#333;line-height:1.6;">
                Thank you for choosing <strong>Rielcode</strong> for your <strong>{{ $order->package }}</strong> project.
            </p>
            <p style="margin:0 0 16px;font-size:15px;color:#333;line-height:1.6;">
                We've received your order. Our team will reach out within <strong>24 hours</strong> to confirm project details and send your invoice separately.
            </p>

            <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border-radius:8px;padding:16px 20px;margin:20px 0;">
                <tr><td style="font-size:13px;color:#64748b;padding-bottom:6px;">Order details</td></tr>
                <tr>
                    <td style="font-size:14px;color:#111;padding-bottom:4px;"><strong>Package:</strong> {{ $order->package }}</td>
                </tr>
                <tr>
                    <td style="font-size:14px;color:#111;padding-bottom:4px;"><strong>Email:</strong> {{ $order->email }}</td>
                </tr>
                @if ($order->final_price > 0)
                <tr>
                    <td style="font-size:14px;color:#111;padding-bottom:4px;"><strong>Total:</strong> Rp{{ number_format($order->final_price, 0, ',', '.') }}</td>
                </tr>
                @endif
            </table>

            <p style="margin:0 0 8px;font-size:15px;color:#333;line-height:1.6;">
                Track your project progress anytime via your private link:
            </p>
            <p style="margin:0 0 20px;">
                <a href="{{ $progressUrl }}" style="color:#3a7bff;font-weight:600;word-break:break-all;">{{ $progressUrl }}</a>
            </p>

            <table width="100%" cellpadding="0" cellspacing="0" style="margin:0 0 24px;">
                <tr>
                    <td align="center">
                        <a href="{{ $progressUrl }}" style="display:inline-block;background:#3a7bff;color:#ffffff;font-weight:600;font-size:14px;padding:12px 28px;border-radius:8px;text-decoration:none;">
                            Open Progress Portal
                        </a>
                    </td>
                </tr>
            </table>

            <p style="margin:0 0 24px;font-size:14px;color:#555;line-height:1.6;">
                Feel free to reply to this email or message us on WhatsApp if you have any questions.
            </p>

            <p style="margin:0;font-size:14px;color:#333;">
                Warm regards,<br>
                <strong>The Rielcode Team</strong><br>
                <a href="https://rielcode.com" style="color:#3a7bff;">rielcode.com</a>
            </p>
        </td>
    </tr>
    <tr>
        <td style="background:#f8fafc;padding:16px 32px;text-align:center;border-top:1px solid #e2e8f0;">
            <p style="margin:0;font-size:11px;color:#94a3b8;">
                This email was sent automatically by the Rielcode system.<br>
                If you don't recognize this order, you can safely ignore this email.
            </p>
        </td>
    </tr>
</table>
</td></tr>
</table>
</body>
</html>
