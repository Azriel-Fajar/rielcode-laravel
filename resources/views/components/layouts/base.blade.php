@props([
    'title' => 'Rielcode',
    'description' => 'Rielcode builds custom websites, landing pages, and simple e-commerce — designed and developed end-to-end.',
    'canonical' => null,
    'ogImage' => '/IMG/og-default.png',
    'bodyClass' => '',
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
        (function () {
            try {
                var stored = localStorage.getItem('rc-theme');
                var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                var theme = stored || (prefersDark ? 'dark' : 'light');
                document.documentElement.setAttribute('data-theme', theme);
            } catch (e) {
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="{{ $bodyClass }}">
    <x-nav />
    <main>
        {{ $slot }}
    </main>
    <x-footer />
    <x-chatbot />
    @stack('scripts')
</body>
</html>
