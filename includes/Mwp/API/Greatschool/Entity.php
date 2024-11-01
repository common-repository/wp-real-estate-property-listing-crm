<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm CRM Client Lead
 *
 * this for the lead that is pushing to masterdigm crm
 * */
class Mwp_API_Greatschool_Entity{
	protected static $instance = null;
	public $submenu_link = 'md-api-admin-greatschool';
	public $controller = null;
	public $api = null;
	public $uri_nearby = 'http://api.greatschools.org/schools/nearby';
	public $http_api_args;
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

	public function add_admin_sub_menu(){
		add_submenu_page(
			PLUGIN_NAME,
			__('Greatschool API', PLUGIN_NAME),
			__('Greatschool API', PLUGIN_NAME),
			'manage_options',
			$this->submenu_link,
			array( $this->controller, 'controller' )
		);
	}

	public function school_nearby($arg = array()){
		$state = null;
		if( isset($arg['state']) ){
			$state = $arg['state'];
		}
		$address = null;
		if( isset($arg['address']) ){
			$address = $arg['address'];
		}
		$url = $this->uri_nearby . '?key=' . $this->api . '&address=' . urlencode($address) . '&state=' . $state;
		$ret = $this->parse_xml($url);
		if( $ret && count($ret->children()) > 0 ){
			return $ret;
		}
		return false;
	}

	public function parse_xml($url){
		if( @simplexml_load_file($url) !== false ){
			return simplexml_load_file($url);
		}
		return false;
	}

	public function api_url($url){
		$school = wp_remote_get($url, $this->http_api_args);
		$header = wp_remote_retrieve_headers($school);
		$res = wp_remote_retrieve_response_code($school);
		if( $res == 200 ){
			return true;
		}
		return false;
	}

	public function __construct(){
		$this->model = new Mwp_API_Greatschool_Model;
		$this->api = $this->model->md_greatschool_api_key('r');
		$this->http_api_args = array(
			'timeout' => 100, 
			'redirection' => 100
		);
	}
}

