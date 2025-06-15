<?php
/**
 * Template Name: Latest Events (Grid)
 * Description: Displays all events in a clean 4-column grid.
 *
 * @package OHA_Theme
 */
get_header();

// Query all published events
$events_query = new WP_Query([
    'post_type'      => 'event',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'orderby'        => 'meta_value',
    'meta_key'       => '_oha_event_date',
    'order'          => 'ASC',
]);
?>
<main id="primary" class="site-main oha-events-page">
    <div class="oha-container">
        <header class="page-header">
            <h1 class="page-title">Events</h1>
            <div class="oha-underline"></div>
        </header>
        <?php if ($events_query->have_posts()) : ?>
            <div class="events-grid">
                <?php while ($events_query->have_posts()) : $events_query->the_post();
                    $event_date = get_post_meta(get_the_ID(), '_oha_event_date', true);
                    $event_location = get_post_meta(get_the_ID(), '_oha_event_location', true);
                    $event_status = get_post_meta(get_the_ID(), '_oha_event_status', true);
                ?>
                <article class="event-card">
                    <div class="event-thumbnail">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', ['loading' => 'lazy']); ?>
                        <?php else : ?>
                            <div class="event-placeholder">
                                <span class="event-icon">🏑</span>
                            </div>
                        <?php endif; ?>
                        <?php if ($event_status) : ?>
                            <div class="event-status-badge event-status-<?php echo esc_attr($event_status); ?>">
                                <?php echo esc_html(ucfirst($event_status)); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="event-card-content">
                        <h3 class="event-card-title"><?php the_title(); ?></h3>
                        <div class="event-card-meta">
                            <?php if ($event_date) : ?>
                                <div class="event-meta-date">
                                    <span class="date-icon">📅</span>
                                    <?php echo esc_html(date('M j, Y', strtotime($event_date))); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($event_location) : ?>
                                <div class="event-meta-location">
                                    <span class="location-icon">📍</span>
                                    <?php echo esc_html($event_location); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <div class="oha-no-content">
                <h3>No Events Found</h3>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php wp_reset_postdata(); get_footer(); ?> 