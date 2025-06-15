<?php
/**
 * The template for displaying single video posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

get_header();
?>

<main class="oha-single-video">
	<div class="oha-container">
		
		<?php while ( have_posts() ) : the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-video-layout' ); ?>>
				
				<!-- Video Player Section -->
				<div class="video-player-section">
					<div class="video-player-wrapper">
						
						<?php
						$video_url = get_post_meta( get_the_ID(), '_oha_video_url', true );
						$video_embed = get_post_meta( get_the_ID(), '_oha_video_embed', true );
						$video_duration = get_post_meta( get_the_ID(), '_oha_video_duration', true );
						$video_type = get_post_meta( get_the_ID(), '_oha_video_type', true );
						
						if ( $video_embed ) :
							// Use custom embed code
							echo wp_kses_post( $video_embed );
						elseif ( $video_url ) :
							// Try to get oEmbed
							$embed = wp_oembed_get( $video_url );
							if ( $embed ) :
								echo $embed;
							else :
								// Fallback to simple video tag or iframe
								if ( strpos( $video_url, '.mp4' ) !== false || strpos( $video_url, '.webm' ) !== false ) :
								?>
									<video controls class="video-player" poster="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>">
										<source src="<?php echo esc_url( $video_url ); ?>" type="video/<?php echo pathinfo( $video_url, PATHINFO_EXTENSION ); ?>">
										<p><?php esc_html_e( 'Your browser does not support the video tag.', 'oha-theme' ); ?></p>
									</video>
								<?php else : ?>
									<iframe src="<?php echo esc_url( $video_url ); ?>" frameborder="0" allowfullscreen class="video-iframe"></iframe>
								<?php endif;
							endif;
						elseif ( has_post_thumbnail() ) :
						?>
							<div class="video-placeholder">
								<?php the_post_thumbnail( 'large' ); ?>
								<div class="video-placeholder-overlay">
									<div class="play-button-large">
										<i class="fas fa-play"></i>
									</div>
									<p><?php esc_html_e( 'Video player not available', 'oha-theme' ); ?></p>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- Video Controls -->
						<div class="video-controls-overlay">
							<div class="video-info-top">
								<?php if ( $video_duration ) : ?>
									<span class="video-duration-display">
										<i class="fas fa-clock"></i>
										<?php echo esc_html( $video_duration ); ?>
									</span>
								<?php endif; ?>
								
								<?php if ( $video_type ) : ?>
									<span class="video-type-badge">
										<i class="fas fa-tag"></i>
										<?php echo esc_html( ucfirst( $video_type ) ); ?>
									</span>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<!-- Video Content Section -->
				<div class="single-video-content">
					
					<!-- Video Header -->
					<header class="single-video-header">
						<h1 class="single-video-title"><?php the_title(); ?></h1>
						
						<div class="video-meta">
							<div class="video-meta-primary">
								<div class="meta-item">
									<i class="far fa-calendar-alt" aria-hidden="true"></i>
									<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
										<?php echo esc_html( get_the_date() ); ?>
									</time>
								</div>
								
								<div class="meta-item">
									<i class="fas fa-user" aria-hidden="true"></i>
									<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
										<?php the_author(); ?>
									</a>
								</div>
								
								<?php if ( $video_duration ) : ?>
									<div class="meta-item">
										<i class="fas fa-clock" aria-hidden="true"></i>
										<span><?php echo esc_html( $video_duration ); ?></span>
									</div>
								<?php endif; ?>
								
								<div class="meta-item">
									<i class="fas fa-eye" aria-hidden="true"></i>
									<span><?php echo get_post_meta( get_the_ID(), 'post_views_count', true ) ?: '0'; ?> <?php esc_html_e( 'views', 'oha-theme' ); ?></span>
								</div>
							</div>
							
							<!-- Video Social Share -->
							<div class="video-social-share">
								<span class="share-label">
									<i class="fas fa-share-alt"></i>
									<?php esc_html_e( 'Share:', 'oha-theme' ); ?>
								</span>
								<div class="social-share-buttons">
									<a href="#" class="share-btn facebook" data-platform="facebook" title="<?php esc_attr_e( 'Share on Facebook', 'oha-theme' ); ?>">
										<i class="fab fa-facebook-f"></i>
									</a>
									<a href="#" class="share-btn twitter" data-platform="twitter" title="<?php esc_attr_e( 'Share on Twitter', 'oha-theme' ); ?>">
										<i class="fab fa-twitter"></i>
									</a>
									<a href="#" class="share-btn linkedin" data-platform="linkedin" title="<?php esc_attr_e( 'Share on LinkedIn', 'oha-theme' ); ?>">
										<i class="fab fa-linkedin-in"></i>
									</a>
									<a href="#" class="share-btn whatsapp" data-platform="whatsapp" title="<?php esc_attr_e( 'Share on WhatsApp', 'oha-theme' ); ?>">
										<i class="fab fa-whatsapp"></i>
									</a>
								</div>
							</div>
						</div>
					</header>

					<!-- Video Description -->
					<div class="single-video-description">
						<?php
						the_content();
						
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oha-theme' ),
							'after'  => '</div>',
						) );
						?>
					</div>

					<!-- Video Details -->
					<div class="video-details-section">
						<h3><?php esc_html_e( 'Video Details', 'oha-theme' ); ?></h3>
						
						<div class="video-details-grid">
							<?php if ( $video_type ) : ?>
								<div class="detail-item">
									<strong><?php esc_html_e( 'Type:', 'oha-theme' ); ?></strong>
									<span><?php echo esc_html( ucfirst( $video_type ) ); ?></span>
								</div>
							<?php endif; ?>
							
							<?php if ( $video_duration ) : ?>
								<div class="detail-item">
									<strong><?php esc_html_e( 'Duration:', 'oha-theme' ); ?></strong>
									<span><?php echo esc_html( $video_duration ); ?></span>
								</div>
							<?php endif; ?>
							
							<div class="detail-item">
								<strong><?php esc_html_e( 'Published:', 'oha-theme' ); ?></strong>
								<span><?php echo esc_html( get_the_date() ); ?></span>
							</div>
							
							<div class="detail-item">
								<strong><?php esc_html_e( 'Author:', 'oha-theme' ); ?></strong>
								<span>
									<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
										<?php the_author(); ?>
									</a>
								</span>
							</div>
							
							<?php
							$video_categories = get_the_terms( get_the_ID(), 'video_category' );
							if ( $video_categories && ! is_wp_error( $video_categories ) ) :
							?>
								<div class="detail-item">
									<strong><?php esc_html_e( 'Categories:', 'oha-theme' ); ?></strong>
									<span>
										<?php
										$category_names = array();
										foreach ( $video_categories as $category ) {
											$category_names[] = '<a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
										}
										echo implode( ', ', $category_names );
										?>
									</span>
								</div>
							<?php endif; ?>
							
							<?php
							$video_tags = get_the_terms( get_the_ID(), 'video_tag' );
							if ( $video_tags && ! is_wp_error( $video_tags ) ) :
							?>
								<div class="detail-item">
									<strong><?php esc_html_e( 'Tags:', 'oha-theme' ); ?></strong>
									<span>
										<?php
										$tag_names = array();
										foreach ( $video_tags as $tag ) {
											$tag_names[] = '<a href="' . esc_url( get_term_link( $tag ) ) . '">' . esc_html( $tag->name ) . '</a>';
										}
										echo implode( ', ', $tag_names );
										?>
									</span>
								</div>
							<?php endif; ?>
						</div>
					</div>

					<!-- Video Actions -->
					<div class="video-actions">
						<button class="video-action-btn like-video" data-video-id="<?php the_ID(); ?>">
							<i class="far fa-heart"></i>
							<span><?php esc_html_e( 'Like', 'oha-theme' ); ?></span>
							<span class="like-count"><?php echo get_post_meta( get_the_ID(), 'video_likes', true ) ?: '0'; ?></span>
						</button>
						
						<button class="video-action-btn bookmark-video" data-video-id="<?php the_ID(); ?>">
							<i class="far fa-bookmark"></i>
							<span><?php esc_html_e( 'Save', 'oha-theme' ); ?></span>
						</button>
						
						<button class="video-action-btn download-video" data-video-url="<?php echo esc_attr( $video_url ); ?>">
							<i class="fas fa-download"></i>
							<span><?php esc_html_e( 'Download', 'oha-theme' ); ?></span>
						</button>
						
						<button class="video-action-btn share-video">
							<i class="fas fa-share"></i>
							<span><?php esc_html_e( 'Share', 'oha-theme' ); ?></span>
						</button>
					</div>
				</div>

				<!-- Video Navigation -->
				<nav class="video-navigation">
					<h3><?php esc_html_e( 'More Videos', 'oha-theme' ); ?></h3>
					<div class="video-nav-links">
						<?php
						$prev_video = get_previous_post( false, '', 'video_category' );
						$next_video = get_next_post( false, '', 'video_category' );
						
						if ( $prev_video ) :
						?>
							<div class="nav-video nav-previous">
								<a href="<?php echo esc_url( get_permalink( $prev_video->ID ) ); ?>" rel="prev">
									<div class="nav-video-content">
										<span class="nav-subtitle">
											<i class="fas fa-chevron-left"></i>
											<?php esc_html_e( 'Previous Video', 'oha-theme' ); ?>
										</span>
										<h4 class="nav-title"><?php echo esc_html( get_the_title( $prev_video->ID ) ); ?></h4>
									</div>
									<div class="nav-video-thumbnail">
										<?php echo get_the_post_thumbnail( $prev_video->ID, 'thumbnail' ); ?>
									</div>
								</a>
							</div>
						<?php endif; ?>
						
						<?php if ( $next_video ) : ?>
							<div class="nav-video nav-next">
								<a href="<?php echo esc_url( get_permalink( $next_video->ID ) ); ?>" rel="next">
									<div class="nav-video-thumbnail">
										<?php echo get_the_post_thumbnail( $next_video->ID, 'thumbnail' ); ?>
									</div>
									<div class="nav-video-content">
										<span class="nav-subtitle">
											<?php esc_html_e( 'Next Video', 'oha-theme' ); ?>
											<i class="fas fa-chevron-right"></i>
										</span>
										<h4 class="nav-title"><?php echo esc_html( get_the_title( $next_video->ID ) ); ?></h4>
									</div>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</nav>

				<!-- Related Videos -->
				<?php
				$related_videos = new WP_Query( array(
					'post_type' => 'oha_video',
					'posts_per_page' => 4,
					'post__not_in' => array( get_the_ID() ),
					'meta_query' => array(
						array(
							'key' => '_oha_video_url',
							'compare' => 'EXISTS',
						),
					),
					'orderby' => 'rand',
				) );
				
				if ( $related_videos->have_posts() ) :
				?>
					<section class="related-videos">
						<h3 class="related-videos-title">
							<i class="fas fa-video"></i>
							<?php esc_html_e( 'Related Videos', 'oha-theme' ); ?>
						</h3>
						<div class="related-videos-grid">
							<?php while ( $related_videos->have_posts() ) : $related_videos->the_post(); ?>
								<div class="related-video-item">
									<div class="related-video-thumbnail">
										<a href="<?php the_permalink(); ?>">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'medium' ); ?>
											<?php else : ?>
												<div class="video-placeholder-thumb">
													<i class="fas fa-video"></i>
												</div>
											<?php endif; ?>
											<div class="play-overlay">
												<i class="fas fa-play"></i>
											</div>
											<?php
											$duration = get_post_meta( get_the_ID(), '_oha_video_duration', true );
											if ( $duration ) :
											?>
												<span class="video-duration-thumb"><?php echo esc_html( $duration ); ?></span>
											<?php endif; ?>
										</a>
									</div>
									<div class="related-video-content">
										<h4 class="related-video-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h4>
										<div class="related-video-meta">
											<span class="video-date"><?php echo esc_html( get_the_date() ); ?></span>
											<span class="video-views"><?php echo get_post_meta( get_the_ID(), 'post_views_count', true ) ?: '0'; ?> <?php esc_html_e( 'views', 'oha-theme' ); ?></span>
										</div>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</section>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>

			</article>

		<?php endwhile; ?>
		
	</div>
</main>

<?php
get_footer(); 