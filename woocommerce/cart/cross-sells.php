<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', $posts_per_page ),
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );

if ( $products->have_posts() ) : ?>

	<!-- Divider -->
	<hr class="mt-0 mb-0 "/>
	<!-- End Divider -->

	<!-- Cross Sells Products -->
	<section class="page-section only-top-margin">
		<div class="container relative">

			<h2 class="section-title font-alt mb-70 mb-sm-40">
				<?php _e( 'You may be interested in&hellip;', 'woocommerce' ) ?>
			</h2>

			<!-- Products Grid -->
			<div class="row multi-columns-row">
				
				<?php woocommerce_product_loop_start(); ?>

					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						
						<!-- Shop Item -->
						<div class="col-md-3 col-lg-3 mb-60 mb-xs-40">
							<?php wc_get_template_part( 'content', 'product' ); ?>
						</div>
						<!-- End Shop Item -->
					<?php endwhile; // end of the loop. ?>

				<?php woocommerce_product_loop_end(); ?>
			</div>
			<!-- End Products Grid -->

		</div>
	</section>
	<!-- End Cross Sells Products -->
<?php endif;

wp_reset_query();
