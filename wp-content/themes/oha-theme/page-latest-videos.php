<?php
/**
 * Template Name: Latest Videos (Modern)
 * Description: Displays video posts (oha_video) in a modern grid layout similar to the homepage Latest Videos section.
 *
 * Adjustable via ACF fields (if available):
 *  – lv_posts_per_page (int)
 *  – lv_featured_count (int)
 *  – lv_order  (asc|desc)
 *  – lv_categories (taxonomy video_category multi-select)
 *
 * @package OHA_Theme
 */

get_header();

// Parameters with fallbacks
$posts_per_page = function_exists('get_field') && get_field('lv_posts_per_page') ? (int) get_field('lv_posts_per_page') : 9;
$featured_count = function_exists('get_field') && get_field('lv_featured_count') ? (int) get_field('lv_featured_count') : 1;
$order          = function_exists('get_field') && get_field('lv_order') === 'asc' ? 'ASC' : 'DESC';
$categories     = function_exists('get_field') ? get_field('lv_categories') : array();

$paged = max(1, get_query_var('paged'));

$args = array(
    'post_type'      => 'oha_video',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'orderby'        => 'date',
    'order'          => $order,
    'paged'          => $paged,
    'ignore_sticky_posts' => true,
);

if ( ! empty($categories) ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'video_category',
            'field'    => 'term_id',
            'terms'    => wp_list_pluck($categories, 'term_id'),
        ),
    );
}

$videos_query = new WP_Query($args);
?>

<main id="primary" class="site-main oha-videos-page">
    <div class="oha-container">
        <header class="page-header">
            <?php the_title('<h1 class="page-title">', '</h1>'); ?>
        </header>

        <?php if ( $videos_query->have_posts() ) : ?>
            <div class="videos-page-layout">
                <?php 
                $all_videos = array();
                $count = 0;
                
                // Collect all videos first
                while ( $videos_query->have_posts() ) : $videos_query->the_post(); $count++;
                    // video meta
                    $video_url = get_post_meta(get_the_ID(), '_oha_video_url', true);
                    $video_duration = get_post_meta(get_the_ID(), '_oha_video_duration', true);
                    // infer type & id
                    $video_type = 'youtube';
                    $video_id = '';
                    if ($video_url) {
                        if (strpos($video_url,'vimeo.com')!==false) {
                            preg_match('/vimeo\.com\/(\d+)/', $video_url, $m);
                            $video_id = $m[1] ?? '';
                            $video_type = 'vimeo';
                        } else {
                            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $m);
                            $video_id = $m[1] ?? '';
                        }
                    }
                    
                    $all_videos[] = array(
                        'post' => get_post(),
                        'video_id' => $video_id,
                        'video_type' => $video_type,
                        'video_duration' => $video_duration,
                        'count' => $count
                    );
                endwhile;
                
                // Display featured video (first one)
                if (!empty($all_videos)) {
                    $featured_video = $all_videos[0];
                    $post = $featured_video['post'];
                    setup_postdata($post);
                ?>
                    <article class="video-page-card video-page-card-featured" data-video-id="<?php echo esc_attr($featured_video['video_id']); ?>" data-video-type="<?php echo esc_attr($featured_video['video_type']); ?>">
                        <div class="video-thumbnail">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('large', ['loading'=>'lazy']); ?>
                            <?php elseif ( $featured_video['video_id'] && $featured_video['video_type']==='youtube' ) : ?>
                                <img src="https://img.youtube.com/vi/<?php echo esc_attr($featured_video['video_id']); ?>/maxresdefault.jpg" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                            <?php else : ?>
                                <div class="video-placeholder"><span class="video-placeholder-icon">V</span></div>
                            <?php endif; ?>
                            
                            <!-- Video Type Badge -->
                            <div class="video-type-badge"><?php echo esc_html(strtoupper($featured_video['video_type'])); ?></div>
                            
                            <!-- Video Publish Date Badge -->
                            <div class="video-publish-date-badge">
                                <span class="date-icon">📅</span>
                                <?php echo esc_html(get_the_date('M j, Y')); ?>
                            </div>
                            
                            <div class="video-play-button" role="button" tabindex="0" aria-label="<?php echo esc_attr(sprintf(__('Play video: %s','oha-theme'), get_the_title())); ?>"><span class="play-icon">▶</span></div>
                            <?php if ($featured_video['video_duration']): ?><div class="video-duration"><?php echo esc_html($featured_video['video_duration']); ?></div><?php endif; ?>
                        </div>
                        <div class="video-card-content">
                            <h3 class="video-card-title"><a href="<?php the_permalink(); ?>" class="video-title-link"><?php the_title(); ?></a></h3>
                        </div>
                    </article>
                <?php
                }
                
                // Display remaining videos in grid
                if (count($all_videos) > 1) {
                    $regular_videos = array_slice($all_videos, 1);
                ?>
                    <div class="videos-page-grid">
                        <?php foreach ($regular_videos as $video_data) {
                            $post = $video_data['post'];
                            setup_postdata($post);
                        ?>
                            <article class="video-page-card" data-video-id="<?php echo esc_attr($video_data['video_id']); ?>" data-video-type="<?php echo esc_attr($video_data['video_type']); ?>">
                                <div class="video-thumbnail">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail('medium', ['loading'=>'lazy']); ?>
                                    <?php elseif ( $video_data['video_id'] && $video_data['video_type']==='youtube' ) : ?>
                                        <img src="https://img.youtube.com/vi/<?php echo esc_attr($video_data['video_id']); ?>/maxresdefault.jpg" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                    <?php else : ?>
                                        <div class="video-placeholder"><span class="video-placeholder-icon">V</span></div>
                                    <?php endif; ?>
                                    
                                    <!-- Video Type Badge -->
                                    <div class="video-type-badge"><?php echo esc_html(strtoupper($video_data['video_type'])); ?></div>
                                    
                                    <!-- Video Publish Date Badge -->
                                    <div class="video-publish-date-badge">
                                        <span class="date-icon">📅</span>
                                        <?php echo esc_html(get_the_date('M j, Y')); ?>
                                    </div>
                                    
                                    <div class="video-play-button" role="button" tabindex="0" aria-label="<?php echo esc_attr(sprintf(__('Play video: %s','oha-theme'), get_the_title())); ?>"><span class="play-icon">▶</span></div>
                                    <?php if ($video_data['video_duration']): ?><div class="video-duration"><?php echo esc_html($video_data['video_duration']); ?></div><?php endif; ?>
                                </div>
                                <div class="video-card-content">
                                    <h3 class="video-card-title"><a href="<?php the_permalink(); ?>" class="video-title-link"><?php the_title(); ?></a></h3>
                                </div>
                            </article>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>

            <?php the_posts_pagination(['total'=>$videos_query->max_num_pages,'mid_size'=>2]); ?>
        <?php else :
            get_template_part('template-parts/content','none');
        endif; ?>
    </div>
</main>

<?php wp_reset_postdata(); get_footer(); 