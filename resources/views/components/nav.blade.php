@props(['base' => '/'])

<nav class="rc-nav" aria-label="Primary" data-rc-nav data-nav>
    <div class="rc-nav__inner rc-container">
        <a class="rc-nav__logo" href="{{ $base }}">
            <span class="rc-label rc-nav__num">N°01</span>
            <span class="rc-nav__name">Rielcode</span>
        </a>

        <ul class="rc-nav__links" data-rc-nav-links>
            <li><a href="{{ $base }}work">Work</a></li>
            <li><a href="{{ $base }}studio">Studio</a></li>
            <li><a href="{{ $base }}services">Services</a></li>
            <li><a href="{{ $base }}contact">Contact</a></li>
        </ul>

        <div class="rc-nav__cta">
            <a class="rc-btn rc-btn--fill rc-btn--sm" href="{{ $base }}contact">Start a project</a>
        </div>

        <button class="rc-nav__burger" aria-label="Open menu" aria-expanded="false" data-rc-burger>
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>
