<x-layouts.base
    title="Share Your Experience | Rielcode"
    description="Share your experience working with Rielcode."
    bodyClass=""
>
@push('head')
<meta name="robots" content="noindex, nofollow">
@vite(['resources/css/pages/testimonial.css'])
@endpush

<div class="testi-page">

    <div class="testi-intro">
        <span class="rc-eyebrow">client testimonial</span>
        <h1>Tell us about your<br><em>Rielcode experience</em></h1>
        <p>Your feedback shapes how Rielcode grows and helps future clients make confident decisions. Takes about 2 minutes.</p>
    </div>

    @if ($errors->any())
        <div class="testi-error">
            <strong>Please fix the following:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="testi-form" method="POST" action="{{ route('testimonial.store') }}" novalidate>
        @csrf
        <input type="hidden" name="t" value="{{ $token }}">
        <input type="text" name="website" class="honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">

        <div class="testi-section">
            <span class="testi-section-label">01 · About you</span>
            <div class="testi-row-2">
                <div class="testi-field {{ $errors->has('client_name') ? 'has-error' : '' }}">
                    <label class="testi-label" for="client_name">Your name <span class="req">*</span></label>
                    <input type="text" id="client_name" name="client_name" maxlength="80" required placeholder="e.g. Jane Smith" value="{{ old('client_name') }}">
                </div>
                <div class="testi-field {{ $errors->has('role_title') ? 'has-error' : '' }}">
                    <label class="testi-label" for="role_title">Role / title <span class="req">*</span></label>
                    <input type="text" id="role_title" name="role_title" maxlength="80" required placeholder="e.g. Owner, Marketing Manager" value="{{ old('role_title') }}">
                </div>
            </div>
            <div class="testi-field {{ $errors->has('business_name') ? 'has-error' : '' }}">
                <label class="testi-label" for="business_name">Business / company name <span class="req">*</span></label>
                <input type="text" id="business_name" name="business_name" maxlength="100" required placeholder="e.g. Acme Inc." value="{{ old('business_name') }}">
            </div>
        </div>

        <div class="testi-section">
            <span class="testi-section-label">02 · Your project</span>
            <div class="testi-field {{ $errors->has('rating') ? 'has-error' : '' }}">
                <label class="testi-label">Overall rating <span class="req">*</span></label>
                <div class="rating-outer">
                    <div class="rating-wrap">
                        @foreach ([5,4,3,2,1] as $r)
                            <input type="radio" id="rating-{{ $r }}" name="rating" value="{{ $r }}" {{ old('rating') == $r ? 'checked' : '' }} required>
                            <label for="rating-{{ $r }}" title="{{ $r }} star{{ $r > 1 ? 's' : '' }}">&#9733;</label>
                        @endforeach
                    </div>
                </div>
                <span class="testi-hint">1 = poor, 5 = excellent</span>
            </div>
            <div class="testi-field {{ $errors->has('project_url') ? 'has-error' : '' }}">
                <label class="testi-label" for="project_url">Project URL <span class="req">*</span></label>
                <input type="url" id="project_url" name="project_url" maxlength="255" required placeholder="https://yoursite.com" value="{{ old('project_url') }}">
                <span class="testi-hint">The site Rielcode built or worked on for you.</span>
            </div>
        </div>

        <div class="testi-section">
            <span class="testi-section-label">03 · Your story</span>
            <div class="testi-field {{ $errors->has('problem_before') ? 'has-error' : '' }}">
                <label class="testi-label" for="problem_before">What problem did you have before working with Rielcode? <span class="req">*</span></label>
                <textarea id="problem_before" name="problem_before" maxlength="300" required data-counter>{{ old('problem_before') }}</textarea>
                <div class="testi-field-meta">
                    <span class="testi-hint">Min 40 characters.</span>
                    <span class="testi-char-count" data-target="problem_before">0 / 300</span>
                </div>
            </div>
            <div class="testi-field {{ $errors->has('solution_after') ? 'has-error' : '' }}">
                <label class="testi-label" for="solution_after">What did Rielcode build for you, and how did it solve that problem? <span class="req">*</span></label>
                <textarea id="solution_after" name="solution_after" maxlength="500" required data-counter>{{ old('solution_after') }}</textarea>
                <div class="testi-field-meta">
                    <span class="testi-hint">Min 50 characters.</span>
                    <span class="testi-char-count" data-target="solution_after">0 / 500</span>
                </div>
            </div>
            <div class="testi-field {{ $errors->has('recommendation') ? 'has-error' : '' }}">
                <label class="testi-label" for="recommendation">Would you recommend Rielcode to others? Why? <span class="req">*</span></label>
                <textarea id="recommendation" name="recommendation" maxlength="300" required data-counter>{{ old('recommendation') }}</textarea>
                <div class="testi-field-meta">
                    <span class="testi-hint">Min 40 characters.</span>
                    <span class="testi-char-count" data-target="recommendation">0 / 300</span>
                </div>
            </div>
        </div>

        <div class="testi-section">
            <span class="testi-section-label">04 · Optional extras</span>
            <div class="testi-field {{ $errors->has('headline') ? 'has-error' : '' }}">
                <label class="testi-label" for="headline">One-line headline summary</label>
                <input type="text" id="headline" name="headline" maxlength="120" placeholder='"Rielcode delivered a clean, fast site in 2 weeks."' value="{{ old('headline') }}">
                <span class="testi-hint">If blank, we'll pull a quote from your answers above.</span>
            </div>
            <div class="testi-field {{ $errors->has('client_email') ? 'has-error' : '' }}">
                <label class="testi-label" for="client_email">Email</label>
                <input type="email" id="client_email" name="client_email" maxlength="120" placeholder="for follow-up only, never displayed" value="{{ old('client_email') }}">
                <span class="testi-hint">Only used if we need to clarify something. Never published.</span>
            </div>
        </div>

        <div class="testi-consent {{ $errors->has('consent_given') ? 'has-error' : '' }}">
            <label class="testi-checkbox-wrap">
                <input type="checkbox" id="consent_given" name="consent_given" value="1" required {{ old('consent_given') ? 'checked' : '' }}>
                <span class="testi-checkbox-box">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="color:var(--rc-on-accent)">
                        <polyline points="2,6 5,9 10,3"/>
                    </svg>
                </span>
            </label>
            <label for="consent_given" style="font-size:var(--fs-body-sm);color:var(--rc-text-muted);cursor:pointer;line-height:var(--lh-body-sm);">
                I allow Rielcode to display this testimonial publicly on rielcode.com and use quotes from it in marketing materials. <span class="req">*</span>
            </label>
        </div>

        <div>
            <button type="submit" class="rc-btn rc-btn--fill" id="submitBtn">
                <span class="btn-text">Submit Testimonial</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </div>
    </form>

    <p class="testi-footer-note">Your testimonial will be reviewed before going public.</p>

</div>

@push('scripts')
<script>
    document.querySelectorAll('textarea[data-counter]').forEach(t => {
        const counter = document.querySelector(`[data-target="${t.id}"]`);
        const max = parseInt(t.getAttribute('maxlength'), 10);
        const update = () => { counter.textContent = `${t.value.length} / ${max}`; };
        t.addEventListener('input', update);
        update();
    });

    const form = document.querySelector('form.testi-form');
    const btn = document.getElementById('submitBtn');
    form.addEventListener('submit', () => {
        btn.disabled = true;
        btn.querySelector('.btn-text').textContent = 'Submitting…';
    });
</script>
@endpush

</x-layouts.base>
