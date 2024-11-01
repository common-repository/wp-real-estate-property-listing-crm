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
class Mwp_CRM_HookLocation{
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
	
	public function location_autocomplete(){
		$loc = new Mwp_CRM_CoverageLookup();
		return $loc->coverage_lookup();
	}
	/**
	 * @param $arg  array accept values
	 * $arg['keyword']
	 * $arg['output']
	 * */
	public function location_build_up($arg = array()){
		$result = array();
		$location = $this->location_autocomplete();
		
		$text = '';
		$keyword = 'full';
		if( isset($arg['keyword']) ){
			$keyword = $arg['keyword'];
		}
		$output = 'json';
		if( isset($arg['output']) ){
			$output = $arg['output'];
		}
		if( isset($location->result) && $location->result == 'success' ){
			//create a json
			foreach($location->lookups as $items){
				$text = $items->full;
				if( $keyword == 'keyword' ){
					$text = $items->keyword;
				}
				$result[] = array(
					'label'	=> 	Mwp_Helpers_Text::remove_non_alphanumeric($text),
					'value'	=>	Mwp_Helpers_Text::remove_non_alphanumeric($text),
					'id'	=>	$items->id,
					'type'	=>	$items->location_type,
				);
			}
			if( $output == 'json' ){
				return json_encode($result);
			}elseif( $output == 'aarray' ){
				return $result;
			}
		}
		return array();
	}
	
	public function get_location_crm(){
		//check_ajax_referer( 'md-ajax-request', 'security' );
		$find = '';
		if( isset($_GET['term']) && trim($_GET['term']) != '' ){
			$find = $_GET['term'];
		}
		$result = array();
		$arg = array(
			'output' => 'aarray'
		);
		$res = $this->location_build_up($arg);
		$indx = 0;
		foreach($res as $key => $val){
			if (stripos($val['value'], $find) !== false) {
				$result[] = $res[$indx];
			}
			$indx++;
		}
		echo json_encode($result);
		die();
	}
}
