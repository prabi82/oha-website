<?php
/**
 * Template part for displaying upcoming events section
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

// Get upcoming events
$events_query = new WP_Query( array(
    'post_type' => 'event',
    'post_status' => 'publish',
    'posts_per_page' => 4,
    'meta_query' => array(
        array(
            'key' => '_oha_event_status',
            'value' => array( 'upcoming', 'ongoing', 'completed' ),
            'compare' => 'IN'
        )
    ),
    'meta_key' => '_oha_event_date',
    'orderby' => 'meta_value',
    'order' => 'DESC'
) );
?>

<section class="oha-upcoming-events" id="upcoming-events">
    <div class="events-overlay-container">
        
        <?php if ( $events_query->have_posts() ) : ?>
            <div class="events-thumbnails-container">
                <div class="oha-container">
                    <div class="events-grid">
                        
                        <?php while ( $events_query->have_posts() ) : $events_query->the_post(); ?>
                            <?php
                            // Get event metadata
                            $event_date = get_post_meta( get_the_ID(), '_oha_event_date', true );
                            $event_time = get_post_meta( get_the_ID(), '_oha_event_time', true );
                            $event_location = get_post_meta( get_the_ID(), '_oha_event_location', true );
                            $event_status = get_post_meta( get_the_ID(), '_oha_event_status', true );
                            
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
                            
                            <article class="event-card" data-event-id="<?php echo esc_attr( get_the_ID() ); ?>">
                                
                                <!-- Event Thumbnail -->
                                <div class="event-thumbnail">
                                    <a href="<?php the_permalink(); ?>" class="event-link">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'medium_large', array( 'loading' => 'lazy' ) ); ?>
                                        <?php else : ?>
                                            <div class="event-placeholder">
                                                <div class="event-placeholder-content">
                                                    <span class="event-icon">🏑</span>
                                                    <span class="event-placeholder-text"><?php echo esc_html( get_the_title() ); ?></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Event Status Badge -->
                                        <?php if ( $event_status ) : ?>
                                            <div class="event-status-badge event-status-<?php echo esc_attr( $event_status ); ?>">
                                                <?php echo esc_html( ucfirst( $event_status ) ); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!-- Hover Overlay with Event Info -->
                                        <div class="event-hover-overlay">
                                            <div class="event-hover-content">
                                                <h3 class="event-hover-title">
                                                    <?php the_title(); ?>
                                                </h3>
                                                <?php if ( $formatted_date ) : ?>
                                                    <div class="event-hover-date">
                                                        <span class="date-icon">📅</span>
                                                        <?php echo esc_html( $formatted_date ); ?>
                                                        <?php if ( $event_time ) : ?>
                                                            <span class="event-hover-time">at <?php echo esc_html( $event_time ); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if ( $event_location ) : ?>
                                                    <div class="event-hover-location">
                                                        <span class="location-icon">📍</span>
                                                        <?php echo esc_html( $event_location ); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                            </article>
                            
                        <?php endwhile; ?>
                        
                    </div>
                </div>
            </div>
            
        <?php else : ?>
            <!-- No events found -->
            <div class="events-no-content">
                <div class="oha-container">
                    <div class="oha-no-content">
                        <div class="oha-no-content-icon">
                            <span class="no-content-event-icon">📅</span>
                        </div>
                        <h3><?php esc_html_e( 'No Events Found', 'oha-theme' ); ?></h3>
                        <p><?php esc_html_e( 'Check back soon for exciting hockey events and tournaments.', 'oha-theme' ); ?></p>
                        
                        <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                            <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=event' ) ); ?>" class="oha-btn oha-btn-primary">
                                <?php esc_html_e( 'Add First Event', 'oha-theme' ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
</section>

<?php wp_reset_postdata(); ?> 