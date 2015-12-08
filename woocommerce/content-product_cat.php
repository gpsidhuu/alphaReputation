<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php do_action( 'woocommerce_before_subcategory', $category ); ?>
<div class="col-md-4 col-lg-4 mb-60 mb-xs-40">
		
		<div class="post-prev-img">
			<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
				<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked woocommerce_subcategory_thumbnail - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $category );
				?>
			</a>
		</div>

		<div class="post-prev-title font-alt align-center">
			<a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
				<?php
				echo $category->name;

				if ( $category->count > 0 )
					echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
				?>
			</a>
        </div>
		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>

	</a>
</div>
<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
