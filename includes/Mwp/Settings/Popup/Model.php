<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Popup_Model{
	protected static $instance = null;
	public $masterdigm_popup_show = 'masterdigm_popup_show';
	public $masterdigm_popup_close = 'masterdigm_popup_close';
	public $masterdigm_popup_clicks = 'masterdigm_popup_clicks';
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

	public function popup_show($action = '', $value = ''){
		$prefix = $this->masterdigm_popup_show;
		switch($action){
			case 'u':
				update_option($prefix, $value);
			break;
			case 'd':
				delete_option($prefix, $value);
			break;
			case 'r':
			default:
				return get_option($prefix, $value);
			break;
		}
	}

	public function popup_close($action = '', $value = ''){
		$prefix = $this->masterdigm_popup_close;
		switch($action){
			case 'u':
				update_option($prefix, $value);
			break;
			case 'd':
				delete_option($prefix, $value);
			break;
			case 'r':
			default:
				return get_option($prefix, $value);
			break;
		}
	}

	public function popup_clicks($action = '', $value = ''){
		$prefix = $this->masterdigm_popup_clicks;
		switch($action){
			case 'u':
				update_option($prefix, $value);
			break;
			case 'd':
				delete_option($prefix, $value);
			break;
			case 'r':
			default:
				return get_option($prefix, $value);
			break;
		}
	}

	public function __construct(){}
}
