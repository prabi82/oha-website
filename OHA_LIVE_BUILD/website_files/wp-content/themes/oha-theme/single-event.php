<?php
/**
 * The template for displaying single event posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

get_header();
?>

<main class="oha-single-event">
	<div class="oha-container">
		
		<?php while ( have_posts() ) : the_post(); ?>
			
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-event-layout' ); ?>>
				
				<!-- Event Hero Section -->
				<div class="event-hero-section">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="event-hero-image">
							<?php the_post_thumbnail( 'large' ); ?>
							<div class="event-hero-overlay">
								<div class="event-hero-content">
									<?php
									$event_date = get_post_meta( get_the_ID(), '_oha_event_date', true );
									$event_time = get_post_meta( get_the_ID(), '_oha_event_time', true );
									$event_status = get_post_meta( get_the_ID(), '_oha_event_status', true ) ?: 'upcoming';
									
									if ( $event_date ) :
										$date_obj = DateTime::createFromFormat( 'Y-m-d', $event_date );
										if ( $date_obj ) :
									?>
										<div class="event-date-hero">
											<span class="event-month"><?php echo $date_obj->format( 'M' ); ?></span>
											<span class="event-day"><?php echo $date_obj->format( 'd' ); ?></span>
											<span class="event-year"><?php echo $date_obj->format( 'Y' ); ?></span>
										</div>
									<?php 
										endif;
									endif; 
									?>
									
									<div class="event-status-badge <?php echo esc_attr( $event_status ); ?>">
										<?php
										switch ( $event_status ) {
											case 'upcoming':
												echo '<i class="fas fa-calendar-plus"></i> ' . esc_html__( 'Upcoming', 'oha-theme' );
												break;
											case 'ongoing':
												echo '<i class="fas fa-calendar-check"></i> ' . esc_html__( 'Ongoing', 'oha-theme' );
												break;
											case 'completed':
												echo '<i class="fas fa-calendar-times"></i> ' . esc_html__( 'Completed', 'oha-theme' );
												break;
											case 'cancelled':
												echo '<i class="fas fa-ban"></i> ' . esc_html__( 'Cancelled', 'oha-theme' );
												break;
											default:
												echo '<i class="fas fa-calendar"></i> ' . esc_html( ucfirst( $event_status ) );
										}
										?>
									</span>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<!-- Event Content Section -->
				<div class="single-event-content">
					
					<!-- Event Header -->
					<header class="single-event-header">
						<h1 class="single-event-title"><?php the_title(); ?></h1>
						
						<div class="event-meta">
							<div class="event-meta-primary">
								<?php if ( $event_date ) : ?>
									<div class="meta-item">
										<i class="far fa-calendar-alt" aria-hidden="true"></i>
										<time datetime="<?php echo esc_attr( $event_date ); ?>">
											<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $event_date ) ) ); ?>
										</time>
									</div>
								<?php endif; ?>
								
								<?php if ( $event_time ) : ?>
									<div class="meta-item">
										<i class="far fa-clock" aria-hidden="true"></i>
										<span><?php echo esc_html( $event_time ); ?></span>
									</div>
								<?php endif; ?>
								
								<?php
								$event_location = get_post_meta( get_the_ID(), '_oha_event_location', true );
								if ( $event_location ) :
								?>
									<div class="meta-item">
										<i class="fas fa-map-marker-alt" aria-hidden="true"></i>
										<span><?php echo esc_html( $event_location ); ?></span>
									</div>
								<?php endif; ?>
								
								<?php
								$event_categories = get_the_terms( get_the_ID(), 'event_category' );
								if ( $event_categories && ! is_wp_error( $event_categories ) ) :
								?>
									<div class="meta-item">
										<i class="fas fa-tag" aria-hidden="true"></i>
										<span>
											<?php
											$category_names = array();
											foreach ( $event_categories as $category ) {
												$category_names[] = '<a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
											}
											echo implode( ', ', $category_names );
											?>
										</span>
									</div>
								<?php endif; ?>
							</div>
							
							<!-- Event Actions -->
							<div class="event-actions-header">
								<?php if ( $event_status === 'upcoming' ) : ?>
									<button class="event-action-btn rsvp-btn" data-event-id="<?php the_ID(); ?>">
										<i class="fas fa-calendar-plus"></i>
										<span><?php esc_html_e( 'RSVP', 'oha-theme' ); ?></span>
									</button>
								<?php endif; ?>
								
								<button class="event-action-btn add-to-calendar" data-event-id="<?php the_ID(); ?>">
									<i class="fas fa-calendar-plus"></i>
									<span><?php esc_html_e( 'Add to Calendar', 'oha-theme' ); ?></span>
								</button>
								
								<button class="event-action-btn share-event">
									<i class="fas fa-share"></i>
									<span><?php esc_html_e( 'Share', 'oha-theme' ); ?></span>
								</button>
							</div>
						</div>
					</header>

					<!-- Event Description -->
					<div class="single-event-description">
						<?php
						the_content();
						
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oha-theme' ),
							'after'  => '</div>',
						) );
						?>
					</div>

					<!-- Event Details Grid -->
					<div class="event-details-section">
						<h3><?php esc_html_e( 'Event Details', 'oha-theme' ); ?></h3>
						
						<div class="event-details-grid">
							<div class="event-details-main">
								<?php if ( $event_date && $event_time ) : ?>
									<div class="detail-item">
										<div class="detail-icon">
											<i class="fas fa-calendar-alt"></i>
										</div>
										<div class="detail-content">
											<strong><?php esc_html_e( 'Date & Time', 'oha-theme' ); ?></strong>
											<span>
												<?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $event_date ) ) ); ?>
												<?php if ( $event_time ) : ?>
													<?php esc_html_e( 'at', 'oha-theme' ); ?> <?php echo esc_html( $event_time ); ?>
												<?php endif; ?>
											</span>
										</div>
									</div>
								<?php endif; ?>
								
								<?php if ( $event_location ) : ?>
									<div class="detail-item">
										<div class="detail-icon">
											<i class="fas fa-map-marker-alt"></i>
										</div>
										<div class="detail-content">
											<strong><?php esc_html_e( 'Location', 'oha-theme' ); ?></strong>
											<span><?php echo esc_html( $event_location ); ?></span>
											<?php
											$event_address = get_post_meta( get_the_ID(), '_oha_event_address', true );
											if ( $event_address ) :
											?>
												<div class="event-address">
													<i class="fas fa-map"></i>
													<?php echo esc_html( $event_address ); ?>
													<a href="https://maps.google.com/?q=<?php echo urlencode( $event_address ); ?>" target="_blank" class="directions-link">
														<?php esc_html_e( 'Get Directions', 'oha-theme' ); ?>
													</a>
												</div>
											<?php endif; ?>
										</div>
									</div>
								<?php endif; ?>
								
								<?php
								$event_organizer = get_post_meta( get_the_ID(), '_oha_event_organizer', true );
								if ( $event_organizer ) :
								?>
									<div class="detail-item">
										<div class="detail-icon">
											<i class="fas fa-user-tie"></i>
										</div>
										<div class="detail-content">
											<strong><?php esc_html_e( 'Organizer', 'oha-theme' ); ?></strong>
											<span><?php echo esc_html( $event_organizer ); ?></span>
										</div>
									</div>
								<?php endif; ?>
								
								<?php
								$event_price = get_post_meta( get_the_ID(), '_oha_event_price', true );
								if ( $event_price ) :
								?>
									<div class="detail-item">
										<div class="detail-icon">
											<i class="fas fa-ticket-alt"></i>
										</div>
										<div class="detail-content">
											<strong><?php esc_html_e( 'Price', 'oha-theme' ); ?></strong>
											<span class="event-price">
												<?php 
												if ( strtolower( $event_price ) === 'free' ) {
													echo '<span class="free-event">' . esc_html__( 'Free', 'oha-theme' ) . '</span>';
												} else {
													echo esc_html( $event_price );
												}
												?>
											</span>
										</div>
									</div>
								<?php endif; ?>
								
								<?php
								$event_capacity = get_post_meta( get_the_ID(), '_oha_event_capacity', true );
								$event_registered = get_post_meta( get_the_ID(), '_oha_event_registered', true ) ?: 0;
								if ( $event_capacity ) :
								?>
									<div class="detail-item">
										<div class="detail-icon">
											<i class="fas fa-users"></i>
										</div>
										<div class="detail-content">
											<strong><?php esc_html_e( 'Capacity', 'oha-theme' ); ?></strong>
											<span>
												<?php echo esc_html( $event_registered ); ?> / <?php echo esc_html( $event_capacity ); ?> <?php esc_html_e( 'attendees', 'oha-theme' ); ?>
												<?php
												$percentage = ( $event_capacity > 0 ) ? ( $event_registered / $event_capacity ) * 100 : 0;
												?>
												<div class="capacity-bar">
													<div class="capacity-fill" style="width: <?php echo esc_attr( $percentage ); ?>%"></div>
												</div>
												<?php if ( $percentage >= 90 ) : ?>
													<span class="capacity-warning"><?php esc_html_e( 'Almost Full!', 'oha-theme' ); ?></span>
												<?php endif; ?>
											</span>
										</div>
									</div>
								<?php endif; ?>
							</div>
							
							<!-- Event Sidebar Info -->
							<div class="event-details-sidebar">
								<!-- Contact Information -->
								<?php
								$event_contact_email = get_post_meta( get_the_ID(), '_oha_event_contact_email', true );
								$event_contact_phone = get_post_meta( get_the_ID(), '_oha_event_contact_phone', true );
								
								if ( $event_contact_email || $event_contact_phone ) :
								?>
									<div class="event-contact-info">
										<h4><?php esc_html_e( 'Contact Information', 'oha-theme' ); ?></h4>
										<?php if ( $event_contact_email ) : ?>
											<div class="contact-item">
												<i class="fas fa-envelope"></i>
												<a href="mailto:<?php echo esc_attr( $event_contact_email ); ?>">
													<?php echo esc_html( $event_contact_email ); ?>
												</a>
											</div>
										<?php endif; ?>
										
										<?php if ( $event_contact_phone ) : ?>
											<div class="contact-item">
												<i class="fas fa-phone"></i>
												<a href="tel:<?php echo esc_attr( $event_contact_phone ); ?>">
													<?php echo esc_html( $event_contact_phone ); ?>
												</a>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								
								<!-- Social Sharing -->
								<div class="event-social-share">
									<h4><?php esc_html_e( 'Share This Event', 'oha-theme' ); ?></h4>
									<div class="social-share-buttons">
										<a href="#" class="share-btn facebook" data-platform="facebook" title="<?php esc_attr_e( 'Share on Facebook', 'oha-theme' ); ?>">
											<i class="fab fa-facebook-f"></i>
										</a>
										<a href="#" class="share-btn twitter" data-platform="twitter" title="<?php esc_attr_e( 'Share on Twitter', 'oha-theme' ); ?>">
											<i class="fab fa-twitter"></i>
										</a>
										<a href="#" class="share-btn linkedin" data-platform="linkedin" title="<?php esc_attr_e( 'Share on LinkedIn', 'oha-theme' ); ?>">
											<i class="fab fa-linkedin-in"></i>
										</a>
										<a href="#" class="share-btn whatsapp" data-platform="whatsapp" title="<?php esc_attr_e( 'Share on WhatsApp', 'oha-theme' ); ?>">
											<i class="fab fa-whatsapp"></i>
										</a>
									</div>
								</div>
								
								<!-- Quick Actions -->
								<div class="event-quick-actions">
									<h4><?php esc_html_e( 'Quick Actions', 'oha-theme' ); ?></h4>
									<div class="quick-actions-buttons">
										<button class="quick-action-btn print-event" onclick="window.print()">
											<i class="fas fa-print"></i>
											<span><?php esc_html_e( 'Print Event', 'oha-theme' ); ?></span>
										</button>
										
										<button class="quick-action-btn bookmark-event" data-event-id="<?php the_ID(); ?>">
											<i class="far fa-bookmark"></i>
											<span><?php esc_html_e( 'Bookmark', 'oha-theme' ); ?></span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Event Registration Section -->
					<?php if ( $event_status === 'upcoming' ) : ?>
						<div class="event-registration-section">
							<h3><?php esc_html_e( 'Event Registration', 'oha-theme' ); ?></h3>
							
							<?php
							$registration_deadline = get_post_meta( get_the_ID(), '_oha_event_registration_deadline', true );
							$registration_open = true;
							
							if ( $registration_deadline ) {
								$deadline_date = DateTime::createFromFormat( 'Y-m-d', $registration_deadline );
								$today = new DateTime();
								if ( $deadline_date < $today ) {
									$registration_open = false;
								}
							}
							
							if ( $event_capacity && $event_registered >= $event_capacity ) {
								$registration_open = false;
							}
							?>
							
							<?php if ( $registration_open ) : ?>
								<div class="registration-form-container">
									<p><?php esc_html_e( 'Register for this event to secure your spot.', 'oha-theme' ); ?></p>
									
									<form class="event-registration-form" data-event-id="<?php the_ID(); ?>">
										<?php wp_nonce_field( 'oha_event_registration', 'registration_nonce' ); ?>
										
										<div class="form-row">
											<div class="form-group">
												<label for="registration_name" class="form-label">
													<?php esc_html_e( 'Full Name', 'oha-theme' ); ?> <span class="required">*</span>
												</label>
												<input type="text" id="registration_name" name="registration_name" class="form-input" required>
											</div>
											
											<div class="form-group">
												<label for="registration_email" class="form-label">
													<?php esc_html_e( 'Email Address', 'oha-theme' ); ?> <span class="required">*</span>
												</label>
												<input type="email" id="registration_email" name="registration_email" class="form-input" required>
											</div>
										</div>
										
										<div class="form-row">
											<div class="form-group">
												<label for="registration_phone" class="form-label">
													<?php esc_html_e( 'Phone Number', 'oha-theme' ); ?>
												</label>
												<input type="tel" id="registration_phone" name="registration_phone" class="form-input">
											</div>
											
											<div class="form-group">
												<label for="registration_guests" class="form-label">
													<?php esc_html_e( 'Number of Guests', 'oha-theme' ); ?>
												</label>
												<select id="registration_guests" name="registration_guests" class="form-select">
													<option value="0"><?php esc_html_e( 'Just me', 'oha-theme' ); ?></option>
													<option value="1"><?php esc_html_e( '+1 Guest', 'oha-theme' ); ?></option>
													<option value="2"><?php esc_html_e( '+2 Guests', 'oha-theme' ); ?></option>
													<option value="3"><?php esc_html_e( '+3 Guests', 'oha-theme' ); ?></option>
													<option value="4"><?php esc_html_e( '+4 Guests', 'oha-theme' ); ?></option>
												</select>
											</div>
										</div>
										
										<div class="form-group">
											<label for="registration_notes" class="form-label">
												<?php esc_html_e( 'Special Requirements or Notes', 'oha-theme' ); ?>
											</label>
											<textarea id="registration_notes" name="registration_notes" class="form-textarea" rows="3" placeholder="<?php esc_attr_e( 'Any dietary restrictions, accessibility needs, or other requirements...', 'oha-theme' ); ?>"></textarea>
										</div>
										
										<div class="form-submit">
											<button type="submit" class="submit-btn">
												<span class="btn-text">
													<i class="fas fa-calendar-check"></i>
													<?php esc_html_e( 'Register for Event', 'oha-theme' ); ?>
												</span>
												<span class="btn-loading" style="display: none;">
													<i class="fas fa-spinner fa-spin"></i>
													<?php esc_html_e( 'Registering...', 'oha-theme' ); ?>
												</span>
											</button>
										</div>
										
										<div class="form-messages"></div>
									</form>
								</div>
							<?php else : ?>
								<div class="registration-closed">
									<i class="fas fa-times-circle"></i>
									<h4><?php esc_html_e( 'Registration Closed', 'oha-theme' ); ?></h4>
									<p>
										<?php 
										if ( $event_capacity && $event_registered >= $event_capacity ) {
											esc_html_e( 'This event has reached its maximum capacity.', 'oha-theme' );
										} elseif ( $registration_deadline ) {
											printf( 
												esc_html__( 'Registration deadline was %s.', 'oha-theme' ), 
												date_i18n( get_option( 'date_format' ), strtotime( $registration_deadline ) )
											);
										} else {
											esc_html_e( 'Registration is no longer available for this event.', 'oha-theme' );
										}
										?>
									</p>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<!-- Event Navigation -->
				<nav class="event-navigation">
					<h3><?php esc_html_e( 'Other Events', 'oha-theme' ); ?></h3>
					<div class="event-nav-links">
						<?php
						$prev_event = get_previous_post( false, '', 'event_category' );
						$next_event = get_next_post( false, '', 'event_category' );
						
						if ( $prev_event ) :
						?>
							<div class="nav-event nav-previous">
								<a href="<?php echo esc_url( get_permalink( $prev_event->ID ) ); ?>" rel="prev">
									<div class="nav-event-content">
										<span class="nav-subtitle">
											<i class="fas fa-chevron-left"></i>
											<?php esc_html_e( 'Previous Event', 'oha-theme' ); ?>
										</span>
										<h4 class="nav-title"><?php echo esc_html( get_the_title( $prev_event->ID ) ); ?></h4>
										<?php
										$prev_event_date = get_post_meta( $prev_event->ID, '_oha_event_date', true );
										if ( $prev_event_date ) :
										?>
											<span class="nav-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $prev_event_date ) ) ); ?></span>
										<?php endif; ?>
									</div>
									<div class="nav-event-thumbnail">
										<?php echo get_the_post_thumbnail( $prev_event->ID, 'thumbnail' ); ?>
									</div>
								</a>
							</div>
						<?php endif; ?>
						
						<?php if ( $next_event ) : ?>
							<div class="nav-event nav-next">
								<a href="<?php echo esc_url( get_permalink( $next_event->ID ) ); ?>" rel="next">
									<div class="nav-event-thumbnail">
										<?php echo get_the_post_thumbnail( $next_event->ID, 'thumbnail' ); ?>
									</div>
									<div class="nav-event-content">
										<span class="nav-subtitle">
											<?php esc_html_e( 'Next Event', 'oha-theme' ); ?>
											<i class="fas fa-chevron-right"></i>
										</span>
										<h4 class="nav-title"><?php echo esc_html( get_the_title( $next_event->ID ) ); ?></h4>
										<?php
										$next_event_date = get_post_meta( $next_event->ID, '_oha_event_date', true );
										if ( $next_event_date ) :
										?>
											<span class="nav-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $next_event_date ) ) ); ?></span>
										<?php endif; ?>
									</div>
								</a>
							</div>
						<?php endif; ?>
					</div>
				</nav>

				<!-- Related Events -->
				<?php
				$related_events = new WP_Query( array(
					'post_type' => 'event',
					'posts_per_page' => 3,
					'post__not_in' => array( get_the_ID() ),
					'meta_query' => array(
						array(
							'key' => '_oha_event_date',
							'value' => date( 'Y-m-d' ),
							'compare' => '>=',
						),
					),
					'meta_key' => '_oha_event_date',
					'orderby' => 'meta_value',
					'order' => 'ASC',
				) );
				
				if ( $related_events->have_posts() ) :
				?>
					<section class="related-events">
						<h3 class="related-events-title">
							<i class="fas fa-calendar-alt"></i>
							<?php esc_html_e( 'Upcoming Events', 'oha-theme' ); ?>
						</h3>
						<div class="related-events-grid">
							<?php while ( $related_events->have_posts() ) : $related_events->the_post(); ?>
								<div class="related-event-item">
									<div class="related-event-image">
										<a href="<?php the_permalink(); ?>">
											<?php if ( has_post_thumbnail() ) : ?>
												<?php the_post_thumbnail( 'medium' ); ?>
											<?php else : ?>
												<div class="event-placeholder-thumb">
													<i class="fas fa-calendar"></i>
												</div>
											<?php endif; ?>
											<?php
											$related_event_date = get_post_meta( get_the_ID(), '_oha_event_date', true );
											if ( $related_event_date ) :
												$related_date_obj = DateTime::createFromFormat( 'Y-m-d', $related_event_date );
												if ( $related_date_obj ) :
											?>
												<div class="event-date-overlay">
													<span class="event-month"><?php echo $related_date_obj->format( 'M' ); ?></span>
													<span class="event-day"><?php echo $related_date_obj->format( 'd' ); ?></span>
												</div>
											<?php 
												endif;
											endif; 
											?>
										</a>
									</div>
									<div class="related-event-content">
										<h4 class="related-event-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										</h4>
										<div class="related-event-meta">
											<?php if ( $related_event_date ) : ?>
												<span class="event-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $related_event_date ) ) ); ?></span>
											<?php endif; ?>
											<?php
											$related_event_location = get_post_meta( get_the_ID(), '_oha_event_location', true );
											if ( $related_event_location ) :
											?>
												<span class="event-location">
													<i class="fas fa-map-marker-alt"></i>
													<?php echo esc_html( $related_event_location ); ?>
												</span>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</section>
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>

			</article>

		<?php endwhile; ?>
		
	</div>
</main>

<?php
get_footer(); 