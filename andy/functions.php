<?php
define( 'TURL', get_bloginfo( 'template_url' ) );
define( 'SURL', get_bloginfo( 'url' ) );
add_action( 'wp_enqueue_scripts', 'xs_enq' );
function xs_enq() {
	wp_enqueue_style( 'custom-style', TURL . '/andy/style.css' );
	wp_enqueue_script( 'global-js', TURL . '/andy/global.js' );
}