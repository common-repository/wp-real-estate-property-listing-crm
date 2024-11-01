<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm CRM Client Lead
 *
 * this for the lead that is pushing to masterdigm crm
 * */
class Mwp_Settings_Lead_Model{
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

	public function lead_status($action = '', $value = ''){
		$prefix = 'masterdigm_lead_status';
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

	public function lead_type($action = '', $value = ''){
		$prefix = 'masterdigm_lead_type';
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

	public function lead_source($action = '', $value = ''){
		$prefix = 'masterdigm_lead_source';
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

	public function delete_all(){
		$this->lead_status('d');
		$this->lead_type('d');
		$this->lead_source('d');
	}

	public function __construct(){}
}

