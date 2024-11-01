<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm Model Entity
 *
 * @since
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_Admin_MasterdigmEntity{
	protected static $instance = null;
	protected $admin_menu_page_title = 'Masterdigm Real Estate';
	protected $admin_menu_title = 'Masterdigm Real Estate';
	protected $admin_menu_capability = 'manage_options';
	protected $admin_menu_position = '66';
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

	public function admin_menu(){
		add_menu_page(
			$this->admin_menu_page_title,
			$this->admin_menu_title,
			$this->admin_menu_capability,
			mwp_plugin_name(),
			array(Mwp_Controllers_Masterdigm::get_instance(), 'controller'),
			plugins_url( mwp_folder_name() . '/assets/md-dashicon.png'),
			$this->admin_menu_position
		);
	}

	public function __construct(){}
}
