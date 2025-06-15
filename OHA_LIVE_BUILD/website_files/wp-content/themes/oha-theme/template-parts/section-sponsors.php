<?php
/**
 * Template part for displaying the sponsors section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

// Get sponsors using our helper function
$sponsors_query = oha_get_sponsors();
?>

<section class="oha-section oha-sponsors" id="sponsors">
	<div class="oha-container">
		
		<!-- Section Header -->
		<div class="oha-section-header">
			<h2 class="oha-section-title">
				<?php esc_html_e( 'Our Partners', 'oha-theme' ); ?>
			</h2>
		</div>
		
		<?php if ( $sponsors_query->have_posts() ) : ?>
			<div class="sponsors-grid">
				<?php while ( $sponsors_query->have_posts() ) : $sponsors_query->the_post(); ?>
					<?php
					// Get sponsor metadata
					$sponsor_url = get_post_meta( get_the_ID(), 'sponsor_url', true );
					$sponsor_type = get_post_meta( get_the_ID(), 'sponsor_type', true );
					$sponsor_level = get_post_meta( get_the_ID(), 'sponsor_level', true );
					?>
					
					<div class="sponsor-logo <?php echo $sponsor_type ? 'sponsor-type-' . esc_attr( sanitize_title( $sponsor_type ) ) : ''; ?> <?php echo $sponsor_level ? 'sponsor-level-' . esc_attr( sanitize_title( $sponsor_level ) ) : ''; ?>">
						<?php if ( $sponsor_url ) : ?>
							<a href="<?php echo esc_url( $sponsor_url ); ?>" 
							   target="_blank" 
							   rel="noopener noreferrer" 
							   aria-label="<?php echo esc_attr( sprintf( __( 'Visit %s website', 'oha-theme' ), get_the_title() ) ); ?>">
						<?php endif; ?>
						
						<?php if ( has_post_thumbnail() ) : ?>
							<?php the_post_thumbnail( 'medium', array( 
								'alt' => get_the_title(),
								'loading' => 'lazy'
							) ); ?>
						<?php else : ?>
							<!-- Sponsor name as fallback -->
							<div class="sponsor-text-logo">
								<span class="sponsor-name"><?php the_title(); ?></span>
								<?php if ( $sponsor_type ) : ?>
									<span class="sponsor-type"><?php echo esc_html( $sponsor_type ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						
						<?php if ( $sponsor_url ) : ?>
							</a>
						<?php endif; ?>
						
						<!-- Sponsor Level Badge -->
						<?php if ( $sponsor_level ) : ?>
							<div class="sponsor-level-badge">
								<?php echo esc_html( $sponsor_level ); ?>
							</div>
						<?php endif; ?>
						
						<!-- Sponsor Tooltip with Description -->
						<?php if ( has_excerpt() || get_the_content() ) : ?>
							<div class="sponsor-tooltip">
								<h4><?php the_title(); ?></h4>
								<?php if ( has_excerpt() ) : ?>
									<p><?php the_excerpt(); ?></p>
								<?php elseif ( get_the_content() ) : ?>
									<p><?php echo wp_kses_post( wp_trim_words( get_the_content(), 15 ) ); ?></p>
								<?php endif; ?>
								
								<?php if ( $sponsor_url ) : ?>
									<span class="sponsor-visit"><?php esc_html_e( 'Visit Website', 'oha-theme' ); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
			</div>
			
		<?php else : ?>
			<!-- No sponsors found -->
			<div class="oha-no-content">
				<div class="oha-no-content-icon">
					<i class="fas fa-handshake" aria-hidden="true"></i>
				</div>
				<h3><?php esc_html_e( 'Looking for Partners', 'oha-theme' ); ?></h3>
				<p><?php esc_html_e( 'We welcome partnerships with organizations that share our passion for hockey development in Oman.', 'oha-theme' ); ?></p>
			</div>
		<?php endif; ?>
		
	</div>
</section>

<?php wp_reset_postdata(); ?> 