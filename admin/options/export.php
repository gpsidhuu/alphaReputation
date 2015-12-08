<?php
/*
 * General Section
*/

$this->sections[] = array(
	'title' => __('Import/Export', 'rhythm'),
	'desc' => __('Import/Export Options', 'rhythm'),
	'icon' => 'el-icon-arrow-down',
	'fields' => array(
		
		array(
			'id'            => 'opt-import-sample-data',
			'type'			=> 'raw',
			'title'         => 'Import sample data',
			'content'		=> '
				<p class="description">'.__('Import sample data including posts, pages, portfolio items, theme options, images, sliders etc. It may take severals minutes!', 'rhythm').'</p>
				<p>
					<span data-confirm="'.esc_attr__('Do you want to continue? Your data will be lost!', 'framework').'" id="import-sample-data" class="button button-primary">'.__('Import', 'rhythm').'</span>
					'.(get_option('ts_import_started') == 1 ? '<span data-confirm="'.esc_attr__('Do you want to continue? If you already imported sample data some theme features WILL NOT WORK CORRECTLY for imported post, pages, portfolio and other items!', 'framework').'" data-done="'.esc_attr__('Done','framework').'" id="reset-importer-status" class="button button-primary">'.__('Reset Status', 'rhythm').'</span>' : '').'
				</p>
				<div id="import-sample-data-log" class="hidden"><div>'
		),
		
		array(
			'id'            => 'opt-import-export',
			'type'          => 'import_export',
			'title'         => __('Import Export', 'rhythm'),
			'subtitle'      => __('Save and restore your Redux options', 'rhythm'),
			'full_width'    => false,
		),
	),
);