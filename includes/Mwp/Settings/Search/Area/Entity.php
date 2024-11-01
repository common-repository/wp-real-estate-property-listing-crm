<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Search_Area_Entity{
	protected static $instance = null;
	protected $price_dbentity = null;
	protected $mwp_config;
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
	 * lot area minimum
	 * */
	public function lot_area_min(){
		$from = 50;
		$to	  = 1000;
		$step = 100;
		return Mwp_Helpers_Text::create_array_range($from, $to, $step);
	}
	/**
	 * lot area minimum
	 * */
	public function lot_area_mid(){
		$from = 1100;
		$to	  = 10000;
		$step = 1000;
		return Mwp_Helpers_Text::create_array_range($from, $to, $step);
	}
	/**
	 * lot area mid
	 * */
	public function lot_area_high(){
		$from = 11000;
		$to	  = 50000;
		$step = 10000;
		return Mwp_Helpers_Text::create_array_range($from, $to, $step);
	}
	
	public function get_lot_area_range(){
		$low 		= $this->lot_area_min();
		if( has_filter('filter_lot_area_min') ){
			$low = apply_filters('filter_lot_area_min', $low);
		}
		$mid 		= $this->lot_area_mid();
		if( has_filter('filter_lot_area_mid') ){
			$mid = apply_filters('filter_lot_area_mid', $mid);
		}
		$high 		= $this->lot_area_high();
		if( has_filter('filter_lot_area_high') ){
			$high = apply_filters('filter_lot_area_high', $high);
		}
		$custom	= array();
		if( has_filter('filter_lot_area_range_custom') ){
			$custom = apply_filters('filter_lot_area_range_custom', $custom);
		}
		return array_merge($low, $mid, $high, $custom);
	}
	
	/**
	 * floor area minimum
	 * */
	public function floor_area_min(){
		$from = 50;
		$to	  = 1000;
		$step = 100;
		return Mwp_Helpers_Text::create_array_range($from, $to, $step);
	}
	/**
	 * floor area minimum
	 * */
	public function floor_area_mid(){
		$from = 1100;
		$to	  = 10000;
		$step = 1000;
		return Mwp_Helpers_Text::create_array_range($from, $to, $step);
	}
	/**
	 * floor area mid
	 * */
	public function floor_area_high(){
		$from = 11000;
		$to	  = 50000;
		$step = 10000;
		return Mwp_Helpers_Text::create_array_range($from, $to, $step);
	}

	public function get_floor_area_range(){
		$low 		= $this->floor_area_min();
		if( has_filter('filter_floor_area_min') ){
			$low = apply_filters('filter_floor_area_min', $low);
		}
		$mid 		= $this->floor_area_mid();
		if( has_filter('filter_floor_area_mid') ){
			$mid = apply_filters('filter_floor_area_mid', $mid);
		}
		$high 		= $this->floor_area_high();
		if( has_filter('filter_floor_area_high') ){
			$high = apply_filters('filter_floor_area_high', $high);
		}
		$custom	= array();
		if( has_filter('filter_floor_area_range_custom') ){
			$custom = apply_filters('filter_floor_area_range_custom', $custom);
		}
		return array_merge($low, $mid, $high, $custom);
	}
		
	public function __construct(){}
}
