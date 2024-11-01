<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Settings_Clientlead extends Mwp_Base{
	protected static $instance = null;
	protected $settings_entity = null;
	protected $wp_entity_client_lead = null;
	protected $client_lead_entity = null;
	protected $db_entity_client_lead = null;
	protected $db_entity_admin_client_lead = null;
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

	public function update_clientlead(){
		$this->db_entity_admin_client_lead->update_lead($_POST);
		$this->md_settings_client_lead();
	}

	/**
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function md_settings_client_lead(){
		global $mwp;
		$data = array();
		$tab_nav = $this->settings_entity->tab_nav();
		$data['url_slug'] = $this->wp_entity_client_lead->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['lead_status'] = $this->client_lead_entity->get_lead_status();
		$data['lead_type'] = $this->client_lead_entity->get_lead_type();
		$data['lead_source'] = $this->client_lead_entity->get_lead_source();
		$data['db_lead_status'] = $this->db_entity_client_lead->get_lead_status();
		$data['db_lead_type'] = $this->db_entity_client_lead->get_lead_type();
		$data['db_lead_source'] = $this->db_entity_client_lead->get_lead_source();

		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('settings/settings-client-lead.php', $data);
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
		$this->settings_entity = new Mwp_Admin_Settings_Entity;
		$this->wp_entity_client_lead = new Mwp_Admin_Settings_Clientlead_WPEntity;
		$this->db_entity_client_lead = new Mwp_Settings_Lead_DBEntity;
		$this->client_lead_entity = new Mwp_Settings_Lead_Entity;
		$this->db_entity_admin_client_lead = new Mwp_Admin_Settings_Clientlead_DBEntity;
	}
}
