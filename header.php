<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="page" id="top">
 *
 * @package Rhythm
 */



if ( get_the_ID() == 1219 ) {
	wp_redirect( get_bloginfo( 'url' ) . '/complete-solution/' );
	die;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!--[if IE]>
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
	<meta name="google-site-verification" content="OLlmz7yUL8jyZo_Pa3UwZULsA5cFElP94yVVtvet_lw"/>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
	<?php wp_head(); ?>
	<script>
		var SURL = '<?php echo SURL;?>';
		var TURL = '<?php echo TURL;?>';
		(function ($) {
			$(document).ready(function () {
				$('.kw').focus();
			})
		})(jQuery)
	</script>
</head>
<body <?php body_class(); ?>>
<?php if ( ts_get_opt( 'enable-preloader' ) == 1 ):
	$preloader_custom_image = ts_get_opt_media( 'preloader-custom-image' );
	?>
	<!-- Page Loader -->
	<div class="page-loader <?php echo( ! empty( $preloader_custom_image ) ? 'loader-custom-image' : '' ); ?>">
		<?php if ( ! empty( $preloader_custom_image ) ): ?>
			<div class="loader-image">
				<img src="<?php echo esc_url( $preloader_custom_image ); ?>" alt="<?php _e( 'Loading...', 'rhythm' ); ?>"/>
			</div>
		<?php endif; ?>
		<div class="loader"><?php _e( 'Loading...', 'rhythm' ); ?></div>
	</div>    <!-- End Page Loader -->
<?php endif; ?>
<!-- Page Wrap -->
<div class="page" id="top">
	<?php if ( ts_get_opt( 'enable-under-construction' ) == 1 && ! current_user_can( 'level_10' ) ): ?><?php get_template_part( 'templates/header/under-construction' ); ?><?php else: ?><?php get_template_part( 'templates/preheader/default' ); ?><?php ts_get_header_template_part(); ?>
<?php endif; ?>