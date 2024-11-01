<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Settings_Popup_Entity {
	protected static $instance = null;
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


	public function show_popup_choose(){
		return array(
			'1' => __('Turn on, show popup after certain clicks?', mwp_localize_domain()),
			'0' => __('Turn off, do not show popup after certain clicks?', mwp_localize_domain()),
		);
	}

	public function show_popup_close_button(){
		return array(
			'1' => __('Yes', mwp_localize_domain()),
			'0' => __('No', mwp_localize_domain()),
		);
	}

	public function show_popup_after(){
		return array(
			'1' => '1',
			'2' => '2',
			'3' => '3',
			'4' => '4',
			'5' => '5',
		);
	}

	public function __construct(){
		$this->popup_model = new Mwp_Settings_Popup_Model;
	}
}
