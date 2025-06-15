<?php
/**
 * The template for displaying single team members
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
			<?php esc_html_e( 'Team Member', 'oha-theme' ); ?>
		</h1>
	</div>
</div>

<!-- Breadcrumbs -->
<div class="oha-breadcrumbs">
	<div class="oha-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'oha-theme' ); ?></a>
		<span> / </span>
		<a href="<?php echo esc_url( home_url( '/team' ) ); ?>"><?php esc_html_e( 'Our Team', 'oha-theme' ); ?></a>
		<span> / </span>
		<span><?php the_title(); ?></span>
	</div>
</div>

<main id="primary" class="site-main oha-single-team-member">
	<div class="oha-container">
		<div class="single-team-member-layout">
			
			<!-- Main Content -->
			<div class="single-team-member-content">
				<?php
				while ( have_posts() ) :
					the_post();
					
					// Get team member metadata
					$position = get_post_meta( get_the_ID(), 'position', true );
					$experience_years = get_post_meta( get_the_ID(), 'experience_years', true );
					$email = get_post_meta( get_the_ID(), 'email', true );
					$phone = get_post_meta( get_the_ID(), 'phone', true );
					$linkedin = get_post_meta( get_the_ID(), 'linkedin_url', true );
					$twitter = get_post_meta( get_the_ID(), 'twitter_url', true );
					$specializations = get_post_meta( get_the_ID(), 'specializations', true );
					$achievements = get_post_meta( get_the_ID(), 'achievements', true );
					$certifications = get_post_meta( get_the_ID(), 'certifications', true );
					?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'oha-team-member-single' ); ?>>
						
						<!-- Team Member Hero -->
						<div class="team-member-hero">
							<div class="team-member-hero-content">
								
								<!-- Team Member Photo -->
								<div class="team-member-photo">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'large', array( 'class' => 'member-image' ) ); ?>
									<?php else : ?>
										<div class="member-placeholder">
											<i class="fas fa-user" aria-hidden="true"></i>
										</div>
									<?php endif; ?>
								</div>
								
								<!-- Team Member Info -->
								<div class="team-member-info">
									<h1 class="member-name"><?php the_title(); ?></h1>
									
									<?php if ( $position ) : ?>
										<h2 class="member-position"><?php echo esc_html( $position ); ?></h2>
									<?php endif; ?>
									
									<div class="member-meta">
										<?php if ( $experience_years ) : ?>
											<div class="meta-item experience">
												<i class="fas fa-clock" aria-hidden="true"></i>
												<span><?php printf( esc_html( _n( '%d Year Experience', '%d Years Experience', $experience_years, 'oha-theme' ) ), $experience_years ); ?></span>
											</div>
										<?php endif; ?>
										
										<?php
										$team_categories = get_the_terms( get_the_ID(), 'team_category' );
										if ( $team_categories && ! is_wp_error( $team_categories ) ) :
										?>
											<div class="meta-item category">
												<i class="fas fa-users" aria-hidden="true"></i>
												<span><?php echo esc_html( $team_categories[0]->name ); ?></span>
											</div>
										<?php endif; ?>
									</div>
									
									<!-- Contact Information -->
									<?php if ( $email || $phone || $linkedin || $twitter ) : ?>
										<div class="member-contact">
											<h3><?php esc_html_e( 'Contact Information', 'oha-theme' ); ?></h3>
											<div class="contact-links">
												<?php if ( $email ) : ?>
													<a href="mailto:<?php echo esc_attr( $email ); ?>" class="contact-link email">
														<i class="fas fa-envelope"></i>
														<span><?php echo esc_html( $email ); ?></span>
													</a>
												<?php endif; ?>
												
												<?php if ( $phone ) : ?>
													<a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone ) ); ?>" class="contact-link phone">
														<i class="fas fa-phone"></i>
														<span><?php echo esc_html( $phone ); ?></span>
													</a>
												<?php endif; ?>
												
												<?php if ( $linkedin ) : ?>
													<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener" class="contact-link linkedin">
														<i class="fab fa-linkedin"></i>
														<span><?php esc_html_e( 'LinkedIn Profile', 'oha-theme' ); ?></span>
													</a>
												<?php endif; ?>
												
												<?php if ( $twitter ) : ?>
													<a href="<?php echo esc_url( $twitter ); ?>" target="_blank" rel="noopener" class="contact-link twitter">
														<i class="fab fa-twitter"></i>
														<span><?php esc_html_e( 'Twitter Profile', 'oha-theme' ); ?></span>
													</a>
												<?php endif; ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
								
							</div>
						</div>
						
						<!-- Team Member Details -->
						<div class="team-member-details">
							
							<!-- Biography -->
							<?php if ( get_the_content() ) : ?>
								<section class="member-biography">
									<h3><?php esc_html_e( 'Biography', 'oha-theme' ); ?></h3>
									<div class="biography-content">
										<?php the_content(); ?>
									</div>
								</section>
							<?php endif; ?>
							
							<!-- Specializations -->
							<?php if ( $specializations ) : ?>
								<section class="member-specializations">
									<h3><?php esc_html_e( 'Specializations', 'oha-theme' ); ?></h3>
									<div class="specializations-content">
										<?php echo wp_kses_post( wpautop( $specializations ) ); ?>
									</div>
								</section>
							<?php endif; ?>
							
							<!-- Achievements -->
							<?php if ( $achievements ) : ?>
								<section class="member-achievements">
									<h3><?php esc_html_e( 'Achievements & Awards', 'oha-theme' ); ?></h3>
									<div class="achievements-content">
										<?php echo wp_kses_post( wpautop( $achievements ) ); ?>
									</div>
								</section>
							<?php endif; ?>
							
							<!-- Certifications -->
							<?php if ( $certifications ) : ?>
								<section class="member-certifications">
									<h3><?php esc_html_e( 'Certifications', 'oha-theme' ); ?></h3>
									<div class="certifications-content">
										<?php echo wp_kses_post( wpautop( $certifications ) ); ?>
									</div>
								</section>
							<?php endif; ?>
							
						</div>
						
					</article>

					<!-- Team Member Navigation -->
					<?php
					$prev_member = get_previous_post( true, '', 'team_category' );
					$next_member = get_next_post( true, '', 'team_category' );
					
					if ( $prev_member || $next_member ) :
					?>
						<nav class="team-member-navigation">
							<h3><?php esc_html_e( 'Other Team Members', 'oha-theme' ); ?></h3>
							<div class="team-nav-links">
								<?php if ( $prev_member ) : ?>
									<div class="nav-member prev-member">
										<a href="<?php echo esc_url( get_permalink( $prev_member->ID ) ); ?>">
											<div class="nav-member-photo">
												<?php echo get_the_post_thumbnail( $prev_member->ID, 'thumbnail' ); ?>
											</div>
											<div class="nav-member-info">
												<span class="nav-label">
													<i class="fas fa-arrow-left"></i>
													<?php esc_html_e( 'Previous Member', 'oha-theme' ); ?>
												</span>
												<h4><?php echo esc_html( get_the_title( $prev_member->ID ) ); ?></h4>
												<span class="nav-position"><?php echo esc_html( get_post_meta( $prev_member->ID, 'position', true ) ); ?></span>
											</div>
										</a>
									</div>
								<?php endif; ?>
								
								<?php if ( $next_member ) : ?>
									<div class="nav-member next-member">
										<a href="<?php echo esc_url( get_permalink( $next_member->ID ) ); ?>">
											<div class="nav-member-photo">
												<?php echo get_the_post_thumbnail( $next_member->ID, 'thumbnail' ); ?>
											</div>
											<div class="nav-member-info">
												<span class="nav-label">
													<?php esc_html_e( 'Next Member', 'oha-theme' ); ?>
													<i class="fas fa-arrow-right"></i>
												</span>
												<h4><?php echo esc_html( get_the_title( $next_member->ID ) ); ?></h4>
												<span class="nav-position"><?php echo esc_html( get_post_meta( $next_member->ID, 'position', true ) ); ?></span>
											</div>
										</a>
									</div>
								<?php endif; ?>
							</div>
						</nav>
					<?php endif; ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>
			</div>
			
			<!-- Sidebar -->
			<aside class="single-team-member-sidebar">
				
				<!-- Related Team Members -->
				<div class="widget related-team-widget">
					<h3 class="widget-title"><?php esc_html_e( 'Other Team Members', 'oha-theme' ); ?></h3>
					<?php
					$related_members = oha_get_team_members( array(
						'posts_per_page' => 4,
						'post__not_in'   => array( get_the_ID() )
					) );
					
					if ( $related_members->have_posts() ) :
					?>
						<div class="related-team-list">
							<?php while ( $related_members->have_posts() ) : $related_members->the_post(); ?>
								<div class="related-team-item">
									<a href="<?php the_permalink(); ?>" class="related-team-link">
										<div class="related-team-photo">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'thumbnail' ); ?>
											<?php else : ?>
												<div class="team-placeholder-thumb">
													<i class="fas fa-user"></i>
												</div>
											<?php endif; ?>
										</div>
										<div class="related-team-info">
											<h4><?php the_title(); ?></h4>
											<span class="team-position"><?php echo esc_html( get_post_meta( get_the_ID(), 'position', true ) ); ?></span>
										</div>
									</a>
								</div>
							<?php endwhile; ?>
						</div>
					<?php
					endif;
					wp_reset_postdata();
					?>
				</div>
				
				<?php get_sidebar(); ?>
			</aside>
			
		</div>
	</div>
</main><!-- #main -->

<?php
get_footer(); 