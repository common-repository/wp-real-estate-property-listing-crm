<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Settings_Popup extends Mwp_Base{
	protected static $instance = null;
	protected $crm_entity = null;
	protected $mwp_crm_adapter = null;
	protected $settings_entity = null;
	protected $db_entity = null;
	protected $admin_popup_wpentity = null;
	protected $admin_popup_dbentity = null;
	protected $popup_dbentity = null;
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

	public function update_popup(){
		$this->admin_popup_dbentity->update_popup_data($_POST);
		$this->md_settings_popup();
	}

	/**
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function md_settings_popup(){
		$data = array();
		$tab_nav = $this->settings_entity->tab_nav();

		$data['url_slug'] = $this->admin_popup_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['model_popup'] = $this->popup_model;
		$data['show_popup_choose'] = $this->admin_popup_entity->show_popup_choose();
		$data['show_popup_close_button'] = $this->admin_popup_entity->show_popup_close_button();
		$data['show_popup_after'] = $this->admin_popup_entity->show_popup_after();
		$data['popup_show'] = $this->db_entity->get_popup_show();
		$data['popup_close'] = $this->db_entity->get_popup_close();
		$data['popup_clicks'] = $this->db_entity->get_popup_clicks();

		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('settings/settings-popup.php', $data);
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
		$this->admin_popup_wpentity = new Mwp_Admin_Settings_Popup_WPEntity;
		$this->admin_popup_entity = new Mwp_Admin_Settings_Popup_Entity;
		$this->admin_popup_dbentity = new Mwp_Admin_Settings_Popup_DBEntity;
		$this->popup_model = new Mwp_Settings_Popup_Model;
		$this->db_entity = new Mwp_Settings_Popup_DBEntity;
	}
}
