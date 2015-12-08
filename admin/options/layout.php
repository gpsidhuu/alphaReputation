<?php
/*
 * Layout Section
*/

$this->sections[] = array(
	'title' => __('Layout Settings', 'rhythm'),
	'desc' => __('Change the main theme\'s layout and configure it.', 'rhythm'),
	'icon' => 'el-icon-th-large',
	'fields' => array(
		array(
			'id'        => 'main-layout',
			'type'      => 'image_select',
			'compiler'  => true,
			'title'     => __('Main Layout', 'rhythm'),
			'subtitle'  => __('Select main content and sidebar alignment. Choose between 1 or 2 column layout.', 'rhythm'),
			'options'   => array(
				'default' => array('alt' => __('1 Column', 'rhythm'),       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
				'left_sidebar' => array('alt' => __('2 Column Left', 'rhythm'),  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
				'right_sidebar' => array('alt' => __('2 Column Right', 'rhythm'), 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
			),
			'default'   => 'default',
			'validate' => 'not_empty',
		),
		
		array(
			'id'        => 'sidebar',
			'type'      => 'select',
			'title'     => __('Sidebar', 'rhythm'),
			'subtitle'  => __('Select custom sidebar', 'rhythm'),
			'options'   => ts_get_custom_sidebars_list(),
			'default'   => '',
			'required'  => array('main-layout', 'equals', array('left_sidebar', 'right_sidebar') ),
		),
		
		array(
			'id'        => 'sidebar-size',
			'type' => 'select',
			'title' => __('Sidebar Size', 'rhythm'),
			'subtitle' => __('Choose size for the title wrapper', 'rhythm'),
			'options' => array(
				'3columns' => __('Normal', 'rhythm'),
				'4columns' => __('Wide', 'rhythm'),
			),
			'default'   => '',
			'required'  => array('main-layout', 'equals', array('left_sidebar', 'right_sidebar') ),
		),
	),
);