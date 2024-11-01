<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get and locate template
 * */
class Mwp_Theme_Locator{
	protected static $instance = null;

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
	
	/**
	 * locate and return template
	 * @param	$template	default null
	 * @return string | path
	 * */
	public function locate_template($template = null){
		$view = new Mwp_View;
		/**
		 * check on the current theme first
		 * wp-content/theme/{current-template}/{$template}
		 * */
		$template_file = wp_strip_all_tags($template);
		
		$template = $view->get_in_theme($template_file);
		if( $template ){
			return $template;
		}
		/**
		 * is it customize?
		 * check on wp-content folder
		 * wp-content/mwp/template/{customize-template}
		 * */
		$template = $view->get_in_wp_content('/mwp/template/' . $template_file); 
		if( $template ){
			return $template;
		}
		/**
		 * else load the default template
		 * wp-content/mwp/template/{customize-template}
		 * */
		$public_template_file = 'template/' . mwp_default_template() . '/' . $template_file; 	
		$template = $view->public_part_partials($public_template_file); 	

		/**
		 * Need more custom layout?
		 * Manul over-ride it with hook
		 * */
		$template = apply_filters('mwp_hook_locate_template_file', $template);

		return $template;
	}
		
	public function __construct(){}	
	
}
