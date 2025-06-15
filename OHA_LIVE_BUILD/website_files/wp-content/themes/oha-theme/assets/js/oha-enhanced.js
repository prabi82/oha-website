/**
 * OHA Theme Enhanced JavaScript
 * Additional functionality for search, single posts, and user experience
 * 
 * @package OHA_Theme
 */

(function($) {
    'use strict';

    // Enhanced OHA functionality
    window.OHAEnhanced = {
        
        // Initialize enhanced features
        init: function() {
            this.tableOfContents();
            this.searchEnhancements();
            this.socialSharing();
            this.readingProgress();
            this.stickyElements();
            this.imageZoom();
            this.printFunctionality();
            this.keyboardNavigation();
            this.cookieConsent();
        },

        // Generate table of contents for long articles
        tableOfContents: function() {
            const tocContainer = $('#article-toc');
            const contentArea = $('.single-post-content-body');
            
            if (!tocContainer.length || !contentArea.length) return;

            const headings = contentArea.find('h2, h3, h4, h5, h6');
            
            if (headings.length < 3) {
                $('.article-toc-widget').hide();
                return;
            }

            let tocHTML = '<ul class="toc-list">';
            const headingIds = [];

            headings.each(function(index) {
                const heading = $(this);
                const text = heading.text().trim();
                const level = parseInt(heading.prop('tagName').substring(1));
                const id = 'toc-heading-' + index;
                
                // Add ID to heading for anchor linking
                heading.attr('id', id);
                headingIds.push({ id: id, element: heading });

                // Create TOC item with proper nesting
                const indentClass = level > 2 ? 'toc-indent-' + (level - 2) : '';
                tocHTML += `<li class="toc-item toc-level-${level} ${indentClass}">
                    <a href="#${id}" class="toc-link">${text}</a>
                </li>`;
            });

            tocHTML += '</ul>';
            tocContainer.html(tocHTML);

            // Store heading data for scroll detection
            tocContainer.data('headings', headingIds);

            // Handle TOC clicks
            tocContainer.on('click', 'a', function(e) {
                e.preventDefault();
                const targetId = $(this).attr('href').substring(1);
                const targetElement = $('#' + targetId);
                
                if (targetElement.length) {
                    $('html, body').animate({
                        scrollTop: targetElement.offset().top - 120
                    }, 500);
                }
            });

            // Highlight active section on scroll
            this.activeTOCHighlight(tocContainer);
        },

        // Highlight active TOC item based on scroll position
        activeTOCHighlight: function(tocContainer) {
            if (!tocContainer.length) return;

            const headings = tocContainer.data('headings');
            if (!headings || headings.length === 0) return;

            let ticking = false;

            const updateActiveTOC = () => {
                const scrollTop = $(window).scrollTop();
                let activeId = null;

                // Find the currently visible heading
                for (let i = headings.length - 1; i >= 0; i--) {
                    const heading = headings[i];
                    if (heading.element.length && scrollTop >= heading.element.offset().top - 150) {
                        activeId = heading.id;
                        break;
                    }
                }

                // Update active states
                tocContainer.find('a').removeClass('active');
                if (activeId) {
                    tocContainer.find(`a[href="#${activeId}"]`).addClass('active');
                }

                ticking = false;
            };

            $(window).on('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(updateActiveTOC);
                    ticking = true;
                }
            });
        },

        // Enhanced search functionality
        searchEnhancements: function() {
            const searchForms = $('.oha-search-form');
            
            searchForms.each(function() {
                const form = $(this);
                const input = form.find('.search-field');
                const suggestions = $('<div class="search-suggestions"></div>');
                
                // Add suggestions container after the form
                form.after(suggestions);

                let searchTimeout;
                
                // Live search suggestions
                input.on('input', function() {
                    const query = $(this).val().trim();
                    
                    clearTimeout(searchTimeout);
                    
                    if (query.length >= 3) {
                        searchTimeout = setTimeout(() => {
                            OHAEnhanced.fetchSearchSuggestions(query, suggestions);
                        }, 300);
                    } else {
                        suggestions.hide();
                    }
                });

                // Hide suggestions when clicking outside
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.oha-search-form, .search-suggestions').length) {
                        suggestions.hide();
                    }
                });

                // Keyboard navigation for suggestions
                input.on('keydown', function(e) {
                    const activeSuggestion = suggestions.find('.suggestion-item.active');
                    
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        if (!activeSuggestion.length) {
                            suggestions.find('.suggestion-item:first').addClass('active');
                        } else {
                            activeSuggestion.removeClass('active').next().addClass('active');
                        }
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        if (activeSuggestion.length) {
                            activeSuggestion.removeClass('active').prev().addClass('active');
                        }
                    } else if (e.key === 'Enter' && activeSuggestion.length) {
                        e.preventDefault();
                        window.location.href = activeSuggestion.find('a').attr('href');
                    }
                });
            });
        },

        // Fetch search suggestions via AJAX
        fetchSearchSuggestions: function(query, container) {
            $.ajax({
                url: oha_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'oha_search_suggestions',
                    query: query,
                    nonce: oha_ajax.nonce
                },
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        let html = '<ul class="suggestions-list">';
                        
                        response.data.forEach(item => {
                            html += `<li class="suggestion-item">
                                <a href="${item.url}">
                                    <div class="suggestion-content">
                                        <strong class="suggestion-title">${item.title}</strong>
                                        <span class="suggestion-type">${item.type}</span>
                                    </div>
                                </a>
                            </li>`;
                        });
                        
                        html += '</ul>';
                        container.html(html).show();
                    } else {
                        container.hide();
                    }
                },
                error: function() {
                    container.hide();
                }
            });
        },

        // Enhanced social sharing
        socialSharing: function() {
            // Open social share links in popup windows
            $('.share-btn, .social-share-buttons a').on('click', function(e) {
                const url = $(this).attr('href');
                
                if (url && (url.includes('facebook.com') || url.includes('twitter.com') || 
                           url.includes('linkedin.com') || url.includes('pinterest.com'))) {
                    e.preventDefault();
                    
                    const windowFeatures = 'width=600,height=400,scrollbars=no,resizable=no,toolbar=no,location=no,directories=no,status=no,menubar=no';
                    window.open(url, 'social-share', windowFeatures);
                }
            });

            // Copy to clipboard functionality
            if ($('.share-copy').length === 0 && $('.social-share-buttons').length) {
                $('.social-share-buttons').append(`
                    <button class="share-btn share-copy" title="Copy link">
                        <i class="fas fa-link"></i>
                    </button>
                `);
            }

            $(document).on('click', '.share-copy', function(e) {
                e.preventDefault();
                
                const url = window.location.href;
                
                // Modern clipboard API
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(() => {
                        OHAEnhanced.showToast('Link copied to clipboard!');
                    });
                } else {
                    // Fallback for older browsers
                    const textArea = document.createElement('textarea');
                    textArea.value = url;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    OHAEnhanced.showToast('Link copied to clipboard!');
                }
            });
        },

        // Reading progress indicator
        readingProgress: function() {
            const progressBar = $('.reading-progress-bar');
            const content = $('.single-post-content-body');
            
            if (!progressBar.length || !content.length) {
                // Create progress bar if it doesn't exist
                if (content.length && $('.oha-single-post').length) {
                    $('body').append(`
                        <div class="reading-progress">
                            <div class="reading-progress-bar"></div>
                        </div>
                    `);
                    this.readingProgress(); // Recursive call with created elements
                }
                return;
            }

            let ticking = false;

            const updateProgress = () => {
                const contentTop = content.offset().top;
                const contentHeight = content.outerHeight();
                const windowHeight = $(window).height();
                const scrollTop = $(window).scrollTop();
                
                const startPos = contentTop - windowHeight + 100;
                const endPos = contentTop + contentHeight - windowHeight;
                
                if (scrollTop >= startPos && scrollTop <= endPos) {
                    const progress = ((scrollTop - startPos) / (endPos - startPos)) * 100;
                    const clampedProgress = Math.min(100, Math.max(0, progress));
                    progressBar.css('width', clampedProgress + '%');
                } else if (scrollTop < startPos) {
                    progressBar.css('width', '0%');
                } else if (scrollTop > endPos) {
                    progressBar.css('width', '100%');
                }

                ticking = false;
            };

            $(window).on('scroll', function() {
                if (!ticking) {
                    requestAnimationFrame(updateProgress);
                    ticking = true;
                }
            });
        },

        // Sticky elements functionality
        stickyElements: function() {
            const stickyElements = $('.article-toc-widget, .sticky-sidebar');
            
            if (!stickyElements.length) return;

            stickyElements.each(function() {
                const element = $(this);
                const parent = element.parent();
                const elementTop = element.offset().top;
                
                $(window).on('scroll', function() {
                    const scrollTop = $(window).scrollTop();
                    const parentBottom = parent.offset().top + parent.outerHeight();
                    const elementHeight = element.outerHeight();
                    
                    if (scrollTop + 40 > elementTop && scrollTop + elementHeight + 40 < parentBottom) {
                        element.addClass('is-sticky');
                    } else {
                        element.removeClass('is-sticky');
                    }
                });
            });
        },

        // Image zoom functionality
        imageZoom: function() {
            // Add zoom functionality to content images
            $('.single-post-content-body img, .oha-gallery img').on('click', function(e) {
                e.preventDefault();
                
                const imgSrc = $(this).attr('src');
                const imgAlt = $(this).attr('alt') || '';
                
                // Create modal for zoomed image
                const modal = $(`
                    <div class="image-zoom-modal">
                        <div class="image-zoom-overlay"></div>
                        <div class="image-zoom-content">
                            <img src="${imgSrc}" alt="${imgAlt}" />
                            <button class="image-zoom-close" aria-label="Close image">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                `);
                
                $('body').append(modal).addClass('modal-open');
                
                // Close modal
                modal.on('click', '.image-zoom-close, .image-zoom-overlay', function() {
                    modal.fadeOut(300, function() {
                        $(this).remove();
                        $('body').removeClass('modal-open');
                    });
                });
                
                // Close with ESC key
                $(document).on('keydown.imageZoom', function(e) {
                    if (e.key === 'Escape') {
                        modal.find('.image-zoom-close').click();
                        $(document).off('keydown.imageZoom');
                    }
                });
            });
        },

        // Print functionality
        printFunctionality: function() {
            // Add print button to single posts
            if ($('.single-post-content').length && !$('.print-button').length) {
                $('.single-post-meta .post-social-share').append(`
                    <button class="share-btn print-button" title="Print article">
                        <i class="fas fa-print"></i>
                    </button>
                `);
            }

            $(document).on('click', '.print-button', function(e) {
                e.preventDefault();
                window.print();
            });

            // Optimize print styles
            const printStyles = `
                @media print {
                    .site-header, .site-footer, .oha-breadcrumbs, 
                    .single-post-sidebar, .post-navigation, .related-posts,
                    .share-btn, .back-to-top, .reading-progress {
                        display: none !important;
                    }
                    
                    .single-post-content {
                        box-shadow: none !important;
                        border-radius: 0 !important;
                    }
                    
                    .single-post-title {
                        font-size: 24pt !important;
                        margin-bottom: 12pt !important;
                    }
                    
                    .single-post-content-body {
                        font-size: 12pt !important;
                        line-height: 1.4 !important;
                    }
                }
            `;
            
            if (!$('#print-styles').length) {
                $('head').append(`<style id="print-styles">${printStyles}</style>`);
            }
        },

        // Enhanced keyboard navigation
        keyboardNavigation: function() {
            // Focus management for modals and overlays
            $(document).on('keydown', function(e) {
                // Handle tab trapping in modals
                if ($('.modal-open').length) {
                    const modal = $('.image-zoom-modal:visible, .video-modal:visible').last();
                    if (modal.length) {
                        const focusableElements = modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                        const firstElement = focusableElements.first();
                        const lastElement = focusableElements.last();
                        
                        if (e.key === 'Tab') {
                            if (e.shiftKey && document.activeElement === firstElement[0]) {
                                e.preventDefault();
                                lastElement.focus();
                            } else if (!e.shiftKey && document.activeElement === lastElement[0]) {
                                e.preventDefault();
                                firstElement.focus();
                            }
                        }
                    }
                }
            });

            // Skip to content link
            if (!$('.skip-to-content').length) {
                $('body').prepend(`
                    <a href="#primary" class="skip-to-content">
                        Skip to main content
                    </a>
                `);
            }
        },

        // Cookie consent functionality
        cookieConsent: function() {
            if (localStorage.getItem('oha_cookie_consent') === 'accepted') {
                return; // Already accepted
            }

            const consentBanner = $(`
                <div class="cookie-consent" role="banner">
                    <div class="cookie-content">
                        <div class="cookie-text">
                            <p>This website uses cookies to enhance your browsing experience and provide personalized content. By continuing to use this site, you consent to our use of cookies.</p>
                        </div>
                        <div class="cookie-actions">
                            <button class="cookie-accept oha-btn oha-btn-primary">Accept</button>
                            <button class="cookie-settings oha-btn oha-btn-outline">Settings</button>
                        </div>
                    </div>
                </div>
            `);
            
            $('body').append(consentBanner);
            
            // Accept cookies
            consentBanner.on('click', '.cookie-accept', function() {
                localStorage.setItem('oha_cookie_consent', 'accepted');
                consentBanner.slideUp(300, function() {
                    $(this).remove();
                });
            });
            
            // Cookie settings (basic implementation)
            consentBanner.on('click', '.cookie-settings', function() {
                alert('Cookie settings functionality would be implemented here with more detailed options.');
            });
        },

        // Utility function to show toast messages
        showToast: function(message, type = 'success') {
            const toast = $(`
                <div class="oha-toast oha-toast-${type}">
                    <span class="toast-message">${message}</span>
                    <button class="toast-close" aria-label="Close">&times;</button>
                </div>
            `);
            
            $('body').append(toast);
            
            // Show toast
            setTimeout(() => toast.addClass('show'), 100);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                toast.removeClass('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
            
            // Manual close
            toast.on('click', '.toast-close', function() {
                toast.removeClass('show');
                setTimeout(() => toast.remove(), 300);
            });
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        OHAEnhanced.init();
    });

    // Add dynamic CSS for enhanced features
    const enhancedCSS = `
        <style id="oha-enhanced-styles">
            /* Reading Progress Bar */
            .reading-progress {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background: rgba(88, 170, 53, 0.2);
                z-index: 9999;
                pointer-events: none;
            }
            
            .reading-progress-bar {
                height: 100%;
                background: var(--oha-primary-green);
                width: 0%;
                transition: width 0.2s ease;
            }
            
            /* Table of Contents */
            .toc-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            
            .toc-item {
                margin-bottom: 8px;
            }
            
            .toc-indent-1 { padding-left: 15px; }
            .toc-indent-2 { padding-left: 30px; }
            .toc-indent-3 { padding-left: 45px; }
            
            .toc-link {
                display: block;
                padding: 5px 10px;
                color: var(--oha-dark-gray);
                text-decoration: none;
                border-left: 3px solid transparent;
                font-size: 0.9rem;
                transition: var(--oha-transition);
            }
            
            .toc-link:hover,
            .toc-link.active {
                color: var(--oha-primary-green);
                border-left-color: var(--oha-primary-green);
                background: rgba(88, 170, 53, 0.1);
            }
            
            /* Search Suggestions */
            .search-suggestions {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--oha-white);
                border: 2px solid var(--oha-primary-green);
                border-top: none;
                border-radius: 0 0 8px 8px;
                box-shadow: var(--oha-shadow-lg);
                z-index: 1000;
                max-height: 300px;
                overflow-y: auto;
            }
            
            .suggestions-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }
            
            .suggestion-item {
                border-bottom: 1px solid var(--oha-light-gray);
            }
            
            .suggestion-item:last-child {
                border-bottom: none;
            }
            
            .suggestion-item a {
                display: block;
                padding: 12px 15px;
                color: var(--oha-dark-gray);
                text-decoration: none;
                transition: var(--oha-transition);
            }
            
            .suggestion-item:hover a,
            .suggestion-item.active a {
                background: var(--oha-primary-green);
                color: var(--oha-white);
            }
            
            .suggestion-title {
                display: block;
                margin-bottom: 3px;
            }
            
            .suggestion-type {
                font-size: 0.8rem;
                opacity: 0.8;
                text-transform: uppercase;
            }
            
            /* Image Zoom Modal */
            .image-zoom-modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 10000;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .image-zoom-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.9);
                cursor: pointer;
            }
            
            .image-zoom-content {
                position: relative;
                max-width: 90%;
                max-height: 90%;
                z-index: 1;
            }
            
            .image-zoom-content img {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
            }
            
            .image-zoom-close {
                position: absolute;
                top: -40px;
                right: -40px;
                background: var(--oha-white);
                color: var(--oha-dark-gray);
                border: none;
                width: 35px;
                height: 35px;
                border-radius: 50%;
                cursor: pointer;
                font-size: 1.2rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            /* Cookie Consent */
            .cookie-consent {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(88, 89, 92, 0.95);
                color: var(--oha-white);
                padding: 20px;
                z-index: 9999;
                backdrop-filter: blur(5px);
            }
            
            .cookie-content {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
            }
            
            .cookie-text {
                flex: 1;
            }
            
            .cookie-text p {
                margin: 0;
                font-size: 0.9rem;
                line-height: 1.4;
            }
            
            .cookie-actions {
                display: flex;
                gap: 10px;
                flex-shrink: 0;
            }
            
            /* Toast Messages */
            .oha-toast {
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--oha-white);
                color: var(--oha-dark-gray);
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: var(--oha-shadow-lg);
                border-left: 4px solid var(--oha-primary-green);
                z-index: 10000;
                transform: translateX(100%);
                opacity: 0;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .oha-toast.show {
                transform: translateX(0);
                opacity: 1;
            }
            
            .oha-toast-error {
                border-left-color: var(--oha-primary-red);
            }
            
            .toast-close {
                background: none;
                border: none;
                font-size: 1.2rem;
                cursor: pointer;
                color: var(--oha-dark-gray);
                opacity: 0.7;
            }
            
            .toast-close:hover {
                opacity: 1;
            }
            
            /* Skip to Content */
            .skip-to-content {
                position: absolute;
                top: -40px;
                left: 6px;
                background: var(--oha-primary-green);
                color: var(--oha-white);
                padding: 8px;
                z-index: 100000;
                text-decoration: none;
                border-radius: 0 0 4px 4px;
            }
            
            .skip-to-content:focus {
                top: 0;
            }
            
            /* Sticky Elements */
            .is-sticky {
                position: fixed;
                top: 40px;
                z-index: 999;
            }
            
            /* Mobile Responsive */
            @media (max-width: 768px) {
                .cookie-content {
                    flex-direction: column;
                    text-align: center;
                    gap: 15px;
                }
                
                .cookie-actions {
                    flex-direction: column;
                    width: 100%;
                }
                
                .image-zoom-close {
                    top: 10px;
                    right: 10px;
                }
                
                .oha-toast {
                    right: 10px;
                    left: 10px;
                    transform: translateY(-100%);
                }
                
                .oha-toast.show {
                    transform: translateY(0);
                }
            }
        </style>
    `;
    
    if (!$('#oha-enhanced-styles').length) {
        $('head').append(enhancedCSS);
    }

})(jQuery); 