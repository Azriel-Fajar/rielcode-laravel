@php $year = date('Y'); @endphp

<footer class="rc-footer">
    <div class="rc-container rc-footer__inner">
        <div class="rc-footer__brand">
            <span class="rc-label">N°01 · Rielcode Studio</span>
            <p class="rc-footer__tag">
                Websites with uncommon polish.
            </p>
        </div>

        <nav class="rc-footer__nav" aria-label="Footer">
            <div>
                <h2 class="rc-footer__heading">Studio</h2>
                <a href="/work">Work</a>
                <a href="/studio">About</a>
                <a href="/services">Services</a>
                <a href="/contact">Contact</a>
            </div>
            <div>
                <h2 class="rc-footer__heading">Legal</h2>
                <a href="/privacy">Privacy</a>
                <a href="/terms">Terms</a>
            </div>
        </nav>

        <div class="rc-footer__controls">
            <x-theme-toggle />
        </div>
    </div>

    <div class="rc-container rc-footer__bottom">
        <small>© {{ $year }} Rielcode. All rights reserved.</small>
    </div>
</footer>
