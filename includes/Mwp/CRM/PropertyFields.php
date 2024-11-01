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
class Mwp_CRM_PropertyFields{
	protected static $instance = null;
	protected $crm_fields = null;
	protected $cache_prefix = 'mwp_cache_crm_property_';
	/**
	 * instantiate the crm property class
	 * */
	protected $crm_property = null;
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

	public function get_field_type(){
		if( isset($this->crm_fields->fields) && isset($this->crm_fields->fields->types) ){
			return $this->crm_fields->fields->types;
		}
		return false;
	}

	public function get_field_status(){
		if( isset($this->crm_fields->fields) && isset($this->crm_fields->fields->status) ){
			return $this->crm_fields->fields->status;
		}
		return false;
	}

	public function get_field_nonviewable_status(){
		if( isset($this->crm_fields->fields) && isset($this->crm_fields->fields->nonviewable_status) ){
			return $this->crm_fields->fields->nonviewable_status;
		}
		return false;
	}

	public function get_field_status_by_val($status_val = '' ){
		$key_active = 0;
		$status = $this->get_field_status();
		if( $status && count($status) > 0 ){
			foreach($status as $key => $val){
				if( strtolower($val) == $status_val ){
					$key_active = $key;
				}
			}
		}
		return $key_active;
	}

	public function fields(){
		$cache_prefix = $this->cache_prefix . 'fields';
		if( mwp_cache_get($cache_prefix) ){
			return mwp_cache_get($cache_prefix);
		}else{
			$status = $this->crm_adapter->get_fields();
			if( isset($status->success) && $status->success ){
				mwp_cache_set($cache_prefix, $status);
				return mwp_cache_get($cache_prefix);
			}
		}
		return false;
	}

	public function __construct($crm_adapter = null){
		if( is_null($crm_adapter) ){
			$this->crm_adapter = new Mwp_CRM_Adapter;
		}else{
			$this->crm_adapter = $crm_adapter;
		}
		
		$this->crm_fields = $this->fields();
	}
}
