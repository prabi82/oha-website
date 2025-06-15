<?php
/**
 * The template for displaying event archives
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

get_header();
?>

<main id="primary" class="site-main">

	<header class="page-header oha-archive-header">
		<div class="oha-container">
			<div class="archive-header-content">
				<h1 class="page-title"><?php esc_html_e( 'All Events', 'oha-theme' ); ?></h1>
				<p class="archive-description">
					<?php esc_html_e( 'Discover all the exciting hockey events and tournaments organized by the Oman Hockey Association.', 'oha-theme' ); ?>
				</p>
			</div>
		</div>
	</header><!-- .page-header -->

	<section class="oha-section oha-events-archive">
		<div class="oha-container">
			
			<?php if ( have_posts() ) : ?>
				
				<div class="events-archive-grid">
					
					<?php while ( have_posts() ) : the_post(); ?>
						<?php
						// Get event metadata
						$event_date = get_post_meta( get_the_ID(), '_oha_event_date', true );
						$event_time = get_post_meta( get_the_ID(), '_oha_event_time', true );
						$event_location = get_post_meta( get_the_ID(), '_oha_event_location', true );
						$event_status = get_post_meta( get_the_ID(), '_oha_event_status', true );
						$event_price = get_post_meta( get_the_ID(), '_oha_event_price', true );
						
						// Format date
						$formatted_date = '';
						$formatted_month = '';
						$formatted_day = '';
						if ( $event_date ) {
							$date_obj = DateTime::createFromFormat( 'Y-m-d', $event_date );
							if ( $date_obj ) {
								$formatted_month = $date_obj->format( 'M' );
								$formatted_day = $date_obj->format( 'd' );
								$formatted_date = $date_obj->format( get_option( 'date_format' ) );
							}
						}
						?>
						
						<article class="event-archive-card" data-event-id="<?php echo esc_attr( get_the_ID() ); ?>">
							
							<!-- Event Thumbnail -->
							<div class="event-archive-thumbnail">
								<a href="<?php the_permalink(); ?>" class="event-archive-link">
									<?php if ( has_post_thumbnail() ) : ?>
										<?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
									<?php else : ?>
										<div class="event-archive-placeholder">
											<div class="event-archive-placeholder-content">
												<span class="event-archive-icon">🏑</span>
											</div>
										</div>
									<?php endif; ?>
									
									<!-- Event Date Badge -->
									<?php if ( $formatted_month && $formatted_day ) : ?>
										<div class="event-archive-date-badge">
											<span class="event-archive-month"><?php echo esc_html( $formatted_month ); ?></span>
											<span class="event-archive-day"><?php echo esc_html( $formatted_day ); ?></span>
										</div>
									<?php endif; ?>
									
									<!-- Event Status Badge -->
									<?php if ( $event_status ) : ?>
										<div class="event-archive-status-badge event-status-<?php echo esc_attr( $event_status ); ?>">
											<?php echo esc_html( ucfirst( $event_status ) ); ?>
										</div>
									<?php endif; ?>
								</a>
							</div>
							
							<!-- Event Content -->
							<div class="event-archive-content">
								<h3 class="event-archive-title">
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</h3>
								
								<div class="event-archive-meta">
									<?php if ( $formatted_date ) : ?>
										<span class="event-archive-date">
											<span class="date-icon">📅</span>
											<?php echo esc_html( $formatted_date ); ?>
											<?php if ( $event_time ) : ?>
												<span class="event-archive-time"> at <?php echo esc_html( $event_time ); ?></span>
											<?php endif; ?>
										</span>
									<?php endif; ?>
									
									<?php if ( $event_location ) : ?>
										<span class="event-archive-location">
											<span class="location-icon">📍</span>
											<?php echo esc_html( $event_location ); ?>
										</span>
									<?php endif; ?>
									
									<?php if ( $event_price ) : ?>
										<span class="event-archive-price">
											<span class="price-icon">💰</span>
											<?php echo esc_html( $event_price ); ?>
										</span>
									<?php endif; ?>
								</div>
								
								<?php if ( has_excerpt() || get_the_content() ) : ?>
									<div class="event-archive-excerpt">
										<?php 
										if ( has_excerpt() ) {
											the_excerpt();
										} else {
											echo '<p>' . wp_trim_words( get_the_content(), 20, '...' ) . '</p>';
										}
										?>
									</div>
								<?php endif; ?>
								
								<a href="<?php the_permalink(); ?>" class="event-archive-read-more">
									<?php esc_html_e( 'Learn More', 'oha-theme' ); ?>
									<span class="read-more-arrow">→</span>
								</a>
							</div>
							
						</article>
						
					<?php endwhile; ?>
					
				</div>
				
				<?php
				// Pagination
				the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __( 'Previous', 'oha-theme' ),
					'next_text' => __( 'Next', 'oha-theme' ) . ' <i class="fas fa-chevron-right"></i>',
				) );
				?>
				
			<?php else : ?>
				
				<!-- No events found -->
				<div class="oha-no-content">
					<div class="oha-no-content-icon">
						<span class="no-content-event-icon">📅</span>
					</div>
					<h3><?php esc_html_e( 'No Events Found', 'oha-theme' ); ?></h3>
					<p><?php esc_html_e( 'There are currently no events available. Please check back later for exciting hockey events and tournaments.', 'oha-theme' ); ?></p>
					
					<?php if ( current_user_can( 'edit_posts' ) ) : ?>
						<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=event' ) ); ?>" class="oha-btn oha-btn-primary">
							<?php esc_html_e( 'Add First Event', 'oha-theme' ); ?>
						</a>
					<?php endif; ?>
				</div>
				
			<?php endif; ?>
			
		</div>
	</section>

</main><!-- #main -->

<?php
get_sidebar();
get_footer(); 