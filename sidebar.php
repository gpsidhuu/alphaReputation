<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Rhythm
 */

$layout = ts_get_opt('main-layout');

switch ($layout):
	case 'left_sidebar': ?>
		<!-- Sidebar -->
		<div class="col-sm-4 <?php echo (ts_get_opt('sidebar-size') == '4columns' ? 'col-md-4' : 'col-md-3'); ?> sidebar">
			<?php if (is_active_sidebar( ts_get_custom_sidebar('main') )): ?>
				<?php dynamic_sidebar( ts_get_custom_sidebar('main') ); ?>
			<?php endif; ?>
		</div>
		<!-- End Sidebar -->
		<?php break;
	
	case 'right_sidebar': ?>
		<!-- Sidebar -->
		<div class="col-sm-4 <?php echo (ts_get_opt('sidebar-size') == '4columns' ? 'col-md-4' : 'col-md-3 col-md-offset-1'); ?> sidebar">
			<?php if (is_active_sidebar( ts_get_custom_sidebar('main') )): ?>
				<?php dynamic_sidebar( ts_get_custom_sidebar('main') ); ?>
			<?php endif; ?>
		</div>
		<!-- End Sidebar -->	
		<?php break;
endswitch;
?>