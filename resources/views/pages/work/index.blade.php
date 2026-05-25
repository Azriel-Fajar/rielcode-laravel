<x-layouts.base
    title="Work · Rielcode"
    description="Case studies from Rielcode: editorial websites, landing pages, and e-commerce built end-to-end."
>
    <section class="rc-work-hero">
        <div class="rc-container rc-work-hero__inner">
            <span class="rc-label">Selected work</span>
            <h1 class="rc-work-hero__title">
                <em>Built</em> with intention.
            </h1>
        </div>
    </section>

    <section class="rc-work-grid-section">
        <div class="rc-container">
            <div class="rc-work-grid">
                @foreach ($projects as $i => $project)
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
                <div class="rc-work-placeholder">
                    <span class="rc-label">More case studies</span>
                    <p>Currently in production. Check back soon.</p>
                </div>
            </div>
        </div>
    </section>

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
