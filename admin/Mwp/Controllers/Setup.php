<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup Controller
 *
 * This will setup the user of the CRM account, but first it will check of other installation requirement
 * - The pages use in this plugin must not exists
 * - The wp-content/uploads folder must be writable
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_Controllers_Setup extends Mwp_Base{
	protected static $instance = null;
	protected $model_subscribe = null;
	protected $subscribe_admin_entity = null;
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

	public function display_form($arg = array()){
		$entity_prerequisite = new Mwp_Install_Notice;
		$prerequisite = $entity_prerequisite->setup_prerequisite();

		$data['model_subscribe'] = $this->model_subscribe;
		$data['get_error'] = array();
		if( isset($arg['error']) ){
			$data['get_error'] = $arg['error'];
		}
		if( $prerequisite['has_passed_prerequisite'] == 0 ){
			//display notice
			$data['msg'] = $prerequisite['msg'];
			$data['plugin_version'] = mwp_plugin_version();
			Mwp_View::get_instance()->admin_partials('setup-prerequisite.php', $data);
		}else{
			$data['subscribe_crm'] = new Mwp_Controllers_SubscribeCRM;
			$data['input_keys'] = new Mwp_Controllers_Settings_CRMkey;
			$data['validate_form'] = false;
			if( $this->model_subscribe->masterdigm_subscribe_step_2('r')
				&& $this->model_subscribe->masterdigm_subscribe_step_2('r') == 1
				&& !$this->model_subscribe->masterdigm_subscribe_api_finish('r')
			){
				$data['url_slug'] = $this->subscribe_admin_entity->get_admin_url_slug();
				$data['validate_form'] = Mwp_View::get_instance()->admin_part_partials('subscribe/validate-forms.php');
			}
			//display form subscribe or setup crm key
			Mwp_View::get_instance()->admin_partials('subscribe/setup-keys.php', $data);
		}
	}

	/**
	 * display forms
	 *
	 * show forms for subscribe on the left and on the right shows form for already have keys
	 * */
	public function index($arg = array()){
		if( !mwp_has_crm_credentials() ){
			$this->display_form($arg);
		}else{
			Mwp_Controllers_Masterdigm::get_instance()->controller('masterdigm');
		}
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
		$this->call_method($this, $action, $arg);
	}

	public function __construct(){
		$this->model_subscribe = new Mwp_Subscribe_Model;
		$this->subscribe_admin_entity = new Mwp_Admin_SubscribeCRMEntity;
	}
}
