<x-layouts.base
    title="Services · Rielcode"
    description="Rielcode service packages: landing pages, custom multi-page sites, and simple e-commerce. Fixed prices in IDR and USD."
>
    {{-- Hero --}}
    <section class="rc-svc-hero">
        <div class="rc-container rc-svc-hero__inner">
            <span class="rc-label">Services &amp; pricing</span>
            <h1 class="rc-svc-hero__title">
                Three ways to<br /><em>work together.</em>
            </h1>
            <p class="rc-svc-hero__body">
                Fixed scope, fixed price. Every package delivers a production-ready website with full design and development, end-to-end.
            </p>
        </div>
    </section>

    {{-- Packages --}}
    <section class="rc-section rc-section--pad-default" id="packages">
        <div class="rc-container">
            <div class="rc-svc-grid">
                @foreach ($services as $svc)
                <div class="rc-pkg-card" id="{{ $svc['id'] }}">
                    <div class="rc-pkg-card__head">
                        <h2 class="rc-pkg-card__title">{{ $svc['title'] }}</h2>
                        <div class="rc-pkg-card__price">
                            <strong class="rc-pkg-card__price-main">{{ $svc['priceIdr'] }}</strong>
                            <span class="rc-pkg-card__price-alt">/ {{ $svc['priceUsd'] }}</span>
                        </div>
                        <span class="rc-label">{{ $svc['timeline'] }}</span>
                    </div>
                    <ul class="rc-pkg-card__list">
                        @foreach ($svc['deliverables'] as $d)
                        <li class="rc-pkg-card__item">
                            <span aria-hidden="true" class="rc-pkg-card__check">✓</span>
                            {{ $d }}
                        </li>
                        @endforeach
                    </ul>
                    <a class="rc-btn rc-btn--fill rc-btn--md" href="/contact">Start a project</a>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Add-ons --}}
    <section class="rc-section rc-section--bg-elev rc-section--pad-default" id="addons">
        <div class="rc-container">
            <div class="rc-svc-sec-head">
                <span class="rc-label">Add-ons</span>
                <h2>Extend any package.</h2>
            </div>
            <table class="rc-addons-table">
                <thead>
                    <tr>
                        <th>Add-on</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($addons as $addon)
                    <tr>
                        <td>{{ $addon['item'] }}</td>
                        <td class="rc-addons-table__price">{{ $addon['price'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                    <summary class="rc-faq__q">{{ $item['q'] }}</summary>
                    <p class="rc-faq__a">{{ $item['a'] }}</p>
                </details>
                @endforeach
            </div>
            <a href="/studio#faq" class="rc-btn rc-btn--underline rc-btn--md" style="margin-top:var(--space-8);display:inline-flex">All FAQs on the Studio page →</a>
        </div>
    </section>

    {{-- CTA Band --}}
    <section class="rc-cta-band">
        <div class="rc-container rc-cta-band__inner">
            <div class="rc-cta-band__copy">
                <span class="rc-label">Booking Q3 2026</span>
                <h2 class="rc-cta-band__heading">Have a project in mind?</h2>
            </div>
            <a href="/contact" class="rc-btn rc-btn--fill rc-btn--lg">Start a project</a>
        </div>
    </section>
</x-layouts.base>
