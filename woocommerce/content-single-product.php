<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<!-- Page Section -->
<section class="main-section page-section">
	<div class="container relative">

		<?php
			/**
			 * woocommerce_before_single_product hook
			 *
			 * @hooked wc_print_notices - 10
			 */
			 do_action( 'woocommerce_before_single_product' );

			 if ( post_password_required() ) {
				echo get_the_password_form();
				return;
			 }
		?>

		<!-- Product Content -->
		<div class="row mb-60 mb-xs-30">
			<div <?php post_class();?> itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>">

				<!-- Product Images -->
				<div class="col-md-4 mb-md-30">

					<div class="post-prev-img">
						<?php woocommerce_show_product_images(); ?>
						<?php woocommerce_show_product_sale_flash(); ?>
					</div>

					<div class="row">
						<?php woocommerce_show_product_thumbnails(); ?>
					</div>

				</div>
				<!-- End Product Images -->

				<!-- Product Description -->
				<div class="col-sm-8 col-md-5 mb-xs-40">

					<?php woocommerce_template_single_title(); ?>

					<hr class="mt-0 mb-30"/>

					<div class="row">
						<div class="col-xs-6 lead mt-0 mb-20">

							<?php woocommerce_template_single_price(); ?>

						</div>
						<div class="col-xs-6 align-right section-text">
							<?php woocommerce_template_single_rating(); ?>
						</div>
					</div>

					<hr class="mt-0 mb-30"/> 

					<div class="section-text mb-30" itemprop="description">
						<?php woocommerce_template_single_excerpt(); ?>
					</div>

					<hr class="mt-0 mb-30"/> 

					<div class="mb-30">
						<?php woocommerce_template_single_add_to_cart(); ?>
					</div>

					<hr class="mt-0 mb-30"/> 

					<div class="section-text small">
						<?php woocommerce_template_single_meta(); ?>
						<?php woocommerce_template_single_sharing(); ?>
					</div>


				</div>
				<!-- End Product Description -->

				<!-- Features -->
				<div class="col-sm-4 col-md-3 mb-xs-40">
					<?php get_sidebar('shop-single'); ?>
				</div>
				<!-- End Features -->

			</div>
		</div>
		<!-- End Product Content -->

		<?php woocommerce_output_product_data_tabs(); ?>

	</div>
</section>
<!-- End Page Section -->
<?php woocommerce_upsell_display(); ?>
