/**
 * OHA Theme Slider JavaScript
 * Swiper slider initialization for hero slider and team carousel
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        OHA_Slider.init();
    });

    // Main OHA Slider object
    window.OHA_Slider = {
        
        // Initialize all sliders
        init: function() {
            this.initHeroSlider();
            this.initTeamCarousel();
        },

        // Hero Slider initialization
        initHeroSlider: function() {
            if (typeof Swiper !== 'undefined' && $('.hero-swiper').length) {
                
                const heroSwiper = new Swiper('.hero-swiper', {
                    // Basic settings
                    loop: true,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    speed: 1000,
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                    
                    // Navigation
                    navigation: {
                        nextEl: '.hero-swiper .swiper-button-next',
                        prevEl: '.hero-swiper .swiper-button-prev',
                    },
                    
                    // Pagination
                    pagination: {
                        el: '.hero-swiper .swiper-pagination',
                        clickable: true,
                        dynamicBullets: true,
                        dynamicMainBullets: 3,
                    },
                    
                    // Keyboard control
                    keyboard: {
                        enabled: true,
                        onlyInViewport: true,
                    },
                    
                    // Accessibility
                    a11y: {
                        prevSlideMessage: 'Previous slide',
                        nextSlideMessage: 'Next slide',
                        firstSlideMessage: 'This is the first slide',
                        lastSlideMessage: 'This is the last slide',
                        paginationBulletMessage: 'Go to slide {{index}}',
                    },
                    
                    // Events
                    on: {
                        init: function() {
                            // Add loaded class for animations
                            $('.hero-swiper').addClass('swiper-loaded');
                        },
                        slideChange: function() {
                            // Trigger any custom animations on slide change
                            OHA_Slider.triggerSlideAnimations(this);
                        }
                    }
                });

                // Pause autoplay on focus for accessibility
                $('.hero-swiper').on('focusin', function() {
                    heroSwiper.autoplay.stop();
                });

                $('.hero-swiper').on('focusout', function() {
                    heroSwiper.autoplay.start();
                });
            }
        },

        // Team Carousel initialization
        initTeamCarousel: function() {
            if (typeof Swiper !== 'undefined' && $('.team-swiper').length) {
                
                const teamSwiper = new Swiper('.team-swiper', {
                    // Basic settings
                    loop: false,
                    autoplay: {
                        delay: 4000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    speed: 800,
                    grabCursor: true,
                    
                    // Responsive breakpoints
                    slidesPerView: 1,
                    spaceBetween: 20,
                    breakpoints: {
                        // Mobile landscape and small tablets
                        480: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        // Tablets
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        // Desktop
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                        // Large desktop
                        1200: {
                            slidesPerView: 4,
                            spaceBetween: 40,
                        }
                    },
                    
                    // Navigation
                    navigation: {
                        nextEl: '.team-swiper .swiper-button-next',
                        prevEl: '.team-swiper .swiper-button-prev',
                    },
                    
                    // Pagination
                    pagination: {
                        el: '.team-swiper .swiper-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    },
                    
                    // Keyboard control
                    keyboard: {
                        enabled: true,
                        onlyInViewport: true,
                    },
                    
                    // Accessibility
                    a11y: {
                        prevSlideMessage: 'Previous team member',
                        nextSlideMessage: 'Next team member',
                        firstSlideMessage: 'This is the first team member',
                        lastSlideMessage: 'This is the last team member',
                        paginationBulletMessage: 'Go to team member {{index}}',
                    },
                    
                    // Events
                    on: {
                        init: function() {
                            $('.team-swiper').addClass('swiper-loaded');
                        },
                        slideChange: function() {
                            OHA_Slider.triggerSlideAnimations(this);
                        }
                    }
                });

                // Pause autoplay on hover for better UX
                $('.team-swiper').hover(
                    function() {
                        teamSwiper.autoplay.stop();
                    },
                    function() {
                        teamSwiper.autoplay.start();
                    }
                );
            }
        },

        // Trigger slide animations
        triggerSlideAnimations: function(swiper) {
            // Remove previous animations
            $(swiper.el).find('.swiper-slide').removeClass('slide-animate');
            
            // Add animation to active slide
            setTimeout(function() {
                $(swiper.el).find('.swiper-slide-active').addClass('slide-animate');
            }, 100);
        },

        // Utility function to handle reduced motion preference
        respectMotionPreference: function() {
            if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                // Disable autoplay and reduce animation speeds for users who prefer reduced motion
                return {
                    autoplay: false,
                    speed: 300,
                    effect: 'slide' // Use slide instead of fade for reduced motion
                };
            }
            return {};
        }
    };

})(jQuery);

/**
 * Custom Swiper Styles for OHA Theme
 */
document.addEventListener('DOMContentLoaded', function() {
    
    // Add custom CSS for Swiper components
    const swiperCSS = `
        <style id="oha-swiper-styles">
        /* Hero Swiper Custom Styles */
        .hero-swiper {
            height: 100%;
            width: 100%;
        }

        .hero-swiper .swiper-button-next,
        .hero-swiper .swiper-button-prev {
            color: var(--oha-white);
            background: rgba(88, 170, 53, 0.8);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .hero-swiper .swiper-button-next:after,
        .hero-swiper .swiper-button-prev:after {
            font-size: 18px;
            font-weight: bold;
        }

        .hero-swiper .swiper-button-next:hover,
        .hero-swiper .swiper-button-prev:hover {
            background: var(--oha-primary-red);
            transform: scale(1.1);
        }

        .hero-swiper .swiper-pagination {
            bottom: 30px;
        }

        .hero-swiper .swiper-pagination-bullet {
            background: rgba(255, 255, 255, 0.5);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .hero-swiper .swiper-pagination-bullet-active {
            background: var(--oha-white);
            transform: scale(1.3);
        }

        /* Team Swiper Custom Styles */
        .team-swiper .swiper-button-next,
        .team-swiper .swiper-button-prev {
            color: var(--oha-primary-green);
            background: var(--oha-white);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            box-shadow: var(--oha-shadow-md);
            transition: all 0.3s ease;
        }

        .team-swiper .swiper-button-next:after,
        .team-swiper .swiper-button-prev:after {
            font-size: 16px;
            font-weight: bold;
        }

        .team-swiper .swiper-button-next:hover,
        .team-swiper .swiper-button-prev:hover {
            background: var(--oha-primary-green);
            color: var(--oha-white);
            transform: scale(1.1);
        }

        .team-swiper .swiper-pagination {
            bottom: -50px;
        }

        .team-swiper .swiper-pagination-bullet {
            background: var(--oha-light-gray);
            width: 10px;
            height: 10px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .team-swiper .swiper-pagination-bullet-active {
            background: var(--oha-primary-green);
            transform: scale(1.2);
        }

        /* Slide Animation Effects */
        .swiper-slide {
            opacity: 0.7;
            transform: scale(0.95);
            transition: all 0.5s ease;
        }

        .swiper-slide-active {
            opacity: 1;
            transform: scale(1);
        }

        .slide-animate .hero-content,
        .slide-animate .team-member-card {
            animation: slideInUp 0.8s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 767px) {
            .hero-swiper .swiper-button-next,
            .hero-swiper .swiper-button-prev {
                width: 40px;
                height: 40px;
            }

            .hero-swiper .swiper-button-next:after,
            .hero-swiper .swiper-button-prev:after {
                font-size: 14px;
            }

            .team-swiper .swiper-button-next,
            .team-swiper .swiper-button-prev {
                width: 35px;
                height: 35px;
            }

            .team-swiper .swiper-button-next:after,
            .team-swiper .swiper-button-prev:after {
                font-size: 14px;
            }

            .hero-swiper .swiper-pagination {
                bottom: 20px;
            }

            .team-swiper .swiper-pagination {
                bottom: -40px;
            }
        }

        /* Reduced Motion Support */
        @media (prefers-reduced-motion: reduce) {
            .swiper-slide,
            .hero-swiper .swiper-button-next,
            .hero-swiper .swiper-button-prev,
            .team-swiper .swiper-button-next,
            .team-swiper .swiper-button-prev {
                transition: none;
            }

            .slide-animate .hero-content,
            .slide-animate .team-member-card {
                animation: none;
            }
        }
        </style>
    `;
    
    document.head.insertAdjacentHTML('beforeend', swiperCSS);
}); 