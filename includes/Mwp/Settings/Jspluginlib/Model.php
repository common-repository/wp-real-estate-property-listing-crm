<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Jspluginlib_Model{
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

	public function jsplugin_lib($action = '', $value = ''){
		$prefix = 'masterdigm_jsplugin_lib';
		switch($action){
			case 'u':
				update_option($prefix, $value);
			break;
			case 'd':
				delete_option($prefix, $value);
			break;
			case 'r':
			default:
				return get_option($prefix, $value);
			break;
		}
	}

	public function __construct(){}
}
