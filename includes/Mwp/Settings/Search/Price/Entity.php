<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Search_Price_Entity{
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
	
	public function get_price_range_by(){
		$ten = $this->price_range_by_tens();
		if( has_filter('filter_price_range_by_tens') ){
			$ten = apply_filters('filter_price_range_by_tens', $ten);
		}
		$hundred = $this->price_range_by_hundred();
		if( has_filter('filter_range_by_hundred') ){
			$hundred = apply_filters('filter_range_by_hundred', $hundred);
		}
		$million = $this->price_range_by_million();
		if( has_filter('filter_range_by_million') ){
			$million = apply_filters('filter_range_by_million', $million);
		}
		return array_merge($ten, $hundred, $million);
	}
	
	public function price_range_by_tens(){
		$start = $this->price_dbentity->get_ten_start();
		$end	  = $this->price_dbentity->get_ten_end();
		$step = $this->price_dbentity->get_ten_step();
		return array(
			'start' => $start,
			'step' => $step,
			'end' => $end,
		);
	}
	
	public function price_range_by_hundred(){
		$start = $this->price_dbentity->get_hundred_start();
		$end	  = $this->price_dbentity->get_hundred_end();
		$step = $this->price_dbentity->get_hundred_step();
		return array(
			'start' => $start,
			'step' => $step,
			'end' => $end,
		);
	}

	public function price_range_by_million(){
		$start = $this->price_dbentity->get_million_start();
		$end	  = $this->price_dbentity->get_million_end();
		$step = $this->price_dbentity->get_million_step();
		return array(
			'start' => $start,
			'step' => $step,
			'end' => $end,
		);
	}
	
	public function __construct(){
		global $mwp;
		$this->mwp_config = $mwp['search_settings_price'];
		$this->price_dbentity = new Mwp_Settings_Search_Price_DBEntity;
	}
}
