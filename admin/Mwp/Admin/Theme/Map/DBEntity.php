<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Theme_Map_DBEntity {
	protected static $instance = null;
	protected $mwp_config;
	protected $theme_model = null;
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
	
	public function get_geocode_address(){
		$geo_address = mwp_get_account_address();
		return $this->map_model->mwp_geo_address('r', $geo_address);
	}

	public function get_mwp_zoom(){
		return $this->map_model->mwp_map_zoom('r', 10);
	}
			
	public function db_delete_all_options(){}
	
	public function __construct(){
		global $mwp;
		$this->mwp_config = $mwp;
		$this->map_model = new Mwp_Theme_Map_Model;
	}
}
