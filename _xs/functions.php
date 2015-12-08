<?php
// GLOABAL
$f = NULL;
define( 'SURL', get_bloginfo( 'url' ) );
define( 'TURL', get_bloginfo( 'template_url' ) );
//autoloader
include_once 'autoload.php';
add_action( 'wp_logout', 'fn_clear_session' );
function fn_clear_session() {
	session_start();
	session_destroy();
}

add_action( 'display_init', '_init' );
function _init() {
	session_start();
	include_once 'classes/xsUTL.php';
	require_once( "Hybrid/Auth.php" );
	//
	if ( isset( $_GET['_login'] ) ) {
		switch ( $_GET['_login'] ) {
			case 'tw':
				$src = 'Twitter';
				break;
			case 'fb':
				$src = 'Facebook';
				break;
			case 'gp':
				$src = "Google";
				break;
		}
	}
	$config = dirname( __FILE__ ) . '/config.php';
	try {
		$hybridauth   = new Hybrid_Auth( $config );
		$social_login = $hybridauth->authenticate( $src );
		$user_profile = $social_login->getUserProfile();
		$id           = $user_profile->identifier;
		$name         = $user_profile->displayName;
		$fname        = $user_profile->firstName;
		$lname        = $user_profile->lastName;
		$email        = $user_profile->email;
		//creates the user
		if ( ! is_email( $email ) ) {
			$_SESSION['role']  = $_SESSION['xs_user_type'];
			$_SESSION['src']   = $_GET['hauth.done'];
			$_SESSION['fname'] = $fname;
			$_SESSION['lname'] = $lname;
			$_SESSION['id']    = $id;
			// redirect to enter email
			wp_redirect( SURL . '/email-needed/' );
			die;
		}
		if ( email_exists( $email ) ) {
			//logs user
			$user      = get_user_by( 'email', $email );
			$logged_in = xsUTL::log_user( $user->ID );
			if ( $logged_in ) {
				wp_redirect( SURL . '/my-account/' );
			}
			die( 'Error' );;
		}
		$_role = $_SESSION['xs_user_type'];
		$data  = [
			'user_login' => $src . '_' . $id,
			'user_email' => $email,
			'first_name' => $fname,
			'last_name'  => $lname,
			'user_pass'  => substr( wp_hash( time() . rand( 0, 100000 ) ), 0, 8 ),
			'role'       => $_role
		];
		$user  = wp_insert_user( $data );
		if ( $user > 0 ) {
			if ( xsUTL::log_user( $user ) ) {
				wp_redirect( SURL . '/my-account/' );
			}
			die( 'Error' );
		}
		xsUTL::addError( 'Sign Up failed' );
	} catch( Exception $e ) {
	}
	// Form Processsor
	if ( $_POST['_act'] && ! is_admin() ) {
		$_form_processor = new xsFormProcess();
		die;
	}
}

add_action( 'wp_enqueue_scripts', 'fn_enq' );
function fn_enq() {
//    wp_enqueue_style('Boot', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');
	wp_enqueue_style( 'lato-font', 'https://fonts.googleapis.com/css?family=Lato:400,400italic,700,900,300' );
	wp_enqueue_style( 'ui-icons', TURL . '/_xs/scripts/UI-icon-master/icon.min.css' );
	wp_enqueue_style( 'fa-animate', TURL . '/_xs/css/fa-animate.css' );
	wp_enqueue_style( 'custom', get_bloginfo( 'template_url' ) . '/_xs/style.css' );
	wp_enqueue_script( 'j-cookie', TURL . '/_xs/scripts/jquery.cookie.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'ajax-uploader', TURL . '/_xs/scripts/ajax-uploader/SimpleAjaxUploader.min.js' );
	//Drop down
	wp_enqueue_script( 'ui-dimmer', TURL . '/_xs/scripts/UI-Dimmer-master/dimmer.min.js' );
	wp_enqueue_style( 'ui-dimmer-css', TURL . '/_xs/scripts/UI-Dimmer-master/dimmer.css' );
	wp_enqueue_script( 'ui-transition', '//oss.maxcdn.com/semantic-ui/2.1.4/components/transition.min.js' );
	wp_enqueue_style( 'ui-transitionCSS', '//oss.maxcdn.com/semantic-ui/2.1.4/components/transition.min.css' );
//	wp_enqueue_script( 'ui-baseJS', TURL . '/_xs/scripts/UI-Dropdown-master/index.min.js' );
	wp_enqueue_script( 'ui-dropdownJS', TURL . '/_xs/scripts/UI-Dropdown-master/dropdown.min.js' );
	wp_enqueue_style( 'ui-dropdown', TURL . '/_xs/scripts/UI-Dropdown-master/dropdown.css' );
	//
	wp_enqueue_script( 'j-global', TURL . '/_xs/scripts/global.js', array( 'jquery' ) );
}

// Custom Login Page
function login_failed() {
	$login_page = home_url( '/login/' );
	wp_redirect( $login_page . '?login=failed' );
	exit;
}

function goto_login_page() {
	global $page_id;
	$login_page = SURL . '/login/';
	$page       = explode( '?', basename( $_SERVER['REQUEST_URI'] ) );
	if ( ( $page[0] == "wp-login.php" ) and $_SERVER['REQUEST_METHOD'] == 'GET' ) {
		wp_redirect( $login_page );
		exit;
	}
}

add_action( 'wp_login_failed', 'login_failed' );
add_action( 'init', 'goto_login_page', 1 ); /**/
function fnValidateEmail( $email ) {
	/** @var $form validateForm */
	global $f;
	if ( email_exists( $email ) ) {
		$f->setCustomError( 'xs_email', 'Email address already Exists' );

		return FALSE;
	}

	return TRUE;
}

function fnValidateEmailOne( $email ) {
	/** @var $form validateForm */
	global $f;
	$user = get_user_by( 'id', get_current_user_id() );
	if ( $user->user_email != $email ) {
		if ( email_exists( $email ) ) {
			$f->setCustomError( 'xs_email', 'Email address already Exists' );

			return FALSE;
		}

		return TRUE;
	}
}

function fnValidateUsername( $username ) {
	global $f;
	if ( username_exists( $username ) ) {
		$f->setCustomError( 'xs_username', 'Username already taken' );

		return FALSE;
	}

	return TRUE;
}

function fnValidatePwd( $pwd ) {
	/** @var $form validateForm */
	global $f;
	if ( $pwd != $_POST['xs_cpwd'] ) {
		$f->setCustomError( 'xs_pwd', 'Passwords don\'t match' );

		return FALSE;
	}

	return TRUE;
}

/**
 * Send Register Email
 */
add_action( 'user_register', 'fn_send_activation_email', 10 );
function fn_send_activation_email( $userId ) {
	$code = md5( time() . rand( 9999, 9999999 ) );
	//
	update_user_meta( $userId, 'xs_code', $code );
	$user = get_user_by( 'id', $userId );
	$user = new WP_User( $userId );
	$role = $user->roles[0];
	if ( $role == 'subscriber' or $user == 'client' ) {
		$msg = '<h2>Welcome to Beaumaxx!</h2>';
		$msg .= '<p>You\'re well on your way to connect with numerous Beauty Professionals for your ideal Beauty Treatments, on <A href="' . SURL . '">www.beaumaxx.co.uk</a><p>';
		$msg .= '<a style="text-decoration: none;display:block; background-color:#0288e3;color: #ffffff;padding: 10px 10px;text-align: center;margin: 20px;" href="' . SURL . '/?activation_code=' . $code . '">Click here to verify your email</a>';
		$msg .= 'Or copy and paste this url in browser';
		$msg .= SURL . '/?activation_code=' . $code;
		wp_mail( $user->user_email, 'Activate your account on BeauMaxx', $msg );
	}
}

add_action( 'init', 'wp_init' );
function wp_init() {
	session_start();
	if ( $_GET['logout'] == 1 ) {
		session_destroy();
		wp_logout();
		wp_redirect( SURL . '/login/?_logout=1' );
		exit;
	}
	if ( $_GET['pid'] != '' && is_numeric( $_GET['pid'] ) ) {
		global $woocommerce;
		$woocommerce->cart->add_to_cart( $_GET['pid'] );
		wp_redirect( SURL . '/checkout/' );
		die;
	}
}

add_action( 'get_header', 'clear_Cart' );
function clear_Cart() {
	if ( get_the_ID() == 116 ) {
		global $woocommerce;
		$woocommerce->cart->empty_cart();
	}
}

add_action( 'after_setup_theme', 'remove_admin_bar' );
function remove_admin_bar() {
	if ( ! current_user_can( 'administrator' ) && ! is_admin() ) {
		show_admin_bar( FALSE );
	}
}