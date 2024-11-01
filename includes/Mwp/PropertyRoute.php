<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Route property url in public
 * */
class Mwp_PropertyRoute{
	/**
	 * instance of this class
	 *
	 * @since 3.12
	 * @access protected
	 * @var	null
	 * */
	protected static $instance = null;
	protected $add_rewrite_rule;
	protected $rule;
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
	
	public static function get($uri, $callback, $callback_param = array()){
		$callback_param[] = $uri;

		return call_user_func_array($callback, array($callback_param));
	}
		
	public function __construct(){}
	
}
