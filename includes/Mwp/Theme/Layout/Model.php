<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Theme_Layout_Model{
	protected static $instance = null;
	public $md_wp_theme_style = 'masterdigm_wp_theme_layout';
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
	
	public function mwp_menu($action = '', $value = ''){
		$prefix = 'mwp_menu';
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

	public function mwp_logo_img($action = '', $value = ''){
		$prefix = 'mwp_logo_img';
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
	
	public function mwp_search_form($action = '', $value = ''){
		$prefix = 'mwp_search_form';
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

	public function mwp_custom_css($action = '', $value = ''){
		$prefix = 'mwp_custom_css';
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
	
	public function mwp_get_headers($action = '', $value = ''){
		$prefix = 'mwp_get_headers';
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

	public function mwp_get_headers_name($action = '', $value = ''){
		$prefix = 'mwp_get_headers_name';
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

	public function mwp_get_footers($action = '', $value = ''){
		$prefix = 'mwp_get_footers';
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
	
	public function mwp_get_footers_name($action = '', $value = ''){
		$prefix = 'mwp_get_footers_name';
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
