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
class Mwp_CRM_CoverageLookup{
	protected static $instance = null;
	protected $account_details_data = null;
	protected $cache_prefix = 'mwp_cache_crm_coverate_lookup_';
	/**
	 * instantiate the crm property class
	 * */
	protected $crm_adapter = null;
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

	public function coverage_lookup(){
		$cache_prefix = $this->cache_prefix . '_init';
		if( mwp_cache_get($cache_prefix) ){
			return mwp_cache_get($cache_prefix);
		}else{
			$account = $this->crm_adapter->get_location();
			mwp_cache_set($cache_prefix, $account);
			return mwp_cache_get($cache_prefix);
		}
		return false;
	}
	
	public function __construct(){
		$this->crm_adapter = new Mwp_CRM_Adapter;
	}
}
