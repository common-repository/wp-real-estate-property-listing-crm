<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Admin_WidgetDashboard{
	protected static $instance = null;
	protected $admin_parent_menu = 'options.php';
	protected $admin_menu_slug = 'md-settings-account';
	protected $admin_url_slug = 'admin.php?page=';
	protected $admin_menu_page_title = 'CRM Credentials Settings';
	protected $admin_menu_title = 'CRM Credentials Settings';
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

	public function display_widget(){
		$data = array();
		$data['account_info'] = mwp_get_account_details();
		Mwp_View::get_instance()->admin_partials('dashboard/widget.php', $data);
	}
	
	public function add_dashboard_widget(){
		wp_add_dashboard_widget(
			'dashboard_cache_property_widget',
			'Masterdigm CRM API',
			array($this,'display_widget')
		);
	}
	
	public function __construct(){
		if( current_user_can('activate_plugins') ){
			add_action('wp_dashboard_setup', array( $this, 'add_dashboard_widget' ), 1000 );
			//$this->controller();
		}
	}
}

