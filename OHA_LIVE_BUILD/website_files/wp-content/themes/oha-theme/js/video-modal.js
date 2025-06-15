/**
 * Video Modal Functionality
 * Handles opening videos in modal overlay for YouTube and Vimeo
 */

(function() {
    'use strict';

    console.log('Video modal script loaded');

    // Modal elements
    const modal = document.getElementById('video-modal');
    const modalOverlay = modal?.querySelector('.video-modal-overlay');
    const modalClose = modal?.querySelector('.video-modal-close');
    const videoPlayer = document.getElementById('video-player');
    
    if (!modal || !videoPlayer) {
        console.error('Missing modal elements:', { modal: !!modal, videoPlayer: !!videoPlayer });
        return;
    }

    console.log('Modal elements found successfully');

    // Function to open modal with video
    function openVideoModal(videoId, videoType, videoTitle = '') {
        console.log('Opening video modal:', { videoId, videoType, videoTitle });
        
        if (!videoId || !videoType) {
            console.error('Missing video data in openVideoModal');
            return;
        }

        let embedUrl = '';
        
        // Generate embed URL based on video type
        switch (videoType.toLowerCase()) {
            case 'youtube':
                embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0&modestbranding=1`;
                break;
            case 'vimeo':
                embedUrl = `https://player.vimeo.com/video/${videoId}?autoplay=1`;
                break;
            default:
                console.warn('Unsupported video type:', videoType);
                return;
        }

        console.log('Generated embed URL:', embedUrl);

        // Create iframe
        const iframe = document.createElement('iframe');
        iframe.src = embedUrl;
        iframe.title = videoTitle || 'Video Player';
        iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture';
        iframe.allowFullscreen = true;

        // Clear previous content and add new iframe
        videoPlayer.innerHTML = '';
        videoPlayer.appendChild(iframe);

        // Show modal
        modal.style.display = 'flex';
        document.body.classList.add('modal-open');
        
        // Focus trap for accessibility
        modalClose.focus();
        
        console.log('Modal opened successfully');
    }

    // Function to close modal
    function closeVideoModal() {
        console.log('Closing video modal');
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
        
        // Clear video content to stop playback
        videoPlayer.innerHTML = '';
    }

    // Event listeners for video play buttons
    function initVideoButtons() {
        const playButtons = document.querySelectorAll('.video-play-button');
        console.log('Found play buttons:', playButtons.length);
        
        playButtons.forEach((button, index) => {
            console.log(`Setting up button ${index}:`, button);
            
            button.addEventListener('click', function(e) {
                console.log('Play button clicked:', this);
                e.preventDefault();
                e.stopPropagation();
                
                // Get video data from parent article
                const videoCard = this.closest('.video-card');
                console.log('Video card found:', videoCard);
                
                if (!videoCard) {
                    console.error('No video card found');
                    return;
                }
                
                const videoId = videoCard.dataset.videoId;
                const videoType = videoCard.dataset.videoType;
                const titleElement = videoCard.querySelector('.video-card-title, .video-title-link');
                const videoTitle = titleElement?.textContent?.trim();
                
                console.log('Video data:', { videoId, videoType, videoTitle, titleElement });
                
                if (videoId && videoType) {
                    openVideoModal(videoId, videoType, videoTitle);
                } else {
                    console.error('Missing video data:', { videoId, videoType });
                    alert('Sorry, this video is not available for playback. Please check the video URL in the admin panel.');
                }
            });
            
            // Add keyboard support
            button.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    }

    // Modal close event listeners
    if (modalClose) {
        modalClose.addEventListener('click', closeVideoModal);
    }
    
    if (modalOverlay) {
        modalOverlay.addEventListener('click', closeVideoModal);
    }

    // Keyboard event listener for ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeVideoModal();
        }
    });

    // Prevent modal content clicks from closing modal
    const modalContent = modal?.querySelector('.video-modal-content');
    if (modalContent) {
        modalContent.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing video buttons');
            initVideoButtons();
        });
    } else {
        console.log('DOM already loaded, initializing video buttons immediately');
        initVideoButtons();
    }

    // Re-initialize when new content is loaded (for AJAX pagination, etc.)
    document.addEventListener('oha:videos-loaded', initVideoButtons);

})(); 