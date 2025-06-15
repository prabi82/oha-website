/**
 * OHA Theme Main JavaScript
 * 
 * Handles all theme-specific functionality including:
 * - Navigation enhancements
 * - Smooth scrolling
 * - Footer newsletter
 * - Back to top button
 * - Social media interactions
 */

jQuery(document).ready(function($) {
    'use strict';

    // Mobile menu toggle functionality
    $('.menu-toggle').on('click', function() {
        $(this).toggleClass('menu-open');
        $('.main-navigation').toggleClass('toggled');
        $('body').toggleClass('menu-open');
    });

    // Close menu when clicking outside
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.main-navigation, .menu-toggle').length) {
            $('.menu-toggle').removeClass('menu-open');
            $('.main-navigation').removeClass('toggled');
            $('body').removeClass('menu-open');
        }
    });

    // Smooth scrolling for anchor links
    $('a[href^="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && 
            location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            
            if (target.length) {
                event.preventDefault();
                var offset = target.offset().top - 100; // Account for fixed header
                
                $('html, body').animate({
                    scrollTop: offset
                }, 800, 'swing');
            }
        }
    });

    // Back to Top Button Functionality
    var $backToTop = $('#back-to-top');
    
    // Show/hide back to top button based on scroll position
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $backToTop.addClass('show');
        } else {
            $backToTop.removeClass('show');
        }
    });
    
    // Back to top click handler
    $backToTop.on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: 0
        }, 800, 'swing');
    });

    // Newsletter Subscription Functionality
    $('.newsletter-form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $input = $form.find('input[type="email"]');
        var $button = $form.find('.newsletter-submit');
        var email = $input.val().trim();
        
        // Basic email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!email) {
            showNewsletterMessage('Please enter your email address.', 'error');
            $input.focus();
            return;
        }
        
        if (!emailRegex.test(email)) {
            showNewsletterMessage('Please enter a valid email address.', 'error');
            $input.focus();
            return;
        }
        
        // Show loading state
        $button.addClass('loading').prop('disabled', true);
        $button.find('i').removeClass('fa-paper-plane').addClass('fa-spinner fa-spin');
        
        // Simulate newsletter subscription (replace with actual implementation)
        setTimeout(function() {
            // Success simulation
            $input.val('');
            $button.removeClass('loading').prop('disabled', false);
            $button.find('i').removeClass('fa-spinner fa-spin').addClass('fa-check');
            
            showNewsletterMessage('Thank you for subscribing! You\'ll receive our latest updates.', 'success');
            
            // Reset button icon after 2 seconds
            setTimeout(function() {
                $button.find('i').removeClass('fa-check').addClass('fa-paper-plane');
            }, 2000);
            
        }, 1500);
    });
    
    // Function to show newsletter messages
    function showNewsletterMessage(message, type) {
        var $form = $('.newsletter-form');
        var $existingMessage = $form.find('.newsletter-message');
        
        // Remove existing message
        $existingMessage.remove();
        
        // Create new message
        var $message = $('<div class="newsletter-message newsletter-' + type + '">' + message + '</div>');
        $form.append($message);
        
        // Show message with animation
        $message.fadeIn(300);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            $message.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }

    // Enhanced Social Media Link Interactions
    $('.footer-social-links .social-link').on('mouseenter', function() {
        $(this).addClass('hovered');
    }).on('mouseleave', function() {
        $(this).removeClass('hovered');
    });

    // Add click tracking for social links (for analytics)
    $('.footer-social-links .social-link').on('click', function() {
        var platform = $(this).attr('class').replace('social-link ', '').replace(' hovered', '');
        
        // Track social media clicks (integrate with your analytics)
        if (typeof gtag !== 'undefined') {
            gtag('event', 'social_click', {
                'social_platform': platform,
                'page_location': window.location.href
            });
        }
    });

    // Lazy Loading for Images (Progressive Enhancement)
    if ('IntersectionObserver' in window) {
        var imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(function(img) {
            imageObserver.observe(img);
        });
    }

    // Enhanced Footer Links with Ripple Effect
    $('.footer-menu-list a').on('click', function(e) {
        var $this = $(this);
        var ripple = $('<span class="ripple"></span>');
        
        $this.prepend(ripple);
        
        var x = e.pageX - $this.offset().left;
        var y = e.pageY - $this.offset().top;
        
        ripple.css({
            left: x,
            top: y,
            background: 'rgba(88, 170, 53, 0.3)',
            borderRadius: '50%',
            transform: 'scale(0)',
            animation: 'ripple 0.6s linear',
            position: 'absolute',
            width: '20px',
            height: '20px'
        });
        
        setTimeout(function() {
            ripple.remove();
        }, 600);
    });

    // Keyboard Navigation Enhancement
    $(document).on('keydown', function(e) {
        // ESC key closes mobile menu
        if (e.key === 'Escape') {
            $('.menu-toggle').removeClass('menu-open');
            $('.main-navigation').removeClass('toggled');
            $('body').removeClass('menu-open');
        }
        
        // Arrow keys for back to top
        if (e.key === 'Home' && e.ctrlKey) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 800);
        }
    });

    // Footer Animation on Scroll
    var $footer = $('.site-footer');
    var footerAnimated = false;
    
    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        var windowHeight = $(window).height();
        var documentHeight = $(document).height();
        var footerTop = $footer.offset().top;
        
        // Animate footer elements when they come into view
        if (!footerAnimated && scrollTop + windowHeight > footerTop) {
            footerAnimated = true;
            
            $('.footer-column').each(function(index) {
                var $column = $(this);
                setTimeout(function() {
                    $column.addClass('animate-in');
                }, index * 150);
            });
        }
    });

    // Contact Form Enhancement (if exists)
    if ($('.contact-form').length) {
        $('.contact-form input, .contact-form textarea').on('focus', function() {
            $(this).parent().addClass('focused');
        }).on('blur', function() {
            if (!$(this).val()) {
                $(this).parent().removeClass('focused');
            }
        });
    }

    // Print Functionality
    $('.print-page').on('click', function(e) {
        e.preventDefault();
        window.print();
    });

    // Search Enhancement
    $('.search-toggle').on('click', function(e) {
        e.preventDefault();
        var $searchForm = $('.header-search-form');
        
        if ($searchForm.is(':visible')) {
            $searchForm.fadeOut(200);
        } else {
            $searchForm.fadeIn(200, function() {
                $searchForm.find('input[type="search"]').focus();
            });
        }
    });

    // Close search when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.header-search-form, .search-toggle').length) {
            $('.header-search-form').fadeOut(200);
        }
    });

    // Accessibility: Skip to Content
    $('.skip-link').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            target.focus();
            if (target.is(':focusable')) {
                return false;
            } else {
                target.attr('tabindex', '-1');
                target.focus();
            }
        }
    });

    // Initialize all components
    initializeOHAComponents();
    
    function initializeOHAComponents() {
        // Add loaded class to body for CSS animations
        $('body').addClass('oha-loaded');
        
        // Initialize any additional components here
        if (typeof window.ohaSlider !== 'undefined') {
            window.ohaSlider.init();
        }
        
        // Trigger custom event for other scripts
        $(document).trigger('oha:initialized');
    }
});

// CSS Animations for Newsletter Messages
jQuery(document).ready(function($) {
    if (!$('#oha-newsletter-styles').length) {
        $('<style id="oha-newsletter-styles">')
            .text(`
                .newsletter-message {
                    display: none;
                    padding: 12px 15px;
                    margin-top: 15px;
                    border-radius: 8px;
                    font-size: 0.9rem;
                    text-align: center;
                    font-weight: 500;
                }
                
                .newsletter-success {
                    background: rgba(88, 170, 53, 0.2);
                    color: #4a7c30;
                    border: 1px solid rgba(88, 170, 53, 0.3);
                }
                
                .newsletter-error {
                    background: rgba(229, 32, 29, 0.2);
                    color: #b8241f;
                    border: 1px solid rgba(229, 32, 29, 0.3);
                }
                
                .newsletter-submit.loading {
                    pointer-events: none;
                    opacity: 0.7;
                }
                
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
                
                .footer-column {
                    opacity: 0;
                    transform: translateY(30px);
                    transition: all 0.6s ease-out;
                }
                
                .footer-column.animate-in {
                    opacity: 1;
                    transform: translateY(0);
                }
                
                @media (prefers-reduced-motion: reduce) {
                    .footer-column {
                        opacity: 1;
                        transform: none;
                        transition: none;
                    }
                }
            `)
            .appendTo('head');
    }
}); 