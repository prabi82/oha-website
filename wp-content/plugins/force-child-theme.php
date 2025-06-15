<?php
/**
 * Plugin Name: Force Child Theme Registration
 * Description: Forces WordPress to recognize the BeTheme Child theme
 * Version: 1.0
 * Author: Support
 */

// Add theme to the theme list
add_filter('wp_prepare_themes_for_js', 'force_add_child_theme');

function force_add_child_theme($themes) {
    $theme_root = get_theme_root();
    $child_theme_dir = $theme_root . '/betheme-child';
    
    if (file_exists($child_theme_dir . '/style.css')) {
        // Add our child theme to the list
        $theme_data = wp_get_theme('betheme-child');
        $themes['betheme-child'] = array(
            'id' => 'betheme-child',
            'name' => $theme_data->get('Name'),
            'screenshot' => array($theme_data->get_screenshot()),
            'description' => $theme_data->get('Description'),
            'author' => $theme_data->get('Author'),
            'authorAndUri' => $theme_data->display('Author', true, true),
            'version' => $theme_data->get('Version'),
            'tags' => $theme_data->get('Tags'),
            'parent' => $theme_data->get('Template'),
            'active' => false,
            'hasUpdate' => false,
            'hasPackage' => false,
            'update' => false,
            'actions' => array(
                'activate' => wp_nonce_url(admin_url('themes.php?action=activate&amp;stylesheet=betheme-child'), 'switch-theme_betheme-child'),
                'customize' => admin_url('customize.php?theme=betheme-child'),
            ),
        );
    }
    
    return $themes;
} 