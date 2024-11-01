<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Settings_Mail_Entity {
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * update the mail content
	 * */
	public function default_content(){
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		$content = '<p>%sitename% - New user registration</p>';
		$content .= 'Hello %name%, here are your website credentials<br>';
		$content .= 'Here are your credentials to log and view up-to-date property listings! You can save your favorite properties, email them, share on Facebook and more!<br>';
		$content .= 'Username : %username%<br>';
		$content .= 'Password : %password%<br>';
		$content .= '<p><a href="%loginurl%" title="Login">Please click to login</a></p>';

		return $content;
	}

	public function default_subject(){
		return 'Hello %name%, here are your website credentials';
	}

	public function __construct(){}

}
