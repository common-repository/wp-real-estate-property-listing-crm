<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Theme_Layout_DBEntity {
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
	
	public function get_menu(){
		return $this->layout_model->mwp_menu();
	}

	public function get_logo(){
		$logo = mwp_get_account_data_key('company_logo');
		$img_logo = '';
		if( $logo && trim($logo != '') ){
			$img_logo = $logo;
		}
		return $this->layout_model->mwp_logo_img('r', $img_logo);
	}

	public function get_search_form(){
		return $this->layout_model->mwp_search_form();
	}

	public function get_custom_css(){
		return $this->layout_model->mwp_custom_css();
	}
	public function get_wp_header(){
		$header = mwp_header();
		return $this->layout_model->mwp_get_headers('r', $header);
	}
	public function get_wp_footer(){
		$footer = mwp_footer();
		return $this->layout_model->mwp_get_footers('r', $footer);
	}
		
	public function db_delete_all_options(){}
	
	public function __construct(){
		global $mwp;
		$this->mwp_config = $mwp;
		$this->layout_model = new Mwp_Theme_Layout_Model;
	}
}
