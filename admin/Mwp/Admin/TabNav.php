<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Admin Tab Nav, Singleton
 * */
class Mwp_Admin_TabNav{
	protected static $instance = null;
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

	public function get_current_tab_nav($tab = ''){
		if( isset($_GET['tab']) && $_GET['tab'] != '' ){
			return $_GET['tab'];
		}
		return false;
	}

	public function tab_nav($template = '', $data = null){
		$current_tab = $this->get_current_tab_nav();
		if( !$current_tab ){
			$current_tab = '';
		}
		$admin_page_url = '';
		$data['current_tab'] = $current_tab;
		$data['admin_page_url'] = $admin_page_url;
		$data['default_tab'] = '';
		if(
			isset($data['default_tab'])
			&& $data['default_tab'] != ''
		){
			$data['default_tab'] = $default_tab;
		}

		Mwp_View::get_instance()->admin_partials($template, $data);
	}
}
