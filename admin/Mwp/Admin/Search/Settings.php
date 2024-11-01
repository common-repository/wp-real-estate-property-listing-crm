<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Admin_Search_Settings{
	protected static $instance = null;
	protected $search_general_model = null;
	protected $search_general_wpentity = null;

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

	public function tab_nav(){
		$data =  array();
		$current_tab = Mwp_Admin_TabNav::get_instance()->get_current_tab_nav();
		$data['default_tab'] = 'general';
		if( !$current_tab ){
			$data['tab'] = 'search/settings/settings-general.php';
			$data['url_slug'] = $this->search_general_wpentity->get_admin_url_slug();
			$data['_tab'] = $data['default_tab'];
		}else{
			$data['tab'] = 'search/settings/' . $current_tab . '.php';
			$data['_tab'] = $current_tab;
		}

		$get_page = '';
		if(
			isset($_GET['page'])
			&& sanitize_text_field($_GET['page']) != ''
		){
			$get_page = $_GET['page'];
		}
		$data['current_plugin_page'] = admin_url( 'admin.php?page=' . $get_page );
		$data['tab_nav'] = array('current_plugin_page' => $data['current_plugin_page'], 'default_tab' => $data['default_tab']);
		$data['tab_nav_template'] = 'search/settings/tab-nav.php';

		return $data;
	}

	public function arr_show_button_forsale(){
		return array(
			'y' => __('Yes', mwp_localize_domain()),
			'n' => __('No', mwp_localize_domain()),
		);
	}

	public function arr_show_button_forrent(){
		return array(
			'y' => __('Yes', mwp_localize_domain()),
			'n' => __('No', mwp_localize_domain()),
		);
	}

	public function arr_show_button_foreclosure(){
		return array(
			'y' => __('Yes', mwp_localize_domain()),
			'n' => __('No', mwp_localize_domain()),
		);
	}

	public function arr_show_button_privatesales(){
		return array(
			'y' => __('Yes', mwp_localize_domain()),
			'n' => __('No', mwp_localize_domain()),
		);
	}

	public function arr_show_button_tolet(){
		return array(
			'y' => __('Yes', mwp_localize_domain()),
			'n' => __('No', mwp_localize_domain()),
		);
	}

	public function __construct(){
		$this->search_general_model = new Mwp_Settings_Search_General_Model;
		$this->search_general_wpentity = new Mwp_Admin_Search_WPEntity;
	}
}


