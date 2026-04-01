@extends('frontend.layouts.app')

@push('css')
    <style>
        .faq-banner-slider {
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            --swiper-navigation-color: var(--primary);
            --swiper-pagination-color: var(--primary);
        }
        .faq-banner-slide {
            position: relative;
        }
        .faq-banner-slide img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            display: block;
        }
        .faq-banner-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.35);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 3rem;
            color: #fff;
        }
        .faq-banner-title {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: .03em;
        }
        .faq-banner-desc {
            max-width: 520px;
            margin-top: .75rem;
            font-size: .95rem;
        }

        .faq-banner-slider .swiper-button-prev,
        .faq-banner-slider .swiper-button-next {
            color: var(--primary);
        }

        .faq-banner-slider .swiper-pagination-bullet {
            background-color: var(--rgba-primary-3);
            opacity: 1;
        }
        .faq-banner-slider .swiper-pagination-bullet-active {
            background-color: var(--primary);
            opacity: 1;
        }

        /* Judul besar FAQ pakai primary */
        .faq-title-main {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }
        .faq-title-sub {
            font-size: 2.2rem;
            font-weight: 600;
            margin-left: .2rem;
            color: var(--secondary);
        }

        .faq-search-input {
            border-radius: 999px;
            padding-left: 2.75rem;
            border: 1px solid #e1e1e1;
            height: 46px;
            font-size: .95rem;
        }
        .faq-search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.1rem var(--rgba-primary-2);
        }
        .faq-search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary);
            opacity: .5;
            font-size: 1rem;
        }

        .faq-help-box {
            background: var(--rgba-primary-1);
            border-radius: 12px;
            padding: 1.75rem 1.5rem;
            /* height: 100%; */
        }
        .faq-help-title {
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: .2rem;
            color: var(--primary);
        }
        .faq-help-subtitle {
            font-size: .9rem;
            color: var(--secondary);
            opacity: .7;
            margin-bottom: 1rem;
        }
        .faq-help-contact {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-top: 1.25rem;
        }
        .faq-help-icon {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.4rem;
        }

        .accordion-button:not(.collapsed) {
            color: var(--primary);
            background-color: var(--rgba-primary-1);
            box-shadow: none;
        }
        .accordion-item {
            border-radius: 0;
            border-left: none;
            border-right: none;
        }
        .accordion-button {
            font-weight: 600;
            font-size: .95rem;
            color: var(--secondary);
        }
        .accordion-button:focus {
            box-shadow: 0 0 0 0.1rem var(--rgba-primary-2);
        }
        .accordion-body {
            font-size: .9rem;
            color: var(--secondary);
        }
    </style>
@endpush


@section('content')

    <div class="container mt-4 mb-4">

        {{-- Banner FAQ (Swiper multi-banner) --}}
        @if($banners->count())
            <div class="faq-banner-slider mb-5">
                <div class="swiper faqSwiper">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                            <div class="swiper-slide faq-banner-slide">
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}">
                                <div class="faq-banner-overlay">
                                    <div class="faq-banner-title">{{ $banner->title }}</div>
                                    @if($banner->description)
                                        <p class="faq-banner-desc mb-0">
                                            {{ $banner->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        @endif

        {{-- Judul & Search --}}
        <div class="row mb-4">
            <div class="col-lg-4 mb-3 mb-lg-0 d-flex align-items-center">
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-baseline">
                        <span class="faq-title-main">Frequently Asked</span>
                    </div>
                    <span class="faq-title-sub">Questions</span>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="position-relative">
                    <span class="faq-search-icon">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="faq-search" class="form-control faq-search-input"
                        placeholder="What you looking for?">
                </div>
            </div>
        </div>

        {{-- Konten: Help box kiri + Accordion kanan --}}
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="faq-help-box">
                    <div class="faq-help-title">Tidak Menemukan Jawaban?</div>
                    <div class="faq-help-subtitle">Kami siap membantu.</div>

                    <div class="faq-help-contact">
                        <div class="faq-help-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">Hubungi Kami</div>
                            <small class="text-muted">Silakan ajukan pertanyaan melalui kanal layanan kami.</small>
                        </div>
                    </div>

                    <a href="https://wa.me/6281234567890" target="_blank"
                    class="btn btn-primary w-100 mt-3 d-flex align-items-center justify-content-center gap-2">
                        <i class="fab fa-whatsapp"></i>
                        Chat Via WhatsApp
                    </a>
                </div>
            </div>

            <div class="col-lg-8">
                @if($faqs->count())
                    <div class="accordion" id="faqAccordion">
                        @foreach($faqs as $index => $faq)
                            @php
                                $collapseId = 'faqCollapse'.$index;
                                $headingId  = 'faqHeading'.$index;
                            @endphp
                            <div class="accordion-item faq-item">
                                <h2 class="accordion-header" id="{{ $headingId }}">
                                    <button class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#{{ $collapseId }}"
                                            aria-expanded="false"
                                            aria-controls="{{ $collapseId }}">
                                        {{ $faq->title }}
                                </button>
                                </h2>
                                <div id="{{ $collapseId }}"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="{{ $headingId }}"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Belum ada data FAQ yang tersedia.</p>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper !== 'undefined') {
                new Swiper('.faqSwiper', {
                    loop: true,
                    pagination: {
                        el: '.faqSwiper .swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.faqSwiper .swiper-button-next',
                        prevEl: '.faqSwiper .swiper-button-prev',
                    },
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                });
            }

            const searchInput = document.getElementById('faq-search');
            const items = document.querySelectorAll('.faq-item');

            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    const term = this.value.toLowerCase();

                    items.forEach(function (item) {
                        const title = item
                            .querySelector('.accordion-button')
                            .innerText.toLowerCase();

                        item.style.display = title.includes(term) ? '' : 'none';
                    });
                });
            }
        });
    </script>
@endpush
