<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Theme_Property_Entity {
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

	public function property_title(){
		return array(
			'address' => __('Address', mwp_localize_domain()),
			'tagline' => __('Tag Line', mwp_localize_domain()),
		);
	}

	public function show_bed(){
		return array(
			'y' => __('Yes', mwp_localize_domain()),
			'n' => __('No', mwp_localize_domain()),
		);
	}

	public function show_bath(){
		return array(
			'y' => __('Yes', mwp_localize_domain()),
			'n' => __('No', mwp_localize_domain()),
		);
	}

	public function show_garage(){
		return array(
			'y' => __('Yes', mwp_localize_domain()),
			'n' => __('No', mwp_localize_domain()),
		);
	}

	public function bookaviewing_align(){
		return array(
			'text-left' => __('Left', mwp_localize_domain()),
			'text-center' => __('Center', mwp_localize_domain()),
			'text-right' => __('Right', mwp_localize_domain()),
		);
	}

	public function __construct(){

	}
}
