<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Admin_CreatePageByLocation_Entity{
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

	public function get_option_log(){
		global $wpdb;
		$sql = "SELECT * FROM $wpdb->options WHERE option_name like '%create_page_by_location_%'";
		return $wpdb->get_results($sql);
	}

	public function parse_option_log(){
		$parse_log = array(
			'total' => 0
		);
		$log = $this->get_option_log();
		foreach($log as $key => $val){
			$parse_log['total'] += 1;
			$date_added = unserialize($val->option_value);
			if( isset($parse_log['data']) ){
				$parse_log['data'][] = array(
					'total' => $date_added['data']['total'],
					'date' 	=> $date_added['data']['date_added']
				);
			}
		}
		return json_decode(json_encode($parse_log), FALSE);
	}

	public function __construct(){}
}


