{{-- Skeleton loader root - populated/cleared by filament-skeleton.js --}}
<div id="rc-skeleton-root" aria-hidden="true" style="position:relative;"></div>

<script>
    (function () {
        // Inline the skeleton JS so it runs before Livewire boots
        // Actual logic is in resources/js/filament-skeleton.js (bundled separately)
        // This script tag is a placeholder; the real module is loaded below.
    })();
</script>

@once
    <script type="module" src="{{ asset('js/filament-skeleton.js') }}"></script>
@endonce
