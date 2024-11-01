<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Subscribe Masterdigm CRM
 * */
class Mwp_Subscribe_API{
	protected $model_subscribe = null;
	protected $http_api_args;
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
	public function get_transaction_key($arg = array()){
		//http://api.masterdigm.net/fkey?email={email}
		$email = '';
		if( isset($arg['email']) ){
			$email = $arg['email'];
		}

		$url = "http://mdapi.masterdigmpro.com/fkey?email={$email}";
		$response = wp_remote_get($url, $this->http_api_args);
		/*echo $url;
		mwp_dump($response);*/
		return $response;
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
	public function get_activate_transaction_key($arg = array()){
		//http://api.masterdigm.net/request/activation/code?k={key}&email=test37@mail.com&company={company}&first_name={first_name}&last_name={last_name}
		$key = '';
		if( isset($arg['k']) ){
			$key = $arg['k'];
		}
		$email = '';
		if( isset($arg['email']) ){
			$email = $arg['email'];
		}
		$company = '';
		if( isset($arg['company']) ){
			$company = $arg['company'];
		}
		$first_name = '';
		if( isset($arg['first_name']) ){
			$first_name = $arg['first_name'];
		}
		$last_name = '';
		if( isset($arg['last_name']) ){
			$last_name = $arg['last_name'];
		}

		$url = "http://mdapi.masterdigmpro.com/request/activation/code?k={$key}&email={$email}&company={$company}&first_name={$first_name}&last_name={$last_name}";
		$response = wp_remote_get($url, $this->http_api_args);
		/*echo $url;
		mwp_dump($response);*/
		return $response;
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
	public function get_activate_code($arg = array()){
		//http://api.masterdigm.net/activate?email={email}&activation_code={activation_code}
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
		$url = "http://mdapi.masterdigmpro.com/activate?email={$email}&activation_code={$activation_code}";
		$response 		= wp_remote_get($url, $this->http_api_args);
		/*echo $url;
		mwp_dump($response);*/
		return $response;
	}

	public function __construct(){
		$this->http_api_args = array(
			'timeout' => 100, 
			'redirection' => 100
		);
	}
}
