<?php
/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */
// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------
return
	array(
		"base_url"   => SURL . '/social-callback/',
		"providers"  => array(
			// openid providers
			"OpenID"     => array(
				"enabled" => TRUE
			),
			"Yahoo"      => array(
				"enabled" => TRUE,
				"keys"    => array( "key" => "", "secret" => "" ),
			),
			"AOL"        => array(
				"enabled" => TRUE
			),
			"Google"     => array(
				"enabled" => TRUE,
				"scope"   => "https://www.googleapis.com/auth/userinfo.email", // optional
				"keys"    => array( "id" => "278604126400-ujo2df5kp1vjohec22sp14028kggnj4a.apps.googleusercontent.com", "secret" => "mV40Yk8MEj40gEZ9QNqlHert" ),
			),
			"Facebook"   => array(
				"enabled"        => TRUE,
				"keys"           => array( "id" => "1660235727588251", "secret" => "3a2c24ed9c0f8b7c0cf4047434413be0" ),
				"scope"          => "email", // optional
				"trustForwarded" => FALSE
			),
			"Twitter"    => array(
				"enabled"      => TRUE,
				"keys"         => array( "key" => "K2dVMhPFbdQHTylbz4JgZiq9v", "secret" => "CAH9MgD6pcQEE1yzU55LvA6BZVxnjYmG9O1hGoAO71KgOa5SVe" ),
				"includeEmail" => FALSE
			),
			// windows live
			"Live"       => array(
				"enabled" => TRUE,
				"keys"    => array( "id" => "", "secret" => "" )
			),
			"LinkedIn"   => array(
				"enabled" => TRUE,
				"keys"    => array( "key" => "", "secret" => "" )
			),
			"Foursquare" => array(
				"enabled" => TRUE,
				"keys"    => array( "id" => "", "secret" => "" )
			),
		),
		// If you want to enable logging, set 'debug_mode' to true.
		// You can also set it to
		// - "error" To log only error messages. Useful in production
		// - "info" To log info and error messages (ignore debug messages)
		"debug_mode" => FALSE,
		// Path to file writable by the web server. Required if 'debug_mode' is not false
		"debug_file" => "",
	);
