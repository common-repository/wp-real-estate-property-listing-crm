<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Loadtime{

	protected static $instance = null;
	private $time_start     =   0;
    private $time_end       =   0;
    private $time           =   0;
	

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
	
	public function start(){
		$this->time_start = microtime(true);
	}

	public function end($msg){
		$this->time = microtime(true) - $this->time_start;
		echo $msg . " (Loaded in $this->time seconds\n)";
	}
	
	public function __construct(){
		if( defined('MWP_EXECUTION_TIME') ){
			$this->time_start = 0;
			$this->time_end = 0;
			$this->time = 0;
		}
	}
}
