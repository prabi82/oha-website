<?php
/**
 * Custom Post Types for OHA Theme
 *
 * Register custom post types for OHA theme functionality
 *
 * @package OHA_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register OHA Videos Post Type
 */
function oha_register_videos_post_type() {
    $labels = array(
        'name'               => _x('Videos', 'post type general name', 'oha-theme'),
        'singular_name'      => _x('Video', 'post type singular name', 'oha-theme'),
        'menu_name'          => _x('Videos', 'admin menu', 'oha-theme'),
        'name_admin_bar'     => _x('Video', 'add new on admin bar', 'oha-theme'),
        'add_new'            => _x('Add New', 'video', 'oha-theme'),
        'add_new_item'       => __('Add New Video', 'oha-theme'),
        'new_item'           => __('New Video', 'oha-theme'),
        'edit_item'          => __('Edit Video', 'oha-theme'),
        'view_item'          => __('View Video', 'oha-theme'),
        'all_items'          => __('All Videos', 'oha-theme'),
        'search_items'       => __('Search Videos', 'oha-theme'),
        'parent_item_colon'  => __('Parent Videos:', 'oha-theme'),
        'not_found'          => __('No videos found.', 'oha-theme'),
        'not_found_in_trash' => __('No videos found in Trash.', 'oha-theme')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Description.', 'oha-theme'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'videos'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-video-alt3',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true,
    );

    register_post_type('oha_video', $args);
}
add_action('init', 'oha_register_videos_post_type');

/**
 * Register OHA Team Members Post Type
 */
function oha_register_team_post_type() {
    $labels = array(
        'name'               => _x('Team Members', 'post type general name', 'oha-theme'),
        'singular_name'      => _x('Team Member', 'post type singular name', 'oha-theme'),
        'menu_name'          => _x('Team Members', 'admin menu', 'oha-theme'),
        'name_admin_bar'     => _x('Team Member', 'add new on admin bar', 'oha-theme'),
        'add_new'            => _x('Add New', 'team member', 'oha-theme'),
        'add_new_item'       => __('Add New Team Member', 'oha-theme'),
        'new_item'           => __('New Team Member', 'oha-theme'),
        'edit_item'          => __('Edit Team Member', 'oha-theme'),
        'view_item'          => __('View Team Member', 'oha-theme'),
        'all_items'          => __('All Team Members', 'oha-theme'),
        'search_items'       => __('Search Team Members', 'oha-theme'),
        'parent_item_colon'  => __('Parent Team Members:', 'oha-theme'),
        'not_found'          => __('No team members found.', 'oha-theme'),
        'not_found_in_trash' => __('No team members found in Trash.', 'oha-theme')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Description.', 'oha-theme'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'team'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 6,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('team_member', $args);
}
add_action('init', 'oha_register_team_post_type');

/**
 * Register OHA Sponsors Post Type
 */
function oha_register_sponsors_post_type() {
    $labels = array(
        'name'               => _x('Sponsors', 'post type general name', 'oha-theme'),
        'singular_name'      => _x('Sponsor', 'post type singular name', 'oha-theme'),
        'menu_name'          => _x('Sponsors', 'admin menu', 'oha-theme'),
        'name_admin_bar'     => _x('Sponsor', 'add new on admin bar', 'oha-theme'),
        'add_new'            => _x('Add New', 'sponsor', 'oha-theme'),
        'add_new_item'       => __('Add New Sponsor', 'oha-theme'),
        'new_item'           => __('New Sponsor', 'oha-theme'),
        'edit_item'          => __('Edit Sponsor', 'oha-theme'),
        'view_item'          => __('View Sponsor', 'oha-theme'),
        'all_items'          => __('All Sponsors', 'oha-theme'),
        'search_items'       => __('Search Sponsors', 'oha-theme'),
        'parent_item_colon'  => __('Parent Sponsors:', 'oha-theme'),
        'not_found'          => __('No sponsors found.', 'oha-theme'),
        'not_found_in_trash' => __('No sponsors found in Trash.', 'oha-theme')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Description.', 'oha-theme'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'sponsors'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-awards',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('sponsor', $args);
}
add_action('init', 'oha_register_sponsors_post_type');

/**
 * Register OHA Events Post Type
 */
function oha_register_events_post_type() {
    $labels = array(
        'name'               => _x('Events', 'post type general name', 'oha-theme'),
        'singular_name'      => _x('Event', 'post type singular name', 'oha-theme'),
        'menu_name'          => _x('Events', 'admin menu', 'oha-theme'),
        'name_admin_bar'     => _x('Event', 'add new on admin bar', 'oha-theme'),
        'add_new'            => _x('Add New', 'event', 'oha-theme'),
        'add_new_item'       => __('Add New Event', 'oha-theme'),
        'new_item'           => __('New Event', 'oha-theme'),
        'edit_item'          => __('Edit Event', 'oha-theme'),
        'view_item'          => __('View Event', 'oha-theme'),
        'all_items'          => __('All Events', 'oha-theme'),
        'search_items'       => __('Search Events', 'oha-theme'),
        'parent_item_colon'  => __('Parent Events:', 'oha-theme'),
        'not_found'          => __('No events found.', 'oha-theme'),
        'not_found_in_trash' => __('No events found in Trash.', 'oha-theme')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Description.', 'oha-theme'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'events'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 8,
        'menu_icon'          => 'dashicons-calendar-alt',
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'       => true,
    );

    register_post_type('event', $args);
}
add_action('init', 'oha_register_events_post_type');

/**
 * Register OHA Slides Post Type (for homepage slider)
 */
function oha_register_slides_post_type() {
    $labels = array(
        'name'               => _x('Slides', 'post type general name', 'oha-theme'),
        'singular_name'      => _x('Slide', 'post type singular name', 'oha-theme'),
        'menu_name'          => _x('Homepage Slides', 'admin menu', 'oha-theme'),
        'name_admin_bar'     => _x('Slide', 'add new on admin bar', 'oha-theme'),
        'add_new'            => _x('Add New', 'slide', 'oha-theme'),
        'add_new_item'       => __('Add New Slide', 'oha-theme'),
        'new_item'           => __('New Slide', 'oha-theme'),
        'edit_item'          => __('Edit Slide', 'oha-theme'),
        'view_item'          => __('View Slide', 'oha-theme'),
        'all_items'          => __('All Slides', 'oha-theme'),
        'search_items'       => __('Search Slides', 'oha-theme'),
        'parent_item_colon'  => __('Parent Slides:', 'oha-theme'),
        'not_found'          => __('No slides found.', 'oha-theme'),
        'not_found_in_trash' => __('No slides found in Trash.', 'oha-theme')
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __('Description.', 'oha-theme'),
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 9,
        'menu_icon'          => 'dashicons-images-alt2',
        'supports'           => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'show_in_rest'       => true,
    );

    register_post_type('slide', $args);
}
add_action('init', 'oha_register_slides_post_type');

/**
 * Register custom taxonomies
 */
function oha_register_custom_taxonomies() {
    
    // Video Categories
    register_taxonomy('video_category', 'oha_video', array(
        'labels' => array(
            'name'              => _x('Video Categories', 'taxonomy general name', 'oha-theme'),
            'singular_name'     => _x('Video Category', 'taxonomy singular name', 'oha-theme'),
            'search_items'      => __('Search Video Categories', 'oha-theme'),
            'all_items'         => __('All Video Categories', 'oha-theme'),
            'parent_item'       => __('Parent Video Category', 'oha-theme'),
            'parent_item_colon' => __('Parent Video Category:', 'oha-theme'),
            'edit_item'         => __('Edit Video Category', 'oha-theme'),
            'update_item'       => __('Update Video Category', 'oha-theme'),
            'add_new_item'      => __('Add New Video Category', 'oha-theme'),
            'new_item_name'     => __('New Video Category Name', 'oha-theme'),
            'menu_name'         => __('Categories', 'oha-theme'),
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'video-category'),
        'show_in_rest'      => true,
    ));

    // Team Positions
    register_taxonomy('team_position', 'team_member', array(
        'labels' => array(
            'name'              => _x('Positions', 'taxonomy general name', 'oha-theme'),
            'singular_name'     => _x('Position', 'taxonomy singular name', 'oha-theme'),
            'search_items'      => __('Search Positions', 'oha-theme'),
            'all_items'         => __('All Positions', 'oha-theme'),
            'parent_item'       => __('Parent Position', 'oha-theme'),
            'parent_item_colon' => __('Parent Position:', 'oha-theme'),
            'edit_item'         => __('Edit Position', 'oha-theme'),
            'update_item'       => __('Update Position', 'oha-theme'),
            'add_new_item'      => __('Add New Position', 'oha-theme'),
            'new_item_name'     => __('New Position Name', 'oha-theme'),
            'menu_name'         => __('Positions', 'oha-theme'),
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'team-position'),
        'show_in_rest'      => true,
    ));

    // Event Categories
    register_taxonomy('event_category', 'event', array(
        'labels' => array(
            'name'              => _x('Event Categories', 'taxonomy general name', 'oha-theme'),
            'singular_name'     => _x('Event Category', 'taxonomy singular name', 'oha-theme'),
            'search_items'      => __('Search Event Categories', 'oha-theme'),
            'all_items'         => __('All Event Categories', 'oha-theme'),
            'parent_item'       => __('Parent Event Category', 'oha-theme'),
            'parent_item_colon' => __('Parent Event Category:', 'oha-theme'),
            'edit_item'         => __('Edit Event Category', 'oha-theme'),
            'update_item'       => __('Update Event Category', 'oha-theme'),
            'add_new_item'      => __('Add New Event Category', 'oha-theme'),
            'new_item_name'     => __('New Event Category Name', 'oha-theme'),
            'menu_name'         => __('Categories', 'oha-theme'),
        ),
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'event-category'),
        'show_in_rest'      => true,
    ));
}
add_action('init', 'oha_register_custom_taxonomies');

/**
 * Flush rewrite rules on theme activation
 */
function oha_flush_rewrite_rules() {
    oha_register_videos_post_type();
    oha_register_team_post_type();
    oha_register_sponsors_post_type();
    oha_register_events_post_type();
    oha_register_slides_post_type();
    oha_register_custom_taxonomies();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'oha_flush_rewrite_rules');

/**
 * Add custom columns to admin post lists
 */
function oha_add_custom_columns($columns) {
    $columns['featured_image'] = __('Featured Image', 'oha-theme');
    return $columns;
}

function oha_display_custom_columns($column, $post_id) {
    switch ($column) {
        case 'featured_image':
            $thumbnail = get_the_post_thumbnail($post_id, array(50, 50));
            echo $thumbnail ? $thumbnail : '—';
            break;
    }
}

// Apply to custom post types
$custom_post_types = array('oha_video', 'team_member', 'sponsor', 'event', 'slide');
foreach ($custom_post_types as $post_type) {
    add_filter("manage_{$post_type}_posts_columns", 'oha_add_custom_columns');
    add_action("manage_{$post_type}_posts_custom_column", 'oha_display_custom_columns', 10, 2);
}

/**
 * Helper function to get videos
 */
function oha_get_videos($args = array()) {
    $default_args = array(
        'post_type'      => 'oha_video',
        'post_status'    => 'publish',
        'posts_per_page' => 6,
        'meta_key'       => '_thumbnail_id',
        'orderby'        => 'date',
        'order'          => 'DESC'
    );
    
    $args = wp_parse_args($args, $default_args);
    return new WP_Query($args);
}

/**
 * Helper function to get team members
 */
function oha_get_team_members($args = array()) {
    $default_args = array(
        'post_type'      => 'team_member',
        'post_status'    => 'publish',
        'posts_per_page' => 8,
        'meta_key'       => '_thumbnail_id',
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );
    
    $args = wp_parse_args($args, $default_args);
    return new WP_Query($args);
}

/**
 * Helper function to get sponsors
 */
function oha_get_sponsors($args = array()) {
    $default_args = array(
        'post_type'      => 'sponsor',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_key'       => '_thumbnail_id',
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );
    
    $args = wp_parse_args($args, $default_args);
    return new WP_Query($args);
}

/**
 * Helper function to get events
 */
function oha_get_events($args = array()) {
    $default_args = array(
        'post_type'      => 'event',
        'post_status'    => 'publish',
        'posts_per_page' => 6,
        'meta_key'       => '_thumbnail_id',
        'orderby'        => 'date',
        'order'          => 'DESC'
    );
    
    $args = wp_parse_args($args, $default_args);
    return new WP_Query($args);
}

/**
 * Helper function to get slides
 */
function oha_get_slides($args = array()) {
    $default_args = array(
        'post_type'      => 'slide',
        'post_status'    => 'publish',
        'posts_per_page' => 5,
        'meta_key'       => '_thumbnail_id',
        'orderby'        => 'menu_order',
        'order'          => 'ASC'
    );
    
    $args = wp_parse_args($args, $default_args);
    return new WP_Query($args);
} 