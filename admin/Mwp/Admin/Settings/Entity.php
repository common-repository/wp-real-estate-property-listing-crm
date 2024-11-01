<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Admin_Settings_Entity{
	protected static $instance = null;
	protected $admin_menu_slug = 'md-settings';
	protected $admin_url_slug = 'admin.php?page=';
	protected $admin_menu_page_title = 'General Settings';
	protected $admin_menu_title = 'General Settings';
	protected $admin_menu_capability = 'manage_options';
	protected $admin_popup_entity = null;
	protected $admin_popup_wpentity = null;
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
		$data['default_tab'] = 'popup';
		if( $current_tab == '' ){
			$data['tab'] = 'settings/settings-popup.php';
			$data['url_slug'] = $this->admin_popup_wpentity->get_admin_url_slug();
			$data['_tab'] = $data['default_tab'];
		}else{
			$data['tab'] = 'settings/' . $current_tab . '.php';
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
		$data['tab_nav_template'] = 'settings/tab-nav.php';

		return $data;
	}

	/**
	 * get form url
	 * */
	public function get_admin_url_slug(){
		return mwp_admin_url() . $this->admin_menu_slug;
	}
	/**
	 * url for the submenu
	 * */
	public function get_admin_menu_slug(){
		return $this->admin_menu_slug;
	}

	public function add_submenu_page(){
		add_submenu_page(
			mwp_plugin_name(),
			$this->admin_menu_page_title,
			$this->admin_menu_title,
			$this->admin_menu_capability,
			$this->admin_popup_wpentity->admin_menu_slug(),
			array(Mwp_Controllers_Settings_Popup::get_instance(), 'controller')
		);
	}

	public function __construct(){
		$this->admin_popup_entity = new Mwp_Admin_Settings_Popup_Entity;
		$this->admin_popup_wpentity = new Mwp_Admin_Settings_Popup_WPEntity;
	}
}
