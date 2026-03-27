@extends('frontend.layouts.app')

@push('css')
	<style>
		html, body {
			overflow-x: hidden;
		}

		/* Banner Overlay */
		.banner-overlay {
			position: relative;
		}
		.banner-overlay::before {
			content: '';
			position: absolute;
			inset: 0;
			background: linear-gradient(135deg, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 50%, transparent 100%);
			z-index: 1;
		}
		.banner-overlay .silder-content {
			position: relative;
			z-index: 2;
		}

		.video-section {
			margin-bottom: 0 !important;
		}
		/* Video Section - FIXED No Overflow */
		.video-section .video-inner {
			height: 280px !important;
			aspect-ratio: 16/9;
			max-width: 100%;
		}
		.video-section .video-block-two {
			overflow: hidden;
		}
		
		/* Title Styling */
		.video-content .top-shape {
			font-size: 14px;
			font-weight: 600;
			letter-spacing: 1px;
			text-transform: uppercase;
			position: relative;
			display: block;
		}
		.video-content .top-shape::after {
			content: '';
			position: absolute;
			bottom: -8px;
			left: 0;
			width: 30px;
			height: 3px;
			background: #007bff;
		}
		.video-content .title {
			font-size: 36px;
			font-weight: 700;
			line-height: 1.2;
			margin-bottom: 20px !important;
		}

		/* Spacing */
		.silder-one + .page-section {
			margin-top: 60px;
		}
		.video-section .col-lg-7 .video-block-two {
			max-width: 480px;
			margin: 0 auto;
		}

		.video-section .video-inner iframe {
			width: 100% !important;
			max-width: 100% !important;
		}

		/* ── Layanan Utama Cards ── */
		.layanan-section {
			margin-top: 0 !important;
		}
		.layanan-card {
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 2px 12px rgba(0,0,0,.08);
			background: #fff;
			transition: transform .2s, box-shadow .2s;
		}
		.layanan-card:hover {
			transform: translateY(-4px);
			box-shadow: 0 6px 20px rgba(0,0,0,.13);
		}
		.layanan-card-header {
			height: 100px;
			display: flex;
		}
		.layanan-card-thumb {
			width: 40%;
			flex-shrink: 0;
			overflow: hidden;
			background: #d9d9d9;
		}
		.layanan-card-thumb img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			display: block;
		}
		.layanan-card-title {
			width: 60%;
			background: var(--primary);
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 0 12px;
		}
		.layanan-card-body {
			min-height: 80px;
			padding: 14px;
		}

		/* ── Layanan Perizinan Cards ── */
		.layanan-service-card {
			border: 1px solid #eee;
			border-radius: 10px;
			text-decoration: none;
			color: inherit;
			display: block;
			transition: transform .2s, box-shadow .2s;
			background: #fff;
		}
		.layanan-service-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 8px 24px rgba(0,0,0,.12) !important;
			color: inherit;
			text-decoration: none;
		}
		.layanan-service-icon {
			width: 90px;
			height: 90px;
			background: var(--primary);
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 14px;
			transition: background .2s;
		}
		.layanan-service-card:hover .layanan-service-icon {
			background: var(--primary-hover, var(--primary));
			filter: brightness(1.1);
		}

		/* Responsive */
		@media (max-width: 991px) {
			.video-section .video-inner { height: 240px !important; }
			.video-content .title { font-size: 28px !important; }
		}
		@media (max-width: 768px) {
			.video-section .video-inner { height: 220px !important; }
			.silder-one + .page-section { margin-top: 40px; }
			.video-content .title { font-size: 24px !important; }
		}
	</style>
@endpush

@section('content')
	<div class="page-content bg-white">
		<!-- Slider -->
		<div class="silder-one">
			<div class="swiper-container main-silder-swiper">
				<div class="swiper-wrapper">
					@forelse($banners as $banner)
						<div class="swiper-slide">
							<div class="dz-slide-item banner-overlay" style="background-image:url({{ asset($banner->image) }});">
								<div class="silder-content" data-swiper-parallax="-40%">
									<div class="inner-content">
										<h1 class="title text-primary">{!! $banner->title !!}</h1>
										<p class="text-light">{!! $banner->description !!}</p>
									</div>
								</div>
							</div>
						</div>
					@empty
						<div class="swiper-slide">
							<div class="dz-slide-item" style="background-image:url({{ asset('frontend/images/main-slider/slider-bg1.png') }});">
								<div class="silder-content" data-swiper-parallax="-40%">
									<div class="inner-content">
										<h1 class="title">Design Your <span class="text-primary">Dream House</span> With Us</h1>
										<p class="m-b30">Welcome to our website</p>
									</div>
								</div>
							</div>
						</div>
					@endforelse
				</div>
				<div class="slider-one-pagination">
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</div>

		<!-- Video Section FIXED - Title Beside Video -->
		<section class="page-section pt-150 pb-40 video-section">
			<div class="container">
				<div class="row align-items-center">
					<!-- Title Column -->
					<div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
						<div class="video-content">
							<span class="top-shape text-primary mb-3">Video Profil</span>
							<h2 class="title mb-3">Profil Investasi <br><span class="text-primary">Kabupaten Katingan</span></h2>
							<p class="text-muted mb-4">Jelajahi peluang investasi menarik dan infrastruktur unggulan di Kabupaten Katingan melalui video profil resmi ini.</p>
							<a href="https://www.youtube.com/watch?v=88TCC3krtKg" class="btn btn-primary" target="_blank">
								<i class="fa fa-play me-2"></i>Lihat di YouTube
							</a>
						</div>
					</div>
					
					<!-- Video Column FIXED -->
					<div class="col-lg-7 col-md-6">
						<div class="video-block style-2 video-block-two">
							<div class="video-inner position-relative rounded shadow-lg overflow-hidden">
								<iframe 
									class="w-100 h-100 position-absolute top-0 start-0"
									style="height: 300px; width: 100%; z-index: 1;"
									src="https://www.youtube.com/embed/88TCC3krtKg?rel=0&modestbranding=1"
									title="Profil Investasi Kabupaten Katingan"
									frameborder="0" 
									allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
									allowfullscreen>
								</iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		{{-- LAYANAN UTAMA SECTION --}}
		<section class="page-section pt-60 pb-60 layanan-section">
			<div class="container">

				{{-- Heading Layanan Utama --}}
				<div class="mb-4">
					<h3 class="fw-bold" style="font-size:22px; border-left: 4px solid var(--primary); padding-left: 12px;">
						Layanan Utama
					</h3>
				</div>

				<div class="row g-4">

					{{-- Card 1: Mal Pelayanan Publik --}}
					<div class="col-lg-4 col-md-6">
						<a href="#" class="layanan-card d-block text-decoration-none text-dark">
							<div class="layanan-card-header">
								<div class="layanan-card-thumb">
									<img src="{{ asset('frontend/images/layanan/mal-pelayanan.jpg') }}"
										alt="Mal Pelayanan Publik">
								</div>
								<div class="layanan-card-title">
									<span class="text-white fw-semibold text-center" style="font-size:15px;">
										Mal Pelayanan Publik
									</span>
								</div>
							</div>
							<div class="layanan-card-body">
								<p class="text-muted mb-0" style="font-size:13.5px;">
									Layanan perizinan terpadu. Ajukan izin usaha, cek status, dan dapatkan informasi persyaratan dalam satu platform.
								</p>
							</div>
						</a>
					</div>

					{{-- Card 2: Komoditas Unggulan --}}
					<div class="col-lg-4 col-md-6">
						<a href="#" class="layanan-card d-block text-decoration-none text-dark">
							<div class="layanan-card-header">
								<div class="layanan-card-thumb">
									<img src="{{ asset('frontend/images/layanan/komoditas.jpg') }}"
										alt="Komoditas Unggulan">
								</div>
								<div class="layanan-card-title">
									<span class="text-white fw-semibold text-center" style="font-size:15px;">
										Komoditas Unggulan
									</span>
								</div>
							</div>
							<div class="layanan-card-body">
								<p class="text-muted mb-0" style="font-size:13.5px;">
									Kenali komoditas utama Katingan—dari pertanian, perkebunan, hingga hasil hutan. Data lengkap untuk pelaku usaha dan investor.
								</p>
							</div>
						</a>
					</div>

					{{-- Card 3: Potensi Investasi --}}
					<div class="col-lg-4 col-md-6">
						<a href="#" class="layanan-card d-block text-decoration-none text-dark">
							<div class="layanan-card-header">
								<div class="layanan-card-thumb">
									<img src="{{ asset('frontend/images/layanan/investasi.jpg') }}"
										alt="Potensi Investasi">
								</div>
								<div class="layanan-card-title">
									<span class="text-white fw-semibold text-center" style="font-size:15px;">
										Potensi Investasi
									</span>
								</div>
							</div>
							<div class="layanan-card-body">
								<p class="text-muted mb-0" style="font-size:13.5px;">
									Peluang investasi yang siap ditawarkan. Profil proyek, data teknis, dan prospek pengembangan daerah.
								</p>
							</div>
						</a>
					</div>

				</div>


				{{-- LAYANAN PERIZINAN USAHA --}}
				<div class="mt-5 mb-4">
					<h3 class="fw-bold" style="font-size:22px; border-left: 4px solid var(--primary); padding-left: 12px;">
						Layanan Perizinan Usaha
					</h3>
				</div>

				<div class="row g-4">

					{{-- Card: Perizinan Online --}}
					<div class="col-lg-4 col-md-4 col-6">
						<a href="#" class="layanan-service-card text-center p-4 shadow-sm">
							<div class="layanan-service-icon">
								{{-- Dokumen / formulir online --}}
								<i class="fa fa-book text-white" style="font-size:34px;"></i>
							</div>
							<p class="fw-semibold mb-0" style="font-size:14px;">Perizinan Online</p>
						</a>
					</div>

					{{-- Card: Pengaduan --}}
					<div class="col-lg-4 col-md-4 col-6">
						<a href="#" class="layanan-service-card text-center p-4 shadow-sm">
							<div class="layanan-service-icon">
								{{-- Lonceng / laporan --}}
								<i class="fa fa-bell text-white" style="font-size:34px;"></i>
							</div>
							<p class="fw-semibold mb-0" style="font-size:14px;">Pengaduan</p>
						</a>
					</div>

					{{-- Card: Chat --}}
					<div class="col-lg-4 col-md-4 col-6">
						<a href="#" class="layanan-service-card text-center p-4 shadow-sm">
							<div class="layanan-service-icon">
								{{-- Gelembung chat --}}
								<i class="fa fa-comments text-white" style="font-size:34px;"></i>
							</div>
							<p class="fw-semibold mb-0" style="font-size:14px;">Chat</p>
						</a>
					</div>

				</div>

			</div>
		</section>

	</div>
@endsection

@push('scripts')
@endpush
