<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family:sans-serif;color:#111;max-width:600px;margin:0 auto;padding:24px">
    <h2 style="margin:0 0 16px">New contact from rielcode.com</h2>

    <table style="width:100%;border-collapse:collapse;font-size:15px">
        <tr>
            <td style="padding:10px 0;border-bottom:1px solid #eee;color:#666;width:140px">Name</td>
            <td style="padding:10px 0;border-bottom:1px solid #eee">{{ $data['name'] }}</td>
        </tr>
        <tr>
            <td style="padding:10px 0;border-bottom:1px solid #eee;color:#666">Email</td>
            <td style="padding:10px 0;border-bottom:1px solid #eee">
                <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
            </td>
        </tr>
        @if (!empty($data['project_type']))
        <tr>
            <td style="padding:10px 0;border-bottom:1px solid #eee;color:#666">Project type</td>
            <td style="padding:10px 0;border-bottom:1px solid #eee">{{ $data['project_type'] }}</td>
        </tr>
        @endif
        <tr>
            <td style="padding:10px 0;color:#666;vertical-align:top">Message</td>
            <td style="padding:10px 0;white-space:pre-wrap">{{ $data['message'] }}</td>
        </tr>
    </table>

    <p style="margin:24px 0 0;font-size:13px;color:#999">
        Sent from {{ $data['ip'] }} &bull; {{ $data['created_at'] }}
    </p>
</body>
</html>
