<?php
/**
 * OHA Theme Setup Functions
 *
 * Additional setup functions for the OHA theme including customizer options
 *
 * @package OHA_Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add customizer settings for OHA theme
 */
function oha_customize_register($wp_customize) {
    
    // Add OHA Contact Section
    $wp_customize->add_section('oha_contact_section', array(
        'title'    => __('OHA Contact Information', 'oha-theme'),
        'priority' => 30,
    ));

    // Contact Phone
    $wp_customize->add_setting('oha_contact_phone', array(
        'default'           => '+968 24 123456',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('oha_contact_phone', array(
        'label'    => __('Phone Number', 'oha-theme'),
        'section'  => 'oha_contact_section',
        'type'     => 'text',
    ));

    // Contact Email
    $wp_customize->add_setting('oha_contact_email', array(
        'default'           => 'info@omanhockey.org',
        'sanitize_callback' => 'sanitize_email',
    ));

    $wp_customize->add_control('oha_contact_email', array(
        'label'    => __('Email Address', 'oha-theme'),
        'section'  => 'oha_contact_section',
        'type'     => 'email',
    ));

    // Contact Location
    $wp_customize->add_setting('oha_contact_location', array(
        'default'           => 'Muscat, Oman',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('oha_contact_location', array(
        'label'    => __('Location', 'oha-theme'),
        'section'  => 'oha_contact_section',
        'type'     => 'text',
    ));

    // Add OHA Social Media Section
    $wp_customize->add_section('oha_social_section', array(
        'title'    => __('OHA Social Media', 'oha-theme'),
        'priority' => 31,
    ));

    // Social Media Links
    $social_networks = array(
        'facebook'  => 'Facebook',
        'twitter'   => 'Twitter',
        'instagram' => 'Instagram',
        'youtube'   => 'YouTube',
        'linkedin'  => 'LinkedIn',
    );

    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting("oha_social_{$network}", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));

        $wp_customize->add_control("oha_social_{$network}", array(
            'label'    => sprintf(__('%s URL', 'oha-theme'), $label),
            'section'  => 'oha_social_section',
            'type'     => 'url',
        ));
    }

    // Add OHA Theme Options Section
    $wp_customize->add_section('oha_theme_options', array(
        'title'    => __('OHA Theme Options', 'oha-theme'),
        'priority' => 32,
    ));

    // Show/Hide Contact Info in Header
    $wp_customize->add_setting('oha_show_header_contact', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('oha_show_header_contact', array(
        'label'    => __('Show Contact Info in Header', 'oha-theme'),
        'section'  => 'oha_theme_options',
        'type'     => 'checkbox',
    ));

    // Enable Sticky Header
    $wp_customize->add_setting('oha_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));

    $wp_customize->add_control('oha_sticky_header', array(
        'label'    => __('Enable Sticky Header', 'oha-theme'),
        'section'  => 'oha_theme_options',
        'type'     => 'checkbox',
    ));

    // Footer Copyright Text
    $wp_customize->add_setting('oha_footer_copyright', array(
        'default'           => sprintf(__('© %s Oman Hockey Association. All rights reserved.', 'oha-theme'), date('Y')),
        'sanitize_callback' => 'wp_kses_post',
    ));

    $wp_customize->add_control('oha_footer_copyright', array(
        'label'    => __('Footer Copyright Text', 'oha-theme'),
        'section'  => 'oha_theme_options',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'oha_customize_register');

/**
 * Get social media links
 */
function oha_get_social_links() {
    $social_networks = array(
        'facebook'  => array('icon' => 'fab fa-facebook-f', 'label' => 'Facebook'),
        'twitter'   => array('icon' => 'fab fa-twitter', 'label' => 'Twitter'),
        'instagram' => array('icon' => 'fab fa-instagram', 'label' => 'Instagram'),
        'youtube'   => array('icon' => 'fab fa-youtube', 'label' => 'YouTube'),
        'linkedin'  => array('icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'),
    );

    $social_links = array();

    foreach ($social_networks as $network => $data) {
        $url = get_theme_mod("oha_social_{$network}");
        if ($url) {
            $social_links[$network] = array(
                'url'   => esc_url($url),
                'icon'  => $data['icon'],
                'label' => $data['label'],
            );
        }
    }

    return $social_links;
}

/**
 * Display social media links
 */
function oha_display_social_links($class = 'footer-social') {
    $social_links = oha_get_social_links();
    
    if (empty($social_links)) {
        return;
    }

    echo '<div class="' . esc_attr($class) . '">';
    foreach ($social_links as $network => $data) {
        printf(
            '<a href="%s" class="social-icon social-icon-%s" target="_blank" rel="noopener noreferrer" aria-label="%s">
                <i class="%s" aria-hidden="true"></i>
            </a>',
            $data['url'],
            esc_attr($network),
            esc_attr($data['label']),
            esc_attr($data['icon'])
        );
    }
    echo '</div>';
}

/**
 * Add custom CSS classes based on customizer settings
 */
function oha_customizer_css_classes($classes) {
    // Add sticky header class
    if (get_theme_mod('oha_sticky_header', true)) {
        $classes[] = 'oha-sticky-header';
    }

    // Add class if header contact is hidden
    if (!get_theme_mod('oha_show_header_contact', true)) {
        $classes[] = 'oha-hide-header-contact';
    }

    return $classes;
}
add_filter('body_class', 'oha_customizer_css_classes');

/**
 * Add OHA theme customizer CSS
 */
function oha_customizer_css() {
    $hide_contact = !get_theme_mod('oha_show_header_contact', true);
    $sticky_header = get_theme_mod('oha_sticky_header', true);

    if ($hide_contact || !$sticky_header) {
        echo '<style type="text/css">';
        
        if ($hide_contact) {
            echo '.header-contact-info { display: none !important; }';
        }
        
        if (!$sticky_header) {
            echo '.site-header { position: relative !important; }';
        }
        
        echo '</style>';
    }
}
add_action('wp_head', 'oha_customizer_css');

/**
 * Get OHA theme version for cache busting
 */
function oha_get_theme_version() {
    $theme = wp_get_theme();
    return $theme->get('Version');
}

/**
 * Add meta tags for OHA theme
 */
function oha_add_meta_tags() {
    echo '<meta name="theme-color" content="#58AA35">' . "\n";
    echo '<meta name="msapplication-TileColor" content="#58AA35">' . "\n";
    echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
    echo '<meta name="apple-mobile-web-app-status-bar-style" content="default">' . "\n";
}
add_action('wp_head', 'oha_add_meta_tags', 1);

/**
 * Improve WordPress SEO
 */
function oha_improve_seo() {
    // Remove unnecessary meta tags
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    
    // Clean up header
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('init', 'oha_improve_seo');

/**
 * Custom excerpt length for OHA theme
 */
function oha_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'oha_excerpt_length');

/**
 * Custom excerpt more text
 */
function oha_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'oha_excerpt_more');

/**
 * Add OHA theme support for various WordPress features
 */
function oha_add_theme_support() {
    // Add support for custom header
    add_theme_support('custom-header', array(
        'default-image'      => '',
        'default-text-color' => '58AA35',
        'width'              => 1200,
        'height'             => 400,
        'flex-width'         => true,
        'flex-height'        => true,
    ));

    // Add support for custom colors
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('OHA Primary Green', 'oha-theme'),
            'slug'  => 'oha-primary-green',
            'color' => '#58AA35',
        ),
        array(
            'name'  => __('OHA Primary Red', 'oha-theme'),
            'slug'  => 'oha-primary-red',
            'color' => '#E5201D',
        ),
        array(
            'name'  => __('OHA Dark Gray', 'oha-theme'),
            'slug'  => 'oha-dark-gray',
            'color' => '#58595C',
        ),
        array(
            'name'  => __('OHA Light Gray', 'oha-theme'),
            'slug'  => 'oha-light-gray',
            'color' => '#D1D3D4',
        ),
    ));

    // Add support for wide blocks
    add_theme_support('align-wide');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-styles.css');
}
add_action('after_setup_theme', 'oha_add_theme_support');

/**
 * Get video publish date helper function
 */
function oha_get_video_publish_date( $post_id = null ) {
    if ( ! $post_id ) {
        global $post;
        $post_id = $post->ID;
    }
    
    $publish_date = get_post_meta( $post_id, '_oha_video_publish_date', true );
    
    if ( $publish_date ) {
        return $publish_date;
    }
    
    // Fallback to post date if no custom publish date is set
    return get_the_date( 'Y-m-d', $post_id );
}

/**
 * Display formatted video publish date
 */
function oha_display_video_publish_date( $post_id = null, $format = '' ) {
    $publish_date = oha_get_video_publish_date( $post_id );
    
    if ( ! $format ) {
        $format = get_option( 'date_format' );
    }
    
    $formatted_date = date_i18n( $format, strtotime( $publish_date ) );
    
    echo '<time class="video-publish-date" datetime="' . esc_attr( $publish_date ) . '">' . esc_html( $formatted_date ) . '</time>';
}

/**
 * Get video metadata helper function
 */
function oha_get_video_meta( $post_id = null ) {
    if ( ! $post_id ) {
        global $post;
        $post_id = $post->ID;
    }
    
    return array(
        'url' => get_post_meta( $post_id, '_oha_video_url', true ),
        'embed' => get_post_meta( $post_id, '_oha_video_embed', true ),
        'duration' => get_post_meta( $post_id, '_oha_video_duration', true ),
        'type' => get_post_meta( $post_id, '_oha_video_type', true ),
        'publish_date' => get_post_meta( $post_id, '_oha_video_publish_date', true ),
        'views' => get_post_meta( $post_id, 'post_views_count', true ) ?: 0,
        'likes' => get_post_meta( $post_id, 'video_likes', true ) ?: 0,
    );
} 