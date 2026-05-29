<x-layouts.base
    title="Contact · Rielcode"
    description="Get in touch with Rielcode to start a website project or ask a question."
>
    {{-- Hero --}}
    <section class="rc-contact-hero">
        <div class="rc-container rc-contact-hero__inner">
            <span class="rc-label">Let's talk</span>
            <h1 class="rc-contact-hero__title">
                Start a project.<br /><em>We'll make it well.</em>
            </h1>
        </div>
    </section>

    {{-- Form + aside --}}
    <section class="rc-section rc-section--pad-tight">
        <div class="rc-container">
            <div class="rc-contact-grid">
                <div>
                    @if ($sent)
                    <div class="rc-form-success">
                        <strong>Message sent.</strong> I'll reply within 24 hours.
                    </div>
                    @endif

                    <form
                        class="rc-form"
                        method="POST"
                        action="/contact"
                        @if ($sent) style="display:none" @endif
                    >
                        @csrf
                        {{-- honeypot --}}
                        <input
                            type="text"
                            name="website"
                            tabindex="-1"
                            autocomplete="off"
                            style="position:absolute;left:-10000px;width:1px;height:1px;opacity:0"
                            aria-hidden="true"
                        />

                        @if ($errors->any())
                        <div class="rc-form-errors">
                            @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                        </div>
                        @endif

                        <div class="rc-field">
                            <label for="name" class="rc-label">Your name</label>
                            <input
                                id="name" name="name" type="text" required
                                autocomplete="name" class="rc-input"
                                value="{{ old('name') }}"
                            />
                        </div>

                        <div class="rc-field">
                            <label for="email" class="rc-label">Email address</label>
                            <input
                                id="email" name="email" type="email" required
                                autocomplete="email" class="rc-input"
                                value="{{ old('email') }}"
                            />
                        </div>

                        <div class="rc-field">
                            <label for="project_type" class="rc-label">Project type</label>
                            <select id="project_type" name="project_type" class="rc-input rc-select">
                                <option value="">Select one</option>
                                <option value="landing"  @selected(old('project_type') === 'landing')>Landing page</option>
                                <option value="custom"   @selected(old('project_type') === 'custom')>Custom website</option>
                                <option value="ecom"     @selected(old('project_type') === 'ecom')>E-commerce</option>
                                <option value="other"    @selected(old('project_type') === 'other')>Other / not sure yet</option>
                            </select>
                        </div>

                        <div class="rc-field">
                            <label for="message" class="rc-label">Message</label>
                            <textarea id="message" name="message" rows="6" required class="rc-input">{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="rc-btn rc-btn--fill rc-btn--lg">
                            Send message
                        </button>

                        <p class="rc-form__legal">
                            By submitting you agree to our <a href="/privacy">privacy policy</a>.
                        </p>
                    </form>
                </div>

                <aside class="rc-contact-aside">
                    <div class="rc-contact-aside__block">
                        <span class="rc-label">Email</span>
                        <a href="mailto:info@rielcode.com" class="rc-contact-aside__link">info@rielcode.com</a>
                    </div>
                    <div class="rc-contact-aside__block">
                        <span class="rc-label">WhatsApp</span>
                        <a href="https://wa.me/6281295536876?text=Hi%21%20I%27d%20like%20to%20discuss%20a%20project." target="_blank" rel="noopener" class="rc-contact-aside__link">Message on WhatsApp →</a>
                    </div>
                    <div class="rc-contact-aside__block">
                        <span class="rc-label">Response time</span>
                        <p class="rc-contact-aside__detail">Within 24 hours (UTC+7). Usually faster.</p>
                    </div>
                    <div class="rc-contact-aside__block">
                        <span class="rc-label">Availability</span>
                        <p class="rc-contact-aside__detail">Open to new projects. Reach out anytime.</p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.base>
