<?php
/**
 * Template part for displaying the latest videos section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

// Get latest videos using our helper function - limit to 3 videos total
$videos_query = oha_get_videos( array( 'posts_per_page' => 3 ) );
?>

<section class="oha-section oha-latest-videos" id="latest-videos">
	<div class="oha-container">
		
		<!-- Section Header -->
		<div class="oha-section-header">
			<div class="section-title-wrapper">
				<h2 class="oha-section-title">
					<?php esc_html_e( 'Latest Videos', 'oha-theme' ); ?>
				</h2>
				<div class="oha-section-subtitle">
					<?php esc_html_e( 'Watch highlights, training sessions, player interviews, and behind-the-scenes content from Oman hockey.', 'oha-theme' ); ?>
				</div>
			</div>
			<div class="section-header-actions">
				<a href="<?php echo esc_url( home_url( '/video' ) ); ?>" class="view-all-btn">
					<?php esc_html_e( 'View All Videos', 'oha-theme' ); ?>
					<span class="btn-arrow">▶</span>
				</a>
			</div>
		</div>
		
		<?php if ( $videos_query->have_posts() ) : ?>
			<div class="videos-layout">
				
				<?php 
				$video_count = 0;
				while ( $videos_query->have_posts() ) : $videos_query->the_post(); 
					$video_count++;
					
					// Get video metadata
					$video_url = get_post_meta( get_the_ID(), '_oha_video_url', true );
					$video_duration = get_post_meta( get_the_ID(), '_oha_video_duration', true );
					$video_type = get_post_meta( get_the_ID(), '_oha_video_type', true ) ?: 'youtube';
					
					// Extract video ID from URL
					$video_id = '';
					if ( $video_url ) {
						if ( strpos( $video_url, 'youtube.com' ) !== false || strpos( $video_url, 'youtu.be' ) !== false ) {
							preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $matches );
							$video_id = isset( $matches[1] ) ? $matches[1] : '';
							$video_type = 'youtube';
						} elseif ( strpos( $video_url, 'vimeo.com' ) !== false ) {
							preg_match( '/vimeo\.com\/(\d+)/', $video_url, $matches );
							$video_id = isset( $matches[1] ) ? $matches[1] : '';
							$video_type = 'vimeo';
						}
					}
					
					// Determine card class based on position (first video gets featured treatment)
					$card_class = 'video-card';
					if ( $video_count === 1 ) {
						$card_class .= ' video-card-featured';
					}
				?>
					
					<article class="<?php echo esc_attr( $card_class ); ?>" data-video-id="<?php echo esc_attr( $video_id ); ?>" data-video-type="<?php echo esc_attr( $video_type ); ?>">
						
						<!-- Video Thumbnail -->
						<div class="video-thumbnail">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
							<?php elseif ( $video_id && $video_type === 'youtube' ) : ?>
								<img src="https://img.youtube.com/vi/<?php echo esc_attr( $video_id ); ?>/maxresdefault.jpg" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
							<?php else : ?>
								<div class="video-placeholder">
									<span class="video-placeholder-icon">V</span>
								</div>
							<?php endif; ?>
							
							<!-- Play Button -->
							<div class="video-play-button" role="button" tabindex="0" aria-label="<?php echo esc_attr( sprintf( __( 'Play video: %s', 'oha-theme' ), get_the_title() ) ); ?>">
								<span class="play-icon">▶</span>
							</div>
							
							<!-- Duration Badge -->
							<?php if ( $video_duration ) : ?>
								<div class="video-duration">
									<?php echo esc_html( $video_duration ); ?>
								</div>
							<?php endif; ?>
							
							<!-- Video Type Badge -->
							<?php if ( $video_type ) : ?>
								<div class="video-type-badge">
									<?php echo esc_html( ucfirst( str_replace( '_', ' ', $video_type ) ) ); ?>
								</div>
							<?php endif; ?>
							
							<!-- Publish Date Badge (only for featured video) -->
							<?php if ( $video_count === 1 ) : ?>
								<div class="video-publish-date-badge">
									<span class="date-icon">📅</span>
									<time datetime="<?php echo esc_attr( oha_get_video_publish_date() ); ?>">
										<?php 
										$video_publish_date = oha_get_video_publish_date();
										echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $video_publish_date ) ) );
										?>
									</time>
								</div>
							<?php endif; ?>
						</div>
						
						<!-- Video Content -->
						<div class="video-card-content">
							
							<!-- Title -->
							<h3 class="video-card-title">
								<a href="<?php echo esc_url( home_url( '/video' ) ); ?>" class="video-title-link">
									<?php the_title(); ?>
								</a>
							</h3>
							
							<!-- Category (only for featured video) -->
							<?php if ( $video_count === 1 ) : ?>
								<?php
								$video_categories = get_the_terms( get_the_ID(), 'video_category' );
								if ( $video_categories && ! is_wp_error( $video_categories ) ) :
									$category = $video_categories[0];
								?>
									<div class="video-card-meta">
										<span class="video-card-category">
											<span class="category-icon">#</span>
											<?php echo esc_html( $category->name ); ?>
										</span>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							
						</div>
						
					</article>
				<?php endwhile; ?>
			</div>
			
		<?php else : ?>
			<!-- No videos found -->
			<div class="oha-no-content">
				<div class="oha-no-content-icon">
					<span class="no-content-video-icon">📹</span>
				</div>
				<h3><?php esc_html_e( 'No Videos Available', 'oha-theme' ); ?></h3>
				<p><?php esc_html_e( 'Check back soon for exciting hockey videos, match highlights, and player interviews.', 'oha-theme' ); ?></p>
				
				<?php if ( current_user_can( 'edit_posts' ) ) : ?>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=oha_video' ) ); ?>" class="oha-btn oha-btn-primary">
						<?php esc_html_e( 'Add First Video', 'oha-theme' ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		
	</div>
</section>

<?php wp_reset_postdata(); ?> 