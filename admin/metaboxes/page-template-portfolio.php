<?php
/**
 * Page Template Portfolio
 */

$sections[] = array(
	//'title' => __(' Settings', 'rhythm'),
	'icon' => 'el-icon-screen',
	'fields' => array(
		array(
			'id'        => 'portfolio-style',
			'type'      => 'select',
			'title'     => __('Style', 'rhythm'),
			'subtitle'  => __('Select desired style for portfolio template. ', 'rhythm'),
			'options'   => array(
				'boxed_black' => __('Boxed black', 'rhythm'),
				'boxed_white' => __('Boxed white', 'rhythm'),
				'boxed_gutter_black' => __('Boxed gutter black', 'rhythm'),
				'boxed_gutter_white' => __('Boxed gutter white', 'rhythm'),
				'boxed_titles_black' => __('Boxed titles black', 'rhythm'),
				'boxed_titles_white' => __('Boxed titles white', 'rhythm'),
				'masonry_black' => __('Masonry black', 'rhythm'),
				'masonry_white' => __('Masonry white', 'rhythm'),
				'wide_black' => __('Wide black', 'rhythm'),
				'wide_white' => __('Wide white', 'rhythm'),
				'wide_gutter_black' => __('Wide gutter black', 'rhythm'),
				'wide_gutter_white' => __('Wide gutter white', 'rhythm'),
				'wide_titles_black' => __('Wide titles black', 'rhythm'),
				'wide_titles_white' => __('Wide titles white', 'rhythm'),
			),
			'default' => 'boxed_black',
			'validate' => 'not_empty',
		),
		array(
			'id' => 'portfolio-allow-vertical-images',
			'type' => 'switch', 
			'title' => __('Allow vertical images', 'rhythm'),
			'default' => 0,
			'required' => array('portfolio-style', '=', array('masonry_black', 'masonry_white'))
		),
		array(
			'id'        => 'portfolio-columns',
			'type'      => 'select',
			'title'     => __('Columns', 'rhythm'),
			'subtitle'  => __('Select desired number of columns', 'rhythm'),
			'options'   => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
			),
			'default' => '2',
			'validate' => 'not_empty',
		),
		array(
			'id'        => 'portfolio-posts-per-page',
			'type'      => 'text',
			'title'     => __('Posts per page', 'rhythm'),
			'subtitle'  => __('The number of items to show.', 'rhythm'),
			'default'   => '',
		),
		array(
			'id' => 'portfolio-enable-pagination',
			'type' => 'switch', 
			'title' => __('Enable pagination', 'rhythm'),
			'subtitle' => __('If on pagination will be enabled.', 'rhythm'),
			'default' => 1,
		),
		
		array(
			'id' => 'portfolio-enable-filter',
			'type' => 'switch', 
			'title' => __('Enable filter', 'rhythm'),
			'subtitle' => __('If on filters will be enabled.', 'rhythm'),
			'default' => 1,
		),
		
		array(
			'id' => 'portfolio-use-external-url',
			'type' => 'switch', 
			'title' => __('Use external URL if exists', 'rhythm'),
			'subtitle' => __('If on external URL is used instead of single post.', 'rhythm'),
			'default' => 0,
		),
		
		array(
			'id' => 'portfolio-allow-lightbox',
			'type' => 'switch', 
			'title' => __('Allow lightbox', 'rhythm'),
			'subtitle' => __('Lightbox will be used if portfolio item lightbox effect is enabled. Lightbox effect must be enabled on portfolio item edit form.', 'rhythm'),
			'default' => 0,
		),
		
		array(
			'id'        => 'portfolio-category',
			'type'      => 'select',
			'title'     => __('Categories', 'rhythm'),
			'subtitle'  => __('Select desired categories', 'rhythm'),
			'options'   => ts_get_terms_assoc('portfolio-category'),
			'multi'     => true,
			'default' => '',
		),
		
		array(
			'id'        => 'portfolio-exclude-posts',
			'type'      => 'text',
			'title'     => __('Excluded portfolio items', 'rhythm'),
			'subtitle'  => __('Post IDs you want to exclude, separated by commas eg. 120,123,1005', 'rhythm'),
			'default'   => '',
		),
	)
);