document.addEventListener('DOMContentLoaded', () => {
    const slider = document.getElementById('testimonialSlider');
    if (!slider) return;

    const track = slider.querySelector('.rc-testimonial-slider__track');
    const slides = slider.querySelectorAll('.rc-testimonial-slider__slide');
    const dots = slider.querySelectorAll('.rc-testimonial-slider__dot');
    const prevBtn = slider.querySelector('.rc-testimonial-slider__arrow--prev');
    const nextBtn = slider.querySelector('.rc-testimonial-slider__arrow--next');
    const delay = parseInt(slider.dataset.autoplay || '6000', 10);

    let current = 0;
    let timer = null;

    function goTo(index) {
        current = (index + slides.length) % slides.length;
        track.style.transform = `translateX(-${current * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle('rc-testimonial-slider__dot--active', i === current));
    }

    function startTimer() {
        timer = setInterval(() => goTo(current + 1), delay);
    }

    function stopTimer() {
        clearInterval(timer);
    }

    prevBtn.addEventListener('click', () => { stopTimer(); goTo(current - 1); startTimer(); });
    nextBtn.addEventListener('click', () => { stopTimer(); goTo(current + 1); startTimer(); });
    dots.forEach((d, i) => d.addEventListener('click', () => { stopTimer(); goTo(i); startTimer(); }));

    slider.addEventListener('mouseenter', stopTimer);
    slider.addEventListener('mouseleave', startTimer);

    startTimer();
});
