<?php
/**
 * ACF fields for Latest Events (Modern) page template.
 */
if ( function_exists('acf_add_local_field_group') ) {
    acf_add_local_field_group(array(
        'key'    => 'group_latest_events_page',
        'title'  => 'Latest Events Page Settings',
        'fields' => array(
            array(
                'key'   => 'field_le_posts_per_page',
                'label' => 'Events per page',
                'name'  => 'le_posts_per_page',
                'type'  => 'number',
                'default_value' => 12,
                'min'   => 1,
                'step'  => 1,
                'instructions' => 'How many events to show per page',
            ),
            array(
                'key'   => 'field_le_featured_count',
                'label' => 'Number of featured events',
                'name'  => 'le_featured_count',
                'type'  => 'number',
                'default_value' => 2,
                'min'   => 0,
                'max'   => 6,
                'step'  => 1,
                'instructions' => 'Number of events to display as featured (larger cards)',
            ),
            array(
                'key'   => 'field_le_order',
                'label' => 'Event order',
                'name'  => 'le_order',
                'type'  => 'select',
                'choices' => array(
                    'desc' => 'Newest First',
                    'asc'  => 'Oldest First',
                ),
                'default_value' => 'desc',
                'instructions' => 'Order events by date',
            ),
            array(
                'key'   => 'field_le_event_status',
                'label' => 'Filter by status',
                'name'  => 'le_event_status',
                'type'  => 'select',
                'choices' => array(
                    'all'       => 'All Events',
                    'upcoming'  => 'Upcoming Only',
                    'ongoing'   => 'Ongoing Only',
                    'completed' => 'Completed Only',
                ),
                'default_value' => 'all',
                'instructions' => 'Filter events by their status',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-latest-events.php',
                ),
            ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen'        => '',
        'active'                => true,
        'description'           => '',
    ));
} 