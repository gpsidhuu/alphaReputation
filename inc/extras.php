<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Rhythm
 */

/**
 * Track search-faq variable from faq template
 * @param array $vars
 * @return string
 */
function ts_add_faq_query_vars($vars) {
	$vars[] = 'search-faq';
	return $vars;
}
add_filter('query_vars', 'ts_add_faq_query_vars');

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function rhythm_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	$classes[] = 'appear-animate';
	
	if (get_post_meta( get_the_ID(), '_wp_page_template', true ) == 'page-templates/shop.php') {
		$classes[] = 'woocommerce';
		$classes[] = 'woocommerce-page';
	}
	
	return $classes;
}
add_filter( 'body_class', 'rhythm_body_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function rhythm_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'rhythm' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'rhythm_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function rhythm_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'rhythm_render_title' );
endif;

if ( !function_exists('rhythm_favicon')):
	
	/**
	 * Adds favicon support
	 */
	function rhythm_favicon() {
	
		$favicon_16 = ts_get_opt('favicon-16');
		if( is_array($favicon_16) && $favicon_16['url'] != '' ) : ?>
			<link rel="icon" type="image/png" href="<?php echo esc_url($favicon_16['url']); ?>" sizes="16x16">
		<?php endif; ?>
		<?php 
		$favicon_32 = ts_get_opt('favicon-32');
		if( is_array($favicon_32) && $favicon_32['url'] != '' ) : ?>
			<link rel="icon" type="image/png" href="<?php echo esc_url($favicon_32['url']); ?>" sizes="32x32">
		<?php endif; ?>
		<?php 
		$favicon_96 = ts_get_opt('favicon-96'); 
		if( is_array($favicon_96) && $favicon_96['url'] != '' ) : ?>
			<link rel="icon" type="image/png" href="<?php echo esc_url($favicon_96['url']); ?>" sizes="96x96">
		<?php endif; ?>
		<?php 
		$favicon_160 = ts_get_opt('favicon-160');
		if( is_array($favicon_160) && $favicon_160['url'] != '' ) : ?>
			<link rel="icon" type="image/png" href="<?php echo esc_url($favicon_160['url']); ?>" sizes="160x160">
		<?php endif; ?>
		<?php 
		$favicon_192 = ts_get_opt('favicon-192');
		if( is_array($favicon_192) && $favicon_192['url'] != '' ) : ?>
			<link rel="icon" type="image/png" href="<?php echo esc_url($favicon_192['url']); ?>" sizes="192x192">
		<?php endif; ?>
		<?php 
		$favicon_a_57 = ts_get_opt('favicon-a-57');
		if( is_array($favicon_a_57) && $favicon_a_57['url'] != '' ) : ?>
			<link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_url($favicon_a_57['url']); ?>">
		<?php endif; ?>
		<?php 
		$favicon_a_114 = ts_get_opt('favicon-a-114');
		if( is_array($favicon_a_114) && $favicon_a_114['url'] != '' ) : ?>
			<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url($favicon_a_114['url']); ?>">
		<?php endif; ?>
		<?php 
		$favicon_a_72 = ts_get_opt('favicon-a-72');
		if( is_array($favicon_a_72) && $favicon_a_72['url'] != '' ) : ?>
			<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url($favicon_a_72['url']); ?>">
		<?php endif; ?>
		<?php 
		$favicon_a_144 = ts_get_opt('favicon-a-144');
		if( is_array($favicon_a_144) && $favicon_a_144['url'] != '' ) : ?>
			<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url($favicon_a_144['url']); ?>">
		<?php endif; ?>
		<?php 
		$favicon_a_60 = ts_get_opt('favicon-a-60');
		if( is_array($favicon_a_60) && $favicon_a_60['url'] != '' ) : ?>
			<link rel="apple-touch-icon" sizes="60x60" href="<?php echo esc_url($favicon_a_60['url']); ?>">
		<?php endif; ?>
		<?php 
		$favicon_a_120 = ts_get_opt('favicon-a-120');
		if( is_array($favicon_a_120) && $favicon_a_120['url'] != '' ) : ?>
			<link rel="apple-touch-icon" sizes="120x120" href="<?php echo esc_url($favicon_a_120['url']); ?>">
		<?php endif; ?>
		<?php 
		$favicon_a_76 = ts_get_opt('favicon-a-76');
		if( is_array($favicon_a_76) && $favicon_a_76['url'] != '' ) : ?>
			<link rel="apple-touch-icon" sizes="76x76" href="<?php echo esc_url($favicon_a_76['url']); ?>">
		<?php endif; ?>
		<?php 
		$favicon_a_152 = ts_get_opt('favicon-a-152');
		if( is_array($favicon_a_152) && $favicon_a_152['url'] != '' ) : ?>
			<link rel="apple-touch-icon" sizes="152x152" href="<?php echo esc_url($favicon_a_152['url']); ?>">
		<?php endif; ?>
		<?php 
		$favicon_a_180 = ts_get_opt('favicon-a-180');
		if( is_array($favicon_a_180) && $favicon_a_180['url'] != '' ) : ?>
			<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url($favicon_a_180['url']); ?>">
		<?php endif; ?>
		<?php if( ts_get_opt('favicon-win-color') != '' ) : ?>
			<meta name="msapplication-TileColor" content="<?php echo esc_url( ts_get_opt('favicon-win-color') ); ?>" />
		<?php endif; ?>
		<?php 
		$favicon_win_70 = ts_get_opt('favicon-win-70');
		if( is_array($favicon_win_70) && $favicon_win_70['url'] != '' ) : ?>
			<meta name="msapplication-square70x70logo" content="<?php echo esc_url($favicon_win_70['url']); ?>" />
		<?php endif; ?>
		<?php 
		$favicon_win_150 = ts_get_opt('favicon-win-150');
		if( is_array($favicon_win_150) && $favicon_win_150['url'] != '' ) : ?>
			<meta name="msapplication-square150x150logo" content="<?php echo esc_url($favicon_win_150['url']); ?>" />
		<?php endif; ?>
		<?php 
		$favicon_win_310 = ts_get_opt('favicon-win-310');
		if( is_array($favicon_win_310) && $favicon_win_310['url'] != '' ) : ?>
			<meta name="msapplication-wide310x150logo" content="<?php echo esc_url($favicon_win_310['url']); ?>" />
		<?php endif; ?>
		<?php 
		$favicon_win_310_quad = ts_get_opt('favicon-win-310-quad');
		if( is_array($favicon_win_310_quad) && $favicon_win_310_quad['url'] != '' ) : ?>
			<meta name="msapplication-square310x310logo" content="<?php echo esc_url($favicon_win_310_quad['url']); ?>" />
		<?php endif; ?>
	<?php
	}
add_action( 'wp_head', 'rhythm_favicon', 5 );
endif;

/**
 * Insert Custom CSS Global Code in wp_head
 */
function rhythm_global_custom_css() { ?>
	<style type="text/css">
		<?php echo wp_strip_all_tags(ts_get_opt('css_editor')); ?>
	</style>
	<?php
}
add_action('wp_head', 'rhythm_global_custom_css', 200);

/**
 * Force under construction
 * @param type $template
 * @return type
 */
function rhythm_force_under_construction( $template ) {

	if (ts_get_opt('enable-under-construction') == 1 && !current_user_can('level_10') ) {
		
		$new_template = locate_template( array( 'templates/pages/under-construction.php' ) );
		if ( '' != $new_template ) {
			return $new_template ;
		}
	}
	return $template;
}
add_filter( 'template_include', 'rhythm_force_under_construction' );

/**
 * Add under construction notice to admin bar for logged user
 * @global type $wp_admin_bar
 */
function ts_under_construction_mode_to_admin_bar() {
    global $wp_admin_bar;
	
	if (ts_get_opt('enable-under-construction') == 1) {
		$wp_admin_bar->add_menu( array(
			'id' => 'wpse-form-in-admin-bar',
			'parent' => 'top-secondary',
			'title' => '<span style="color: #FF0000;">Under Construction</span>'
		) );
	}
}
add_action( 'admin_bar_menu', 'ts_under_construction_mode_to_admin_bar' );