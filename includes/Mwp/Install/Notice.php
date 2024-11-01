<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Notice installation or prerequisite before install
 * */
class Mwp_Install_Notice{
	protected static $instance = null;
	public $has_passed_prerequisite = 'has_passed_prerequisite';
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

	public function has_passed_prerequisite($action = '', $value = ''){
		$prefix = $this->has_passed_prerequisite;
		switch($action){
			case 'r':
				return get_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'd':
				delete_option($prefix);
			break;
		}
	}

	public function check_permalinks_enable(){
		return get_option('permalink_structure');
	}

	public function is_wp_upload_exists(){
		// check if media upload exists
		// this to make sure cache works
		$upload_dir = wp_upload_dir();
		if(
			file_exists($upload_dir['basedir'])
			&& is_writable($upload_dir['basedir'])
		){
			return true;
		}
		return false;
	}

	public function check_default_page(){
		return array(
			'Property',
			'Search Properties',
			'My Account',
			'State',
			'County',
			'City',
			'Community',
			'Un Subscribe',
		);
	}

	public function setup_prerequisite(){
		$step_one_pass = true;
		//check cache folder
		$need_setup = array();
		if( !$this->is_wp_upload_exists() ){
			$need_setup[] = __("Folder wp-content/uploads doesn't exists, please create and make it writable", mwp_localize_domain());
			$step_one_pass = false;
		}
		//check permalinks
		if( !$this->check_permalinks_enable() ){
			$need_setup[] = __("The permalinks, need to set up so the url will work in property pages", mwp_localize_domain());
			$step_one_pass = false;
		}
		//check pages
		foreach($this->check_default_page() as $pages){
			if( get_page_by_title($pages) ){
				$need_setup[] = '"'.$pages.'"' . __(" page already exists, please check or rename the page title and the url", mwp_localize_domain());
				$step_one_pass = false;
			}
		}

		if( $step_one_pass ){
			$this->has_passed_prerequisite('u',1);
			return array(
				'msg' => '',
				'has_passed_prerequisite' => 1
			);
		}else{
			$this->has_passed_prerequisite('d');
			return array(
				'msg' => $need_setup,
				'has_passed_prerequisite' => 0
			);
		}
	}

	public function __construct(){}

}
