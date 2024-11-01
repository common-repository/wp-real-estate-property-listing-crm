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
class Mwp_Flexmls_PropertyFields{
	protected static $instance = null;
	protected $crm_fields = null;
	protected $flexmls_fields = null;
	protected $cache_prefix = 'mwp_cache_flexmls_property_';
	/**
	 * instantiate the crm property class
	 * */
	protected $crm_property = null;
	protected $flexmls_adapter = null;
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
		return $this->flexmls_adapter->get_property_type();
	}

	public function get_standard_fields(){
		return $this->flexmls_adapter->get_standard_fields();
	}

	public function get_standard_field_list(){
		return $this->flexmls_adapter->get_standard_field_list();
	}

	public function __construct(){
		$this->flexmls_adapter = new Mwp_Flexmls_Adapter;
	}
}
