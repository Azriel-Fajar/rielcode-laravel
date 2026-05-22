<x-layouts.base
    title="Rielcode – Websites with uncommon polish"
    description="A solo studio in Salatiga building editorial-grade websites, landing pages, and simple e-commerce for international and Indonesian SMB clients."
>
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
            <p class="rc-hero__body">A solo studio building editorial-grade sites, landing pages, and simple e-commerce — designed and developed end-to-end from Salatiga, Indonesia.</p>
            <div class="rc-hero__ctas">
                <a class="rc-btn rc-btn--fill rc-btn--lg" href="/order">Start a project</a>
                <a class="rc-btn rc-btn--underline rc-btn--md" href="/work">See the work</a>
            </div>
            <div class="rc-hero__chips">
                <span>Booking · Q3 2026</span>
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
                            <img src="{{ $project->image_path ? asset('storage/' . $project->image_path) : asset('IMG/og-default.png') }}" alt="{{ $project->title }}" loading="lazy" />
                        </div>
                        <div class="rc-workcard__meta">
                            <span class="rc-label">{{ substr($project->created_at, 0, 4) }} · {{ $project->tags_array[0] ?? 'Custom website' }}</span>
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
                        <img class="rc-home-studio__portrait" src="{{ $studioPortraitImage }}" alt="Azriel — Rielcode Studio" loading="lazy" />
                    @else
                        <div class="rc-home-studio__portrait" aria-hidden="true"></div>
                    @endif
                </div>
                <div class="rc-home-studio__copy">
                    <span class="rc-label">The studio</span>
                    <h2><em>A solo studio</em> in Salatiga, building for the world.</h2>
                    <p>Rielcode is run by Azriel — a developer and informatics engineering student who treats each website as an editorial product, not a template fill.</p>
                    <ul class="rc-home-studio__stats">
                        <li><strong>4+</strong><span>years writing for the web</span></li>
                        <li><strong>20+</strong><span>projects shipped</span></li>
                        <li><strong>3</strong><span>countries served</span></li>
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
                <h2>Three ways to work together.</h2>
            </div>
            <div class="rc-home-services">
                <a class="rc-svccard" href="/services#landing">
                    <h3 class="rc-svccard__title">Landing</h3>
                    <p class="rc-svccard__desc">A single high-conversion page. Copy, design, build, ship — in two weeks.</p>
                    <div class="rc-svccard__price">
                        <span class="rc-label">From</span>
                        <strong>IDR 4M</strong>
                        <span class="rc-svccard__alt">/ $260</span>
                    </div>
                    <span class="rc-svccard__arrow" aria-hidden="true">→</span>
                </a>
                <a class="rc-svccard" href="/services#custom">
                    <h3 class="rc-svccard__title">Custom</h3>
                    <p class="rc-svccard__desc">A bespoke multi-page site, designed and developed end-to-end.</p>
                    <div class="rc-svccard__price">
                        <span class="rc-label">From</span>
                        <strong>IDR 8–12M</strong>
                        <span class="rc-svccard__alt">/ $520–780</span>
                    </div>
                    <span class="rc-svccard__arrow" aria-hidden="true">→</span>
                </a>
                <a class="rc-svccard" href="/services#ecom">
                    <h3 class="rc-svccard__title">E-commerce</h3>
                    <p class="rc-svccard__desc">Simple storefronts for small catalogues. Payment + inventory included.</p>
                    <div class="rc-svccard__price">
                        <span class="rc-label">From</span>
                        <strong>IDR 15M+</strong>
                        <span class="rc-svccard__alt">/ $980+</span>
                    </div>
                    <span class="rc-svccard__arrow" aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>

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
                            <button class="rc-testimonial-slider__arrow rc-testimonial-slider__arrow--prev" aria-label="Previous">&larr;</button>
                            <div class="rc-testimonial-slider__dots">
                                @foreach ($testimonials as $i => $t)
                                    <button class="rc-testimonial-slider__dot{{ $i === 0 ? ' rc-testimonial-slider__dot--active' : '' }}" data-index="{{ $i }}" aria-label="Testimonial {{ $i + 1 }}"></button>
                                @endforeach
                            </div>
                            <button class="rc-testimonial-slider__arrow rc-testimonial-slider__arrow--next" aria-label="Next">&rarr;</button>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- CTA Band --}}
    <section class="rc-ctaband">
        <div class="rc-container rc-ctaband__inner">
            <span class="rc-label rc-ctaband__eyebrow">Booking Q3 2026</span>
            <h2 class="rc-ctaband__heading">Have a project in mind? Let's make it well.</h2>
            <a class="rc-ctaband__cta" href="/order">
                Start a project
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>
</x-layouts.base>
