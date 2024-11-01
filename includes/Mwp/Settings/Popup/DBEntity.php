<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Popup_DBEntity{
	protected static $instance = null;
	protected $popup_db_entity = null;
	protected $default_popup_settings;
	protected $popup_model = null;
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

	public function get_popup_show(){
		$show_popup = $this->default_popup_settings['show_popup'];
		return $this->popup_model->popup_show('r', $show_popup);
	}

	public function get_popup_close(){
		$close_popup = $this->default_popup_settings['close_popup'];
		return $this->popup_model->popup_close('r', $close_popup);
	}

	public function get_popup_clicks(){
		$show_popup_after_certain_clicks = $this->default_popup_settings['show_popup_after_certain_clicks'];
		return $this->popup_model->popup_clicks('r', $show_popup_after_certain_clicks);
	}

	public function __construct(){
		global $mwp;
		$this->default_popup_settings = $mwp['settings_popup'];
		$this->popup_model = new Mwp_Settings_Popup_Model;
	}
}
