<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm Controller
 *
 * This class defines the decision between displaying dashboard or the Setup / Wizard process
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_Controllers_Masterdigm extends Mwp_Base{
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

	/**
	 * Controller
	 *
	 * @param	$action		string | empty
	 * @parem	$arg		array
	 * 						optional, pass data for controller
	 * @return mix
	 * */
	public function controller($action = '', $arg = array()){
		if( mwp_has_crm_credentials() ){
			$this->call_method($this, $action);
		}else{
			Mwp_Controllers_Setup::get_instance()->controller('index');
		}
	}

	public function masterdigm(){
		$data = array();
		$current_tab = Mwp_Admin_TabNav::get_instance()->get_current_tab_nav();

		if( $current_tab == '' ){
			$data['tab'] = 'dashboard/dashboard.php';
		}else{
			$data['tab'] = 'dashboard/' . $current_tab . '.php';
		}
		$data['default_tab'] = 'dashboard';
		$get_page = '';
		if(
			isset($_GET['page'])
			&& sanitize_text_field($_GET['page']) != ''
		){
			$get_page = $_GET['page'];
		}
		$data['current_plugin_page'] = admin_url( 'admin.php?page=' . $get_page );
		$data['tab_nav'] = array('current_plugin_page' => $data['current_plugin_page'], 'default_tab' => $data['default_tab']);
		$data['tab_nav_template'] = 'dashboard/tab-nav.php';

		Mwp_View::get_instance()->admin_partials('dashboard/index.php', $data);
	}

	public function __construct(){}
}
