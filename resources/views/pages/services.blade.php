<x-layouts.base
    title="Services · Rielcode"
    description="Rielcode service packages: landing pages, custom multi-page sites, and simple e-commerce. Fixed prices in IDR and USD."
>
    {{-- Hero --}}
    <section class="rc-svc-hero">
        <div class="rc-container rc-svc-hero__inner">
            <span class="rc-label">Services &amp; pricing</span>
            <h1 class="rc-svc-hero__title">
                Five ways to<br /><em>work together.</em>
            </h1>
            <p class="rc-svc-hero__body">
                Fixed scope, fixed price. Every package delivers a production-ready website with full design and development, end-to-end.
            </p>
        </div>
    </section>
    <div style="text-align:center;margin-top:var(--space-8)">
        <x-wa-consult-btn />
    </div>

    {{-- Packages --}}
    <section class="rc-section rc-section--pad-default" id="packages">
        <div class="rc-container">
            <div class="rc-svc-grid rc-svc-grid--5col">
                @foreach ($packages as $pkg)
                <div class="rc-pkg-card{{ $pkg->is_popular ? ' rc-pkg-card--popular' : '' }}" id="{{ $pkg->slug }}">
                    @if ($pkg->is_popular)
                        <span class="rc-pkg-card__popular-badge">Most popular</span>
                    @endif
                    @if ($pkg->badge_color)
                        <span class="rc-pkg-card__badge rc-pkg-card__badge--{{ $pkg->badge_color }}">
                            @if ($pkg->original_idr && $pkg->original_idr > $pkg->idr_price)
                                50% OFF
                            @else
                                {{ ucfirst($pkg->badge_color) }}
                            @endif
                        </span>
                    @endif
                    <div class="rc-pkg-card__head">
                        <h2 class="rc-pkg-card__title">{{ $pkg->package_name }}</h2>
                        @if ($pkg->blurb)
                            <p class="rc-pkg-card__blurb">{{ $pkg->blurb }}</p>
                        @endif
                        <div class="rc-pkg-card__price">
                            @if ($pkg->idr_price)
                                @if ($pkg->original_idr && $pkg->original_idr > $pkg->idr_price)
                                    <span class="rc-pkg-card__price-strike">IDR {{ number_format($pkg->original_idr / 1000) }}k</span>
                                @endif
                                <strong class="rc-pkg-card__price-main">IDR {{ number_format($pkg->idr_price / 1000) }}k</strong>
                            @else
                                <strong class="rc-pkg-card__price-main">You choose</strong>
                            @endif
                            @if ($pkg->us_price)
                                @if ($pkg->original_us && $pkg->original_us > $pkg->us_price)
                                    <span class="rc-pkg-card__price-strike">${{ number_format($pkg->original_us) }}</span>
                                @endif
                                <span class="rc-pkg-card__price-alt">/ ${{ number_format($pkg->us_price) }}</span>
                            @else
                                <span class="rc-pkg-card__price-alt">/ from $X</span>
                            @endif
                        </div>
                        @if ($pkg->delivery_days_min && $pkg->delivery_days_max)
                            <span class="rc-label">{{ $pkg->delivery_days_min }}&ndash;{{ $pkg->delivery_days_max }} days</span>
                        @endif
                    </div>
                    @if ($pkg->includes_free_hosting || $pkg->includes_free_domain)
                        <div class="rc-pkg-card__promo">
                            <span class="rc-pkg-card__promo-pill">
                                ✓ Free hosting{{ $pkg->includes_free_domain ? ' + domain' : '' }} included
                            </span>
                        </div>
                    @endif
                    @if ($pkg->features_json)
                        <ul class="rc-pkg-card__list">
                          @foreach ($pkg->features_json['sections'] ?? [] as $section)
                            <li class="rc-pkg-card__section">
                              <span class="rc-pkg-card__section-title">{{ $section['title'] }}</span>
                              <ul class="rc-pkg-card__sublist">
                                @foreach ($section['items'] as $row)
                                  <li class="rc-pkg-card__item {{ $row['included'] ? '' : 'rc-pkg-card__item--off' }}">
                                    <span class="rc-pkg-card__check">{{ $row['included'] ? '✓' : '—' }}</span>
                                    {{ $row['label'] }}
                                  </li>
                                @endforeach
                              </ul>
                            </li>
                          @endforeach
                        </ul>
                    @endif
                    @if ($pkg->slug === 'custom')
                        <a class="rc-btn rc-btn--fill rc-btn--md" href="/custom-plan">Start custom plan</a>
                    @else
                        <a class="rc-btn rc-btn--fill rc-btn--md" href="/order?aksi={{ $pkg->slug }}">Choose plan</a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <div style="text-align:center;margin-top:var(--space-8)">
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
                        <td class="rc-addons-table__type" data-label="Type">{{ str_replace('_', ' ', $addon->type) }}</td>
                        <td class="rc-addons-table__price" data-label="IDR">IDR {{ number_format($addon->price_idr / 1000) }}k</td>
                        <td class="rc-addons-table__price" data-label="USD">${{ number_format($addon->price_usd) }}</td>
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
            <a href="/studio#faq" class="rc-btn rc-btn--underline rc-btn--md" style="margin-top:var(--space-8);display:inline-flex">All FAQs on the Studio page &rarr;</a>
        </div>
    </section>

    {{-- CTA Band --}}
    <section class="rc-cta-band">
        <div class="rc-container rc-cta-band__inner">
            <div class="rc-cta-band__copy">
                <span class="rc-label">Booking Q3 2026</span>
                <h2 class="rc-cta-band__heading">Have a project in mind?</h2>
            </div>
            <a href="/order" class="rc-btn rc-btn--fill rc-btn--lg">Start a project</a>
        </div>
    </section>
</x-layouts.base>
