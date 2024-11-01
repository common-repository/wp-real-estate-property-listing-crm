<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Propertyalert_Settings extends Mwp_Base{
	protected static $instance = null;
	protected $propertyalert_wpentity = null;
	protected $propertyalert_model = null;
	
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
	
	public function update_theme_property(){
		$success_unsubscribe = '';
		if( isset($_POST['success-unsubscribe']) 
			&& $_POST['success-unsubscribe'] != ''
		){
			$success_unsubscribe = $_POST['success-unsubscribe'];	
		}
		$fail_unsubscribe = '';
		if( isset($_POST['fail-unsubscribe']) 
			&& $_POST['fail-unsubscribe'] != ''
		){
			$fail_unsubscribe = $_POST['fail-unsubscribe'];	
		}
		$this->propertyalert_model->success_unsubscribe('u', $success_unsubscribe);
		$this->propertyalert_model->fail_unsubscribe('u', $fail_unsubscribe);
		$this->index();
	}
	
	/**
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function index(){
		$data =  array();
		$data['url_slug'] = $this->propertyalert_wpentity->get_admin_url_slug();
		$editor_settings 	= array(
			'teeny'			=>	true,
			'textarea_rows' => 	5,
			'media_buttons' => 	false
		);
		$data['editor_settings'] = $editor_settings;
		$data['success_editor_editor_id'] = 'success-unsubscribe';
		$data['fail_editor_editor_id'] = 'fail-unsubscribe';
		$data['success_editor_content'] = $this->propertyalert_model->success_unsubscribe('r', '');
		$data['fail_editor_content'] = $this->propertyalert_model->fail_unsubscribe('r', '');
		
		Mwp_View::get_instance()->admin_partials('propertyalert/index.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_property_alert(){
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
		$this->propertyalert_wpentity = new Mwp_Admin_Propertyalert_WPEntity;
		$this->propertyalert_model = new Mwp_Propertyalert_Model;
	}
}
