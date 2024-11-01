<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Account_Settings extends Mwp_Base{
	protected static $instance = null;
	protected $crm_entity = null;
	protected $mwp_crm_adapter = null;
	protected $settings_account = null;
	protected $settings_crmkey = null;
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
	public function display_form(){
		$data =  array();
		$data['url_slug'] = $this->settings_account->get_admin_url_slug();
		$data['admin_menu_url'] = $this->settings_account->get_admin_menu_slug();
		$data['method'] = 'update_api';
		$data['api_feed'] = $this->crm_model->default_feed('r');
		$data['key'] = $this->crm_model->key('r');
		$data['token'] = $this->crm_model->token('r');
		$data['broker_id'] = $this->crm_model->brokerid('r');
		$data['crm_form'] = Mwp_View::get_instance()->admin_part_partials('settings/crmkey-form.php', $data);
		Mwp_View::get_instance()->admin_partials('account/settings/index.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_account($arg = array()){
		$this->display_form();
	}

	public function update_api(){
		$update = $this->crm_entity->put_update_api($_POST);
		$this->md_settings_account();
	}
		
	public function mwp_delete_all_cache(){
		//this is from the dashboard widget
		mwp_cache_clean();
		Mwp_Helpers_File::redirect_to(admin_url('/'));
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
		$this->crm_model = new Mwp_CRM_Model;
		$this->crm_entity = new Mwp_Admin_Settings_CRMkeyEntity;
		$this->mwp_crm_adapter = new Mwp_CRM_Adapter;
		$this->settings_account = new Mwp_Admin_Account_Settings;
		$this->settings_crmkey = new Mwp_Controllers_Settings_CRMkey;
	}
}
