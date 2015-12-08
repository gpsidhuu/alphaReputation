<?php
add_action( 'display_init', '_init' );
function _init() {
	require_once( "Hybrid/Auth.php" );
	if( isset( $_GET['_login'] ) ) {
		switch( $_GET['_login'] ) {
			case 'tw':
				break;
			case 'fb':
				break;
			case 'gp':
				break;
		}
	}
	$config=dirname( __FILE__ ) . '/config.php';
	try {
		$hybridauth=new Hybrid_Auth( $config );
		$twitter=$hybridauth->authenticate( "Google" );
		$user_profile=$twitter->getUserProfile();
		echo "Hi there! " . $user_profile->displayName;
		$twitter->setUserStatus( "Hello world!" );
		$user_contacts=$twitter->getUserContacts();
	} catch( Exception $e ) {
		echo "Ooophs, we got an error: " . $e->getMessage();
	}
}