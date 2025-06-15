<?php
/**
 * Template Name: Latest News (Modern)
 * Description: Displays blog posts in a modern, responsive card grid with optional featured cards.
 *
 * The design re-uses the existing "news-card" styles that power the home-page "Latest News" section so it
 * fits perfectly into the global theme branding.
 *
 * Adjustable parameters (via ACF field group with the same field names):
 *  – ln_posts_per_page   (number)  Total posts per page (default 9)
 *  – ln_featured_count   (number)  How many posts at the top should use the larger "featured" style (default 2)
 *  – ln_categories       (taxonomy multi-select)  Limit posts to selected categories (optional)
 *  – ln_order            (select asc|desc)  Date ordering (default desc)
 *
 * If the ACF plugin or the specific fields are not present the template falls back to sensible defaults.
 *
 * @package OHA_Theme
 */

get_header();

// -----------------------------------------------------------------------------
// Read adjustable parameters (safe defaults if the fields are missing)
// -----------------------------------------------------------------------------
$posts_per_page = function_exists( 'get_field' ) && get_field( 'ln_posts_per_page' ) ? (int) get_field( 'ln_posts_per_page' ) : 9;
$featured_count = function_exists( 'get_field' ) && get_field( 'ln_featured_count' ) ? (int) get_field( 'ln_featured_count' ) : 2;
$order          = function_exists( 'get_field' ) && get_field( 'ln_order' ) === 'asc' ? 'ASC' : 'DESC';
$categories     = function_exists( 'get_field' ) ? get_field( 'ln_categories' ) : array();

// Current paged value for pagination support.
$paged = max( 1, get_query_var( 'paged' ) );

// Build WP_Query arguments.
$args = array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => $posts_per_page,
    'orderby'             => 'date',
    'order'               => $order,
    'paged'               => $paged,
    'ignore_sticky_posts' => true,
);

if ( ! empty( $categories ) ) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => wp_list_pluck( $categories, 'term_id' ),
        ),
    );
}

$news_query = new WP_Query( $args );
?>

<main id="primary" class="site-main oha-news-page">
    <div class="oha-container">

        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <?php the_title( '<h1 class="page-title">', '</h1>' ); ?>
            </header>
        <?php endif; ?>

        <?php if ( $news_query->have_posts() ) : ?>

            <div class="news-grid-container">

                <?php
                // -----------------------------------------------------------------
                // Featured cards (bigger variant)
                // -----------------------------------------------------------------
                if ( $featured_count > 0 ) :
                    echo '<div class="news-grid-featured">';
                    $featured_rendered = 0;
                    while ( $news_query->have_posts() && $featured_rendered < $featured_count ) :
                        $news_query->the_post();
                        $featured_rendered++;
                        ?>
                        <article class="news-card news-card-featured">
                            <a href="<?php the_permalink(); ?>" class="news-card-link" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'oha-theme' ), get_the_title() ) ); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="news-card-image" style="background-image:url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');">
                                <?php else : ?>
                                    <div class="news-card-image news-card-no-image">
                                <?php endif; ?>
                                        <div class="news-card-overlay"></div>
                                        <div class="news-card-icon"><span class="news-icon-text">N</span></div>
                                        <div class="news-card-content">
                                            <div class="news-card-date"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd M, Y' ) ); ?></time></div>
                                            <h3 class="news-card-title"><?php the_title(); ?></h3>
                                        </div>
                                    </div>
                            </a>
                        </article>
                        <?php
                    endwhile;
                    echo '</div>'; // .news-grid-featured
                endif;
                ?>

                <div class="news-grid-regular">
                    <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
                        <article class="news-card news-card-regular">
                            <a href="<?php the_permalink(); ?>" class="news-card-link" aria-label="<?php echo esc_attr( sprintf( __( 'Read more about %s', 'oha-theme' ), get_the_title() ) ); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="news-card-image" style="background-image:url('<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) ); ?>');">
                                <?php else : ?>
                                    <div class="news-card-image news-card-no-image">
                                <?php endif; ?>
                                        <div class="news-card-overlay"></div>
                                        <div class="news-card-icon"><span class="news-icon-text">N</span></div>
                                        <div class="news-card-content">
                                            <div class="news-card-date"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'd M, Y' ) ); ?></time></div>
                                            <h3 class="news-card-title"><?php the_title(); ?></h3>
                                        </div>
                                    </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div><!-- .news-grid-regular -->

            </div><!-- .news-grid-container -->

            <?php
            // ------------------------------- Pagination -------------------------
            the_posts_pagination( array(
                'total'   => $news_query->max_num_pages,
                'mid_size' => 2,
            ) );
            ?>

        <?php else :
            get_template_part( 'template-parts/content', 'none' );
        endif; ?>

    </div><!-- .oha-container -->
</main>

<?php
wp_reset_postdata();
get_footer(); 