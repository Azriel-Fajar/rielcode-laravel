<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Progress · Rielcode</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..900;1,9..144,300..900&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/pages/progress.css'])
</head>

<body>

    <nav class="pp-nav" role="navigation" aria-label="Site navigation">
        <a href="https://rielcode.com" class="pp-nav__brand" aria-label="Rielcode home">
            <span class="pp-nav__num">N°01</span>
            <span class="pp-nav__name">Rielcode</span>
        </a>
    </nav>

    <main class="pp-main">

        <header class="pp-hero" data-reveal>
            <span class="pp-eyebrow">Project Progress</span>
            <h1 class="pp-hero__title">Hi <em>{{ explode(' ', $order->order_name)[0] ?? 'there' }}</em>, here's where we
                are.</h1>
            <div class="pp-hero__meta">
                <span>{{ $order->package }}</span>
                @if ($order->invoice_number)
                    <span class="pp-hero__sep" aria-hidden="true">·</span>
                    <span class="pp-hero__mono">{{ $order->invoice_number }}</span>
                @endif
                @if ($order->created_at)
                    <span class="pp-hero__sep" aria-hidden="true">·</span>
                    <span>Started {{ \Carbon\Carbon::parse($order->created_at)->format('M j, Y') }}</span>
                @endif
            </div>
        </header>

        {{-- Current Stage --}}
        <section class="pp-card" aria-labelledby="stage-heading" data-reveal>
            <div class="pp-card__head">
                <h2 class="pp-card__title" id="stage-heading">Current Stage</h2>
                <span class="pp-pill pp-pill--stage">{{ $stages[$currentStage]['label'] }}</span>
            </div>
            <p class="pp-stage-desc">{{ $stages[$currentStage]['desc'] }}</p>

            <div class="pp-stepper" role="list" aria-label="Project stages">
                @foreach ($stageKeys as $i => $key)
                    @php
                        $isDone = $i < $currentIndex;
                        $isActive = $i === $currentIndex;
                        $cls = 'pp-step' . ($isDone ? ' is-done' : ($isActive ? ' is-active' : ''));
                        $label = $stages[$key]['label'];
                        $aria = $isDone
                            ? "$label: completed"
                            : ($isActive
                                ? "$label: current stage"
                                : "$label: upcoming");
                    @endphp
                    <div class="{{ $cls }}" role="listitem" aria-label="{{ $aria }}">
                        <div class="pp-step__node" aria-hidden="true">
                            @if ($isDone)
                                <span class="pp-check"></span>
                            @else
                                <span>{{ $i + 1 }}</span>
                            @endif
                        </div>
                        <div class="pp-step__label">{{ $label }}</div>
                    </div>
                    @if ($i < count($stageKeys) - 1)
                        <div class="pp-step__bar{{ $isDone ? ' is-done' : '' }}" aria-hidden="true"></div>
                    @endif
                @endforeach
            </div>
        </section>

        <div class="pp-grid">

            {{-- Preview --}}
            <section class="pp-card" aria-labelledby="preview-heading" data-reveal>
                <div class="pp-card__head">
                    <h2 class="pp-card__title" id="preview-heading">Preview</h2>
                    @if ($order->staging_url)
                        <span class="pp-pill pp-pill--ready">
                            <svg width="9" height="9" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true">
                                <circle cx="12" cy="12" r="12" />
                            </svg>
                            Ready
                        </span>
                    @else
                        <span class="pp-pill pp-pill--pending">Not yet</span>
                    @endif
                </div>

                @if ($order->staging_url)
                    <p class="pp-stage-desc">Your staging site is live. Preview it below.</p>
                    <div class="pp-url-row" aria-label="Staging URL">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="2" y1="12" x2="22" y2="12" />
                            <path
                                d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                        </svg>
                        <span>{{ $order->staging_url }}</span>
                    </div>
                    <a href="{{ $order->staging_url }}" target="_blank" rel="noopener noreferrer"
                        class="pp-btn pp-btn--primary">
                        Open Preview
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M7 17 17 7" />
                            <path d="M7 7h10v10" />
                        </svg>
                    </a>
                @else
                    <div class="pp-empty" role="status" aria-live="polite">
                        <div class="pp-empty__icon" aria-hidden="true">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                <line x1="1" y1="1" x2="23" y2="23" />
                            </svg>
                        </div>
                        <span>Preview will appear once design is ready</span>
                    </div>
                @endif
            </section>

            {{-- Order Summary --}}
            <section class="pp-card" aria-labelledby="summary-heading" data-reveal>
                <div class="pp-card__head">
                    <h2 class="pp-card__title" id="summary-heading">Order Summary</h2>
                </div>
                <dl class="pp-summary">
                    <div class="pp-summary__row">
                        <dt>Plan</dt>
                        <dd style="margin:0"><b>{{ $order->package }}</b></dd>
                    </div>
                    <div class="pp-summary__row">
                        <dt>Package price</dt>
                        <dd style="margin:0">
                            @if (($order->invoice_currency ?? 'IDR') === 'USD')
                                ${{ number_format($order->package_price ?? 0, 2) }}
                            @else
                                Rp{{ number_format($order->package_price ?? 0, 0, ',', '.') }}
                            @endif
                        </dd>
                    </div>
                    @if (!empty($order->selected_addons))
                        <div class="pp-summary__row" style="padding-left:12px;font-size:13px;">
                            <dt style="color:var(--faint);font-size:11px;font-weight:500;letter-spacing:.06em;text-transform:uppercase;padding-top:10px;padding-bottom:2px;border:none;"
                                colspan="2">Add-ons</dt>
                        </div>
                        @foreach ($order->selected_addons as $addon)
                            <div class="pp-summary__row" style="padding-left:12px;">
                                <dt>
                                    {{ $addon['name'] ?? 'Add-on' }}@if (!empty($addon['tier'])) - {{ $addon['tier'] }}@endif@if (!empty($addon['qty']) && $addon['qty'] > 1) ×{{ $addon['qty'] }}@endif
                                </dt>
                                <dd style="margin:0">
                                    @if (!empty($addon['included']) && (int) ($addon['price_idr'] ?? 0) === 0)
                                        <span style="color:#3ecf8e;">Included</span>
                                    @elseif (($order->invoice_currency ?? 'IDR') === 'USD')
                                        ${{ number_format($addon['price_usd'] ?? 0, 2) }}
                                    @else
                                        Rp{{ number_format($addon['price_idr'] ?? 0, 0, ',', '.') }}
                                    @endif
                                </dd>
                            </div>
                        @endforeach
                    @endif
                    <div class="pp-summary__total">
                        <span>Total</span>
                        <span>
                            @if (($order->invoice_currency ?? 'IDR') === 'USD')
                                ${{ number_format($order->final_price ?? 0, 2) }}
                            @else
                                Rp{{ number_format($order->final_price ?? 0, 0, ',', '.') }}
                            @endif
                        </span>
                    </div>
                </dl>
            </section>

        </div>

        {{-- Latest Updates --}}
        <section class="pp-card" style="margin-top:16px;" aria-labelledby="updates-heading" data-reveal>
            <div class="pp-card__head">
                <h2 class="pp-card__title" id="updates-heading">Latest Updates</h2>
                <span class="pp-pill pp-pill--count"
                    aria-label="{{ $notes->count() }} updates">{{ $notes->count() }}</span>
            </div>
            @if ($notes->isEmpty())
                <div class="pp-empty pp-empty--lg" role="status">
                    <div class="pp-empty__icon" aria-hidden="true">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                    </div>
                    <span>No updates yet - we'll post here as work progresses.</span>
                </div>
            @else
                <ol class="pp-feed" aria-label="Project update timeline">
                    @foreach ($notes as $note)
                        <li class="pp-feed__item">
                            <div class="pp-feed__track" aria-hidden="true">
                                <div class="pp-feed__dot"></div>
                                <div class="pp-feed__line"></div>
                            </div>
                            <div class="pp-feed__body">
                                <time class="pp-feed__time"
                                    datetime="{{ \Carbon\Carbon::parse($note->created_at)->toIso8601String() }}">
                                    {{ \Carbon\Carbon::parse($note->created_at)->format('M j, Y · H:i') }}
                                </time>
                                <p class="pp-feed__text">{{ nl2br(e($note->note)) }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            @endif
        </section>

        <footer class="pp-foot" data-reveal>
            <p>Need to reach us? Reply to your order email or message Rielcode on WhatsApp.</p>
            <p class="pp-foot__private">Private link · do not share publicly</p>
        </footer>

    </main>

    <script>
        (function() {
            var els = document.querySelectorAll('[data-reveal]');
            if (!els.length) return;
            var io = new IntersectionObserver(function(entries) {
                entries.forEach(function(e) {
                    if (e.isIntersecting) {
                        e.target.setAttribute('data-reveal', 'in');
                        io.unobserve(e.target);
                    }
                });
            }, {
                threshold: 0.08
            });
            els.forEach(function(el) {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition =
                    'opacity 500ms cubic-bezier(0.22,0.61,0.36,1), transform 500ms cubic-bezier(0.22,0.61,0.36,1)';
                io.observe(el);
            });
            document.addEventListener('DOMContentLoaded', function() {
                els.forEach(function(el) {
                    if (el.getBoundingClientRect().top < window.innerHeight) {
                        el.setAttribute('data-reveal', 'in');
                        el.style.opacity = '1';
                        el.style.transform = 'none';
                        io.unobserve(el);
                    }
                });
            });
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                els.forEach(function(el) {
                    el.style.opacity = '1';
                    el.style.transform = 'none';
                    el.style.transition = 'none';
                });
            }
        })();
    </script>

</body>

</html>
