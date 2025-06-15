<?php
/**
 * Template Name: Contact Page
 * The template for displaying the contact page
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
			<?php esc_html_e( 'Contact Us', 'oha-theme' ); ?>
		</h1>
		<p class="page-subtitle">
			<?php esc_html_e( 'Get in touch with the Oman Hockey Association', 'oha-theme' ); ?>
		</p>
	</div>
</div>

<!-- Breadcrumbs -->
<div class="oha-breadcrumbs">
	<div class="oha-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'oha-theme' ); ?></a>
		<span> / </span>
		<span><?php esc_html_e( 'Contact', 'oha-theme' ); ?></span>
	</div>
</div>

<main id="primary" class="site-main oha-contact-page">
	<div class="oha-container">
		
		<!-- Contact Information Section -->
		<section class="contact-info-section oha-section">
			<div class="contact-info-grid">
				
				<!-- Contact Details -->
				<div class="contact-details">
					<h2><?php esc_html_e( 'Contact Information', 'oha-theme' ); ?></h2>
					<p><?php esc_html_e( 'Reach out to us through any of the following channels. We\'re here to help with all your hockey-related inquiries.', 'oha-theme' ); ?></p>
					
					<div class="contact-items">
						
						<!-- Office Address -->
						<?php
						$office_address = get_theme_mod( 'oha_contact_address', 'Muscat, Sultanate of Oman' );
						if ( $office_address ) :
						?>
							<div class="contact-item">
								<div class="contact-icon">
									<i class="fas fa-map-marker-alt" aria-hidden="true"></i>
								</div>
								<div class="contact-info">
									<h4><?php esc_html_e( 'Office Address', 'oha-theme' ); ?></h4>
									<p><?php echo esc_html( $office_address ); ?></p>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- Phone Number -->
						<?php
						$phone_number = get_theme_mod( 'oha_contact_phone', '+968 1234 5678' );
						if ( $phone_number ) :
						?>
							<div class="contact-item">
								<div class="contact-icon">
									<i class="fas fa-phone" aria-hidden="true"></i>
								</div>
								<div class="contact-info">
									<h4><?php esc_html_e( 'Phone Number', 'oha-theme' ); ?></h4>
									<p>
										<a href="tel:<?php echo esc_attr( str_replace( ' ', '', $phone_number ) ); ?>">
											<?php echo esc_html( $phone_number ); ?>
										</a>
									</p>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- Email Address -->
						<?php
						$email_address = get_theme_mod( 'oha_contact_email', 'info@omanhockey.om' );
						if ( $email_address ) :
						?>
							<div class="contact-item">
								<div class="contact-icon">
									<i class="fas fa-envelope" aria-hidden="true"></i>
								</div>
								<div class="contact-info">
									<h4><?php esc_html_e( 'Email Address', 'oha-theme' ); ?></h4>
									<p>
										<a href="mailto:<?php echo esc_attr( $email_address ); ?>">
											<?php echo esc_html( $email_address ); ?>
										</a>
									</p>
								</div>
							</div>
						<?php endif; ?>
						
						<!-- Office Hours -->
						<div class="contact-item">
							<div class="contact-icon">
								<i class="fas fa-clock" aria-hidden="true"></i>
							</div>
							<div class="contact-info">
								<h4><?php esc_html_e( 'Office Hours', 'oha-theme' ); ?></h4>
								<div class="office-hours">
									<p><strong><?php esc_html_e( 'Sunday - Thursday:', 'oha-theme' ); ?></strong> 8:00 AM - 5:00 PM</p>
									<p><strong><?php esc_html_e( 'Friday - Saturday:', 'oha-theme' ); ?></strong> <?php esc_html_e( 'Closed', 'oha-theme' ); ?></p>
								</div>
							</div>
						</div>
						
					</div>
					
					<!-- Social Media Links -->
					<div class="contact-social">
						<h4><?php esc_html_e( 'Follow Us', 'oha-theme' ); ?></h4>
						<div class="social-links">
							<?php
							$facebook_url = get_theme_mod( 'oha_facebook_url' );
							$twitter_url = get_theme_mod( 'oha_twitter_url' );
							$instagram_url = get_theme_mod( 'oha_instagram_url' );
							$youtube_url = get_theme_mod( 'oha_youtube_url' );
							?>
							
							<?php if ( $facebook_url ) : ?>
								<a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener" class="social-link facebook">
									<i class="fab fa-facebook-f" aria-hidden="true"></i>
									<span class="screen-reader-text"><?php esc_html_e( 'Facebook', 'oha-theme' ); ?></span>
								</a>
							<?php endif; ?>
							
							<?php if ( $twitter_url ) : ?>
								<a href="<?php echo esc_url( $twitter_url ); ?>" target="_blank" rel="noopener" class="social-link twitter">
									<i class="fab fa-twitter" aria-hidden="true"></i>
									<span class="screen-reader-text"><?php esc_html_e( 'Twitter', 'oha-theme' ); ?></span>
								</a>
							<?php endif; ?>
							
							<?php if ( $instagram_url ) : ?>
								<a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener" class="social-link instagram">
									<i class="fab fa-instagram" aria-hidden="true"></i>
									<span class="screen-reader-text"><?php esc_html_e( 'Instagram', 'oha-theme' ); ?></span>
								</a>
							<?php endif; ?>
							
							<?php if ( $youtube_url ) : ?>
								<a href="<?php echo esc_url( $youtube_url ); ?>" target="_blank" rel="noopener" class="social-link youtube">
									<i class="fab fa-youtube" aria-hidden="true"></i>
									<span class="screen-reader-text"><?php esc_html_e( 'YouTube', 'oha-theme' ); ?></span>
								</a>
							<?php endif; ?>
						</div>
					</div>
					
				</div>
				
				<!-- Contact Form -->
				<div class="contact-form-container">
					<h2><?php esc_html_e( 'Send Us a Message', 'oha-theme' ); ?></h2>
					<p><?php esc_html_e( 'Have a question or want to get involved? Fill out the form below and we\'ll get back to you as soon as possible.', 'oha-theme' ); ?></p>
					
					<!-- Contact Form -->
					<form id="oha-contact-form" class="oha-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						
						<?php wp_nonce_field( 'oha_contact_form', 'oha_contact_nonce' ); ?>
						<input type="hidden" name="action" value="oha_contact_form_submit">
						
						<div class="form-row">
							<div class="form-group">
								<label for="contact-name" class="form-label">
									<?php esc_html_e( 'Full Name', 'oha-theme' ); ?>
									<span class="required">*</span>
								</label>
								<input type="text" id="contact-name" name="contact_name" class="form-input" required>
							</div>
							
							<div class="form-group">
								<label for="contact-email" class="form-label">
									<?php esc_html_e( 'Email Address', 'oha-theme' ); ?>
									<span class="required">*</span>
								</label>
								<input type="email" id="contact-email" name="contact_email" class="form-input" required>
							</div>
						</div>
						
						<div class="form-row">
							<div class="form-group">
								<label for="contact-phone" class="form-label">
									<?php esc_html_e( 'Phone Number', 'oha-theme' ); ?>
								</label>
								<input type="tel" id="contact-phone" name="contact_phone" class="form-input">
							</div>
							
							<div class="form-group">
								<label for="contact-subject" class="form-label">
									<?php esc_html_e( 'Subject', 'oha-theme' ); ?>
									<span class="required">*</span>
								</label>
								<select id="contact-subject" name="contact_subject" class="form-select" required>
									<option value=""><?php esc_html_e( 'Select a subject', 'oha-theme' ); ?></option>
									<option value="general"><?php esc_html_e( 'General Inquiry', 'oha-theme' ); ?></option>
									<option value="membership"><?php esc_html_e( 'Membership Information', 'oha-theme' ); ?></option>
									<option value="coaching"><?php esc_html_e( 'Coaching Programs', 'oha-theme' ); ?></option>
									<option value="tournaments"><?php esc_html_e( 'Tournaments & Events', 'oha-theme' ); ?></option>
									<option value="media"><?php esc_html_e( 'Media & Press', 'oha-theme' ); ?></option>
									<option value="sponsorship"><?php esc_html_e( 'Sponsorship Opportunities', 'oha-theme' ); ?></option>
									<option value="other"><?php esc_html_e( 'Other', 'oha-theme' ); ?></option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label for="contact-message" class="form-label">
								<?php esc_html_e( 'Message', 'oha-theme' ); ?>
								<span class="required">*</span>
							</label>
							<textarea id="contact-message" name="contact_message" class="form-textarea" rows="6" required placeholder="<?php esc_attr_e( 'Please provide details about your inquiry...', 'oha-theme' ); ?>"></textarea>
						</div>
						
						<!-- Honeypot field for spam protection -->
						<div class="honeypot-field" style="display: none;">
							<label for="contact-website"><?php esc_html_e( 'Website', 'oha-theme' ); ?></label>
							<input type="text" id="contact-website" name="contact_website" tabindex="-1">
						</div>
						
						<div class="form-group form-submit">
							<button type="submit" class="oha-btn oha-btn-primary oha-btn-large submit-btn">
								<span class="btn-text"><?php esc_html_e( 'Send Message', 'oha-theme' ); ?></span>
								<span class="btn-loading" style="display: none;">
									<i class="fas fa-spinner fa-spin"></i>
									<?php esc_html_e( 'Sending...', 'oha-theme' ); ?>
								</span>
							</button>
						</div>
						
					</form>
					
					<!-- Form Messages -->
					<div id="form-messages" class="form-messages" style="display: none;"></div>
					
				</div>
				
			</div>
		</section>
		
		<!-- Map Section (Optional) -->
		<section class="contact-map-section oha-section">
			<div class="map-container">
				<h2><?php esc_html_e( 'Find Us', 'oha-theme' ); ?></h2>
				<div class="map-wrapper">
					<!-- Placeholder for Google Maps or OpenStreetMap -->
					<div class="map-placeholder">
						<div class="map-placeholder-content">
							<i class="fas fa-map-marked-alt" aria-hidden="true"></i>
							<h3><?php esc_html_e( 'OHA Office Location', 'oha-theme' ); ?></h3>
							<p><?php esc_html_e( 'Interactive map integration can be added here with Google Maps or OpenStreetMap.', 'oha-theme' ); ?></p>
							<a href="https://maps.google.com/?q=Muscat,+Oman" target="_blank" rel="noopener" class="oha-btn oha-btn-outline">
								<i class="fas fa-external-link-alt"></i>
								<?php esc_html_e( 'View on Google Maps', 'oha-theme' ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!-- Page Content (if any) -->
		<?php
		while ( have_posts() ) :
			the_post();
			
			if ( get_the_content() ) :
			?>
				<section class="contact-page-content oha-section">
					<div class="page-content-wrapper">
						<?php
						the_content();
						
						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oha-theme' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>
				</section>
			<?php
			endif;
			
		endwhile; // End of the loop.
		?>
		
	</div>
</main><!-- #main -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('oha-contact-form');
    const formMessages = document.getElementById('form-messages');
    const submitBtn = contactForm.querySelector('.submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-flex';
            formMessages.style.display = 'none';
            
            // Get form data
            const formData = new FormData(contactForm);
            
            // Submit form via AJAX
            fetch(contactForm.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Reset button state
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                
                // Show message
                formMessages.style.display = 'block';
                formMessages.className = 'form-messages ' + (data.success ? 'success' : 'error');
                formMessages.innerHTML = data.message;
                
                // Reset form on success
                if (data.success) {
                    contactForm.reset();
                }
                
                // Scroll to message
                formMessages.scrollIntoView({ behavior: 'smooth', block: 'center' });
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Reset button state
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                
                // Show error message
                formMessages.style.display = 'block';
                formMessages.className = 'form-messages error';
                formMessages.innerHTML = '<?php esc_html_e( "An error occurred. Please try again later.", "oha-theme" ); ?>';
                
                formMessages.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
        });
    }
});
</script>

<?php
get_footer(); 