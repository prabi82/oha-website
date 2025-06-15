<?php
/**
 * Template part for displaying featured/sticky posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'oha-featured-card' ); ?>>
	
	<div class="featured-card-wrapper">
		
		<!-- Featured Image -->
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="featured-card-image">
				<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'oha-theme' ), get_the_title() ) ); ?>">
					<?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?>
					<div class="featured-overlay">
						<div class="featured-content-overlay">
							<span class="featured-badge">
								<i class="fas fa-star"></i>
								<?php esc_html_e( 'Featured', 'oha-theme' ); ?>
							</span>
							<h3 class="featured-title">
								<?php the_title(); ?>
							</h3>
							<div class="featured-excerpt">
								<?php echo wp_kses_post( wp_trim_words( get_the_excerpt() ?: get_the_content(), 20, '...' ) ); ?>
							</div>
							<div class="featured-meta">
								<span class="featured-date">
									<i class="far fa-calendar-alt"></i>
									<?php echo esc_html( get_the_date() ); ?>
								</span>
								<span class="featured-reading-time">
									<i class="fas fa-clock"></i>
									<?php echo oha_get_reading_time( get_the_content() ); ?> <?php esc_html_e( 'min read', 'oha-theme' ); ?>
								</span>
							</div>
							<div class="featured-cta">
								<span class="featured-read-more">
									<?php esc_html_e( 'Read Full Story', 'oha-theme' ); ?>
									<i class="fas fa-arrow-right"></i>
								</span>
							</div>
						</div>
					</div>
				</a>
			</div>
		<?php else : ?>
			<div class="featured-card-content-only">
				<div class="featured-content-wrapper">
					<span class="featured-badge">
						<i class="fas fa-star"></i>
						<?php esc_html_e( 'Featured', 'oha-theme' ); ?>
					</span>
					
					<header class="featured-header">
						<h3 class="featured-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark">
								<?php the_title(); ?>
							</a>
						</h3>
					</header>
					
					<div class="featured-meta">
						<div class="featured-date">
							<i class="far fa-calendar-alt" aria-hidden="true"></i>
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
							</time>
						</div>
						
						<?php
						$categories = get_the_category();
						if ( $categories ) :
						?>
							<div class="featured-category">
								<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="category-link">
									<i class="fas fa-folder" aria-hidden="true"></i>
									<?php echo esc_html( $categories[0]->name ); ?>
								</a>
							</div>
						<?php endif; ?>
						
						<div class="featured-reading-time">
							<i class="fas fa-clock"></i>
							<?php echo oha_get_reading_time( get_the_content() ); ?> <?php esc_html_e( 'min read', 'oha-theme' ); ?>
						</div>
					</div>
					
					<div class="featured-excerpt">
						<?php
						if ( has_excerpt() ) {
							the_excerpt();
						} else {
							echo wp_kses_post( wp_trim_words( get_the_content(), 30, '...' ) );
						}
						?>
					</div>
					
					<div class="featured-footer">
						<a href="<?php the_permalink(); ?>" class="featured-read-more-btn">
							<?php esc_html_e( 'Read Full Story', 'oha-theme' ); ?>
							<i class="fas fa-arrow-right" aria-hidden="true"></i>
						</a>
						
						<div class="featured-author">
							<div class="author-avatar">
								<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
							</div>
							<span class="author-name">
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
									<?php the_author(); ?>
								</a>
							</span>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		
	</div><!-- .featured-card-wrapper -->
	
</article><!-- #post-<?php the_ID(); ?> --> 