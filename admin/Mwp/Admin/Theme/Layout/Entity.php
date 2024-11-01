<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Theme_Layout_Entity {
	protected static $instance = null;
	protected $popup_model = null;
	protected $admin_db_entity = null;
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
	
	public function wp_get_nav_menus(){
		$menus = wp_get_nav_menus();
		$mwp_menus = array();
		if( $menus ){
			foreach($menus as $key => $val){
				$mwp_menus[$val->slug] = $val->name;
			}
			return $mwp_menus; 
		}
		return false; 
	}
	
	public function get_template(){
		$path = mwp_search_form_template_dir();
		$replace_path = mwp_default_template_dir();
		$list = 'MWP Search Form';
		return Mwp_TemplateDetails::get_instance()->get_theme_page_template($path, $replace_path, $list);
	}
	
	public function __construct(){
		$this->admin_db_entity = new Mwp_Admin_Theme_Layout_DBEntity;
	}
}
