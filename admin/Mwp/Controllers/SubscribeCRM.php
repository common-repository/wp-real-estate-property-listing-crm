<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Subscribe for CRM Credentials Key
 * */
class Mwp_Controllers_SubscribeCRM extends Mwp_Base{
	protected static $instance = null;
	protected $subscribe_api = null;
	protected $subscribe_model = null;
	protected $subscribe_admin_model_entity = null;
	protected $mwp_crm_adapter = null;
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

	public function subscribe_api_key($input = null){
		if( is_null($input) ){
			$input = $_POST;
		}

		$email 		= '';
		$error 		= array();
		$has_error 	= false;
		$arg 		= array();

		if(
			isset($input['email'])
			&& is_email($input['email'])
			&& trim($input['email']) != ''
		){
			$email = $input['email'];
		}else{
			$has_error = true;
			$error[] = __('Please provide valid email address', mwp_localize_domain());
		}
		$company = '';
		if( isset($input['company']) ){
			$company = $input['company'];
		}
		$first_name = '';
		if( isset($input['first_name']) ){
			$first_name = $input['first_name'];
		}
		$last_name = '';
		if( isset($input['last_name']) ){
			$last_name = $input['last_name'];
		}
		if( $has_error ){
			$this->set_input_error($error);
			$arg = array(
				'error' => $this->get_input_error(),
			);
		}else{
			//process
			$arg_subscribe_data = array(
				'email' => $email,
				'company' => $company,
				'first_name' => $first_name,
				'last_name' => $last_name,
			);
			$transaction_key = $this->subscribe_entity->transaction_key($arg_subscribe_data);

			if( $transaction_key ){
				$arg_subscribe_data['k'] = $this->subscribe_model->masterdigm_subscribe_transaction_key('r');
				$activate = $this->subscribe_entity->activate_transaction_key($arg_subscribe_data);
				if(
					$activate
					&& $this->subscribe_model->masterdigm_subscribe_step_2('r')
					&& $this->subscribe_model->masterdigm_subscribe_step_2('r') == 1
				){
					$msg = $this->subscribe_model->masterdigm_subscribe_msg_step_2('r');
					$arg = array(
						'info' => $msg,
					);
				}else{
					$has_error = true;
					$error[] = $this->subscribe_model->masterdigm_subscribe_msg_step_2('r');
					$this->set_input_error($error);
					$arg = array(
						'error' => $this->get_input_error(),
					);
				}
			}else{
				$has_error = true;
				$error[] = __('Error in transaction key, please try again', mwp_localize_domain());
				$this->set_input_error($error);
				$arg = array(
					'error' => $this->get_input_error(),
				);
			}
		}
		Mwp_Controllers_Setup::get_instance()->controller('index', $arg);
	}

	public function activate_code($input = null){
		if( is_null($input) ){
			$input = $_POST;
		}
		$error 		= array();
		$has_error 	= false;
		$activate_error = false;
		$activation_code = '';

		if(
			isset($input['activation_code'])
			&& $input['activation_code'] != ''
		){
			$activation_code = $input['activation_code'];
		}
		$arg = array(
			'activation_code' => $activation_code,
			'email' => $this->subscribe_model->masterdigm_subscribe_email_used('r')
		);

		if(
			$this->subscribe_model->masterdigm_subscribe_step_2('r')
			&& $this->subscribe_model->masterdigm_subscribe_step_2('r') == 1
		){

			$activate_code 	= $this->subscribe_entity->validate_activation_code($arg);

			if( $activate_code ){
				$step_3 = $this->subscribe_model->masterdigm_subscribe_step_3('r');
				$step_3_data = $this->subscribe_model->masterdigm_subscribe_api_step_3('r');
				$step_3_activation_code = $this->subscribe_model->masterdigm_subscribe_activation_code('r');
				$step_3_who_activate = $this->subscribe_model->masterdigm_subscribe_step_3_current_user('r');
			
				//step 3
				if(
					$step_3
					&& $step_3 == 1
				){
					$data = $this->subscribe_model->masterdigm_subscribe_api_step_3('r');
					
					if( $data['data_result'] && $data['data_result']->result == 'success' ){
						$api = new Mwp_CRM_Model;

						$key = $data['data_result']->api_access->key;
						$token = $data['data_result']->api_access->token;
						$account_id = $data['data_result']->account_id;

						//auto add default settings setup
						$crm_cred = array(
							'key' => $key,
							'token' => $token,
							'endpoint' => mwp_crm_api_endpoint(),
							'version' => mwp_crm_api_version(),
						);
						$client = $this->mwp_crm_adapter;
						$client->set_client($crm_cred);
						$test_connection = $client->test_connection();
						
						if( isset($test_connection->result) && $test_connection->result == 'success' ){
							mwp_cache_clean();
							//save the crm credentials
							$api->key('u', $key);
							$api->token('u', $token);
							$api->brokerid('u', $account_id);
							$api->default_feed('u', 'crm');

							//auto create settings
							$this->admin_search_dbentity->db_update_search_property_status();

							$property_settings = new Mwp_Admin_Search_DBEntity;
							$property_settings->db_update_general_search();

							$client_lead_settings = new Mwp_Admin_Settings_Clientlead_DBEntity;
							$client_lead_settings->update_lead();
							
							$theme_setup = new Mwp_Admin_Theme_Property_DBEntity;
							$theme_setup->db_update();
							
							//create pages
							Mwp_Admin_CreatePage::get_instance()->create_property_page();
							
							//finish setup
							$this->subscribe_model->masterdigm_subscribe_api_finish('u', 1);
						}
					}else{
						$has_error = true;
						$msg = __e('CRM Credentials mismatch', mwp_localize_domain());
						$error[] = $msg;
						$this->set_input_error($error);
						$arg = array(
							'error' => $this->get_input_error(),
						);
					}
				}
			}else{
				$activate_error = true;
				$has_error = true;
				$msg = $this->subscribe_model->masterdigm_subscribe_api_step_3_msg('r');
				$error[] = $msg;
				$this->set_input_error($error);
				$arg = array(
					'error' => $this->get_input_error(),
				);
			}
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
		$data['current_user'] = mwp_wp_get_current_user();
		$data['url_slug'] = $this->subscribe_admin_model_entity->get_admin_url_slug();

		Mwp_View::get_instance()->admin_partials('subscribe/forms.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_subscribe_api(){
		
		$this->display_form();
	}

	/**
	 * Controller
	 *
	 * @param	$action		string | empty
	 * @return mix
	 * */
	public function controller($action = '', $arg = array()){
		$this->call_method($this, $action);
	}

	public function __construct(){
		$this->admin_search_dbentity = new Mwp_Admin_Search_DBEntity;
		$this->subscribe_api = new Mwp_Subscribe_API;
		$this->subscribe_model = new Mwp_Subscribe_Model;
		$this->subscribe_admin_model_entity = new Mwp_Admin_SubscribeCRMEntity;
		$this->subscribe_entity = new Mwp_Subscribe_Entity;
		$this->mwp_crm_adapter = new Mwp_CRM_Adapter;
	}
}
