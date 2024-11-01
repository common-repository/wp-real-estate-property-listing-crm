<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Settings_Popup_WPEntity {
	protected static $instance = null;
	protected $admin_parent_menu = 'options.php';
	protected $admin_menu_slug = 'md-settings-popup';
	protected $admin_url_slug = 'admin.php?page=';
	protected $admin_menu_page_title = 'Popup';
	protected $admin_menu_title = 'Popup';
	protected $admin_menu_capability = 'manage_options';

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

	public function admin_menu_page_title(){
		return $this->admin_menu_page_title;
	}

	public function admin_menu_slug(){
		return $this->admin_menu_slug;
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
			$this->admin_parent_menu,
			$this->admin_menu_page_title,
			$this->admin_menu_title,
			$this->admin_menu_capability,
			$this->admin_menu_slug,
			array(Mwp_Controllers_Settings_Popup::get_instance(), 'controller')
		);
	}

	public function __construct(){}
}
