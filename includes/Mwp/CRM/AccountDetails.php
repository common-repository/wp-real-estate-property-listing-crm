<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm CRM Property Fields
 *
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_CRM_AccountDetails{
	protected static $instance = null;
	protected $account_details_data = null;
	protected $cache_prefix = 'mwp_cache_crm_account_details';
	/**
	 * instantiate the crm property class
	 * */
	protected $crm_adapter = null;
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
	 * Get all account detail by all data or individually
	 * @param	$key	string		default null, else grab the key result in account_details
	 * @return	array | object
	 * */
	public function get_account_data($key = null){
		$account_details = $this->account_details();
		if( isset($account_details->result) && $account_details->result == 'success' ){
			if( !is_null($key) ){
				if( $account_details->data && isset($account_details->data->$key) ){
					return $account_details->data->$key;
				}else{
					return false;
				}
			}else{
				if( $account_details && isset($account_details->data) ){
					return $account_details->data;
				}
			}
		}
		return false;
	}

	public function account_details(){
		$cache_prefix = $this->cache_prefix;
		if( mwp_cache_get($cache_prefix) ){
			return mwp_cache_get($cache_prefix);
		}else{
			$account = $this->crm_adapter->get_account_details();
			mwp_cache_set($cache_prefix, $account);
			return mwp_cache_get($cache_prefix);
		}
		return false;
	}
	
	public function agent_details($agent_id = null){
		$cache_prefix = $this->cache_prefix . '_agent_details_' . $agent_id;
		if( mwp_cache_get($cache_prefix) ){
			return mwp_cache_get($cache_prefix);
		}else{
			$agent_details = $this->crm_adapter->get_agent_details($agent_id);
			mwp_cache_set($cache_prefix, $agent_details);
			return mwp_cache_get($cache_prefix);
		}
		return false;
	}
	
	public function push_crm_data( $array_data ){
		extract($array_data);

		$userid 	= 0;
		$account_id = Mwp_CRM_AccountDetails::get_instance()->get_account_data('accountid');
		$this->crm_adapter->set_account_Id( $account_id );

		$get_userid = $this->get_account_data('userid');
		if( $get_userid ){
			$userid = $get_userid;
		}
		$data = array(
			'first_name'         => sanitize_text_field(isset($yourname)) ? sanitize_text_field($yourname):'',
			'last_name'          => sanitize_text_field(isset($yourlastname)) ? sanitize_text_field($yourlastname):'',
			'middle_name'        => sanitize_text_field(isset($yourmidname)) ? sanitize_text_field($yourmidname):'',
			'lead_source'        => mwp_get_lead_source(),
			'sourceid'        	 => mwp_get_lead_source(),
			'phone_home'         => sanitize_text_field(isset($phone_home)) ? sanitize_text_field($phone_home):'',
			'phone_mobile'       => sanitize_text_field(isset($phone_mobile)) ? sanitize_text_field($phone_mobile):'',
			'phone_work'         => sanitize_text_field(isset($phone_work)) ? sanitize_text_field($phone_work):'',
			'phone_fax'          => sanitize_text_field(isset($phone_fax)) ? sanitize_text_field($phone_fax):'',
			'email1'             => sanitize_text_field(isset($email1)) ? sanitize_text_field($email1):'',
			'address_street'     => sanitize_text_field(isset($address_street)) ? sanitize_text_field($address_street):'',
			'address_city'       => sanitize_text_field(isset($address_city)) ? sanitize_text_field($address_city):'',
			'address_state'      => sanitize_text_field(isset($address_state)) ? sanitize_text_field($address_state):'',
			'address_postalcode' => sanitize_text_field(isset($address_postalcode)) ? sanitize_text_field($address_postalcode):'',
			'address_country'    => sanitize_text_field(isset($address_country)) ? sanitize_text_field($address_country):'',
			'company'            => sanitize_text_field(isset($company)) ? sanitize_text_field($company):'',
			'assigned_to'		 => sanitize_text_field(isset($userid)) ? sanitize_text_field($userid):'',
			'note'				 => sanitize_text_field(isset($note)) ? sanitize_text_field($note):'',
			'source_url'		 => sanitize_text_field(isset($source_url)) ? sanitize_text_field($source_url):'',
			'lead_status'		 => mwp_get_lead_status(),
			'lead_type'			 => mwp_get_lead_type(),
		);

		$response   = $this->crm_adapter->save_lead($data);
		return $response;
	}
	
	public function __construct($crm_adapter = null){
		if( is_null($crm_adapter) ){
			$this->crm_adapter = new Mwp_CRM_Adapter;
		}else{
			$this->crm_adapter = $crm_adapter;
		}
	}
}
