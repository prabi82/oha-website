<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package OHA_Theme
 */

get_header();
?>

<!-- Page Header -->
<div class="oha-page-header">
	<div class="oha-container">
		<h1 class="oha-page-title">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'oha-theme' ), '<span class="search-query">' . get_search_query() . '</span>' );
			?>
		</h1>
	</div>
</div>

<!-- Breadcrumbs -->
<div class="oha-breadcrumbs">
	<div class="oha-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'oha-theme' ); ?></a>
		<span> / </span>
		<span><?php esc_html_e( 'Search Results', 'oha-theme' ); ?></span>
	</div>
</div>

<main id="primary" class="site-main oha-search">
	<div class="oha-container">
		<div class="search-layout">
			
			<!-- Main Content -->
			<div class="search-content">
				
				<!-- Search Form -->
				<div class="search-form-section">
					<h2><?php esc_html_e( 'Search Again', 'oha-theme' ); ?></h2>
					<p><?php esc_html_e( 'Refine your search or try different keywords:', 'oha-theme' ); ?></p>
					<?php get_search_form(); ?>
				</div>

				<?php if ( have_posts() ) : ?>
					
					<!-- Search Results Count -->
					<div class="search-results-info">
						<p class="search-count">
							<?php
							global $wp_query;
							$total = $wp_query->found_posts;
							printf( 
								esc_html( _n( 'Found %d result for "%s"', 'Found %d results for "%s"', $total, 'oha-theme' ) ), 
								$total,
								'<strong>' . get_search_query() . '</strong>'
							);
							?>
						</p>
					</div>

					<!-- Search Results -->
					<div class="search-results">
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'template-parts/content', 'search' );

						endwhile;
						?>
					</div>

					<!-- Enhanced Pagination -->
					<div class="search-pagination">
						<?php
						the_posts_pagination( array(
							'mid_size'  => 2,
							'prev_text' => '<i class="fas fa-arrow-left"></i> ' . esc_html__( 'Previous', 'oha-theme' ),
							'next_text' => esc_html__( 'Next', 'oha-theme' ) . ' <i class="fas fa-arrow-right"></i>',
						) );
						?>
					</div>

				<?php else : ?>

					<!-- No Search Results -->
					<div class="search-no-results">
						<div class="oha-no-content">
							<div class="oha-no-content-icon">
								<i class="fas fa-search" aria-hidden="true"></i>
							</div>
							<h3><?php esc_html_e( 'No Results Found', 'oha-theme' ); ?></h3>
							<p>
								<?php
								printf(
									esc_html__( 'Sorry, but nothing matched your search terms "%s". Please try again with different keywords.', 'oha-theme' ),
									'<strong>' . get_search_query() . '</strong>'
								);
								?>
							</p>
							
							<!-- Search Suggestions -->
							<div class="search-suggestions">
								<h4><?php esc_html_e( 'Search Suggestions:', 'oha-theme' ); ?></h4>
								<ul>
									<li><?php esc_html_e( 'Make sure all words are spelled correctly', 'oha-theme' ); ?></li>
									<li><?php esc_html_e( 'Try different keywords', 'oha-theme' ); ?></li>
									<li><?php esc_html_e( 'Try more general keywords', 'oha-theme' ); ?></li>
									<li><?php esc_html_e( 'Use fewer keywords', 'oha-theme' ); ?></li>
								</ul>
							</div>

							<!-- Popular Content -->
							<div class="search-popular-content">
								<h4><?php esc_html_e( 'Popular Content', 'oha-theme' ); ?></h4>
								<?php
								$popular_posts = new WP_Query( array(
									'post_type'      => 'post',
									'posts_per_page' => 5,
									'meta_key'       => 'post_views_count',
									'orderby'        => 'meta_value_num',
									'order'          => 'DESC'
								) );
								
								if ( $popular_posts->have_posts() ) :
								?>
									<ul class="popular-posts-list">
										<?php while ( $popular_posts->have_posts() ) : $popular_posts->the_post(); ?>
											<li>
												<a href="<?php the_permalink(); ?>">
													<i class="far fa-newspaper"></i>
													<?php the_title(); ?>
												</a>
											</li>
										<?php endwhile; ?>
									</ul>
								<?php
								endif;
								wp_reset_postdata();
								?>
							</div>
						</div>
					</div>

				<?php endif; ?>
				
			</div>
			
			<!-- Sidebar -->
			<aside class="search-sidebar">
				<?php get_sidebar(); ?>
			</aside>
			
		</div>
	</div>
</main><!-- #main -->

<?php
get_footer();
