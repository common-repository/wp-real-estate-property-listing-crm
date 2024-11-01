<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Settings_CRMkey extends Mwp_Base{
	protected static $instance = null;
	protected $crm_entity = null;
	protected $mwp_crm_adapter = null;
	protected $subscribe_model = null;
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
	 * the method controller
	 * */
	public function update_api($input = array()){
		$error 		= array();
		$has_error 	= false;
		$arg 		= array();

		if( count($input) == 0 ){
			$input = $_POST;
		}
		if(
			( trim($input['settings_api_key']) == '' || trim($input['settings_api_token']) == '')
		){
			$has_error = true;
			$error[] = __('Please provide property CRM api token / key', mwp_localize_domain());
		}

		if(
			$input['settings_api_default_feed'] == '0'
		){
			$has_error = true;
			$error[] = __('Please choose data to feed', mwp_localize_domain());
		}

		if(
			$input['settings_api_broker_id'] == ''
		){
			$has_error = true;
			$error[] = __('Please provide Broker ID', mwp_localize_domain());
		}

		if( $has_error ){
			$this->set_input_error($error);
			$arg = array(
				'error' => $this->get_input_error(),
			);
		}else{
			$ret = $this->crm_entity->put_update_api($input);
			$arg = $ret;
			mwp_cache_clean();
			Mwp_Admin_CreatePage::get_instance()->create_property_page();
		}
		update_option('api_keys_changed', true);
		Mwp_Controllers_Setup::get_instance()->controller('index', $arg);
	}

	/**
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function display_form(){
		$data['url_slug'] = $this->crm_entity->get_admin_url_slug();
		$data['admin_menu_url'] = $this->crm_entity->get_admin_menu_slug();
		$data['api_feed'] = $this->crm_model->default_feed('r');
		$data['key'] = $this->crm_model->key('r');
		$data['token'] = $this->crm_model->token('r');
		$data['broker_id'] = $this->crm_model->brokerid('r');
		$data['crm_form'] = Mwp_View::get_instance()->admin_part_partials('settings/crmkey-form.php', $data);

		Mwp_View::get_instance()->admin_partials('settings/settings-crm.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_crm(){
		$this->display_form();
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
		$this->subscribe_model = new Mwp_Subscribe_Model;
	}
}
