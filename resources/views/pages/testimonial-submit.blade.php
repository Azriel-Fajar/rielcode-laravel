<x-layouts.base
    title="Share Your Experience | Rielcode"
    description="Share your experience working with Rielcode."
    bodyClass=""
>
@push('head')
<meta name="robots" content="noindex, nofollow">
<style>
.testi-page {
    padding: var(--space-16) var(--container-pad) var(--space-24);
    max-width: 720px;
    margin: 0 auto;
}

.testi-intro {
    margin-bottom: var(--space-12);
}

.testi-intro .rc-eyebrow {
    display: block;
    margin-bottom: var(--space-3);
    font-family: var(--rc-font-mono);
    font-size: var(--fs-label);
    letter-spacing: var(--ls-label);
    text-transform: uppercase;
    color: var(--rc-accent);
}

.testi-intro h1 {
    font-family: var(--rc-font-display);
    font-size: clamp(2rem, 5vw, var(--fs-h1));
    font-style: italic;
    font-weight: 700;
    line-height: var(--lh-h1);
    color: var(--rc-text);
    margin: 0 0 var(--space-4);
}

.testi-intro p {
    font-size: var(--fs-body-md);
    color: var(--rc-text-muted);
    margin: 0;
    line-height: var(--lh-body-md);
}

.testi-error {
    background: color-mix(in oklab, #dc2626 12%, var(--rc-bg));
    border: 1px solid color-mix(in oklab, #dc2626 40%, transparent);
    color: #dc2626;
    padding: var(--space-4) var(--space-6);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-6);
    font-size: var(--fs-body-sm);
}

.testi-error ul {
    margin: var(--space-2) 0 0;
    padding-left: var(--space-4);
}

.testi-form {
    display: flex;
    flex-direction: column;
    gap: var(--space-4);
}

.testi-section {
    background: var(--rc-bg-elev);
    border: 1px solid var(--rc-border);
    border-radius: var(--radius-lg);
    padding: var(--space-8);
}

.testi-section-label {
    font-family: var(--rc-font-mono);
    font-size: var(--fs-label);
    letter-spacing: var(--ls-label);
    text-transform: uppercase;
    color: var(--rc-accent);
    margin-bottom: var(--space-6);
    display: block;
}

.testi-field {
    margin-bottom: var(--space-6);
}

.testi-field:last-child {
    margin-bottom: 0;
}

.testi-label {
    display: block;
    font-size: var(--fs-body-sm);
    font-weight: 600;
    color: var(--rc-text);
    margin-bottom: var(--space-2);
}

.testi-label .req {
    color: #dc2626;
}

.testi-field input,
.testi-field textarea {
    width: 100%;
    background: var(--rc-bg);
    border: 1px solid var(--rc-border);
    border-radius: var(--radius-md);
    padding: 11px 14px;
    color: var(--rc-text);
    font-family: var(--rc-font-body);
    font-size: var(--fs-body-md);
    transition: border-color var(--transition-fast), box-shadow var(--transition-fast);
}

.testi-field input::placeholder,
.testi-field textarea::placeholder {
    color: var(--rc-text-faint);
}

.testi-field input:focus,
.testi-field textarea:focus {
    outline: none;
    border-color: var(--rc-accent);
    box-shadow: 0 0 0 3px color-mix(in oklab, var(--rc-accent) 18%, transparent);
}

.testi-field textarea {
    resize: vertical;
    min-height: 100px;
    line-height: var(--lh-body-md);
}

.testi-field.has-error input,
.testi-field.has-error textarea {
    border-color: #dc2626;
}

.testi-hint {
    display: block;
    font-size: var(--fs-label);
    color: var(--rc-text-faint);
    margin-top: var(--space-1);
    line-height: var(--lh-body-sm);
}

.testi-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-4);
}

@media (max-width: 520px) {
    .testi-row-2 { grid-template-columns: 1fr; }
}

.testi-field-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: var(--space-1);
}

.testi-char-count {
    font-family: var(--rc-font-mono);
    font-size: var(--fs-label);
    color: var(--rc-text-faint);
}

/* Star rating */
.rating-outer {
    display: flex;
    justify-content: flex-start;
}

.rating-wrap {
    display: inline-flex;
    flex-direction: row-reverse;
    gap: var(--space-1);
    position: relative;
}

.rating-wrap input[type="radio"] {
    opacity: 0;
    position: absolute;
    width: 0;
    height: 0;
}

.rating-wrap label {
    font-size: 32px;
    color: var(--rc-border-strong);
    cursor: pointer;
    transition: color var(--transition-fast);
    line-height: 1;
}

.rating-wrap input:checked ~ label,
.rating-wrap label:hover,
.rating-wrap label:hover ~ label {
    color: #d97706;
}

.rating-wrap input:focus-visible + label {
    outline: 2px solid #d97706;
    outline-offset: 2px;
    border-radius: 2px;
}

/* Custom checkbox */
.testi-checkbox-wrap {
    position: relative;
    width: 20px;
    height: 20px;
    flex-shrink: 0;
    margin-top: 1px;
}

.testi-checkbox-wrap input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    cursor: pointer;
    z-index: 1;
}

.testi-checkbox-box {
    width: 20px;
    height: 20px;
    border: 2px solid var(--rc-border-strong);
    border-radius: var(--radius-sm);
    background: var(--rc-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: border-color var(--transition-fast), background var(--transition-fast);
    pointer-events: none;
}

.testi-checkbox-wrap input:checked + .testi-checkbox-box {
    background: var(--rc-accent);
    border-color: var(--rc-accent);
}

.testi-checkbox-box svg {
    opacity: 0;
    transition: opacity var(--transition-fast);
}

.testi-checkbox-wrap input:checked + .testi-checkbox-box svg {
    opacity: 1;
}

.testi-checkbox-wrap input:focus-visible + .testi-checkbox-box {
    outline: 2px solid var(--rc-accent);
    outline-offset: 2px;
}

/* Consent */
.testi-consent {
    display: flex;
    align-items: flex-start;
    gap: var(--space-3);
    margin-bottom: var(--space-6);
}

.honeypot {
    display: none !important;
    visibility: hidden !important;
}

.testi-footer-note {
    text-align: center;
    color: var(--rc-text-faint);
    font-size: var(--fs-body-sm);
    margin-top: var(--space-6);
}
</style>
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
