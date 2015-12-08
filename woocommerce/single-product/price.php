<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<!--				<del class="section-text">$50.00</del>
				<strong>$25.99</strong>-->

<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<?php echo $product->get_price_html(); ?>

	<meta itemprop="price" content="<?php echo esc_attr($product->get_price()); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo esc_attr(get_woocommerce_currency()); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo esc_attr($product->is_in_stock()) ? 'InStock' : 'OutOfStock'; ?>" />

</div>
