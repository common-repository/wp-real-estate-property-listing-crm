<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Lead_DBEntity{
	protected static $instance = null;
	protected $crm_adapter = null;
	protected $lead_entity = null;
	protected $lead_model = null;
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
		$crm_lead_status = $this->lead_entity->get_lead_status();
		return $this->lead_model->lead_status('r', $crm_lead_status);
	}

	public function get_lead_type(){
		$crm_lead_type = $this->lead_entity->get_lead_type();
		return $this->lead_model->lead_type('r', $crm_lead_type);
	}

	public function get_lead_source(){
		$crm_lead_source = $this->lead_entity->get_lead_source();
		return $this->lead_model->lead_source('r', $crm_lead_source);
	}

	public function __construct(){
		$this->crm_adapter = new Mwp_CRM_Adapter;
		$this->lead_entity = new Mwp_Settings_Lead_Entity;
		$this->lead_model = new Mwp_Settings_Lead_Model;
	}
}
