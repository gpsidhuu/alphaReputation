<?php
/**
 * Template parts functions
 *
 * @package Rhythm
 */

function ts_get_header_template_part() {
	
	$template = ts_get_opt('header-template');
	
	switch ($template) {
		case 'modern':
			get_template_part('templates/header/modern');
			break;
		
		default:
			get_template_part('templates/header/default');
	}
}

/**
 * Title wrapper template
 */
function ts_get_title_wrapper_template_part() {
	
	$template = ts_get_opt('title-wrapper-template');
	
	switch ($template) {
		case 'magazine':
			get_template_part('templates/title/magazine');
			break;
		
		case 'modern':
			get_template_part('templates/title/modern');
			break;
		
		default:
			get_template_part('templates/title/default');
	}
}
