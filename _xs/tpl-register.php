<?php
/**
 * Template Name: [REGISTER]
 */
if( ! is_user_logged_in() ) {
} else {
	wp_redirect( SURL . '/my-account/' );
	exit;
}
get_header();
ts_get_title_wrapper_template_part();
?>
	<!-- Page Section -->
	<section class="main-section page-section <?php echo sanitize_html_classes( ts_get_post_opt( 'page-margin-local' ) ); ?>">
		<div class="container relative">
			<?php get_template_part( 'templates/global/page-before-content' ); ?>



			<?php while( have_posts() ) :
			the_post(); ?><?php get_template_part( 'templates/content/content', 'page' ); ?>
			<div class="row row-eq-height">
				<div class="col-sm-4">
					<form class="xs-ajax xs-form-p" action="">
						<input type="hidden" name="_act" value="register">
						<label for="">Username</label>
						<input type="text" name="xs_username" id="">
						<input name="xs_user_type" type="hidden" value="<?php echo $user_type; ?>" id="">
						<label for="">Email address</label>
						<input type="text" name="xs_email" id="">
						<label for="Password">Password</label>
						<input type="password" name="xs_pwd" id="">
						<label for="Password">Confirm Password</label>
						<input type="password" name="xs_cpwd" id="">
						<button class="" type="submit"><i class="fa fa-circle-o faa-burst animated"></i> <span>Sign Up</span></button>
					</form>
				</div>
				<div class="col-sm-2">
					<div class="sep-or">OR</div>
					<div class="sep-line"></div>
				</div>
				<div class="col-sm-4">
					<table class="vmid">
						<tr>
							<td>
								<div class="xs-social-login">
									<a href="<?php echo SURL; ?>/?_login=fb" class="fb-btn"><i class="fa fa-facebook facebook"></i>Facebook Login</a>
									<div class="clearfix"></div>
									<a href="<?php echo SURL; ?>/?_login=tw" class="tw-btn"><i class="fa fa-twitter twitter"></i>Twitter Login</a>
									<div class="clearfix"></div>
									<a href="<?php echo SURL; ?>/?_login=gp" class="gp-btn"><i class="fa fa-google"></i>Google Login</a>
									<div class="clearfix"></div>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<?php endwhile; // end of the loop ?><?php get_template_part( 'templates/global/page-after-content' ); ?>
			</div>
	</section><!-- End Page Section -->
<?php get_footer();



