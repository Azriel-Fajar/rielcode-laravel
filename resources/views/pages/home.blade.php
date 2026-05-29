<x-layouts.base title="Rielcode – Websites with uncommon polish"
    description="Rielcode builds editorial-grade websites, landing pages, and simple e-commerce for international and Indonesian clients.">
    {{-- Hero --}}
    <section class="rc-hero">
        <div class="rc-container rc-hero__inner">
            <span class="rc-label rc-hero__eyebrow">N°01 – Rielcode Studio</span>
            <h1 class="rc-hero__title">
                <span class="rc-hero__italic">
                    <span class="rc-hero__word" style="--i:0">Websites</span>
                    <span class="rc-hero__word" style="--i:1"> with</span>
                </span>
                <span class="rc-hero__roman">
                    <span class="rc-hero__word" style="--i:2">uncommon</span>
                    <span class="rc-hero__word" style="--i:3"> polish.</span>
                </span>
            </h1>
            <p class="rc-hero__body">Editorial-grade websites, landing pages, and simple e-commerce, designed and
                developed end-to-end.</p>
            <div class="rc-hero__ctas">
                <a class="rc-btn rc-btn--fill rc-btn--lg" href="/order">Start a project</a>
                <a class="rc-btn rc-btn--underline rc-btn--md" href="/work">See the work</a>
                <x-wa-consult-btn size="lg" />
            </div>
            <div class="rc-hero__chips">
                <span>Open to Projects</span>
                <span>·</span>
                <span>IDR / USD</span>
            </div>
        </div>
    </section>

    {{-- Featured work --}}
    <section class="rc-section rc-section--bg-default rc-section--pad-default" id="work">
        <div class="rc-container">
            <div class="rc-home-feat__head">
                <span class="rc-label">Selected work</span>
                <h2>Made for clients who notice the details.</h2>
            </div>
            <div class="rc-home-feat__grid">
                @foreach ($featuredWork as $i => $project)
                    <a class="rc-workcard rc-workcard--{{ $i === 0 ? 'lg' : 'sm' }}" href="/work/{{ $project->slug }}">
                        <div class="rc-workcard__media">
                            <img src="{{ $project->image_path ? asset('storage/' . $project->image_path) : asset('IMG/og-default.png') }}"
                                alt="{{ $project->title }}" loading="lazy" />
                        </div>
                        <div class="rc-workcard__meta">
                            <span class="rc-label">{{ substr($project->created_at, 0, 4) }} ·
                                {{ $project->tags_array[0] ?? 'Custom website' }}</span>
                            <h2 class="rc-workcard__title">{{ $project->title }}</h2>
                        </div>
                    </a>
                @endforeach
                @if ($featuredWork->count() < 2)
                    <a class="rc-workcard rc-workcard--sm" href="/work">
                        <div class="rc-workcard__media">
                            <img src="/IMG/og-default.png" alt="" loading="lazy" />
                        </div>
                        <div class="rc-workcard__meta">
                            <span class="rc-label">2026 · In production</span>
                            <h2 class="rc-workcard__title">More case studies coming.</h2>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- Studio --}}
    <section class="rc-section rc-section--bg-elev rc-section--pad-default" id="studio">
        <div class="rc-container">
            <div class="rc-home-studio">
                <div class="rc-home-studio__media">
                    @if ($studioPortraitImage)
                        <img class="rc-home-studio__portrait" src="{{ $studioPortraitImage }}" alt="Rielcode Studio"
                            loading="lazy" />
                    @else
                        <div class="rc-home-studio__portrait" aria-hidden="true"></div>
                    @endif
                </div>
                <div class="rc-home-studio__copy">
                    <span class="rc-label">The studio</span>
                    <h2>Built for clients who <em>notice the details.</em></h2>
                    <p>Rielcode treats each website as an editorial product, not a template fill.</p>
                    <ul class="rc-home-studio__stats">
                        <li><strong>4+</strong><span>years writing for the web</span></li>
                        <li><strong>5+</strong><span>projects shipped</span></li>
                        <li><strong>2</strong><span>countries served</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Services --}}
    <section class="rc-section rc-section--bg-default rc-section--pad-default" id="services">
        <div class="rc-container">
            <div class="rc-home-feat__head">
                <span class="rc-label">Services</span>
                <h2>Ways to work together.</h2>
            </div>
            <div class="rc-svc-grid rc-svc-grid--3col">
                @foreach ($packages as $pkg)
                    <div class="rc-pkg-card{{ $pkg->is_popular ? ' rc-pkg-card--popular' : '' }}{{ $pkg->slug === 'business' ? ' rc-pkg-card--best' : '' }}"
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
                                <span
                                    class="rc-label">{{ $pkg->delivery_days_min }}&ndash;{{ $pkg->delivery_days_max }}
                                    days</span>
                            @endif
                        </div>
                        @if ($pkg->features_json)
                            <ul class="rc-pkg-card__list">
                                @foreach ($pkg->features() as $row)
                                    <li
                                        class="rc-pkg-card__item {{ $row['included'] ? '' : 'rc-pkg-card__item--off' }}">
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
            <div style="text-align:center;margin-top:var(--space-8)">
                <a class="rc-btn rc-btn--outline rc-btn--md" href="/services">See all plans &amp; pricing &rarr;</a>
            </div>
        </div>
    </section>
    <div style="text-align:center;margin-top:var(--space-8)">
        <x-wa-consult-btn />
    </div>

    {{-- Testimonials --}}
    @if ($testimonials->isNotEmpty())
        <section class="rc-section rc-section--bg-default rc-section--pad-default" id="testimonials">
            <div class="rc-container">
                @if ($testimonials->count() === 1)
                    @php $t = $testimonials->first() @endphp
                    <figure class="rc-home-quote">
                        <blockquote class="rc-home-quote__body">
                            <p><em>"{{ $t->headline }}"</em></p>
                            <p class="rc-home-quote__detail">{{ $t->recommendation }}</p>
                        </blockquote>
                        <figcaption class="rc-home-quote__cite">
                            <strong>{{ $t->client_name }}</strong>
                            <span>{{ $t->role_title }}, {{ $t->business_name }}</span>
                        </figcaption>
                    </figure>
                @else
                    <div class="rc-testimonial-slider" id="testimonialSlider" data-autoplay="6000">
                        <div class="rc-testimonial-slider__track">
                            @foreach ($testimonials as $t)
                                <figure class="rc-home-quote rc-testimonial-slider__slide">
                                    <blockquote class="rc-home-quote__body">
                                        <p><em>"{{ $t->headline }}"</em></p>
                                        <p class="rc-home-quote__detail">{{ $t->recommendation }}</p>
                                    </blockquote>
                                    <figcaption class="rc-home-quote__cite">
                                        <strong>{{ $t->client_name }}</strong>
                                        <span>{{ $t->role_title }}, {{ $t->business_name }}</span>
                                    </figcaption>
                                </figure>
                            @endforeach
                        </div>
                        <div class="rc-testimonial-slider__controls">
                            <button class="rc-testimonial-slider__arrow rc-testimonial-slider__arrow--prev"
                                aria-label="Previous">&larr;</button>
                            <div class="rc-testimonial-slider__dots">
                                @foreach ($testimonials as $i => $t)
                                    <button
                                        class="rc-testimonial-slider__dot{{ $i === 0 ? ' rc-testimonial-slider__dot--active' : '' }}"
                                        data-index="{{ $i }}"
                                        aria-label="Testimonial {{ $i + 1 }}"></button>
                                @endforeach
                            </div>
                            <button class="rc-testimonial-slider__arrow rc-testimonial-slider__arrow--next"
                                aria-label="Next">&rarr;</button>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- CTA Band --}}
    <section class="rc-ctaband">
        <div class="rc-container rc-ctaband__inner">
            <span class="rc-label rc-ctaband__eyebrow">Open to Projects</span>
            <h2 class="rc-ctaband__heading">Have a project in mind? Let's make it well.</h2>
            <a class="rc-ctaband__cta" href="/order">
                Start a project
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>
</x-layouts.base>
