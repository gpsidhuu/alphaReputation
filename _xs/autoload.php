<?php
spl_autoload_register( function ( $class ) {
	$file=dirname( __FILE__ ) . '/classes/' . $class . '.php';
	if( file_exists( $file ) ) {
		include_once $file;
	}
} );