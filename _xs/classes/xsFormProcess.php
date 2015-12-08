<?php

class xsFormProcess {
	private $error = [ ];
	private $okMsg;
	private $actions = array(
		'login',
		'register',
		'email_needed',
		'update_profile',
		'purchase_credit',
		'update_bus_profile',
		'add_coupon',
		'validate_coupon',
	);
	private $current_action;
	private $redirect;

	function __construct() {
		//	error_reporting( E_ALL ); // TODO: Error reporting here
		$this->current_action = trim( $_POST['_act'] );
		//
		//if ($_POST)
		if( ! in_array( $this->current_action, $this->actions ) ) {
			return;
		}
		$varFunction = $this->current_action;
		$this->$varFunction();
	}

	function login() {
		$this->okMsg = 'OK';
	}

	function update_profile() {
		extract( $_POST );
		global $f;
		$f = new xsValidateForm();
		$f->setRule( 'xs_first_name', 'First Name', 'trim|required' );
		$f->setRule( 'xs_last_name', 'Last  Name', 'trim|required' );
		$f->setRule( 'xs_email', 'Email address', 'trim|required|valid_email|callback[fnValidateEmailOne]' );
		$f->setRule( 'xs_gender', 'Gender', 'required' );
		$f->setRule( 'xs_tel1', 'Telephone', 'trim|required' );
		$f->setRule( 'xs_address', 'Address', 'trim|required' );
		$f->setRule( 'xs_city', 'City', 'trim|required' );
		$f->setRule( 'xs_zipcode', 'Zipcode', 'trim|required' );
		// PRO validation
		$user = new xsUser();
		if( $user->is_Pro() ) {
			/// PRO Validations
			$f->setRule( 'xs_verification_id', 'Verification ID', 'trim|required' );
			$f->setRule( 'xs_services', 'At Least 1 Service', 'trim|required' );
			$f->setRule( 'xs_cert_id', 'Certificate', 'trim|required' );
			$f->setRule( 'xs_cv_id', 'CV', 'trim|required' );
			//
		}
		if( $f->validate() ) {
			extract( $_POST );
			$user_id = get_current_user_id();
			wp_update_user( array(
				'ID'         => $user_id,
				'user_email' => $xs_email
			) );
			// PRo FIELDS //
			if( $user->is_Pro() ) {
				update_user_meta( $user_id, 'xs_verification_id', $xs_verification_id );
				update_user_meta( $user_id, 'xs_services', explode( ',', $xs_service ) );
				update_user_meta( $user_id, 'xs_cert_id', $xs_cert_id );
				update_user_meta( $user_id, 'xs_cv_id', $xs_cv_id );
			}
			// ////////////////
			update_user_meta( $user_id, 'first_name', $xs_first_name );
			update_user_meta( $user_id, 'last_name', $xs_last_name );
			update_user_meta( $user_id, 'xs_pic_id', $xs_pic_id );
			update_user_meta( $user_id, 'xs_gender', $xs_gender );
			update_user_meta( $user_id, 'xs_tel1', $xs_tel1 );
			update_user_meta( $user_id, 'xs_tel2', $xs_tel2 );
			update_user_meta( $user_id, 'xs_address', $xs_address );
			update_user_meta( $user_id, 'xs_city', $xs_city );
			update_user_meta( $user_id, 'xs_zipcode', $xs_zipcode );
			if( get_user_meta( $user_id, 'xs_first_run', TRUE ) != 1 ) {
				update_user_meta( $user_id, 'xs_first_run', 1 );
				$this->redirect = SURL . '/completed/';
			}
			$this->okMsg = 'Profile Update';
		} else {
			$err = $f->returnErrors();
			$this->error = $err;
		}
	}

	function email_needed() {
		global $f;
		$f = new xsValidateForm();
		$f->setRule( 'xs_email', 'Email Id', 'trim|required|valid_email|callback[fnValidateEmail]' );
		if( $f->validate() ) {
			// sign up and create acc 	print_r( $_SESSION );
			$data = [
				'user_login' => $_SESSION['src'] . '_' . $_SESSION['id'],
				'user_email' => $_POST['xs_email'],
				'first_name' => $_SESSION['fname'],
				'last_name'  => $_SESSION['lname'],
				'user_pass'  => substr( wp_hash( time() . rand( 0, 100000 ) ), 0, 8 ),
				'role'       => $_SESSION['role']
			];
			$user = wp_insert_user( $data );
			if( $user > 0 ) {
				if( xsUTL::log_user( $user ) ) {
					$this->okMsg = "Registration Successful.Please wait...";
					$this->redirect = SURL . '/my-account/';
				}
			}
			xsUTL::addError( 'Sign Up failed' );
		} else {
			$this->error = $f->returnErrors();
		}
	}

	/**
	 * Register Form
	 */
	function register() {
		global $f;
		$f = new xsValidateForm();
		$f->setRule( 'xs_username', 'Username', 'trim|required|fnValidateUsername' );
		$f->setRule( 'xs_email', 'Email ID', 'trim|required|valid_email|callback[fnValidateEmail]' );
		$f->setRule( 'xs_pwd', 'Password', 'required|callback[fnValidatePwd]' );
		if( $f->validate() ) {
			$userdata = [
				'user_login' => $_POST['xs_username'],
				'user_pass'  => $_POST['xs_pwd'],
				'user_email' => $_POST['xs_email'],
				'role'       => $_POST['xs_user_type']
			];
			$id = wp_insert_user( $userdata );
			if( ! is_wp_error( $id ) ) {
				$this->redirect = SURL . '/login/?_reg=1';
				$this->okMsg = 'Registration Successful.Please wait..';
			} else {
				$this->error[] = 'User Cant be created at this time. Please try again';
			}
		} else {
			$this->error = $f->returnErrors();
		}
	}

	function __destruct() {
		if( ! in_array( $this->current_action, $this->actions ) ) {
			return;
		}
		// TODO: Implement __destruct() method.
		if( ! empty( $this->error ) ) {
			echo json_encode( array(
				'status' => FALSE,
				'errors' => implode( '<br>', $this->error ),
			) );
		} else {
			echo json_encode( array(
				'status'   => TRUE,
				'errors'   => $this->okMsg,
				'redirect' => $this->redirect
			) );
		}
		die;
	}
}

