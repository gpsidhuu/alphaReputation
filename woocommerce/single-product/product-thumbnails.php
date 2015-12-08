<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	$loop 		= 0;

	foreach ( $attachment_ids as $attachment_id ) {
		$classes = array( 'zoom' );
		
		$image_link = wp_get_attachment_url( $attachment_id );

		if ( ! $image_link )
			continue;

		$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
		$image_class = esc_attr( implode( ' ', $classes ) );
		$image_title = esc_attr( get_the_title( $attachment_id ) );
		echo '<div class="col-xs-3 post-prev-img">';
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="lightbox-gallery-3 mfp-image %s" title="%s">%s</a>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );
		echo '</div>';
		$loop++;
	}
	
	wp_enqueue_script( 'jquery-magnific-popup' );
}
