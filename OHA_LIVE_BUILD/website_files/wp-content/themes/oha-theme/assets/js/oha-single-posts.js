/**
 * OHA Enhanced Single Posts JavaScript
 * Functionality for single video, event, and other post types
 */

(function($) {
    'use strict';

    // Single Posts Enhancement Object
    window.OHASinglePosts = {
        
        // Initialize
        init: function() {
            this.bindEvents();
            this.initializeFeatures();
        },

        // Bind events
        bindEvents: function() {
            
            // Video functionality
            $(document).on('click', '.like-video', this.handleVideoLike.bind(this));
            $(document).on('click', '.bookmark-video', this.handleVideoBookmark.bind(this));
            $(document).on('click', '.download-video', this.handleVideoDownload.bind(this));
            $(document).on('click', '.share-video', this.handleVideoShare.bind(this));
            
            // Event functionality
            $(document).on('click', '.rsvp-btn', this.handleEventRSVP.bind(this));
            $(document).on('click', '.add-to-calendar', this.handleAddToCalendar.bind(this));
            $(document).on('click', '.share-event', this.handleEventShare.bind(this));
            $(document).on('submit', '.event-registration-form', this.handleEventRegistration.bind(this));
            $(document).on('click', '.bookmark-event', this.handleEventBookmark.bind(this));
            
            // General functionality
            $(document).on('click', '.share-btn', this.handleSocialShare.bind(this));
            $(document).on('click', '.quick-bookmark-btn', this.handleQuickBookmark.bind(this));
            
            // Video player enhancements
            this.enhanceVideoPlayers();
        },

        // Initialize features
        initializeFeatures: function() {
            this.loadBookmarkStates();
            this.initializeShareButtons();
            this.setupVideoProgress();
            this.initializeEventCountdown();
        },

        // Video functionality
        handleVideoLike: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const videoId = $button.data('video-id');
            const $likeCount = $button.find('.like-count');
            
            if ($button.hasClass('liked')) {
                this.removeLike(videoId, $button, $likeCount);
            } else {
                this.addLike(videoId, $button, $likeCount);
            }
        },

        addLike: function(videoId, $button, $likeCount) {
            const likes = this.getLikes();
            
            if (!likes.includes(videoId)) {
                likes.push(videoId);
                localStorage.setItem('oha_video_likes', JSON.stringify(likes));
                
                $button.addClass('liked')
                       .find('i').removeClass('far').addClass('fas');
                
                const currentCount = parseInt($likeCount.text()) || 0;
                $likeCount.text(currentCount + 1);
                
                // Send AJAX request to update server-side count
                this.updateVideoLikeCount(videoId, 1);
                
                this.showMessage('Video liked!', 'success');
            }
        },

        removeLike: function(videoId, $button, $likeCount) {
            let likes = this.getLikes();
            likes = likes.filter(id => id !== videoId);
            
            localStorage.setItem('oha_video_likes', JSON.stringify(likes));
            
            $button.removeClass('liked')
                   .find('i').removeClass('fas').addClass('far');
            
            const currentCount = parseInt($likeCount.text()) || 0;
            $likeCount.text(Math.max(0, currentCount - 1));
            
            // Send AJAX request to update server-side count
            this.updateVideoLikeCount(videoId, -1);
            
            this.showMessage('Like removed!', 'info');
        },

        getLikes: function() {
            const likes = localStorage.getItem('oha_video_likes');
            return likes ? JSON.parse(likes) : [];
        },

        updateVideoLikeCount: function(videoId, increment) {
            if (typeof oha_ajax !== 'undefined') {
                $.ajax({
                    url: oha_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'oha_update_video_likes',
                        nonce: oha_ajax.nonce,
                        video_id: videoId,
                        increment: increment
                    }
                });
            }
        },

        handleVideoBookmark: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const videoId = $button.data('video-id');
            
            this.toggleBookmark(videoId, $button, 'video');
        },

        handleVideoDownload: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const videoUrl = $button.data('video-url');
            
            if (videoUrl) {
                // Create download link
                const link = document.createElement('a');
                link.href = videoUrl;
                link.download = 'video';
                link.target = '_blank';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                this.showMessage('Video download started!', 'success');
            } else {
                this.showMessage('Download not available for this video.', 'error');
            }
        },

        handleVideoShare: function(e) {
            e.preventDefault();
            
            const url = window.location.href;
            const title = document.title;
            
            this.showShareMenu($(e.currentTarget), url, title);
        },

        // Event functionality
        handleEventRSVP: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const eventId = $button.data('event-id');
            
            // Scroll to registration form
            const $registrationForm = $('.event-registration-section');
            if ($registrationForm.length) {
                $('html, body').animate({
                    scrollTop: $registrationForm.offset().top - 100
                }, 500);
                
                // Focus on first input
                setTimeout(() => {
                    $registrationForm.find('input:first').focus();
                }, 600);
            }
        },

        handleAddToCalendar: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const eventId = $button.data('event-id');
            
            this.showCalendarOptions($button, eventId);
        },

        showCalendarOptions: function($button, eventId) {
            const $menu = $(`
                <div class="calendar-options-menu">
                    <a href="#" class="calendar-option" data-type="google">
                        <i class="fab fa-google"></i> Google Calendar
                    </a>
                    <a href="#" class="calendar-option" data-type="outlook">
                        <i class="fab fa-microsoft"></i> Outlook
                    </a>
                    <a href="#" class="calendar-option" data-type="ical">
                        <i class="fas fa-calendar"></i> iCal
                    </a>
                    <a href="#" class="calendar-option" data-type="yahoo">
                        <i class="fab fa-yahoo"></i> Yahoo
                    </a>
                </div>
            `);
            
            // Remove existing menus
            $('.calendar-options-menu').remove();
            
            // Position and show menu
            $button.parent().css('position', 'relative').append($menu);
            
            // Handle calendar option clicks
            $menu.on('click', '.calendar-option', (e) => {
                e.preventDefault();
                const type = $(e.currentTarget).data('type');
                this.generateCalendarLink(type, eventId);
                $menu.fadeOut(200, () => $menu.remove());
            });
            
            // Close menu when clicking outside
            setTimeout(() => {
                $(document).one('click', () => {
                    $menu.fadeOut(200, () => $menu.remove());
                });
            }, 100);
        },

        generateCalendarLink: function(type, eventId) {
            // Get event details from the page
            const title = $('.single-event-title').text();
            const location = $('.meta-item:contains("Location")').find('span').text();
            const dateTime = this.getEventDateTime();
            
            let calendarUrl = '';
            
            switch (type) {
                case 'google':
                    calendarUrl = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(title)}&dates=${dateTime.start}/${dateTime.end}&location=${encodeURIComponent(location)}`;
                    break;
                case 'outlook':
                    calendarUrl = `https://outlook.live.com/calendar/0/deeplink/compose?subject=${encodeURIComponent(title)}&startdt=${dateTime.start}&enddt=${dateTime.end}&location=${encodeURIComponent(location)}`;
                    break;
                case 'ical':
                    this.generateICalFile(title, dateTime, location);
                    return;
                case 'yahoo':
                    calendarUrl = `https://calendar.yahoo.com/?v=60&view=d&type=20&title=${encodeURIComponent(title)}&st=${dateTime.start}&et=${dateTime.end}&in_loc=${encodeURIComponent(location)}`;
                    break;
            }
            
            if (calendarUrl) {
                window.open(calendarUrl, '_blank');
            }
        },

        getEventDateTime: function() {
            // Extract date and time from the page
            const dateElement = $('.meta-item time').attr('datetime');
            const timeElement = $('.meta-item:contains("Time")').find('span').text();
            
            // Format for calendar services (YYYYMMDDTHHMMSSZ)
            const date = new Date(dateElement);
            if (timeElement) {
                // Parse time and set it
                const timeParts = timeElement.match(/(\d{1,2}):(\d{2})\s*(AM|PM)?/i);
                if (timeParts) {
                    let hours = parseInt(timeParts[1]);
                    const minutes = parseInt(timeParts[2]);
                    const ampm = timeParts[3];
                    
                    if (ampm && ampm.toUpperCase() === 'PM' && hours < 12) {
                        hours += 12;
                    } else if (ampm && ampm.toUpperCase() === 'AM' && hours === 12) {
                        hours = 0;
                    }
                    
                    date.setHours(hours, minutes);
                }
            }
            
            const endDate = new Date(date);
            endDate.setHours(endDate.getHours() + 2); // Default 2-hour duration
            
            return {
                start: this.formatDateForCalendar(date),
                end: this.formatDateForCalendar(endDate)
            };
        },

        formatDateForCalendar: function(date) {
            return date.toISOString().replace(/[:-]/g, '').replace(/\.\d{3}/, '');
        },

        generateICalFile: function(title, dateTime, location) {
            const icalContent = [
                'BEGIN:VCALENDAR',
                'VERSION:2.0',
                'PRODID:-//OHA//Event Calendar//EN',
                'BEGIN:VEVENT',
                `DTSTART:${dateTime.start}`,
                `DTEND:${dateTime.end}`,
                `SUMMARY:${title}`,
                `LOCATION:${location}`,
                'END:VEVENT',
                'END:VCALENDAR'
            ].join('\r\n');
            
            const blob = new Blob([icalContent], { type: 'text/calendar' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'event.ics';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },

        handleEventShare: function(e) {
            e.preventDefault();
            
            const url = window.location.href;
            const title = $('.single-event-title').text();
            
            this.showShareMenu($(e.currentTarget), url, title);
        },

        handleEventRegistration: function(e) {
            e.preventDefault();
            
            const $form = $(e.currentTarget);
            const $submitBtn = $form.find('.submit-btn');
            const eventId = $form.data('event-id');
            
            // Validate form
            if (!this.validateRegistrationForm($form)) {
                return false;
            }
            
            // Show loading state
            this.setLoadingState($submitBtn, true);
            
            // Prepare form data
            const formData = {
                action: 'oha_event_registration',
                event_id: eventId,
                registration_name: $form.find('[name="registration_name"]').val(),
                registration_email: $form.find('[name="registration_email"]').val(),
                registration_phone: $form.find('[name="registration_phone"]').val(),
                registration_guests: $form.find('[name="registration_guests"]').val(),
                registration_notes: $form.find('[name="registration_notes"]').val(),
                registration_nonce: $form.find('[name="registration_nonce"]').val()
            };
            
            // Submit registration
            if (typeof oha_ajax !== 'undefined') {
                $.ajax({
                    url: oha_ajax.ajax_url,
                    type: 'POST',
                    data: formData,
                    success: (response) => {
                        if (response.success) {
                            this.showFormMessage($form, response.data.message, 'success');
                            $form[0].reset();
                        } else {
                            this.showFormMessage($form, response.data.message || 'Registration failed. Please try again.', 'error');
                        }
                    },
                    error: () => {
                        this.showFormMessage($form, 'Connection error. Please try again.', 'error');
                    },
                    complete: () => {
                        this.setLoadingState($submitBtn, false);
                    }
                });
            }
            
            return false;
        },

        validateRegistrationForm: function($form) {
            const name = $form.find('[name="registration_name"]').val().trim();
            const email = $form.find('[name="registration_email"]').val().trim();
            
            if (!name) {
                this.showFormMessage($form, 'Please enter your full name.', 'error');
                $form.find('[name="registration_name"]').focus();
                return false;
            }
            
            if (!email || !this.isValidEmail(email)) {
                this.showFormMessage($form, 'Please enter a valid email address.', 'error');
                $form.find('[name="registration_email"]').focus();
                return false;
            }
            
            return true;
        },

        isValidEmail: function(email) {
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        },

        handleEventBookmark: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const eventId = $button.data('event-id');
            
            this.toggleBookmark(eventId, $button, 'event');
        },

        // General functionality
        handleSocialShare: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const platform = $button.data('platform');
            const url = window.location.href;
            const title = document.title;
            
            this.shareOnPlatform(platform, url, title);
        },

        shareOnPlatform: function(platform, url, title) {
            const shareUrls = {
                facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
                twitter: `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`,
                linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`,
                whatsapp: `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`
            };
            
            if (shareUrls[platform]) {
                window.open(shareUrls[platform], '_blank', 'width=600,height=400,scrollbars=yes,resizable=yes');
            }
        },

        showShareMenu: function($button, url, title) {
            const shareUrls = {
                facebook: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`,
                twitter: `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`,
                linkedin: `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`,
                whatsapp: `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`
            };
            
            const $menu = $(`
                <div class="share-menu">
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
                    <button class="share-option copy-link" data-url="${url}">
                        <i class="fas fa-link"></i> Copy Link
                    </button>
                </div>
            `);
            
            // Remove existing menus
            $('.share-menu').remove();
            
            // Position and show menu
            $button.parent().css('position', 'relative').append($menu);
            
            // Handle copy link
            $menu.on('click', '.copy-link', (e) => {
                e.preventDefault();
                this.copyToClipboard(url);
                $menu.fadeOut(200, () => $menu.remove());
            });
            
            // Close menu when clicking outside
            setTimeout(() => {
                $(document).one('click', () => {
                    $menu.fadeOut(200, () => $menu.remove());
                });
            }, 100);
        },

        copyToClipboard: function(text) {
            navigator.clipboard.writeText(text).then(() => {
                this.showMessage('Link copied to clipboard!', 'success');
            }).catch(() => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                this.showMessage('Link copied to clipboard!', 'success');
            });
        },

        handleQuickBookmark: function(e) {
            e.preventDefault();
            
            const $button = $(e.currentTarget);
            const postId = $button.data('post-id') || $button.data('video-id') || $button.data('event-id');
            const postType = $button.closest('[class*="single-"]').length ? 'general' : 'post';
            
            this.toggleBookmark(postId, $button, postType);
        },

        toggleBookmark: function(itemId, $button, type) {
            const bookmarks = this.getBookmarks(type);
            const isBookmarked = bookmarks.includes(itemId);
            
            if (isBookmarked) {
                this.removeBookmark(itemId, $button, type);
            } else {
                this.addBookmark(itemId, $button, type);
            }
        },

        addBookmark: function(itemId, $button, type) {
            const bookmarks = this.getBookmarks(type);
            
            if (!bookmarks.includes(itemId)) {
                bookmarks.push(itemId);
                localStorage.setItem(`oha_${type}_bookmarks`, JSON.stringify(bookmarks));
                
                $button.addClass('bookmarked')
                       .find('i').removeClass('far').addClass('fas');
                
                this.showMessage('Bookmarked!', 'success');
            }
        },

        removeBookmark: function(itemId, $button, type) {
            let bookmarks = this.getBookmarks(type);
            bookmarks = bookmarks.filter(id => id !== itemId);
            
            localStorage.setItem(`oha_${type}_bookmarks`, JSON.stringify(bookmarks));
            
            $button.removeClass('bookmarked')
                   .find('i').removeClass('fas').addClass('far');
            
            this.showMessage('Bookmark removed!', 'info');
        },

        getBookmarks: function(type) {
            const bookmarks = localStorage.getItem(`oha_${type}_bookmarks`);
            return bookmarks ? JSON.parse(bookmarks) : [];
        },

        loadBookmarkStates: function() {
            // Load video bookmarks
            const videoBookmarks = this.getBookmarks('video');
            videoBookmarks.forEach(videoId => {
                $(`.bookmark-video[data-video-id="${videoId}"]`)
                    .addClass('bookmarked')
                    .find('i').removeClass('far').addClass('fas');
            });
            
            // Load event bookmarks
            const eventBookmarks = this.getBookmarks('event');
            eventBookmarks.forEach(eventId => {
                $(`.bookmark-event[data-event-id="${eventId}"]`)
                    .addClass('bookmarked')
                    .find('i').removeClass('far').addClass('fas');
            });
            
            // Load video likes
            const videoLikes = this.getLikes();
            videoLikes.forEach(videoId => {
                $(`.like-video[data-video-id="${videoId}"]`)
                    .addClass('liked')
                    .find('i').removeClass('far').addClass('fas');
            });
        },

        initializeShareButtons: function() {
            // Add click tracking to share buttons
            $('.share-btn').on('click', function(e) {
                const platform = $(this).data('platform');
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'share', {
                        method: platform,
                        content_type: 'post',
                        item_id: document.body.className.match(/postid-(\d+)/)?.[1] || 'unknown'
                    });
                }
            });
        },

        enhanceVideoPlayers: function() {
            // Add custom controls and features to video players
            $('video.video-player').each(function() {
                const video = this;
                const $video = $(video);
                
                // Add loading state
                video.addEventListener('loadstart', () => {
                    $video.addClass('loading');
                });
                
                video.addEventListener('canplay', () => {
                    $video.removeClass('loading');
                });
                
                // Track viewing progress
                video.addEventListener('timeupdate', () => {
                    const progress = (video.currentTime / video.duration) * 100;
                    if (progress > 25 && !video.dataset.quarter) {
                        video.dataset.quarter = true;
                        this.trackVideoProgress(video, 25);
                    }
                    if (progress > 50 && !video.dataset.half) {
                        video.dataset.half = true;
                        this.trackVideoProgress(video, 50);
                    }
                    if (progress > 75 && !video.dataset.threeQuarter) {
                        video.dataset.threeQuarter = true;
                        this.trackVideoProgress(video, 75);
                    }
                });
                
                video.addEventListener('ended', () => {
                    this.trackVideoProgress(video, 100);
                });
            }.bind(this));
        },

        setupVideoProgress: function() {
            // Initialize video progress tracking
            if ($('video.video-player').length && typeof oha_ajax !== 'undefined') {
                this.trackVideoView();
            }
        },

        trackVideoView: function() {
            const videoId = $('.oha-single-video article').attr('id')?.replace('post-', '');
            if (videoId) {
                $.ajax({
                    url: oha_ajax.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'oha_track_video_view',
                        nonce: oha_ajax.nonce,
                        video_id: videoId
                    }
                });
            }
        },

        trackVideoProgress: function(video, percentage) {
            if (typeof gtag !== 'undefined') {
                gtag('event', 'video_progress', {
                    video_title: document.title,
                    video_percent: percentage
                });
            }
        },

        initializeEventCountdown: function() {
            // Add countdown timer for upcoming events
            const $eventDate = $('.single-event-header time');
            if ($eventDate.length) {
                const eventDateTime = $eventDate.attr('datetime');
                const eventTime = $('.meta-item:contains("Time")').find('span').text();
                
                if (eventDateTime) {
                    this.setupCountdownTimer(eventDateTime, eventTime);
                }
            }
        },

        setupCountdownTimer: function(dateTime, time) {
            const eventDate = new Date(dateTime);
            if (time) {
                // Parse and set time
                const timeParts = time.match(/(\d{1,2}):(\d{2})\s*(AM|PM)?/i);
                if (timeParts) {
                    let hours = parseInt(timeParts[1]);
                    const minutes = parseInt(timeParts[2]);
                    const ampm = timeParts[3];
                    
                    if (ampm && ampm.toUpperCase() === 'PM' && hours < 12) {
                        hours += 12;
                    } else if (ampm && ampm.toUpperCase() === 'AM' && hours === 12) {
                        hours = 0;
                    }
                    
                    eventDate.setHours(hours, minutes);
                }
            }
            
            const now = new Date();
            if (eventDate > now) {
                this.createCountdownDisplay(eventDate);
            }
        },

        createCountdownDisplay: function(eventDate) {
            const $countdown = $(`
                <div class="event-countdown">
                    <h4>Event starts in:</h4>
                    <div class="countdown-timer">
                        <div class="countdown-item">
                            <span class="countdown-number days">0</span>
                            <span class="countdown-label">Days</span>
                        </div>
                        <div class="countdown-item">
                            <span class="countdown-number hours">0</span>
                            <span class="countdown-label">Hours</span>
                        </div>
                        <div class="countdown-item">
                            <span class="countdown-number minutes">0</span>
                            <span class="countdown-label">Minutes</span>
                        </div>
                        <div class="countdown-item">
                            <span class="countdown-number seconds">0</span>
                            <span class="countdown-label">Seconds</span>
                        </div>
                    </div>
                </div>
            `);
            
            $('.event-actions-header').before($countdown);
            
            const updateCountdown = () => {
                const now = new Date();
                const difference = eventDate - now;
                
                if (difference > 0) {
                    const days = Math.floor(difference / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((difference % (1000 * 60)) / 1000);
                    
                    $countdown.find('.days').text(days);
                    $countdown.find('.hours').text(hours);
                    $countdown.find('.minutes').text(minutes);
                    $countdown.find('.seconds').text(seconds);
                } else {
                    $countdown.html('<h4>Event has started!</h4>');
                }
            };
            
            updateCountdown();
            setInterval(updateCountdown, 1000);
        },

        // Utility functions
        setLoadingState: function($button, isLoading) {
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

        showFormMessage: function($form, message, type) {
            const $messages = $form.find('.form-messages');
            $messages.removeClass('success error info').addClass(type);
            $messages.html(message).fadeIn();
            
            setTimeout(() => {
                $messages.fadeOut();
            }, 5000);
        },

        showMessage: function(message, type = 'info') {
            const $message = $(`<div class="oha-notification oha-notification-${type}">${message}</div>`);
            
            // Remove existing notifications
            $('.oha-notification').remove();
            
            // Add new notification
            $('body').append($message);
            
            // Show and auto-hide
            $message.fadeIn(300);
            setTimeout(() => {
                $message.fadeOut(300, () => $message.remove());
            }, 3000);
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        if ($('.oha-single-video, .oha-single-event').length) {
            OHASinglePosts.init();
        }
    });

})(jQuery);

/**
 * Additional CSS for enhanced functionality
 */
document.addEventListener('DOMContentLoaded', function() {
    const singlePostsCSS = `
        <style id="oha-single-posts-styles">
        .share-menu,
        .calendar-options-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--oha-white);
            border: 1px solid var(--oha-light-gray);
            border-radius: 6px;
            box-shadow: var(--oha-shadow-md);
            padding: 10px;
            z-index: 1000;
            min-width: 180px;
        }
        
        .share-option,
        .calendar-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            color: var(--oha-dark-gray);
            text-decoration: none;
            border-radius: 4px;
            transition: var(--oha-transition);
            font-size: 0.9rem;
            border: none;
            background: none;
            width: 100%;
            cursor: pointer;
        }
        
        .share-option:hover,
        .calendar-option:hover {
            background: #f8f9fa;
            color: var(--oha-primary-green);
        }
        
        .oha-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 6px;
            color: var(--oha-white);
            font-weight: var(--oha-font-medium);
            z-index: 10000;
            box-shadow: var(--oha-shadow-lg);
            display: none;
        }
        
        .oha-notification-success {
            background: #28a745;
        }
        
        .oha-notification-error {
            background: #dc3545;
        }
        
        .oha-notification-info {
            background: #17a2b8;
        }
        
        .video-action-btn.liked,
        .bookmark-video.bookmarked,
        .bookmark-event.bookmarked {
            color: var(--oha-primary-red) !important;
        }
        
        .event-countdown {
            background: linear-gradient(135deg, var(--oha-primary-green), var(--oha-primary-red));
            color: var(--oha-white);
            padding: 20px;
            border-radius: 12px;
            margin: 20px 0;
            text-align: center;
        }
        
        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
        }
        
        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 60px;
        }
        
        .countdown-number {
            font-size: 2rem;
            font-weight: var(--oha-font-bold);
            line-height: 1;
        }
        
        .countdown-label {
            font-size: 0.8rem;
            margin-top: 5px;
            opacity: 0.9;
        }
        
        .capacity-bar {
            width: 100%;
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            margin: 8px 0;
            overflow: hidden;
        }
        
        .capacity-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--oha-primary-green), var(--oha-primary-red));
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        
        .capacity-warning {
            color: var(--oha-primary-red);
            font-weight: var(--oha-font-medium);
            font-size: 0.9rem;
        }
        
        .video-player.loading {
            opacity: 0.7;
            pointer-events: none;
        }
        
        @media (max-width: 768px) {
            .countdown-timer {
                gap: 10px;
            }
            
            .countdown-item {
                min-width: 50px;
            }
            
            .countdown-number {
                font-size: 1.5rem;
            }
            
            .oha-notification {
                left: 20px;
                right: 20px;
                top: 20px;
            }
        }
        </style>
    `;
    
    if ($('.oha-single-video, .oha-single-event').length) {
        document.head.insertAdjacentHTML('beforeend', singlePostsCSS);
    }
}); 