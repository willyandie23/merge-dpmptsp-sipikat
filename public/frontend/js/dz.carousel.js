/* JavaScript Document */
jQuery(window).on('load', function() {
    'use strict';
	
	// main-silder-swiper
	if(jQuery('.main-silder-swiper').length > 0){
		var swiper = new Swiper('.main-silder-swiper', {
			speed: 1500,
			parallax: true,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
				renderBullet: function (index, className) {
				  return '<span class="' + className + '">' + (index + 1) + '</span>';
				},
			},
			navigation: {
				nextEl: '.swiper-button-next1',
				prevEl: '.swiper-button-prev1',
			},
		});
	}
	
	// Testimonial Swiper
	if(jQuery('.testimonial-swiper1').length > 0){
		var testimonialswiper1 = new Swiper('.testimonial-swiper1', {
			speed: 1500,
			slidesPerView: 3,
			spaceBetween: 30,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: '.swiper-pagination1',
				clickable: true,
				renderBullet: function (index, className) {
				  return '<span class="' + className + '">' + (index + 1) + '</span>';
				},
			},
			breakpoints: {
				1191: {
					slidesPerView: 3,
				},
				691: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	// Testimonial Swiper
	if(jQuery('.testimonial-swiper2').length > 0){
		var testimonialswiper2 = new Swiper('.testimonial-swiper2', {
			speed: 1500,
			slidesPerView: 2,
			spaceBetween: 0,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: '.swiper-pagination1',
				clickable: true,
				renderBullet: function (index, className) {
				  return '<span class="' + className + '">' + (index + 1) + '</span>';
				},
			},
			breakpoints: {
				1200: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	setTimeout(function(){
		// Swiper Portfolio
		if(jQuery('.swiper-portfolio').length > 0){
			var swiper2 = new Swiper('.swiper-portfolio', {
				slidesPerView: 1,
				spaceBetween: 0,
				speed: 1500,
				loop:true,
				autoplay: {
				   delay: 3000,
				},
				navigation: {
					nextEl: '.swiper-button-next2',
					prevEl: '.swiper-button-prev2',
				},
			});
		}	
		
	}, 1000);
	
	
	// Blog Swiper
	if(jQuery('.blog-swiper').length > 0){
		var swiper2 = new Swiper('.blog-swiper', {
			slidesPerView: 3,
			spaceBetween: 0,
			speed: 1500,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			breakpoints: {
				1280: {
					slidesPerView: 3,
				},
				991: {
					slidesPerView: 3,
				},
				691: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}

	// Blog Swiper
	if(jQuery('.post-swiper').length > 0){
		var swiper2 = new Swiper('.post-swiper', {
			slidesPerView: 1,
			spaceBetween: 0,
			speed: 1500,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			navigation: {
				nextEl: '.prev-post-swiper-btn',
				prevEl: '.next-post-swiper-btn',
			},
		});
	}
	
	// Team Swiper
	if(jQuery('.team-swiper').length > 0){
		var swiper4 = new Swiper('.team-swiper', {
			speed: 1500,
			slidesPerView: 4,
			spaceBetween: 30,
			loop:true,
			autoplay: {
			   delay: 3000,
			},
			pagination: {
				el: '.swiper-pagination2',
				clickable: true,
				renderBullet: function (index, className) {
				  return '<span class="' + className + '">' + (index + 1) + '</span>';
				},
			},
			breakpoints: {
				1191: {
					slidesPerView: 4,
				},
				991: {
					slidesPerView: 3,
				},
				591: {
					slidesPerView: 2,
				},
				320: {
					slidesPerView: 1,
				},
			}
		});
	}
	
	// Clients Swiper
	if(jQuery('.clients-swiper').length > 0){
		var swiper5 = new Swiper('.clients-swiper', {
			speed: 1500,
			parallax: true,
			slidesPerView: 4,
			spaceBetween: 30,
			autoplay: {
			   delay: 3000,
			},
			loop:true,
			navigation: {
				nextEl: '.swiper-button-next5',
				prevEl: '.swiper-button-prev5',
			},
			breakpoints: {
				1191: {
					slidesPerView: 6,
				},
				991: {
					slidesPerView: 5,
				},
				691: {
					slidesPerView: 4,
				},
				591: {
					slidesPerView: 3,
				},
				320: {
					slidesPerView: 2,
				},
			}
		});
	}

	// Story-Swiper ======
	if ($('.galley-thumb-swiper').length > 0 && $('.galley-swiper').length > 0) {
		var swiper = new Swiper(".galley-thumb-swiper", {
		  loop: false,
		  spaceBetween: 10,
		  slidesPerView: 4,
		  freeMode: true,
		  watchSlidesProgress: true,
		});
	
		var swiper2 = new Swiper(".galley-swiper", {
		  loop: true,
		  spaceBetween: 10,
		  thumbs: {
			swiper: swiper,
		  },
		});
	}
	
	// Blog slideshow Swiper ==
	if(jQuery('.blog-slideshow').length > 0){
		var swiperTestimonial = new Swiper('.blog-slideshow', {
			loop: true,
			spaceBetween: 0,
			slidesPerView: "auto",
			speed: 1500,
			//autoplay: {
			//   delay: 2000,
			//},
			pagination: {
			  el: ".swiper-pagination-two",
			  clickable: true,
			},
		});
	}
	
	var myModalEl = document.getElementById('staticBackdrop');
	if(myModalEl){
			myModalEl.addEventListener('shown.bs.modal', function (event) {
			if(jQuery('.status-swiper').length > 0){
				var swiper = new Swiper('.status-swiper', {
					loop: true,
					spaceBetween: 0,
					slidesPerView: "auto",
					speed: 1500,
					effect: "fade",
					 autoplay: {
						 delay: 2000,
					 },
					pagination: {
						el: ".status-pagination",
						clickable: true,
					},
				});
		
				jQuery('.post-status-btn').on('click', function () {
					swiper.slideTo(0); 
					swiper.autoplay.start(); 
				});
			}
		})
	}
});