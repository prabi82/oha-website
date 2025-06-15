<?php
/**
 * Register ACF fields for the Latest News (Modern) page template.
 * Requires Advanced Custom Fields PRO / free plugin to be active.
 */

if ( function_exists( 'acf_add_local_field_group' ) ) {

    acf_add_local_field_group( array(
        'key'                   => 'group_latest_news_page',
        'title'                 => 'Latest News Page Settings',
        'fields'                => array(
            array(
                'key'   => 'field_ln_posts_per_page',
                'label' => 'Posts per page',
                'name'  => 'ln_posts_per_page',
                'type'  => 'number',
                'default_value' => 9,
                'min'   => 1,
                'step'  => 1,
            ),
            array(
                'key'   => 'field_ln_featured_count',
                'label' => 'Number of featured cards',
                'name'  => 'ln_featured_count',
                'type'  => 'number',
                'default_value' => 2,
                'min'   => 0,
                'step'  => 1,
            ),
            array(
                'key'   => 'field_ln_order',
                'label' => 'Order',
                'name'  => 'ln_order',
                'type'  => 'select',
                'choices' => array(
                    'desc' => 'Newest to oldest',
                    'asc'  => 'Oldest to newest',
                ),
                'default_value' => 'desc',
                'return_format' => 'value',
            ),
            array(
                'key'   => 'field_ln_categories',
                'label' => 'Categories',
                'name'  => 'ln_categories',
                'type'  => 'taxonomy',
                'taxonomy' => 'category',
                'field_type' => 'multi_select',
                'add_term'   => 0,
                'return_format' => 'object',
            ),
        ),
        'location'              => array(
            array(
                array(
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-latest-news.php',
                ),
            ),
        ),
        'style'                 => 'seamless',
        'menu_order'            => 0,
    ) );
} 