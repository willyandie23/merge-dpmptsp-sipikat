@extends('frontend.layouts.app')

@push('css')
    <style>
        html, body {
            overflow-x: hidden;
        }
    </style>
@endpush

@section('content')
    <div class="page-content bg-white">
		<!-- Slider -->
		<div class="silder-one">
			<div class="swiper-container main-silder-swiper">
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="dz-slide-item" style="background-image:url({{ asset('frontend/images/main-slider/slider-bg1.png') }});">
							<div class="silder-content" data-swiper-parallax="-40%">
								<div class="inner-content">
									<h6 class="sub-title">We Are Best Architecture Of This Year</h6>
									<h1 class="title">Design Your <span class="text-primary">Dream House</span> With Us</h1>
									<p class="m-b30">Duis feugiat est tincidunt ligula maximus convallis. Aenean ultricies, mi non vestibulum auctor, erat tortor porttitor ipsum, nec dictum tortor sem eget nunc. Etiam sed facilisis erat. </p>
									<a href="about-us.html" class="btn shadow-primary btn-primary">Browse Project</a>
								</div>
							</div>
							<div class="slider-img" data-swiper-parallax-y="-40%" data-swiper-parallax-x="20%" data-swiper-parallax-opacity="0">
								<img src="images/main-slider/pic1.jpg" alt=""/> 
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="dz-slide-item" style="background-image:url(images/main-slider/slider-bg1.png);">
							<div class="silder-content" data-swiper-parallax="-40%">
								<div class="inner-content">
									<h6 class="sub-title">We Create Your Dream Ideas</h6>
									<h1 class="title">Interior   <span class="text-primary">Design</span> For Solutions  </h1>
									<p class="m-b30">Duis feugiat est tincidunt ligula maximus convallis. Aenean ultricies, mi non vestibulum auctor, erat tortor porttitor ipsum, nec dictum tortor sem eget nunc. Etiam sed facilisis erat. </p>
									<a href="about-us.html" class="btn shadow-primary btn-primary">Browse Project</a>
								</div>
							</div>
							<div class="slider-img" data-swiper-parallax-y="-40%" data-swiper-parallax-x="20%" data-swiper-parallax-opacity="0">
								<img src="images/main-slider/pic2.jpg" alt=""/> 
							</div>
						</div>
					</div>
					<div class="swiper-slide">
						<div class="dz-slide-item" style="background-image:url(images/main-slider/slider-bg1.png);">
							<div class="silder-content" data-swiper-parallax="-40%">
								<div class="inner-content">
									<h6 class="sub-title">We Are Best Architecture Of This Year</h6>
									<h1 class="title">Experience <span class="text-primary">Design</span> With Comfort </h1>
									<p class="m-b30">Duis feugiat est tincidunt ligula maximus convallis. Aenean ultricies, mi non vestibulum auctor, erat tortor porttitor ipsum, nec dictum tortor sem eget nunc. Etiam sed facilisis erat. </p>
									<a href="about-us.html" class="btn shadow-primary btn-primary">Browse Project</a>
								</div>
							</div>
							<div class="slider-img" data-swiper-parallax-y="-40%" data-swiper-parallax-x="20%" data-swiper-parallax-opacity="0">
								<img src="images/main-slider/pic3.jpg" alt=""/> 
							</div>
						</div>
					</div>
				</div>
				<div class="slider-one-pagination">
					<!-- Add Navigation -->
					<div class="swiper-pagination"></div>
				</div>
			</div>
		</div>
		
		<!-- Clients Logo -->
		<div class="clients-section-1  pb-0">
			<div class="container">
				<div class="swiper-container clients-swiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="clients-logo aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="100">
								<img class="logo-main" src="images/logo/logo-gray1.png" alt="">
								<img class="logo-hover" src="images/logo/logo-brown1.png" alt="">
							</div>
						</div>	
						<div class="swiper-slide">
							<div class="clients-logo aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="200">
								<img class="logo-main" src="images/logo/logo-gray2.png" alt="">
								<img class="logo-hover" src="images/logo/logo-brown2.png" alt="">
							</div>
						</div>
						<div class="swiper-slide">
							<div class="clients-logo aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="300">
								<img class="logo-main" src="images/logo/logo-gray3.png" alt="">
								<img class="logo-hover" src="images/logo/logo-brown3.png" alt="">
							</div>
						</div>	
						<div class="swiper-slide">
							<div class="clients-logo aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="400">
								<img class="logo-main" src="images/logo/logo-gray4.png" alt="">
								<img class="logo-hover" src="images/logo/logo-brown4.png" alt="">
							</div>
						</div>
						<div class="swiper-slide">
							<div class="clients-logo aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="500">
								<img class="logo-main" src="images/logo/logo-gray5.png" alt="">
								<img class="logo-hover" src="images/logo/logo-brown5.png" alt="">
							</div>
						</div>
						<div class="swiper-slide">
							<div class="clients-logo aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="600">
								<img class="logo-main" src="images/logo/logo-gray6.png" alt="">
								<img class="logo-hover" src="images/logo/logo-brown6.png" alt="">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- About Us -->
		<section class="content-inner-2">
			<div class="container">
				<div class="row align-items-center about-bx1">
					<div class="col-lg-6 m-lg-b30">
						<div class="dz-media">
							<img src="images/about/about1.jpg" alt="" class="aos-item" data-aos="fade-down" data-aos-duration="800" data-aos-delay="400">
							<div class="year-exp aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
								<h2 class="year text-primary">25</h2>
								<h4 class="text">Years Of<br/>Experience</h4>
							</div>
						</div>
					</div>
					<div class="col-lg-6 aos-item" data-aos="fade-in" data-aos-duration="1500" data-aos-delay="800">
						<div class="section-head style-1">
							<h6 class="text-primary sub-title">Welcome To ArchCode</h6>
							<h2 class="title">We Can Create More Than You Expect</h2>
						</div>
						<p>Nullam nec rutrum eros. Maecenas maximus augue eget libero dictum, vitae tempus erat pretium. Fusce fermentum lacus ut nunc dignissim hendrerit. Quisque sit amet dignissim orci, eget laoreet eros. </p>
						<div class="row">
							<div class="col-md-6">
								<div class="about-text-bx">
									<h4>Construction</h4>
									<p>Curabitur vel auctor nibh. Curabitur egestas posuere mi, sed pulvinar ligula.</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="about-text-bx">
									<h4>Architecture</h4>
									<p>Curabitur vel auctor nibh. Curabitur egestas posuere mi, sed pulvinar ligula.</p>
								</div>
							</div>
						</div>
						<a href="about-us.html" class="btn shadow-primary btn-primary">Learn More</a>
					</div>
				</div>
			</div>
		</section>
		<!-- About Us -->
		<!-- Our Features -->
		<section class="content-inner pt-5">
			<div class="container">
				<div class="row">
					<div class="col-lg-3 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
						<div class="icon-bx-wraper style-6 m-b30" data-name="789">
							<h2 class="counter text-primary">789</h2>
							<h4 class="title">Squre Area<br/>Complex</h4>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
						<div class="icon-bx-wraper style-6 m-b30" data-name="158">
							<h2 class="counter text-primary">158</h2>
							<h4 class="title">Happy<br/>Clients</h4>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
						<div class="icon-bx-wraper style-6 m-b30" data-name="874">
							<h2 class="counter text-primary">874</h2>
							<h4 class="title">Completed<br/>Projects</h4>
						</div>
					</div>
					<div class="col-lg-3 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="800">
						<div class="icon-bx-wraper style-6 m-b30" data-name="987">
							<h2 class="counter text-primary">987</h2>
							<h4 class="title">Cup Of<br/>Coffee</h4>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Our Features -->
		<section class="content-inner-2 bg-gray service-area" style="background-image:url(images/background/pattern3.png)">
			<div class="container">
				<div class="row m-b70 m-md-b10">
					<div class="col-lg-4 col-md-12 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
						<div class="section-head style-1">
							<h6 class="text-primary sub-title">Popular Services</h6>
							<h2 class="title">We Provide Best Features To Build Dream</h2>
						</div>
					</div>
					<div class="col-lg-8 col-md-12">
						<div class="row">
							<div class="col-lg-6 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
								<div class="icon-bx-wraper style-2 left m-b50">
									<div class="icon-bx-sm bg-primary icon-bx text-white">
										<i class="flaticon-blueprint-1"></i> 
									</div>
									<div class="icon-content">
										<h4 class="title m-b10">Floor Plan Design</h4>
										<p>Nunc convallis sagittis dui eu dictum. Cras sodales id ipsum ac aliquam.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
								<div class="icon-bx-wraper style-2 left m-b50">
									<div class="icon-bx-sm bg-primary icon-bx text-white">
										<i class="flaticon-furniture"></i> 
									</div>
									<div class="icon-content">
										<h4 class="title m-b10">Furniture Work</h4>
										<p>Nunc convallis sagittis dui eu dictum. Cras sodales id ipsum ac aliquam.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
								<div class="icon-bx-wraper style-2 left m-b50">
									<div class="icon-bx-sm bg-primary icon-bx text-white">
										<i class="flaticon-crane"></i> 
									</div>
									<div class="icon-content">
										<h4 class="title m-b10">Construction Work</h4>
										<p>Nunc convallis sagittis dui eu dictum. Cras sodales id ipsum ac aliquam.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">
								<div class="icon-bx-wraper style-2 left m-b50">
									<div class="icon-bx-sm bg-primary icon-bx text-white">
										<i class="flaticon-home"></i> 
									</div>
									<div class="icon-content">
										<h4 class="title m-b10">Architecture</h4>
										<p>Nunc convallis sagittis dui eu dictum. Cras sodales id ipsum ac aliquam.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1000">
								<div class="icon-bx-wraper style-2 left m-b50">
									<div class="icon-bx-sm bg-primary icon-bx text-white">
										<i class="flaticon-interior-design-1"></i> 
									</div>
									<div class="icon-content">
										<h4 class="title m-b10">Interior Designing</h4>
										<p>Nunc convallis sagittis dui eu dictum. Cras sodales id ipsum ac aliquam.</p>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-sm-6 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="1200">
								<div class="icon-bx-wraper style-2 left m-b50">
									<div class="icon-bx-sm bg-primary icon-bx text-white">
										<i class="flaticon-support"></i> 
									</div>
									<div class="icon-content">
										<h4 class="title m-b10">24X7 Support</h4>
										<p>Nunc convallis sagittis dui eu dictum. Cras sodales id ipsum ac aliquam.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="video-bx content-media style-1">
							<img src="images/pic1.jpg" alt="">
							<div class="video-btn aos-item" data-aos="zoom-in" data-aos-duration="1500" data-aos-delay="200">
								<a href="https://www.youtube.com/watch?v=b95ZyCes95A" class="popup-youtube"><i class="fa fa-play"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Testimonials -->
		<section class="content-inner section-title style-1">
			<div class="container">
				<div class="row ">
					<div class="col-md-12">
						<div class="section-head style-1 text-center">
							<h6 class="text-primary sub-title">Testimonial</h6>
							<h2 class="title">See What Our Clients Says</h2>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12 m-b20">
						<div class="swiper-container testimonial-swiper1">
							<div class="swiper-wrapper">
								<div class="swiper-slide aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
									<div class="testimonial-1">
										<div class="testimonial-pic">
											<img src="images/testimonials/pic1.jpg" alt="">
											<div class="info">
												<h5 class="testimonial-name">John</h5> 
												<span class="testimonial-position text-primary">Designer</span> 
											</div>
										</div>
										<div class="testimonial-info">
											<div class="testimonial-text">
												<p>Suspendisse sem est, eleifend id vulputate sit amet, rhoncus mollis justo. Cras iaculis justo ac dictum vestibulum. Cras id arcu turpis. Nulla ligula velit, condimentum ut orci eget, semper efficitur odio. applale Dgafgad</p>
											</div>
											<div class="testimonial-review">
												<ul class="star-rating text-primary">
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
												</ul>
												<h4 class="review">Awesome</h4>
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
									<div class="testimonial-1">
										<div class="testimonial-pic">
											<img src="images/testimonials/pic2.jpg" alt="">
											<div class="info">
												<h5 class="testimonial-name">Caroline</h5> 
												<span class="testimonial-position text-primary">CEO Founder</span> 
											</div>
										</div>
										<div class="testimonial-info">
											<div class="testimonial-text">
												<p>Suspendisse sem est, eleifend id vulputate sit amet, rhoncus mollis justo. Cras iaculis justo ac dictum vestibulum. Cras id arcu turpis. Nulla ligula velit, condimentum ut orci eget, semper efficitur odio.</p>
											</div>
											<div class="testimonial-review">
												<ul class="star-rating text-primary">
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
												</ul>
												<h4 class="review">Best Qulity</h4>
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
									<div class="testimonial-1">
										<div class="testimonial-pic">
											<img src="images/testimonials/pic3.jpg" alt="">
											<div class="info">
												<h5 class="testimonial-name">Kimberly</h5> 
												<span class="testimonial-position text-primary">Web Developer</span> 
											</div>
										</div>
										<div class="testimonial-info">
											<div class="testimonial-text">
												<p>Suspendisse sem est, eleifend id vulputate sit amet, rhoncus mollis justo. Cras iaculis justo ac dictum vestibulum. Cras id arcu turpis. Nulla ligula velit, condimentum ut orci eget, semper efficitur odio.</p>
											</div>
											<div class="testimonial-review">
												<ul class="star-rating text-primary">
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
												</ul>
												<h4 class="review">Use Fully</h4>
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
									<div class="testimonial-1">
										<div class="testimonial-pic">
											<img src="images/testimonials/pic1.jpg" alt="">
											<div class="info">
												<h5 class="testimonial-name">Ginger Plantq</h5> 
												<span class="testimonial-position text-primary">CEO Founder</span> 
											</div>
										</div>
										<div class="testimonial-info">
											<div class="testimonial-text">
												<p>Suspendisse sem est, eleifend id vulputate sit amet, rhoncus mollis justo. Cras iaculis justo ac dictum vestibulum. Cras id arcu turpis. Nulla ligula velit, condimentum ut orci eget, semper efficitur odio.</p>
											</div>
											<div class="testimonial-review">
												<ul class="star-rating text-primary">
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
												</ul>
												<h4 class="review">Grateful</h4>
											</div>
										</div>
									</div>
								</div>
								<div class="swiper-slide aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
									<div class="testimonial-1">
										<div class="testimonial-pic">
											<img src="images/testimonials/pic2.jpg" alt="">
											<div class="info">
												<h5 class="testimonial-name">Fay Daway</h5> 
												<span class="testimonial-position text-primary">Designer</span> 
											</div>
										</div>
										<div class="testimonial-info">
											<div class="testimonial-text">
												<p>Suspendisse sem est, eleifend id vulputate sit amet, rhoncus mollis justo. Cras iaculis justo ac dictum vestibulum. Cras id arcu turpis. Nulla ligula velit, condimentum ut orci eget, semper efficitur odio.</p>
											</div>
											<div class="testimonial-review">
												<ul class="star-rating text-primary">
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
													<li><i class="fa fa-star"></i></li>
												</ul>
												<h4 class="review">Awesome</h4>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- Add Navigation -->
							<div class="swiper-pagination1 text-center"></div>
						</div>
					</div>
				</div>
			</div>
		</section>		
		<!-- Our Portfolio -->
		<section class="content-inner-2 bg-gray portfolio-area1"  style="background-image:url(images/background/pattern3.png)">
			<div class="container">
				<div class="row align-items-center section-head-bx">
					<div class="col-md-8">
						<div class="section-head style-1">
							<h6 class="text-primary sub-title">Our Portfolio</h6>
							<h2 class="title">See Our Latest Work</h2>
						</div>
					</div>
					<div class="col-md-4 text-end">
						<div class="portfolio-pagination d-inline-block mb-5">
							<div class="btn-prev swiper-button-prev2"><i class="las la-arrow-left"></i></div>
							<div class="btn-next swiper-button-next2"><i class="las la-arrow-right"></i></div>
						</div>
					</div>
				</div>
			</div>
			<div class="container-fluid">
				<div class="swiper-container swiper-portfolio lightgallery aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="400">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="dz-box overlay style-1">
								<div class="dz-media">
									<img src="images/work/pic-1.jpg" alt="">
								</div>
								<div class="dz-info">
									<span data-exthumbimage="images/work/pic-1.jpg" data-src="images/work/pic-1.jpg" class="view-btn lightimg" title="INTERIOR DESIGN"></span>
									<h6 class="sub-title">INTERIOR DESIGN</h6>
									<div class="port-info">
										<div class="dz-meta">
											<ul>
												<li class="post-date">7 March 2024</li>
												<li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
											</ul>
										</div>
										<h2 class="title m-b15"><a href="portfolio-details.html">Modern House Interior <span>New York</span></a></h2>
									</div>
								</div>
							</div>
						</div>	
						<div class="swiper-slide">
							<div class="dz-box overlay style-1">
								<div class="dz-media">
									<img src="images/work/pic-2.jpg" alt="">
								</div>
								<div class="dz-info">
									<span data-exthumbimage="images/work/pic-2.jpg" data-src="images/work/pic-2.jpg" class="view-btn lightimg" title="ARCHITECTURAL"></span>
									<h6 class="sub-title">ARCHITECTURAL</h6>
									<div class="port-info">
										<div class="dz-meta">
											<ul>
												<li class="post-date">23 Feb 2024</li>
												<li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
											</ul>
										</div>
										<h2 class="title m-b15"><a href="portfolio-details.html">Sample Hotel Art, <span>India</span></a></h2>
									</div>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-box overlay style-1">
								<div class="dz-media">
									<img src="images/work/pic-3.jpg" alt="">
								</div>
								<div class="dz-info">
									<span data-exthumbimage="images/work/pic-3.jpg" data-src="images/work/pic-3.jpg" class="view-btn lightimg" title="INTERIOR DESIGN"></span>
									<h6 class="sub-title">CONSTRUCTION</h6>
									<div class="port-info">
										<div class="dz-meta">
											<ul>
												<li class="post-date">24 June 2024</li>
												<li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
											</ul>
										</div>
										<h2 class="title m-b15"><a href="portfolio-details.html">Modern Family House,  <span>Italy</span></a></h2>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</div>	
			</div>	
		</section>
		<!-- Team -->
		<section class="content-inner section-title">
			<div class="container">
				<div class="section-head style-1 text-center">
					<h6 class="text-primary sub-title">Our Team</h6>
					<h2 class="title">Our Creative Expertise</h2>
				</div>
				<div class="row">
					<div class="col-lg-12 m-b30">
						<div class="swiper-container team-swiper">
							<div class="swiper-wrapper">
								<div class="swiper-slide">
									<div class="dz-team style-1 text-center m-b30 overlay-shine aos-item" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200">
										<div class="dz-media">
											<a href="javascript:void(0);"><img src="images/team/pic1.jpg" alt=""></a>
											<ul class="team-social">
												<li><a href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-instagram"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
											</ul>
										</div>
										<div class="dz-content">
											<h5 class="dz-name"><a href="javascript:void(0);">Andrey Carol</a></h5>
											<h6 class="dz-position text-primary">Director</h6>
										</div>
									</div>
								</div>	
								<div class="swiper-slide">
									<div class="dz-team style-1 text-center m-b30 overlay-shine aos-item" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="400">
										<div class="dz-media">
											<a href="javascript:void(0);"><img src="images/team/pic2.jpg" alt=""></a>
											<ul class="team-social">
												<li><a href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-instagram"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
											</ul>
										</div>
										<div class="dz-content">
											<h5 class="dz-name"><a href="javascript:void(0);">Rebecca Ruth</a></h5>
											<h6 class="dz-position text-primary">Director</h6>
										</div>
									</div>
								</div>
								<div class="swiper-slide">
									<div class="dz-team style-1 text-center m-b30 overlay-shine aos-item" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="600">
										<div class="dz-media">
											<a href="javascript:void(0);"><img src="images/team/pic3.jpg" alt=""></a>
											<ul class="team-social">
												<li><a href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-instagram"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
											</ul>
										</div>
										<div class="dz-content">
											<h5 class="dz-name"><a href="javascript:void(0);">Austin Doe</a></h5>
											<h6 class="dz-position text-primary">Director</h6>
										</div>
									</div>
								</div>	
								<div class="swiper-slide">
									<div class="dz-team style-1 text-center m-b30 overlay-shine aos-item" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="800">
										<div class="dz-media">
											<a href="javascript:void(0);"><img src="images/team/pic4.jpg" alt=""></a>
											<ul class="team-social">
												<li><a href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-instagram"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
											</ul>
										</div>
										<div class="dz-content">
											<h5 class="dz-name"><a href="javascript:void(0);">Lala Rose</a></h5>
											<h6 class="dz-position text-primary">Director</h6>
										</div>
									</div>
								</div>
								<div class="swiper-slide">
									<div class="dz-team style-1 text-center m-b30 overlay-shine aos-item" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200">
										<div class="dz-media">
											<a href="javascript:void(0);"><img src="images/team/pic2.jpg" alt=""></a>
											<ul class="team-social">
												<li><a href="javascript:void(0);"><i class="fab fa-facebook-f"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-instagram"></i></a></li>
												<li><a href="javascript:void(0);"><i class="fab fa-twitter"></i></a></li>
											</ul>
										</div>
										<div class="dz-content">
											<h5 class="dz-name"><a href="javascript:void(0);">Andrey Carol</a></h5>
											<h6 class="dz-position text-primary">Director</h6>
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-pagination2 text-center"></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Content Box -->
		<section class="bg-gray" style="background-image:url(images/background/pattern3.png)">
			<div class="">
				<div class="row spno">
					<div class="col-lg-4 aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="200">
						<img src="images/pic2.jpg" class="img-cover" alt=""/>
					</div>
					<div class="col-lg-4 aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="400">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d227748.3825624477!2d75.65046970649679!3d26.88544791796718!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c4adf4c57e281%3A0xce1c63a0cf22e09!2sJaipur%2C+Rajasthan!5e0!3m2!1sen!2sin!4v1500819483219" class="align-self-stretch radius-sm" style="border:0; width:100%; min-height:300px; height:100%" allowfullscreen></iframe>
					</div>
					<div class="col-lg-4 align-self-center aos-item" data-aos="fade-in" data-aos-duration="1000" data-aos-delay="600">
						<div class="newsletter-bx">
							<div class="section-head style-1">
								<h6 class="text-primary sub-title">Newsletter</h6>
								<h2 class="title">Stay Updated With Our Newsletter</h2>
							</div>
							<div class="dzSubscribeMsg"></div>
							<form action="script/mailchamp.php" class="dzSubscribe" method="post">
								<div class="form-group mb-3">
									<input type="text" name="dzName" required class="form-control" placeholder="Your Name">
								</div>
								<div class="form-group m-b30">
									<input type="email" name="dzEmail" required class="form-control" placeholder="Your Email Address">
								</div>
								<div class="form-group">
									<button name="submit" type="submit" value="Submit" class="btn btn-primary">Submit Now</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Blog -->
		<section class="content-inner-1">
			<div class="container">
				<div class="section-head style-1 text-center">
					<h6 class="text-primary sub-title">Our Blog</h6>
					<h2 class="title">Latest News Feed</h2>
				</div> 
				<div class="blog-area">
					<div class="swiper-container blog-swiper">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="dz-card blog-grid style-1 aos-item" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="200">
									<div class="dz-media">
										<a href="blog-details.html"><img src="images/blog/blog-grid/pic1.jpg" alt=""></a>
									</div>
									<div class="dz-info text-center">
										<div class="dz-meta">
											<ul>
												<li class="post-date">14 Feb 2024</li>
											</ul>
										</div>
										<h5 class="dz-title"><a href="blog-details.html">Construction Any Good? 5 Ways You Can Be Certain.</a></h5>
										<div class="dz-post-text text">
											<p>You can align your image to the left, right, or center with a caption, link and alt text New Journey to the.</p>
										</div>
										<a href="blog-details.html" class="btn-link">Read More</a>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-card blog-grid style-1 aos-item" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="500">
									<div class="dz-media">
										<a href="blog-details.html"><img src="images/blog/blog-grid/pic2.jpg" alt=""></a>
									</div>
									<div class="dz-info text-center">
										<div class="dz-meta">
											<ul>
												<li class="post-date">25 March 2024</li>
											</ul>
										</div>
										<h5 class="dz-title"><a href="blog-details.html">Why You Cannot Learn Construction Well.</a></h5>
										<div class="dz-post-text text">
											<p>You can align your image to the left, right, or center with a caption, link and alt text New Journey to the.</p>
										</div>
										<a href="blog-details.html" class="btn-link">Read More</a>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-card blog-grid style-1 aos-item" data-aos="fade-up" data-aos-duration="2000" data-aos-delay="800">
									<div class="dz-media">
										<a href="blog-details.html"><img src="images/blog/blog-grid/pic3.jpg" alt=""></a>
									</div>
									<div class="dz-info text-center">
										<div class="dz-meta">
											<ul>
												<li class="post-date">7 March 2024</li>
											</ul>
										</div>
										<h5 class="dz-title"><a href="blog-details.html">Ten Things You Didn’t Know About Construction.</a></h5>
										<div class="dz-post-text text">
											<p>You can align your image to the left, right, or center with a caption, link and alt text New Journey to the.</p>
										</div>
										<a href="blog-details.html" class="btn-link">Read More</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection

@push('scripts')
@endpush