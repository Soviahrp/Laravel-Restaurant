<section id="review" class="review section light-background">
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Review</h2>
        <p>What Are They <span class="description-title">Saying About Us</span></p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
                {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": "auto",
                    "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                    }
                }
            </script>
            <div class="swiper-wrapper">
                @foreach ($reviews as $review)
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row gy-4 justify-content-center">
                                <div class="col-lg-6">
                                    <div class="testimonial-content">
                                        <p>
                                            <i class="bi bi-quote quote-icon-left"></i>
                                            <span>{{ $review->comment ?? 'No comment provided.' }}</span>
                                            <i class="bi bi-quote quote-icon-right"></i>
                                        </p>
                                        @if ($review->transaction)
                                            <h3>{{ $review->transaction->name }}</h3>
                                        @else
                                            <h3>Anonim</h3>
                                        @endif
                                        <div class="stars">
                                            @for ($i = 0; $i < $review->rate; $i++)
                                                <i class="bi bi-star-fill"></i>
                                            @endfor
                                            @for ($i = $review->rate; $i < 5; $i++)
                                                <i class="bi bi-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 text-center">
                                    <img src="{{ asset('storage/' . $review->transaction->file) }}"
                                        class="img-fluid testimonial-img"
                                        alt="{{ $review->transaction->name ?? 'Testimonial Image' }}">
                                </div>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section><!-- /Testimonials Section -->
