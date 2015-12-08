<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Rhythm
 */
?>
<?php get_sidebar( 'footer' ); ?>

<?php if ( ts_get_opt( 'footer-enable' ) == 1 ): ?>
	<!-- Foter -->
	<footer class="page-section bg-gray-lighter footer pb-60">
		<div class="container">
			<!-- Footer Logo -->
			<?php if ( ts_get_opt( 'footer-logo-enable' ) ): ?>
				<div class="local-scroll mb-30 wow fadeInUp" data-wow-duration="1.5s">
					<?php rhythm_logo( 'footer-logo', get_template_directory_uri() . '/images/logo-footer.png', '' ); ?>
				</div>
			<?php endif; ?>
			<!-- End Footer Lo  go -->
			<?php
			if ( ts_get_opt( 'footer-enable-social-icons' ) == 1 ): ?>
				<!-- Social Links -->
				<div class="footer-social-links mb-110 mb-xs-60">
					<?php rhythm_social_links(); ?>
				</div>                    <!-- End Social Links -->
			<?php endif; ?>
			<!-- Footer Text -->
			<div class="footer-text">
				<div class="footer-copy font-alt">
					<?php echo ts_get_opt( 'footer-text-content' ); ?>
				</div>
				<div class="footer-made">
					<?php echo ts_get_opt( 'footer-small-text-content' ); ?>
				</div>
			</div>
			<!-- End Footer Text -->
		</div>
		<!-- Top Link -->
		<div class="local-scroll">
			<a href="#top" class="link-to-top"><i class="fa fa-caret-up"></i></a>
		</div>
		<!-- End Top Link -->
	</footer>        <!-- End Foter -->
<?php endif; ?>
</div><!-- End Page Wrap -->
<?php wp_footer(); ?>
<script>
	(function ($) {
		$(document).ready(function () {

			$('.tpl-tabs a').click(function (e) {
				var id = $(this).attr('href');

				$('.tab-pane').addClass('fade').removeClass('active');
				$(id).addClass('active').removeClass('fade');
				e.preventDefault();
			})
		})
	})(jQuery)</script></body></html>
