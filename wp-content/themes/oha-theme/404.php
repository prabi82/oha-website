<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package OHA_Theme
 */

get_header();
?>

<!-- Page Header -->
<div class="oha-page-header">
	<div class="oha-container">
		<h1 class="oha-page-title">
			<?php esc_html_e( '404 - Page Not Found', 'oha-theme' ); ?>
		</h1>
	</div>
</div>

<!-- Breadcrumbs -->
<div class="oha-breadcrumbs">
	<div class="oha-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'oha-theme' ); ?></a>
		<span> / </span>
		<span><?php esc_html_e( '404 Error', 'oha-theme' ); ?></span>
	</div>
</div>

<main id="primary" class="site-main oha-404">
	<div class="oha-container">
		
		<section class="error-404 not-found">
			
			<!-- 404 Hero -->
			<div class="error-404-hero">
				<div class="error-404-icon">
					<i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
				</div>
				<h2 class="error-404-title">
					<?php esc_html_e( 'Page Not Found', 'oha-theme' ); ?>
				</h2>
				<p class="error-404-message">
					<?php esc_html_e( 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'oha-theme' ); ?>
				</p>
			</div>

			<!-- Search and Navigation -->
			<div class="error-404-content">
				
				<div class="error-404-grid">
					
					<!-- Search -->
					<div class="error-404-section">
						<h3><?php esc_html_e( 'Search Our Site', 'oha-theme' ); ?></h3>
						<p><?php esc_html_e( 'Try searching for what you were looking for:', 'oha-theme' ); ?></p>
						<?php get_search_form(); ?>
					</div>

					<!-- Navigation Links -->
					<div class="error-404-section">
						<h3><?php esc_html_e( 'Quick Navigation', 'oha-theme' ); ?></h3>
						<div class="error-404-nav">
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="oha-btn oha-btn-primary">
								<i class="fas fa-home"></i>
								<?php esc_html_e( 'Back to Home', 'oha-theme' ); ?>
							</a>
							<a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="oha-btn oha-btn-outline">
								<i class="fas fa-newspaper"></i>
								<?php esc_html_e( 'Latest News', 'oha-theme' ); ?>
							</a>
							<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="oha-btn oha-btn-outline">
								<i class="fas fa-info-circle"></i>
								<?php esc_html_e( 'About OHA', 'oha-theme' ); ?>
							</a>
							<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="oha-btn oha-btn-outline">
								<i class="fas fa-envelope"></i>
								<?php esc_html_e( 'Contact Us', 'oha-theme' ); ?>
							</a>
						</div>
					</div>

					<!-- Recent Posts -->
					<div class="error-404-section">
						<h3><?php esc_html_e( 'Recent News', 'oha-theme' ); ?></h3>
						<?php
						$recent_posts = new WP_Query( array(
							'post_type'      => 'post',
							'posts_per_page' => 5,
							'post_status'    => 'publish'
						) );
						
						if ( $recent_posts->have_posts() ) :
						?>
							<ul class="error-404-posts">
								<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
									<li>
										<a href="<?php the_permalink(); ?>">
											<i class="far fa-newspaper"></i>
											<?php the_title(); ?>
										</a>
										<span class="post-date"><?php echo get_the_date(); ?></span>
									</li>
								<?php endwhile; ?>
							</ul>
						<?php
						endif;
						wp_reset_postdata();
						?>
					</div>

					<!-- Categories -->
					<div class="error-404-section">
						<h3><?php esc_html_e( 'Browse Categories', 'oha-theme' ); ?></h3>
						<?php
						$categories = get_categories( array(
							'orderby' => 'count',
							'order'   => 'DESC',
							'number'  => 8
						) );
						
						if ( $categories ) :
						?>
							<ul class="error-404-categories">
								<?php foreach ( $categories as $category ) : ?>
									<li>
										<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
											<i class="fas fa-tag"></i>
											<?php echo esc_html( $category->name ); ?>
											<span class="category-count">(<?php echo $category->count; ?>)</span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>

				</div>
				
			</div>
			
		</section><!-- .error-404 -->
		
	</div>
</main><!-- #main -->

<?php
get_footer();
