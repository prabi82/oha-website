<?php
/**
 * Template part for displaying the hero slider section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

// Get slides from custom post type
$slides_query = oha_get_slides( array( 'posts_per_page' => 5 ) );
?>

<section class="oha-hero-slider" id="hero-slider">
	<?php if ( $slides_query->have_posts() ) : ?>
		<div class="swiper hero-swiper">
			<div class="swiper-wrapper">
				<?php while ( $slides_query->have_posts() ) : $slides_query->the_post(); ?>
					<?php
					// Get banner options
					$hide_banner_text = get_post_meta( get_the_ID(), '_oha_hide_banner_text', true );
					$enable_learn_more = get_post_meta( get_the_ID(), '_oha_enable_learn_more', true );
					$learn_more_text = get_post_meta( get_the_ID(), '_oha_learn_more_text', true );
					$learn_more_url = get_post_meta( get_the_ID(), '_oha_learn_more_url', true );
					$enable_secondary_cta = get_post_meta( get_the_ID(), '_oha_enable_secondary_cta', true );
					$secondary_cta_text = get_post_meta( get_the_ID(), '_oha_secondary_cta_text', true );
					$secondary_cta_url = get_post_meta( get_the_ID(), '_oha_secondary_cta_url', true );
					
					// Set defaults for backward compatibility
					if ( $enable_learn_more === '' ) {
						$enable_learn_more = '1'; // Default to enabled
					}
					if ( empty( $learn_more_text ) ) {
						$learn_more_text = 'Learn More';
					}
					if ( $enable_secondary_cta === '' ) {
						$enable_secondary_cta = '1'; // Default to enabled
					}
					if ( empty( $secondary_cta_text ) ) {
						$secondary_cta_text = 'Contact Us';
					}
					?>
					<div class="swiper-slide hero-slide <?php echo $hide_banner_text ? 'hide-text' : ''; ?>" <?php if ( has_post_thumbnail() ) : ?>style="background-image: url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'full' ) ); ?>');"<?php endif; ?>>
						<div class="oha-container">
							<div class="hero-content">
								<?php if ( ! $hide_banner_text ) : ?>
									<?php if ( get_the_title() ) : ?>
										<h1 class="hero-title"><?php the_title(); ?></h1>
									<?php endif; ?>
									
									<?php if ( get_the_content() ) : ?>
										<div class="hero-subtitle">
											<?php 
											// Get excerpt or content
											$content = get_the_excerpt() ? get_the_excerpt() : wp_trim_words( get_the_content(), 20 );
											echo wp_kses_post( $content );
											?>
										</div>
									<?php endif; ?>
								<?php endif; ?>
								
								<?php if ( $enable_learn_more || $enable_secondary_cta ) : ?>
									<div class="hero-cta">
										<?php if ( $enable_learn_more ) : ?>
											<?php
											// Determine learn more URL
											$learn_more_final_url = ! empty( $learn_more_url ) ? $learn_more_url : home_url( '/about' );
											?>
											<a href="<?php echo esc_url( $learn_more_final_url ); ?>" class="oha-btn oha-btn-primary">
												<?php echo esc_html( $learn_more_text ); ?>
											</a>
										<?php endif; ?>
										
										<?php if ( $enable_secondary_cta ) : ?>
											<?php
											// Determine secondary CTA URL
											$secondary_cta_final_url = ! empty( $secondary_cta_url ) ? $secondary_cta_url : home_url( '/contact' );
											?>
											<a href="<?php echo esc_url( $secondary_cta_final_url ); ?>" class="oha-btn oha-btn-outline">
												<?php echo esc_html( $secondary_cta_text ); ?>
											</a>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			
			<!-- Slider Navigation -->
			<div class="swiper-pagination"></div>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
		
	<?php else : ?>
		<!-- Default hero section when no slides are available -->
		<div class="hero-slide default-hero" style="background-image: linear-gradient(135deg, var(--oha-primary-green), var(--oha-primary-red));">
			<div class="oha-container">
				<div class="hero-content">
					<h1 class="hero-title">
						<?php esc_html_e( 'Welcome to Oman Hockey Association', 'oha-theme' ); ?>
					</h1>
					<div class="hero-subtitle">
						<?php esc_html_e( 'The official governing body for hockey in the Sultanate of Oman, promoting and developing the sport at all levels across the country.', 'oha-theme' ); ?>
					</div>
					<div class="hero-cta">
						<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="oha-btn oha-btn-primary">
							<?php esc_html_e( 'About OHA', 'oha-theme' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/news' ) ); ?>" class="oha-btn oha-btn-outline">
							<?php esc_html_e( 'Latest News', 'oha-theme' ); ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<?php wp_reset_postdata(); ?>
</section> 