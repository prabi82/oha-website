<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package OHA_Theme
 */

get_header();
?>

<!-- Page Header -->
<div class="oha-page-header">
	<div class="oha-container">
		<h1 class="oha-page-title">
			<?php esc_html_e( 'News Article', 'oha-theme' ); ?>
		</h1>
	</div>
</div>

<!-- Breadcrumbs -->
<div class="oha-breadcrumbs">
	<div class="oha-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'oha-theme' ); ?></a>
		<span> / </span>
		<a href="<?php echo esc_url( home_url( '/news' ) ); ?>"><?php esc_html_e( 'News', 'oha-theme' ); ?></a>
		<span> / </span>
		<span><?php the_title(); ?></span>
	</div>
</div>

<main id="primary" class="site-main oha-single-post">
	<div class="oha-container">
		<div class="single-post-layout">
			
			<!-- Main Content -->
			<div class="single-post-content">
				<?php
				while ( have_posts() ) :
					the_post();
				?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'oha-post-single' ); ?>>
						
						<!-- Post Header -->
						<header class="single-post-header">
							<h1 class="single-post-title"><?php the_title(); ?></h1>
							
							<div class="single-post-meta">
								<div class="post-meta-primary">
									<div class="meta-item post-date">
										<i class="far fa-calendar-alt"></i>
										<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
											<?php echo esc_html( get_the_date() ); ?>
										</time>
									</div>
									
									<div class="meta-item post-author">
										<i class="fas fa-user"></i>
										<span><?php esc_html_e( 'By', 'oha-theme' ); ?> <?php the_author(); ?></span>
									</div>
									
									<?php
									$categories = get_the_category();
									if ( $categories ) :
									?>
										<div class="meta-item post-category">
											<i class="fas fa-folder"></i>
											<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" class="category-link">
												<?php echo esc_html( $categories[0]->name ); ?>
											</a>
										</div>
									<?php endif; ?>
									
									<div class="meta-item post-reading-time">
										<i class="fas fa-clock"></i>
										<span><?php echo oha_get_reading_time( get_the_content() ); ?> <?php esc_html_e( 'min read', 'oha-theme' ); ?></span>
									</div>
								</div>
								
								<!-- Social Sharing -->
								<div class="post-social-share">
									<span class="share-label"><?php esc_html_e( 'Share:', 'oha-theme' ); ?></span>
									<div class="social-share-buttons">
										<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" 
										   target="_blank" rel="noopener" class="share-btn facebook" title="<?php esc_attr_e( 'Share on Facebook', 'oha-theme' ); ?>">
											<i class="fab fa-facebook-f"></i>
										</a>
										<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" 
										   target="_blank" rel="noopener" class="share-btn twitter" title="<?php esc_attr_e( 'Share on Twitter', 'oha-theme' ); ?>">
											<i class="fab fa-twitter"></i>
										</a>
										<a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode( get_permalink() ); ?>" 
										   target="_blank" rel="noopener" class="share-btn linkedin" title="<?php esc_attr_e( 'Share on LinkedIn', 'oha-theme' ); ?>">
											<i class="fab fa-linkedin-in"></i>
										</a>
										<a href="whatsapp://send?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>" 
										   class="share-btn whatsapp" title="<?php esc_attr_e( 'Share on WhatsApp', 'oha-theme' ); ?>">
											<i class="fab fa-whatsapp"></i>
										</a>
									</div>
								</div>
							</div>
						</header>

						<!-- Featured Image -->
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="single-post-featured-image">
								<?php the_post_thumbnail( 'large', array( 'loading' => 'eager' ) ); ?>
								<?php 
								$caption = get_the_post_thumbnail_caption();
								if ( $caption ) :
								?>
									<figcaption class="featured-image-caption">
										<?php echo esc_html( $caption ); ?>
									</figcaption>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<!-- Post Content -->
						<div class="single-post-content-body">
							<?php
							the_content(
								sprintf(
									wp_kses(
										/* translators: %s: Name of current post. Only visible to screen readers */
										__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'oha-theme' ),
										array(
											'span' => array(
												'class' => array(),
											),
										)
									),
									wp_kses_post( get_the_title() )
								)
							);

							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oha-theme' ),
									'after'  => '</div>',
								)
							);
							?>
						</div>

						<!-- Post Tags -->
						<?php
						$tags = get_the_tags();
						if ( $tags ) :
						?>
							<div class="single-post-tags">
								<h4><?php esc_html_e( 'Tags:', 'oha-theme' ); ?></h4>
								<div class="tags-list">
									<?php foreach ( $tags as $tag ) : ?>
										<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="tag-link">
											<i class="fas fa-tag"></i>
											<?php echo esc_html( $tag->name ); ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>

					</article>



					<!-- Related Posts -->
					<?php
					$related_posts = oha_get_related_posts( get_the_ID(), 3 );
					if ( $related_posts->have_posts() ) :
					?>
						<section class="related-posts">
							<h3 class="related-posts-title"><?php esc_html_e( 'Related Articles', 'oha-theme' ); ?></h3>
							<div class="related-posts-grid">
								<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
									<article class="related-post-item">
										<?php if ( has_post_thumbnail() ) : ?>
											<div class="related-post-image">
												<a href="<?php the_permalink(); ?>">
													<?php the_post_thumbnail( 'medium' ); ?>
												</a>
											</div>
										<?php endif; ?>
										<div class="related-post-content">
											<h4 class="related-post-title">
												<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
											</h4>
											<div class="related-post-meta">
												<span class="related-post-date"><?php echo esc_html( get_the_date() ); ?></span>
											</div>
											<a href="<?php the_permalink(); ?>" class="related-post-link">
												<?php esc_html_e( 'Read More', 'oha-theme' ); ?>
												<i class="fas fa-arrow-right"></i>
											</a>
										</div>
									</article>
								<?php endwhile; ?>
							</div>
						</section>
					<?php
					endif;
					wp_reset_postdata();
					?>



				<?php endwhile; // End of the loop. ?>
			</div>
			
		</div>
	</div>
</main><!-- #main -->

<?php
get_footer();
