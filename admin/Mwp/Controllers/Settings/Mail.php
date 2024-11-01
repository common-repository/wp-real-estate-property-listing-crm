<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Settings_Mail extends Mwp_Base{
	protected static $instance = null;
	protected $crm_entity = null;
	protected $mwp_crm_adapter = null;
	protected $admin_settings_entity = null;
	protected $mail_settings_entity = null;
	protected $mail_admin_settings_entity = null;
	protected $mail_admin_settings_dbentity = null;
	protected $mail_model = null;
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

	public function update_mail(){
		$this->mail_admin_settings_dbentity->db_update_mail($_POST);
		$this->md_settings_mail();
	}

	/**
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function md_settings_mail(){
		$data = array();
		$tab_nav = $this->admin_settings_entity->tab_nav();
		$data['_tab'] = $tab_nav['_tab'];
		$data['url_slug'] = $this->mail_admin_settings_wpentity->get_admin_url_slug() . '&tab=' . $data['_tab'];
		$data['mail_server'] = $this->mail_admin_settings_dbentity->get_email();
		$data['content'] = stripslashes($this->mail_model->content('r'));
		$data['subject'] = $this->mail_model->subject('r');
		$data['editor_id'] = 'md_mail_content';
		$data['settings'] = array( 'media_buttons' => false, 'editor_height' => 250, 'teeny' => true );

		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('settings/settings-mail.php', $data);
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
		$this->admin_settings_entity = new Mwp_Admin_Settings_Entity;
		$this->mail_settings_entity = new Mwp_Settings_Mail_Entity;
		$this->mail_admin_settings_wpentity = new Mwp_Admin_Settings_Mail_WPEntity;
		$this->mail_admin_settings_dbentity = new Mwp_Admin_Settings_Mail_DBEntity;
		$this->mail_model = new Mwp_Settings_Mail_Model;
	}
}
