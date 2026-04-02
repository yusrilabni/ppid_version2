@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. HERO SLIDER
            const heroSwiper = new Swiper('.hero-slider', {
                loop: true,
                effect: '{{ $sliderAnimationType }}',
                autoHeight: {{ $sliderAspectRatio === 'aspect-auto' ? 'true' : 'false' }},
                speed: 1200,
                parallax: true,
                grabCursor: true,
                watchSlidesProgress: true,
                autoplay: {
                    delay: {{ $transitionDuration }},
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                pagination: {
                    el: '.hero-slider .swiper-pagination',
                    clickable: true,
                    dynamicBullets: true
                },
                navigation: {
                    nextEl: '.swiper-button-next-custom',
                    prevEl: '.swiper-button-prev-custom'
                },
                @if($sliderAnimationType === 'fade')
                fadeEffect: { crossFade: true },
                @elseif($sliderAnimationType === 'cube')
                cubeEffect: { shadow: true, slideShadows: true, shadowOffset: 20, shadowScale: 0.94 },
                @elseif($sliderAnimationType === 'flip')
                flipEffect: { rotate: 30, slideShadows: true },
                @elseif($sliderAnimationType === 'coverflow')
                coverflowEffect: { rotate: 35, stretch: 0, depth: 100, modifier: 1, slideShadows: true },
                @endif
                on: {
                    init: function() {
                        const self = this;
                        if ('{{ $sliderAspectRatio }}' === 'aspect-first') {
                            const lockToFirst = () => {
                                const firstSlide = self.slides.find(s => s.getAttribute('data-swiper-slide-index') === '0');
                                const firstImg = firstSlide ? firstSlide.querySelector('img') : null;
                                if (firstImg && firstImg.complete && firstImg.naturalWidth) {
                                    const ratio = firstImg.naturalHeight / firstImg.naturalWidth;
                                    const targetHeight = self.el.offsetWidth * ratio;
                                    self.el.style.height = targetHeight + 'px';
                                    self.slides.forEach(s => s.style.height = targetHeight + 'px');
                                    self.update();
                                } else if (firstImg) {
                                    firstImg.onload = lockToFirst;
                                }
                            };
                            setTimeout(lockToFirst, 300);
                            window.addEventListener('resize', lockToFirst);
                        }
                    },
                    slideChangeTransitionStart: function() {
                        if (this.params.autoHeight) this.updateAutoHeight(800);
                    }
                }
            });

            // 2. LATEST INFO CAROUSEL
            new Swiper('.latest-info-carousel', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                speed: 800,
                grabCursor: true,
                watchSlidesProgress: true,
                autoplay: { delay: 4000, disableOnInteraction: false, pauseOnMouseEnter: true },
                pagination: { el: '.latest-info-pagination', clickable: true, dynamicBullets: true },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4 }
                }
            });

            // 3. NEWS CAROUSEL
            new Swiper('.news-carousel', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                speed: 800,
                grabCursor: true,
                watchSlidesProgress: true,
                autoplay: { delay: 5000, disableOnInteraction: false, pauseOnMouseEnter: true },
                pagination: { el: '.news-pagination', clickable: true, dynamicBullets: true },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                    1280: { slidesPerView: 4 }
                }
            });

            // 4. CONTACT FORM LOGIC
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('submitBtn');
                    const submitText = document.getElementById('submitText');
                    const loadingSpinner = document.getElementById('loadingSpinner');
                    const formMessage = document.getElementById('formMessage');
                    const formData = new FormData(this);
                    
                    submitBtn.disabled = true;
                    submitText.classList.add('hidden');
                    loadingSpinner.classList.remove('hidden');

                    try {
                        const method = formData.get('method') || 'email';
                        const name = formData.get('name');
                        const subject = formData.get('subject');
                        const message = formData.get('message');
                        
                        if (method === 'email') {
                            const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=ppidkabsinjai@gmail.com&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(message)}`;
                            window.open(gmailUrl, '_blank');
                        } else {
                            const waUrl = `https://wa.me/6285156878911?text=${encodeURIComponent('*Pesan Baru*\nName: ' + name + '\nSubjek: ' + subject + '\n' + message)}`;
                            window.open(waUrl, '_blank');
                        }
                        formMessage.textContent = "Pesan Anda telah disiapkan.";
                        formMessage.className = "text-center text-sm mt-4 text-green-600 font-bold";
                        formMessage.classList.remove('hidden');
                        this.reset();
                    } catch (error) {
                        formMessage.textContent = "Terjadi kesalahan.";
                        formMessage.className = "text-center text-sm mt-4 text-red-600";
                        formMessage.classList.remove('hidden');
                    } finally {
                        submitBtn.disabled = false;
                        submitText.classList.remove('hidden');
                        loadingSpinner.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@endpush
