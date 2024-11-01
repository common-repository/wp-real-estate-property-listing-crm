<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Theme_Map_Model{
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
	
	public function mwp_geo_address($action = '', $value = ''){
		$prefix = 'mwp_geo_address';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_map_zoom($action = '', $value = ''){
		$prefix = 'mwp_map_zoom';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function __construct(){}
}
