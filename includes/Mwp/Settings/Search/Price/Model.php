<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Search_Price_Model{
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
	 *
	 * */
	public function ten_start($action = '', $value = ''){
		$prefix = 'masterdigm_search_price_range_ten_start';
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

	public function ten_end($action = '', $value = ''){
		$prefix = 'masterdigm_search_price_range_ten_end';
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

	public function ten_step($action = '', $value = ''){
		$prefix = 'masterdigm_search_price_range_ten_step';
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

	/**
	 *
	 * */
	public function hundred_start($action = '', $value = ''){
		$prefix = 'masterdigm_search_price_range_hundred_start';
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

	public function hundred_end($action = '', $value = ''){
		$prefix = 'masterdigm_search_price_range_hundred_end';
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

	public function hundred_step($action = '', $value = ''){
		$prefix = 'masterdigm_search_price_range_hundred_step';
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

	/**
	 *
	 * */
	public function million_start($action = '', $value = ''){
		$prefix = 'masterdigm_search_price_range_million_start';
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

	public function million_end($action = '', $value = ''){
		$prefix = 'masterdigm_search_price_range_million_end';
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

	public function million_step($action = '', $value = ''){
		$prefix = 'masterdigm_search_price_range_million_step';
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
