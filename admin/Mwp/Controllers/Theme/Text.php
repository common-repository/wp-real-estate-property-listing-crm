<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Theme_Text extends Mwp_Base{
	protected static $instance = null;
	protected $admin_theme_entity = null;
	protected $admin_theme_wpentity = null;
	protected $admin_text_wpentity = null;
	protected $admin_text_entity = null;
	protected $model = null;

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

	public function update_theme_text(){
		//update menu
		$this->model->mwp_theme_text('u',$_POST['mwp_theme_text']);
		$this->index();
	}

	/**
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function index(){
		$data =  array();
		$tab_nav = $this->admin_theme_entity->tab_nav();
		$data['url_slug'] = $this->admin_text_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['label'] = $this->admin_text_entity->mwp_get_label();
		$data['db_label'] = $this->model->mwp_theme_text();
		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('theme/settings/text.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_theme_text(){
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
		$this->admin_theme_entity = new Mwp_Admin_Theme_Settings;
		$this->admin_theme_wpentity = new Mwp_Admin_Theme_WPEntity;
		$this->admin_text_entity = new Mwp_Admin_Theme_Text_Entity;
		$this->admin_text_wpentity = new Mwp_Admin_Theme_Text_WPEntity;
		//$this->admin_text_dbentity = new Mwp_Admin_Theme_Layout_DBEntity;
		//$this->text_dbentity = new Mwp_Admin_Theme_Layout_DBEntity;
		$this->model = new Mwp_Theme_Text_Model;
	}
}
