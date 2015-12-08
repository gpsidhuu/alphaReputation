<?php
/*
 * General Section
*/

$this->sections[] = array(
	'title' => __('General Settings', 'rhythm'),
	'desc' => __('Configure easily the basic theme\'s settings.', 'rhythm'),
	'icon' => 'el-icon-adjust-alt',
	'fields' => array(
		
		array(
			'id'=>'enable-under-construction',
			'type' => 'switch', 
			'title' => __('Enable Under Construction', 'rhythm'),
			'subtitle'=> __('If on, the frontend shows under construction page only.', 'rhythm'),
			'desc' => __('Only administrator will be able to visit site. If you want to check under construction mode is enabled you have to logout.', 'rhythm'),
			'default' => 0,
		),
		
		array(
			'id'=>'enable-preloader',
			'type' => 'switch', 
			'title' => __('Enable Loader Effect?', 'rhythm'),
			'subtitle'=> __('If on, a loader will appear before loading the page.', 'rhythm'),
			'default' => 0,
		),
		
		array(
			'id'=>'preloader-custom-image',
			'type' => 'media', 
			'url' => true,
			'title' => __('Preloader custom image', 'rhythm'),
			'subtitle' => __('Upload the image that will be used for preloader.', 'rhythm'),
		),
		
		array(
			'id'       => 'custom-sidebars',
			'type'     => 'multi_text',
			'title'    => __( 'Custom Sidebars', 'rhythm' ),
			'subtitle' => __( 'Custom sidebars can be assigned to any page or post.', 'rhythm' ),
			'desc'     => __( 'You can add as many custom sidebars as you need.', 'rhythm' )
		)
	),
);