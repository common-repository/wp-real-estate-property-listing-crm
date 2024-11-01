<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Theme_Map extends Mwp_Base{
	protected static $instance = null;
	protected $crm_entity = null;
	protected $mwp_crm_adapter = null;
	protected $admin_map_style_wpentity = null;
	protected $admin_map_style_dbentity = null;
	protected $admin_theme_entity = null;
	protected $model_map = null;
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

	public function update_theme_map(){
		if( isset($_POST['mwp_geo_address']) && trim($_POST['mwp_geo_address']) != '' ){
			$this->model_map->mwp_geo_address('u', $_POST['mwp_geo_address']);
		}
		if( isset($_POST['mwp_map_zoom']) && trim($_POST['mwp_map_zoom']) != '' ){
			$this->model_map->mwp_map_zoom('u', $_POST['mwp_map_zoom']);
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
		$tab_nav = $this->admin_theme_entity->tab_nav();
		$data['url_slug'] = $this->admin_map_style_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['geocode_address'] = $this->admin_map_style_dbentity->get_geocode_address();
		$data['mwp_zoom'] = $this->admin_map_style_dbentity->get_mwp_zoom();
		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('theme/settings/map.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_theme_map(){

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
		$this->admin_map_style_wpentity = new Mwp_Admin_Theme_Map_WPEntity;
		$this->admin_map_style_dbentity = new Mwp_Admin_Theme_Map_DBEntity;
		$this->model_map = new Mwp_Theme_Map_Model;
	}
}
