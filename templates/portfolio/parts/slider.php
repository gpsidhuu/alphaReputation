<?php
/** 
 * Slider part for portfolio single
 * 
 * @package Rhythm
 */
?>
<!-- Work Gallery -->
<?php $gallery = ts_get_post_opt('portfolio-gallery');
if (is_array($gallery)): ?>
	<div class="work-full-media mb-30 mb-xs-10">
		<ul class="clearlist work-full-slider owl-carousel">
		<?php foreach ($gallery as $item): ?>
			<?php if (isset($item['attachment_id'])): ?>
				<li>
					<?php echo wp_get_attachment_image( $item['attachment_id'], 'ts-full', array('alt' => esc_attr($item['title'])) ); ?>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>	
		</ul>
	</div>
<?php 
wp_enqueue_script( 'owl-carousel' );
endif; ?>
<!-- End Work Gallery -->