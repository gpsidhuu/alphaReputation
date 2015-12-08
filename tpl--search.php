<?php
/**
 * Template Name: GOOGLE SEACRH
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Rhythm
 */
get_header();
ts_get_title_wrapper_template_part();
?>
	<section class="main-section page-sefction <?php echo sanitize_html_classes( ts_get_post_opt( 'page-margin-local' ) ); ?>">
		<div class="container relative">
			<?php get_template_part( 'templates/global/page-before-content' ); ?><?php while( have_posts() ) : the_post(); ?><?php get_template_part( 'templates/content/content', 'page' ); ?><?php endwhile; // end of the loop ?><?php get_template_part( 'templates/global/page-after-content' ); ?>
		</div>
		<?php if( $_REQUEST['keyword'] != '' ):
			if( $_REQUEST['si'] == '' ): $_REQUEST['si'] = 0;endif; ?>
			<div id="white-content-wrapper">
				<h3>ALPHA REPUTATION SEARCH RESULTS</h3>

				<p class="form-description" style="font-weight: bold;">Type your key word below and mark the negative link(s), images and video's you want removed.</p>
			</div>
		<?php endif; ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="how-it-works" style="margin-top: 0;">
						<h5>HOW IT WORKS</h5>
						<ol>
							<li class="hiw-1">Check the box(es) next to all the negative links, images and video's you want removed.</li><!--

	-->
							<li class="hiw-2">Fill in your contact details <br/> and please describe the issue(s) you are facing.</li><!--

	-->
							<li class="hiw-3">Click on FREE SCAN to be contacted back<br/> within 24 hours with a comprehensive<br/> Online Reputation Management Plan</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="src">
			<div class="container">
				<form action="" method="get" class="xs-form">
					<div class="row">
						<div class="col-sm-5">
							<input type="text" placeholder="What key word is bothering you?" name="keyword" id="kw">
						</div>
						<div class="col-sm-5">
							<?php
							$urls = [ /**/
								'www.google.com',
								'www.google.co.uk',
								'www.google.fr',
								'www.google.de',
								'www.google.nl',
								'www.google.com.mx',
								'www.google.com.au',
								'www.google.ca',
								'www.google.be',
							];
							?>
							<select name="si" id="">
								<option value="">Select search engine...</option>
								<?php
								$x = 0;
								foreach( $urls as $url ): ?>
									<option value="<?php echo $x; ?>"><?php echo $url; ?></option>
									<?php $x ++; endforeach; ?>
							</select>
						</div>
						<div class="col-sm-2">
							<button type="submit" class="butn">SEARCH</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php if( trim( $_REQUEST['keyword'] ) != '' ): ?>
			<div class="container">
				<div class="row">
					<?php if( $_REQUEST['keyword'] != '' ): ?>
						<div class="col-sm-12">
							<div class="kw-con">
								<h2 class="xs-l"><?php echo $_REQUEST['keyword']; ?></h2>

								<h2 class="xs-r"><?php echo str_ireplace( array( 'https://', 'www.' ), '', $urls[ $_REQUEST['si'] ] ); ?></h2>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="" style="background: #fff url(<?php echo SURL; ?>/wp-content/uploads/2015/06/LOGO_BG.png) 0 0 repeat;">
				<form action="" class="xs-form cu ajaxForm">
					<div class="container" style="padding-top: 30px;padding-bottom: 30px;">
						<div class="row">
							<div class="col-sm-8">
								<div class="xs-tabs">
									<a class="loaded active" data-keyword="<?php echo $_REQUEST['keyword']; ?>" data-type="web" data-url="<?php echo $urls[ $_REQUEST['si'] ]; ?>" <?php if( $_REQUEST['type'] == '' or $_REQUEST['type'] == 'web' ) {
										echo 'class="active"';
									} ?> href="<?php echo SURL; ?>/check-rank/?type=web&keyword=<?php echo $_REQUEST['keyword']; ?>">Web
									</a>
									<a data-keyword="<?php echo $_REQUEST['keyword']; ?>" data-type="img" data-url="<?php echo $urls[ $_REQUEST['si'] ]; ?>" <?php if( $_REQUEST['type'] == 'img' ): ?>class="active"<?php endif; ?> href="<?php bloginfo( 'url' ); ?>/check-rank/?type=img&keyword=<?php echo $_REQUEST['keyword']; ?>">Images</a>
									<a data-keyword="<?php echo $_REQUEST['keyword']; ?>" data-type="vid" data-url="<?php echo $urls[ $_REQUEST['si'] ]; ?>" <?php if( $_REQUEST['type'] == 'vid' ): ?>class="active"<?php endif; ?> href="<?php bloginfo( 'url' ); ?>/check-rank/?type=vid&keyword=<?php echo $_REQUEST['keyword']; ?>">Videos</a>
								</div>
								<div class="xs-tab-con xs-tab-con-web "> <?php
									include_once 'andy/simple_html_dom.php';
									$keywordsGot = urlencode( $_REQUEST['keyword'] );
									include_once 'parts/web.php'; ?></div>
								<div class="xs-tab-con xs-tab-con-img"></div>
								<div class="xs-tab-con xs-tab-con-vid"></div>
							</div>
							<div class="col-sm-4">
								<div class="my-form" style="padding: 10px;background-color: #252525;">
									<div class="row">
										<div class="col-sm-12">
											<label for="">Name</label>
											<input type="text" name="fname" id="">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<label>Email Address</label>
											<input type="text" name="xemail" id="">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<label>Phone No.</label>
											<input type="text" name="phone" id="">
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<label for="Message">Message</label>
											<textarea name="msg" id="" cols="30" rows="4"></textarea>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<input type="hidden" name="_action" value="rs" id="">
											<input type="hidden" name="_keyword" value="<?php echo $_REQUEST['keyword']; ?>" id="">
											<input type="hidden" name="_se" value="<?php echo $urls[ $_REQUEST['si'] ]; ?>" id="">
											<button type="submit" class="butn">FREE SCAN</button>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="err"></div>
										</div>
									</div>
									<script>
										(function ($) {
											$(document).ready(function () {
												$('.ajaxForm').submit(function (e) {
													$('.err').html(' ');
													$('button', this).text('Please wait...')
													$.ajax({
														type: 'POST',
														dataType: 'JSON',
														data: $(this).serialize(),
														success: function (data) {
															if (data.status) {
																$('.err').html('<div class="redg">' + data.msg + '</div>')
															} else {
																$('.err').html('<div class="rede">' + data.msg + '</div>')
															}
														}
													});
													$('button', this).text('FREE SCAN');
													e.preventDefault();
												})
											})
										})(jQuery)
									</script>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		<?php else: ?>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="alert alert-danger">No results found.</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</section><!-- End Page Section -->
<?php get_footer();

