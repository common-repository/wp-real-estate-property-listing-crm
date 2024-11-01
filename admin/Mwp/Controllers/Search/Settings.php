<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Search_Settings extends Mwp_Base{
	protected static $instance = null;
	protected $crm_entity = null;
	protected $mwp_crm_adapter = null;
	protected $search_admin_entity = null;
	protected $search_general_model = null;
	protected $admin_search_general_dbentity = null;
	protected $search_admin_wpentity = null;
	protected $property_fields = null;
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
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function index(){
		$data =  array();
		$tab_nav = $this->search_admin_entity->tab_nav();
		$data['url_slug'] = $this->search_admin_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];

		$data['arr_show_button_forsale'] = $this->search_admin_entity->arr_show_button_forrent();
		$data['arr_show_button_forrent'] = $this->search_admin_entity->arr_show_button_forrent();
		$data['arr_show_button_foreclosure'] = $this->search_admin_entity->arr_show_button_foreclosure();
		$data['arr_show_button_privatesales'] = $this->search_admin_entity->arr_show_button_privatesales();
		$data['arr_show_button_tolet'] = $this->search_admin_entity->arr_show_button_tolet();
		$data['arr_show_property_status'] = $this->search_admin_entity->arr_show_button_forrent();
		$property_fields = new Mwp_CRM_PropertyFields($this->crm_adapter);
		$data['arr_property_fields_status'] = $property_fields->get_field_status();

		$data['db_show_button_forsale'] = $this->search_dbentity->get_form_show_forsale_button();
		$data['db_show_button_forrent'] = $this->search_dbentity->get_form_show_forrent_button();
		$data['db_show_button_foreclosure'] = $this->search_dbentity->get_form_show_foreclosure_button();
		$data['db_show_button_privatesales'] = $this->search_dbentity->get_form_show_privatesales_button();
		$data['db_show_button_tolet'] = $this->search_dbentity->get_form_show_tolet_button();
		$data['db_property_fields_status'] = $this->search_dbentity->get_search_property_status();

		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('search/settings/settings-general.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_search(){
		$this->index();
	}
	/**
	 * update
	 * */
	public function update_general(){
		$this->admin_search_general_dbentity->db_update_general_search($_POST);
		$this->index();
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
		$this->crm_adapter = new Mwp_CRM_Adapter;
		$this->search_admin_entity = new Mwp_Admin_Search_Settings;
		$this->search_general_model = new Mwp_Settings_Search_General_Model;
		$this->admin_search_general_entity = new Mwp_Admin_Search_Settings;
		$this->admin_search_general_dbentity = new Mwp_Admin_Search_DBEntity;
		$this->search_admin_wpentity = new Mwp_Admin_Search_WPEntity;
		$this->search_dbentity = new Mwp_Settings_Search_General_DBEntity;
	}
}
