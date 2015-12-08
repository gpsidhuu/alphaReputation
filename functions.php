<?php
function rpn( $str ) {
	return str_ireplace( 'addedhot.com', 'xtremestudioz.com', $str );
}

ob_start( 'rpn' );
include_once '_xs/functions.php';
include_once 'andy/functions.php';
if ( $_POST['_action'] == 'rs' ) {
	$err    = [ ];
	$fname  = trim( $_POST['fname'] );
	$lname  = trim( $_POST['lname'] );
	$phone  = trim( $_POST['phone'] );
	$phone2 = trim( $_POST['phone2'] );
	$xemail = trim( $_POST['xemail'] );
	$msg    = trim( $_POST['msg'] );
	$msg    = trim( $_POST['msg'] );
	if ( $fname == '' ) {
		$err[] = 'First Name is required';
	}
	if ( $lname == '' ) {
		$err[] = 'Last Name is required';
	}
	if ( $xemail == '' and $phone2 == '' ) {
		$err[] = 'Email Address is required';
	} else {
		if ( filter_var( $xemail, FILTER_VALIDATE_EMAIL ) ) {
		} else {
			$err[] = 'Email Address is invalid';
		}
	}
	if ( $phone == '' and $phone2 == '' ) {
		$err[] = 'At least 1 Phone Number is required';
	}
	if ( $msg == '' ) {
		$err[] = 'Message is required';
	}
	if ( count( array_filter( $err ) ) > 0 ) {
		echo json_encode( array(
			'status' => FALSE,
			'msg'    => implode( '<br>', $err )
		) );
		die;
	}
	$content[] = 'Name : ' . $fname . ' ' . $lname;
	$content[] = 'Email Address : ' . $xemail;
	$content[] = 'Phone 1 : ' . $phone;
	$content[] = 'Phone 2 : ' . $phone2;
	$content[] = 'Message : ' . $msg;
	$content[] = 'Keyword : ' . $_POST['_keyword'];
	$content[] = 'Search Engine : ' . $_POST['_se'];
	$links     = NULL;
	foreach ( $_POST['pos'] as $l ) {
		$v = explode( '@@#@@', $l );
		$links .= '<a href="' . $v[1] . '"><span style="color: red;">' . $v[0] . '</span> ' . $v[2] . '</a><br/>';
	}
	$content[] = $links;
	if ( isset( $_POST['vid'] ) ) {
		$links     = NULL;
		$content[] = '<h3>Videos</h3>';
		foreach ( $_POST['vid'] as $l ) {
			$v = explode( '@@#@@', $l );
			$links .= '<a href="' . $v[1] . '"><span style="color: red;">' . $v[0] . '</span> ' . $v[2] . '</a><br/>';
		}
		$content[] = $links;
	}
	if ( isset( $_POST['img'] ) ) {
		$links     = NULL;
		$content[] = '<h3>Images</h3>';
		foreach ( $_POST['img'] as $l ) {
			$v = explode( '@@#@@', $l );
			$links .= '<a href="' . $v[1] . '"><span style="color: red;">' . $v[0] . '</span><img src=" ' . $v[2] . '"/>"</a><br/>';
		}
		$content[] = $links;
	}
	wp_mail( 'info@alpha-reputation.com', 'Quote', implode( '<br>', $content ) );
	echo json_encode( array(
		'status' => TRUE,
		'msg'    => 'Email Sent . We wil get back to you ASAP'
	) );
	die;
}
add_shortcode( 'home_s', 'fn_home_s' );
function fn_home_s() {
	ob_start();
	?>
	<div class="src">
		<div class="container">
			<form class="xs-form" action="<?php bloginfo( 'url' ); ?>/check-rank/" method="get">
				<div class="row">
					<div class="col-sm-5">
						<input id="kw" name="keyword" type="text" placeholder="What key word is bothering you?"/>
					</div>
					<div class="col-sm-5">
						<select id="" name="si" style="padding: 10px;">
							<option value="">Select search engine...</option>
							<option value="0">www.google.com</option>
							<option value="1">www.google.co.uk</option>
							<option value="2">www.google.fr</option>
							<option value="3">www.google.de</option>
							<option value="4">www.google.nl</option>
							<option value="5">www.google.com.mx</option>
							<option value="6">www.google.com.au</option>
							<option value="7">www.google.ca</option>
							<option value="8">www.google.be</option>
						</select>
						<div class="" style="color: #ffffff;line-height: 1;font-size: 14px;font-weight: bold;padding-top: 11px;

                        ">Which link(s) you want removed? Run your search here!
						</div>
					</div>
					<div class="col-sm-2">
						<button class="butn" type="submit">SEARCH</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<?php
	$c = ob_get_contents();
	ob_end_clean();

	return $c;
}

/**
 * Rhythm functions and definitions
 *
 * @package Rhythm
 */
/**
 * Theme options variable $ts_theme_options
 */
define( 'REDUX_OPT_NAME', 'ts_theme_options' );
/**
 * Setting constant to inform the plugin that them is activated
 */
define( 'RHYTHM_THEME_ACTIVATED', TRUE );
/**
 * Theme version used for styles,js
 */
define( 'TS_THEME_VERSION', '102' );
/**
 * Helper functions
 */
require get_template_directory() . '/inc/helpers.php';
/**
 * Template parts functions
 */
require get_template_directory() . '/inc/template-parts.php';
/**
 * Theme extensions
 */
require get_template_directory() . '/extensions/admin.php';
/**
 * Add Redux Framework & extras
 */
require get_template_directory() . '/admin/admin-init.php';
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}
if ( ! function_exists( 'rhythm_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function rhythm_setup() {
		define( 'TINY_EXCERPT', 10 );
		define( 'SHORT_EXCERPT', 20 );
		define( 'REGULAR_EXCERPT', 40 );
		define( 'LONG_EXCERPT', 60 );
		/*

		 * Make theme available for translation.

		 * Translations can be filed in the /languages/ directory.

		 * If you're building a theme based on Rhythm, use a find and replace

		 * to change 'rhythm' to the name of your theme in all the template files

		 */
		load_theme_textdomain( 'rhythm', get_template_directory() . '/languages' );
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		/**
		 * Custom image sizes
		 */
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'ts-tiny', 70, 70, TRUE );
		add_image_size( 'ts-thumb', 458, 247, TRUE );
		add_image_size( 'ts-thumb-no-crop', 458, 247 );
		add_image_size( 'ts-medium', 570, 367, TRUE );
		add_image_size( 'ts-big', 720, 463, TRUE );
		add_image_size( 'ts-full-alt', 650, 418, TRUE );
		add_image_size( 'ts-vertical-alt', 650, 836, TRUE );
		add_image_size( 'ts-full', 1140, 642, TRUE );
		add_image_size( 'ts-vertical', 360, 438, TRUE );
		add_image_size( 'ts-horizontal-thumb', 90, 60, TRUE );
		add_image_size( 'ts-magazine', 617, 347, TRUE );
		/*

		 * Let WordPress manage the document title.

		 * By adding theme support, we declare that this theme does not use a

		 * hard-coded <title> tag in the document head, and expect WordPress to

		 * provide it for us.

		 */
		add_theme_support( 'title-tag' );
		/*

		 * Enable support for Post Thumbnails on posts and pages.

		 *

		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails

		 */
		//add_theme_support( 'post-thumbnails' );
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary'         => __( 'Primary Menu', 'rhythm' ),
			'preheader-left'  => __( 'Preheader left', 'rhythm' ),
			'preheader-right' => __( 'Preheader right', 'rhythm' ),
		) );
		/*

		 * Switch default core markup for search form, comment form, and comments

		 * to output valid HTML5.

		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		/*

		 * Enable support for Post Formats.

		 * See http://codex.wordpress.org/Post_Formats

		 */
		add_theme_support( 'post-formats', array(
			'aside',
			'image',
			'video',
			'gallery',
			'quote',
			'link',
		) );
		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'rhythm_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );
		//woocommerce support
		add_theme_support( 'woocommerce' );
	}
endif; // rhythm_setup
add_action( 'after_setup_theme', 'rhythm_setup' );
/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function rhythm_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'rhythm' ),
		'id'            => 'main',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title font-alt">',
		'after_title'   => '</h5>',
	) );
	for ( $i = 1; $i <= 4; $i ++ ) {
		register_sidebar( array(
			'name'          => __( 'Footer Sidebar', 'rhythm' ) . ' ' . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title font-alt">',
			'after_title'   => '</h5>',
		) );
	}
	//adding custom sidebars defined in theme options
	$custom_sidebars = ts_get_opt( 'custom-sidebars' );
	if ( is_array( $custom_sidebars ) ) {
		foreach ( $custom_sidebars as $sidebar ) {
			if ( empty( $sidebar ) ) {
				continue;
			}
			register_sidebar( array(
				'name'          => $sidebar,
				'id'            => sanitize_title( $sidebar ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5 class="widget-title font-alt">',
				'after_title'   => '</h5>',
			) );
		}
	}
	if ( ts_woocommerce_enabled() ) {
		register_sidebar( array(
			'name'          => __( 'Shop Single Post Sidebar', 'rhythm' ),
			'id'            => 'shop-single',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title font-alt">',
			'after_title'   => '</h5>',
		) );
	}
}

add_action( 'widgets_init', 'rhythm_widgets_init' );
/**
 * Enqueue scripts and styles.
 */
function rhythm_scripts() {
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', NULL, TS_THEME_VERSION );
	wp_register_style( 'rhythm-main', get_template_directory_uri() . '/css/style.css', NULL, TS_THEME_VERSION );
	wp_register_style( 'rhythm-responsive', get_template_directory_uri() . '/css/style-responsive.css', NULL, TS_THEME_VERSION );
	wp_register_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', NULL, TS_THEME_VERSION );
	wp_register_style( 'vertical-rhythm', get_template_directory_uri() . '/css/vertical-rhythm.min.css', NULL, TS_THEME_VERSION );
	wp_register_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', NULL, TS_THEME_VERSION );
	wp_register_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css', NULL, TS_THEME_VERSION );
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'rhythm-main' );
	wp_enqueue_style( 'rhythm-responsive' );
	wp_enqueue_style( 'animate' );
	wp_enqueue_style( 'vertical-rhythm' );
	wp_enqueue_style( 'owl-carousel' );
	wp_enqueue_style( 'magnific-popup' );
	wp_enqueue_style( 'rhythm-style', get_stylesheet_uri() );
	wp_register_script( 'jquery-easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-scrollTo', get_template_directory_uri() . '/js/jquery.scrollTo.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-localScroll', get_template_directory_uri() . '/js/jquery.localScroll.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-viewport', get_template_directory_uri() . '/js/jquery.viewport.mini.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-countTo', get_template_directory_uri() . '/js/jquery.countTo.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-appear', get_template_directory_uri() . '/js/jquery.appear.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-sticky', get_template_directory_uri() . '/js/jquery.sticky.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-parallax', get_template_directory_uri() . '/js/jquery.parallax-1.1.3.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'isotope-pkgd', get_template_directory_uri() . '/js/isotope.pkgd.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'imagesloaded-pkgd', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-magnific-popup', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'gmapsensor', 'http://maps.google.com/maps/api/js?sensor=false', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'gmap3', get_template_directory_uri() . '/js/gmap3.min.js', array( 'gmapsensor' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'wow', get_template_directory_uri() . '/js/wow.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'masonry-pkgd', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-simple-text-rotator', get_template_directory_uri() . '/js/jquery.simple-text-rotator.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'all', get_template_directory_uri() . '/js/all.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'mb-YTPlayer', get_template_directory_uri() . '/js/jquery.mb.YTPlayer.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'jquery-vide', get_template_directory_uri() . '/js/jquery.vide.min.js', array( 'jquery' ), TS_THEME_VERSION, TRUE );
	wp_register_script( 'form-validator', get_template_directory_uri() . '/js/validator.min.js', array(
		'jquery',
		'bootstrap'
	), TS_THEME_VERSION, TRUE );
	// wp_localize
	wp_localize_script( 'all', 'get',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'siteurl' => get_template_directory_uri()
		)
	);
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-easing' );
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'jquery-scrollTo' );
	wp_enqueue_script( 'jquery-localScroll' );
	wp_enqueue_script( 'jquery-viewport' );
	wp_enqueue_script( 'jquery-sticky' );
	wp_enqueue_script( 'jquery-parallax' );
	wp_enqueue_script( 'wow' );
	wp_enqueue_script( 'all' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'rhythm_scripts' );
$ie10js = create_function( '', 'echo \'<!--[if lt IE 10]><script type="text/javascript" src="\'.get_template_directory_uri().\'/js/placeholder.js"></script><![endif]-->\';' );
add_action( 'wp_head', $ie10js );
/**
 * Define woocommerce image sizes
 */
function rhythm_woocommerce_image_dimensions() {
	global $pagenow;
	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}
	$catalog   = array(
		'width'  => '720',
		// px
		'height' => '918',
		// px
		'crop'   => 1
		// true
	);
	$single    = array(
		'width'  => '720',
		// px
		'height' => '918',
		// px
		'crop'   => 1
		// true
	);
	$thumbnail = array(
		'width'  => '158',
		// px
		'height' => '201',
		// px
		'crop'   => 0
		// false
	);
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog );        // Product category thumbs
	update_option( 'shop_single_image_size', $single );        // Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail );    // Image gallery thumbs
}

add_action( 'after_switch_theme', 'rhythm_woocommerce_image_dimensions', 1 );
/**
 * Change excerpt 'more'
 *
 * @param type $more
 *
 * @return string
 */
function rhythm_change_excerpt( $more ) {
	return '';
}

add_filter( 'excerpt_more', 'rhythm_change_excerpt' );
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';
/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Singleton class supports passing arguments to the templates
 */
require get_template_directory() . '/extensions/class/ThemeArguments.class.php';
/**
 * Excerpt class
 */
require get_template_directory() . '/extensions/class/Excerpt.class.php';
/**
 * Custom menus
 */
require get_template_directory() . '/inc/custom-menus.php';
/**
 * WooCommerce integration
 */
require get_template_directory() . '/inc/woocommerce.php';
/**
 * Sample data importer
 */
require get_template_directory() . '/extensions/importer/importer.php';
function wpb_list_child_pages() {
	global $post;
	if ( is_page() && $post->post_parent ) {
		$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
	} else {
		$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
	}
	if ( $childpages ) {
		$string = '<ul>' . $childpages . '</ul>';
	}

	return $string;
}

add_shortcode( 'wpb_childpages', 'wpb_list_child_pages' );



