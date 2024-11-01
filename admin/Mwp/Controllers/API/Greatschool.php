<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_API_Greatschool extends Mwp_Base{
	protected static $instance = null;
	protected $api_flexmls_wpentity = null;
	protected $api_settings = null;
	protected $api_greatschool_wpentity = null;
	protected $api_greatschool_model = null;
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
	
	public function update_api_greatschool(){
		$md_greatschool_api_key = '';
		if( isset($_POST['md_greatschool_api_key'])
			&& $_POST['md_greatschool_api_key'] != ''
		){
			$md_greatschool_api_key = $_POST['md_greatschool_api_key'];
		}
		$this->api_greatschool_model->md_greatschool_api_key('u', $md_greatschool_api_key);
		$this->index();
	}
		
	/**
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function index(){
		$data =  array();
		$tab_nav = $this->api_settings->tab_nav();
		$data['url_slug'] = $this->api_greatschool_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['md_greatschool_api_key'] = $this->api_greatschool_model->md_greatschool_api_key('r');
		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('api/great-school.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_greatschool_api(){
		$this->index();
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
		$this->call_method($this, $action);
	}

	public function __construct(){
		$this->api_greatschool_wpentity = new Mwp_Admin_API_Greatschool_WPEntity;	
		$this->api_settings = new Mwp_Admin_API_Settings;
		$this->api_greatschool_model = new Mwp_API_Greatschool_Model;
	}
}
