<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Share Your Experience | Rielcode</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body { background: #0b0d12; color: #e7e9ee; font-family: 'Outfit', system-ui, sans-serif; margin: 0; }
        .topbar { display: flex; align-items: center; justify-content: space-between; padding: 14px 24px; border-bottom: 1px solid rgba(255,255,255,.08); }
        .topbar a { color: rgba(255,255,255,.6); text-decoration: none; font-size: 14px; display: flex; align-items: center; gap: 6px; }
        .topbar a:hover { color: #fff; }
        .topbar img { height: 28px; }
        .page-wrapper { max-width: 680px; margin: 0 auto; padding: 48px 22px 80px; }
        .intro { margin-bottom: 36px; }
        .rc-eyebrow { font-family: 'JetBrains Mono', monospace; font-size: 11px; letter-spacing: .12em; color: #8ab4ff; text-transform: uppercase; display: block; margin-bottom: 10px; }
        .intro h1 { font-size: 2rem; font-weight: 700; margin: 0 0 12px; line-height: 1.2; }
        .gradient-text { background: linear-gradient(135deg, #3a7bff 0%, #a78bfa 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .intro p { color: #a8adba; margin: 0; line-height: 1.6; }
        .error-banner { background: #3a1722; border: 1px solid #6b2235; color: #ffb3c1; padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 14px; }
        .error-banner ul { margin: 8px 0 0; padding-left: 18px; }
        .testimonial-form { display: flex; flex-direction: column; gap: 0; }
        .form-section { background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08); border-radius: 12px; padding: 24px; margin-bottom: 16px; }
        .section-label { font-family: 'JetBrains Mono', monospace; font-size: 11px; letter-spacing: .1em; color: #8ab4ff; text-transform: uppercase; margin-bottom: 18px; }
        .field-group { margin-bottom: 18px; }
        .field-group:last-child { margin-bottom: 0; }
        .field-label { display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #fff; }
        .field-label .req { color: #f87171; }
        .field-group input, .field-group textarea { width: 100%; background: #0b0d12; border: 1px solid rgba(255,255,255,.12); border-radius: 8px; padding: 11px 14px; color: #e7e9ee; font-family: inherit; font-size: 15px; }
        .field-group input:focus, .field-group textarea:focus { outline: none; border-color: #3a7bff; box-shadow: 0 0 0 3px rgba(58,123,255,.18); }
        .field-group textarea { resize: vertical; min-height: 100px; line-height: 1.55; }
        .field-group.has-error input, .field-group.has-error textarea { border-color: #f87171; }
        .hint { font-size: 12px; color: #8a90a0; margin-top: 5px; display: block; }
        .row-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media (max-width: 520px) { .row-2col { grid-template-columns: 1fr; } }
        .rating-group { display: flex; flex-direction: row-reverse; gap: 4px; }
        .rating-group input[type=radio] { display: none; }
        .rating-group label { font-size: 28px; color: rgba(255,255,255,.2); cursor: pointer; transition: color .15s; }
        .rating-group input:checked ~ label, .rating-group label:hover, .rating-group label:hover ~ label { color: #fbbf24; }
        .field-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 5px; }
        .char-count { font-size: 12px; color: #8a90a0; font-family: 'JetBrains Mono', monospace; }
        .consent-group { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 24px; }
        .consent-group input { width: 18px; height: 18px; margin-top: 2px; flex-shrink: 0; accent-color: #3a7bff; cursor: pointer; }
        .consent-group label { font-size: 14px; color: #a8adba; cursor: pointer; line-height: 1.5; }
        .honeypot { display: none !important; visibility: hidden !important; }
        .submit-btn { display: flex; align-items: center; justify-content: center; gap: 10px; background: #3a7bff; color: #fff; border: 0; border-radius: 10px; padding: 16px 32px; font-size: 16px; font-weight: 600; cursor: pointer; font-family: inherit; transition: background .15s; }
        .submit-btn:hover { background: #2c66e0; }
        .submit-btn:disabled { opacity: .6; cursor: not-allowed; }
        .footer-note { text-align: center; color: rgba(255,255,255,.3); font-size: 13px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="topbar">
        <a href="https://rielcode.com">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Back to rielcode.com
        </a>
        <a href="https://rielcode.com">
            <img src="https://rielcode.com/IMG/Rielcode%20Logo%20Transparent.png" alt="Rielcode">
        </a>
    </div>

    <main class="page-wrapper">

        <div class="intro">
            <span class="rc-eyebrow">client testimonial</span>
            <h1>Tell us about your <br><span class="gradient-text">Rielcode experience</span></h1>
            <p>Your feedback shapes how Rielcode grows and helps future clients make confident decisions. Takes about 2 minutes.</p>
        </div>

        @if ($errors->any())
            <div class="error-banner">
                <strong>Please fix the following:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="testimonial-form" method="POST" action="{{ route('testimonial.store') }}" novalidate>
            @csrf
            <input type="hidden" name="t" value="{{ $token }}">
            <input type="text" name="website" class="honeypot" tabindex="-1" autocomplete="off" aria-hidden="true">

            <div class="form-section">
                <div class="section-label">01 &mdash; About you</div>
                <div class="row-2col">
                    <div class="field-group {{ $errors->has('client_name') ? 'has-error' : '' }}">
                        <label class="field-label" for="client_name">Your name <span class="req">*</span></label>
                        <input type="text" id="client_name" name="client_name" maxlength="80" required placeholder="e.g. Jane Smith" value="{{ old('client_name') }}">
                    </div>
                    <div class="field-group {{ $errors->has('role_title') ? 'has-error' : '' }}">
                        <label class="field-label" for="role_title">Role / title <span class="req">*</span></label>
                        <input type="text" id="role_title" name="role_title" maxlength="80" required placeholder="e.g. Owner, Marketing Manager" value="{{ old('role_title') }}">
                    </div>
                </div>
                <div class="field-group {{ $errors->has('business_name') ? 'has-error' : '' }}">
                    <label class="field-label" for="business_name">Business / company name <span class="req">*</span></label>
                    <input type="text" id="business_name" name="business_name" maxlength="100" required placeholder="e.g. Acme Inc." value="{{ old('business_name') }}">
                </div>
            </div>

            <div class="form-section">
                <div class="section-label">02 &mdash; Your project</div>
                <div class="field-group {{ $errors->has('rating') ? 'has-error' : '' }}">
                    <label class="field-label">Overall rating <span class="req">*</span></label>
                    <div class="rating-group">
                        @foreach ([5,4,3,2,1] as $r)
                            <input type="radio" id="rating-{{ $r }}" name="rating" value="{{ $r }}" {{ old('rating') == $r ? 'checked' : '' }} required>
                            <label for="rating-{{ $r }}" title="{{ $r }} star{{ $r > 1 ? 's' : '' }}">&#9733;</label>
                        @endforeach
                    </div>
                    <span class="hint">1 = poor &mdash; 5 = excellent</span>
                </div>
                <div class="field-group {{ $errors->has('project_url') ? 'has-error' : '' }}">
                    <label class="field-label" for="project_url">Project URL <span class="req">*</span></label>
                    <input type="url" id="project_url" name="project_url" maxlength="255" required placeholder="https://yoursite.com" value="{{ old('project_url') }}">
                    <span class="hint">The site Rielcode built or worked on for you.</span>
                </div>
            </div>

            <div class="form-section">
                <div class="section-label">03 &mdash; Your story</div>
                <div class="field-group {{ $errors->has('problem_before') ? 'has-error' : '' }}">
                    <label class="field-label" for="problem_before">What problem did you have before working with Rielcode? <span class="req">*</span></label>
                    <textarea id="problem_before" name="problem_before" maxlength="300" required data-counter>{{ old('problem_before') }}</textarea>
                    <div class="field-meta">
                        <span class="hint">Min 40 characters.</span>
                        <span class="char-count" data-target="problem_before">0 / 300</span>
                    </div>
                </div>
                <div class="field-group {{ $errors->has('solution_after') ? 'has-error' : '' }}">
                    <label class="field-label" for="solution_after">What did Rielcode build for you, and how did it solve that problem? <span class="req">*</span></label>
                    <textarea id="solution_after" name="solution_after" maxlength="500" required data-counter>{{ old('solution_after') }}</textarea>
                    <div class="field-meta">
                        <span class="hint">Min 50 characters.</span>
                        <span class="char-count" data-target="solution_after">0 / 500</span>
                    </div>
                </div>
                <div class="field-group {{ $errors->has('recommendation') ? 'has-error' : '' }}">
                    <label class="field-label" for="recommendation">Would you recommend Rielcode to others? Why? <span class="req">*</span></label>
                    <textarea id="recommendation" name="recommendation" maxlength="300" required data-counter>{{ old('recommendation') }}</textarea>
                    <div class="field-meta">
                        <span class="hint">Min 40 characters.</span>
                        <span class="char-count" data-target="recommendation">0 / 300</span>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="section-label">04 &mdash; Optional extras</div>
                <div class="field-group {{ $errors->has('headline') ? 'has-error' : '' }}">
                    <label class="field-label" for="headline">One-line headline summary</label>
                    <input type="text" id="headline" name="headline" maxlength="120" placeholder='"Rielcode delivered a clean, fast site in 2 weeks."' value="{{ old('headline') }}">
                    <span class="hint">If blank, we'll pull a quote from your answers above.</span>
                </div>
                <div class="field-group {{ $errors->has('client_email') ? 'has-error' : '' }}">
                    <label class="field-label" for="client_email">Email</label>
                    <input type="email" id="client_email" name="client_email" maxlength="120" placeholder="for follow-up only, never displayed" value="{{ old('client_email') }}">
                    <span class="hint">Only used if we need to clarify something. Never published.</span>
                </div>
            </div>

            <div class="consent-group {{ $errors->has('consent_given') ? 'has-error' : '' }}">
                <input type="checkbox" id="consent_given" name="consent_given" value="1" required {{ old('consent_given') ? 'checked' : '' }}>
                <label for="consent_given">
                    I allow Rielcode to display this testimonial publicly on rielcode.com and use quotes from it in marketing materials. <span class="req">*</span>
                </label>
            </div>

            <button type="submit" class="submit-btn" id="submitBtn">
                <span class="btn-text">Submit Testimonial</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </form>

        <p class="footer-note">Your testimonial will be reviewed before going public.</p>

    </main>

    <script>
        document.querySelectorAll('textarea[data-counter]').forEach(t => {
            const counter = document.querySelector(`[data-target="${t.id}"]`);
            const max = parseInt(t.getAttribute('maxlength'), 10);
            const update = () => {
                counter.textContent = `${t.value.length} / ${max}`;
            };
            t.addEventListener('input', update);
            update();
        });

        const form = document.querySelector('form.testimonial-form');
        const btn = document.getElementById('submitBtn');
        form.addEventListener('submit', () => {
            btn.disabled = true;
            btn.querySelector('.btn-text').textContent = 'Submitting...';
        });
    </script>
</body>
</html>
