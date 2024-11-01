<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Search_General_DBEntity{
	protected static $instance = null;
	protected $settings_search_model = null;
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

	public function get_form_title(){
		global $mwp;
		$default_data = $mwp['property_label'];
		$form_title = $default_data['search-title'];

		return $this->search_general_model->form_title('r', $form_title);
	}

	public function get_form_show_forsale_button(){
		global $mwp;
		$default_data = $mwp['search_settings_general'];
		$show_forsale_button = $default_data['show_forsale_button'];

		return $this->search_general_model->show_for_sale_button('r', $show_forsale_button);
	}

	public function get_form_show_forrent_button(){
		global $mwp;
		$default_data = $mwp['search_settings_general'];
		$show_forrent_button = $default_data['show_forrent_button'];

		return $this->search_general_model->show_for_rent_button('r', $show_forrent_button);
	}

	public function get_form_show_foreclosure_button(){
		global $mwp;
		$default_data = $mwp['search_settings_general'];
		$show_button = $default_data['show_foreclosure_button'];

		return $this->search_general_model->show_foreclosure_button('r', $show_button);
	}

	public function get_form_show_privatesales_button(){
		global $mwp;
		$default_data = $mwp['search_settings_general'];
		$show_button = $default_data['show_privatesales_button'];

		return $this->search_general_model->show_privatesales_button('r', $show_button);
	}

	public function get_form_show_tolet_button(){
		global $mwp;
		$default_data = $mwp['search_settings_general'];
		$show_button = $default_data['show_tolet_button'];

		return $this->search_general_model->show_tolet_button('r', $show_button);
	}

	public function get_search_property_status(){
		global $mwp;
		$default_data = $mwp['search_settings_general'];
		$status_search = $default_data['property_status'];

		$property_fields = new Mwp_CRM_PropertyFields($this->crm_adapter);
		$property_fields_status = $property_fields->get_field_status_by_val($status_search);

		return $this->search_general_model->search_status('r', $property_fields_status);
	}

	public function __construct(){
		$this->crm_adapter = new Mwp_CRM_Adapter;
		$this->search_general_model = new Mwp_Settings_Search_General_Model;
	}
}
