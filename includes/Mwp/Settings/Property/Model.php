<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Property_Model{
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
	 * address or tagline
	 * */
	public function property_title($action = '', $value = ''){
		$prefix = 'masterdigm_property_title';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	/**
	 * book a viewing url
	 * */
	public function bookaviewing_url($action = '', $value = ''){
		$prefix = 'masterdigm_bookaviewing_url';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function bookaviewing_label($action = '', $value = ''){
		$prefix = 'masterdigm_bookaviewing_label';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function bookaviewing_align($action = '', $value = ''){
		$prefix = 'masterdigm_bookaviewing_align';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function show_bed($action = '', $value = ''){
		$prefix = 'masterdigm_show_bed';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function show_bath($action = '', $value = ''){
		$prefix = 'masterdigm_show_bath';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function show_garage($action = '', $value = ''){
		$prefix = 'masterdigm_show_garage';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function __construct(){}
}
