<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Client Brief | Rielcode</title></head>
<body style="margin:0;padding:0;background:#f4f4f5;font-family:Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f5;padding:40px 20px;">
<tr><td align="center">
<table width="560" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:12px;overflow:hidden;">
    <tr><td style="background:#0a0a0a;padding:20px 32px;text-align:center;"><p style="margin:0;font-size:18px;font-weight:700;color:#fff;">Rielcode: Client Brief</p></td></tr>
    <tr><td style="padding:28px 32px;">
        <p style="margin:0 0 12px;font-size:15px;color:#333;">A client brief has been submitted for order <strong>{{ $order->order_name }}</strong> ({{ $order->package }}).</p>
        @foreach ($briefData as $key => $value)
        @if ($value)
        <p style="margin:0 0 8px;font-size:14px;color:#111;"><strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong><br>{{ is_array($value) ? implode(', ', $value) : $value }}</p>
        @endif
        @endforeach
    </td></tr>
</table>
</td></tr></table>
</body>
</html>
