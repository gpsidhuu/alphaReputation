<?php
/*

 * Template Name: [Login]

 */
if( is_user_logged_in() ) {
	wp_redirect( SURL . '/my-account/' );
	die;
}
get_header();
ts_get_title_wrapper_template_part();
?>
	<!-- Page Section -->
	<section class="main-section page-section <?php echo sanitize_html_classes( ts_get_post_opt( 'page-margin-local' ) ); ?>">
		<div class="container relative">
			<?php get_template_part( 'templates/global/page-before-content' ); ?>
			<div class="row">
				<div class="col-sm-12 ">
					<?php
					$login = $_GET['login'];
					if( $login === "failed" ) {
						echo '<p class="xs-error"><strong>ERROR:</strong> Invalid username and/or password.</p>';
					} elseif( $login === "empty" ) {
						echo '<p class="xs-error"><strong>ERROR:</strong> Username and/or Password is empty.</p>';
					} elseif( $login === "false" ) {
						echo '<p class="xs-error"><strong>ERROR:</strong> You are logged out.</p>';
					}
					if( $_GET['_reg'] == 1 ) {
						echo '<p class="xs-success">Registration successful.Please login below</p>';
					}
					if( $_GET['_logout'] == 1 ) {
						echo '<p class="xs-success">Your are logged out now.!!!</p>';
					}
					if( $_GET['_auth'] == 'false' ) {
						echo '<p class="xs-error">Restricted Access. Please login to continue.</p>';
					}
					?>
				</div>
			</div>
			<div class="row  row-eq-height">
				<div class="col-lg-4 col-md-4 col-sm-6">
					<?php
					ob_start();
					wp_login_form();
					$form = ob_get_contents();
					ob_end_clean();
					$form = str_ireplace( 'id="loginform"', 'class="xs-form-p"', $form );
					$form = str_ireplace( 'login-remember', 'xs-checkbox float-right"', $form );
					echo $form;
					?>
				</div>
				<div class="col-sm-2">
					<div class="sep-or">OR</div>
					<div class="sep-line"></div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6">
					<table class="vmid">
						<tr>
							<td>
								<a href="<?php echo SURL; ?>/?_login=fb" class="fb-btn"><i class="fa fa-facebook facebook"></i>Facebook Login</a>
								<div class="clearfix"></div>
								<a href="<?php echo SURL; ?>/?_login=tw" class="tw-btn"><i class="fa fa-twitter twitter"></i>Twitter Login</a>
								<div class="clearfix"></div>
								<a href="<?php echo SURL; ?>/?_login=gp" class="gp-btn"><i class="fa fa-google"></i>Google Login</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<?php get_template_part( 'templates/global/page-after-content' ); ?>
		</div>
	</section><!-- End Page Section -->
<?php get_footer();

