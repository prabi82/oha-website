<?php
/**
 * OHA Theme Functions and Definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package OHA_Theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function oha_theme_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on _s, use a find and replace
		* to change '_s' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'oha-theme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// Custom logo support for OHA
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 300,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
	
	// Register navigation menus
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'oha-theme' ),
			'footer'  => esc_html__( 'Footer Menu', 'oha-theme' ),
		)
	);
	
	// Add theme support for selective refresh for widgets
	add_theme_support( 'customize-selective-refresh-widgets' );
	
	// Add theme support for HTML5 markup
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'oha_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);
	
	// Add support for responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Add support for editor styles
	add_theme_support( 'editor-styles' );
	
	// Add support for wide and full alignment
	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'oha_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function oha_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'oha_content_width', 1200 );
}
add_action( 'after_setup_theme', 'oha_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function oha_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'oha-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'oha-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// Footer widget areas
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget 1', 'oha-theme' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets for footer column 1.', 'oha-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget 2', 'oha-theme' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets for footer column 2.', 'oha-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Widget 3', 'oha-theme' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets for footer column 3.', 'oha-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'oha_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function oha_theme_scripts() {
	// Font Awesome for icons - Updated to latest version with high priority
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css', array(), '6.5.0' );
	
	// Google Fonts - Tajawal (Correct spelling)
	wp_enqueue_style( 'oha-google-fonts', 'https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap', array(), '1.0.4' );
	
	// Main stylesheet
	wp_enqueue_style( 'oha-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'oha-style', 'rtl', 'replace' );
	
	// OHA global styles (with Google Fonts dependency)
	wp_enqueue_style( 'oha-global', get_template_directory_uri() . '/assets/css/oha-global.css', array( 'oha-style', 'oha-google-fonts' ), '1.0.5' );
	
	// OHA components (with Font Awesome dependency)
	wp_enqueue_style(
		'oha-components',
		get_template_directory_uri() . '/assets/css/oha-components.css',
		array( 'font-awesome' ),
		'8.3.0'
	);
	
	// OHA responsive
	wp_enqueue_style( 'oha-responsive', get_template_directory_uri() . '/assets/css/oha-responsive.css', array( 'oha-components' ), '1.2.0' );
	
	// Navigation script
	wp_enqueue_script( 'oha-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	
	// OHA main script
	wp_enqueue_script( 'oha-main', get_template_directory_uri() . '/assets/js/oha-main.js', array( 'jquery' ), '2.0.0', true );
	
	// Swiper for sliders (only on front page)
	if ( is_front_page() ) {
		wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0' );
		wp_enqueue_script( 'swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0.0', true );
		wp_enqueue_script( 'oha-slider', get_template_directory_uri() . '/assets/js/oha-slider.js', array( 'swiper-js' ), _S_VERSION, true );
	}

	// Comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Localize script for AJAX calls
	wp_localize_script( 'oha-main', 'oha_ajax', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'oha_nonce' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'oha_theme_scripts' );

/**
 * Add preload for critical fonts - Updated for Tajawal (correct spelling)
 */
function oha_preload_fonts() {
	// Preconnect to Google Fonts for better performance
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
	// Direct Google Fonts link with correct spelling
	echo '<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">' . "\n";
}
add_action( 'wp_head', 'oha_preload_fonts', 1 );

/**
 * Add custom body classes
 */
function oha_body_classes( $classes ) {
	$classes[] = 'oha-theme';
	
	if ( is_front_page() ) {
		$classes[] = 'oha-homepage';
	}
	
	return $classes;
}
add_filter( 'body_class', 'oha_body_classes' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load OHA custom post types
 */
require get_template_directory() . '/inc/custom-post-types.php';

/**
 * Load OHA setup functions
 */
require get_template_directory() . '/inc/oha-setup.php';

/**
 * Load OHA custom widgets
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Contact Form Functionality
 */

/**
 * Handle contact form submission
 */
function oha_handle_contact_form_submission() {
    // Check if it's our form submission
    if ( ! isset( $_POST['action'] ) || $_POST['action'] !== 'oha_contact_form_submit' ) {
        return;
    }
    
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['oha_contact_nonce'], 'oha_contact_form' ) ) {
        wp_die( __( 'Security check failed. Please try again.', 'oha-theme' ) );
    }
    
    // Check for honeypot (spam protection)
    if ( ! empty( $_POST['contact_website'] ) ) {
        wp_die( __( 'Spam detected.', 'oha-theme' ) );
    }
    
    // Sanitize and validate form data
    $contact_name = sanitize_text_field( $_POST['contact_name'] );
    $contact_email = sanitize_email( $_POST['contact_email'] );
    $contact_phone = sanitize_text_field( $_POST['contact_phone'] );
    $contact_subject = sanitize_text_field( $_POST['contact_subject'] );
    $contact_message = sanitize_textarea_field( $_POST['contact_message'] );
    
    // Validation
    $errors = array();
    
    if ( empty( $contact_name ) ) {
        $errors[] = __( 'Name is required.', 'oha-theme' );
    }
    
    if ( empty( $contact_email ) || ! is_email( $contact_email ) ) {
        $errors[] = __( 'Valid email address is required.', 'oha-theme' );
    }
    
    if ( empty( $contact_subject ) ) {
        $errors[] = __( 'Subject is required.', 'oha-theme' );
    }
    
    if ( empty( $contact_message ) ) {
        $errors[] = __( 'Message is required.', 'oha-theme' );
    }
    
    // If errors, return JSON response
    if ( ! empty( $errors ) ) {
        wp_send_json_error( array(
            'message' => implode( '<br>', $errors )
        ) );
    }
    
    // Get recipient email from theme customizer
    $recipient_email = get_theme_mod( 'oha_contact_email', get_option( 'admin_email' ) );
    
    // Prepare email
    $subject_line = sprintf( __( '[OHA Contact] %s', 'oha-theme' ), ucfirst( str_replace( '_', ' ', $contact_subject ) ) );
    
    $message_body = sprintf(
        __( "New contact form submission from OHA website:\n\nName: %s\nEmail: %s\nPhone: %s\nSubject: %s\n\nMessage:\n%s\n\n---\nSubmitted on: %s\nFrom IP: %s", 'oha-theme' ),
        $contact_name,
        $contact_email,
        $contact_phone ?: __( 'Not provided', 'oha-theme' ),
        ucfirst( str_replace( '_', ' ', $contact_subject ) ),
        $contact_message,
        current_time( 'Y-m-d H:i:s' ),
        $_SERVER['REMOTE_ADDR']
    );
    
    // Email headers
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $contact_name . ' <' . $contact_email . '>'
    );
    
    // Send email
    $mail_sent = wp_mail( $recipient_email, $subject_line, $message_body, $headers );
    
    if ( $mail_sent ) {
        // Save to database (optional)
        oha_save_contact_submission( $contact_name, $contact_email, $contact_phone, $contact_subject, $contact_message );
        
        // Send auto-reply to user
        oha_send_contact_auto_reply( $contact_email, $contact_name );
        
        wp_send_json_success( array(
            'message' => __( 'Thank you for your message! We will get back to you as soon as possible.', 'oha-theme' )
        ) );
    } else {
        wp_send_json_error( array(
            'message' => __( 'Sorry, there was an error sending your message. Please try again later or contact us directly.', 'oha-theme' )
        ) );
    }
}
add_action( 'wp_ajax_oha_contact_form_submit', 'oha_handle_contact_form_submission' );
add_action( 'wp_ajax_nopriv_oha_contact_form_submit', 'oha_handle_contact_form_submission' );
add_action( 'admin_post_oha_contact_form_submit', 'oha_handle_contact_form_submission' );
add_action( 'admin_post_nopriv_oha_contact_form_submit', 'oha_handle_contact_form_submission' );

/**
 * Save contact form submission to database
 */
function oha_save_contact_submission( $name, $email, $phone, $subject, $message ) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'oha_contact_submissions';
    
    // Create table if it doesn't exist
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        email varchar(100) NOT NULL,
        phone varchar(20),
        subject varchar(100) NOT NULL,
        message text NOT NULL,
        ip_address varchar(45),
        submitted_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    
    // Insert submission
    $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $message,
            'ip_address' => $_SERVER['REMOTE_ADDR']
        ),
        array( '%s', '%s', '%s', '%s', '%s', '%s' )
    );
}

/**
 * Send auto-reply email to contact form submitter
 */
function oha_send_contact_auto_reply( $user_email, $user_name ) {
    $subject = __( 'Thank you for contacting OHA', 'oha-theme' );
    
    $message = sprintf(
        __( "Dear %s,\n\nThank you for contacting the Oman Hockey Association. We have received your message and will respond as soon as possible.\n\nIf you have an urgent inquiry, please call us at %s or email us directly at %s.\n\nBest regards,\nOman Hockey Association Team\n\n---\nThis is an automated response. Please do not reply to this email.", 'oha-theme' ),
        $user_name,
        get_theme_mod( 'oha_contact_phone', '+968 1234 5678' ),
        get_theme_mod( 'oha_contact_email', 'info@omanhockey.om' )
    );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: Oman Hockey Association <' . get_theme_mod( 'oha_contact_email', get_option( 'admin_email' ) ) . '>'
    );
    
    wp_mail( $user_email, $subject, $message, $headers );
}

/**
 * Add contact form settings to customizer
 */
function oha_contact_form_customizer( $wp_customize ) {
    // Contact Information Section
    $wp_customize->add_section( 'oha_contact_info', array(
        'title'    => __( 'Contact Information', 'oha-theme' ),
        'priority' => 35,
    ) );
    
    // Contact Address
    $wp_customize->add_setting( 'oha_contact_address', array(
        'default'           => 'Muscat, Sultanate of Oman',
        'sanitize_callback' => 'sanitize_textarea_field',
    ) );
    
    $wp_customize->add_control( 'oha_contact_address', array(
        'label'   => __( 'Office Address', 'oha-theme' ),
        'section' => 'oha_contact_info',
        'type'    => 'textarea',
    ) );
    
    // Contact Phone
    $wp_customize->add_setting( 'oha_contact_phone', array(
        'default'           => '+968 1234 5678',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'oha_contact_phone', array(
        'label'   => __( 'Phone Number', 'oha-theme' ),
        'section' => 'oha_contact_info',
        'type'    => 'text',
    ) );
    
    // Contact Email
    $wp_customize->add_setting( 'oha_contact_email', array(
        'default'           => 'info@omanhockey.om',
        'sanitize_callback' => 'sanitize_email',
    ) );
    
    $wp_customize->add_control( 'oha_contact_email', array(
        'label'   => __( 'Email Address', 'oha-theme' ),
        'section' => 'oha_contact_info',
        'type'    => 'email',
    ) );
}
add_action( 'customize_register', 'oha_contact_form_customizer' );

/**
 * Add customizer options for header partner logos
 */
function oha_header_customizer( $wp_customize ) {
    // Header Settings Section
    $wp_customize->add_section( 'oha_header_settings', array(
        'title'    => __( 'OHA Header Settings', 'oha-theme' ),
        'priority' => 30,
    ) );
    
    // Official Title Setting
    $wp_customize->add_setting( 'oha_official_title', array(
        'default'           => __( 'Official Website Of Oman Hockey Association', 'oha-theme' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( 'oha_official_title', array(
        'label'    => __( 'Official Website Title', 'oha-theme' ),
        'section'  => 'oha_header_settings',
        'type'     => 'text',
    ) );
    
    // Partner Logos Section
    $wp_customize->add_setting( 'oha_partner_logos_heading', array(
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'oha_partner_logos_heading', array(
        'label'    => __( 'Partner Logos', 'oha-theme' ),
        'section'  => 'oha_header_settings',
        'type'     => 'hidden',
    ) ) );
    
    // Add up to 6 partner logo settings
    for ( $i = 1; $i <= 6; $i++ ) {
        // Partner Logo Image
        $wp_customize->add_setting( "oha_partner_logo_$i", array(
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "oha_partner_logo_$i", array(
            'label'    => sprintf( __( 'Partner Logo %d', 'oha-theme' ), $i ),
            'section'  => 'oha_header_settings',
        ) ) );
        
        // Partner Name
        $wp_customize->add_setting( "oha_partner_name_$i", array(
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        
        $wp_customize->add_control( "oha_partner_name_$i", array(
            'label'    => sprintf( __( 'Partner %d Name', 'oha-theme' ), $i ),
            'section'  => 'oha_header_settings',
            'type'     => 'text',
        ) );
        
        // Partner URL
        $wp_customize->add_setting( "oha_partner_url_$i", array(
            'sanitize_callback' => 'esc_url_raw',
        ) );
        
        $wp_customize->add_control( "oha_partner_url_$i", array(
            'label'    => sprintf( __( 'Partner %d URL', 'oha-theme' ), $i ),
            'section'  => 'oha_header_settings',
            'type'     => 'url',
        ) );
    }
}
add_action( 'customize_register', 'oha_header_customizer' );

/**
 * Get partner logos for header
 */
function oha_get_partner_logos() {
    $theme_uri = get_template_directory_uri();
    
    // Default partners with actual logo paths
    $default_partners = array(
        array(
            'name' => 'BADR AL SAMAA',
            'logo' => $theme_uri . '/assets/images/partners/badr-al-samaa.png',
            'url' => '#',
        ),
        array(
            'name' => 'JINDAL STEEL',
            'logo' => $theme_uri . '/assets/images/partners/jindal-steel.png',
            'url' => '#',
        ),
    );
    
    // Get custom partner logos from customizer (if any)
    $custom_partners = get_theme_mod('oha_partner_logos', array());
    
    // Return custom partners if available, otherwise return defaults
    return !empty($custom_partners) ? $custom_partners : $default_partners;
}

/**
 * Admin page for viewing contact submissions
 */
function oha_add_contact_submissions_admin_page() {
    add_menu_page(
        __( 'Contact Submissions', 'oha-theme' ),
        __( 'Contact Forms', 'oha-theme' ),
        'manage_options',
        'oha-contact-submissions',
        'oha_contact_submissions_page',
        'dashicons-email-alt',
        30
    );
}
add_action( 'admin_menu', 'oha_add_contact_submissions_admin_page' );

/**
 * Display contact submissions admin page
 */
function oha_contact_submissions_page() {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'oha_contact_submissions';
    
    // Handle deletion
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['id'] ) ) {
        $id = intval( $_GET['id'] );
        $wpdb->delete( $table_name, array( 'id' => $id ), array( '%d' ) );
        echo '<div class="notice notice-success"><p>' . __( 'Submission deleted.', 'oha-theme' ) . '</p></div>';
    }
    
    // Get submissions
    $submissions = $wpdb->get_results( "SELECT * FROM $table_name ORDER BY submitted_at DESC" );
    
    ?>
    <div class="wrap">
        <h1><?php _e( 'Contact Form Submissions', 'oha-theme' ); ?></h1>
        
        <?php if ( empty( $submissions ) ) : ?>
            <p><?php _e( 'No contact form submissions yet.', 'oha-theme' ); ?></p>
        <?php else : ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php _e( 'Date', 'oha-theme' ); ?></th>
                        <th><?php _e( 'Name', 'oha-theme' ); ?></th>
                        <th><?php _e( 'Email', 'oha-theme' ); ?></th>
                        <th><?php _e( 'Subject', 'oha-theme' ); ?></th>
                        <th><?php _e( 'Message', 'oha-theme' ); ?></th>
                        <th><?php _e( 'Actions', 'oha-theme' ); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $submissions as $submission ) : ?>
                        <tr>
                            <td><?php echo esc_html( $submission->submitted_at ); ?></td>
                            <td>
                                <strong><?php echo esc_html( $submission->name ); ?></strong>
                                <?php if ( $submission->phone ) : ?>
                                    <br><small><?php echo esc_html( $submission->phone ); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><a href="mailto:<?php echo esc_attr( $submission->email ); ?>"><?php echo esc_html( $submission->email ); ?></a></td>
                            <td><?php echo esc_html( ucfirst( str_replace( '_', ' ', $submission->subject ) ) ); ?></td>
                            <td>
                                <div style="max-width: 300px; max-height: 100px; overflow: hidden;">
                                    <?php echo esc_html( wp_trim_words( $submission->message, 15 ) ); ?>
                                </div>
                                <details style="margin-top: 5px;">
                                    <summary style="cursor: pointer; color: #0073aa;"><?php _e( 'View full message', 'oha-theme' ); ?></summary>
                                    <div style="margin-top: 10px; padding: 10px; background: #f9f9f9; border-left: 3px solid #0073aa;">
                                        <?php echo nl2br( esc_html( $submission->message ) ); ?>
                                    </div>
                                </details>
                            </td>
                            <td>
                                <a href="mailto:<?php echo esc_attr( $submission->email ); ?>?subject=Re: <?php echo esc_attr( $submission->subject ); ?>" class="button button-small"><?php _e( 'Reply', 'oha-theme' ); ?></a>
                                <a href="<?php echo esc_url( add_query_arg( array( 'action' => 'delete', 'id' => $submission->id ) ) ); ?>" class="button button-small" onclick="return confirm('<?php _e( 'Are you sure you want to delete this submission?', 'oha-theme' ); ?>')"><?php _e( 'Delete', 'oha-theme' ); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Enhanced Content and Template Helper Functions
 */

/**
 * Calculate estimated reading time for content
 */
function oha_get_reading_time( $content ) {
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    $reading_time = ceil( $word_count / 200 ); // Average reading speed: 200 words per minute
    
    return max( 1, $reading_time ); // Minimum 1 minute
}

/**
 * Get related posts based on categories and tags
 */
function oha_get_related_posts( $post_id, $number_posts = 3 ) {
    $current_post = get_post( $post_id );
    
    if ( ! $current_post ) {
        return new WP_Query( array( 'post__in' => array( 0 ) ) );
    }
    
    // Get post categories and tags
    $categories = wp_get_post_categories( $post_id );
    $tags = wp_get_post_tags( $post_id, array( 'fields' => 'ids' ) );
    
    $related_args = array(
        'post_type'      => $current_post->post_type,
        'post_status'    => 'publish',
        'posts_per_page' => $number_posts,
        'post__not_in'   => array( $post_id ),
        'meta_query'     => array(
            'relation' => 'OR',
        ),
    );
    
    // Add category or tag queries if available
    if ( ! empty( $categories ) || ! empty( $tags ) ) {
        $tax_query = array( 'relation' => 'OR' );
        
        if ( ! empty( $categories ) ) {
            $tax_query[] = array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $categories,
            );
        }
        
        if ( ! empty( $tags ) ) {
            $tax_query[] = array(
                'taxonomy' => 'post_tag',
                'field'    => 'term_id',
                'terms'    => $tags,
            );
        }
        
        $related_args['tax_query'] = $tax_query;
    }
    
    $related_posts = new WP_Query( $related_args );
    
    // If no related posts found, get recent posts from same post type
    if ( ! $related_posts->have_posts() ) {
        $related_args = array(
            'post_type'      => $current_post->post_type,
            'post_status'    => 'publish',
            'posts_per_page' => $number_posts,
            'post__not_in'   => array( $post_id ),
            'orderby'        => 'date',
            'order'          => 'DESC',
        );
        
        $related_posts = new WP_Query( $related_args );
    }
    
    return $related_posts;
}

/**
 * Enhanced search functionality
 */
function oha_search_filter( $query ) {
    if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
        // Include custom post types in search
        $query->set( 'post_type', array( 'post', 'page', 'oha_video', 'team_member', 'event' ) );
        
        // Improve search relevance
        $query->set( 'orderby', array( 'relevance' => 'DESC', 'date' => 'DESC' ) );
    }
}
add_action( 'pre_get_posts', 'oha_search_filter' );

/**
 * Add search functionality to admin bar
 */
function oha_admin_bar_search() {
    global $wp_admin_bar;
    
    if ( ! is_admin_bar_showing() ) {
        return;
    }
    
    $wp_admin_bar->add_menu( array(
        'id'     => 'oha-search',
        'title'  => '<form action="' . esc_url( home_url( '/' ) ) . '" method="get" class="adminbar-search">
                        <input type="search" name="s" placeholder="' . esc_attr__( 'Search OHA...', 'oha-theme' ) . '" class="adminbar-input" />
                        <input type="submit" class="adminbar-button" value="' . esc_attr__( 'Search', 'oha-theme' ) . '" />
                    </form>',
        'meta'   => array( 'class' => 'oha-admin-search' ),
    ) );
}
add_action( 'wp_before_admin_bar_render', 'oha_admin_bar_search' );

/**
 * Track post views for popular content
 */
function oha_track_post_views( $post_id ) {
    if ( ! is_single() ) return;
    if ( empty( $post_id ) ) {
        global $post;
        $post_id = $post->ID;
    }
    
    $views = get_post_meta( $post_id, 'post_views_count', true );
    $views = $views ? $views : 0;
    $views++;
    
    update_post_meta( $post_id, 'post_views_count', $views );
}

function oha_track_post_views_init() {
    if ( is_single() ) {
        oha_track_post_views( get_the_ID() );
    }
}
add_action( 'wp_head', 'oha_track_post_views_init' );

/**
 * Add meta boxes for additional post options
 */
function oha_add_post_meta_boxes() {
    add_meta_box(
        'oha-post-options',
        __( 'OHA Post Options', 'oha-theme' ),
        'oha_post_options_callback',
        'post',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'oha_add_post_meta_boxes' );

function oha_post_options_callback( $post ) {
    wp_nonce_field( 'oha_post_options_nonce', 'oha_post_options_nonce' );
    
    $featured = get_post_meta( $post->ID, '_oha_featured_post', true );
    $breaking = get_post_meta( $post->ID, '_oha_breaking_news', true );
    
    ?>
    <p>
        <label>
            <input type="checkbox" name="oha_featured_post" value="1" <?php checked( $featured, '1' ); ?> />
            <?php esc_html_e( 'Featured Post', 'oha-theme' ); ?>
        </label>
    </p>
    <p>
        <label>
            <input type="checkbox" name="oha_breaking_news" value="1" <?php checked( $breaking, '1' ); ?> />
            <?php esc_html_e( 'Breaking News', 'oha-theme' ); ?>
        </label>
    </p>
    <?php
}

function oha_save_post_options( $post_id ) {
    if ( ! isset( $_POST['oha_post_options_nonce'] ) || ! wp_verify_nonce( $_POST['oha_post_options_nonce'], 'oha_post_options_nonce' ) ) {
        return;
    }
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    $featured = isset( $_POST['oha_featured_post'] ) ? '1' : '0';
    $breaking = isset( $_POST['oha_breaking_news'] ) ? '1' : '0';
    
    update_post_meta( $post_id, '_oha_featured_post', $featured );
    update_post_meta( $post_id, '_oha_breaking_news', $breaking );
}
add_action( 'save_post', 'oha_save_post_options' );

/**
 * Archive Enhancement Functions for Step 11
 */

/**
 * AJAX handler for loading more posts
 */
function oha_load_more_posts() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['nonce'], 'oha_load_more_nonce' ) ) {
        wp_die( 'Security check failed' );
    }
    
    $page = intval( $_POST['page'] );
    $sort = sanitize_text_field( $_POST['sort'] ) ?: 'date_desc';
    $category = intval( $_POST['category'] ) ?: 0;
    $tag = sanitize_text_field( $_POST['tag'] ) ?: '';
    $search = sanitize_text_field( $_POST['search'] ) ?: '';
    
    // Parse sort parameter
    $sort_parts = explode( '_', $sort );
    $orderby = $sort_parts[0];
    $order = $sort_parts[1] ?? 'DESC';
    
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => get_option( 'posts_per_page' ),
        'paged'          => $page,
        'orderby'        => $orderby,
        'order'          => strtoupper( $order ),
    );
    
    // Add category filter
    if ( $category ) {
        $args['cat'] = $category;
    }
    
    // Add tag filter
    if ( $tag ) {
        $args['tag'] = $tag;
    }
    
    // Add search filter
    if ( $search ) {
        $args['s'] = $search;
    }
    
    // Special handling for comment count sorting
    if ( $orderby === 'comment_count' ) {
        $args['orderby'] = 'comment_count';
        $args['order'] = 'DESC';
    }
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) :
        ob_start();
        
        while ( $query->have_posts() ) : $query->the_post();
            get_template_part( 'template-parts/content', 'archive' );
        endwhile;
        
        $html = ob_get_clean();
        wp_reset_postdata();
        
        wp_send_json_success( array(
            'html' => $html,
            'has_more' => ( $page < $query->max_num_pages ),
            'total_pages' => $query->max_num_pages,
            'current_page' => $page
        ) );
    else :
        wp_send_json_error( array(
            'message' => __( 'No more posts found.', 'oha-theme' )
        ) );
    endif;
}
add_action( 'wp_ajax_oha_load_more_posts', 'oha_load_more_posts' );
add_action( 'wp_ajax_nopriv_oha_load_more_posts', 'oha_load_more_posts' );

/**
 * AJAX handler for archive sorting
 */
function oha_sort_archive_posts() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['nonce'], 'oha_sort_nonce' ) ) {
        wp_die( 'Security check failed' );
    }
    
    $sort = sanitize_text_field( $_POST['sort'] ) ?: 'date_desc';
    $category = intval( $_POST['category'] ) ?: 0;
    $tag = sanitize_text_field( $_POST['tag'] ) ?: '';
    $search = sanitize_text_field( $_POST['search'] ) ?: '';
    
    // Parse sort parameter
    $sort_parts = explode( '_', $sort );
    $orderby = $sort_parts[0];
    $order = $sort_parts[1] ?? 'DESC';
    
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => get_option( 'posts_per_page' ),
        'paged'          => 1,
        'orderby'        => $orderby,
        'order'          => strtoupper( $order ),
    );
    
    // Add filters
    if ( $category ) {
        $args['cat'] = $category;
    }
    
    if ( $tag ) {
        $args['tag'] = $tag;
    }
    
    if ( $search ) {
        $args['s'] = $search;
    }
    
    // Special handling for comment count sorting
    if ( $orderby === 'comment_count' ) {
        $args['orderby'] = 'comment_count';
        $args['order'] = 'DESC';
    }
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) :
        ob_start();
        
        while ( $query->have_posts() ) : $query->the_post();
            get_template_part( 'template-parts/content', 'archive' );
        endwhile;
        
        $html = ob_get_clean();
        wp_reset_postdata();
        
        wp_send_json_success( array(
            'html' => $html,
            'has_more' => ( 1 < $query->max_num_pages ),
            'total_pages' => $query->max_num_pages,
            'total_posts' => $query->found_posts
        ) );
    else :
        wp_send_json_error( array(
            'message' => __( 'No posts found with current sorting.', 'oha-theme' )
        ) );
    endif;
}
add_action( 'wp_ajax_oha_sort_archive_posts', 'oha_sort_archive_posts' );
add_action( 'wp_ajax_nopriv_oha_sort_archive_posts', 'oha_sort_archive_posts' );

/**
 * Get archive statistics
 */
function oha_get_archive_stats() {
    $stats = array();
    
    // Total posts
    $stats['total_posts'] = wp_count_posts( 'post' )->publish;
    
    // Categories count
    $stats['categories'] = wp_count_terms( 'category', array( 'hide_empty' => true ) );
    
    // Tags count
    $stats['tags'] = wp_count_terms( 'post_tag', array( 'hide_empty' => true ) );
    
    // Authors count
    $stats['authors'] = count( get_users( array( 'who' => 'authors' ) ) );
    
    // Comments count
    $comments_count = wp_count_comments();
    $stats['comments'] = $comments_count->approved;
    
    return $stats;
}

/**
 * Enhanced archive title
 */
function oha_get_enhanced_archive_title() {
    if ( is_category() ) {
        return sprintf( __( 'Category: %s', 'oha-theme' ), single_cat_title( '', false ) );
    } elseif ( is_tag() ) {
        return sprintf( __( 'Tag: %s', 'oha-theme' ), single_tag_title( '', false ) );
    } elseif ( is_author() ) {
        return sprintf( __( 'Author: %s', 'oha-theme' ), get_the_author() );
    } elseif ( is_date() ) {
        if ( is_year() ) {
            return sprintf( __( 'Year: %s', 'oha-theme' ), get_the_date( 'Y' ) );
        } elseif ( is_month() ) {
            return sprintf( __( 'Month: %s', 'oha-theme' ), get_the_date( 'F Y' ) );
        } elseif ( is_day() ) {
            return sprintf( __( 'Day: %s', 'oha-theme' ), get_the_date() );
        }
    }
    
    return get_the_archive_title();
}

/**
 * Get popular posts for archive sidebar
 */
function oha_get_popular_posts( $limit = 5 ) {
    return new WP_Query( array(
        'posts_per_page' => $limit,
        'meta_key' => 'post_views_count',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'post_status' => 'publish',
        'ignore_sticky_posts' => true,
    ) );
}

/**
 * Archive pagination with enhanced styling
 */
function oha_archive_pagination() {
    global $wp_query;
    
    $current = max( 1, get_query_var( 'paged' ) );
    $total = $wp_query->max_num_pages;
    
    if ( $total <= 1 ) return;
    
    echo '<nav class="oha-archive-pagination" role="navigation">';
    echo '<h2 class="screen-reader-text">' . __( 'Posts navigation', 'oha-theme' ) . '</h2>';
    
    echo paginate_links( array(
        'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
        'format'    => '?paged=%#%',
        'current'   => $current,
        'total'     => $total,
        'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __( 'Previous', 'oha-theme' ),
        'next_text' => __( 'Next', 'oha-theme' ) . ' <i class="fas fa-chevron-right"></i>',
        'mid_size'  => 2,
        'end_size'  => 1,
        'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'oha-theme' ) . ' </span>',
    ) );
    
    echo '</nav>';
}

/**
 * Enqueue archive-specific scripts and styles
 */
function oha_archive_scripts() {
    if ( is_archive() || is_home() ) {
        wp_enqueue_script( 'oha-archive', get_template_directory_uri() . '/assets/js/oha-archive.js', array( 'jquery', 'oha-main' ), _S_VERSION, true );
        
        wp_localize_script( 'oha-archive', 'oha_archive', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'load_more_nonce' => wp_create_nonce( 'oha_load_more_nonce' ),
            'sort_nonce' => wp_create_nonce( 'oha_sort_nonce' ),
            'loading_text' => __( 'Loading...', 'oha-theme' ),
            'no_more_posts' => __( 'No more posts to load.', 'oha-theme' ),
            'error_message' => __( 'Error loading posts. Please try again.', 'oha-theme' ),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'oha_archive_scripts' );

/**
 * Custom excerpt length for archive cards
 */
function oha_archive_excerpt_length( $length ) {
    if ( is_archive() || is_home() ) {
        return 25;
    }
    return $length;
}
add_filter( 'excerpt_length', 'oha_archive_excerpt_length' );

/**
 * Custom excerpt more text for archive cards
 */
function oha_archive_excerpt_more( $more ) {
    if ( is_archive() || is_home() ) {
        return '...';
    }
    return $more;
}
add_filter( 'excerpt_more', 'oha_archive_excerpt_more' );

/**
 * Add body class for archive view type
 */
function oha_archive_body_class( $classes ) {
    if ( is_archive() || is_home() ) {
        $classes[] = 'oha-archive-page';
        
        // Add view type class (default to grid)
        $view_type = isset( $_COOKIE['oha_archive_view'] ) ? $_COOKIE['oha_archive_view'] : 'grid';
        $classes[] = 'archive-view-' . $view_type;
    }
    
    return $classes;
}
add_filter( 'body_class', 'oha_archive_body_class' );

/**
 * Enhanced archive meta query for better performance
 */
function oha_archive_pre_get_posts( $query ) {
    if ( ! is_admin() && $query->is_main_query() ) {
        
        // For archive pages, optimize queries
        if ( $query->is_archive() || $query->is_home() ) {
            
            // Exclude password protected posts from archives
            $query->set( 'has_password', false );
            
            // Set posts per page for archives
            $posts_per_page = get_theme_mod( 'oha_archive_posts_per_page', get_option( 'posts_per_page' ) );
            $query->set( 'posts_per_page', $posts_per_page );
            
            // Optimize meta queries
            $query->set( 'update_post_meta_cache', false );
            $query->set( 'update_post_term_cache', false );
        }
    }
}
add_action( 'pre_get_posts', 'oha_archive_pre_get_posts' );

/**
 * Step 12: Enhanced Single Post Types Functionality
 * Added: March 2024
 */

// Enqueue single posts enhanced scripts
function oha_enqueue_single_posts_scripts() {
    if ( is_singular( array( 'oha_video', 'event' ) ) ) {
        wp_enqueue_script( 
            'oha-single-posts', 
            get_template_directory_uri() . '/assets/js/oha-single-posts.js',
            array( 'jquery' ), 
            '1.0.0', 
            true 
        );
        
        // Localize script for AJAX
        wp_localize_script( 'oha-single-posts', 'oha_ajax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'oha_ajax_nonce' )
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'oha_enqueue_single_posts_scripts' );

// AJAX handler for video likes
function oha_update_video_likes() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['nonce'], 'oha_ajax_nonce' ) ) {
        wp_die( 'Security check failed' );
    }
    
    $video_id = intval( $_POST['video_id'] );
    $increment = intval( $_POST['increment'] );
    
    if ( $video_id && in_array( $increment, array( 1, -1 ) ) ) {
        $current_likes = get_post_meta( $video_id, 'video_likes', true );
        $current_likes = $current_likes ? intval( $current_likes ) : 0;
        
        $new_likes = max( 0, $current_likes + $increment );
        update_post_meta( $video_id, 'video_likes', $new_likes );
        
        wp_send_json_success( array( 'likes' => $new_likes ) );
    }
    
    wp_send_json_error( 'Invalid request' );
}
add_action( 'wp_ajax_oha_update_video_likes', 'oha_update_video_likes' );
add_action( 'wp_ajax_nopriv_oha_update_video_likes', 'oha_update_video_likes' );

// AJAX handler for event registration
function oha_handle_event_registration() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['registration_nonce'], 'oha_event_registration' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed' ) );
    }
    
    $event_id = intval( $_POST['event_id'] );
    $name = sanitize_text_field( $_POST['registration_name'] );
    $email = sanitize_email( $_POST['registration_email'] );
    $phone = sanitize_text_field( $_POST['registration_phone'] );
    $guests = intval( $_POST['registration_guests'] );
    $notes = sanitize_textarea_field( $_POST['registration_notes'] );
    
    // Validate required fields
    if ( empty( $name ) || empty( $email ) || ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields with valid information.' ) );
    }
    
    // Check if event exists and registration is open
    $event = get_post( $event_id );
    if ( ! $event || $event->post_type !== 'event' ) {
        wp_send_json_error( array( 'message' => 'Event not found.' ) );
    }
    
    $event_status = get_post_meta( $event_id, '_oha_event_status', true );
    if ( $event_status !== 'upcoming' ) {
        wp_send_json_error( array( 'message' => 'Registration is not available for this event.' ) );
    }
    
    // Check capacity
    $event_capacity = get_post_meta( $event_id, '_oha_event_capacity', true );
    $event_registered = get_post_meta( $event_id, '_oha_event_registered', true ) ?: 0;
    
    if ( $event_capacity && ( $event_registered + $guests + 1 ) > $event_capacity ) {
        wp_send_json_error( array( 'message' => 'Not enough spots available for the requested number of attendees.' ) );
    }
    
    // Check registration deadline
    $registration_deadline = get_post_meta( $event_id, '_oha_event_registration_deadline', true );
    if ( $registration_deadline ) {
        $deadline_date = DateTime::createFromFormat( 'Y-m-d', $registration_deadline );
        $today = new DateTime();
        if ( $deadline_date < $today ) {
            wp_send_json_error( array( 'message' => 'Registration deadline has passed.' ) );
        }
    }
    
    // Create registration record
    $registration_data = array(
        'event_id' => $event_id,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'guests' => $guests,
        'notes' => $notes,
        'registration_date' => current_time( 'mysql' ),
        'user_ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT']
    );
    
    // Store registration in database
    global $wpdb;
    $table_name = $wpdb->prefix . 'oha_event_registrations';
    
    // Create table if it doesn't exist
    oha_create_event_registrations_table();
    
    $result = $wpdb->insert( $table_name, $registration_data );
    
    if ( $result ) {
        // Update registered count
        update_post_meta( $event_id, '_oha_event_registered', $event_registered + $guests + 1 );
        
        // Send confirmation email
        oha_send_registration_confirmation( $event_id, $registration_data );
        
        // Send admin notification
        oha_send_admin_registration_notification( $event_id, $registration_data );
        
        wp_send_json_success( array( 
            'message' => 'Registration successful! You will receive a confirmation email shortly.' 
        ) );
    } else {
        wp_send_json_error( array( 'message' => 'Registration failed. Please try again.' ) );
    }
}
add_action( 'wp_ajax_oha_event_registration', 'oha_handle_event_registration' );
add_action( 'wp_ajax_nopriv_oha_event_registration', 'oha_handle_event_registration' );

// Create event registrations table
function oha_create_event_registrations_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'oha_event_registrations';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        event_id bigint(20) NOT NULL,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(50),
        guests int(11) DEFAULT 0,
        notes text,
        registration_date datetime DEFAULT CURRENT_TIMESTAMP,
        user_ip varchar(45),
        user_agent text,
        status varchar(20) DEFAULT 'confirmed',
        PRIMARY KEY (id),
        KEY event_id (event_id),
        KEY email (email)
    ) $charset_collate;";
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

// Send registration confirmation email
function oha_send_registration_confirmation( $event_id, $registration_data ) {
    $event = get_post( $event_id );
    $event_date = get_post_meta( $event_id, '_oha_event_date', true );
    $event_time = get_post_meta( $event_id, '_oha_event_time', true );
    $event_location = get_post_meta( $event_id, '_oha_event_location', true );
    
    $subject = sprintf( 'Registration Confirmation - %s', $event->post_title );
    
    $message = "Dear {$registration_data['name']},\n\n";
    $message .= "Thank you for registering for the following event:\n\n";
    $message .= "Event: {$event->post_title}\n";
    
    if ( $event_date ) {
        $message .= "Date: " . date_i18n( get_option( 'date_format' ), strtotime( $event_date ) ) . "\n";
    }
    
    if ( $event_time ) {
        $message .= "Time: {$event_time}\n";
    }
    
    if ( $event_location ) {
        $message .= "Location: {$event_location}\n";
    }
    
    if ( $registration_data['guests'] > 0 ) {
        $message .= "Guests: {$registration_data['guests']}\n";
    }
    
    $message .= "\nEvent Details: " . get_permalink( $event_id ) . "\n\n";
    $message .= "We look forward to seeing you at the event!\n\n";
    $message .= "Best regards,\n";
    $message .= "Oman Hockey Association";
    
    wp_mail( $registration_data['email'], $subject, $message );
}

// Send admin notification for new registration
function oha_send_admin_registration_notification( $event_id, $registration_data ) {
    $event = get_post( $event_id );
    $admin_email = get_option( 'admin_email' );
    
    $subject = sprintf( 'New Event Registration - %s', $event->post_title );
    
    $message = "A new registration has been received:\n\n";
    $message .= "Event: {$event->post_title}\n";
    $message .= "Name: {$registration_data['name']}\n";
    $message .= "Email: {$registration_data['email']}\n";
    
    if ( $registration_data['phone'] ) {
        $message .= "Phone: {$registration_data['phone']}\n";
    }
    
    if ( $registration_data['guests'] > 0 ) {
        $message .= "Guests: {$registration_data['guests']}\n";
    }
    
    if ( $registration_data['notes'] ) {
        $message .= "Notes: {$registration_data['notes']}\n";
    }
    
    $message .= "\nRegistration Date: {$registration_data['registration_date']}\n";
    $message .= "Event Details: " . get_permalink( $event_id ) . "\n";
    $message .= "Admin Panel: " . admin_url( 'edit.php?post_type=event' );
    
    wp_mail( $admin_email, $subject, $message );
}

// AJAX handler for video view tracking
function oha_track_video_view() {
    // Verify nonce
    if ( ! wp_verify_nonce( $_POST['nonce'], 'oha_ajax_nonce' ) ) {
        wp_die( 'Security check failed' );
    }
    
    $video_id = intval( $_POST['video_id'] );
    
    if ( $video_id ) {
        $current_views = get_post_meta( $video_id, 'post_views_count', true );
        $current_views = $current_views ? intval( $current_views ) : 0;
        
        update_post_meta( $video_id, 'post_views_count', $current_views + 1 );
        
        wp_send_json_success( array( 'views' => $current_views + 1 ) );
    }
    
    wp_send_json_error( 'Invalid request' );
}
add_action( 'wp_ajax_oha_track_video_view', 'oha_track_video_view' );
add_action( 'wp_ajax_nopriv_oha_track_video_view', 'oha_track_video_view' );

// Add meta boxes for enhanced post types
function oha_add_enhanced_meta_boxes() {
    // Video meta boxes
    add_meta_box(
        'oha_video_details',
        'Video Details',
        'oha_video_details_callback',
        'oha_video',
        'normal',
        'high'
    );
    
    // Event meta boxes
    add_meta_box(
        'oha_event_details',
        'Event Details',
        'oha_event_details_callback',
        'event',
        'normal',
        'high'
    );
    
    add_meta_box(
        'oha_event_registration',
        'Registration Settings',
        'oha_event_registration_callback',
        'event',
        'side',
        'default'
    );
}
add_action( 'add_meta_boxes', 'oha_add_enhanced_meta_boxes' );

// Video details meta box callback
function oha_video_details_callback( $post ) {
    wp_nonce_field( 'oha_video_details_nonce', 'oha_video_details_nonce' );
    
    $video_url = get_post_meta( $post->ID, '_oha_video_url', true );
    $video_embed = get_post_meta( $post->ID, '_oha_video_embed', true );
    $video_duration = get_post_meta( $post->ID, '_oha_video_duration', true );
    $video_type = get_post_meta( $post->ID, '_oha_video_type', true );
    $video_publish_date = get_post_meta( $post->ID, '_oha_video_publish_date', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="oha_video_url">Video URL</label></th>
            <td>
                <input type="url" id="oha_video_url" name="oha_video_url" value="<?php echo esc_attr( $video_url ); ?>" class="regular-text" />
                <p class="description">YouTube, Vimeo, or direct video file URL</p>
            </td>
        </tr>
        <tr>
            <th><label for="oha_video_embed">Custom Embed Code</label></th>
            <td>
                <textarea id="oha_video_embed" name="oha_video_embed" rows="4" class="large-text"><?php echo esc_textarea( $video_embed ); ?></textarea>
                <p class="description">Optional: Custom embed code (will override URL)</p>
            </td>
        </tr>
        <tr>
            <th><label for="oha_video_duration">Duration</label></th>
            <td>
                <input type="text" id="oha_video_duration" name="oha_video_duration" value="<?php echo esc_attr( $video_duration ); ?>" placeholder="e.g., 10:30" />
                <p class="description">Format: MM:SS or HH:MM:SS</p>
            </td>
        </tr>
        <tr>
            <th><label for="oha_video_publish_date">Video Publish Date</label></th>
            <td>
                <input type="date" id="oha_video_publish_date" name="oha_video_publish_date" value="<?php echo esc_attr( $video_publish_date ); ?>" />
                <p class="description">The original date when this video was published/recorded</p>
            </td>
        </tr>
        <tr>
            <th><label for="oha_video_type">Video Type</label></th>
            <td>
                <select id="oha_video_type" name="oha_video_type">
                    <option value="match" <?php selected( $video_type, 'match' ); ?>>Match</option>
                    <option value="training" <?php selected( $video_type, 'training' ); ?>>Training</option>
                    <option value="interview" <?php selected( $video_type, 'interview' ); ?>>Interview</option>
                    <option value="highlights" <?php selected( $video_type, 'highlights' ); ?>>Highlights</option>
                    <option value="documentary" <?php selected( $video_type, 'documentary' ); ?>>Documentary</option>
                    <option value="other" <?php selected( $video_type, 'other' ); ?>>Other</option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

// Event details meta box callback
function oha_event_details_callback( $post ) {
    wp_nonce_field( 'oha_event_details_nonce', 'oha_event_details_nonce' );
    
    $event_date = get_post_meta( $post->ID, '_oha_event_date', true );
    $event_time = get_post_meta( $post->ID, '_oha_event_time', true );
    $event_location = get_post_meta( $post->ID, '_oha_event_location', true );
    $event_address = get_post_meta( $post->ID, '_oha_event_address', true );
    $event_organizer = get_post_meta( $post->ID, '_oha_event_organizer', true );
    $event_price = get_post_meta( $post->ID, '_oha_event_price', true );
    $event_status = get_post_meta( $post->ID, '_oha_event_status', true ) ?: 'upcoming';
    $event_contact_email = get_post_meta( $post->ID, '_oha_event_contact_email', true );
    $event_contact_phone = get_post_meta( $post->ID, '_oha_event_contact_phone', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="oha_event_date">Event Date</label></th>
            <td>
                <input type="date" id="oha_event_date" name="oha_event_date" value="<?php echo esc_attr( $event_date ); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_time">Event Time</label></th>
            <td>
                <input type="time" id="oha_event_time" name="oha_event_time" value="<?php echo esc_attr( $event_time ); ?>" />
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_location">Location</label></th>
            <td>
                <input type="text" id="oha_event_location" name="oha_event_location" value="<?php echo esc_attr( $event_location ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_address">Full Address</label></th>
            <td>
                <textarea id="oha_event_address" name="oha_event_address" rows="3" class="large-text"><?php echo esc_textarea( $event_address ); ?></textarea>
                <p class="description">Full address for map directions</p>
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_organizer">Organizer</label></th>
            <td>
                <input type="text" id="oha_event_organizer" name="oha_event_organizer" value="<?php echo esc_attr( $event_organizer ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_price">Price</label></th>
            <td>
                <input type="text" id="oha_event_price" name="oha_event_price" value="<?php echo esc_attr( $event_price ); ?>" placeholder="Free or amount" />
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_status">Status</label></th>
            <td>
                <select id="oha_event_status" name="oha_event_status">
                    <option value="upcoming" <?php selected( $event_status, 'upcoming' ); ?>>Upcoming</option>
                    <option value="ongoing" <?php selected( $event_status, 'ongoing' ); ?>>Ongoing</option>
                    <option value="completed" <?php selected( $event_status, 'completed' ); ?>>Completed</option>
                    <option value="cancelled" <?php selected( $event_status, 'cancelled' ); ?>>Cancelled</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_contact_email">Contact Email</label></th>
            <td>
                <input type="email" id="oha_event_contact_email" name="oha_event_contact_email" value="<?php echo esc_attr( $event_contact_email ); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_contact_phone">Contact Phone</label></th>
            <td>
                <input type="tel" id="oha_event_contact_phone" name="oha_event_contact_phone" value="<?php echo esc_attr( $event_contact_phone ); ?>" />
            </td>
        </tr>
    </table>
    <?php
}

// Event registration meta box callback
function oha_event_registration_callback( $post ) {
    wp_nonce_field( 'oha_event_registration_nonce', 'oha_event_registration_nonce' );
    
    $event_capacity = get_post_meta( $post->ID, '_oha_event_capacity', true );
    $event_registered = get_post_meta( $post->ID, '_oha_event_registered', true ) ?: 0;
    $registration_deadline = get_post_meta( $post->ID, '_oha_event_registration_deadline', true );
    ?>
    <table class="form-table">
        <tr>
            <th><label for="oha_event_capacity">Capacity</label></th>
            <td>
                <input type="number" id="oha_event_capacity" name="oha_event_capacity" value="<?php echo esc_attr( $event_capacity ); ?>" min="1" />
                <p class="description">Maximum number of attendees</p>
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_registered">Registered</label></th>
            <td>
                <input type="number" id="oha_event_registered" name="oha_event_registered" value="<?php echo esc_attr( $event_registered ); ?>" min="0" />
                <p class="description">Current number of registered attendees</p>
            </td>
        </tr>
        <tr>
            <th><label for="oha_event_registration_deadline">Registration Deadline</label></th>
            <td>
                <input type="date" id="oha_event_registration_deadline" name="oha_event_registration_deadline" value="<?php echo esc_attr( $registration_deadline ); ?>" />
                <p class="description">Last date for registration</p>
            </td>
        </tr>
    </table>
    <?php
}

// Save enhanced meta box data
function oha_save_enhanced_meta_boxes( $post_id ) {
    // Check if it's an autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    
    // Check user permissions
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    
    // Save slide banner options
    if ( isset( $_POST['oha_slide_banner_options_nonce'] ) && wp_verify_nonce( $_POST['oha_slide_banner_options_nonce'], 'oha_slide_banner_options_nonce' ) ) {
        $hide_banner_text = isset( $_POST['oha_hide_banner_text'] ) ? '1' : '0';
        update_post_meta( $post_id, '_oha_hide_banner_text', $hide_banner_text );
    }
    
    // Save slide CTA options
    if ( isset( $_POST['oha_slide_cta_options_nonce'] ) && wp_verify_nonce( $_POST['oha_slide_cta_options_nonce'], 'oha_slide_cta_options_nonce' ) ) {
        $cta_fields = array(
            '_oha_enable_learn_more' => isset( $_POST['oha_enable_learn_more'] ) ? '1' : '0',
            '_oha_learn_more_text' => sanitize_text_field( $_POST['oha_learn_more_text'] ?? '' ),
            '_oha_learn_more_url' => esc_url_raw( $_POST['oha_learn_more_url'] ?? '' ),
            '_oha_enable_secondary_cta' => isset( $_POST['oha_enable_secondary_cta'] ) ? '1' : '0',
            '_oha_secondary_cta_text' => sanitize_text_field( $_POST['oha_secondary_cta_text'] ?? '' ),
            '_oha_secondary_cta_url' => esc_url_raw( $_POST['oha_secondary_cta_url'] ?? '' )
        );
        
        foreach ( $cta_fields as $field => $value ) {
            update_post_meta( $post_id, $field, $value );
        }
    }
    
    // Save video meta data
    if ( isset( $_POST['oha_video_details_nonce'] ) && wp_verify_nonce( $_POST['oha_video_details_nonce'], 'oha_video_details_nonce' ) ) {
        $video_fields = array(
            '_oha_video_url' => 'esc_url_raw',
            '_oha_video_embed' => 'wp_kses_post',
            '_oha_video_duration' => 'sanitize_text_field',
            '_oha_video_type' => 'sanitize_text_field',
            '_oha_video_publish_date' => 'sanitize_text_field'
        );
        
        foreach ( $video_fields as $field => $sanitize_func ) {
            $field_name = str_replace( '_oha_', 'oha_', $field );
            if ( isset( $_POST[ $field_name ] ) ) {
                update_post_meta( $post_id, $field, $sanitize_func( $_POST[ $field_name ] ) );
            }
        }
    }
    
    // Save event meta data
    if ( isset( $_POST['oha_event_details_nonce'] ) && wp_verify_nonce( $_POST['oha_event_details_nonce'], 'oha_event_details_nonce' ) ) {
        $event_fields = array(
            '_oha_event_date' => 'sanitize_text_field',
            '_oha_event_time' => 'sanitize_text_field',
            '_oha_event_location' => 'sanitize_text_field',
            '_oha_event_address' => 'sanitize_textarea_field',
            '_oha_event_organizer' => 'sanitize_text_field',
            '_oha_event_price' => 'sanitize_text_field',
            '_oha_event_status' => 'sanitize_text_field',
            '_oha_event_contact_email' => 'sanitize_email',
            '_oha_event_contact_phone' => 'sanitize_text_field'
        );
        
        foreach ( $event_fields as $field => $sanitize_func ) {
            $field_name = str_replace( '_oha_', 'oha_', $field );
            if ( isset( $_POST[ $field_name ] ) ) {
                update_post_meta( $post_id, $field, $sanitize_func( $_POST[ $field_name ] ) );
            }
        }
    }
    
    // Save event registration data
    if ( isset( $_POST['oha_event_registration_nonce'] ) && wp_verify_nonce( $_POST['oha_event_registration_nonce'], 'oha_event_registration_nonce' ) ) {
        $registration_fields = array(
            '_oha_event_capacity' => 'intval',
            '_oha_event_registered' => 'intval',
            '_oha_event_registration_deadline' => 'sanitize_text_field'
        );
        
        foreach ( $registration_fields as $field => $sanitize_func ) {
            $field_name = str_replace( '_oha_', 'oha_', $field );
            if ( isset( $_POST[ $field_name ] ) ) {
                update_post_meta( $post_id, $field, $sanitize_func( $_POST[ $field_name ] ) );
            }
        }
    }
}
add_action( 'save_post', 'oha_save_enhanced_meta_boxes' );

// Add custom columns to admin lists
function oha_add_video_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $title ) {
        $new_columns[ $key ] = $title;
        if ( $key === 'title' ) {
            $new_columns['video_publish_date'] = 'Publish Date';
            $new_columns['video_duration'] = 'Duration';
            $new_columns['video_type'] = 'Type';
            $new_columns['video_views'] = 'Views';
            $new_columns['video_likes'] = 'Likes';
        }
    }
    return $new_columns;
}
add_filter( 'manage_oha_video_posts_columns', 'oha_add_video_admin_columns' );

function oha_video_admin_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'video_publish_date':
            $publish_date = get_post_meta( $post_id, '_oha_video_publish_date', true );
            if ( $publish_date ) {
                echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $publish_date ) ) );
            } else {
                echo '—';
            }
            break;
        case 'video_duration':
            echo esc_html( get_post_meta( $post_id, '_oha_video_duration', true ) ?: '—' );
            break;
        case 'video_type':
            echo esc_html( ucfirst( get_post_meta( $post_id, '_oha_video_type', true ) ?: '—' ) );
            break;
        case 'video_views':
            echo esc_html( get_post_meta( $post_id, 'post_views_count', true ) ?: '0' );
            break;
        case 'video_likes':
            echo esc_html( get_post_meta( $post_id, 'video_likes', true ) ?: '0' );
            break;
    }
}
add_action( 'manage_oha_video_posts_custom_column', 'oha_video_admin_column_content', 10, 2 );

function oha_add_event_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $title ) {
        $new_columns[ $key ] = $title;
        if ( $key === 'title' ) {
            $new_columns['event_date'] = 'Date';
            $new_columns['event_location'] = 'Location';
            $new_columns['event_status'] = 'Status';
            $new_columns['event_registered'] = 'Registered';
        }
    }
    return $new_columns;
}
add_filter( 'manage_event_posts_columns', 'oha_add_event_admin_columns' );

function oha_event_admin_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'event_date':
            $date = get_post_meta( $post_id, '_oha_event_date', true );
            echo $date ? esc_html( date_i18n( get_option( 'date_format' ), strtotime( $date ) ) ) : '—';
            break;
        case 'event_location':
            echo esc_html( get_post_meta( $post_id, '_oha_event_location', true ) ?: '—' );
            break;
        case 'event_status':
            $status = get_post_meta( $post_id, '_oha_event_status', true ) ?: 'upcoming';
            echo '<span class="event-status-' . esc_attr( $status ) . '">' . esc_html( ucfirst( $status ) ) . '</span>';
            break;
        case 'event_registered':
            $registered = get_post_meta( $post_id, '_oha_event_registered', true ) ?: 0;
            $capacity = get_post_meta( $post_id, '_oha_event_capacity', true );
            echo esc_html( $registered );
            if ( $capacity ) {
                echo ' / ' . esc_html( $capacity );
            }
            break;
    }
}
add_action( 'manage_event_posts_custom_column', 'oha_event_admin_column_content', 10, 2 );

// Add admin styles for status indicators
function oha_admin_styles() {
    echo '<style>
        .event-status-upcoming { color: #007cba; font-weight: bold; }
        .event-status-ongoing { color: #46b450; font-weight: bold; }
        .event-status-completed { color: #999; }
        .event-status-cancelled { color: #dc3232; font-weight: bold; }
    </style>';
}
add_action( 'admin_head', 'oha_admin_styles' );

// Initialize event registrations table on theme activation
function oha_theme_activation() {
    oha_create_event_registrations_table();
}
add_action( 'after_switch_theme', 'oha_theme_activation' );

// Add admin menu for event registrations
function oha_add_event_registrations_menu() {
    add_submenu_page(
        'edit.php?post_type=event',
        'Event Registrations',
        'Registrations',
        'manage_options',
        'event-registrations',
        'oha_event_registrations_page'
    );
}
add_action( 'admin_menu', 'oha_add_event_registrations_menu' );

// Event registrations admin page
function oha_event_registrations_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'oha_event_registrations';
    
    // Handle registration deletion
    if ( isset( $_GET['action'] ) && $_GET['action'] === 'delete' && isset( $_GET['id'] ) ) {
        $id = intval( $_GET['id'] );
        $wpdb->delete( $table_name, array( 'id' => $id ), array( '%d' ) );
        echo '<div class="notice notice-success"><p>Registration deleted successfully.</p></div>';
    }
    
    $registrations = $wpdb->get_results( "
        SELECT r.*, p.post_title as event_title 
        FROM $table_name r 
        LEFT JOIN {$wpdb->posts} p ON r.event_id = p.ID 
        ORDER BY r.registration_date DESC
    " );
    ?>
    <div class="wrap">
        <h1>Event Registrations</h1>
        
        <?php if ( $registrations ) : ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Guests</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $registrations as $registration ) : ?>
                        <tr>
                            <td>
                                <strong><?php echo esc_html( $registration->event_title ); ?></strong>
                            </td>
                            <td><?php echo esc_html( $registration->name ); ?></td>
                            <td>
                                <a href="mailto:<?php echo esc_attr( $registration->email ); ?>">
                                    <?php echo esc_html( $registration->email ); ?>
                                </a>
                            </td>
                            <td>
                                <?php if ( $registration->phone ) : ?>
                                    <a href="tel:<?php echo esc_attr( $registration->phone ); ?>">
                                        <?php echo esc_html( $registration->phone ); ?>
                                    </a>
                                <?php else : ?>
                                    —
                                <?php endif; ?>
                            </td>
                            <td><?php echo esc_html( $registration->guests ); ?></td>
                            <td><?php echo esc_html( date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $registration->registration_date ) ) ); ?></td>
                            <td>
                                <a href="<?php echo esc_url( admin_url( 'edit.php?post_type=event&page=event-registrations&action=delete&id=' . $registration->id ) ); ?>" 
                                   class="button" 
                                   onclick="return confirm('Are you sure you want to delete this registration?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No registrations found.</p>
        <?php endif; ?>
    </div>
    <?php
}

// Add slide banner management meta boxes
function oha_add_slide_meta_boxes() {
    add_meta_box(
        'oha-slide-banner-options',
        __( 'Banner Display Options', 'oha-theme' ),
        'oha_slide_banner_options_callback',
        'slide',
        'normal',
        'high'
    );
    
    add_meta_box(
        'oha-slide-cta-options',
        __( 'Call-to-Action Settings', 'oha-theme' ),
        'oha_slide_cta_options_callback',
        'slide',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'oha_add_slide_meta_boxes' );

// Slide banner options meta box callback
function oha_slide_banner_options_callback( $post ) {
    wp_nonce_field( 'oha_slide_banner_options_nonce', 'oha_slide_banner_options_nonce' );
    
    $hide_banner_text = get_post_meta( $post->ID, '_oha_hide_banner_text', true );
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="oha_hide_banner_text"><?php esc_html_e( 'Banner Text Display', 'oha-theme' ); ?></label>
            </th>
            <td>
                <label>
                    <input type="checkbox" name="oha_hide_banner_text" id="oha_hide_banner_text" value="1" <?php checked( $hide_banner_text, '1' ); ?> />
                    <?php esc_html_e( 'Hide banner title and subtitle text', 'oha-theme' ); ?>
                </label>
                <p class="description"><?php esc_html_e( 'Check this to hide the title and subtitle text on this slide, showing only the background image.', 'oha-theme' ); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

// Slide CTA options meta box callback
function oha_slide_cta_options_callback( $post ) {
    wp_nonce_field( 'oha_slide_cta_options_nonce', 'oha_slide_cta_options_nonce' );
    
    $enable_learn_more = get_post_meta( $post->ID, '_oha_enable_learn_more', true );
    $learn_more_text = get_post_meta( $post->ID, '_oha_learn_more_text', true );
    $learn_more_url = get_post_meta( $post->ID, '_oha_learn_more_url', true );
    $enable_secondary_cta = get_post_meta( $post->ID, '_oha_enable_secondary_cta', true );
    $secondary_cta_text = get_post_meta( $post->ID, '_oha_secondary_cta_text', true );
    $secondary_cta_url = get_post_meta( $post->ID, '_oha_secondary_cta_url', true );
    
    // Set defaults
    if ( empty( $enable_learn_more ) ) {
        $enable_learn_more = '1'; // Default to enabled
    }
    if ( empty( $learn_more_text ) ) {
        $learn_more_text = 'Learn More';
    }
    if ( empty( $enable_secondary_cta ) ) {
        $enable_secondary_cta = '1'; // Default to enabled
    }
    if ( empty( $secondary_cta_text ) ) {
        $secondary_cta_text = 'Contact Us';
    }
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Primary Button (Learn More)', 'oha-theme' ); ?></label>
            </th>
            <td>
                <label style="margin-bottom: 10px; display: block;">
                    <input type="checkbox" name="oha_enable_learn_more" value="1" <?php checked( $enable_learn_more, '1' ); ?> />
                    <?php esc_html_e( 'Enable primary button', 'oha-theme' ); ?>
                </label>
                
                <p>
                    <label for="oha_learn_more_text"><?php esc_html_e( 'Button Text:', 'oha-theme' ); ?></label><br>
                    <input type="text" name="oha_learn_more_text" id="oha_learn_more_text" value="<?php echo esc_attr( $learn_more_text ); ?>" class="regular-text" placeholder="Learn More" />
                </p>
                
                <p>
                    <label for="oha_learn_more_url"><?php esc_html_e( 'Button URL:', 'oha-theme' ); ?></label><br>
                    <input type="url" name="oha_learn_more_url" id="oha_learn_more_url" value="<?php echo esc_url( $learn_more_url ); ?>" class="regular-text" placeholder="https://example.com" />
                    <br><small class="description"><?php esc_html_e( 'Leave empty to use default link (/about)', 'oha-theme' ); ?></small>
                </p>
            </td>
        </tr>
        
        <tr>
            <th scope="row">
                <label><?php esc_html_e( 'Secondary Button', 'oha-theme' ); ?></label>
            </th>
            <td>
                <label style="margin-bottom: 10px; display: block;">
                    <input type="checkbox" name="oha_enable_secondary_cta" value="1" <?php checked( $enable_secondary_cta, '1' ); ?> />
                    <?php esc_html_e( 'Enable secondary button', 'oha-theme' ); ?>
                </label>
                
                <p>
                    <label for="oha_secondary_cta_text"><?php esc_html_e( 'Button Text:', 'oha-theme' ); ?></label><br>
                    <input type="text" name="oha_secondary_cta_text" id="oha_secondary_cta_text" value="<?php echo esc_attr( $secondary_cta_text ); ?>" class="regular-text" placeholder="Contact Us" />
                </p>
                
                <p>
                    <label for="oha_secondary_cta_url"><?php esc_html_e( 'Button URL:', 'oha-theme' ); ?></label><br>
                    <input type="url" name="oha_secondary_cta_url" id="oha_secondary_cta_url" value="<?php echo esc_url( $secondary_cta_url ); ?>" class="regular-text" placeholder="https://example.com" />
                    <br><small class="description"><?php esc_html_e( 'Leave empty to use default link (/contact)', 'oha-theme' ); ?></small>
                </p>
            </td>
        </tr>
    </table>
    <?php
}

function oha_add_slide_admin_columns( $columns ) {
    $new_columns = array();
    foreach ( $columns as $key => $title ) {
        $new_columns[ $key ] = $title;
        if ( $key === 'title' ) {
            $new_columns['slide_text_display'] = 'Text Display';
            $new_columns['slide_buttons'] = 'Buttons';
            $new_columns['slide_order'] = 'Order';
        }
    }
    return $new_columns;
}
add_filter( 'manage_slide_posts_columns', 'oha_add_slide_admin_columns' );

function oha_slide_admin_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'slide_text_display':
            $hide_text = get_post_meta( $post_id, '_oha_hide_banner_text', true );
            if ( $hide_text ) {
                echo '<span style="color: #dc3232;">✗ Hidden</span>';
            } else {
                echo '<span style="color: #46b450;">✓ Visible</span>';
            }
            break;
        case 'slide_buttons':
            $enable_learn_more = get_post_meta( $post_id, '_oha_enable_learn_more', true );
            $enable_secondary = get_post_meta( $post_id, '_oha_enable_secondary_cta', true );
            
            // Default to enabled if not set
            if ( $enable_learn_more === '' ) $enable_learn_more = '1';
            if ( $enable_secondary === '' ) $enable_secondary = '1';
            
            $buttons = array();
            if ( $enable_learn_more ) {
                $buttons[] = 'Primary';
            }
            if ( $enable_secondary ) {
                $buttons[] = 'Secondary';
            }
            
            if ( ! empty( $buttons ) ) {
                echo esc_html( implode( ', ', $buttons ) );
            } else {
                echo '<span style="color: #999;">None</span>';
            }
            break;
        case 'slide_order':
            echo esc_html( get_post_field( 'menu_order', $post_id ) ?: '0' );
            break;
    }
}
add_action( 'manage_slide_posts_custom_column', 'oha_slide_admin_column_content', 10, 2 );

// Latest News page ACF settings
require get_template_directory() . '/inc/acf-latest-news.php';

// Latest Videos ACF settings
require get_template_directory() . '/inc/acf-latest-videos.php';

// Latest Events ACF settings
require get_template_directory() . '/inc/acf-latest-events.php';

// at bottom near other enqueue
function oha_enqueue_editor_blocks(){
    wp_enqueue_script( 'oha-editor-blocks', get_template_directory_uri() . '/js/editor-blocks.js', array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ), '1.0', true );
}
add_action( 'enqueue_block_editor_assets', 'oha_enqueue_editor_blocks' );

// Enqueue video modal script
function oha_enqueue_video_modal() {
    wp_enqueue_script( 'oha-video-modal', get_template_directory_uri() . '/js/video-modal.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'oha_enqueue_video_modal' );

/**
 * Fix permalink issues by flushing rewrite rules when needed
 */
function oha_flush_rewrite_rules_on_activation() {
    // Register custom post types first
    oha_register_custom_post_types();
    // Then flush rewrite rules
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'oha_flush_rewrite_rules_on_activation' );

/**
 * Ensure rewrite rules are flushed when switching to this theme
 */
function oha_flush_rewrite_rules_on_switch() {
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'oha_flush_rewrite_rules_on_switch' );

/**
 * Register custom post types
 */
function oha_register_custom_post_types() {
    // Register Video post type
    register_post_type( 'oha_video', array(
        'labels' => array(
            'name' => 'Videos',
            'singular_name' => 'Video',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'video' ),
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'menu_icon' => 'dashicons-video-alt3',
    ));

    // Register Event post type
    register_post_type( 'event', array(
        'labels' => array(
            'name' => 'Events',
            'singular_name' => 'Event',
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array( 'slug' => 'events' ),
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
        'menu_icon' => 'dashicons-calendar-alt',
    ));
}
add_action( 'init', 'oha_register_custom_post_types' );
