<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'oha-post-card' ); ?>>
	
	<?php if ( has_post_thumbnail() && ! is_singular() ) : ?>
		<div class="post-card-image">
			<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'oha-theme' ), get_the_title() ) ); ?>">
				<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="post-card-content">
		
		<header class="entry-header">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
				<div class="entry-meta">
					<div class="meta-item meta-date">
						<i class="far fa-calendar-alt" aria-hidden="true"></i>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
							<?php echo esc_html( get_the_date() ); ?>
						</time>
					</div>
					
					<?php if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
						<div class="meta-item meta-comments">
							<i class="far fa-comments" aria-hidden="true"></i>
							<?php
							comments_popup_link(
								esc_html__( 'Leave a comment', 'oha-theme' ),
								esc_html__( '1 Comment', 'oha-theme' ),
								esc_html__( '% Comments', 'oha-theme' )
							);
							?>
						</div>
					<?php endif; ?>
					
					<?php
					$categories = get_the_category();
					if ( $categories && ! is_singular() ) :
					?>
						<div class="meta-item meta-category">
							<i class="fas fa-tag" aria-hidden="true"></i>
							<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="category-link">
								<?php echo esc_html( $categories[0]->name ); ?>
							</a>
						</div>
					<?php endif; ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php if ( has_post_thumbnail() && is_singular() ) : ?>
			<div class="single-post-image">
				<?php the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="entry-content">
			<?php
			if ( is_singular() ) :
				the_content();
			else :
				// Show excerpt for archive/blog pages
				if ( has_excerpt() ) {
					the_excerpt();
				} else {
					echo wp_kses_post( wp_trim_words( get_the_content(), 25, '...' ) );
				}
			endif;

			if ( is_singular() ) :
				wp_link_pages(
					array(
						'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'oha-theme' ) . '</span>',
						'after'  => '</div>',
					)
				);
			endif;
			?>
		</div><!-- .entry-content -->

		<?php if ( ! is_singular() ) : ?>
			<div class="entry-readmore">
				<a href="<?php the_permalink(); ?>" class="read-more-link">
					<?php esc_html_e( 'Read More', 'oha-theme' ); ?>
					<i class="fas fa-arrow-right" aria-hidden="true"></i>
				</a>
			</div>
		<?php endif; ?>

		<?php if ( is_singular() ) : ?>
			<footer class="entry-footer">
				<div class="entry-footer-meta">
					
					<!-- Author Info -->
					<div class="author-info">
						<div class="author-avatar">
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
						</div>
						<div class="author-details">
							<h4 class="author-name">
								<?php esc_html_e( 'Written by', 'oha-theme' ); ?>
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
									<?php the_author(); ?>
								</a>
							</h4>
							<?php if ( get_the_author_meta( 'description' ) ) : ?>
								<p class="author-bio"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
							<?php endif; ?>
						</div>
					</div>

					<!-- Tags and Categories -->
					<div class="entry-taxonomies">
						<?php
						$categories = get_the_category();
						if ( $categories ) :
						?>
							<div class="entry-categories">
								<strong><?php esc_html_e( 'Categories:', 'oha-theme' ); ?></strong>
								<?php foreach ( $categories as $category ) : ?>
									<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-tag">
										<?php echo esc_html( $category->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
						
						<?php
						$tags = get_the_tags();
						if ( $tags ) :
						?>
							<div class="entry-tags">
								<strong><?php esc_html_e( 'Tags:', 'oha-theme' ); ?></strong>
								<?php foreach ( $tags as $tag ) : ?>
									<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-link">
										#<?php echo esc_html( $tag->name ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
					
				</div>
			</footer><!-- .entry-footer -->
		<?php endif; ?>
		
	</div><!-- .post-card-content -->
	
</article><!-- #post-<?php the_ID(); ?> -->
