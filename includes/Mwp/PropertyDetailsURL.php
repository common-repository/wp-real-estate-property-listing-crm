<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Route for property details 
 * */
class Mwp_PropertyDetailsURL{
	/**
	 * instance of this class
	 *
	 * @since 3.12
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;
	protected $uri;
	public $mwp_plugin;
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
	
	public function config_property_details(){
		global $mwp;
		return $mwp['property_details'];
	}
	
	public function property_detail_url(){
		$config =  $this->config_property_details();
		return  $config['url'];
	}

	public function property_detail_uri_var(){
		global $mwp;
		return  $mwp['setup']['uri_query'];
	}
	
	/**
	 * setup the property url for single
	 * two options one is pretty link and one is ugly link
	 * @since    1.0.0
	 *
	 * @param    int    $matrix_id    matrix id of the property.
	 * @param    string | alpha numeric    $address    address of the property.
	 *
	 * @return url
	 * */
	public function get_property_url($url){
		$property_url =  $this->property_detail_url();
		if( get_option('permalink_structure') ){
			return home_url($property_url .'/'. $url);
		}
	}
	
	/**
	 * rewrite the property page to add query string such as address
	 * */
	public function load_rewrite_property(){
		$property_url =  $this->property_detail_url();
		$regex = '^'.$property_url.'/([^/]*)/?';
		$redirect = 'index.php?'.$this->property_detail_uri_var().'='.$property_url.'&url=$matches[1]';
		$after = 'top';
		add_rewrite_rule(
			$regex,
			$redirect,
			$after
		);
		add_rewrite_tag('%'.$this->property_detail_uri_var().'%', '([^&]+)');
		add_rewrite_tag('%url%', '([^&]+)');
	}
	

	public function route($arg = array()){
		global $plugin;

		$plugin->get_loader()->add_action(
			'init',
			$this,
			'load_rewrite_property'
		);
		$plugin->get_loader()->add_filter(
			'template_include',
			Mwp_Theme_PropertyDetails::get_instance(),
			'display'
		);
	}
	
	public function __construct(){}
}
