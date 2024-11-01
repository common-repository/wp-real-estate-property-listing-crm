<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Settings_Jspluginlib extends Mwp_Base{
	protected static $instance = null;
	protected $admin_jspluginlib_entity = null;
	protected $jspluginlib_entity = null;
	protected $jspluginlib_model = null;
	protected $settings_entity = null;
	protected $admin_jspluginlib_wpentity = null;
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

	public function update_jspluginlib(){
		$post_jspluginlib = array();
		if( isset($_POST['jspluginlib']) ){
			$post_jspluginlib = $_POST['jspluginlib'];
		}
		$input_jsplugin_lib = $this->admin_jspluginlib_entity->get_checked_input_jsplugin_lib($post_jspluginlib);

		$this->jspluginlib_model->jsplugin_lib('u', $input_jsplugin_lib);
		$this->md_settings_jspluginlib();
	}

	/**
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function md_settings_jspluginlib(){
		global $mwp;
		$data = array();
		$tab_nav = $this->settings_entity->tab_nav();
		$data['_tab'] = $tab_nav['_tab'];
		$data['url_slug'] = $this->admin_jspluginlib_wpentity->get_admin_url_slug() . '&tab=' . $data['_tab'];
		$data['jspluginlib'] = $mwp['jsplugin-library-script'] + $mwp['jsplugin-library-css'];
		$data['db_jspluginlib'] = array_keys($this->jspluginlib_model->jsplugin_lib('r'));

		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('settings/settings-jsplugin-library.php', $data);
	}

	/**
	 * Controller
	 *
	 * @param	$action		string | empty
	 * @parem	$arg		array
	 * 						optional, pass data for controller
	 * @return mix
	 * */
	public function controller($action = '', $arg = array()){
		$this->call_method($this, $action);
	}

	public function __construct(){
		$this->settings_entity = new Mwp_Admin_Settings_Entity;
		$this->admin_jspluginlib_entity = new Mwp_Admin_Settings_Jspluginlib_Entity;
		$this->admin_jspluginlib_wpentity = new Mwp_Admin_Settings_Jspluginlib_WPEntity;
		$this->jspluginlib_entity = new Mwp_Settings_Jspluginlib_Entity;
		$this->jspluginlib_model = new Mwp_Settings_Jspluginlib_Model;
	}
}
