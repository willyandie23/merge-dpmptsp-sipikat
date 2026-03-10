@extends('frontend.layouts.app')

@push('css')
    
@endpush

@section('content')
    <div class="content-inner">
        <div class="container">
            <div class="row" id="masonry">
                <div class="col-xl-6 col-lg-6 card-container">
                    <div class="dz-card blog-grid style-1 m-b50 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="dz-media">
                            <a href="blog-details.html"><img src="images/blog/large/pic1.jpg" alt=""></a>
                        </div>
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">25 Feb 2024</li>
                                    <li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
                                </ul>
                            </div>
                            <h3 class="dz-title"><a href="blog-details.html">Why You Cannot Learn Construction Well</a></h3>
                            <div class="dz-post-text text">
                                <p>Sed non sapien urna. Cras quis porta risus, vitae pulvinar nibh. In hac habitasse platea dictumst. Integer congue et enim cursus porttitor. Vestibulum mattis placerat magna, sit amet laoreet sapien.</p>
                            </div>
                            <a href="blog-details.html" class="btn-link">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 card-container">	
                    <div class="dz-card blog-grid style-1 m-b50 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="dz-media">
                            <div class="swiper-container post-swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <a href="blog-details.html"><img src="images/blog/large/pic2.jpg" alt=""></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="blog-details.html"><img src="images/blog/large/pic1.jpg" alt=""></a>
                                    </div>
                                    <div class="swiper-slide">
                                        <a href="blog-details.html"><img src="images/blog/large/pic3.jpg" alt=""></a>
                                    </div>
                                </div>
                                <div class="prev-post-swiper-btn"><i class="la fa-angle-left"></i></div>
                                <div class="next-post-swiper-btn"><i class="la fa-angle-right"></i></div>
                            </div>
                        </div>
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">24 March 2024</li>
                                    <li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
                                </ul>
                            </div>
                            <h3 class="dz-title"><a href="blog-details.html">Reasons Why You Shouldn’t Rely On Construction Anymore..</a></h3>
                            <div class="dz-post-text text">
                                <p>Sed non sapien urna. Cras quis porta risus, vitae pulvinar nibh. In hac habitasse platea dictumst. Integer congue et enim cursus porttitor. Vestibulum mattis placerat magna, sit amet laoreet sapien.</p>
                            </div>
                            <a href="blog-details.html" class="btn-link">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 card-container">		
                    <div class="dz-card blog-grid style-1 m-b50 post-video aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="dz-media">
                            <a href="blog-details.html">
                                <img src="images/blog/large/pic3.jpg" alt="">
                                <div class="post-video-icon"><i class="fas fa-play"></i></div>
                            </a>
                        </div>
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">04 April 2024</li>
                                    <li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
                                </ul>
                            </div>
                            <h3 class="dz-title"><a href="blog-details.html">Construction Any Good? 5 Ways You Can Be Certain.</a></h3>
                            <div class="dz-post-text text">
                                <p>Sed non sapien urna. Cras quis porta risus, vitae pulvinar nibh. In hac habitasse platea dictumst. Integer congue et enim cursus porttitor. Vestibulum mattis placerat magna, sit amet laoreet sapien.</p>
                            </div>
                            <a href="blog-details.html" class="btn-link">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 card-container">		
                    <div class="dz-card blog-grid style-1 m-b50 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">2 May 2024</li>
                                    <li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
                                </ul>
                            </div>
                            <h3 class="dz-title"><a href="blog-details.html">“ Doubts About Construction You Should Clarify. ” </a></h3>
                            <div class="dz-post-text text">
                                <p>Sed non sapien urna. Cras quis porta risus, vitae pulvinar nibh. In hac habitasse platea dictumst. Integer congue et enim cursus porttitor. Vestibulum mattis placerat magna, sit amet laoreet sapien.</p>
                            </div>
                            <a href="blog-details.html" class="btn-link">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 card-container">
                    <div class="dz-card blog-grid style-1 m-b50 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="dz-media">
                            <a href="blog-details.html"><img src="images/blog/large/pic2.jpg" alt=""></a>
                        </div>
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">4 June 2024</li>
                                    <li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
                                </ul>
                            </div>
                            <h3 class="dz-title"><a href="blog-details.html">Why You Cannot Learn Construction Well.</a></h3>
                            <div class="dz-post-text text">
                                <p>Sed non sapien urna. Cras quis porta risus, vitae pulvinar nibh. In hac habitasse platea dictumst. Integer congue et enim cursus porttitor. Vestibulum mattis placerat magna, sit amet laoreet sapien.</p>
                            </div>
                            <a href="blog-details.html" class="btn-link">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 card-container">		
                    <div class="dz-card blog-grid style-1 m-b50 aos-item" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                        <div class="dz-info">
                            <div class="dz-meta">
                                <ul>
                                    <li class="post-date">7 March 2024</li>
                                    <li class="post-user">By <a href="javascript:void(0);">John Doe</a></li>
                                </ul>
                            </div>
                            <h3 class="dz-title"><a href="blog-details.html">“ Ten Things You Didn’t Know About Construction.” </a></h3>
                            <div class="dz-post-text text">
                                <p>Sed non sapien urna. Cras quis porta risus, vitae pulvinar nibh. In hac habitasse platea dictumst. Integer congue et enim cursus porttitor. Vestibulum mattis placerat magna, sit amet laoreet sapien.</p>
                            </div>
                            <a href="blog-details.html" class="btn-link">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">		
                <div class="col-xl-12 col-lg-12">		
                    <nav aria-label="Blog Pagination">
                        <ul class="pagination text-center m-b30">
                            <li class="page-item"><a class="page-link prev" href="javascript:void(0);"><i class="la la-angle-left"></i></a></li>
                            <li class="page-item"><a class="page-link active" href="javascript:void(0);">1</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                            <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                            <li class="page-item"><a class="page-link next" href="javascript:void(0);"><i class="la la-angle-right"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    
@endpush