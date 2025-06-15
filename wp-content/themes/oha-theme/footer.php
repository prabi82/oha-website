<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OHA_Theme
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		
		<!-- Main Footer Section -->
		<div class="footer-main">
			<div class="oha-container">
				<div class="footer-content-grid">
					
					<!-- OHA Information Column -->
					<div class="footer-column footer-about">
						<?php
						$custom_logo_id = get_theme_mod( 'custom_logo' );
						$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
						?>
						
						<div class="footer-brand">
							<?php if ( has_custom_logo() ) : ?>
								<div class="footer-logo">
									<img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
								</div>
							<?php endif; ?>
						</div>
						
						<!-- Contact Quick Info -->
						<div class="footer-contact-quick">
							<?php
							$phone = get_theme_mod( 'oha_contact_phone', '+968 24 123456' );
							$email = get_theme_mod( 'oha_contact_email', 'info@omanhockey.org' );
							
							if ( $phone ) : ?>
								<div class="contact-quick-item">
									<i class="fas fa-phone" aria-hidden="true"></i>
									<a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
								</div>
							<?php endif;
							
							if ( $email ) : ?>
								<div class="contact-quick-item">
									<i class="fas fa-envelope" aria-hidden="true"></i>
									<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
								</div>
							<?php endif; ?>
						</div>
					</div>
					
					<!-- Quick Links Column -->
					<div class="footer-column footer-links">
						<h4 class="footer-column-title"><?php esc_html_e( 'Quick Links', 'oha-theme' ); ?></h4>
						<ul class="footer-menu-list">
							<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About OHA', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/news' ) ); ?>"><?php esc_html_e( 'Latest News', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/events' ) ); ?>"><?php esc_html_e( 'Events', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/national-team' ) ); ?>"><?php esc_html_e( 'National Team', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/coaching-technical' ) ); ?>"><?php esc_html_e( 'Coaching & Technical', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/schedules' ) ); ?>"><?php esc_html_e( 'Schedules', 'oha-theme' ); ?></a></li>
						</ul>
					</div>
					
					<!-- Resources Column -->
					<div class="footer-column footer-resources">
						<h4 class="footer-column-title"><?php esc_html_e( 'Resources', 'oha-theme' ); ?></h4>
						<ul class="footer-menu-list">
							<li><a href="<?php echo esc_url( home_url( '/tournaments' ) ); ?>"><?php esc_html_e( 'Tournaments', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/training-programs' ) ); ?>"><?php esc_html_e( 'Training Programs', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/media' ) ); ?>"><?php esc_html_e( 'Media Gallery', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>"><?php esc_html_e( 'Official Shop', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/rules-regulations' ) ); ?>"><?php esc_html_e( 'Rules & Regulations', 'oha-theme' ); ?></a></li>
							<li><a href="<?php echo esc_url( home_url( '/downloads' ) ); ?>"><?php esc_html_e( 'Downloads', 'oha-theme' ); ?></a></li>
						</ul>
					</div>
					
					<!-- Newsletter & Social Column -->
					<div class="footer-column footer-newsletter">
						<h4 class="footer-column-title"><?php esc_html_e( 'Stay Connected', 'oha-theme' ); ?></h4>
						
						<div class="footer-newsletter-form">
							<p class="newsletter-description"><?php esc_html_e( 'Subscribe to our newsletter for the latest updates and news.', 'oha-theme' ); ?></p>
							
							<form class="newsletter-form" action="#" method="post" novalidate>
								<div class="newsletter-input-group">
									<input type="email" name="newsletter_email" placeholder="<?php esc_attr_e( 'Enter your email address', 'oha-theme' ); ?>" required />
									<button type="submit" class="newsletter-submit">
										<i class="fas fa-paper-plane" aria-hidden="true"></i>
										<span class="sr-only"><?php esc_html_e( 'Subscribe', 'oha-theme' ); ?></span>
									</button>
								</div>
								<p class="newsletter-privacy"><?php esc_html_e( 'We respect your privacy. Unsubscribe at any time.', 'oha-theme' ); ?></p>
							</form>
						</div>
						
						<!-- Social Media Links -->
						<div class="footer-social-section">
							<h5 class="social-title"><?php esc_html_e( 'Follow Us', 'oha-theme' ); ?></h5>
							<div class="footer-social-links">
								<a href="#" class="social-link facebook" aria-label="<?php esc_attr_e( 'Facebook', 'oha-theme' ); ?>">
									<i class="fab fa-facebook-f" aria-hidden="true"></i>
								</a>
								<a href="#" class="social-link twitter" aria-label="<?php esc_attr_e( 'Twitter', 'oha-theme' ); ?>">
									<i class="fab fa-twitter" aria-hidden="true"></i>
								</a>
								<a href="#" class="social-link instagram" aria-label="<?php esc_attr_e( 'Instagram', 'oha-theme' ); ?>">
									<i class="fab fa-instagram" aria-hidden="true"></i>
								</a>
								<a href="#" class="social-link youtube" aria-label="<?php esc_attr_e( 'YouTube', 'oha-theme' ); ?>">
									<i class="fab fa-youtube" aria-hidden="true"></i>
								</a>
							</div>
						</div>
					</div>
					
				</div><!-- .footer-content-grid -->
			</div><!-- .oha-container -->
		</div><!-- .footer-main -->
		
		<!-- Footer Bottom Section -->
		<div class="footer-bottom">
			<div class="oha-container">
				<div class="footer-bottom-content">
					
					<!-- Copyright & Legal -->
					<div class="footer-copyright">
						<p class="copyright-text">
							<?php
							printf(
								/* translators: %s: Current year */
								esc_html__( '© %s Hockey Oman. All rights reserved.', 'oha-theme' ),
								date( 'Y' )
							);
							?>
						</p>
						<div class="footer-legal-links">
							<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'oha-theme' ); ?></a>
							<span class="separator">•</span>
							<a href="<?php echo esc_url( home_url( '/terms-conditions' ) ); ?>"><?php esc_html_e( 'Terms & Conditions', 'oha-theme' ); ?></a>
							<span class="separator">•</span>
							<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact Us', 'oha-theme' ); ?></a>
						</div>
					</div>
					
					<!-- Partner Logos Small -->
					<div class="footer-partners">
						<p class="partners-label"><?php esc_html_e( 'Proudly supported by:', 'oha-theme' ); ?></p>
						<div class="footer-partner-logos">
							<?php
							$partners = oha_get_partner_logos();
							if ( $partners && is_array( $partners ) ) :
								foreach ( array_slice( $partners, 0, 3 ) as $partner ) : // Show only first 3 in footer
									if ( isset( $partner['logo'] ) && $partner['logo'] ) :
							?>
								<div class="footer-partner-logo">
									<?php if ( isset( $partner['url'] ) && $partner['url'] ) : ?>
										<a href="<?php echo esc_url( $partner['url'] ); ?>" target="_blank" rel="noopener">
									<?php endif; ?>
										<img src="<?php echo esc_url( $partner['logo'] ); ?>" 
										     alt="<?php echo esc_attr( $partner['name'] ?? '' ); ?>" />
									<?php if ( isset( $partner['url'] ) && $partner['url'] ) : ?>
										</a>
									<?php endif; ?>
								</div>
							<?php
									endif;
								endforeach;
							endif;
							?>
						</div>
					</div>
					
					<!-- Development Credit -->
					<div class="footer-credit">
						<p class="dev-credit">
							<?php esc_html_e( 'Website designed and developed with', 'oha-theme' ); ?>
							<i class="fas fa-heart" aria-hidden="true"></i>
							<?php esc_html_e( 'by OHA Web Team', 'oha-theme' ); ?>
						</p>
					</div>
					
				</div><!-- .footer-bottom-content -->
			</div><!-- .oha-container -->
		</div><!-- .footer-bottom -->
		
		<!-- Back to Top Button -->
		<button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'oha-theme' ); ?>">
			<i class="fas fa-chevron-up" aria-hidden="true"></i>
		</button>
		
	</footer><!-- #colophon -->
	
</div><!-- #page -->

<!-- Video Modal -->
<div id="video-modal" class="video-modal" style="display: none;">
	<div class="video-modal-overlay"></div>
	<div class="video-modal-content">
		<button class="video-modal-close" aria-label="Close video">&times;</button>
		<div class="video-modal-container">
			<div id="video-player"></div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>
</html>
