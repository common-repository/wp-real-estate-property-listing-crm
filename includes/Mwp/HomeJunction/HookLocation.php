<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm MLS Model
 *
 * This class handles the CRM database like keys from Masterdigm
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_HomeJunction_HookLocation{
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
	
	public function location_autocomplete($term = ''){
		$loc = new Mwp_HomeJunction_CoverageLookup();
		return $loc->get_coverage_lookup($term);
	}
	
	/**
	 * @param $arg  array accept values
	 * $arg['keyword']
	 * $arg['output']
	 * */
	public function location_build_up($arg = array(), $search_type = 'full'){
		$result = array();
		$term = '';
		if( isset($arg['term']) 
			&& $arg['term'] != '' 
		){
			$term = $arg['term'];
		}
		$output = 'json';
		if( isset($arg['output']) ){
			$output = $arg['output'];
		}

		$location = $this->location_autocomplete($term);

		if( $location->success ){
			foreach($location->result->matches as $k => $v){
				$result[$v->city] = array(
					'label'	=> 	$v->city .', '. $v->state,
					'value'	=>	$v->city,
					'id'	=>	$v->city,
					'type'	=>	'city',
				);
			}
			if( $output == 'json' ){
				return json_encode($result);
			}elseif( $output == 'aarray' ){
				return $result;
			}
		}
		return $result;
	}
	
	public function get_location_hji(){
		//check_ajax_referer( 'md-ajax-request', 'security' );
		$find = '';
		if( isset($_GET['term']) && trim($_GET['term']) != '' ){
			$find = $_GET['term'];
		}
		$result = array();
		$arg = array(
			'output' => 'aarray',
			'term' => $find
		);
		$res = $this->location_build_up($arg);
		$indx = 0;
		foreach($res as $key => $val){
			if (stripos($val['value'], $find) !== false) {
				$result[] = $val;
			}
			$indx++;
		}
		echo json_encode($result);
		die();
	}
}
