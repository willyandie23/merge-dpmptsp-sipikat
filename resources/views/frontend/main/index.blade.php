@extends('frontend.layouts.app')

@section('title')
    DPMPTSP - Beranda
@endsection

@push('css')
	<style>
		html, body {
			overflow-x: hidden;
		}

		/* ── Banner Overlay ── */
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

		/* ── Video Section ── */
		.video-sections .video-inner {
			height: 280px !important;
			aspect-ratio: 16/9;
			max-width: 100%;
		}
		.video-sections .video-block-two {
			overflow: hidden;
		}

		/* Video Content Title Styling */
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

		/* ── SPACING GLOBAL (super rapat antar section) ── */
		.page-section {
			padding-top: 15px !important;
			padding-bottom: 15px !important;
		}
		.page-section:first-of-type {
			padding-top: 50px !important;
		}
		.page-section + .page-section {
			margin-top: 5px !important;
		}

		/* ── VIDEO SECTION SPACING FIX (atas lebih lega, bawah lebih rapat) ── */
		.video-sections {
			padding-top: 35px !important;   /* jarak ke banner (tidak lagi terlalu tipis) */
			padding-bottom: 8px !important; /* jarak ke Layanan Utama (tidak lagi terlalu besar) */
			margin-top: 0 !important;
		}

		/* ── TITLE SECTION (tidak over ke kiri) ── */
		.page-section .container > div.mb-4,
		.page-section .container > div.mb-5 {
			padding-left: 15px !important;
		}

		/* ── TOMBOL SWIPER ── */
		.swiper-button-prev,
		.swiper-button-next {
			width: 44px !important;
			height: 44px !important;
			background: rgba(255,255,255,0.95) !important;
			box-shadow: 0 3px 12px rgba(0,0,0,0.12) !important;
			border-radius: 50% !important;
			top: 50% !important;
			transform: translateY(-50%) !important;
			z-index: 30 !important;
			color: var(--primary) !important;
			border: 1px solid #eee;
		}
		.layanan-utama-swiper .swiper-button-prev,
		.layanan-perizinan-swiper .swiper-button-prev { left: 12px !important; }
		.layanan-utama-swiper .swiper-button-next,
		.layanan-perizinan-swiper .swiper-button-next { right: 12px !important; }
		.swiper-button-prev:hover,
		.swiper-button-next:hover {
			background: var(--primary) !important;
			color: #fff !important;
			border-color: var(--primary);
		}

		/* ── DYNAMIC OVERLAY FADE ── */
		.layanan-utama-swiper,
		.layanan-perizinan-swiper {
			position: relative;
			overflow: hidden;
		}
		.layanan-utama-swiper::before,
		.layanan-perizinan-swiper::before,
		.layanan-utama-swiper::after,
		.layanan-perizinan-swiper::after {
			content: '';
			position: absolute;
			top: 0;
			bottom: 0;
			width: 90px;
			z-index: 25;
			pointer-events: none;
			opacity: 1;
			transition: opacity .3s ease;
		}
		.layanan-utama-swiper::before,
		.layanan-perizinan-swiper::before {
			left: 0;
			background: linear-gradient(to right, #ffffff 30%, rgba(255,255,255,0.3) 70%, transparent);
		}
		.layanan-utama-swiper::after,
		.layanan-perizinan-swiper::after {
			right: 0;
			background: linear-gradient(to left, #ffffff 30%, rgba(255,255,255,0.3) 70%, transparent);
		}
		.layanan-utama-swiper.overlay-right-only::before,
		.layanan-perizinan-swiper.overlay-right-only::before { opacity: 0; }
		.layanan-utama-swiper.overlay-left-only::after,
		.layanan-perizinan-swiper.overlay-left-only::after { opacity: 0; }

		/* ── Layanan Cards ── */
		.layanan-card { 
			border-radius: 8px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,.08); 
			background: #fff; transition: transform .2s, box-shadow .2s; 
		}
		.layanan-card:hover { transform: translateY(-4px); box-shadow: 0 6px 20px rgba(0,0,0,.13); }
		.layanan-card-header { height: 100px; display: flex; }
		.layanan-card-thumb { width: 40%; flex-shrink: 0; overflow: hidden; background: #d9d9d9; }
		.layanan-card-thumb img { width: 100%; height: 100%; object-fit: cover; display: block; }
		.layanan-card-title { width: 60%; background: var(--primary); display: flex; align-items: center; justify-content: center; padding: 0 12px; }
		.layanan-card-body { min-height: 80px; padding: 14px; }

		.layanan-service-card {
			border: 1px solid #eee; border-radius: 10px; text-decoration: none; color: inherit;
			display: block; transition: transform .2s, box-shadow .2s; background: #fff;
		}
		.layanan-service-card:hover { transform: translateY(-5px); box-shadow: 0 8px 24px rgba(0,0,0,.12) !important; }
		.layanan-service-icon {
			width: 90px; height: 90px; background: var(--primary); border-radius: 10px;
			display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;
		}

		/* ── CARD BERITA & GALERI ── */
		.news-card, .gallery-card {
			border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08);
			transition: all .3s ease; background: #fff; height: 100%; display: block;
			text-decoration: none; color: inherit;
		}
		.news-card:hover, .gallery-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important; }
		.gallery-card .card-img-top { filter: brightness(0.9); }
		.gallery-card:hover .card-img-top { filter: brightness(1); }

		.komoditas-section .section-title {
			font-size: 32px;
			font-weight: 700;
			color: var(--primary);
			text-align: center;
			margin-bottom: 8px;
		}
		.komoditas-section .section-subtitle {
			font-size: 18px;
			font-weight: 600;
			text-align: center;
			margin-bottom: 40px;
			color: #555;
		}
		.komoditas-card {
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 4px 20px rgba(0,0,0,0.08);
			transition: all .3s ease;
			height: 100%;
			display: flex;
			flex-direction: column;
			background: #fff;
		}
		.komoditas-card:hover {
			transform: translateY(-6px);
			box-shadow: 0 15px 30px rgba(0,0,0,0.15);
		}
		.komoditas-card-inner {
			display: flex;
			flex: 1;
		}
		.komoditas-card .left-box {
			width: 35%;
			background: #e9e9e9;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 12px;
		}
		.komoditas-card .left-box img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			border-radius: 8px;
			/* TIDAK ADA OUTLINE / BORDER */
		}
		.komoditas-card .right-box {
			width: 65%;
			background: var(--primary);           /* ← diganti ke primary */
			color: #fff;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px 15px;
			font-size: 22px;
			font-weight: 700;
			text-align: center;
			line-height: 1.3;
		}
		.komoditas-card-body {
			padding: 22px 20px;
			flex: 1;
			font-size: 14.5px;
			line-height: 1.6;
			color: #555;
		}

		.pagination .page-link {
			border: none;
			color: #666;
			font-weight: 500;
			padding: 10px 16px;
			margin: 0 3px;
			border-radius: 6px;
		}
		.pagination .page-link.active {
			background: var(--primary);
			color: #fff;
			box-shadow: 0 2px 8px rgba(0,123,255,.3);
		}
		.pagination .page-link:hover:not(.active) {
			background: #f8f9fa;
			color: var(--primary);
		}
		.pagination .page-item.disabled .page-link {
			color: #ccc;
		}

				/* ── PELUANG INVESTASI SECTION (Style ArchCode) ── */
		.peluang-section .filter-bar {
			background: #fff;
			border-radius: 8px;
			box-shadow: 0 4px 15px rgba(0,0,0,0.08);
			padding: 14px 20px;
		}
		.stat-card {
			border-radius: 10px;
			background: #fff;
			box-shadow: 0 4px 15px rgba(0,0,0,0.06);
			transition: transform .2s;
		}
		.stat-card:hover { transform: translateY(-3px); }
		.peluang-card {
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 4px 20px rgba(0,0,0,0.08);
			transition: all .3s ease;
			height: 100%;
			display: flex;
			flex-direction: column;
			background: #fff;
		}
		.peluang-card:hover {
			transform: translateY(-6px);
			box-shadow: 0 15px 30px rgba(0,0,0,0.15);
		}
		.peluang-card .left-box {
			width: 35%;
			background: #e9e9e9;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 12px;
		}
		.peluang-card .left-box img {
			width: 100%;
			height: 100%;
			object-fit: cover;
			border-radius: 8px;
		}
		.peluang-card .right-box {
			width: 65%;
			background: var(--primary);
			color: #fff;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px 15px;
			font-size: 22px;
			font-weight: 700;
			text-align: center;
			line-height: 1.3;
		}
		.peluang-card-body {
			padding: 22px 20px;
			flex: 1;
			font-size: 14.5px;
			line-height: 1.6;
			color: #555;
		}

		.silder-one {
			width: 100% !important;
			max-width: 100% !important;
		}
		.dz-slide-item {
			width: 100vw !important;           /* pakai viewport width */
			min-height: 650px !important;      /* tinggi minimal */
			background-size: cover !important;
			background-position: center center !important;
			background-repeat: no-repeat !important;
		}
		.banner-overlay {
			position: relative;
			height: 100% !important;
		}

		/* Detail Card Clickable */
		.detail-card {
			cursor: pointer;
			transition: all .3s ease;
		}
		.detail-card:hover {
			transform: translateY(-6px);
			box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
		}

		/* Responsive */
		@media (max-width: 991px) {
			.video-sections .video-inner { height: 240px !important; }
			.video-content .title { font-size: 28px !important; }
		}
		@media (max-width: 768px) {
			.video-sections .video-inner { height: 220px !important; }
			.video-content .title { font-size: 24px !important; }
		}
	</style>
@endpush

@section('content')
	<div class="page-content bg-white mb-4">
		<!-- Slider -->
		<div class="silder-one">
			<div class="swiper-container main-silder-swiper">
				<div class="swiper-wrapper">
					@forelse($banners as $banner)
						<div class="swiper-slide">
							<div class="dz-slide-item banner-overlay" style="background-image:url({{ asset('storage/' . $banner->image) }});">
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

		<!-- Video Section -->
		<section class="page-section video-sections mb-3">
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
					
					<!-- Video Column -->
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

		<!-- Layanan Utama -->
		<section class="page-section layanan-section">
			<div class="container">
				<div class="mb-4">
					<h3 class="fw-bold" style="font-size:22px; border-left: 4px solid var(--primary); padding-left: 12px;">
						Layanan Utama
					</h3>
				</div>

				@if($layananUtama->count())
					<div class="layanan-utama-swiper swiper">
						<div class="swiper-wrapper">
							@foreach($layananUtama as $item)
								<div class="swiper-slide">
									<a href="#" class="layanan-card d-block text-decoration-none text-dark">
										<div class="layanan-card-header">
											<div class="layanan-card-thumb">
												@if($item->image)
													<img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
												@else
													<div style="background:#ddd;height:100%;"></div>
												@endif
											</div>
											<div class="layanan-card-title">
												<span class="text-white fw-semibold text-center" style="font-size:15px;">
													{{ $item->title }}
												</span>
											</div>
										</div>
										<div class="layanan-card-body">
											<div class="text-muted mb-0" style="font-size:13.5px; line-height: 1.6;">
												{!! $item->description !!}
											</div>
										</div>
									</a>
								</div>
							@endforeach
						</div>
						<!-- Navigation -->
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
					</div>
				@else
					<p class="text-muted">Belum ada data Layanan Utama.</p>
				@endif
			</div>
		</section>

		<!-- Layanan Perizinan -->
		<section class="page-section">
			<div class="container">
				<div class="mb-5">
					<h3 class="fw-bold" style="font-size:22px; border-left: 4px solid var(--primary); padding-left: 12px;">
						Layanan Perizinan Usaha
					</h3>
				</div>

				@if($layananPerizinan->count())
					<div class="layanan-perizinan-swiper swiper">
						<div class="swiper-wrapper">
							@foreach($layananPerizinan as $item)
								<div class="swiper-slide">
									<a href="#" class="layanan-service-card text-center p-4 shadow-sm">
										<div class="layanan-service-icon">
											<i class="{{ $item->icon }} text-white" style="font-size:34px;"></i>
										</div>
										<p class="fw-semibold mb-0" style="font-size:14px;">{{ $item->title }}</p>
									</a>
								</div>
							@endforeach
						</div>
						<!-- Navigation -->
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
					</div>
				@else
					<p class="text-muted">Belum ada data Layanan Perizinan.</p>
				@endif
			</div>
		</section>

		<!-- Realisasi Investasi -->
		<section class="page-section">
			<div class="container">
				<div class="mb-5">
					<h3 class="fw-bold" style="font-size:22px; border-left: 4px solid var(--primary); padding-left: 12px;">
						Realisasi Investasi
					</h3>
				</div>

				<!-- Filter Tahun -->
				<div class="d-flex justify-content-end mb-4">
					<select id="yearFilter" class="form-select form-select-sm" style="width: 160px;">
						@foreach($realisasiYears as $y)
							<option value="{{ $y }}" {{ $y == $realisasiYear ? 'selected' : '' }}>
								Tahun {{ $y }}
							</option>
						@endforeach
					</select>
				</div>

				<div class="row g-4">
					<!-- Bar Chart -->
					<div class="col-12">
						<div class="card shadow-sm border-0">
							<div class="card-body p-4">
								<canvas id="barChart" height="110"></canvas>
							</div>
						</div>
					</div>

					<!-- Donut + Tenaga Kerja -->
					<div class="col-lg-7">
						<div class="row g-4">
							<div class="col-md-7">
								<div class="card shadow-sm border-0 h-100">
									<div class="card-body text-center pt-4">
										<h5 class="mb-3">Realisasi Investasi {{ $realisasiYear }}</h5>
										<canvas id="donutChart" width="260" height="260"></canvas>
										<div class="mt-4">
											<h3 class="fw-bold text-primary mb-1">
												Rp {{ number_format($totalRealisasi / 1000000000, 2) }} T
											</h3>
											<small class="text-muted">
												dari target Rp {{ number_format($totalTarget / 1000000000, 2) }} T
											</small>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="card shadow-sm border-0 h-100 d-flex flex-column justify-content-center align-items-center text-center p-4">
									<i class="mdi mdi-account-group" style="font-size: 52px; color: #00aaff;"></i>
									<h5 class="fw-bold mt-3 mb-1">Penyerapan Tenaga Kerja</h5>
									<h3 class="mb-0 text-primary">{{ number_format($totalTenagaKerja) }}</h3>
									<small class="text-muted">orang</small>
								</div>
							</div>
						</div>
					</div>

					<!-- Pie Chart PMA & PMDN -->
					<div class="col-lg-5">
						<div class="card shadow-sm border-0 h-100">
							<div class="card-body pt-4">
								<h5 class="mb-4">Kontribusi PMA & PMDN {{ $realisasiYear }}</h5>
								<canvas id="pieChart" height="220"></canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Berita Terbaru -->
		<section class="page-section">
			<div class="container">
				<div class="mb-5">
					<h3 class="fw-bold" style="font-size:22px; border-left: 4px solid var(--primary); padding-left: 12px;">
						Berita
					</h3>
				</div>

				<div class="row g-4">
					@forelse($latestNews as $news)
						<div class="col-lg-4 col-md-6">
							<a href="{{ route('news.index') }}" class="news-card">
								<div class="position-relative">
									@if($news->image)
										<img src="{{ asset('storage/' . $news->image) }}" class="card-img-top w-100" alt="{{ $news->title }}" style="height: 220px; object-fit: cover;">
									@else
										<div class="bg-light" style="height: 220px;"></div>
									@endif
								</div>
								<div class="p-4">
									<h5 class="fw-semibold mb-2">{{ $news->title }}</h5>
									<p class="text-muted small" style="line-height:1.6;">
										{!! Str::limit($news->description ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 130) !!}
									</p>
								</div>
							</a>
						</div>
					@empty
						<div class="col-12 text-center py-5">
							<p class="text-muted">Belum ada berita terbaru.</p>
						</div>
					@endforelse
				</div>

				<div class="text-center mt-5">
					<a href="{{ route('news.index') }}" class="btn btn-primary px-5 py-3 rounded-pill">
						Lihat Semua Berita <i class="fa fa-arrow-right ms-2"></i>
					</a>
				</div>
			</div>
		</section>

		<!-- Galeri Terbaru -->
		<section class="page-section">
			<div class="container">
				<div class="mb-5">
					<h3 class="fw-bold" style="font-size:22px; border-left: 4px solid var(--primary); padding-left: 12px;">
						Galeri
					</h3>
				</div>

				<div class="row g-4">
					@forelse($latestGallery as $gallery)
						<div class="col-lg-4 col-md-6">
							<a href="{{ route('gallery.index') }}" class="gallery-card">
								<div class="position-relative">
									@if($gallery->image)
										<img src="{{ asset('storage/' . $gallery->image) }}" class="card-img-top w-100" alt="{{ $gallery->title }}" style="height: 220px; object-fit: cover;">
									@else
										<div class="bg-light" style="height: 220px;"></div>
									@endif
								</div>
								<div class="p-4">
									<h5 class="fw-semibold mb-2">{{ $gallery->title }}</h5>
									<p class="text-muted small" style="line-height:1.6;">
										{!! Str::limit($gallery->description ?? 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 130) !!}
									</p>
								</div>
							</a>
						</div>
					@empty
						<div class="col-12 text-center py-5">
							<p class="text-muted">Belum ada galeri terbaru.</p>
						</div>
					@endforelse
				</div>

				<div class="text-center mt-5">
					<a href="{{ route('gallery.index') }}" class="btn btn-primary px-5 py-3 rounded-pill">
						Lihat Semua Galeri <i class="fa fa-arrow-right ms-2"></i>
					</a>
				</div>
			</div>
		</section>

		<!-- Komoditas Unggulan -->
		<section class="page-section komoditas-section">
			<div class="container">
				<h2 class="section-title">Komoditas Unggulan</h2>
				<p class="section-subtitle">SK Bupati Katingan<br><strong>Nomor 53 Tahun 2023</strong></p>

				<div class="row g-4">
					@forelse($komoditasUnggulan as $item)
						<div class="col-lg-6 col-md-6">
							<div class="komoditas-card detail-card text-decoration-none"
								data-title="{{ $item->title }}"
								data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}"
								data-description="{!! addslashes($item->description ?? '') !!}">
								
								<div class="komoditas-card-inner">
									<!-- Left Box (Gray) -->
									<div class="left-box">
										@if($item->image)
											<img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
										@else
											<div style="width:100%; height:160px; background:#ccc; border-radius:8px;"></div>
										@endif
									</div>
									<!-- Right Box (Primary) -->
									<div class="right-box">
										{{ $item->title }}
									</div>
								</div>
								<!-- Description (tetap pendek di card) -->
								<div class="komoditas-card-body">
									{!! Str::limit($item->description, 160) !!}
								</div>
							</div>
						</div>
					@empty
						<div class="col-12 text-center py-5">
							<p class="text-muted">Belum ada data Komoditas Unggulan.</p>
						</div>
					@endforelse
				</div>

				{{-- Pagination Style ArchCode (sama seperti halaman Berita kamu) --}}
				@if($komoditasUnggulan->hasPages())
				<div class="row mt-5">
					<div class="col-12">
						<nav aria-label="Komoditas Pagination">
							<ul class="pagination text-center m-b30">
								<!-- Previous -->
								<li class="page-item {{ $komoditasUnggulan->onFirstPage() ? 'disabled' : '' }}">
									<a class="page-link prev" href="{{ $komoditasUnggulan->previousPageUrl() }}">
										<i class="la la-angle-left"></i>
									</a>
								</li>

								<!-- Page Numbers -->
								@foreach($komoditasUnggulan->getUrlRange(1, $komoditasUnggulan->lastPage()) as $page => $url)
									<li class="page-item">
										<a class="page-link {{ $page == $komoditasUnggulan->currentPage() ? 'active' : '' }}" href="{{ $url }}">
											{{ $page }}
										</a>
									</li>
								@endforeach

								<!-- Next -->
								<li class="page-item {{ !$komoditasUnggulan->hasMorePages() ? 'disabled' : '' }}">
									<a class="page-link next" href="{{ $komoditasUnggulan->nextPageUrl() }}">
										<i class="la la-angle-right"></i>
									</a>
								</li>
							</ul>
						</nav>
					</div>
				</div>
				@endif
			</div>
		</section>

		<!-- Peluang Investasi -->
		<section class="page-section peluang-section">
			<div class="container">

				<!-- Filter Bar -->
				<form method="GET" class="filter-bar mb-5">
					<div class="row align-items-end g-3">
						<!-- Lokasi -->
						<div class="col-lg-3 col-md-6">
							<label class="fw-semibold mb-1">Lokasi</label>
							<select name="kecamatan_id" class="form-select">
								<option value="">Pilih Kecamatan</option>
								@foreach($kecamatans as $kec)
									<option value="{{ $kec->id }}" {{ $kecamatanId == $kec->id ? 'selected' : '' }}>
										{{ $kec->name }}
									</option>
								@endforeach
							</select>
						</div>

						<!-- Sektor -->
						<div class="col-lg-3 col-md-6">
							<label class="fw-semibold mb-1">Sektor</label>
							<select name="sektor_id" class="form-select">
								<option value="">Pilih Sektor</option>
								@foreach($sektors as $s)
									<option value="{{ $s->id }}" {{ $sektorId == $s->id ? 'selected' : '' }}>
										{{ $s->name }}
									</option>
								@endforeach
							</select>
						</div>

						<!-- Tahun -->
						<div class="col-lg-2 col-md-6">
							<label class="fw-semibold mb-1">Tahun</label>
							<select name="year" class="form-select">
								@foreach($peluangYears as $y)
									<option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>{{ $y }}</option>
								@endforeach
							</select>
						</div>

						<!-- Keyword -->
						<div class="col-lg-3 col-md-6">
							<label class="fw-semibold mb-1">Cari Keywords...</label>
							<div class="input-group">
								<input type="text" name="keyword" class="form-control" placeholder="Cari keywords..." value="{{ $keyword }}">
								<button type="submit" class="btn btn-primary px-4">
									<i class="fa fa-search"></i> SEARCH
								</button>
							</div>
						</div>
					</div>
				</form>

				<!-- Statistik 3 Kolom -->
				<div class="row g-4 mb-5">
					<!-- Populasi -->
					<div class="col-lg-4 col-md-4">
						<div class="stat-card p-4 text-center">
							<i class="mdi mdi-account-group" style="font-size: 48px; color: #00aaff;"></i>
							<h4 class="mt-3 mb-1">{{ number_format($totalPopulasi) }} Ribu</h4>
							<p class="text-muted mb-0">Populasi {{ $selectedYear }}</p>
						</div>
					</div>
					<!-- PDRB -->
					<div class="col-lg-4 col-md-4">
						<div class="stat-card p-4 text-center">
							<i class="mdi mdi-chart-bar" style="font-size: 48px; color: #00aaff;"></i>
							<h4 class="mt-3 mb-1">Rp {{ number_format($totalPDRB / 1000000000, 3) }} Miliar</h4>
							<p class="text-muted mb-0">Produk Domestik Regional Bruto {{ $selectedYear }}</p>
						</div>
					</div>
					<!-- Pertumbuhan Ekonomi -->
					<div class="col-lg-4 col-md-4">
						<div class="stat-card p-4 text-center">
							<i class="mdi mdi-trending-up" style="font-size: 48px; color: #00cc88;"></i>
							<h4 class="mt-3 mb-1">{{ number_format($pertumbuhanEkonomi, 2) }}%</h4>
							<p class="text-muted mb-0">Pertumbuhan Ekonomi {{ $selectedYear }}</p>
						</div>
					</div>
				</div>

				<!-- Title -->
				<h2 class="text-center text-primary fw-bold mb-4" style="font-size: 32px;">Peluang Investasi</h2>

				<!-- Cards -->
				<div class="row g-4">
					@forelse($peluangInvestasi as $item)
						<div class="col-lg-4 col-md-6">
							<div class="peluang-card detail-card text-decoration-none"
								data-title="{{ $item->title }}"
								data-image="{{ $item->image ? asset('storage/' . $item->image) : '' }}"
								data-description="{!! addslashes($item->description ?? '') !!}">
								
								<div class="peluang-card-inner d-flex">
									<!-- Left Box (Gray) -->
									<div class="left-box">
										@if($item->image)
											<img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
										@else
											<div style="width:100%; height:160px; background:#ccc; border-radius:8px;"></div>
										@endif
									</div>
									<!-- Right Box (Primary) -->
									<div class="right-box">
										{{ $item->title }}
									</div>
								</div>
								<!-- Description (tetap pendek di card) -->
								<div class="peluang-card-body">
									{!! Str::limit($item->description, 160) !!}
								</div>
							</div>
						</div>
					@empty
						<div class="col-12 text-center py-5">
							<p class="text-muted">Belum ada data Peluang Investasi yang sesuai filter.</p>
						</div>
					@endforelse
				</div>

			</div>
		</section>

		<!-- Detail Modal - Komoditas Unggulan & Peluang Investasi -->
		<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
			<div class="modal-dialog modal-xl modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header border-0 pb-0">
						<h4 class="modal-title fw-bold text-primary" id="modalTitle"></h4>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body px-4 pb-4">
						<!-- Gambar -->
						<div id="modalImageContainer" class="mb-4 text-center rounded-3 overflow-hidden"></div>
						
						<!-- Deskripsi Lengkap -->
						<div id="modalDescription" style="line-height: 1.75; font-size: 15.5px; color: #444;"></div>
					</div>
					<div class="modal-footer border-0 pt-0">
						<button type="button" class="btn btn-secondary px-5" data-bs-dismiss="modal">Tutup</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Main Banner Swiper
            if (typeof Swiper !== 'undefined') {
                new Swiper('.main-silder-swiper', {
                    loop: true,
                    pagination: { el: '.swiper-pagination', clickable: true },
                    autoplay: { delay: 5000 }
                });

                // Layanan Utama Swiper + Dynamic Overlay
                const layananUtamaSwiper = new Swiper('.layanan-utama-swiper', {
                    slidesPerView: 'auto',
                    spaceBetween: 20,
                    navigation: {
                        nextEl: '.layanan-utama-swiper .swiper-button-next',
                        prevEl: '.layanan-utama-swiper .swiper-button-prev'
                    },
                    breakpoints: {
                        320: { slidesPerView: 1.2 },
                        576: { slidesPerView: 2.2 },
                        768: { slidesPerView: 3 },
                        992: { slidesPerView: 4 }
                    }
                });
                // Dynamic Overlay Layanan Utama
                const updateUtamaOverlay = () => {
                    const container = document.querySelector('.layanan-utama-swiper');
                    if (!container) return;
                    container.classList.remove('overlay-left-only', 'overlay-right-only');
                    if (layananUtamaSwiper.isBeginning) container.classList.add('overlay-right-only');
                    else if (layananUtamaSwiper.isEnd) container.classList.add('overlay-left-only');
                };
                layananUtamaSwiper.on('slideChange', updateUtamaOverlay);
                layananUtamaSwiper.on('reachBeginning', updateUtamaOverlay);
                layananUtamaSwiper.on('reachEnd', updateUtamaOverlay);
                updateUtamaOverlay(); // initial

                // Layanan Perizinan Swiper + Dynamic Overlay
                const layananPerizinanSwiper = new Swiper('.layanan-perizinan-swiper', {
                    slidesPerView: 'auto',
                    spaceBetween: 20,
                    navigation: {
                        nextEl: '.layanan-perizinan-swiper .swiper-button-next',
                        prevEl: '.layanan-perizinan-swiper .swiper-button-prev'
                    },
                    breakpoints: {
                        320: { slidesPerView: 2.2 },
                        576: { slidesPerView: 3.2 },
                        768: { slidesPerView: 4 },
                        992: { slidesPerView: 5 }
                    }
                });
                // Dynamic Overlay Layanan Perizinan
                const updatePerizinanOverlay = () => {
                    const container = document.querySelector('.layanan-perizinan-swiper');
                    if (!container) return;
                    container.classList.remove('overlay-left-only', 'overlay-right-only');
                    if (layananPerizinanSwiper.isBeginning) container.classList.add('overlay-right-only');
                    else if (layananPerizinanSwiper.isEnd) container.classList.add('overlay-left-only');
                };
                layananPerizinanSwiper.on('slideChange', updatePerizinanOverlay);
                layananPerizinanSwiper.on('reachBeginning', updatePerizinanOverlay);
                layananPerizinanSwiper.on('reachEnd', updatePerizinanOverlay);
                updatePerizinanOverlay(); // initial
            }

            // CHART.JS
            if (typeof Chart !== 'undefined') {

                // Bar Chart Realisasi per Tahun
                const barCtx = document.getElementById('barChart');
                if (barCtx) {
                    new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($realisasiPerTahun->pluck('year')),
                            datasets: [{
                                label: 'Realisasi Investasi',
                                data: @json($realisasiPerTahun->pluck('total')),
                                backgroundColor: '#00aaff',
                                borderColor: '#00aaff',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { callback: v => 'Rp ' + (v / 1000000000) + ' T' }
                                }
                            }
                        }
                    });
                }

                // Donut Chart Jan-Sep
                const donutCtx = document.getElementById('donutChart');
                if (donutCtx) {
                    new Chart(donutCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Realisasi', 'Sisa Target'],
                            datasets: [{
                                data: [{{ $totalRealisasi }}, {{ max($totalTarget - $totalRealisasi, 0) }}],
                                backgroundColor: ['#00aaff', '#e0e0e0'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            cutout: '78%',
                            plugins: { legend: { display: false } }
                        }
                    });
                }

                // Pie Chart PMA & PMDN
                const pieCtx = document.getElementById('pieChart');
                if (pieCtx) {
                    new Chart(pieCtx, {
                        type: 'pie',
                        data: {
                            labels: ['PMA', 'PMDN'],
                            datasets: [{
                                data: [{{ $pma }}, {{ $pmdn }}],
                                backgroundColor: ['#00aaff', '#00cc88'],
                                borderWidth: 0
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: { legend: { position: 'bottom' } }
                        }
                    });
                }
            }

            // Filter Tahun
            const yearFilter = document.getElementById('yearFilter');
            if (yearFilter) {
                yearFilter.addEventListener('change', function () {
                    window.location.href = '?year=' + this.value;
                });
            }

			const detailCards = document.querySelectorAll('.detail-card');
			const modalElement = document.getElementById('detailModal');
			
			if (!modalElement) return;

			const bsModal = new bootstrap.Modal(modalElement);
			const modalTitle = document.getElementById('modalTitle');
			const modalImageContainer = document.getElementById('modalImageContainer');
			const modalDescription = document.getElementById('modalDescription');

			detailCards.forEach(card => {
				card.addEventListener('click', function () {
					const title = this.getAttribute('data-title');
					const imageUrl = this.getAttribute('data-image');
					let description = this.getAttribute('data-description');

					// Isi judul
					modalTitle.textContent = title;

					// Isi gambar
					if (imageUrl) {
						modalImageContainer.innerHTML = `
							<img src="${imageUrl}" 
								class="img-fluid w-100 rounded-3 shadow-sm" 
								style="max-height: 480px; max-width: 480px; object-fit: contain;" 
								alt="${title}">
						`;
					} else {
						modalImageContainer.innerHTML = `
							<div class="bg-light p-5 text-center rounded-3">
								<p class="mb-0 text-muted">Tidak ada gambar tersedia</p>
							</div>
						`;
					}

					// Isi deskripsi lengkap
					modalDescription.innerHTML = description || '<p class="text-muted">Tidak ada deskripsi tersedia.</p>';

					// Tampilkan modal
					bsModal.show();
				});
			});
        });
    </script>
@endpush