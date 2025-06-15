<?php
/**
 * The template for displaying team member archives
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

get_header();
?>

<!-- Page Header -->
<div class="oha-page-header">
	<div class="oha-container">
		<h1 class="oha-page-title">
			<?php esc_html_e( 'Our Team', 'oha-theme' ); ?>
		</h1>
		<p class="page-subtitle">
			<?php esc_html_e( 'Meet the dedicated professionals behind the Oman Hockey Association', 'oha-theme' ); ?>
		</p>
	</div>
</div>

<!-- Breadcrumbs -->
<div class="oha-breadcrumbs">
	<div class="oha-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'oha-theme' ); ?></a>
		<span> / </span>
		<span><?php esc_html_e( 'Our Team', 'oha-theme' ); ?></span>
	</div>
</div>

<main id="primary" class="site-main oha-team-archive">
	<div class="oha-container">
		
		<!-- Team Filters -->
		<div class="team-filters">
			<div class="filter-header">
				<h3><?php esc_html_e( 'Filter by Category', 'oha-theme' ); ?></h3>
			</div>
			<div class="filter-buttons">
				<button class="filter-btn active" data-filter="*">
					<?php esc_html_e( 'All Members', 'oha-theme' ); ?>
				</button>
				<?php
				$team_categories = get_terms( array(
					'taxonomy' => 'team_category',
					'hide_empty' => true,
				) );
				
				if ( $team_categories && ! is_wp_error( $team_categories ) ) :
					foreach ( $team_categories as $category ) :
				?>
					<button class="filter-btn" data-filter=".<?php echo esc_attr( $category->slug ); ?>">
						<?php echo esc_html( $category->name ); ?>
						<span class="filter-count">(<?php echo $category->count; ?>)</span>
					</button>
				<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
		
		<div class="team-archive-layout">
			
			<!-- Main Content -->
			<div class="team-archive-content">
				<?php if ( have_posts() ) : ?>
					
					<!-- Archive Info -->
					<div class="archive-info">
						<p class="team-count">
							<?php
							global $wp_query;
							$total = $wp_query->found_posts;
							printf( 
								esc_html( _n( 'Meet our %d team member', 'Meet our %d team members', $total, 'oha-theme' ) ), 
								$total 
							);
							?>
						</p>
					</div>

					<!-- Team Grid -->
					<div class="team-grid" id="team-grid">
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							
							// Get team member metadata
							$position = get_post_meta( get_the_ID(), 'position', true );
							$experience_years = get_post_meta( get_the_ID(), 'experience_years', true );
							$email = get_post_meta( get_the_ID(), 'email', true );
							$phone = get_post_meta( get_the_ID(), 'phone', true );
							
							// Get team categories for filtering
							$team_categories = get_the_terms( get_the_ID(), 'team_category' );
							$category_classes = '';
							if ( $team_categories && ! is_wp_error( $team_categories ) ) {
								foreach ( $team_categories as $category ) {
									$category_classes .= ' ' . $category->slug;
								}
							}
							?>
							
							<div class="team-member-card<?php echo esc_attr( $category_classes ); ?>" data-aos="fade-up">
								
								<!-- Team Member Image -->
								<div class="team-member-image">
									<a href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'View %s profile', 'oha-theme' ), get_the_title() ) ); ?>">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
										<?php else : ?>
											<div class="team-member-placeholder">
												<i class="fas fa-user" aria-hidden="true"></i>
											</div>
										<?php endif; ?>
									</a>
									
									<!-- Quick Contact Overlay -->
									<div class="team-member-overlay">
										<div class="member-quick-contact">
											<?php if ( $email ) : ?>
												<a href="mailto:<?php echo esc_attr( $email ); ?>" class="quick-contact-btn email" title="<?php esc_attr_e( 'Send Email', 'oha-theme' ); ?>">
													<i class="fas fa-envelope"></i>
												</a>
											<?php endif; ?>
											
											<?php if ( $phone ) : ?>
												<a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone ) ); ?>" class="quick-contact-btn phone" title="<?php esc_attr_e( 'Call Phone', 'oha-theme' ); ?>">
													<i class="fas fa-phone"></i>
												</a>
											<?php endif; ?>
											
											<a href="<?php the_permalink(); ?>" class="quick-contact-btn profile" title="<?php esc_attr_e( 'View Profile', 'oha-theme' ); ?>">
												<i class="fas fa-user"></i>
											</a>
										</div>
									</div>
								</div>

								<!-- Team Member Info -->
								<div class="team-member-info">
									<h2 class="team-member-name">
										<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
									</h2>
									
									<?php if ( $position ) : ?>
										<p class="team-member-position"><?php echo esc_html( $position ); ?></p>
									<?php endif; ?>
									
									<div class="team-member-meta">
										<?php if ( $experience_years ) : ?>
											<div class="meta-item team-member-experience">
												<i class="fas fa-clock" aria-hidden="true"></i>
												<span><?php printf( esc_html( _n( '%d Year', '%d Years', $experience_years, 'oha-theme' ) ), $experience_years ); ?></span>
											</div>
										<?php endif; ?>
										
										<?php if ( $team_categories && ! is_wp_error( $team_categories ) ) : ?>
											<div class="meta-item team-member-category">
												<i class="fas fa-users" aria-hidden="true"></i>
												<span><?php echo esc_html( $team_categories[0]->name ); ?></span>
											</div>
										<?php endif; ?>
									</div>
									
									<?php if ( has_excerpt() ) : ?>
										<div class="team-member-bio">
											<?php the_excerpt(); ?>
										</div>
									<?php elseif ( get_the_content() ) : ?>
										<div class="team-member-bio">
											<?php echo wp_kses_post( wp_trim_words( get_the_content(), 20, '...' ) ); ?>
										</div>
									<?php endif; ?>
									
									<!-- Contact Information -->
									<div class="team-member-contact">
										<div class="contact-items">
											<?php if ( $email ) : ?>
												<a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-item">
													<i class="fas fa-envelope"></i>
													<span class="screen-reader-text"><?php esc_html_e( 'Email', 'oha-theme' ); ?></span>
												</a>
											<?php endif; ?>
											
											<?php if ( $phone ) : ?>
												<a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone ) ); ?>" class="contact-item">
													<i class="fas fa-phone"></i>
													<span class="screen-reader-text"><?php esc_html_e( 'Phone', 'oha-theme' ); ?></span>
												</a>
											<?php endif; ?>
										</div>
										
										<a href="<?php the_permalink(); ?>" class="view-profile-btn">
											<?php esc_html_e( 'View Profile', 'oha-theme' ); ?>
											<i class="fas fa-arrow-right" aria-hidden="true"></i>
										</a>
									</div>
								</div>
							</div>
							
						<?php endwhile; ?>
					</div>

					<!-- Enhanced Pagination -->
					<div class="team-pagination">
						<?php
						the_posts_pagination( array(
							'mid_size'  => 2,
							'prev_text' => '<i class="fas fa-arrow-left"></i> ' . esc_html__( 'Previous', 'oha-theme' ),
							'next_text' => esc_html__( 'Next', 'oha-theme' ) . ' <i class="fas fa-arrow-right"></i>',
						) );
						?>
					</div>

				<?php else : ?>

					<div class="team-no-content">
						<div class="oha-no-content">
							<div class="oha-no-content-icon">
								<i class="fas fa-users" aria-hidden="true"></i>
							</div>
							<h3><?php esc_html_e( 'No Team Members Found', 'oha-theme' ); ?></h3>
							<p><?php esc_html_e( 'There are no team members to display at this time. Please check back later.', 'oha-theme' ); ?></p>
							<?php if ( current_user_can( 'edit_posts' ) ) : ?>
								<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=team_member' ) ); ?>" class="oha-btn oha-btn-primary">
									<i class="fas fa-plus"></i>
									<?php esc_html_e( 'Add Team Member', 'oha-theme' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>

				<?php endif; ?>
			</div>
			
			<!-- Sidebar -->
			<aside class="team-archive-sidebar">
				
				<!-- Team Statistics Widget -->
				<div class="widget team-stats-widget">
					<h3 class="widget-title"><?php esc_html_e( 'Team Statistics', 'oha-theme' ); ?></h3>
					<div class="team-stats">
						<?php
						// Get team statistics
						$total_members = wp_count_posts( 'team_member' )->publish;
						$team_categories = get_terms( array(
							'taxonomy' => 'team_category',
							'hide_empty' => true,
						) );
						?>
						
						<div class="stat-item">
							<span class="stat-number"><?php echo esc_html( $total_members ); ?></span>
							<span class="stat-label"><?php esc_html_e( 'Total Members', 'oha-theme' ); ?></span>
						</div>
						
						<?php if ( $team_categories && ! is_wp_error( $team_categories ) ) : ?>
							<div class="stat-item">
								<span class="stat-number"><?php echo count( $team_categories ); ?></span>
								<span class="stat-label"><?php esc_html_e( 'Departments', 'oha-theme' ); ?></span>
							</div>
						<?php endif; ?>
					</div>
				</div>
				
				<!-- Team Categories Widget -->
				<?php if ( $team_categories && ! is_wp_error( $team_categories ) ) : ?>
					<div class="widget team-categories-widget">
						<h3 class="widget-title"><?php esc_html_e( 'Team Categories', 'oha-theme' ); ?></h3>
						<ul class="team-categories-list">
							<?php foreach ( $team_categories as $category ) : ?>
								<li>
									<a href="<?php echo esc_url( get_term_link( $category ) ); ?>" class="category-link">
										<i class="fas fa-users"></i>
										<?php echo esc_html( $category->name ); ?>
										<span class="category-count">(<?php echo $category->count; ?>)</span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>
				
				<?php get_sidebar(); ?>
			</aside>
			
		</div>
	</div>
</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Team filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const teamCards = document.querySelectorAll('.team-member-card');
    
    if (filterButtons.length > 0 && teamCards.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');
                
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter team cards
                teamCards.forEach(card => {
                    if (filter === '*' || card.classList.contains(filter.substring(1))) {
                        card.style.display = 'block';
                        card.style.animation = 'fadeInUp 0.6s ease-out';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }
});
</script>

<?php
get_footer(); 