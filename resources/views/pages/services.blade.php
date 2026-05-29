<x-layouts.base title="Services · Rielcode"
    description="Rielcode service packages: landing pages, custom multi-page sites, and simple e-commerce. Fixed prices in IDR and USD.">
    {{-- Hero --}}
    <section class="rc-svc-hero">
        <div class="rc-container rc-svc-hero__inner">
            <span class="rc-label">Services &amp; pricing</span>
            <h1 class="rc-svc-hero__title">
                Ways to<br /><em>work together.</em>
            </h1>
            <p class="rc-svc-hero__body">
                Fixed scope, fixed price. Every package delivers a production-ready website with full design and
                development, end-to-end.
            </p>
        </div>
    </section>
    <div style="text-align:center;margin-top:var(--space-8)">
        <x-wa-consult-btn />
    </div>

    {{-- Packages --}}
    <section class="rc-section rc-section--pad-default" id="packages">
        <div class="rc-container">
            <div style="text-align:center"><p class="rc-svc-panel-notice">Every order includes a private progress panel &ndash; track your build in real time.</p></div>
            {{-- Top 4 plans --}}
            <div class="rc-svc-grid rc-svc-grid--4col">
                @foreach ($packages->filter(fn($p) => $p->slug !== 'custom') as $pkg)
                    <div class="rc-pkg-card{{ $pkg->is_popular ? ' rc-pkg-card--popular' : '' }}{{ $pkg->slug === 'business' ? ' rc-pkg-card--best' : '' }}{{ $loop->index >= 2 ? ' rc-pkg-card--hidden-mobile' : '' }}"
                        id="{{ $pkg->slug }}">
                        @if ($pkg->is_popular)
                            <span class="rc-pkg-card__ribbon">Most popular</span>
                        @elseif ($pkg->slug === 'business')
                            <span class="rc-pkg-card__ribbon rc-pkg-card__ribbon--best">Best choice</span>
                        @endif
                        <div class="rc-pkg-card__top">
                            <h2 class="rc-pkg-card__title">{{ str_replace(' Plan', '', $pkg->package_name) }}</h2>
                            @if ($pkg->blurb)
                                <p class="rc-pkg-card__blurb">{{ $pkg->blurb }}</p>
                            @endif
                        </div>
                        <div class="rc-pkg-card__head">
                            <div class="rc-pkg-card__price">
                                @if ($pkg->idr_price)
                                    <strong class="rc-pkg-card__price-main">
                                        {{ $pkg->idrShort() }}
                                        @if ($pkg->us_price)
                                            <span class="rc-pkg-card__price-alt">/
                                                ${{ number_format($pkg->us_price) }}</span>
                                        @endif
                                    </strong>
                                @else
                                    <strong class="rc-pkg-card__price-main">You choose</strong>
                                @endif
                            </div>
                            @if ($pkg->delivery_days_min && $pkg->delivery_days_max)
                                <span class="rc-label">{{ $pkg->delivery_days_min }}&ndash;{{ $pkg->delivery_days_max }}
                                    days</span>
                            @endif
                        </div>
                        @if ($pkg->features_json)
                            <ul class="rc-pkg-card__list">
                                @foreach ($pkg->features() as $row)
                                    <li class="rc-pkg-card__item {{ $row['included'] ? '' : 'rc-pkg-card__item--off' }}">
                                        <span class="rc-pkg-card__check">{{ $row['included'] ? '✓' : '✕' }}</span>
                                        <span class="rc-pkg-card__item-label">{!! $row['label'] !!}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <a class="rc-btn rc-btn--fill rc-btn--md" href="/order?aksi={{ $pkg->slug }}">Choose
                            plan</a>
                    </div>
                @endforeach
            </div>
            <div class="rc-svc-plans-expand" id="svc-plans-expand-wrap">
                <button class="rc-btn rc-btn--outline rc-btn--md" id="svc-plans-expand-btn" onclick="rcExpandPlans()">
                    Show all plans
                </button>
            </div>
            {{-- Custom plan - full-width horizontal card --}}
            @php $custom = $packages->firstWhere('slug', 'custom') @endphp
            @if ($custom)
                <div class="rc-pkg-card rc-pkg-card--custom-wide" id="custom">
                    <div class="rc-pkg-card--custom-wide__left">
                        <h2 class="rc-pkg-card__title">{{ str_replace(' Plan', '', $custom->package_name) }}</h2>
                        @if ($custom->blurb)
                            <p class="rc-pkg-card__blurb">{{ $custom->blurb }}</p>
                        @endif
                    </div>
                    <div class="rc-pkg-card--custom-wide__right">
                        <a class="rc-btn rc-btn--fill rc-btn--md" href="/custom-plan">Start custom plan</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <div style="text-align:center;margin-top:var(--space-8);margin-bottom:var(--space-12)">
        <x-wa-consult-btn />
    </div>

    {{-- Add-ons --}}
    <section class="rc-section rc-section--bg-elev rc-section--pad-default" id="addons">
        <div class="rc-container">
            <div class="rc-svc-sec-head">
                <span class="rc-label">Add-ons</span>
                <h2>Extend any package.</h2>
            </div>
            <div class="rc-addons-table-wrap">
                <table class="rc-addons-table">
                    <thead>
                        <tr>
                            <th>Add-on</th>
                            <th>Type</th>
                            <th>IDR</th>
                            <th>USD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addons as $addon)
                            <tr>
                                <td>
                                    {{ $addon->name }}
                                    @if ($addon->description)
                                        <span class="rc-addons-table__desc">{{ $addon->description }}</span>
                                    @endif
                                </td>
                                <td class="rc-addons-table__type" data-label="Type">
                                    {{ str_replace('_', ' ', $addon->type) }}</td>
                                @php
                                    $useTiers = $addon->price_idr == 0 && !empty($addon->tiers);
                                    $firstTier = $useTiers ? $addon->tiers[0] : null;
                                @endphp
                                <td class="rc-addons-table__price" data-label="IDR">
                                    @if ($useTiers)
                                        from IDR {{ number_format($firstTier['price_idr'] / 1000) }}k
                                    @else
                                        IDR {{ number_format($addon->price_idr / 1000) }}k
                                    @endif
                                </td>
                                <td class="rc-addons-table__price" data-label="USD">
                                    @if ($useTiers)
                                        from ${{ number_format($firstTier['price_usd']) }}
                                    @else
                                        ${{ number_format($addon->price_usd) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="rc-section rc-section--pad-default" id="faq">
        <div class="rc-container">
            <div class="rc-svc-sec-head">
                <span class="rc-label">Common questions</span>
                <h2>Quick answers.</h2>
            </div>
            <div class="rc-faq">
                @foreach ($faqs as $item)
                    <details class="rc-faq__item">
                        <summary class="rc-faq__q">{{ $item->question }}</summary>
                        <p class="rc-faq__a">{{ $item->answer }}</p>
                    </details>
                @endforeach
            </div>
            <a href="/studio#faq" class="rc-btn rc-btn--underline rc-btn--md"
                style="margin-top:var(--space-8);display:inline-flex">All FAQs on the Studio page &rarr;</a>
        </div>
    </section>

    {{-- CTA Band --}}
    <section class="rc-ctaband">
        <div class="rc-container rc-ctaband__inner">
            <span class="rc-label rc-ctaband__eyebrow">Open to Projects</span>
            <h2 class="rc-ctaband__heading">Have a project in mind? Let's make it well.</h2>
            <a class="rc-ctaband__cta" href="/order">
                Start a project
            </a>
        </div>
    </section>
    <script>
        function rcExpandPlans() {
            document.querySelectorAll('.rc-pkg-card--hidden-mobile').forEach(function(el) {
                el.classList.remove('rc-pkg-card--hidden-mobile');
            });
            var wrap = document.getElementById('svc-plans-expand-wrap');
            if (wrap) wrap.style.display = 'none';
        }
    </script>
</x-layouts.base>
