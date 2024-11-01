<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_API_Social extends Mwp_Base{
	protected static $instance = null;
	protected $api_social_wpentity = null;
	protected $api_settings = null;
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
	
	public function update_api_social(){

		if( $_POST['masterdigm_facebook_id'] 
			&& $_POST['masterdigm_facebook_id'] != ''
		){
			$this->social_api_model->masterdigm_facebook_id('u', $_POST['masterdigm_facebook_id']);
		}
		if( $_POST['masterdigm_facebook_secret'] 
			&& $_POST['masterdigm_facebook_secret'] != ''
		){
			$this->social_api_model->masterdigm_facebook_secret('u', $_POST['masterdigm_facebook_secret']);
		}
		if( $_POST['masterdigm_facebook_version'] 
			&& $_POST['masterdigm_facebook_version'] != ''
		){
			$this->social_api_model->masterdigm_facebook_version('u', $_POST['masterdigm_facebook_version']);
		}
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
		$data['url_slug'] = $this->api_social_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['masterdigm_facebook_id'] = $this->social_api_model->masterdigm_facebook_id('r');
		$data['masterdigm_facebook_secret'] = $this->social_api_model->masterdigm_facebook_secret('r');
		$data['masterdigm_facebook_version'] = $this->social_api_model->masterdigm_facebook_version('r');
		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('api/social-api.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_social_api(){
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
		$this->api_social_wpentity = new Mwp_Admin_API_Social_WPEntity;	
		$this->api_settings = new Mwp_Admin_API_Settings;	
		$this->social_api_dbentity = new Mwp_API_Social_DBEntity;
		$this->social_api_model = new Mwp_API_Social_Model;
	}
}
