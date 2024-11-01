<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm MLS Property Fields
 *
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_MLS_AccountDetails{
	protected static $instance = null;
	protected $account_details_data = null;
	protected $cache_prefix = 'mwp_cache_mls_account_details';
	/**
	 * instantiate the crm property class
	 * */
	protected $crm_adapter = null;
	protected $mls_adapter = null;
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
		$type = array();
		$cache_keyword 	= 'mls_property_type';
		$property_type 	= array();
		//mwp_cache_del($cache_keyword);
		if( mwp_cache_get($cache_keyword) ){
			$property_type = mwp_cache_get($cache_keyword);
		}else{
			$property_type 	= $this->mls_adapter->get_property_types();
			if( $property_type && isset($property_type->result) == 'success'){
				if( isset($property_type->types) ){
					foreach($property_type->types as $k => $v){
						$key = mwp_trim_tolower($v);
						$type[$key] = $v;
					}
				}
			}else{
				return false;
			}
			$property_type = $type;
			mwp_cache_set($cache_keyword, $property_type);
		}
		return $property_type;
	}
	
	public function get_property_type_key($key = ''){
		$types = $this->get_property_type();
		if( $types && isset($types->result) && $types->result == 'success' ){
			$get_key = array_key_exists($key,$types->types);
			if( $get_key ){
				return $types->types[$get_key];
			}
		}else{
			return false;
		}
	}
	
	public function __construct($mls_adapter = null){
		if( is_null($mls_adapter) ){
			$this->mls_adapter = new Mwp_MLS_Adapter;
		}else{
			$this->mls_adapter = $mls_adapter;
		}
	}
}
