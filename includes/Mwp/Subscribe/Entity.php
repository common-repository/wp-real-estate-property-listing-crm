<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Subscribe Masterdigm CRM
 * */
class Mwp_Subscribe_Entity{
	protected $model_subscribe = null;
	protected $model_api = null;
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
	 * @param $arg array() possible elements
	 * k = the activation key - required
	 * email = email address - required
	 * company = name of the company
	 * first_name = first name
	 * last_name = last name
	 * */
	public function transaction_key($arg = array()){
		//http://api.masterdigm.net/fkey?email={email}
		$response = $this->model_api->get_transaction_key($arg);
		$email = $arg['email'];

		if( $response ){
			$response_code 	= wp_remote_retrieve_response_code( $response );
			$response_body = wp_remote_retrieve_body($response);
			$response_body = json_decode($response_body);
			if( $response_code == 200 ){
				if(
					$response_body
					&& isset($response_body->result)
					&& $response_body->result == 'success'
				){
					$this->model_subscribe->masterdigm_subscribe_transaction_key('u', $response_body->key);
					$this->model_subscribe->masterdigm_subscribe_step_1('u', 1);
					$this->model_subscribe->masterdigm_subscribe_email_used('u', $email);
					return true;
				}else{
					$this->model_subscribe->masterdigm_subscribe_step_1('u', 0);
					$this->model_subscribe->masterdigm_subscribe_transaction_key('u', 'fail');
					return false;
				}
			}else{
				$this->model_subscribe->masterdigm_subscribe_step_1('u', 0);
				$this->model_subscribe->masterdigm_subscribe_transaction_key('u', 'fail');
				return false;
			}
		}
		return false;
	}

	/**
	 * step two
	 * @param $arg array() possible elements
	 * k = the activation key - required
	 * email = email address - required
	 * company = name of the company
	 * first_name = first name
	 * last_name = last name
	 * */
	public function activate_transaction_key($arg = array()){
		//http://api.masterdigm.net/request/activation/code?k={key}&email=test37@mail.com&company={company}&first_name={first_name}&last_name={last_name}
		$response = $this->model_api->get_activate_transaction_key($arg);
		if( $response ){
			$response_code = wp_remote_retrieve_response_code( $response );
			$response_body = wp_remote_retrieve_body($response);
			$response_body = json_decode($response_body);
			if( $response_code == 200 ){
				if(
					$response_body
					&& isset($response_body->result)
					&& $response_body->result == 'success'
				){
					$this->model_subscribe->masterdigm_subscribe_send_activation_code('u', 1);
					$this->model_subscribe->masterdigm_subscribe_step_2('u', 1);
					$this->model_subscribe->masterdigm_subscribe_msg_step_2('u', $response_body->message);
					$step_2_data = array(
						'email' => $arg['email'],
						'company' => $arg['company'],
						'first_name' => $arg['first_name'],
						'last_name' => $arg['last_name'],
					);
					$this->model_subscribe->masterdigm_subscribe_step_2_data('u', $step_2_data);
					return true;
				}else{
					$this->model_subscribe->masterdigm_subscribe_step_2('u', 0);
					$this->model_subscribe->masterdigm_subscribe_msg_step_2('u', $response_body->message);
					return false;
				}
			}else{
				$this->model_subscribe->masterdigm_subscribe_step_2('u', 0);
				$this->model_subscribe->masterdigm_subscribe_msg_step_2('u', 'fail');
				return false;
			}
		}
		return false;
	}

	/**
	 * step three
	 * @param $arg array() possible elements
	 * k = the activation code - required
	 * email = email address - required
	 * company = name of the company
	 * first_name = first name
	 * last_name = last name
	 * */
	public function validate_activation_code($arg = array()){
		//http://api.masterdigm.net/activate?email={email}&activation_code={activation_code}
		$response = $this->model_api->get_activate_code($arg);

		if( $response ){
			$api_message 	= false;
			$api_result 	= false;
			$activation_code = '';
			if(
				isset($arg['activation_code'])
				&& trim($arg['activation_code']) != ''
			){
				$activation_code = $arg['activation_code'];
			}
			$email = '';
			if(
				isset($arg['email'])
				&& trim($arg['email']) != ''
			){
				$email = $arg['email'];
			}
			$response_code 	= wp_remote_retrieve_response_code( $response );
			$response_body = wp_remote_retrieve_body($response);
			$response_body = json_decode($response_body);
			if( $response_code == 200 ){
				if(
					$response_body
					&& isset($response_body->result)
					&& $response_body->result == 'success'
				){
					$data = array(
						'activation_code' => $activation_code,
						'data_result' => $response_body
					);
					$current_user 	= mwp_wp_get_current_user();
					$this->model_subscribe->masterdigm_subscribe_step_3('u', 1);
					$this->model_subscribe->masterdigm_subscribe_step_3_current_user('u', $current_user);
					$this->model_subscribe->masterdigm_subscribe_activation_code('u', $activation_code);
					$this->model_subscribe->masterdigm_subscribe_api_step_3('u', $data);
					$api_message = 'success';
					$api_result = true;
					$this->model_subscribe->masterdigm_subscribe_api_step_3_msg('u', $api_message);
					return true;
				}else{
					$data = $this->model_subscribe->masterdigm_subscribe_api_step_3('r');

					$api_message = $response_body->message;
					$api_message .= '<br> ' . __('Please check your email for your API Access and login', mwp_localize_domain());
					$api_message .= '<br><br> ' . __('Or you can input your CRM credentials on the right side form', mwp_localize_domain());
					$api_message .= '<br> ' . __('Here is your API Credentials:', mwp_localize_domain());
					$api_message .= '<br> ' . __('CRM Key', mwp_localize_domain()) . ': ' . $data['data_result']->api_access->key;
					$api_message .= '<br> ' . __('CRM Token', mwp_localize_domain()) . ': ' . $data['data_result']->api_access->token;
					$api_message .= '<br> ' . __('CRM Broker Id', mwp_localize_domain()) . ': ' . $data['data_result']->account_id;
					$this->model_subscribe->masterdigm_subscribe_api_step_3_msg('u', $api_message);
					return false;
				}
			}
		}
		return false;
	}

	public function __construct(){
		$this->model_subscribe = new Mwp_Subscribe_Model;
		$this->model_api = new Mwp_Subscribe_API;
	}
}
