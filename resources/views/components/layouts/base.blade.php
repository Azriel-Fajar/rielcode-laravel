@props([
    'title' => 'Rielcode',
    'description' =>
        'Rielcode builds custom websites, landing pages, and simple e-commerce, designed and developed end-to-end.',
    'canonical' => null,
    'ogImage' => '/IMG/og-default.png',
    'bodyClass' => '',
    'hideChatbot' => false,
])
@php
    $canonical = $canonical ?? url()->current();
@endphp
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <link rel="icon" type="image/png" href="/IMG/Rielcode Logo Square Transparent Icon.png" />
    <link rel="apple-touch-icon" href="/IMG/Rielcode Logo Square Transparent Icon.png" />
    <link rel="canonical" href="{{ $canonical }}" />

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="{{ $title }}" />
    <meta property="og:description" content="{{ $description }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ $canonical }}" />
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta name="twitter:card" content="summary_large_image" />

    <link rel="preload" href="/fonts/Inter-VariableFont.woff2" as="font" type="font/woff2" crossorigin />
    <link rel="preload" href="/fonts/Fraunces-VariableFont.woff2" as="font" type="font/woff2" crossorigin />

    <script>
        (function() {
            try {
                var stored = localStorage.getItem('rc-theme');
                var theme = stored || 'light';
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1014744971033787');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1014744971033787&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
</head>

<body class="{{ $bodyClass }}">
    <x-nav />
    <main>
        {{ $slot }}
    </main>
    <x-footer />
    @unless($hideChatbot)
    <x-chatbot />
    @endunless
    @stack('scripts')
</body>

</html>
