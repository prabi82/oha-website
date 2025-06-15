<?php
/**
 * Template part for displaying posts in archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'oha-archive-card' ); ?>>
	
	<!-- Post Image -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="archive-card-image">
			<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'oha-theme' ), get_the_title() ) ); ?>">
				<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
				<div class="image-overlay">
					<i class="fas fa-arrow-right"></i>
				</div>
			</a>
			
			<!-- Post Format Badge -->
			<?php if ( get_post_format() ) : ?>
				<div class="post-format-badge">
					<i class="fas fa-<?php echo get_post_format() === 'video' ? 'play' : ( get_post_format() === 'gallery' ? 'images' : 'file-alt' ); ?>"></i>
				</div>
			<?php endif; ?>
			
			<!-- Reading Time Badge -->
			<div class="reading-time-badge">
				<i class="fas fa-clock"></i>
				<?php echo oha_get_reading_time( get_the_content() ); ?> <?php esc_html_e( 'min', 'oha-theme' ); ?>
			</div>
		</div>
	<?php else : ?>
		<div class="archive-card-placeholder">
			<i class="fas fa-newspaper"></i>
		</div>
	<?php endif; ?>

	<div class="archive-card-content">
		
		<!-- Post Meta Top -->
		<div class="archive-card-meta-top">
			<div class="post-date">
				<i class="far fa-calendar-alt" aria-hidden="true"></i>
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
					<?php echo esc_html( get_the_date() ); ?>
				</time>
			</div>
			
			<?php
			$categories = get_the_category();
			if ( $categories ) :
			?>
				<div class="post-category">
					<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="category-link">
						<i class="fas fa-folder" aria-hidden="true"></i>
						<?php echo esc_html( $categories[0]->name ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>
		
		<!-- Post Title -->
		<header class="archive-card-header">
			<h2 class="archive-card-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark">
					<?php the_title(); ?>
				</a>
			</h2>
		</header>

		<!-- Post Excerpt -->
		<div class="archive-card-excerpt">
			<?php
			if ( has_excerpt() ) {
				the_excerpt();
			} else {
				echo wp_kses_post( wp_trim_words( get_the_content(), 25, '...' ) );
			}
			?>
		</div>
		
		<!-- Post Meta Bottom -->
		<div class="archive-card-meta-bottom">
			<div class="post-author">
				<div class="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
				</div>
				<div class="author-info">
					<span class="author-name">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
							<?php the_author(); ?>
						</a>
					</span>
				</div>
			</div>
			
			<div class="post-stats">
				<?php if ( comments_open() || get_comments_number() ) : ?>
					<div class="comments-count">
						<i class="far fa-comments" aria-hidden="true"></i>
						<span><?php echo get_comments_number(); ?></span>
					</div>
				<?php endif; ?>
				
				<?php if ( function_exists( 'oha_get_post_views' ) ) : ?>
					<div class="views-count">
						<i class="fas fa-eye" aria-hidden="true"></i>
						<span><?php echo get_post_meta( get_the_ID(), 'post_views_count', true ) ?: '0'; ?></span>
					</div>
				<?php endif; ?>
			</div>
		</div>
		
		<!-- Read More -->
		<div class="archive-card-footer">
			<a href="<?php the_permalink(); ?>" class="read-more-btn">
				<span><?php esc_html_e( 'Read Full Article', 'oha-theme' ); ?></span>
				<i class="fas fa-arrow-right" aria-hidden="true"></i>
			</a>
			
			<!-- Share Quick Actions -->
			<div class="quick-actions">
				<button class="quick-share-btn" data-url="<?php echo esc_url( get_permalink() ); ?>" data-title="<?php echo esc_attr( get_the_title() ); ?>" title="<?php esc_attr_e( 'Share', 'oha-theme' ); ?>">
					<i class="fas fa-share-alt"></i>
				</button>
				<button class="quick-bookmark-btn" data-post-id="<?php the_ID(); ?>" title="<?php esc_attr_e( 'Bookmark', 'oha-theme' ); ?>">
					<i class="far fa-bookmark"></i>
				</button>
			</div>
		</div>
		
	</div><!-- .archive-card-content -->
	
</article><!-- #post-<?php the_ID(); ?> --> 