<?php 
/**
 * Content wrapper presented after the loop (eg. used in page.php)
 * 
 * @package Rhythm
 */

$layout = ts_get_opt('main-layout');
if ($layout == 'left_sidebar'): ?>
		</div>
		<!-- End Page Content -->
	</div><!-- .row -->
<?php elseif ($layout == 'right_sidebar'): ?>
		</div>
		<!-- End Page Content -->
		<?php get_sidebar(); ?>
	</div><!-- .row -->
<?php else: ?>
		</div>
		<!-- End Page Content -->
	</div><!-- .row -->
<?php endif; ?>