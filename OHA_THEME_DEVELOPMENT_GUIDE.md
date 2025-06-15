# OHA (Oman Hockey Association) Custom WordPress Theme Development Guide

## Project Pivot Overview

**Previous Approach:** Modifying existing BeTheme child theme (hockey-child-test) with CSS overrides and fighting Muffin Builder conflicts.

**New Approach:** Building a custom WordPress theme using Underscores (_s) starter theme as foundation, providing complete control over design and functionality.

## Why We Pivoted to Underscores

### Problems with Previous Approach:
- ❌ Muffin Builder CSS conflicts
- ❌ Difficult to override existing styles
- ❌ Bloated parent theme code
- ❌ Limited customization control
- ❌ Performance issues
- ❌ Maintenance nightmares

### Benefits of Underscores Approach:
- ✅ Complete design freedom
- ✅ Clean, minimal codebase
- ✅ WordPress best practices
- ✅ Perfect OHA brand implementation
- ✅ High performance
- ✅ Easy maintenance and updates
- ✅ No conflicts or overrides needed

## Phase 1: Project Setup and Foundation

### Step 1: Download and Install Underscores Theme

```bash
# Navigate to WordPress themes directory
cd wp-content/themes/

# Download Underscores theme
# Option A: Download from underscores.me with custom name "oha-theme"
# Option B: Clone from GitHub and rename
git clone https://github.com/Automattic/_s.git oha-theme
cd oha-theme

# Update theme information in style.css
```

### Step 2: Theme Configuration

**File: `style.css` - Update Theme Header**
```css
/*
Theme Name: OHA - Oman Hockey Association
Description: Custom WordPress theme for Oman Hockey Association featuring official OHA branding, modern responsive design, and custom sections for news, videos, events, and team management.
Author: OHA Development Team
Version: 1.0.0
License: GPL v2 or later
Text Domain: oha-theme
Tags: responsive, accessibility-ready, custom-header, custom-logo, custom-menu, featured-images, flexible-header, microformats, post-formats, rtl-language-support, sticky-post, threaded-comments, translation-ready
Template: oha-theme

OHA Official Colors:
Primary Green: #58AA35
Primary Red: #E5201D
Light Gray: #D1D3D4
Dark Gray: #58595C
*/
```

### Step 3: Update Functions.php with OHA Configuration

**File: `functions.php` - Initial Setup**
```php
<?php
/**
 * OHA Theme Functions and Definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package OHA_Theme
 */

if (!defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function oha_theme_setup() {
    // Add theme support for various features
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 300,
        'flex-width'  => true,
        'flex-height' => true,
    ));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'oha-theme'),
        'footer'  => esc_html__('Footer Menu', 'oha-theme'),
    ));
    
    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
    
    // Add theme support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'oha_theme_setup');

/**
 * Enqueue scripts and styles.
 */
function oha_theme_scripts() {
    // Main stylesheet
    wp_enqueue_style('oha-style', get_stylesheet_uri(), array(), _S_VERSION);
    
    // OHA global styles
    wp_enqueue_style('oha-global', get_template_directory_uri() . '/assets/css/oha-global.css', array('oha-style'), _S_VERSION);
    
    // OHA components
    wp_enqueue_style('oha-components', get_template_directory_uri() . '/assets/css/oha-components.css', array('oha-global'), _S_VERSION);
    
    // Responsive styles
    wp_enqueue_style('oha-responsive', get_template_directory_uri() . '/assets/css/oha-responsive.css', array('oha-components'), _S_VERSION);
    
    // Main JavaScript
    wp_enqueue_script('oha-main', get_template_directory_uri() . '/assets/js/oha-main.js', array('jquery'), _S_VERSION, true);
    
    // Swiper for sliders (only on front page)
    if (is_front_page()) {
        wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css', array(), '10.0.0');
        wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js', array(), '10.0.0', true);
        wp_enqueue_script('oha-slider', get_template_directory_uri() . '/assets/js/oha-slider.js', array('swiper-js'), _S_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'oha_theme_scripts');

// Include additional functionality
require get_template_directory() . '/inc/oha-setup.php';
require get_template_directory() . '/inc/custom-post-types.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/template-functions.php';
?>
```

## Phase 2: OHA Brand Implementation

### Step 4: Create Global CSS with OHA Branding

**File: `assets/css/oha-global.css`**
```css
/* OHA Global Styles - Brand Implementation */

/* CSS Custom Properties (Variables) */
:root {
    /* OHA Official Colors */
    --oha-primary-green: #58AA35;
    --oha-primary-red: #E5201D;
    --oha-light-gray: #D1D3D4;
    --oha-dark-gray: #58595C;
    --oha-white: #FFFFFF;
    --oha-black: #000000;
    
    /* Typography Variables */
    --oha-font-primary: 'PF Din Text Universal', Arial, sans-serif;
    --oha-font-fallback: Arial, Helvetica, sans-serif;
    
    /* Spacing Variables */
    --oha-spacing-xs: 0.5rem;
    --oha-spacing-sm: 1rem;
    --oha-spacing-md: 1.5rem;
    --oha-spacing-lg: 2rem;
    --oha-spacing-xl: 3rem;
    
    /* Border Radius */
    --oha-border-radius: 8px;
    --oha-border-radius-sm: 4px;
    
    /* Shadows */
    --oha-shadow-light: 0 2px 4px rgba(0, 0, 0, 0.1);
    --oha-shadow-medium: 0 4px 8px rgba(0, 0, 0, 0.15);
    --oha-shadow-dark: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* Typography Implementation */
body {
    font-family: var(--oha-font-primary);
    font-weight: 400; /* Regular */
    line-height: 1.6;
    color: var(--oha-black);
}

/* Heading Hierarchy with PF Din Text Universal */
h1 {
    font-family: var(--oha-font-primary);
    font-weight: 800; /* ExtraBold */
    color: var(--oha-primary-green);
    font-size: clamp(2rem, 5vw, 3.5rem);
    line-height: 1.2;
    margin-bottom: var(--oha-spacing-md);
}

h2 {
    font-family: var(--oha-font-primary);
    font-weight: 700; /* Bold */
    color: var(--oha-primary-green);
    font-size: clamp(1.5rem, 4vw, 2.5rem);
    line-height: 1.3;
    margin-bottom: var(--oha-spacing-md);
}

h3, h4 {
    font-family: var(--oha-font-primary);
    font-weight: 500; /* Medium */
    color: var(--oha-primary-green);
    font-size: clamp(1.25rem, 3vw, 1.8rem);
    line-height: 1.4;
    margin-bottom: var(--oha-spacing-sm);
}

h5, h6 {
    font-family: var(--oha-font-primary);
    font-weight: 500; /* Medium */
    color: var(--oha-dark-gray);
    font-size: clamp(1rem, 2.5vw, 1.4rem);
    line-height: 1.4;
    margin-bottom: var(--oha-spacing-sm);
}

/* Body Text */
p, div, span, li {
    font-family: var(--oha-font-primary);
    font-weight: 400; /* Regular */
}

/* Light Text for Captions and Metadata */
.caption, .meta-text, small, .post-meta {
    font-family: var(--oha-font-primary);
    font-weight: 300; /* Light */
    color: var(--oha-dark-gray);
    font-size: 0.9rem;
}

/* Link Styles */
a {
    color: var(--oha-primary-green);
    text-decoration: none;
    transition: color 0.3s ease;
}

a:hover, a:focus {
    color: var(--oha-primary-red);
}

/* Button Styles */
.btn-oha-primary, .button-primary {
    background-color: var(--oha-primary-green);
    color: var(--oha-white);
    border: 2px solid var(--oha-primary-green);
    padding: 12px 24px;
    border-radius: var(--oha-border-radius-sm);
    font-family: var(--oha-font-primary);
    font-weight: 500; /* Medium */
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-oha-primary:hover, .button-primary:hover {
    background-color: var(--oha-primary-red);
    border-color: var(--oha-primary-red);
    color: var(--oha-white);
    transform: translateY(-2px);
    box-shadow: var(--oha-shadow-medium);
}

.btn-oha-secondary {
    background-color: transparent;
    color: var(--oha-primary-green);
    border: 2px solid var(--oha-primary-green);
    padding: 12px 24px;
    border-radius: var(--oha-border-radius-sm);
    font-family: var(--oha-font-primary);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-block;
}

.btn-oha-secondary:hover {
    background-color: var(--oha-primary-green);
    color: var(--oha-white);
}

/* Container and Layout */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 var(--oha-spacing-md);
}

.section-spacing {
    padding: var(--oha-spacing-xl) 0;
}

/* Section Titles */
.section-title {
    text-align: center;
    margin-bottom: var(--oha-spacing-xl);
    position: relative;
}

.section-title::after {
    content: '';
    display: block;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, var(--oha-primary-red) 0%, var(--oha-primary-green) 100%);
    margin: var(--oha-spacing-sm) auto 0;
    border-radius: 2px;
}

/* Card Styles */
.oha-card {
    background: var(--oha-white);
    border-radius: var(--oha-border-radius);
    box-shadow: var(--oha-shadow-light);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-left: 4px solid var(--oha-primary-green);
}

.oha-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--oha-shadow-medium);
}

/* Responsive Grid System */
.oha-grid {
    display: grid;
    gap: var(--oha-spacing-lg);
}

.oha-grid-2 {
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
}

.oha-grid-3 {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}

.oha-grid-4 {
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
}

/* Utility Classes */
.text-center { text-align: center; }
.text-left { text-align: left; }
.text-right { text-align: right; }

.color-primary-green { color: var(--oha-primary-green); }
.color-primary-red { color: var(--oha-primary-red); }
.color-dark-gray { color: var(--oha-dark-gray); }

.bg-primary-green { background-color: var(--oha-primary-green); }
.bg-primary-red { background-color: var(--oha-primary-red); }
.bg-light-gray { background-color: var(--oha-light-gray); }

.mt-xs { margin-top: var(--oha-spacing-xs); }
.mt-sm { margin-top: var(--oha-spacing-sm); }
.mt-md { margin-top: var(--oha-spacing-md); }
.mt-lg { margin-top: var(--oha-spacing-lg); }
.mt-xl { margin-top: var(--oha-spacing-xl); }

.mb-xs { margin-bottom: var(--oha-spacing-xs); }
.mb-sm { margin-bottom: var(--oha-spacing-sm); }
.mb-md { margin-bottom: var(--oha-spacing-md); }
.mb-lg { margin-bottom: var(--oha-spacing-lg); }
.mb-xl { margin-bottom: var(--oha-spacing-xl); }
```

### Step 5: Create OHA Header Structure

**File: `header.php`**
```php
<?php
/**
 * The header for OHA theme
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OHA_Theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'oha-theme'); ?></a>

    <header id="masthead" class="site-header">
        <!-- Logo Section - White Background -->
        <div class="header-logo-section">
            <div class="container">
                <div class="header-logo-wrapper">
                    <div class="site-branding">
                        <?php
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            echo '<h1 class="site-title"><a href="' . esc_url(home_url('/')) . '">' . get_bloginfo('name') . '</a></h1>';
                        }
                        ?>
                    </div>
                    
                    <!-- Social Media Icons -->
                    <div class="header-social-media">
                        <?php oha_display_social_media_icons(); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Section - OHA Green Background -->
        <div class="header-navigation-section">
            <div class="container">
                <nav id="site-navigation" class="main-navigation">
                    <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                        <span class="hamburger"></span>
                        <span class="hamburger"></span>
                        <span class="hamburger"></span>
                        <span class="sr-only"><?php esc_html_e('Menu', 'oha-theme'); ?></span>
                    </button>
                    
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>
            </div>
        </div>
    </header><!-- #masthead -->
```

## Phase 3: Custom Sections Development

### Step 6: Create Template Parts Directory Structure

Create the following files in `template-parts/` directory:

1. `section-hero-slider.php` - Homepage hero slider
2. `section-latest-news.php` - Latest news/blog posts
3. `section-latest-videos.php` - Video gallery
4. `section-team-carousel.php` - Team members carousel
5. `section-sponsors.php` - Sponsors logo section
6. `section-events.php` - Upcoming events

### Step 7: Homepage Template

**File: `front-page.php`**
```php
<?php
/**
 * The front page template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <!-- Hero Slider Section -->
    <?php get_template_part('template-parts/section', 'hero-slider'); ?>
    
    <!-- Latest News Section -->
    <?php get_template_part('template-parts/section', 'latest-news'); ?>
    
    <!-- Latest Videos Section -->
    <?php get_template_part('template-parts/section', 'latest-videos'); ?>
    
    <!-- Team Carousel Section -->
    <?php get_template_part('template-parts/section', 'team-carousel'); ?>
    
    <!-- Sponsors Section -->
    <?php get_template_part('template-parts/section', 'sponsors'); ?>
    
    <!-- Events Section -->
    <?php get_template_part('template-parts/section', 'events'); ?>

</main><!-- #main -->

<?php
get_footer();
?>
```

## Phase 4: Custom Post Types and Fields

### Step 8: Custom Post Types Setup

**File: `inc/custom-post-types.php`**
```php
<?php
/**
 * Custom Post Types for OHA Theme
 *
 * @package OHA_Theme
 */

/**
 * Register Video Post Type
 */
function oha_register_video_post_type() {
    $labels = array(
        'name'                  => _x('Videos', 'Post Type General Name', 'oha-theme'),
        'singular_name'         => _x('Video', 'Post Type Singular Name', 'oha-theme'),
        'menu_name'             => __('Videos', 'oha-theme'),
        'name_admin_bar'        => __('Video', 'oha-theme'),
        'archives'              => __('Video Archives', 'oha-theme'),
        'attributes'            => __('Video Attributes', 'oha-theme'),
        'parent_item_colon'     => __('Parent Video:', 'oha-theme'),
        'all_items'             => __('All Videos', 'oha-theme'),
        'add_new_item'          => __('Add New Video', 'oha-theme'),
        'add_new'               => __('Add New', 'oha-theme'),
        'new_item'              => __('New Video', 'oha-theme'),
        'edit_item'             => __('Edit Video', 'oha-theme'),
        'update_item'           => __('Update Video', 'oha-theme'),
        'view_item'             => __('View Video', 'oha-theme'),
        'view_items'            => __('View Videos', 'oha-theme'),
        'search_items'          => __('Search Videos', 'oha-theme'),
        'not_found'             => __('Not found', 'oha-theme'),
        'not_found_in_trash'    => __('Not found in Trash', 'oha-theme'),
        'featured_image'        => __('Video Thumbnail', 'oha-theme'),
        'set_featured_image'    => __('Set video thumbnail', 'oha-theme'),
        'remove_featured_image' => __('Remove video thumbnail', 'oha-theme'),
        'use_featured_image'    => __('Use as video thumbnail', 'oha-theme'),
        'insert_into_item'      => __('Insert into video', 'oha-theme'),
        'uploaded_to_this_item' => __('Uploaded to this video', 'oha-theme'),
        'items_list'            => __('Videos list', 'oha-theme'),
        'items_list_navigation' => __('Videos list navigation', 'oha-theme'),
        'filter_items_list'     => __('Filter videos list', 'oha-theme'),
    );

    $args = array(
        'label'                 => __('Video', 'oha-theme'),
        'description'           => __('Hockey videos and highlights', 'oha-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies'            => array('video_category'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-video-alt3',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('oha_video', $args);
}
add_action('init', 'oha_register_video_post_type', 0);

/**
 * Register Team Member Post Type
 */
function oha_register_team_member_post_type() {
    $labels = array(
        'name'                  => _x('Team Members', 'Post Type General Name', 'oha-theme'),
        'singular_name'         => _x('Team Member', 'Post Type Singular Name', 'oha-theme'),
        'menu_name'             => __('Team Members', 'oha-theme'),
        'name_admin_bar'        => __('Team Member', 'oha-theme'),
        'add_new_item'          => __('Add New Team Member', 'oha-theme'),
        'add_new'               => __('Add New', 'oha-theme'),
        'new_item'              => __('New Team Member', 'oha-theme'),
        'edit_item'             => __('Edit Team Member', 'oha-theme'),
        'view_item'             => __('View Team Member', 'oha-theme'),
    );

    $args = array(
        'label'                 => __('Team Member', 'oha-theme'),
        'description'           => __('OHA team members and staff', 'oha-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 21,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('team_member', $args);
}
add_action('init', 'oha_register_team_member_post_type', 0);

/**
 * Register Sponsor Post Type
 */
function oha_register_sponsor_post_type() {
    $labels = array(
        'name'                  => _x('Sponsors', 'Post Type General Name', 'oha-theme'),
        'singular_name'         => _x('Sponsor', 'Post Type Singular Name', 'oha-theme'),
        'menu_name'             => __('Sponsors', 'oha-theme'),
        'add_new_item'          => __('Add New Sponsor', 'oha-theme'),
        'edit_item'             => __('Edit Sponsor', 'oha-theme'),
    );

    $args = array(
        'label'                 => __('Sponsor', 'oha-theme'),
        'description'           => __('OHA sponsors and partners', 'oha-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail', 'page-attributes'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 22,
        'menu_icon'             => 'dashicons-awards',
        'show_in_admin_bar'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('sponsor', $args);
}
add_action('init', 'oha_register_sponsor_post_type', 0);

/**
 * Register Event Post Type
 */
function oha_register_event_post_type() {
    $labels = array(
        'name'                  => _x('Events', 'Post Type General Name', 'oha-theme'),
        'singular_name'         => _x('Event', 'Post Type Singular Name', 'oha-theme'),
        'menu_name'             => __('Events', 'oha-theme'),
        'add_new_item'          => __('Add New Event', 'oha-theme'),
        'edit_item'             => __('Edit Event', 'oha-theme'),
    );

    $args = array(
        'label'                 => __('Event', 'oha-theme'),
        'description'           => __('Hockey events and tournaments', 'oha-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 23,
        'menu_icon'             => 'dashicons-calendar-alt',
        'show_in_admin_bar'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('event', $args);
}
add_action('init', 'oha_register_event_post_type', 0);

/**
 * Register Slide Post Type for Homepage Slider
 */
function oha_register_slide_post_type() {
    $labels = array(
        'name'                  => _x('Slides', 'Post Type General Name', 'oha-theme'),
        'singular_name'         => _x('Slide', 'Post Type Singular Name', 'oha-theme'),
        'menu_name'             => __('Homepage Slides', 'oha-theme'),
        'add_new_item'          => __('Add New Slide', 'oha-theme'),
        'edit_item'             => __('Edit Slide', 'oha-theme'),
    );

    $args = array(
        'label'                 => __('Slide', 'oha-theme'),
        'description'           => __('Homepage slider content', 'oha-theme'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'page-attributes'),
        'hierarchical'          => false,
        'public'                => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 24,
        'menu_icon'             => 'dashicons-images-alt2',
        'show_in_admin_bar'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('slide', $args);
}
add_action('init', 'oha_register_slide_post_type', 0);
?>
```

## Phase 5: Implementation Timeline

### Week 1: Foundation Setup
- [ ] Download and configure Underscores theme
- [ ] Update theme information and basic setup
- [ ] Implement OHA color palette and typography
- [ ] Create basic header structure
- [ ] Set up file organization

### Week 2: Core Components
- [ ] Complete header implementation with two-tier layout
- [ ] Create footer with OHA branding
- [ ] Implement navigation styling
- [ ] Set up custom post types
- [ ] Create basic page templates

### Week 3: Custom Sections
- [ ] Build hero slider section
- [ ] Create latest news section
- [ ] Implement video gallery
- [ ] Build team carousel
- [ ] Create sponsors section

### Week 4: Advanced Features
- [ ] Add WordPress Customizer options
- [ ] Implement responsive design
- [ ] Add animations and interactions
- [ ] Performance optimization
- [ ] Testing and debugging

### Week 5: Final Polish
- [ ] Content migration from old theme
- [ ] Client training and documentation
- [ ] Final testing across devices/browsers
- [ ] Performance optimization
- [ ] Go-live preparation

## Required Tools and Plugins

### Essential Plugins
1. **Advanced Custom Fields (ACF) Pro** - For custom fields and flexible content
2. **Yoast SEO** - SEO optimization
3. **Wordfence Security** - Security protection
4. **WP Rocket** - Caching and performance (optional)

### Development Tools
1. **Local WordPress environment** (XAMPP, Local by Flywheel, etc.)
2. **Code editor** with WordPress/PHP support
3. **Browser developer tools** for testing
4. **Image optimization tools** for web-ready assets

### Assets Needed
1. **PF Din Text Universal font files** (.woff2, .woff formats)
2. **OHA logo files** (SVG, PNG formats)
3. **Sample content** for testing (images, text, videos)
4. **Social media icons** (Font Awesome or custom SVGs)

## Success Metrics

### Performance Goals
- Page load time under 3 seconds
- Google PageSpeed score above 90
- Mobile-friendly test passing
- Zero accessibility errors

### Functionality Goals
- All custom sections working perfectly
- Responsive design on all devices
- Easy content management for client
- SEO-optimized structure

### Brand Compliance Goals
- Exact OHA color implementation
- Proper typography hierarchy
- Professional, polished appearance
- Consistent brand experience

## Maintenance and Support Plan

### Monthly Tasks
- WordPress core and plugin updates
- Security monitoring
- Performance optimization
- Content backup verification

### Quarterly Tasks
- Full website audit
- Performance analysis
- Security scan
- Content strategy review

### Annual Tasks
- Complete website review
- Technology updates
- Design refresh evaluation
- Strategic planning

This comprehensive guide ensures we build a professional, performant, and perfectly branded WordPress theme for the Oman Hockey Association using modern best practices and clean, maintainable code. 