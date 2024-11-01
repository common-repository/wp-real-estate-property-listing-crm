<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Theme_Layout extends Mwp_Base{
	protected static $instance = null;
	protected $crm_entity = null;
	protected $mwp_crm_adapter = null;
	protected $subscribe_model = null;
	protected $theme_entity = null;
	protected $theme_wpentity = null;
	protected $theme_style_entity = null;
	protected $theme_style_dbentity = null;
	protected $theme_style_wpentity = null;
	protected $admin_theme_style_dbentity = null;
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

	public function update_theme_layout(){
		//update menu
		if( isset($_POST['mwp_menu']) && $_POST['mwp_menu'] != '-1' ){
			$this->model->mwp_menu('u', $_POST['mwp_menu']);
		}
		if( isset($_POST['mwp_logo']) ){
			$this->model->mwp_logo_img('u', $_POST['mwp_logo']);
		}
		if( isset($_POST['mwp_search_form']) ){
			$this->model->mwp_search_form('u', $_POST['mwp_search_form']);
		}
		if( isset($_POST['mwp_custom_css']) ){
			$this->model->mwp_custom_css('u', $_POST['mwp_custom_css']);
		}
		$this->model->mwp_get_headers('u', $_POST['mwp_get_headers']);
		$this->model->mwp_get_headers_name('u', $_POST['header_name']);
		$this->model->mwp_get_footers('u', $_POST['mwp_get_footers']);
		$this->model->mwp_get_footers_name('u', $_POST['footer_name']);
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
		$data['url_slug'] = $this->admin_layout_style_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['wp_registered_menu'] = $this->admin_layout_style_entity->wp_get_nav_menus();
		$data['db_menu'] = $this->admin_layout_style_dbentity->get_menu();
		$data['db_logo'] = $this->admin_layout_style_dbentity->get_logo();
		$data['search_form'] = $this->admin_layout_style_entity->get_template();
		$data['db_search_form'] = $this->admin_layout_style_dbentity->get_search_form();
		$data['get_custom_css'] = $this->admin_layout_style_dbentity->get_custom_css();
		$data['use_mwp_header'] = mwp_get_headers();
		$data['use_mwp_header_name'] = mwp_get_headers_name();
		$data['use_mwp_footer'] = mwp_get_footers();
		$data['use_mwp_footer_name'] = mwp_get_footers_name();
		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('theme/settings/layout.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_theme_layout(){

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
		$this->admin_layout_style_entity = new Mwp_Admin_Theme_Layout_Entity;
		$this->admin_layout_style_wpentity = new Mwp_Admin_Theme_Layout_WPEntity;
		$this->admin_layout_style_dbentity = new Mwp_Admin_Theme_Layout_DBEntity;
		$this->layout_style_dbentity = new Mwp_Admin_Theme_Layout_DBEntity;
		$this->model = new Mwp_Theme_Layout_Model;
	}
}
