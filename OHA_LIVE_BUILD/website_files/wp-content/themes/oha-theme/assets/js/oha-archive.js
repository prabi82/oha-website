/**
 * OHA Archive JavaScript
 * Enhanced functionality for archive pages
 */

(function($) {
    'use strict';

    // Archive object
    window.OHAArchive = {
        
        // Current state
        state: {
            currentPage: 1,
            isLoading: false,
            currentSort: 'date_desc',
            currentView: 'grid',
            hasMore: true,
            totalPages: 1
        },

        // Initialize
        init: function() {
            this.bindEvents();
            this.loadViewPreference();
            this.initializeFilters();
            this.setupInfiniteScroll();
        },

        // Bind events
        bindEvents: function() {
            
            // Load More button
            $(document).on('click', '#load-more-posts', this.loadMorePosts.bind(this));
            
            // Sort change
            $(document).on('change', '#archive-sort', this.handleSortChange.bind(this));
            
            // View toggle
            $(document).on('click', '.view-btn', this.handleViewChange.bind(this));
            
            // Quick share buttons
            $(document).on('click', '.quick-share-btn', this.handleQuickShare.bind(this));
            
            // Quick bookmark buttons
            $(document).on('click', '.quick-bookmark-btn', this.handleQuickBookmark.bind(this));
            
            // Filter buttons (if any)
            $(document).on('click', '.filter-btn', this.handleFilterChange.bind(this));
            
            // Keyboard navigation
            $(document).on('keydown', this.handleKeyboardNavigation.bind(this));
        },

        // Load more posts
        loadMorePosts: function(e) {
            e.preventDefault();
            
            if (this.state.isLoading || !this.state.hasMore) return;
            
            const $button = $('#load-more-posts');
            const nextPage = this.state.currentPage + 1;
            
            this.setLoadingState($button, true);
            
            $.ajax({
                url: oha_archive.ajax_url,
                type: 'POST',
                data: {
                    action: 'oha_load_more_posts',
                    nonce: oha_archive.load_more_nonce,
                    page: nextPage,
                    sort: this.state.currentSort,
                    category: this.getCurrentCategory(),
                    tag: this.getCurrentTag(),
                    search: this.getCurrentSearch()
                },
                success: (response) => {
                    if (response.success) {
                        const $container = $('#archive-posts-container');
                        const $newPosts = $(response.data.html);
                        
                        // Add posts with animation
                        $newPosts.hide();
                        $container.append($newPosts);
                        $newPosts.fadeIn(600);
                        
                        // Update state
                        this.state.currentPage = nextPage;
                        this.state.hasMore = response.data.has_more;
                        this.state.totalPages = response.data.total_pages;
                        
                        // Update button
                        if (!this.state.hasMore) {
                            $button.hide();
                        }
                        
                        // Trigger animation for new posts
                        this.animateNewPosts($newPosts);
                        
                    } else {
                        this.showMessage(response.data.message || oha_archive.error_message, 'error');
                    }
                },
                error: () => {
                    this.showMessage(oha_archive.error_message, 'error');
                },
                complete: () => {
                    this.setLoadingState($button, false);
                }
            });
        },

        // Handle sort change
        handleSortChange: function(e) {
            const newSort = $(e.target).val();
            
            if (newSort === this.state.currentSort) return;
            
            this.state.currentSort = newSort;
            this.state.currentPage = 1;
            this.reloadPosts();
        },

        // Reload posts with new sorting/filtering
        reloadPosts: function() {
            if (this.state.isLoading) return;
            
            const $container = $('#archive-posts-container');
            const $loadMoreBtn = $('#load-more-posts');
            
            this.state.isLoading = true;
            
            // Show loading overlay
            this.showLoadingOverlay($container);
            
            $.ajax({
                url: oha_archive.ajax_url,
                type: 'POST',
                data: {
                    action: 'oha_sort_archive_posts',
                    nonce: oha_archive.sort_nonce,
                    sort: this.state.currentSort,
                    category: this.getCurrentCategory(),
                    tag: this.getCurrentTag(),
                    search: this.getCurrentSearch()
                },
                success: (response) => {
                    if (response.success) {
                        // Replace content with animation
                        $container.fadeOut(300, () => {
                            $container.html(response.data.html);
                            $container.fadeIn(400);
                            
                            // Update state
                            this.state.hasMore = response.data.has_more;
                            this.state.totalPages = response.data.total_pages;
                            this.state.currentPage = 1;
                            
                            // Update load more button
                            if (this.state.hasMore) {
                                $loadMoreBtn.show();
                            } else {
                                $loadMoreBtn.hide();
                            }
                            
                            // Update results count
                            this.updateResultsCount(response.data.total_posts);
                            
                            // Trigger animations
                            this.animateNewPosts($container.find('.oha-archive-card'));
                        });
                    } else {
                        this.showMessage(response.data.message || oha_archive.error_message, 'error');
                    }
                },
                error: () => {
                    this.showMessage(oha_archive.error_message, 'error');
                },
                complete: () => {
                    this.state.isLoading = false;
                    this.hideLoadingOverlay($container);
                }
            });
        },

        // Handle view change (grid/list)
        handleViewChange: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const newView = $button.data('view');
            
            if (newView === this.state.currentView) return;
            
            // Update buttons
            $('.view-btn').removeClass('active');
            $button.addClass('active');
            
            // Update container
            const $container = $('#archive-posts-container');
            $container.removeClass('view-grid view-list').addClass('view-' + newView);
            $container.attr('data-view', newView);
            
            // Update body class
            $('body').removeClass('archive-view-grid archive-view-list').addClass('archive-view-' + newView);
            
            // Save preference
            this.state.currentView = newView;
            this.saveViewPreference(newView);
            
            // Animate transition
            this.animateViewChange($container);
        },

        // Handle quick share
        handleQuickShare: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const url = $button.data('url');
            const title = $button.data('title');
            
            if (navigator.share) {
                // Use native sharing if available
                navigator.share({
                    title: title,
                    url: url
                }).catch(() => {
                    // Fallback to custom share menu
                    this.showShareMenu($button, url, title);
                });
            } else {
                // Show custom share menu
                this.showShareMenu($button, url, title);
            }
        },

        // Show share menu
        showShareMenu: function($button, url, title) {
            const shareUrls = {
                facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
                twitter: `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`,
                linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`,
                whatsapp: `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`
            };
            
            const $menu = $(`
                <div class="quick-share-menu">
                    <a href="${shareUrls.facebook}" target="_blank" class="share-option facebook">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </a>
                    <a href="${shareUrls.twitter}" target="_blank" class="share-option twitter">
                        <i class="fab fa-twitter"></i> Twitter
                    </a>
                    <a href="${shareUrls.linkedin}" target="_blank" class="share-option linkedin">
                        <i class="fab fa-linkedin-in"></i> LinkedIn
                    </a>
                    <a href="${shareUrls.whatsapp}" target="_blank" class="share-option whatsapp">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>
            `);
            
            // Remove existing menus
            $('.quick-share-menu').remove();
            
            // Position and show menu
            $button.parent().css('position', 'relative').append($menu);
            
            // Close menu when clicking outside
            setTimeout(() => {
                $(document).one('click', () => {
                    $menu.fadeOut(200, () => $menu.remove());
                });
            }, 100);
        },

        // Handle quick bookmark
        handleQuickBookmark: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const postId = $button.data('post-id');
            
            // Toggle bookmark state
            const isBookmarked = $button.hasClass('bookmarked');
            
            if (isBookmarked) {
                this.removeBookmark(postId, $button);
            } else {
                this.addBookmark(postId, $button);
            }
        },

        // Add bookmark
        addBookmark: function(postId, $button) {
            const bookmarks = this.getBookmarks();
            
            if (!bookmarks.includes(postId)) {
                bookmarks.push(postId);
                localStorage.setItem('oha_bookmarks', JSON.stringify(bookmarks));
                
                $button.addClass('bookmarked')
                       .find('i').removeClass('far').addClass('fas');
                
                this.showMessage('Article bookmarked!', 'success');
            }
        },

        // Remove bookmark
        removeBookmark: function(postId, $button) {
            let bookmarks = this.getBookmarks();
            bookmarks = bookmarks.filter(id => id !== postId);
            
            localStorage.setItem('oha_bookmarks', JSON.stringify(bookmarks));
            
            $button.removeClass('bookmarked')
                   .find('i').removeClass('fas').addClass('far');
            
            this.showMessage('Bookmark removed!', 'info');
        },

        // Get bookmarks from localStorage
        getBookmarks: function() {
            const bookmarks = localStorage.getItem('oha_bookmarks');
            return bookmarks ? JSON.parse(bookmarks) : [];
        },

        // Initialize filters
        initializeFilters: function() {
            // Mark bookmarked posts
            const bookmarks = this.getBookmarks();
            bookmarks.forEach(postId => {
                $(`.quick-bookmark-btn[data-post-id="${postId}"]`)
                    .addClass('bookmarked')
                    .find('i').removeClass('far').addClass('fas');
            });
        },

        // Setup infinite scroll (optional)
        setupInfiniteScroll: function() {
            if (!$('#load-more-posts').length) return;
            
            let isInfiniteScrollEnabled = false; // Can be enabled via customizer
            
            if (isInfiniteScrollEnabled) {
                $(window).on('scroll', OHA.debounce(() => {
                    if (this.state.hasMore && !this.state.isLoading) {
                        const $loadMore = $('#load-more-posts');
                        const scrollTop = $(window).scrollTop();
                        const windowHeight = $(window).height();
                        const documentHeight = $(document).height();
                        
                        if (scrollTop + windowHeight >= documentHeight - 1000) {
                            this.loadMorePosts({ preventDefault: () => {} });
                        }
                    }
                }, 250));
            }
        },

        // Animation helpers
        animateNewPosts: function($posts) {
            $posts.each((index, element) => {
                const $post = $(element);
                setTimeout(() => {
                    $post.addClass('oha-fade-in');
                }, index * 100);
            });
        },

        animateViewChange: function($container) {
            $container.addClass('view-transitioning');
            setTimeout(() => {
                $container.removeClass('view-transitioning');
            }, 300);
        },

        // Loading states
        setLoadingState: function($button, isLoading) {
            this.state.isLoading = isLoading;
            
            if (isLoading) {
                $button.prop('disabled', true);
                $button.find('.btn-text').hide();
                $button.find('.btn-loading').show();
            } else {
                $button.prop('disabled', false);
                $button.find('.btn-text').show();
                $button.find('.btn-loading').hide();
            }
        },

        showLoadingOverlay: function($container) {
            const $overlay = $('<div class="archive-loading-overlay"><i class="fas fa-spinner fa-spin"></i></div>');
            $container.css('position', 'relative').append($overlay);
        },

        hideLoadingOverlay: function($container) {
            $container.find('.archive-loading-overlay').remove();
        },

        // View preferences
        loadViewPreference: function() {
            const savedView = localStorage.getItem('oha_archive_view') || 'grid';
            this.state.currentView = savedView;
            
            $('.view-btn').removeClass('active');
            $(`.view-btn[data-view="${savedView}"]`).addClass('active');
            
            $('#archive-posts-container').attr('data-view', savedView);
            $('body').addClass('archive-view-' + savedView);
        },

        saveViewPreference: function(view) {
            localStorage.setItem('oha_archive_view', view);
            
            // Set cookie for server-side detection
            document.cookie = `oha_archive_view=${view}; path=/; max-age=31536000`; // 1 year
        },

        // Utility functions
        getCurrentCategory: function() {
            return $('body').hasClass('category') ? $('body').attr('class').match(/category-(\d+)/)?.[1] || 0 : 0;
        },

        getCurrentTag: function() {
            return $('body').hasClass('tag') ? $('body').attr('class').match(/tag-([^\s]+)/)?.[1] || '' : '';
        },

        getCurrentSearch: function() {
            return new URLSearchParams(window.location.search).get('s') || '';
        },

        updateResultsCount: function(totalPosts) {
            const $counter = $('.showing-results');
            if ($counter.length && totalPosts !== undefined) {
                $counter.text(`Showing 1 - ${Math.min(this.state.currentPage * 10, totalPosts)} of ${totalPosts} articles`);
            }
        },

        showMessage: function(message, type = 'info') {
            const $message = $(`<div class="archive-message archive-message-${type}">${message}</div>`);
            
            // Remove existing messages
            $('.archive-message').remove();
            
            // Add new message
            $('.archive-content').prepend($message);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                $message.fadeOut(300, () => $message.remove());
            }, 3000);
        },

        handleKeyboardNavigation: function(e) {
            // Add keyboard shortcuts for archive navigation
            if (e.ctrlKey || e.metaKey) {
                switch (e.keyCode) {
                    case 71: // Ctrl+G for grid view
                        e.preventDefault();
                        $('.view-btn[data-view="grid"]').click();
                        break;
                    case 76: // Ctrl+L for list view
                        e.preventDefault();
                        $('.view-btn[data-view="list"]').click();
                        break;
                }
            }
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        if ($('body').hasClass('oha-archive-page')) {
            OHAArchive.init();
        }
    });

})(jQuery);

/**
 * Additional CSS for archive functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    const archiveCSS = `
        <style id="oha-archive-styles">
        .archive-loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--oha-primary-green);
            z-index: 10;
        }
        
        .quick-share-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--oha-white);
            border: 1px solid var(--oha-light-gray);
            border-radius: 6px;
            box-shadow: var(--oha-shadow-md);
            padding: 10px;
            z-index: 1000;
            min-width: 150px;
        }
        
        .share-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            color: var(--oha-dark-gray);
            text-decoration: none;
            border-radius: 4px;
            transition: var(--oha-transition);
            font-size: 0.9rem;
        }
        
        .share-option:hover {
            background: #f8f9fa;
            color: var(--oha-primary-green);
        }
        
        .archive-message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }
        
        .archive-message-success {
            background: #d4edda;
            color: #155724;
            border-color: #28a745;
        }
        
        .archive-message-error {
            background: #f8d7da;
            color: #721c24;
            border-color: #dc3545;
        }
        
        .archive-message-info {
            background: #d1ecf1;
            color: #0c5460;
            border-color: #17a2b8;
        }
        
        .view-transitioning {
            opacity: 0.7;
            pointer-events: none;
        }
        
        .quick-bookmark-btn.bookmarked {
            color: var(--oha-primary-red) !important;
        }
        
        .oha-archive-card {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s ease;
        }
        
        .oha-archive-card.oha-fade-in {
            opacity: 1;
            transform: translateY(0);
        }
        </style>
    `;
    
    if ($('body').hasClass('oha-archive-page')) {
        document.head.insertAdjacentHTML('beforeend', archiveCSS);
    }
}); 