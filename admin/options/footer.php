<?php
/*
 * Footer Section
*/

$this->sections[] = array(
	'title' => __('Footer', 'rhythm'),
	'desc' => __('Change the footer section configuration.', 'rhythm'),
	'icon' => 'el-icon-cog',
	'fields' => array(
		
			
		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Footer sidebar configuration', 'rhythm')
		),
			
		array(
			'id'=>'footer-widgets-enable',
			'type' => 'switch',
			'title' => __('Enable footer sidebar?', 'rhythm'),
			'subtitle'=> __('If on, this layout part will be displayed.', 'rhythm'),
			"default" => 0,
		),
		
		array(
			'id'        => 'footer-sidebar-1',
			'type'      => 'select',
			'title'     => __('Footer Sidebar 1', 'rhythm'),
			'subtitle'  => __('Select custom sidebar', 'rhythm'),
			'options'   => ts_get_custom_sidebars_list(),
			'default'   => 'default',
			'required'  => array('footer-widgets-enable', 'equals', '1'),
			'validate'	=> 'not_empty'
		),
		
		array(
			'id'        => 'footer-sidebar-2',
			'type'      => 'select',
			'title'     => __('Footer Sidebar 2', 'rhythm'),
			'subtitle'  => __('Select custom sidebar', 'rhythm'),
			'options'   => ts_get_custom_sidebars_list(),
			'default'   => 'default',
			'required'  => array('footer-widgets-enable', 'equals', '1'),
			'validate'	=> 'not_empty'
		),
		
		array(
			'id'        => 'footer-sidebar-3',
			'type'      => 'select',
			'title'     => __('Footer Sidebar 3', 'rhythm'),
			'subtitle'  => __('Select custom sidebar', 'rhythm'),
			'options'   => ts_get_custom_sidebars_list(),
			'default'   => 'default',
			'required'  => array('footer-widgets-enable', 'equals', '1'),
			'validate'	=> 'not_empty'
		),
		
		array(
			'id'        => 'footer-sidebar-4',
			'type'      => 'select',
			'title'     => __('Footer Sidebar 4', 'rhythm'),
			'subtitle'  => __('Select custom sidebar', 'rhythm'),
			'options'   => ts_get_custom_sidebars_list(),
			'default'   => 'default',
			'required'  => array('footer-widgets-enable', 'equals', '1'),
			'validate'	=> 'not_empty'
		),
		
		
		array(
			'id' => 'random-number',
			'type' => 'info',
			'desc' => __('Footer bar configuration', 'rhythm')
		),
		
		array(
			'id'=>'footer-enable',
			'type' => 'switch', 
			'title' => __('Enable footer?', 'rhythm'),
			'subtitle'=> __('If on, this layout part will be displayed.', 'rhythm'),
			"default" => 1,
		),
		
		array(
			'id'=>'footer-logo-enable',
			'type' => 'switch', 
			'title' => __('Enable logo?', 'rhythm'),
			'subtitle'=> __('If on, this layout part will be displayed.', 'rhythm'),
			"default" => 1,
		),
		
		array(
			'id'=>'footer-logo',
			'type' => 'media', 
			'url' => true,
			'title' => __('Footer Logo', 'rhythm'),
			'subtitle' => __('Upload the logo that will be displayed in the footer.', 'rhythm'),
		),
			
		array(
			'id'=>'footer-enable-social-icons',
			'type' => 'switch',
			'title' => __('Show social icons', 'rhythm'),
			'subtitle'=> __('If on, social icons will be displayed.', 'rhythm'),
			"default" => 0,
		),

		array(
			'id' => 'footer-text-content',
			'type' => 'textarea',
			'title' => __('Copyright Content', 'rhythm'),
			'subtitle' => __('Place any text to be displayed.', 'rhythm'),
			'default' => '',
		),
		array(
			'id' => 'footer-small-text-content',
			'type' => 'textarea',
			'title' => __('Copyright Small Content', 'rhythm'),
			'subtitle' => __('Place any text to be displayed.', 'rhythm'),
			'default' => '',
		),
	), // #fields
);