<?php
/*
 * Portfolio images Section
*/

$sections[] = array(
	'icon' => 'el-icon-picture',
	'title' => __('Gallery', 'rhythm'),
	'fields' => array(
		
		array(
			'id'=>'portfolio-enable-featured-image-local',
			'type' => 'button_set',
			'title' => __('Enable featured image section', 'rhythm'),
			'subtitle'=> __('If on, this layout part will be displayed.', 'rhythm'),
			'options' => array(
				'1' => 'On',
				'' => 'Default',
				'0' => 'Off',
			),
			'default' => '',
		),
		
		array(
			'id'=>'portfolio-enable-gallery-local',
			'type' => 'button_set',
			'title' => __('Enable project gallery section', 'rhythm'),
			'subtitle'=> __('If on, this layout part will be displayed.', 'rhythm'),
			'options' => array(
				'1' => 'On',
				'' => 'Default',
				'0' => 'Off',
			),
			'default' => '',
		),
		
		array(
			'id'=>'portfolio-gallery-type-local',
			'type' => 'select',
			'title' => __('Gallery Type', 'rhythm'),
			'subtitle' => __('Select the gallery template.', 'rhythm'),
			'options' => array(
				'classic' => __('Classic', 'rhythm'),
				'slider' => __('Slider', 'rhythm'),
				'fullwidth-slider' => __('Fullwidth Slider', 'rhythm'),
			),
			'default' => '',
		),
		
		array(
			'id'        => 'portfolio-gallery',
			'type'      => 'slides',
			'title'     => __('Gallery', 'rhythm'),
			'subtitle'  => __('Upload images or add from media library.', 'rhythm'),
			'placeholder'   => array(
				'title' => __('Title', 'rhythm'),
			),
			'show' => array(
				'title' => true,
				'description' => false,
				'url' => false,
			)
		),
	), // #fields
);