<x-layouts.base
    title="Studio · Rielcode"
    description="Rielcode builds editorial websites for the world. About our process, values, and FAQ."
>
    {{-- Hero --}}
    <section class="rc-studio-hero">
        <div class="rc-container rc-studio-hero__inner">
            <span class="rc-label">N°01 · The studio</span>
            <h1 class="rc-studio-hero__title">
                <em>Editorial websites</em><br />built for the world.
            </h1>
            <p class="rc-studio-hero__body">
                Rielcode treats each website as an editorial product, not a template fill.
            </p>
            @if ($studioHeroImage)
                <div class="rc-studio-hero__media">
                    <img src="{{ $studioHeroImage }}" alt="Rielcode Studio" loading="lazy" />
                </div>
            @endif
        </div>
    </section>

    {{-- Process --}}
    <section class="rc-section rc-section--bg-elev rc-section--pad-default" id="process">
        <div class="rc-container">
            <div class="rc-studio-sec-head">
                <span class="rc-label">How it works</span>
                <h2>Four steps, every project.</h2>
            </div>
            <ol class="rc-process">
                <li class="rc-process__item">
                    <span class="rc-process__num rc-label">01</span>
                    <h3 class="rc-process__title">Brief</h3>
                    <p class="rc-process__body">We start with a focused brief: goals, audience, references, constraints. No guesswork. A clear brief makes everything downstream faster and better.</p>
                </li>
                <li class="rc-process__item">
                    <span class="rc-process__num rc-label">02</span>
                    <h3 class="rc-process__title">Design</h3>
                    <p class="rc-process__body">Typography-first layout in Figma or direct-to-code depending on complexity. You review every key screen before development starts.</p>
                </li>
                <li class="rc-process__item">
                    <span class="rc-process__num rc-label">03</span>
                    <h3 class="rc-process__title">Build</h3>
                    <p class="rc-process__body">Static Astro builds for marketing sites. Custom stacks for more complex projects. Pixel-precise implementation. No template drift.</p>
                </li>
                <li class="rc-process__item">
                    <span class="rc-process__num rc-label">04</span>
                    <h3 class="rc-process__title">Ship</h3>
                    <p class="rc-process__body">Deployed to your preferred host. Includes a handoff doc with admin access, DNS notes, and 14 days of bug-fix coverage.</p>
                </li>
            </ol>
        </div>
    </section>

    {{-- Values --}}
    <section class="rc-section rc-section--bg-default rc-section--pad-default" id="values">
        <div class="rc-container">
            <div class="rc-studio-sec-head">
                <span class="rc-label">What we believe</span>
                <h2>Three things that guide every build.</h2>
            </div>
            <ul class="rc-values">
                <li class="rc-values__item">
                    <h3 class="rc-values__title">Composition over decoration</h3>
                    <p class="rc-values__body">Premium feels earned, not loud. Whitespace, type hierarchy, and rhythm do more than gradients and glow.</p>
                </li>
                <li class="rc-values__item">
                    <h3 class="rc-values__title">Clarity of intent</h3>
                    <p class="rc-values__body">Every page has one job. We scope it, design for it, and don't bury it under options.</p>
                </li>
                <li class="rc-values__item">
                    <h3 class="rc-values__title">Speed of trust</h3>
                    <p class="rc-values__body">Short feedback loops, WhatsApp-first communication, honest timelines. No surprise delays.</p>
                </li>
            </ul>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="rc-section rc-section--bg-elev rc-section--pad-default" id="faq">
        <div class="rc-container">
            <div class="rc-studio-sec-head">
                <span class="rc-label">Questions</span>
                <h2>Answers upfront.</h2>
            </div>
            <div class="rc-faq">
                @foreach ($faqs as $item)
                    <details class="rc-faq__item">
                        <summary class="rc-faq__q">
                            <span>{{ $item->question }}</span>
                            <span class="rc-faq__icon" aria-hidden="true">+</span>
                        </summary>
                        <div class="rc-faq__a">
                            <p>{{ $item->answer }}</p>
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA Band --}}
    <section class="rc-ctaband">
        <div class="rc-container rc-ctaband__inner">
            <span class="rc-label rc-ctaband__eyebrow">Open to Projects</span>
            <h2 class="rc-ctaband__heading">Ready to start a project?</h2>
            <a class="rc-ctaband__cta" href="/contact">
                Get in touch
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>
</x-layouts.base>
