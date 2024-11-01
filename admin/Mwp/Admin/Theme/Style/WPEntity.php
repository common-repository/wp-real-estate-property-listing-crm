<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Admin_Theme_Style_WPEntity{
	protected static $instance = null;
	protected $admin_parent_menu = 'options.php';
	protected $admin_menu_slug = 'md-settings-theme-style';
	protected $admin_url_slug = 'admin.php?page=';
	protected $admin_menu_page_title = 'Style';
	protected $admin_menu_title = 'Style';
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

	public function enqueue_scripts(){
		global $get_current_screen;
		global $mwp;

		$screen = get_current_screen();

		if( is_admin() && $screen->id == 'admin_page_md-settings-theme-style' ) {
			wp_register_style( 
				$mwp['setup']['plugin_name'] . '-mwp-color-picker-css',
				$mwp['plugin_path']['admin_url_path'] . 'colorpicker/css/colorpicker.css', 
				false, 
				$mwp['setup']['plugin_version']
			);
			wp_register_style( 
				$mwp['setup']['plugin_name'] . '-mwp-color-picker-layout',
				$mwp['plugin_path']['admin_url_path'] . 'colorpicker/css/layout.css', 
				false, 
				$mwp['setup']['plugin_version']
			);
			 wp_enqueue_style( $mwp['setup']['plugin_name'] . '-mwp-color-picker-css' );
			 wp_enqueue_style( $mwp['setup']['plugin_name'] . '-mwp-color-picker-layout' );
			// Add the color picker css file
			// Include our custom jQuery file with WordPress Color Picker dependency
			wp_enqueue_script(
				$mwp['setup']['plugin_name'] . '-mwp-color-picker',
				$mwp['plugin_path']['admin_url_path'] . 'colorpicker/js/colorpicker.js',
				array( 'jquery' ),
				$mwp['setup']['plugin_version'],
				true
			);
			wp_enqueue_script(
				$mwp['setup']['plugin_name'] . '-mwp-color-picker-eye',
				$mwp['plugin_path']['admin_url_path'] . 'colorpicker/js/eye.js',
				array( 'jquery' ),
				$mwp['setup']['plugin_version'],
				true
			);
			wp_enqueue_script(
				$mwp['setup']['plugin_name'] . '-mwp-color-picker-util',
				$mwp['plugin_path']['admin_url_path'] . 'colorpicker/js/utils.js',
				array( 'jquery' ),
				$mwp['setup']['plugin_version'],
				true
			);
			wp_enqueue_script(
				$mwp['setup']['plugin_name'] . '-md-wp-color-picker-style',
				$mwp['plugin_path']['admin_url_path'] . 'js/mwp-style.js',
				array( 'jquery' ),
				$mwp['setup']['plugin_version'],
				true
			);
		}
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
			array(Mwp_Controllers_Theme_Style::get_instance(), 'controller')
		);
	}

	public function __construct(){
	}
}
