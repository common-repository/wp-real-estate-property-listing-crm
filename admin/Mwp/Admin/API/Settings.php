<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Admin_API_Settings{
	protected static $instance = null;
	protected $theme_admin_wpentity = null;
	protected $theme_admin_property_wpentity = null;
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

	public function tab_nav(){
		$data =  array();
		$current_tab = Mwp_Admin_TabNav::get_instance()->get_current_tab_nav();
		$data['default_tab'] = 'property';
		if( !$current_tab ){
			$data['tab'] = 'api/social-api.php';
			$data['url_slug'] = $this->theme_admin_property_wpentity->get_admin_url_slug();
			$data['_tab'] = $data['default_tab'];
		}else{
			$data['tab'] = 'api/' . $current_tab . '.php';
			$data['_tab'] = $current_tab;
		}

		$get_page = '';
		if(
			isset($_GET['page'])
			&& sanitize_text_field($_GET['page']) != ''
		){
			$get_page = $_GET['page'];
		}
		$data['current_plugin_page'] = admin_url( 'admin.php?page=' . $get_page );
		$data['tab_nav'] = array('current_plugin_page' => $data['current_plugin_page'], 'default_tab' => $data['default_tab']);
		$data['tab_nav_template'] = 'api/tab-nav.php';

		return $data;
	}


	public function __construct(){
		$this->theme_admin_wpentity = new Mwp_Admin_API_WPEntity;
		$this->theme_admin_property_wpentity = new Mwp_Admin_API_Social_WPEntity;
	}
}


