<?php
/**
 * Content wrapper presented before the loop (eg. used in page.php)
 * 
 * @package Rhythm
 */

$layout = ts_get_opt('main-layout');
if ($layout == 'left_sidebar'): ?>
	<div class="row">
		<?php get_sidebar(); ?>
		<div class="col-sm-8 <?php echo (ts_get_opt('sidebar-size') == '4columns' ? '' : 'col-md-offset-1'); ?>">

<?php elseif ($layout == 'right_sidebar'): ?>
	<div class="row">
		<div class="col-sm-8">
<?php endif; 