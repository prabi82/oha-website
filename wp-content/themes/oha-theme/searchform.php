<?php
/**
 * Custom search form template
 *
 * @package OHA_Theme
 */
?>

<form role="search" method="get" class="oha-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-form-wrapper">
		<label for="search-field-<?php echo uniqid(); ?>" class="screen-reader-text">
			<?php esc_html_e( 'Search for:', 'oha-theme' ); ?>
		</label>
		<input type="search" 
			   id="search-field-<?php echo uniqid(); ?>" 
			   class="search-field" 
			   placeholder="<?php echo esc_attr__( 'Search OHA website...', 'oha-theme' ); ?>" 
			   value="<?php echo get_search_query(); ?>" 
			   name="s" 
			   required />
		
		<button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'Search', 'oha-theme' ); ?>">
			<i class="fas fa-search" aria-hidden="true"></i>
			<span class="search-submit-text"><?php esc_html_e( 'Search', 'oha-theme' ); ?></span>
		</button>
	</div>
	
	<!-- Advanced Search Options -->
	<div class="search-filters" style="display: none;">
		<div class="search-filter-group">
			<label for="search-post-type"><?php esc_html_e( 'Search in:', 'oha-theme' ); ?></label>
			<select name="post_type" id="search-post-type" class="search-filter-select">
				<option value=""><?php esc_html_e( 'All Content', 'oha-theme' ); ?></option>
				<option value="post" <?php selected( get_query_var( 'post_type' ), 'post' ); ?>><?php esc_html_e( 'News Articles', 'oha-theme' ); ?></option>
				<option value="page" <?php selected( get_query_var( 'post_type' ), 'page' ); ?>><?php esc_html_e( 'Pages', 'oha-theme' ); ?></option>
				<option value="oha_video" <?php selected( get_query_var( 'post_type' ), 'oha_video' ); ?>><?php esc_html_e( 'Videos', 'oha-theme' ); ?></option>
				<option value="team_member" <?php selected( get_query_var( 'post_type' ), 'team_member' ); ?>><?php esc_html_e( 'Team Members', 'oha-theme' ); ?></option>
				<option value="event" <?php selected( get_query_var( 'post_type' ), 'event' ); ?>><?php esc_html_e( 'Events', 'oha-theme' ); ?></option>
			</select>
		</div>
	</div>
	
	<button type="button" class="search-advanced-toggle" onclick="ohaToggleAdvancedSearch(this)">
		<i class="fas fa-cog" aria-hidden="true"></i>
		<span class="advanced-text"><?php esc_html_e( 'Advanced Search', 'oha-theme' ); ?></span>
	</button>
</form>

<style>
/* Search Form Styles */
.oha-search-form {
	position: relative;
	margin-bottom: var(--oha-spacing-md);
}

.search-form-wrapper {
	display: flex;
	background: var(--oha-white);
	border: 2px solid var(--oha-light-gray);
	border-radius: 8px;
	overflow: hidden;
	transition: var(--oha-transition);
}

.search-form-wrapper:focus-within {
	border-color: var(--oha-primary-green);
	box-shadow: 0 0 0 3px rgba(88, 170, 53, 0.1);
}

.search-field {
	flex: 1;
	padding: 15px 20px;
	border: none;
	font-size: 1rem;
	font-family: var(--oha-font-family);
	background: transparent;
	color: var(--oha-dark-gray);
}

.search-field:focus {
	outline: none;
}

.search-field::placeholder {
	color: var(--oha-dark-gray);
	opacity: 0.7;
}

.search-submit {
	padding: 15px 25px;
	background: var(--oha-primary-green);
	color: var(--oha-white);
	border: none;
	cursor: pointer;
	transition: var(--oha-transition);
	display: flex;
	align-items: center;
	gap: 8px;
	font-weight: var(--oha-font-medium);
}

.search-submit:hover,
.search-submit:focus {
	background: var(--oha-primary-red);
	outline: none;
}

.search-submit-text {
	display: none;
}

.search-advanced-toggle {
	position: absolute;
	top: 100%;
	right: 0;
	margin-top: 8px;
	background: none;
	border: none;
	color: var(--oha-primary-green);
	font-size: 0.9rem;
	cursor: pointer;
	display: flex;
	align-items: center;
	gap: 5px;
	transition: var(--oha-transition);
}

.search-advanced-toggle:hover {
	color: var(--oha-primary-red);
}

.search-filters {
	margin-top: var(--oha-spacing-md);
	padding: var(--oha-spacing-md);
	background: #f8f9fa;
	border-radius: 6px;
	border: 1px solid var(--oha-light-gray);
}

.search-filter-group {
	display: flex;
	flex-direction: column;
	gap: 8px;
}

.search-filter-group label {
	font-weight: var(--oha-font-medium);
	color: var(--oha-dark-gray);
	font-size: 0.9rem;
}

.search-filter-select {
	padding: 8px 12px;
	border: 1px solid var(--oha-light-gray);
	border-radius: 4px;
	background: var(--oha-white);
	font-family: var(--oha-font-family);
	color: var(--oha-dark-gray);
}

.search-filter-select:focus {
	outline: none;
	border-color: var(--oha-primary-green);
}

/* Mobile Responsive */
@media (min-width: 768px) {
	.search-submit-text {
		display: inline;
	}
	
	.search-filters {
		display: grid;
		grid-template-columns: 1fr;
		gap: var(--oha-spacing-md);
	}
	
	.search-filter-group {
		flex-direction: row;
		align-items: center;
		gap: 15px;
	}
	
	.search-filter-group label {
		min-width: 100px;
		margin-bottom: 0;
	}
}

/* Header Search Form (smaller version) */
.header-search-form .search-form-wrapper {
	min-width: 300px;
}

.header-search-form .search-field {
	padding: 10px 15px;
	font-size: 0.9rem;
}

.header-search-form .search-submit {
	padding: 10px 15px;
}

.header-search-form .search-advanced-toggle {
	display: none;
}
</style>

<script>
function ohaToggleAdvancedSearch(button) {
	const filters = button.parentElement.querySelector('.search-filters');
	const isVisible = filters.style.display !== 'none';
	
	if (isVisible) {
		filters.style.display = 'none';
		button.innerHTML = '<i class="fas fa-cog" aria-hidden="true"></i><span class="advanced-text"><?php esc_html_e( 'Advanced Search', 'oha-theme' ); ?></span>';
	} else {
		filters.style.display = 'block';
		button.innerHTML = '<i class="fas fa-times" aria-hidden="true"></i><span class="advanced-text"><?php esc_html_e( 'Hide Advanced', 'oha-theme' ); ?></span>';
	}
}
</script> 