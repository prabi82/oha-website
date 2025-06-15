<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'oha-search-result' ); ?>>
	
	<div class="search-result-content">
		
		<header class="search-result-header">
			<?php the_title( sprintf( '<h2 class="search-result-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
			
			<div class="search-result-meta">
				<div class="meta-item meta-type">
					<i class="fas fa-tag" aria-hidden="true"></i>
					<?php
					$post_type = get_post_type();
					$post_type_object = get_post_type_object( $post_type );
					
					if ( $post_type_object ) {
						echo esc_html( $post_type_object->labels->singular_name );
					}
					?>
				</div>
				
				<?php if ( 'post' === get_post_type() ) : ?>
					<div class="meta-item meta-date">
						<i class="far fa-calendar-alt" aria-hidden="true"></i>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
					</div>
				<?php endif; ?>
				
				<?php
				// Show category for posts
				if ( 'post' === get_post_type() ) {
					$categories = get_the_category();
					if ( $categories ) :
					?>
						<div class="meta-item meta-category">
							<i class="fas fa-folder" aria-hidden="true"></i>
							<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="category-link">
								<?php echo esc_html( $categories[0]->name ); ?>
							</a>
						</div>
					<?php endif;
				}
				
				// Show video category for videos
				if ( 'oha_video' === get_post_type() ) {
					$video_categories = get_the_terms( get_the_ID(), 'video_category' );
					if ( $video_categories && ! is_wp_error( $video_categories ) ) :
					?>
						<div class="meta-item meta-category">
							<i class="fas fa-video" aria-hidden="true"></i>
							<a href="<?php echo esc_url( get_term_link( $video_categories[0] ) ); ?>" class="category-link">
								<?php echo esc_html( $video_categories[0]->name ); ?>
							</a>
						</div>
					<?php endif;
				}
				?>
			</div>
		</header><!-- .search-result-header -->

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="search-result-image">
				<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'oha-theme' ), get_the_title() ) ); ?>">
					<?php the_post_thumbnail( 'medium', array( 'loading' => 'lazy' ) ); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="search-result-excerpt">
			<?php
			// Custom excerpt for different post types
			if ( has_excerpt() ) {
				echo '<p>' . esc_html( get_the_excerpt() ) . '</p>';
			} else {
				// Get content excerpt
				$content = get_the_content();
				$content = wp_strip_all_tags( $content );
				$excerpt = wp_trim_words( $content, 30, '...' );
				
				if ( $excerpt ) {
					echo '<p>' . esc_html( $excerpt ) . '</p>';
				}
			}
			?>
		</div><!-- .search-result-excerpt -->

		<div class="search-result-footer">
			<a href="<?php the_permalink(); ?>" class="read-more-link">
				<?php
				$post_type = get_post_type();
				switch ( $post_type ) {
					case 'oha_video':
						esc_html_e( 'Watch Video', 'oha-theme' );
						echo ' <i class="fas fa-play" aria-hidden="true"></i>';
						break;
					case 'team_member':
						esc_html_e( 'View Profile', 'oha-theme' );
						echo ' <i class="fas fa-user" aria-hidden="true"></i>';
						break;
					case 'event':
						esc_html_e( 'Event Details', 'oha-theme' );
						echo ' <i class="fas fa-calendar" aria-hidden="true"></i>';
						break;
					case 'page':
						esc_html_e( 'Read More', 'oha-theme' );
						echo ' <i class="fas fa-arrow-right" aria-hidden="true"></i>';
						break;
					default:
						esc_html_e( 'Read Article', 'oha-theme' );
						echo ' <i class="fas fa-arrow-right" aria-hidden="true"></i>';
						break;
				}
				?>
			</a>
		</div>
		
	</div><!-- .search-result-content -->
	
</article><!-- #post-<?php the_ID(); ?> -->
