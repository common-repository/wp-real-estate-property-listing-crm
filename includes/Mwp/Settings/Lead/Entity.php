<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Lead_Entity{
	protected static $instance = null;
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

	public function get_lead_status(){
		$account = new Mwp_CRM_AccountDetails($this->crm_adapter);
		$lead_status = $account->get_account_data('lead_status');
		return $lead_status;
	}

	public function get_lead_type(){
		$account = new Mwp_CRM_AccountDetails($this->crm_adapter);
		$lead_type = $account->get_account_data('lead_type');
		return $lead_type;
	}

	public function get_lead_source(){
		$account = new Mwp_CRM_AccountDetails($this->crm_adapter);
		$lead_source = $account->get_account_data('lead_source');
		return $lead_source;
	}

	public function __construct(){
		$this->crm_adapter = new Mwp_CRM_Adapter;
	}
}
