<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package OHA_Theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'oha-theme' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		
		<!-- Top Header Section -->
		<div class="header-top-section">
			<div class="oha-container">
				<div class="header-top-container">
					
					<!-- Logo and Official Title -->
					<div class="header-logo-section">
						<div class="site-branding">
							<?php
							// Custom Logo
							if ( has_custom_logo() ) {
								the_custom_logo();
							} else {
								// Fallback to site title if no logo
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
											<?php bloginfo( 'name' ); ?>
										</a>
									</h1>
									<?php
								else :
									?>
									<p class="site-title">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
											<?php bloginfo( 'name' ); ?>
										</a>
									</p>
									<?php
								endif;
							}
							?>
						</div><!-- .site-branding -->
					</div>
					
					<!-- Official Title - Centered -->
					<div class="official-title">
						<h2><?php echo esc_html( get_theme_mod( 'oha_official_title', __( 'Official Website Of Hockey Oman', 'oha-theme' ) ) ); ?></h2>
					</div>
					
					<!-- Partner Logos -->
					<div class="header-partners">
						<?php
						// Get partner logos from customizer
						$partner_logos = oha_get_partner_logos();
						
						if ( empty( $partner_logos ) ) {
							// Default partners for demonstration (matching reference image)
							$default_partners = array(
								array(
									'name' => 'Oman Olympic Committee',
									'logo' => '',
									'url' => '#',
								),
								array(
									'name' => 'BADR AL SAMAA',
									'logo' => '',
									'url' => '#',
								),
								array(
									'name' => 'JINDAL STEEL',
									'logo' => '',
									'url' => '#',
								),
							);
							$partner_logos = $default_partners;
						}
						
						if ( ! empty( $partner_logos ) ) :
						?>
							<div class="partner-logos">
								<?php foreach ( $partner_logos as $partner ) : ?>
									<div class="partner-logo">
										<?php if ( ! empty( $partner['url'] ) ) : ?>
											<a href="<?php echo esc_url( $partner['url'] ); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr( $partner['name'] ); ?>">
										<?php endif; ?>
										
										<?php if ( ! empty( $partner['logo'] ) ) : ?>
											<img src="<?php echo esc_url( $partner['logo'] ); ?>" alt="<?php echo esc_attr( $partner['name'] ); ?>">
										<?php else : ?>
											<div class="partner-placeholder">
												<span><?php echo esc_html( $partner['name'] ); ?></span>
											</div>
										<?php endif; ?>
										
										<?php if ( ! empty( $partner['url'] ) ) : ?>
											</a>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div><!-- .header-partners -->
					
				</div><!-- .header-top-container -->
			</div><!-- .oha-container -->
		</div><!-- .header-top-section -->
		
		<!-- Navigation Section -->
		<div class="header-nav-section">
			<div class="oha-container">
				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'oha-theme' ); ?>">
					
					<!-- Mobile Menu Toggle -->
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'oha-theme' ); ?>">
						<span class="menu-toggle-icon">
							<span></span>
							<span></span>
							<span></span>
						</span>
						<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'oha-theme' ); ?></span>
					</button>
					
					<!-- Primary Navigation Menu -->
					<?php
					if ( has_nav_menu( 'primary' ) ) {
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'primary-menu',
								'container'      => false,
								'fallback_cb'    => 'oha_primary_menu_fallback',
								'depth'          => 3,
							)
						);
					} else {
						// Fallback menu if no menu is assigned
						oha_primary_menu_fallback();
					}
					?>
					
				</nav><!-- #site-navigation -->
			</div><!-- .oha-container -->
		</div><!-- .header-nav-section -->
		
	</header><!-- #masthead -->

	<!-- Page Content Wrapper -->
	<div id="content" class="site-content">

<?php
/**
 * Fallback function for primary menu
 */
function oha_primary_menu_fallback() {
	?>
	<ul id="primary-menu" class="primary-menu">
		<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'oha-theme' ); ?></a></li>
		<li class="menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'About OHA', 'oha-theme' ); ?></a>
			<ul class="sub-menu">
				<li><a href="<?php echo esc_url( home_url( '/about/history' ) ); ?>"><?php esc_html_e( 'History', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/about/governance' ) ); ?>"><?php esc_html_e( 'Governance', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/about/vision-mission' ) ); ?>"><?php esc_html_e( 'Vision & Mission', 'oha-theme' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/teams' ) ); ?>"><?php esc_html_e( 'National Team', 'oha-theme' ); ?></a>
			<ul class="sub-menu">
				<li><a href="<?php echo esc_url( home_url( '/teams/men' ) ); ?>"><?php esc_html_e( 'Men\'s Team', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/teams/women' ) ); ?>"><?php esc_html_e( 'Women\'s Team', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/teams/youth' ) ); ?>"><?php esc_html_e( 'Youth Teams', 'oha-theme' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/news' ) ); ?>"><?php esc_html_e( 'Media', 'oha-theme' ); ?></a>
			<ul class="sub-menu">
				<li><a href="<?php echo esc_url( home_url( '/news' ) ); ?>"><?php esc_html_e( 'News', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/videos' ) ); ?>"><?php esc_html_e( 'Videos', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>"><?php esc_html_e( 'Photo Gallery', 'oha-theme' ); ?></a></li>
			</ul>
		</li>
		<li class="menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/development' ) ); ?>"><?php esc_html_e( 'Coaching & Technical', 'oha-theme' ); ?></a>
			<ul class="sub-menu">
				<li><a href="<?php echo esc_url( home_url( '/development/coaching' ) ); ?>"><?php esc_html_e( 'Coaching Programs', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/development/referee' ) ); ?>"><?php esc_html_e( 'Referee Development', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/development/youth' ) ); ?>"><?php esc_html_e( 'Youth Development', 'oha-theme' ); ?></a></li>
			</ul>
		</li>
		<li><a href="<?php echo esc_url( home_url( '/schedule' ) ); ?>"><?php esc_html_e( 'Schedule', 'oha-theme' ); ?></a></li>
		<li><a href="<?php echo esc_url( home_url( '/events' ) ); ?>"><?php esc_html_e( 'Events', 'oha-theme' ); ?></a></li>
		<li class="menu-item-has-children">
			<a href="<?php echo esc_url( home_url( '/information' ) ); ?>"><?php esc_html_e( 'Important Information', 'oha-theme' ); ?></a>
			<ul class="sub-menu">
				<li><a href="<?php echo esc_url( home_url( '/information/rules' ) ); ?>"><?php esc_html_e( 'Rules & Regulations', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/information/calendar' ) ); ?>"><?php esc_html_e( 'Calendar', 'oha-theme' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/information/documents' ) ); ?>"><?php esc_html_e( 'Documents', 'oha-theme' ); ?></a></li>
			</ul>
		</li>
		<li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'oha-theme' ); ?></a></li>
	</ul>
	<?php
}
