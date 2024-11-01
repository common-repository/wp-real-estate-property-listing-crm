<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Theme_Support_Enfold{
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
	
	public function mwp_filter_title($title){
		if( Mwp_View::get_instance()->data 
			&& isset(Mwp_View::get_instance()->data['property_data'])
			&& Mwp_View::get_instance()->data['property_data']->has_property()
			&& mwp_is_property_details_page()
		){
			if( mwp_get_current_api_source() == 'crm' ){
				if( mwp_is_display_tag_line() ){
					$title = Mwp_View::get_instance()->data['property_data']->property_data[0]->tag_line();
				}else{
					$title = Mwp_View::get_instance()->data['property_data']->property_data[0]->get_address();
				}
			}else{
				$title = Mwp_View::get_instance()->data['property_data']->property_data[0]->get_address();
			}
			//echo $title;exit();
		}
		if( mwp_is_search_result_page() ){
			if( isset($_GET['location']) && trim($_GET['location']) != '' ){
				$title = 'Search Result Properties for '.$_GET['location'];
			}else{
				$title = 'Search Result Properties';
			}
		}
		return $title;
	}
	
		
	public function init_hook(){
		add_filter('avf_title_tag', array($this, 'mwp_filter_title'),9999, 1);
	}
				
	public function __construct(){
		$this->init_hook();
	}
}

