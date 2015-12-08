<?php
if (!defined( 'ABSPATH' )) {
	die( 'You cannot access this script directly' );
}

add_action( 'wp_ajax_import_sample_data', 'ts_importer_init' );
add_action( 'wp_ajax_refresh_import_log', 'ts_refresh_import_log' );
add_action( 'wp_ajax_reset_importer_status', 'ts_reset_import_status' );



/**
 * Importer init
 */
function ts_importer_init() {
	
	@ini_set('max_execution_time', 600);
	
	try {
		$importer = new ts_importer;
		
		if ($importer -> init()) {		
			//nothing to do
		}
		
	} catch (Exception $e) {
		
		$importer -> log('ERROR - '.$e->getMessage());
	}
	
	die();
}

/**
 * Refresh import log
 */
function ts_refresh_import_log() {
	
	$importer = new ts_importer;
	
	$log_check = $importer -> get_log();
	//don't add message if ERROR was found, JS script is going to stop refreshing
	if (strpos($log_check,'ERROR') === false) { 
		$importer -> log('MESSAGE - Import in progress...');
	}
	$log = $importer -> get_log();
	echo nl2br($log);
	die();
}

/**
 * Reset importer status
 */
function ts_reset_import_status() {
	delete_option('ts_import_started');
	die();
}

class ts_importer {
	
	/**
	 * Import starts if initiated and value is true, otherwise does not start
	 * @var bool 
	 */
	var $import = false;
	
	/**
	 * Revolution slider UniteDBRev class object
	 * @var object
	 */
	var $db = null;
	
	/**
	 * Construct
	 */
	public function __construct() {
		
		if ( current_user_can( 'manage_options' ) ) {
			$this -> import = true;
			
			if ( !defined('WP_LOAD_IMPORTERS') ) {
				define('WP_LOAD_IMPORTERS', true); 
			}
		}
	}
	
	/**
	 * Init importer
	 * @return boolean false if import failed
	 */
	public function init() {
		
		if ($this -> import !== true) {
			return false;
		}
		$this -> log('', false);
		
		if (get_option('ts_import_started') == 1) {
			$this -> log('ERROR - Import already started. You can\'t import sample data again. Please use fresh Wordpress installation or refresh this page and reset import using "Reset Status" button.');
			return false;
		}
		
		if (!class_exists('DOMDocument')) {
			$this -> log('ERROR - DOMDocument class doesn\'t exists. PHP extension libxml is required. Please contact your server administrator.');
			return false;
		}
		
		if (!$this -> include_files()) {
			$this -> log('ERROR - Importer can\'t load required files');
			return false;
		}
		
		if (function_exists('ini_get')) {
			$max_execution_time = ini_get('max_execution_time');
			if ($max_execution_time < 500) {
				$this -> log('NOTICE - Your script maximum execution time is set to '.$max_execution_time.' seconds. It may be not enough for import to succeed. Suggested value is 500 seconds.');
			}
		}
		
		$this -> log('MESSAGE - Import initialized!');
		
		if( class_exists('Woocommerce') ) {
			$this -> import('data.xml');
			$this -> set_woocommerce();
			
		} else {
			$this -> import('data.xml');
		}
		
		$this -> set_menus();		
		$this -> import_theme_options();
		$this -> import_widgets();		
		$this -> import_revolution_slider();
		$this -> set_reading_options();
		return true;
	}
	
	/**
	 * Include requried classes
	 * @return boolean true if all required files are included, false otherwise
	 */
	protected function include_files() {
		
		if (!class_exists( 'WP_Importer')) {
            include_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        }

        if (!class_exists('WP_Import')) {
            include_once get_template_directory() . '/extensions/importer/wordpress-importer.php';
        }
		
		//check if required importer classes exist
		if (!class_exists('WP_Importer') || !class_exists('WP_Import')) {
			return false;
		}
		return true;
	}
	
	/**
	 * Import file with data including posts, pages, comments, custom fields, terms, navigation menus and custom posts and settings
	 * @param string file name to import eg. data.xml or data_woocommerce.xml
	 * @return boolean
	 */
	protected function import($file) {
		
		$importer = new WP_Import();
         
		$xml = get_template_directory() . '/sample-data/'.$file;
		
		if (!file_exists($xml)) {
			$this -> log('ERROR - data.xml file not found');
			throw new Exception(sprintf(__('File %s not found.','rhythm'),$xml).' <br/><strong>'.__('Import stopped!','rhythm').'</strong>');
		}
		
		$importer->fetch_attachments = true;
			
		ob_start();
		$this -> log('MESSAGE - data.xml import started');
		update_option('ts_import_started',1);
		$importer->import($xml);
		ob_end_clean();
		$this -> log('MESSAGE - data.xml import completed');
		return true;
	}
	
	/**
	 * Set woocommerce pages
	 * @return boolean
	 */
	protected function set_woocommerce() {
		
		global $wpdb;
		
		$pages = array(
			'woocommerce_shop_page_id' => 'shop',
			'woocommerce_cart_page_id' => 'cart',
			'woocommerce_checkout_page_id' => 'checkout',
			'woocommerce_myaccount_page_id' => 'my-account',
			'woocommerce_lost_password_page_id' => 'lost-password',
			'woocommerce_edit_address_page_id' => 'edit-address',
			'woocommerce_view_order_page_id' => 'view-order',
			'woocommerce_change_password_page_id' => 'change-password',
			'woocommerce_logout_page_id' => 'logout',	
			'woocommerce_pay_page_id' => 'pay',
			'woocommerce_thanks_page_id' => 'order-received'
		);
		$this -> log('MESSAGE - saving woocommerce settings.');
		foreach($pages as $page_key => $slug) {
			
			$page = $wpdb -> get_row($wpdb -> prepare('SELECT * FROM '.$wpdb -> posts.' WHERE post_name= %s', $slug));
			if(isset( $page->ID ) && $page->ID) {
				update_option($page_key, $page->ID);
			}
		}
		
		// We no longer need to install pages
		delete_option( '_wc_needs_pages' );
		delete_transient( '_wc_activation_redirect' );
		$this -> log('MESSAGE - woocommerce settings saved.');
		// Flush rules after install
		flush_rewrite_rules();
		return true;
	}
	
	/**
	 * Set menus
	 * @return boolean
	 */
	protected function set_menus() {
		
		$registered_menus = get_registered_nav_menus();
		$locations = get_theme_mod( 'nav_menu_locations' );
		$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
		
		if ($registered_menus && $menus) {
			foreach ($registered_menus as $registered_menu_key => $registered_menu) {
				foreach ($menus as $menu) {
					
					if (stristr($menu->slug,$registered_menu_key)) {
						
						if (!is_array($locations)) {
							$locations = array();
						}
						
						$locations[$registered_menu_key] = $menu -> term_id;
					}
				}
			}
			set_theme_mod( 'nav_menu_locations', $locations ); // set menus to locations
			$this -> log('MESSAGE - menu location set.');
		}
		return true;
	}
	
	/**
	 * Import theme options
	 * @return boolean
	 */
	protected function import_theme_options() {

		$reduxConfig = new rhythm_Redux_Framework_config();
			
		$redux = $reduxConfig -> ReduxFramework;
	
		$import_json_file = get_template_directory() . '/sample-data/redux.json';
		$import_json = file_get_contents( $import_json_file );
		
		$import_data = get_option(REDUX_OPT_NAME);
		
		if (!is_array($import_data)) {
			return false;
		}
		
		$import_data['import'] = 'Import';
		$import_data['import_code'] = $import_json;

		$data = $redux-> _validate_options( $import_data );
		
		if (is_array($data)) {
			
			$basedir = '';
			$upload_dir = wp_upload_dir();
			if (isset($upload_dir['basedir'])) {
				$basedir = $upload_dir['basedir'];
			}
			
			foreach ($data as $key => $item) {
				if (is_array($item)) {
					
					//upload image from url field
					if (isset($item['url']) && !empty($item['url'])) {
						
						//skip images already downloaded (it should rather not happen)
						if (strstr($item['url'], $basedir)) {
							continue;
						}
						
						$id = $this -> import_image($item['url']);
						if ($id !== false) {
						
							$image = wp_get_attachment_image_src( $id, 'full' );
							
							if (is_array($image) && !is_wp_error($image)) {
								
								$data[$key]['url'] = $image[0];
								$data[$key]['id'] = $id;
								$data[$key]['height'] = $image[2];
								$data[$key]['width'] = $image[1];

								$thumb = wp_get_attachment_image_src( $id, 'thumbnail' );
								if (is_array($thumb) && !is_wp_error($thumb)) {
									$data[$key]['thumbnail'] = $thumb[0];
								}
							}
						}
					}
					
					//upload image from background-image field
					if (isset($item['background-image']) && !empty($item['background-image'])) {
						
						//skip images already downloaded (it should rather not happen)
						if (strstr($item['background-image'], $basedir)) {
							continue;
						}
						
						$id = $this -> import_image($item['background-image']);
						if ($id !== false) {
						
							$image = wp_get_attachment_image_src( $id, 'full' );
							if (is_array($image) && !is_wp_error($image)) {
								$data[$key]['background-image'] = $image[0];
								
								$data[$key]['media'] = array();
								$data[$key]['media']['id'] = $id;
								$data[$key]['media']['height'] = $image[2];
								$data[$key]['media']['width'] = $image[1];

								$thumb = wp_get_attachment_image_src( $id, 'thumbnail' );
								if (is_array($thumb) && !is_wp_error($thumb)) {
									$data[$key]['media']['thumbnail'] = $thumb[0];
								}
							}
						}
					}
				}
			}
		}
		
		$this -> log('MESSAGE - saving redux settings.');
		if ( ! empty( $data ) ) {
			$redux -> set_options( $data );
			$this -> log('MESSAGE - redux settings saved.');
		} else {
			$this -> log('ERROR - redux settings empty.');
		}
		
		return true;
	}
	
	/**
	 * Import image to media library
	 * @param string $url
	 * @return boolean
	 */
	protected function import_image($url) {
		
		$tmp = download_url( $url );
		$file_array = array(
			'name' => basename( $url ),
			'tmp_name' => $tmp
		);

		// Check for download errors
		if ( is_wp_error( $tmp ) ) {
			@unlink( $file_array[ 'tmp_name' ] );
			return false;
		}

		$id = media_handle_sideload( $file_array, 0 );
		
		// Check for handle sideload errors.
		if ( is_wp_error( $id ) ) {
			@unlink( $file_array['tmp_name'] );
			return false;
		}
		return $id;
	}
	
	/**
	 * Import widgets
	 * @return boolean
	 */
	protected function import_widgets() {

		$widget_data_file = get_template_directory() . '/sample-data/widget_data.json';
				
		$widget_data_json = file_get_contents( $widget_data_file );
		$import_array = json_decode($widget_data_json, true);
		
		if (!is_array($import_array)) {
			return false;
		}
		
		$this -> log('MESSAGE - widgets import started.');
		
		$sidebars_data = $import_array[0];
		$widget_data = $import_array[1];
		$current_sidebars = get_option( 'sidebars_widgets' );
		
		if (is_array($GLOBALS['wp_registered_sidebars'])) {
			foreach ($GLOBALS['wp_registered_sidebars'] as $key => $sidebar) {
				
				if (!isset($current_sidebars[$key])) {
					$current_sidebars[$key] = array();
				}
			}
		}
		
		//fix nav_menu widget IDs
		if (isset($widget_data['nav_menu'])) {
			
			$menus = wp_get_nav_menus(array('orderby' => 'name'));
			
			foreach ($widget_data['nav_menu'] as $widget_key => $widget_menu) {
				
				if (is_array($menus) && !is_wp_error($menus)) {
					foreach ($menus as $menu_key => $menu) {
						if (isset($widget_menu['title'])) {
							if ($widget_menu['title'] == $menu -> name) {
								$widget_data['nav_menu'][$widget_key]['nav_menu'] = $menu -> term_id;
							}
						}
					}
				}
				
			}
		}
		
		$new_widgets = array( );

		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :
			
			foreach ( $import_widgets as $import_widget ) :
				//if the sidebar exists
				if ( isset( $current_sidebars[$import_sidebar] ) ) :
					
					$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data = get_option( 'widget_' . $title );
					
					$new_widget_name =  $this -> get_new_widget_name( $title, $index );
					
					$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

					if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
						while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
							$new_index++;
						}
					}
					$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
					if ( array_key_exists( $title, $new_widgets ) ) {
						$new_widgets[$title][$new_index] = $widget_data[$title][$index];
						$multiwidget = $new_widgets[$title]['_multiwidget'];
						unset( $new_widgets[$title]['_multiwidget'] );
						$new_widgets[$title]['_multiwidget'] = $multiwidget;
					} else {
						$current_widget_data[$new_index] = $widget_data[$title][$index];
						$current_multiwidget = $current_widget_data['_multiwidget'];
						$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
						$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
						unset( $current_widget_data['_multiwidget'] );
						$current_widget_data['_multiwidget'] = $multiwidget;
						$new_widgets[$title] = $current_widget_data;
					}

				endif;
			endforeach;
		endforeach;

		if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
			update_option( 'sidebars_widgets', $current_sidebars );
			
			foreach ( $new_widgets as $title => $content ) {
				$content = apply_filters( 'widget_data_import', $content, $title );
				update_option( 'widget_' . $title, $content );
			}
			$this -> log('MESSAGE - widgets import completed.');
			return true;
		}
		$this -> log('NOTICE - widget import not completed.');
		return false;
	}
	
	/**
	 *
	 * @param string $widget_name
	 * @param string $widget_index
	 * @return string
	 */
	public static function get_new_widget_name( $widget_name, $widget_index ) {
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array( );
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;
		return $new_widget_name;
	}

	/**
	 * Import Revolution Slider
	 * @return boolean
	 */
	protected function import_revolution_slider() {
		
		if( !class_exists('UniteFunctionsRev') ) { // if revslider is activated
			$this -> log('NOTICE - Revslider is not activated. You can import sliders manualy from /sample-data/revslider folder later.');
			return false;
		}
		
		$this -> log('MESSAGE - Revslider import started.');
		
		$this->db = new UniteDBRev();
		
		$rev_slider_dir = get_template_directory() . '/sample-data/revslider/';
		
		//get available sliders list
		$rev_slider_files = array();
		$found_files = glob( $rev_slider_dir . '*.zip' );
		if (is_array($found_files) && count($found_files) > 0) {
			foreach($found_files  as $filename ) {
				$filename = basename($filename);
				$rev_slider_files[] = get_template_directory() . '/sample-data/revslider/' . $filename ;
			}
		}
		if (count($rev_slider_files) > 0) {
			foreach( $rev_slider_files as $filepath ) {
				$this -> import_revolution_slider_item($filepath);
			}
		}
		$this -> log('MESSAGE - Revslider import completed.');
		return true;
	}
	
	/**
	 * 
	 * @param type $filepath
	 * @return boolean
	 */
	protected function import_revolution_slider_item($filepath) {
		
		if(file_exists($filepath) == false) {
			//UniteFunctionsRev::throwError("Import file not found ".$filepath." !!!");
			$this -> log('NOTICE - Import file not found '.$filepath);
			return;
		}
		
		//check if zip file or fallback to old, if zip, check if all files exist
		if(!class_exists("ZipArchive")){
			$importZip = false;
		}else{
			$zip = new ZipArchive;
			$importZip = $zip->open($filepath, ZIPARCHIVE::CREATE);
		}
		
		if($importZip === true){ //true or integer. If integer, its not a correct zip file

			//check if files all exist in zip
			$slider_export = $zip->getStream('slider_export.txt');
			$custom_animations = $zip->getStream('custom_animations.txt');
			$dynamic_captions = $zip->getStream('dynamic-captions.css');
			$static_captions = $zip->getStream('static-captions.css');

			if(!$slider_export)  {
//				UniteFunctionsRev::throwError("slider_export.txt does not exist!");
				$this -> log('NOTICE - slider_export.txt does not exist! '.$filepath);
				return;
			}
			//if(!$custom_animations)  UniteFunctionsRev::throwError("custom_animations.txt does not exist!");
			//if(!$dynamic_captions) UniteFunctionsRev::throwError("dynamic-captions.css does not exist!");
			//if(!$static_captions)  UniteFunctionsRev::throwError("static-captions.css does not exist!");

			$content = '';
			$animations = '';
			$dynamic = '';
			$static = '';
			
			while (!feof($slider_export)) $content .= fread($slider_export, 1024);
			if($custom_animations){ while (!feof($custom_animations)) $animations .= fread($custom_animations, 1024); }
			if($dynamic_captions){ while (!feof($dynamic_captions)) $dynamic .= fread($dynamic_captions, 1024); }
			if($static_captions){ while (!feof($static_captions)) $static .= fread($static_captions, 1024); }

			fclose($slider_export);
			if($custom_animations){ fclose($custom_animations); }
			if($dynamic_captions){ fclose($dynamic_captions); }
			if($static_captions){ fclose($static_captions); }

			//check for images!

		}else{ //check if fallback
			//get content array
			$content = @file_get_contents($filepath);
		}

		if($importZip === true){ //we have a zip
			$db = new UniteDBRev();

			//update/insert custom animations
			$animations = @unserialize($animations);
			if(!empty($animations)){
				foreach($animations as $key => $animation){ //$animation['id'], $animation['handle'], $animation['params']
					$exist = $db->fetch(GlobalsRevSlider::$table_layer_anims, "handle = '".$animation['handle']."'");
					if(!empty($exist)){ //update the animation, get the ID
						if($updateAnim == "true"){ //overwrite animation if exists
							$arrUpdate = array();
							$arrUpdate['params'] = stripslashes(json_encode(str_replace("'", '"', $animation['params'])));
							$db->update(GlobalsRevSlider::$table_layer_anims, $arrUpdate, array('handle' => $animation['handle']));

							$id = $exist['0']['id'];
						}else{ //insert with new handle
							$arrInsert = array();
							$arrInsert["handle"] = 'copy_'.$animation['handle'];
							$arrInsert["params"] = stripslashes(json_encode(str_replace("'", '"', $animation['params'])));

							$id = $db->insert(GlobalsRevSlider::$table_layer_anims, $arrInsert);
						}
					}else{ //insert the animation, get the ID
						$arrInsert = array();
						$arrInsert["handle"] = $animation['handle'];
						$arrInsert["params"] = stripslashes(json_encode(str_replace("'", '"', $animation['params'])));

						$id = $db->insert(GlobalsRevSlider::$table_layer_anims, $arrInsert);
					}

					//and set the current customin-oldID and customout-oldID in slider params to new ID from $id
					$content = str_replace(array('customin-'.$animation['id'], 'customout-'.$animation['id']), array('customin-'.$id, 'customout-'.$id), $content);	
				}
				//dmp(__("animations imported!",REVSLIDER_TEXTDOMAIN));
			}else{
				//dmp(__("no custom animations found, if slider uses custom animations, the provided export may be broken...",REVSLIDER_TEXTDOMAIN));
			}

			//overwrite/append static-captions.css
			if(!empty($static)){
				if($updateStatic == "true"){ //overwrite file
					RevOperations::updateStaticCss($static);
				}else{ //append
					$static_cur = RevOperations::getStaticCss();
					$static = $static_cur."\n".$static;
					RevOperations::updateStaticCss($static);
				}
			}
			//overwrite/create dynamic-captions.css
			//parse css to classes
			$dynamicCss = UniteCssParserRev::parseCssToArray($dynamic);

			if(is_array($dynamicCss) && $dynamicCss !== false && count($dynamicCss) > 0){
				foreach($dynamicCss as $class => $styles){
					//check if static style or dynamic style
					$class = trim($class);

					if((strpos($class, ':hover') === false && strpos($class, ':') !== false) || //before, after
						strpos($class," ") !== false || // .tp-caption.imageclass img or .tp-caption .imageclass or .tp-caption.imageclass .img
						strpos($class,".tp-caption") === false || // everything that is not tp-caption
						(strpos($class,".") === false || strpos($class,"#") !== false) || // no class -> #ID or img
						strpos($class,">") !== false){ //.tp-caption>.imageclass or .tp-caption.imageclass>img or .tp-caption.imageclass .img
						continue;
					}

					//is a dynamic style
					if(strpos($class, ':hover') !== false){
						$class = trim(str_replace(':hover', '', $class));
						$arrInsert = array();
						$arrInsert["hover"] = json_encode($styles);
						$arrInsert["settings"] = json_encode(array('hover' => 'true'));
					}else{
						$arrInsert = array();
						$arrInsert["params"] = json_encode($styles);
					}
					//check if class exists
					$result = $db->fetch(GlobalsRevSlider::$table_css, "handle = '".$class."'");

					if(!empty($result)){ //update
						$db->update(GlobalsRevSlider::$table_css, $arrInsert, array('handle' => $class));
					}else{ //insert
						$arrInsert["handle"] = $class;
						$db->insert(GlobalsRevSlider::$table_css, $arrInsert);
					}
				}
				//dmp(__("dynamic styles imported!",REVSLIDER_TEXTDOMAIN));
			}else{
				//dmp(__("no dynamic styles found, if slider uses dynamic styles, the provided export may be broken...",REVSLIDER_TEXTDOMAIN));
			}
		}

		$content = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $content); //clear errors in string

		$arrSlider = @unserialize($content);
			if(empty($arrSlider)) {
				UniteFunctionsRev::throwError("Wrong export slider file format! This could be caused because the ZipArchive extension is not enabled.");	
				$this -> log('NOTICE - Wrong export slider file format! This could be caused because the ZipArchive extension is not enabled. '.$filepath);
				return;
			}

		//update slider params
		$sliderParams = $arrSlider["params"];

//		if($sliderExists){					
//			$sliderParams["title"] = $this->arrParams["title"];
//			$sliderParams["alias"] = $this->arrParams["alias"];
//			$sliderParams["shortcode"] = $this->arrParams["shortcode"];
//		}

		if(isset($sliderParams["background_image"]))
			$sliderParams["background_image"] = UniteFunctionsWPRev::getImageUrlFromPath($sliderParams["background_image"]);

		$json_params = json_encode($sliderParams);

		//update slider or create new
//		if($sliderExists){
//			$arrUpdate = array("params"=>$json_params);	
//			$this->db->update(GlobalsRevSlider::$table_sliders,$arrUpdate,array("id"=>$sliderID));
//		}else{	//new slider
			$arrInsert = array();
			$arrInsert["params"] = $json_params;
			$arrInsert["title"] = UniteFunctionsRev::getVal($sliderParams, "title","Slider1");
			$arrInsert["alias"] = UniteFunctionsRev::getVal($sliderParams, "alias","slider1");	
			$sliderID = $this->db->insert(GlobalsRevSlider::$table_sliders,$arrInsert);
//		}

		//-------- Slides Handle -----------

		//delete current slides
//		if($sliderExists)
//			$this->deleteAllSlides();

		//create all slides
		$arrSlides = $arrSlider["slides"];

		$alreadyImported = array();

		foreach($arrSlides as $slide){

			$params = $slide["params"];
			$layers = $slide["layers"];

			//convert params images:
			if(isset($params["image"])){
				//import if exists in zip folder
				if(strpos($params["image"], 'http') !== false){
				}else{
					if(trim($params["image"]) !== ''){
						if($importZip === true){ //we have a zip, check if exists
							$image = $zip->getStream('images/'.$params["image"]);
							if(!$image){
								echo $params["image"].__(' not found!<br>');

							}else{
								if(!isset($alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]])){
									$importImage = UniteFunctionsWPRev::import_media('zip://'.$filepath."#".'images/'.$params["image"], $sliderParams["alias"].'/');

									if($importImage !== false){
										$alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]] = $importImage['path'];

										$params["image"] = $importImage['path'];
									}
								}else{
									$params["image"] = $alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]];
								}


							}
						}
					}
					$params["image"] = UniteFunctionsWPRev::getImageUrlFromPath($params["image"]);
				}
			}

			//convert layers images:
			foreach($layers as $key=>$layer){					
				if(isset($layer["image_url"])){
					//import if exists in zip folder
					if(trim($layer["image_url"]) !== ''){
						if(strpos($layer["image_url"], 'http') !== false){
						}else{
							if($importZip === true){ //we have a zip, check if exists
								$image_url = $zip->getStream('images/'.$layer["image_url"]);
								if(!$image_url){
									echo $layer["image_url"].__(' not found!<br>');
								}else{
									if(!isset($alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]])){
										$importImage = UniteFunctionsWPRev::import_media('zip://'.$filepath."#".'images/'.$layer["image_url"], $sliderParams["alias"].'/');

										if($importImage !== false){
											$alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]] = $importImage['path'];

											$layer["image_url"] = $importImage['path'];
										}
									}else{
										$layer["image_url"] = $alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]];
									}
								}
							}
						}
					}
					$layer["image_url"] = UniteFunctionsWPRev::getImageUrlFromPath($layer["image_url"]);
					$layers[$key] = $layer;
				}
			}

			//create new slide
			$arrCreate = array();
			$arrCreate["slider_id"] = $sliderID;
			$arrCreate["slide_order"] = $slide["slide_order"];

			$my_layers = json_encode($layers);
			if(empty($my_layers))
				$my_layers = stripslashes(json_encode($layers));
			$my_params = json_encode($params);
			if(empty($my_params))
				$my_params = stripslashes(json_encode($params));


			$arrCreate["layers"] = $my_layers;
			$arrCreate["params"] = $my_params;

			$this->db->insert(GlobalsRevSlider::$table_slides,$arrCreate);									
		}

		//check if static slide exists and import
		if(isset($arrSlider['static_slides']) && !empty($arrSlider['static_slides'])){
			$static_slide = $arrSlider['static_slides'];
			foreach($static_slide as $slide){

				$params = $slide["params"];
				$layers = $slide["layers"];

				//convert params images:
				if(isset($params["image"])){
					//import if exists in zip folder
					if(strpos($params["image"], 'http') !== false){
					}else{
						if(trim($params["image"]) !== ''){
							if($importZip === true){ //we have a zip, check if exists
								$image = $zip->getStream('images/'.$params["image"]);
								if(!$image){
									echo $params["image"].__(' not found!<br>');

								}else{
									if(!isset($alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]])){
										$importImage = UniteFunctionsWPRev::import_media('zip://'.$filepath."#".'images/'.$params["image"], $sliderParams["alias"].'/');

										if($importImage !== false){
											$alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]] = $importImage['path'];

											$params["image"] = $importImage['path'];
										}
									}else{
										$params["image"] = $alreadyImported['zip://'.$filepath."#".'images/'.$params["image"]];
									}


								}
							}
						}
						$params["image"] = UniteFunctionsWPRev::getImageUrlFromPath($params["image"]);
					}
				}

				//convert layers images:
				foreach($layers as $key=>$layer){					
					if(isset($layer["image_url"])){
						//import if exists in zip folder
						if(trim($layer["image_url"]) !== ''){
							if(strpos($layer["image_url"], 'http') !== false){
							}else{
								if($importZip === true){ //we have a zip, check if exists
									$image_url = $zip->getStream('images/'.$layer["image_url"]);
									if(!$image_url){
										echo $layer["image_url"].__(' not found!<br>');
									}else{
										if(!isset($alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]])){
											$importImage = UniteFunctionsWPRev::import_media('zip://'.$filepath."#".'images/'.$layer["image_url"], $sliderParams["alias"].'/');

											if($importImage !== false){
												$alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]] = $importImage['path'];

												$layer["image_url"] = $importImage['path'];
											}
										}else{
											$layer["image_url"] = $alreadyImported['zip://'.$filepath."#".'images/'.$layer["image_url"]];
										}
									}
								}
							}
						}
						$layer["image_url"] = UniteFunctionsWPRev::getImageUrlFromPath($layer["image_url"]);
						$layers[$key] = $layer;
					}
				}

				//create new slide
				$arrCreate = array();
				$arrCreate["slider_id"] = $sliderID;

				$my_layers = json_encode($layers);
				if(empty($my_layers))
					$my_layers = stripslashes(json_encode($layers));
				$my_params = json_encode($params);
				if(empty($my_params))
					$my_params = stripslashes(json_encode($params));


				$arrCreate["layers"] = $my_layers;
				$arrCreate["params"] = $my_params;

//				if($sliderExists){
//					unset($arrCreate["slider_id"]);
//					$this->db->update(GlobalsRevSlider::$table_static_slides,$arrCreate,array("slider_id"=>$sliderID));
//				}else{
					$this->db->insert(GlobalsRevSlider::$table_static_slides,$arrCreate);									
//				}
			}
		}
	}
	
	/**
	 * Set reading options
	 * @global type $wpdb
	 * @return boolean
	 */
	protected function set_reading_options() {
		
		global $wpdb;
		
		$homepage = $wpdb -> get_row('SELECT * FROM '.$wpdb -> posts.' WHERE post_name="homepage"');
		$this -> log('MESSAGE - Setting home page');
		if(isset( $homepage ) && $homepage->ID) {
			update_option('show_on_front', 'page');
			update_option('page_on_front', $homepage->ID);
			
			$this -> log('MESSAGE - Home page set');
		} else {
			$this -> log('NOTICE - Home page couldn\'t be set.');
		}
		return true;
	}

		/**
	 * Download images
	 * @param type $data
	 * @return type
	 */
	protected function download_images($data) {
		
		if (is_array($data)) {
			foreach ($data as $key => $val) {
				$data[$key] = $this -> download_images($val);
			}
		} else {
			
			$image_exp = '!http://[a-z0-9\-\.\/]+\.(?:jpe?g|png|gif)!Ui';
			
			if (preg_match_all($image_exp , $data , $matches)) {
				
				if (isset($matches[0]) && is_array($matches[0])) {
					foreach ($matches[0] as $match) {
						
						$new_image = media_sideload_image( $match, null );
						
						if (!is_wp_error($new_image)) {
							
							//$new_image is html tag img, we need to retrieve src attribute
							$dom = new DOMDocument();
							$dom -> loadHTML($new_image);
							$imageTags = $dom->getElementsByTagName('img') -> item(0);
							$data = $imageTags->getAttribute('src');
						}
					}
				}
			}
		}
		return $data;
	}
	
	/**
	 * Log message
	 * @param string $message
	 * @param boolean $append
	 */
	public function log($message, $append = true) {
		$upload_dir = wp_upload_dir();
		if (isset($upload_dir['baseurl'])) {
			
			$data = '';
			if (!empty($message)) {
				$data = date("Y-m-d H:i:s").' - '.$message."\n";
			}
			
			if ($append === true) {
				file_put_contents($upload_dir['basedir'].'/importer.log', $data, FILE_APPEND);
			} else {
				file_put_contents($upload_dir['basedir'].'/importer.log', $data);
			}
		}
	}
	
	/**
	 * Get Log content
	 * @return string
	 */
	public function get_log() {
		$upload_dir = wp_upload_dir();
		if (isset($upload_dir['baseurl'])) {
			
			if (file_exists($upload_dir['basedir'].'/importer.log')) {
				return file_get_contents($upload_dir['basedir'].'/importer.log');
			}
		}
		return '';
	}
}