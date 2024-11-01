<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Property_Settings extends Mwp_Base{
	protected static $instance = null;
	protected $crm_entity = null;
	protected $mwp_crm_adapter = null;
	protected $subscribe_model = null;
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
	 * display form914940
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function display_form(){
		$data =  array();
		Mwp_View::get_instance()->admin_partials('property/settings/index.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_property(){
		$this->display_form();
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
		$this->crm_model = new Mwp_CRM_Model;
		$this->crm_entity = new Mwp_Admin_Settings_CRMkeyEntity;
		$this->mwp_crm_adapter = new Mwp_CRM_Adapter;
		$this->subscribe_model = new Mwp_Subscribe_Model;
	}
}
