<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm CRM Property Fields
 *
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_HomeJunction_PropertyFields{
	protected static $instance = null;
	/**
	 * instantiate the crm property class
	 * */
	protected $hji_adapter = null;
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

	public function get_property_type(){
		$cache_keyword 	= 'mwp_hji_coverage_prop_type';
		$prop_res = array();
		if( mwp_cache_get($cache_keyword) ){
			$prop_type = mwp_cache_get($cache_keyword);
		}else{
			$prop_type 	= $this->hji_adapter->get_property_type();
			if( isset($prop_type->propertyTypes) ){
				foreach($prop_type->propertyTypes as $k => $v){
					$prop_res[$k] = $v;
				}
			}
			mwp_cache_set($cache_keyword, $prop_res);
			$prop_type = $prop_res;
		}
		return $prop_type;
	}

	public function __construct(){
		$this->hji_adapter = new Mwp_HomeJunction_Adapter;
	}
}
