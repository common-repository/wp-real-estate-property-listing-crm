<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm CRM Model
 *
 * This class handles the CRM database like keys from Masterdigm
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_MLS_Model{
	protected static $instance = null;
	public $plugin_obj;
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
	
	public function md_query_page_title($string){
		global $wpdb;
		$location_name = str_replace(' ','-',strtolower($string));
		$location_name = esc_sql($location_name);
		$sql = "SELECT * FROM ".$wpdb->posts." WHERE post_name LIKE  '{$location_name}%' AND post_status =  'publish'";
		$ret = $wpdb->get_results($sql);
		return $ret;
	}
	
	public function is_property_viewable_hook_mls($status){
		//status not to show
		$arr_status = array(
			'sold'
		);
		$status = trim(strtolower($status));
		if( in_array($status,$arr_status) ){
			return false;
		}
		return true;
	}
	
}
