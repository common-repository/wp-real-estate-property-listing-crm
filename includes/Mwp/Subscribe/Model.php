<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Subscribe Masterdigm CRM
 * */
class Mwp_Subscribe_Model{
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

	public function masterdigm_subscribe_transaction_key($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_transaction_key';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_step_1($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_step_1';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_email_used($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_email_used';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_send_activation_code($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_send_activation_code';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_step_2($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_step_2';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_msg_step_2($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_msg_step_2';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_step_2_data($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_step_2_data';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_step_3($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_step_3';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_step_3_current_user($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_step_3_current_user';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_activation_code($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_activation_code';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_api_step_3($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_api_step_3';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_api_step_3_msg($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_api_step_3_msg';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function masterdigm_subscribe_api_finish($action = '', $value = ''){
		$prefix = 'masterdigm_subscribe_api_finish';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix);
			break;
		}
	}

	public function delete_all(){
		$this->masterdigm_subscribe_api_finish('d');
		$this->masterdigm_subscribe_api_step_3_msg('d');
		$this->masterdigm_subscribe_api_step_3('d');
		$this->masterdigm_subscribe_activation_code('d');
		$this->masterdigm_subscribe_step_3_current_user('d');
		$this->masterdigm_subscribe_step_3('d');
		$this->masterdigm_subscribe_step_2_data('d');
		$this->masterdigm_subscribe_msg_step_2('d');
		$this->masterdigm_subscribe_step_2('d');
		$this->masterdigm_subscribe_send_activation_code('d');
		$this->masterdigm_subscribe_email_used('d');
		$this->masterdigm_subscribe_step_1('d');
		$this->masterdigm_subscribe_transaction_key('d');
	}
}
