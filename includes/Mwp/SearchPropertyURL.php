<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Route for search property
 * */
class Mwp_SearchPropertyURL{
	/**
	 * instance of this class
	 *
	 * @since 3.12
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;
	protected $uri;
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
	
	public function config(){
		global $mwp;
		return $mwp['search_settings_general'];
	}
	
	public function url(){
		$config =  $this->config();
		return  $config['search_property_url'];
	}

	public function uri_var(){
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
	public function get_url($url = ''){
		if( get_option('permalink_structure') ){
			return home_url($this->url() .'/'. $url);
		}
	}
	
	/**
	 * rewrite the property page to add query string such as address
	 * */
	public function load_rewrite_property(){
		$url =  $this->url();

		//pagination
		$pagination_regex = '^'.$url.'/page/([0-9]{1,})/?';
		$pagination_redirect = 'index.php?'.$this->uri_var().'='.$url.'&paged=$matches[1]';
		//echo $pagination_redirect;
		$pagination_after = 'top';
		add_rewrite_rule(
			$pagination_regex,
			$pagination_redirect,
			$pagination_after
		);
		$regex = '^'.$url.'/?';
		$redirect = 'index.php?'.$this->uri_var().'='.$url;
		$after = 'top';
		add_rewrite_rule(
			$regex,
			$redirect,
			$after
		);
		add_rewrite_tag('%'.$this->uri_var().'%', '([^&]+)');
		//add_rewrite_tag('%search%', '([^&]+)');
		//add_rewrite_endpoint( 'mwppage', EP_PERMALINK );
	}
	
	public function query_vars($query_vars ){
		$query_vars[] = 'mwppage';
		return $query_vars;
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
			Mwp_Theme_SearchResult::get_instance(),
			'display'
		);
	}
	
	public function __construct(){}
}
