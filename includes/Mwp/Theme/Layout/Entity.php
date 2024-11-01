<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Theme_Layout_Entity{
	protected static $instance = null;
	protected $layout_admin_dbentity = null;
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
	
		
	public function wp_nav_menu($args = array()){
		$menu = '';
		if(isset($args['menu'])){
			$menu = $args['menu'];
		}
		if( $menu != '' ){
			wp_nav_menu( array(
				'menu'  => $menu, // Do not fall back to first non-empty menu.
                'menu_class'        => 'nav navbar-nav mwp-wp-navmenu',
				'fallback_cb'    => false, // Do not fall back to wp_page_menu()
				'walker' => new Mwp_Theme_Layout_NavWalker()
			) );
		}
	}
	
	public function show_menu(){
		$menu_slug = $this->layout_admin_dbentity->get_menu();
		if( $menu_slug ){
			$args['menu'] = $menu_slug;
			$this->wp_nav_menu($args);
		}
	}
	
	public function get_logo(){
		return $this->layout_admin_dbentity->get_logo();
	}

	public function get_search_form(){
		global $mwp;
		$template = $mwp['template']['raw_search_form'];
		if( $this->layout_admin_dbentity->get_search_form() && $this->layout_admin_dbentity->get_search_form() != '-1' ){
			return $this->layout_admin_dbentity->get_search_form();
		}
		return $template;
	}

	public function get_custom_css(){
		return $this->layout_admin_dbentity->get_custom_css();
	}
	
	public function __construct(){
		$this->layout_admin_dbentity = new Mwp_Admin_Theme_Layout_DBEntity;
	}
}
