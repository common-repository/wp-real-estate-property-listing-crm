<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Settings_Clientlead_DBEntity {
	protected static $instance = null;
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

	public function update_lead($input = array()){
		$lead_status = 1;
		if( isset($input['lead_status']) 
			&& $input['lead_status'] != ''
		){
			$lead_status = $input['lead_status'];
		}
		$lead_type = 1;
		if( isset($input['lead_type']) 
			&& $input['lead_type'] != ''
		){
			$lead_type = $input['lead_type'];
		}
		$lead_source = 1;
		if( isset($input['lead_source']) 
			&& $input['lead_source'] != ''
		){
			$lead_source = $input['lead_source'];
		}
		$this->lead_model->lead_status('u', $lead_status);
		$this->lead_model->lead_type('u', $lead_type);
		$this->lead_model->lead_source('u', $lead_source);
	}

	public function __construct(){
		$this->lead_model = new Mwp_Settings_Lead_Model;
	}
}
