<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Theme_Property extends Mwp_Base{
	protected static $instance = null;
	protected $crm_entity = null;
	protected $mwp_crm_adapter = null;
	protected $subscribe_model = null;
	protected $theme_entity = null;
	protected $theme_wpentity = null;
	protected $theme_property_entity = null;
	protected $theme_property_dbentity = null;
	protected $theme_property_wpentity = null;
	protected $admin_theme_property_dbentity = null;

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
	public function index(){
		$data =  array();
		$tab_nav = $this->theme_entity->tab_nav();
		$data['url_slug'] = $this->theme_property_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['show_default_property_name'] = $this->theme_property_entity->property_title();
		$data['arr_show_bed'] = $this->theme_property_entity->show_bed();
		$data['arr_show_bath'] = $this->theme_property_entity->show_bath();
		$data['arr_show_garage'] = $this->theme_property_entity->show_garage();
		$data['db_property_title'] = $this->theme_property_dbentity->get_property_title();
		$data['book_a_viewing_align'] = $this->theme_property_entity->bookaviewing_align();
		$data['db_book_a_viewing_align'] = $this->theme_property_dbentity->get_book_a_viewing_align();
		$data['db_book_a_viewing_url'] = $this->theme_property_dbentity->get_book_a_viewing_url();
		$data['db_book_a_viewing_label'] = $this->theme_property_dbentity->get_book_a_viewing_label();
		$data['db_show_bath'] = $this->theme_property_dbentity->get_show_bath();
		$data['db_show_bed'] = $this->theme_property_dbentity->get_show_bed();
		$data['db_show_garage'] = $this->theme_property_dbentity->get_show_garage();

		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('theme/settings/property.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_theme_property(){
		$this->index();
	}

	public function update_theme_property(){
		$this->admin_theme_property_dbentity->db_update($_POST);
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
		$this->theme_entity = new Mwp_Admin_Theme_Settings;
		$this->theme_wpentity = new Mwp_Admin_Theme_WPEntity;
		$this->theme_property_entity = new Mwp_Admin_Theme_Property_Entity;
		$this->theme_property_dbentity = new Mwp_Settings_Property_DBEntity;
		$this->theme_property_wpentity = new Mwp_Admin_Theme_Property_WPEntity;
		$this->admin_theme_property_dbentity = new Mwp_Admin_Theme_Property_DBEntity;
	}
}
