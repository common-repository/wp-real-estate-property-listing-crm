<?php
class Mwp_HomeJunction_CoverageLookup{
	protected static $instance = null;
	public $flexmls;

	public function __construct(){
		$this->hji = new Mwp_HomeJunction_Adapter;
	}

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

	public function get_coverage_lookup($term = ''){
		$cache_keyword 	= 'mwp_hji_coverage_lookup_'.$term;
		if( mwp_cache_get($cache_keyword) ){
			$autocomplete_result = mwp_cache_get($cache_keyword);
		}else{
			$autocomplete_result 	= $this->hji->get_locations($term);
			mwp_cache_set($cache_keyword, $autocomplete_result);
		}
		return $autocomplete_result;
	}

	public function get_country_coverage_lookup(){
		$location = array();
		$location = $this->get_coverage_lookup();
		return $location;
	}

	/**
	 * create a country look up
	 * - store it in _options table, if it doesn't exsits
	 * - create a json file
	 * */
	public function create_country_lookup($location = null, $search_type = 'full'){
		$json_location 	= array();
		$location 		= $this->get_country_coverage_lookup();

		return $json_location;
	}
}
