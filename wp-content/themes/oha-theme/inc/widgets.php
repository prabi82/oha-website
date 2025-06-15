<?php
/**
 * Custom Widgets for OHA Theme
 *
 * @package OHA_Theme
 */

/**
 * Recent Videos Widget
 */
class OHA_Recent_Videos_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'oha_recent_videos',
            esc_html__( 'OHA Recent Videos', 'oha-theme' ),
            array(
                'description' => esc_html__( 'Display recent videos from OHA.', 'oha-theme' ),
                'classname' => 'oha-recent-videos-widget',
            )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Videos', 'oha-theme' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        
        echo $args['before_widget'];
        
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
        }
        
        $videos = oha_get_videos( array(
            'posts_per_page' => $number,
            'post_status' => 'publish'
        ) );
        
        if ( $videos->have_posts() ) :
        ?>
            <div class="recent-videos-list">
                <?php while ( $videos->have_posts() ) : $videos->the_post(); ?>
                    <div class="recent-video-item">
                        <div class="video-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                <?php else : ?>
                                    <div class="video-placeholder-thumb">
                                        <i class="fas fa-play"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="play-overlay">
                                    <i class="fas fa-play"></i>
                                </div>
                            </a>
                        </div>
                        <div class="video-info">
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <span class="video-date"><?php echo esc_html( get_the_date() ); ?></span>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php
        else :
        ?>
            <p><?php esc_html_e( 'No videos found.', 'oha-theme' ); ?></p>
        <?php
        endif;
        wp_reset_postdata();
        
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Recent Videos', 'oha-theme' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'oha-theme' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_attr_e( 'Number of videos to show:', 'oha-theme' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 3;
        
        return $instance;
    }
}

/**
 * Upcoming Events Widget
 */
class OHA_Upcoming_Events_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'oha_upcoming_events',
            esc_html__( 'OHA Upcoming Events', 'oha-theme' ),
            array(
                'description' => esc_html__( 'Display upcoming events from OHA.', 'oha-theme' ),
                'classname' => 'oha-upcoming-events-widget',
            )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Upcoming Events', 'oha-theme' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        
        echo $args['before_widget'];
        
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
        }
        
        $current_date = current_time( 'Y-m-d' );
        $events = oha_get_events( array(
            'posts_per_page' => $number,
            'meta_query' => array(
                array(
                    'key' => 'event_start_date',
                    'value' => $current_date,
                    'compare' => '>='
                )
            ),
            'meta_key' => 'event_start_date',
            'orderby' => 'meta_value',
            'order' => 'ASC'
        ) );
        
        if ( $events->have_posts() ) :
        ?>
            <div class="upcoming-events-widget-list">
                <?php while ( $events->have_posts() ) : $events->the_post(); ?>
                    <?php
                    $event_start_date = get_post_meta( get_the_ID(), 'event_start_date', true );
                    $event_time = get_post_meta( get_the_ID(), 'event_time', true );
                    $event_location = get_post_meta( get_the_ID(), 'event_location', true );
                    ?>
                    <div class="upcoming-event-widget-item">
                        <?php if ( $event_start_date ) : ?>
                            <div class="event-date-widget">
                                <span class="event-day"><?php echo esc_html( date_i18n( 'd', strtotime( $event_start_date ) ) ); ?></span>
                                <span class="event-month"><?php echo esc_html( date_i18n( 'M', strtotime( $event_start_date ) ) ); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="event-info-widget">
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <?php if ( $event_time ) : ?>
                                <span class="event-time-widget">
                                    <i class="fas fa-clock"></i>
                                    <?php echo esc_html( $event_time ); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ( $event_location ) : ?>
                                <span class="event-location-widget">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php echo esc_html( $event_location ); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php
        else :
        ?>
            <p><?php esc_html_e( 'No upcoming events.', 'oha-theme' ); ?></p>
        <?php
        endif;
        wp_reset_postdata();
        
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Upcoming Events', 'oha-theme' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'oha-theme' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_attr_e( 'Number of events to show:', 'oha-theme' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 3;
        
        return $instance;
    }
}

/**
 * Team Highlights Widget
 */
class OHA_Team_Highlights_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'oha_team_highlights',
            esc_html__( 'OHA Team Highlights', 'oha-theme' ),
            array(
                'description' => esc_html__( 'Display featured team members.', 'oha-theme' ),
                'classname' => 'oha-team-highlights-widget',
            )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Team Highlights', 'oha-theme' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        
        echo $args['before_widget'];
        
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
        }
        
        $team_members = oha_get_team_members( array(
            'posts_per_page' => $number,
            'orderby' => 'rand'
        ) );
        
        if ( $team_members->have_posts() ) :
        ?>
            <div class="team-highlights-list">
                <?php while ( $team_members->have_posts() ) : $team_members->the_post(); ?>
                    <?php
                    $position = get_post_meta( get_the_ID(), 'position', true );
                    $email = get_post_meta( get_the_ID(), 'email', true );
                    ?>
                    <div class="team-highlight-item">
                        <div class="team-photo-widget">
                            <a href="<?php the_permalink(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'thumbnail' ); ?>
                                <?php else : ?>
                                    <div class="team-placeholder-widget">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="team-info-widget">
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <?php if ( $position ) : ?>
                                <span class="team-position-widget"><?php echo esc_html( $position ); ?></span>
                            <?php endif; ?>
                            <?php if ( $email ) : ?>
                                <a href="mailto:<?php echo esc_attr( $email ); ?>" class="team-email-widget">
                                    <i class="fas fa-envelope"></i>
                                    <?php esc_html_e( 'Contact', 'oha-theme' ); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php
        else :
        ?>
            <p><?php esc_html_e( 'No team members found.', 'oha-theme' ); ?></p>
        <?php
        endif;
        wp_reset_postdata();
        
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Team Highlights', 'oha-theme' );
        $number = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : 3;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'oha-theme' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_attr_e( 'Number of team members to show:', 'oha-theme' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 3;
        
        return $instance;
    }
}

/**
 * Social Media Widget
 */
class OHA_Social_Media_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'oha_social_media',
            esc_html__( 'OHA Social Media', 'oha-theme' ),
            array(
                'description' => esc_html__( 'Display social media links with follower counts.', 'oha-theme' ),
                'classname' => 'oha-social-media-widget',
            )
        );
    }

    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Follow Us', 'oha-theme' );
        $show_labels = ! empty( $instance['show_labels'] ) ? true : false;
        
        echo $args['before_widget'];
        
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $title ) . $args['after_title'];
        }
        
        // Get social media URLs from customizer
        $facebook_url = get_theme_mod( 'oha_facebook_url' );
        $twitter_url = get_theme_mod( 'oha_twitter_url' );
        $instagram_url = get_theme_mod( 'oha_instagram_url' );
        $youtube_url = get_theme_mod( 'oha_youtube_url' );
        
        if ( $facebook_url || $twitter_url || $instagram_url || $youtube_url ) :
        ?>
            <div class="social-media-widget-list">
                <?php if ( $facebook_url ) : ?>
                    <a href="<?php echo esc_url( $facebook_url ); ?>" target="_blank" rel="noopener" class="social-widget-link facebook">
                        <i class="fab fa-facebook-f"></i>
                        <?php if ( $show_labels ) : ?>
                            <span><?php esc_html_e( 'Facebook', 'oha-theme' ); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
                
                <?php if ( $twitter_url ) : ?>
                    <a href="<?php echo esc_url( $twitter_url ); ?>" target="_blank" rel="noopener" class="social-widget-link twitter">
                        <i class="fab fa-twitter"></i>
                        <?php if ( $show_labels ) : ?>
                            <span><?php esc_html_e( 'Twitter', 'oha-theme' ); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
                
                <?php if ( $instagram_url ) : ?>
                    <a href="<?php echo esc_url( $instagram_url ); ?>" target="_blank" rel="noopener" class="social-widget-link instagram">
                        <i class="fab fa-instagram"></i>
                        <?php if ( $show_labels ) : ?>
                            <span><?php esc_html_e( 'Instagram', 'oha-theme' ); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
                
                <?php if ( $youtube_url ) : ?>
                    <a href="<?php echo esc_url( $youtube_url ); ?>" target="_blank" rel="noopener" class="social-widget-link youtube">
                        <i class="fab fa-youtube"></i>
                        <?php if ( $show_labels ) : ?>
                            <span><?php esc_html_e( 'YouTube', 'oha-theme' ); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php
        else :
        ?>
            <p><?php esc_html_e( 'No social media links configured.', 'oha-theme' ); ?></p>
        <?php
        endif;
        
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Follow Us', 'oha-theme' );
        $show_labels = ! empty( $instance['show_labels'] ) ? true : false;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'oha-theme' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked( $show_labels ); ?> id="<?php echo esc_attr( $this->get_field_id( 'show_labels' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_labels' ) ); ?>">
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_labels' ) ); ?>"><?php esc_attr_e( 'Show platform labels', 'oha-theme' ); ?></label>
        </p>
        <p>
            <small><?php esc_html_e( 'Configure social media URLs in Appearance > Customize > Social Media.', 'oha-theme' ); ?></small>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['show_labels'] = ! empty( $new_instance['show_labels'] ) ? true : false;
        
        return $instance;
    }
}

/**
 * Register Widgets
 */
function oha_register_widgets() {
    register_widget( 'OHA_Recent_Videos_Widget' );
    register_widget( 'OHA_Upcoming_Events_Widget' );
    register_widget( 'OHA_Team_Highlights_Widget' );
    register_widget( 'OHA_Social_Media_Widget' );
}
add_action( 'widgets_init', 'oha_register_widgets' ); 