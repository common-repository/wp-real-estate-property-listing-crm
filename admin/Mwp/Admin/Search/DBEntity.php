<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Admin_Search_DBEntity{
	protected static $instance = null;
	protected $search_general_model = null;
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

	public function db_update_general_search($input = array()){
		global $mwp;

		$default_data = $mwp['search_settings_general'];

		$setting_search_title = $default_data['search_title'];
		if( isset($input['setting_search_title']) && trim($input['setting_search_title']) != '') {
			$setting_search_title = sanitize_text_field($input['setting_search_title']);
		}

		$search_forsale_button = $default_data['show_forsale_button'];
		if( isset($input['search_forsale_button']) ){
			$search_forsale_button = sanitize_text_field($input['search_forsale_button']);
		}

		$search_forrent_button = $default_data['show_forrent_button'];
		if( isset($input['search_forrent_button']) ){
			$search_forrent_button = sanitize_text_field($input['search_forrent_button']);
		}
		
		$show_foreclosure_button = $default_data['show_foreclosure_button'];
		if( isset($input['show_foreclosure_button']) ){
			$show_foreclosure_button = sanitize_text_field($input['show_foreclosure_button']);
		}
		
		$show_privatesales_button = $default_data['show_privatesales_button'];
		if( isset($input['show_privatesales_button']) ){
			$show_privatesales_button = sanitize_text_field($input['show_privatesales_button']);
		}
		
		$show_tolet_button = $default_data['show_tolet_button'];
		if( isset($input['show_tolet_button']) ){
			$show_tolet_button = sanitize_text_field($input['show_tolet_button']);
		}
		
		$search_status = null;
		if( isset($input['property_status']) 
			&& $input['property_status'] != ''
		){
			$search_status = $input['property_status'];
		}
		
		$this->db_update_search_property_status($search_status);
		$this->search_general_model->form_title('u', $setting_search_title);
		$this->search_general_model->show_for_sale_button('u', $search_forsale_button);
		$this->search_general_model->show_for_rent_button('u', $search_forrent_button);
		$this->search_general_model->show_foreclosure_button('u', $show_foreclosure_button);
		$this->search_general_model->show_privatesales_button('u', $show_privatesales_button);
		$this->search_general_model->show_tolet_button('u', $show_tolet_button);
	}



	public function db_update_search_property_status($status_id = null){
		global $mwp;

		$default_data = $mwp['search_settings_general'];

		if( is_null($status_id) ){
			$status_search = $default_data['property_status'];
			$property_fields = new Mwp_CRM_PropertyFields($this->crm_adapter);
			$property_fields_status = $property_fields->get_field_status_by_val($status_search);
		}else{
			$property_fields_status = $status_id;
		}

		return $this->search_general_model->search_status('u', $property_fields_status);
	}

	public function delete_all(){
		$this->settings_search_model->search_status('d');
		$this->settings_search_model->form_title('d');
		$this->settings_search_model->show_for_sale_button('d');
		$this->settings_search_model->show_for_rent_button('d');
	}

	public function __construct(){
		$this->crm_adapter = new Mwp_CRM_Adapter;
		$this->search_general_model = new Mwp_Settings_Search_General_Model;
	}
}


