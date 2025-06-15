<?php
/**
 * The template for displaying the front page
 *
 * This is the homepage template for the OHA website.
 * It displays the hero slider, upcoming events, latest news, videos, and partners.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OHA_Theme
 */

get_header();
?>

<main id="primary" class="site-main oha-homepage">

	<?php
	// Hero Slider Section
	get_template_part( 'template-parts/section', 'hero-slider' );
	
	// Upcoming Events Section (overlapping the hero banner)
	get_template_part( 'template-parts/section', 'upcoming-events' );
	
	// Latest News Section
	get_template_part( 'template-parts/section', 'latest-news' );
	
	// Latest Videos Section
	get_template_part( 'template-parts/section', 'latest-videos' );
	
	// Partners Section
	get_template_part( 'template-parts/section', 'sponsors' );
	
	// Display homepage content if set
	while ( have_posts() ) :
		the_post();
		
		if ( get_the_content() ) :
			?>
			<section class="oha-section oha-homepage-content">
				<div class="oha-container">
					<div class="homepage-content-wrapper">
						<?php
						the_content();
						
						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'oha-theme' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>
				</div>
			</section>
			<?php
		endif;
		
	endwhile; // End of the loop.
	?>

</main><!-- #main -->

<?php
get_footer(); 