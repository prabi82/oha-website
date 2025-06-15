<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

get_header();
?>

<main class="oha-archive">
	<div class="oha-container">
		
		<!-- Page Header -->
		<div class="oha-page-header">
			<h1 class="oha-page-title">
				<?php echo oha_get_enhanced_archive_title(); ?>
			</h1>
			
			<?php 
			$archive_description = '';
			if ( is_category() ) {
				$archive_description = category_description();
			} elseif ( is_tag() ) {
				$archive_description = tag_description();
			} elseif ( is_author() ) {
				$archive_description = get_the_author_meta( 'description' );
			}
			
			if ( $archive_description ) : ?>
				<div class="page-subtitle">
					<?php echo wp_kses_post( $archive_description ); ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Archive Controls -->
		<div class="archive-controls">
			<div class="archive-controls-wrapper">
				
				<!-- Archive Stats -->
				<div class="archive-stats">
					<div class="stats-info">
						<?php
						global $wp_query;
						$total_posts = $wp_query->found_posts;
						$posts_per_page = get_option( 'posts_per_page' );
						$current_page = max( 1, get_query_var( 'paged' ) );
						$showing_start = ( ( $current_page - 1 ) * $posts_per_page ) + 1;
						$showing_end = min( $current_page * $posts_per_page, $total_posts );
						?>
						<span class="showing-results">
							<?php 
							if ( $total_posts > 0 ) {
								printf( 
									esc_html__( 'Showing %s - %s of %s articles', 'oha-theme' ), 
									$showing_start, 
									$showing_end, 
									$total_posts 
								);
							} else {
								esc_html_e( 'No articles found', 'oha-theme' );
							}
							?>
						</span>
						
						<?php if ( is_category() ) : ?>
							<span class="archive-type-badge">
								<i class="fas fa-folder"></i>
								<?php esc_html_e( 'Category', 'oha-theme' ); ?>
							</span>
						<?php elseif ( is_tag() ) : ?>
							<span class="archive-type-badge">
								<i class="fas fa-tag"></i>
								<?php esc_html_e( 'Tag', 'oha-theme' ); ?>
							</span>
						<?php elseif ( is_author() ) : ?>
							<span class="archive-type-badge">
								<i class="fas fa-user"></i>
								<?php esc_html_e( 'Author', 'oha-theme' ); ?>
							</span>
						<?php elseif ( is_date() ) : ?>
							<span class="archive-type-badge">
								<i class="fas fa-calendar"></i>
								<?php esc_html_e( 'Date', 'oha-theme' ); ?>
							</span>
						<?php endif; ?>
					</div>
				</div>

				<!-- Archive Controls Actions -->
				<div class="archive-controls-actions">
					
					<!-- Sort Controls -->
					<div class="sort-controls">
						<label for="archive-sort" class="sort-label">
							<i class="fas fa-sort"></i>
							<?php esc_html_e( 'Sort by:', 'oha-theme' ); ?>
						</label>
						<select id="archive-sort" class="sort-select">
							<option value="date_desc"><?php esc_html_e( 'Newest First', 'oha-theme' ); ?></option>
							<option value="date_asc"><?php esc_html_e( 'Oldest First', 'oha-theme' ); ?></option>
							<option value="title_asc"><?php esc_html_e( 'Title A-Z', 'oha-theme' ); ?></option>
							<option value="title_desc"><?php esc_html_e( 'Title Z-A', 'oha-theme' ); ?></option>
							<option value="comment_count"><?php esc_html_e( 'Most Commented', 'oha-theme' ); ?></option>
						</select>
					</div>

					<!-- View Controls -->
					<div class="view-controls">
						<span class="view-label">
							<?php esc_html_e( 'View:', 'oha-theme' ); ?>
						</span>
						<div class="view-buttons">
							<button class="view-btn active" data-view="grid" title="<?php esc_attr_e( 'Grid View', 'oha-theme' ); ?>">
								<i class="fas fa-th"></i>
							</button>
							<button class="view-btn" data-view="list" title="<?php esc_attr_e( 'List View', 'oha-theme' ); ?>">
								<i class="fas fa-list"></i>
							</button>
						</div>
					</div>
				</div>
				
			</div><!-- .archive-controls-wrapper -->
		</div><!-- .archive-controls -->

		<div class="archive-layout">
			
			<!-- Main Archive Content -->
			<div class="archive-main-content">
				
				<?php if ( have_posts() ) : ?>
					
					<!-- Featured Posts (for sticky posts) -->
					<?php
					$sticky_posts = get_option( 'sticky_posts' );
					if ( ! empty( $sticky_posts ) && ! is_paged() ) :
						$featured_posts = new WP_Query( array(
							'post__in' => $sticky_posts,
							'posts_per_page' => 2,
							'ignore_sticky_posts' => 1,
						) );
						
						if ( $featured_posts->have_posts() ) :
					?>
						<section class="featured-posts-section">
							<h2 class="section-title">
								<i class="fas fa-star"></i>
								<?php esc_html_e( 'Featured Articles', 'oha-theme' ); ?>
							</h2>
							<div class="featured-posts-grid">
								<?php while ( $featured_posts->have_posts() ) : $featured_posts->the_post(); ?>
									<?php get_template_part( 'template-parts/content', 'featured' ); ?>
								<?php endwhile; ?>
							</div>
						</section>
						<?php wp_reset_postdata(); ?>
					<?php 
						endif;
					endif; 
					?>

					<!-- Regular Archive Posts -->
					<section class="archive-posts-section">
						<h2 class="section-title">
							<?php
							if ( is_category() ) {
								printf( esc_html__( 'All posts in %s', 'oha-theme' ), single_cat_title( '', false ) );
							} elseif ( is_tag() ) {
								printf( esc_html__( 'All posts tagged %s', 'oha-theme' ), single_tag_title( '', false ) );
							} elseif ( is_author() ) {
								printf( esc_html__( 'All posts by %s', 'oha-theme' ), get_the_author() );
							} else {
								esc_html_e( 'Latest Articles', 'oha-theme' );
							}
							?>
						</h2>
						
						<div id="archive-posts-container" class="archive-grid" data-view="grid">
							<?php
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', 'archive' );

							endwhile;
							?>
						</div><!-- .archive-grid -->
						
						<?php if ( $wp_query->max_num_pages > 1 ) : ?>
							<div class="archive-load-more">
								<button id="load-more-posts" class="oha-btn oha-btn-primary">
									<span class="btn-text">
										<i class="fas fa-plus"></i>
										<?php esc_html_e( 'Load More Articles', 'oha-theme' ); ?>
									</span>
									<span class="btn-loading" style="display: none;">
										<i class="fas fa-spinner fa-spin"></i>
										<?php esc_html_e( 'Loading...', 'oha-theme' ); ?>
									</span>
								</button>
							</div>
						<?php endif; ?>
						
					</section><!-- .archive-posts-section -->

				<?php else : ?>
					
					<!-- No Content Found -->
					<div class="archive-no-content">
						<div class="no-content-wrapper">
							<div class="no-content-icon">
								<i class="fas fa-search"></i>
							</div>
							<h3><?php esc_html_e( 'Nothing found', 'oha-theme' ); ?></h3>
							<p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'oha-theme' ); ?></p>
							
							<div class="search-form-wrapper">
								<?php get_search_form(); ?>
							</div>
							
							<div class="suggestions">
								<h4><?php esc_html_e( 'Browse by Category', 'oha-theme' ); ?></h4>
								<div class="category-suggestions">
									<?php
									$categories = get_categories( array(
										'orderby' => 'count',
										'order'   => 'DESC',
										'number'  => 6,
										'hide_empty' => true,
									) );
									
									foreach ( $categories as $category ) :
									?>
										<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-suggestion">
											<i class="fas fa-folder"></i>
											<?php echo esc_html( $category->name ); ?>
											<span class="count">(<?php echo $category->count; ?>)</span>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</div>

				<?php endif; ?>
				
				<!-- Standard Pagination (fallback) -->
				<?php oha_archive_pagination(); ?>
				
			</div><!-- .archive-main-content -->

			<!-- Archive Sidebar -->
			<aside class="archive-sidebar">
				
				<!-- Category/Tag Info Widget -->
				<?php if ( is_category() || is_tag() ) : ?>
					<div class="widget category-info-widget">
						<div class="category-info">
							<?php if ( is_category() ) : ?>
								<h3><?php printf( esc_html__( 'About %s', 'oha-theme' ), single_cat_title( '', false ) ); ?></h3>
								<?php
								$cat_stats = oha_get_archive_stats();
								$current_cat = get_queried_object();
								?>
								<div class="category-stats">
									<div class="stat-item">
										<div class="stat-number"><?php echo $current_cat->count; ?></div>
										<div class="stat-label"><?php esc_html_e( 'Articles', 'oha-theme' ); ?></div>
									</div>
								</div>
								
								<?php if ( category_description() ) : ?>
									<div class="category-description">
										<?php echo wp_kses_post( category_description() ); ?>
									</div>
								<?php endif; ?>
								
							<?php elseif ( is_tag() ) : ?>
								<h3><?php printf( esc_html__( 'Tagged: %s', 'oha-theme' ), single_tag_title( '', false ) ); ?></h3>
								<?php
								$current_tag = get_queried_object();
								?>
								<div class="category-stats">
									<div class="stat-item">
										<div class="stat-number"><?php echo $current_tag->count; ?></div>
										<div class="stat-label"><?php esc_html_e( 'Articles', 'oha-theme' ); ?></div>
									</div>
								</div>
								
								<?php if ( tag_description() ) : ?>
									<div class="category-description">
										<?php echo wp_kses_post( tag_description() ); ?>
									</div>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Categories Widget -->
				<div class="widget">
					<h3 class="widget-title">
						<i class="fas fa-folder-open"></i>
						<?php esc_html_e( 'Browse Categories', 'oha-theme' ); ?>
					</h3>
					<ul class="categories-list">
						<?php
						$categories = get_categories( array(
							'orderby' => 'count',
							'order'   => 'DESC',
							'hide_empty' => true,
						) );
						
						foreach ( $categories as $category ) :
						?>
							<li>
								<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
									<span>
										<i class="fas fa-folder"></i>
										<?php echo esc_html( $category->name ); ?>
									</span>
									<span class="count"><?php echo $category->count; ?></span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>

				<!-- Popular Posts Widget -->
				<?php
				$popular_posts = oha_get_popular_posts( 5 );
				if ( $popular_posts->have_posts() ) :
				?>
					<div class="widget">
						<h3 class="widget-title">
							<i class="fas fa-fire"></i>
							<?php esc_html_e( 'Popular Articles', 'oha-theme' ); ?>
						</h3>
						<div class="popular-posts-list">
							<?php while ( $popular_posts->have_posts() ) : $popular_posts->the_post(); ?>
								<div class="popular-post-item">
									<?php if ( has_post_thumbnail() ) : ?>
										<div class="popular-post-image">
											<a href="<?php the_permalink(); ?>">
												<?php the_post_thumbnail( 'thumbnail' ); ?>
											</a>
										</div>
									<?php endif; ?>
									<div class="popular-post-content">
										<h4 class="popular-post-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h4>
										<div class="popular-post-meta">
											<span class="post-date"><?php echo get_the_date(); ?></span>
											<span class="post-views">
												<i class="fas fa-eye"></i>
												<?php echo get_post_meta( get_the_ID(), 'post_views_count', true ) ?: '0'; ?>
											</span>
										</div>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>

				<!-- Standard Sidebar -->
				<?php get_sidebar(); ?>
				
			</aside><!-- .archive-sidebar -->
			
		</div><!-- .archive-layout -->
		
	</div><!-- .oha-container -->
</main><!-- .oha-archive -->

<?php
get_footer();
