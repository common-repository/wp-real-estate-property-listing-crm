<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Settings_Popup_DBEntity {
	protected static $instance = null;
	protected $popup_model = null;
	protected $default_popup_settings;
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

	public function update_popup_data($input = array()){
		$popup_show = sanitize_text_field( $input['masterdigm_popup_show'] );
		$popup_close = sanitize_text_field( $input['masterdigm_popup_close'] );
		$popup_clicks = sanitize_text_field( $input['masterdigm_popup_clicks'] );

		$this->popup_model->popup_show('u', $popup_show);
		$this->popup_model->popup_close('u', $popup_close);
		$this->popup_model->popup_clicks('u', $popup_clicks);
	}

	public function db_delete_all_options(){
		$this->popup_model->popup_show('d');
		$this->popup_model->popup_close('d');
		$this->popup_model->popup_clicks('d');
	}

	public function __construct(){
		global $mwp;
		$this->default_popup_settings = $mwp['settings_popup'];
		$this->popup_model = new Mwp_Settings_Popup_Model;
	}
}
