<x-layouts.base
    :title="$project->title . ' · Rielcode'"
    :description="$project->description"
>
    @push('scripts')
        @vite('resources/js/case-study.js')
    @endpush

    <header class="rc-cs-cover">
        <div class="rc-container rc-cs-cover__inner">
            <div class="rc-cs-cover__meta rc-label">
                <span>{{ substr($project->created_at, 0, 4) }}</span>
                @if ($project->tags_array)
                    <span>·</span>
                    <span>{{ implode(', ', $project->tags_array) }}</span>
                @endif
                @if ($project->url)
                    <span>·</span>
                    <a href="{{ $project->url }}" target="_blank" rel="noopener" class="rc-cs-cover__link">Visit site →</a>
                @endif
            </div>
            <h1 class="rc-cs-cover__title"><em>{{ $project->title }}</em></h1>
        </div>
        <div class="rc-cs-cover__image-wrap">
            <img src="{{ $project->image_path }}" alt="{{ $project->title }}" class="rc-cs-cover__image" data-parallax />
        </div>
    </header>

    <div class="rc-container rc-cs-body">
        <p>{{ $project->description }}</p>

        @if ($project->stack_array)
            <h2>Tech stack</h2>
            <ul>
                @foreach ($project->stack_array as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="rc-container">
        <div class="rc-cs-next">
            <span class="rc-label">Next project</span>
            <a href="/work" class="rc-cs-next__link">
                <span>Back to all work</span>
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>

    <section class="rc-ctaband">
        <div class="rc-container rc-ctaband__inner">
            <span class="rc-label rc-ctaband__eyebrow">Work with Rielcode</span>
            <h2 class="rc-ctaband__heading">Want a site built with this much care?</h2>
            <a class="rc-ctaband__cta" href="/order">
                Start a project
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </section>
</x-layouts.base>
