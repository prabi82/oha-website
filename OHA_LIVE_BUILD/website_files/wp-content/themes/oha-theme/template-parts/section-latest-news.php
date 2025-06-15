<?php
/**
 * Template part for displaying the latest news section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

// Get latest posts
$news_query = new WP_Query( array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 5,
	'meta_key'       => '_thumbnail_id',
	'orderby'        => 'date',
	'order'          => 'DESC'
) );
?>

<section class="oha-section oha-latest-news" id="latest-news">
	<div class="oha-container">
		
		<!-- Section Header -->
		<div class="oha-section-header">
			<h2 class="oha-section-title">
				<?php esc_html_e( 'Latest News', 'oha-theme' ); ?>
			</h2>
			<a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="view-all-link">
				<?php esc_html_e( 'VIEW ALL', 'oha-theme' ); ?>
				<span class="btn-arrow">→</span>
			</a>
		</div>
		
		<?php if ( $news_query->have_posts() ) : ?>
			<div class="news-grid-container">
				
				<!-- Top Row: 2 Featured/Larger News Items -->
				<div class="news-grid-featured">
					<?php 
					$post_count = 0;
					while ( $news_query->have_posts() && $post_count < 2 ) : 
						$news_query->the_post(); 
						$post_count++;
					?>
						<article class="news-card news-card-featured">
							
							<!-- News Card Link -->
							<a href="<?php the_permalink(); ?>" class="news-card-link" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'oha-theme' ), get_the_title() ) ); ?>">
								
								<!-- Featured Image Background -->
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="news-card-image" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');">
								<?php else : ?>
									<div class="news-card-image news-card-no-image">
								<?php endif; ?>
									
									<!-- Overlay -->
									<div class="news-card-overlay"></div>
									
									<!-- News Icon (positioned relative to card) -->
									<div class="news-card-icon">
										<span class="news-icon-text">N</span>
									</div>
									
									<!-- Content Overlay -->
									<div class="news-card-content">
										
										<!-- Date -->
										<div class="news-card-date">
											<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
												<?php echo esc_html( get_the_date( 'd M, Y' ) ); ?>
											</time>
										</div>
										
										<!-- Title -->
										<h3 class="news-card-title">
											<?php the_title(); ?>
										</h3>
										
									</div>
								</div>
								
							</a>
							
						</article>
					<?php endwhile; ?>
				</div>
				
				<!-- Bottom Row: 3 Regular/Smaller News Items -->
				<div class="news-grid-regular">
					<?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
						<article class="news-card news-card-regular">
							
							<!-- News Card Link -->
							<a href="<?php the_permalink(); ?>" class="news-card-link" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'oha-theme' ), get_the_title() ) ); ?>">
								
								<!-- Featured Image Background -->
								<?php if ( has_post_thumbnail() ) : ?>
									<div class="news-card-image" style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');">
								<?php else : ?>
									<div class="news-card-image news-card-no-image">
								<?php endif; ?>
									
									<!-- Overlay -->
									<div class="news-card-overlay"></div>
									
									<!-- News Icon (positioned relative to card) -->
									<div class="news-card-icon">
										<span class="news-icon-text">N</span>
									</div>
									
									<!-- Content Overlay -->
									<div class="news-card-content">
										
										<!-- Date -->
										<div class="news-card-date">
											<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
												<?php echo esc_html( get_the_date( 'd M, Y' ) ); ?>
											</time>
										</div>
										
										<!-- Title -->
										<h3 class="news-card-title">
											<?php the_title(); ?>
										</h3>
										
									</div>
								</div>
								
							</a>
							
						</article>
					<?php endwhile; ?>
				</div>
				
			</div>
			
		<?php else : ?>
			<!-- No posts found -->
			<div class="oha-no-content">
				<div class="oha-no-content-icon">
					<i class="far fa-newspaper" aria-hidden="true"></i>
				</div>
				<h3><?php esc_html_e( 'No News Available', 'oha-theme' ); ?></h3>
				<p><?php esc_html_e( 'Stay tuned for upcoming news and announcements from the Oman Hockey Association.', 'oha-theme' ); ?></p>
				
				<?php if ( current_user_can( 'publish_posts' ) ) : ?>
					<a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>" class="oha-btn oha-btn-primary">
						<?php esc_html_e( 'Add First Post', 'oha-theme' ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		
	</div>
</section>

<?php wp_reset_postdata(); ?> 