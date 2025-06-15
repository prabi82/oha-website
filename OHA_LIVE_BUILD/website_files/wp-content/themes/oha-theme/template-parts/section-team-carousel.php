<?php
/**
 * Template part for displaying the team carousel section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

// Get team members using our helper function
$team_query = oha_get_team_members( array( 'posts_per_page' => 8 ) );
?>

<section class="oha-section oha-team-carousel" id="team-carousel">
	<div class="oha-container">
		
		<!-- Section Header -->
		<div class="oha-section-header">
			<h2 class="oha-section-title">
				<?php esc_html_e( 'Meet Our Team', 'oha-theme' ); ?>
			</h2>
			<div class="oha-section-subtitle">
				<?php esc_html_e( 'The dedicated professionals and passionate individuals who lead and support the development of hockey in Oman.', 'oha-theme' ); ?>
			</div>
		</div>
		
		<?php if ( $team_query->have_posts() ) : ?>
			<div class="team-carousel-wrapper">
				<div class="swiper team-swiper">
					<div class="swiper-wrapper">
						<?php while ( $team_query->have_posts() ) : $team_query->the_post(); ?>
							<?php
							// Get team member metadata
							$position = get_post_meta( get_the_ID(), 'team_position', true );
							$phone = get_post_meta( get_the_ID(), 'team_phone', true );
							$email = get_post_meta( get_the_ID(), 'team_email', true );
							$experience = get_post_meta( get_the_ID(), 'team_experience', true );
							
							// Get position taxonomy if meta not available
							if ( ! $position ) {
								$positions = get_the_terms( get_the_ID(), 'team_position' );
								if ( $positions && ! is_wp_error( $positions ) ) {
									$position = $positions[0]->name;
								}
							}
							?>
							
							<div class="swiper-slide">
								<article class="team-member-card">
									
									<!-- Team Member Image -->
									<div class="team-member-image">
										<?php if ( has_post_thumbnail() ) : ?>
											<?php the_post_thumbnail( 'medium', array( 'loading' => 'lazy' ) ); ?>
										<?php else : ?>
											<div class="team-member-placeholder">
												<i class="fas fa-user" aria-hidden="true"></i>
											</div>
										<?php endif; ?>
									</div>
									
									<!-- Team Member Info -->
									<div class="team-member-info">
										
										<!-- Name -->
										<h3 class="team-member-name">
											<?php the_title(); ?>
										</h3>
										
										<!-- Position -->
										<?php if ( $position ) : ?>
											<div class="team-member-position">
												<?php echo esc_html( $position ); ?>
											</div>
										<?php endif; ?>
										
										<!-- Experience -->
										<?php if ( $experience ) : ?>
											<div class="team-member-experience">
												<i class="fas fa-clock" aria-hidden="true"></i>
												<?php echo esc_html( sprintf( __( '%s years experience', 'oha-theme' ), $experience ) ); ?>
											</div>
										<?php endif; ?>
										
										<!-- Bio -->
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
										<?php if ( $phone || $email ) : ?>
											<div class="team-member-contact">
												<?php if ( $phone ) : ?>
													<a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone ) ); ?>" class="team-contact-item">
														<i class="fas fa-phone" aria-hidden="true"></i>
														<span class="screen-reader-text"><?php esc_html_e( 'Phone:', 'oha-theme' ); ?></span>
													</a>
												<?php endif; ?>
												
												<?php if ( $email ) : ?>
													<a href="mailto:<?php echo esc_attr( $email ); ?>" class="team-contact-item">
														<i class="fas fa-envelope" aria-hidden="true"></i>
														<span class="screen-reader-text"><?php esc_html_e( 'Email:', 'oha-theme' ); ?></span>
													</a>
												<?php endif; ?>
											</div>
										<?php endif; ?>
										
									</div>
									
								</article>
							</div>
						<?php endwhile; ?>
					</div>
					
					<!-- Carousel Navigation -->
					<div class="swiper-pagination"></div>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				</div>
			</div>
			
			<!-- View All Team Button -->
			<div class="oha-section-footer">
				<a href="<?php echo esc_url( home_url( '/team' ) ); ?>" class="oha-btn oha-btn-outline oha-btn-large">
					<?php esc_html_e( 'View All Team Members', 'oha-theme' ); ?>
					<i class="fas fa-users" aria-hidden="true"></i>
				</a>
			</div>
			
		<?php else : ?>
			<!-- No team members found -->
			<div class="oha-no-content">
				<div class="oha-no-content-icon">
					<i class="fas fa-users" aria-hidden="true"></i>
				</div>
				<h3><?php esc_html_e( 'No Team Members', 'oha-theme' ); ?></h3>
				<p><?php esc_html_e( 'Meet our team members who are dedicated to promoting hockey in Oman.', 'oha-theme' ); ?></p>
				
				<?php if ( current_user_can( 'edit_posts' ) ) : ?>
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=team_member' ) ); ?>" class="oha-btn oha-btn-primary">
						<?php esc_html_e( 'Add Team Member', 'oha-theme' ); ?>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		
	</div>
</section>

<?php wp_reset_postdata(); ?> 