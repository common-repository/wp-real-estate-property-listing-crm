<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Search_General_Model{
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

	public function search_status($action = '', $value = ''){
		$prefix = 'masterdigm_search_property';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	/**
	 *
	 * */
	public function form_title($action = '', $value = ''){
		$prefix = 'masterdigm_search_form_title';
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

	public function show_for_sale_button($action = '', $value = ''){
		$prefix = 'masterdigm_search_show_forsale_button';
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

	public function show_for_rent_button($action = '', $value = ''){
		$prefix = 'masterdigm_search_show_forrent_button';
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

	public function show_foreclosure_button($action = '', $value = ''){
		$prefix = 'masterdigm_search_show_foreclosure_button';
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

	public function show_privatesales_button($action = '', $value = ''){
		$prefix = 'masterdigm_search_show_privatesales_button';
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

	public function show_tolet_button($action = '', $value = ''){
		$prefix = 'masterdigm_search_show_tolet_button';
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
