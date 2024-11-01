<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Theme_Style extends Mwp_Base{
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

	public function update_theme_colorstyle(){
		$this->theme_style_dbentity->db_update_list_color($_POST['list']);
		$this->theme_style_dbentity->db_update_list_color($_POST['details']);
		$this->theme_style_dbentity->db_update_list_color($_POST['form']);
		$this->theme_style_dbentity->db_update_list_color($_POST['header']);
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
		$data['url_slug'] = $this->admin_theme_style_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['current_color'] = $this->theme_style_dbentity->get_wp_style();
		$data['mwp_list_main_background'] = $this->theme_style_dbentity->get_mwp_list_main_background();
		$data['mwp_list_active_label'] = $this->theme_style_dbentity->get_mwp_list_active_label();
		$data['mwp_list_secondary_background'] = $this->theme_style_dbentity->get_mwp_list_secondary_background();
		$data['mwp_list_font_color'] = $this->theme_style_dbentity->get_mwp_list_font_color();
		$data['mwp_list_hover_font_color'] = $this->theme_style_dbentity->get_mwp_list_hover_font_color();
		$data['mwp_list_main_content_font_color'] = $this->theme_style_dbentity->get_mwp_list_main_content_font_color();
		$data['mwp_list_main_content_heading_color'] = $this->theme_style_dbentity->get_mwp_list_main_content_heading_color();
		$data['mwp_list_main_content_second_font_color'] = $this->theme_style_dbentity->get_mwp_list_main_content_second_font_color();
		$data['mwp_list_border_color'] = $this->theme_style_dbentity->get_mwp_list_border_color();
		$data['mwp_details_tab_active_background'] = $this->theme_style_dbentity->get_mwp_details_tab_active_background();
		$data['mwp_details_tab_active_fontcolor'] = $this->theme_style_dbentity->get_mwp_details_tab_active_fontcolor();
		$data['mwp_details_tab_inactive_background'] = $this->theme_style_dbentity->get_mwp_details_tab_inactive_background();
		$data['mwp_details_tab_inactive_fontcolor'] = $this->theme_style_dbentity->get_mwp_details_tab_inactive_fontcolor();
		$data['mwp_details_main_page_background'] = $this->theme_style_dbentity->get_mwp_details_main_page_background();
		$data['mwp_details_main_background'] = $this->theme_style_dbentity->get_mwp_details_main_background();
		$data['mwp_details_main_font_color'] = $this->theme_style_dbentity->get_mwp_details_main_font_color();
		$data['mwp_details_secondary_background'] = $this->theme_style_dbentity->get_mwp_details_secondary_background();
		$data['mwp_details_secondary_font_color'] = $this->theme_style_dbentity->get_mwp_details_secondary_font_color();
		$data['mwp_details_content_main_fontcolor'] = $this->theme_style_dbentity->get_mwp_details_content_main_fontcolor();
		$data['mwp_details_content_main_heading_fontcolor'] = $this->theme_style_dbentity->get_mwp_details_content_main_heading_fontcolor();
		$data['mwp_details_content_secondary_fontcolor'] = $this->theme_style_dbentity->get_mwp_details_content_secondary_fontcolor();
		$data['mwp_details_content_border_color'] = $this->theme_style_dbentity->get_mwp_details_content_border_color();
		$data['mwp_search_main_page_background'] = $this->theme_style_dbentity->get_mwp_search_main_page_background();
		$data['mwp_button_main_background'] = $this->theme_style_dbentity->get_mwp_button_main_background();
		$data['mwp_button_font_color'] = $this->theme_style_dbentity->get_mwp_button_font_color();
		$data['mwp_button_secondary_background'] = $this->theme_style_dbentity->get_mwp_button_secondary_background();
		$data['mwp_button_secondary_fontcolor'] = $this->theme_style_dbentity->get_mwp_button_secondary_fontcolor();
		$data['mwp_button_border_color'] = $this->theme_style_dbentity->get_mwp_button_border_color();
		$data['mwp_header_main_background_color'] = $this->theme_style_dbentity->get_mwp_header_main_background_color();
		$data['mwp_header_secondary_background_color'] = $this->theme_style_dbentity->get_mwp_header_secondary_background_color();
		$data['mwp_header_primary_font_color'] = $this->theme_style_dbentity->get_mwp_header_primary_font_color();
		$data['mwp_header_secondary_font_color'] = $this->theme_style_dbentity->get_mwp_header_secondary_font_color();
		$data['mwp_header_heading_color'] = $this->theme_style_dbentity->get_mwp_header_heading_color();
		$data['mwp_header_border_color'] = $this->theme_style_dbentity->get_mwp_header_border_color();
		$data['mwp_details_tab_hover_background'] = $this->theme_style_dbentity->get_mwp_details_tab_hover_background();
		$data['mwp_details_tab_hover_font_color'] = $this->theme_style_dbentity->get_mwp_details_tab_hover_font_color();
		
		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('theme/settings/color-style.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_theme_style(){

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
		$this->admin_theme_style_entity = new Mwp_Admin_Theme_Style_Entity;
		$this->admin_theme_style_wpentity = new Mwp_Admin_Theme_Style_WPEntity;
		$this->admin_theme_style_dbentity = new Mwp_Admin_Theme_Style_DBEntity;
		$this->theme_style_dbentity = new Mwp_Admin_Theme_Style_DBEntity;
		$this->model = new Mwp_Theme_Style_Model;
	}
}
