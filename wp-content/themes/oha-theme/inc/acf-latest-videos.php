<?php
/**
 * ACF fields for Latest Videos (Modern) page template.
 */
if ( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key'    => 'group_latest_videos_page',
        'title'  => 'Latest Videos Page Settings',
        'fields' => array(
            array(
                'key'   => 'field_lv_posts_per_page',
                'label' => 'Videos per page',
                'name'  => 'lv_posts_per_page',
                'type'  => 'number',
                'default_value' => 6,
                'min'   => 1,
                'step'  => 1,
            ),
            array(
                'key'   => 'field_lv_featured_count',
                'label' => 'Number of featured videos',
                'name'  => 'lv_featured_count',
                'type'  => 'number',
                'default_value' => 1,
                'min'   => 0,
                'step'  => 1,
            ),
            array(
                'key'   => 'field_lv_order',
                'label' => 'Order',
                'name'  => 'lv_order',
                'type'  => 'select',
                'choices' => array('desc'=>'Newest to oldest','asc'=>'Oldest to newest'),
                'default_value' => 'desc',
                'return_format' => 'value',
            ),
            array(
                'key'   => 'field_lv_categories',
                'label' => 'Video Categories',
                'name'  => 'lv_categories',
                'type'  => 'taxonomy',
                'taxonomy' => 'video_category',
                'field_type' => 'multi_select',
                'add_term' => 0,
                'return_format' => 'object',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-latest-videos.php',
                ),
            ),
        ),
        'style' => 'seamless',
    ));
} 