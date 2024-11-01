<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm CRM Model
 *
 * This class handles the CRM database like keys from Masterdigm
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_CRM_Model{
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
	 * CRUD in the option table
	 *
	 * c = create / add, u = Update, d = delete and default / r = read
	 *
	 * @return mix | array | bool
	 * */
	public function default_feed($action = '', $value = ''){
		$option_name = 'masterdigm_crm_default_feed';
		switch($action){
			case 'c':
				add_option($option_name, $value);
			break;
			case 'u':
				update_option($option_name, $value);
			break;
			case 'd':
				delete_option($option_name);
			break;
			default:
			case 'r':
				return get_option($option_name);
			break;
		}
	}

	/**
	 * CRUD in the option table
	 *
	 * c = create / add, u = Update, d = delete and default / r = read
	 *
	 * @return mix | array | bool
	 * */
	public function brokerid($action = '', $value = ''){
		$option_name = 'masterdigm_crm_api_brokerid';
		switch($action){
			case 'c':
				add_option($option_name, $value);
			break;
			case 'u':
				update_option($option_name, $value);
			break;
			case 'd':
				delete_option($option_name);
			break;
			default:
			case 'r':
				return get_option($option_name);
			break;
		}
	}

	/**
	 * CRUD in the option table
	 *
	 * c = create / add, u = Update, d = delete and default / r = read
	 *
	 * @return mix | array | bool
	 * */
	public function key($action = '', $value = ''){
		$option_name = 'masterdigm_crm_api_key';
		switch($action){
			case 'c':
				add_option($option_name, $value);
			break;
			case 'u':
				update_option($option_name, $value);
			break;
			case 'd':
				delete_option($option_name);
			break;
			default:
			case 'r':
				return get_option($option_name);
			break;
		}
	}

	/**
	 * CRUD in the option table
	 *
	 * c = create / add, u = Update, d = delete and default / r = read
	 *
	 * @return mix | array | bool
	 * */
	public function token($action = '', $value = ''){
		$option_name = 'masterdigm_crm_api_token';
		switch($action){
			case 'c':
				add_option($option_name, $value);
			break;
			case 'u':
				update_option($option_name, $value);
			break;
			case 'd':
				delete_option($option_name);
			break;
			default:
			case 'r':
				return get_option($option_name);
			break;
		}
	}

	public function delete_all(){
		$this->brokerid('d');
		$this->token('d');
		$this->key('d');
		$this->default_feed('d');
	}

	public function __construct(){}

}
$GLOBALS['mwp_crm'] = new Mwp_CRM_Model;
