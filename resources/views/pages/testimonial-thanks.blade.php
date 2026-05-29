<x-layouts.base
    title="Thank You | Rielcode"
    description="Your testimonial has been submitted."
    bodyClass=""
>
@push('head')
<meta name="robots" content="noindex, nofollow">
<script>document.documentElement.setAttribute('data-theme','light');</script>
<style>
.thanks-page {
    padding: var(--space-16) var(--container-pad) var(--space-24);
    max-width: 560px;
    margin: 0 auto;
    text-align: center;
}

.thanks-star {
    font-size: 48px;
    line-height: 1;
    margin-bottom: var(--space-6);
    color: #d97706;
}

.thanks-page h1 {
    font-family: var(--rc-font-display);
    font-size: clamp(2rem, 5vw, var(--fs-h1));
    font-style: italic;
    font-weight: 700;
    line-height: var(--lh-h1);
    color: var(--rc-text);
    margin: 0 0 var(--space-4);
}

.thanks-page p {
    font-size: var(--fs-body-md);
    color: var(--rc-text-muted);
    line-height: var(--lh-body-md);
    margin: 0 0 var(--space-10);
}
</style>
@endpush

<div class="thanks-page">
    <div class="thanks-star">★</div>
    <h1>Thank you for<br><em>your review.</em></h1>
    <p>Your testimonial has been submitted and will be reviewed before going live. I really appreciate you taking the time.</p>
    <a href="https://rielcode.com" class="rc-btn rc-btn--fill">Back to rielcode.com</a>
</div>

</x-layouts.base>
