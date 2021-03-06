<?php
/** 
 * Fullwidth Slider part for portfolio single
 * 
 * @package Rhythm
 */
?>
<!-- Work Fullwidth Slider -->
<?php $gallery = ts_get_post_opt('portfolio-gallery');
if (is_array($gallery)): ?>
	<div class="fullwidth-slider-wrapper">
		<div class="home-section fullwidth-slider bg-dark mb-30 mb-xs-10">
		<?php foreach ($gallery as $item): ?>
			<?php if (isset($item['attachment_id'])): 
				$image = wp_get_attachment_image_src( $item['attachment_id'], 'full', array('alt' => esc_attr($item['title'])) );
				if (isset($image[0]) && !empty($image[0])): ?>
					<!-- Slide Item -->
					<section class="home-section bg-scroll fixed-height-medium" data-background="<?php echo esc_url($image[0]); ?>">
						<div class="js-height-parent container"></div>
					</section>
					<!-- End Slide Item -->
				<?php endif; ?>

			<?php endif; ?>
		<?php endforeach; ?>	
		</div>
	</div>
	<?php 
	wp_enqueue_script( 'owl-carousel' );
endif; ?>
<!-- End Work Fullwidth Slider -->