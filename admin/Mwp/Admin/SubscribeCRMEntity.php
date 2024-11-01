<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Subscribe for CRM Credentials Key
 * */
class Mwp_Admin_SubscribeCRMEntity{
	protected static $instance = null;
	protected $subscribe_api = null;
	protected $subscribe_model = null;
	protected $admin_parent_menu = 'options.php';
	protected $admin_menu_slug = 'md-subscribe-api';
	protected $admin_menu_page_title = 'Subscribe Masterdigm API';
	protected $admin_menu_title = 'Subscribe Masterdigm API';
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
			array(Mwp_Controllers_SubscribeCRM::get_instance(), 'controller')
		);
	}

	public function __construct(){}
}
