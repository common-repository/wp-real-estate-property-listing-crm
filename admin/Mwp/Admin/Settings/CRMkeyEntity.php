<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Admin_Settings_CRMkeyEntity {
	protected static $instance = null;
	protected $admin_parent_menu = 'options.php';
	protected $admin_menu_slug = 'md-settings-crm';
	protected $admin_url_slug = 'admin.php?page=';
	protected $admin_menu_page_title = 'Subscribe Masterdigm API';
	protected $admin_menu_title = 'Subscribe Masterdigm API';
	protected $admin_menu_capability = 'manage_options';
	protected $admin_search_dbentity = null;
	
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
	 * process and update api credentials
	 * */
	public function put_update_api($input = array()){
		$crm_cred = array(
			'key' => $input['settings_api_key'],
			'token' => $input['settings_api_token'],
			'endpoint' => mwp_crm_api_endpoint(),
			'version' => mwp_crm_api_version(),
		);
		$client = $this->mwp_crm_adapter;
		$client->set_client($crm_cred);
		$test_connection = $client->test_connection();
		//mwp_dump($test_connection,1);//ok
		$fields = new Mwp_CRM_PropertyFields($this->mwp_crm_adapter);
		//mwp_dump($fields,1);
		if( isset($test_connection->result) && $test_connection->result == 'success' ){
			//clear cache first
			mwp_cache_clean();
			
			//mwp_dump($input);
			//mwp_dump($fields,1);
			//save crm credentials to db
			$key = sanitize_text_field($input['settings_api_key']);
			$token = sanitize_text_field($input['settings_api_token']);
			$broker_id = sanitize_text_field($input['settings_api_broker_id']);
			$default_feed = sanitize_text_field($input['settings_api_default_feed']);
			$this->crm_model->key('u', $key);
			$this->crm_model->token('u', $token);
			$this->crm_model->brokerid('u', $broker_id);
			$this->crm_model->default_feed('u', $default_feed);

			//auto create settings
			$this->admin_search_dbentity->db_update_search_property_status();
			$property_settings = new Mwp_Admin_Search_DBEntity;
			$property_settings->db_update_general_search();

			$client_lead_settings = new Mwp_Admin_Settings_Clientlead_DBEntity;
			$client_lead_settings->update_lead();
			
			$theme_setup = new Mwp_Admin_Theme_Property_DBEntity;
			$theme_setup->db_update();
			$this->subscribe_model->masterdigm_subscribe_api_finish('u', 1);
			return true;
		}else{
			$has_error = true;
			$msg = __('CRM Credentials mismatch', mwp_localize_domain());
			$error[] = $msg;
			$arg = array(
				'error' => $error,
			);
			return $arg;
		}
		return false;
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
			array(Mwp_Controllers_Settings_CRMkey::get_instance(), 'controller')
		);
	}

	public function __construct(){
		$this->crm_model = new Mwp_CRM_Model;
		$this->mwp_crm_adapter = new Mwp_CRM_Adapter;
		$this->subscribe_model = new Mwp_Subscribe_Model;
		$this->admin_search_dbentity = new Mwp_Admin_Search_DBEntity;
	}
}
