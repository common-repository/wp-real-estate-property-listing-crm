<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Settings_Jspluginlib_Entity {
	protected static $instance = null;
	protected $admin_parent_menu = 'options.php';
	protected $admin_menu_slug = 'md-settings-jspluginlib';
	protected $admin_url_slug = 'admin.php?page=';
	protected $admin_menu_page_title = 'JS Plugin Library';
	protected $admin_menu_title = 'JS Plugin Library';
	protected $admin_menu_capability = 'manage_options';
	protected $jspluginlib_model = null;
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

	public function get_checked_input_jsplugin_lib($input = array()){
		global $mwp;

		$db_jspluginlib = array();
		$form_input = array_keys($input);
		$jspluginlib = $mwp['jsplugin-library-script'] + $mwp['jsplugin-library-css'];
		foreach($jspluginlib as $key => $val){
			if(in_array($key, $form_input) ){
				$db_jspluginlib[$key] = $jspluginlib[$key];
			}
		}
		return $db_jspluginlib;
	}

	public function default_jsplugin_lib(){
		global $mwp;

		if( !$this->jspluginlib_model->jsplugin_lib('r') ){
			//pre populate
			$jspluginlib = $mwp['jsplugin-library-script'] + $mwp['jsplugin-library-css'];
			$this->jspluginlib_model->jsplugin_lib('u', $jspluginlib);
		}
	}


	public function __construct(){
		$this->jspluginlib_model = new Mwp_Settings_Jspluginlib_Model;
	}
}
