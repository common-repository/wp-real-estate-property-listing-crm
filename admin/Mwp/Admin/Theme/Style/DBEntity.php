<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Theme_Style_DBEntity {
	protected static $instance = null;
	protected $mwp_config;
	protected $theme_model = null;
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

	public function get_wp_style(){
		$config = $this->mwp_config;
		$color = $config['template']['color'];
		return $this->theme_model->md_wp_theme_style('r', $color);
	}
	public function get_mwp_list_main_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_list_main_background'];
		return $this->theme_model->mwp_list_main_background('r', $color);
	}
	public function get_mwp_list_active_label(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_list_active_label'];
		return $this->theme_model->mwp_list_active_label('r', $color);
	}
	public function get_mwp_list_secondary_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_list_secondary_background'];
		return $this->theme_model->mwp_list_secondary_background('r', $color);
	}
	public function get_mwp_list_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_list_font_color'];
		return $this->theme_model->mwp_list_font_color('r', $color);
	}
	public function get_mwp_list_hover_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_list_hover_font_color'];
		return $this->theme_model->mwp_list_hover_font_color('r', $color);
	}
	public function get_mwp_list_main_content_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_list_main_content_font_color'];
		return $this->theme_model->mwp_list_main_content_font_color('r', $color);
	}
	public function get_mwp_list_main_content_second_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_list_main_content_second_font_color'];
		return $this->theme_model->mwp_list_main_content_second_font_color('r', $color);
	}
	public function get_mwp_list_main_content_heading_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_list_main_content_heading_color'];
		return $this->theme_model->mwp_list_main_content_heading_color('r', $color);
	}
	public function get_mwp_list_border_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_list_border_color'];
		return $this->theme_model->mwp_list_border_color('r', $color);
	}
	//details
	public function get_mwp_details_tab_active_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_tab_active_background'];
		return $this->theme_model->mwp_details_tab_active_background('r', $color);
	}
	public function get_mwp_details_tab_active_fontcolor(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_tab_active_fontcolor'];
		return $this->theme_model->mwp_details_tab_active_fontcolor('r', $color);
	}
	public function get_mwp_details_tab_inactive_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_tab_inactive_background'];
		return $this->theme_model->mwp_details_tab_inactive_background('r', $color);
	}
	public function get_mwp_details_tab_inactive_fontcolor(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_tab_inactive_fontcolor'];
		return $this->theme_model->mwp_details_tab_inactive_fontcolor('r', $color);
	}
	//details
	//details overall
	public function get_mwp_details_main_page_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_main_page_background'];
		return $this->theme_model->mwp_details_main_page_background('r', $color);
	}
	public function get_mwp_details_main_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_main_background'];
		return $this->theme_model->mwp_details_main_background('r', $color);
	}
	public function get_mwp_details_main_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_main_font_color'];
		return $this->theme_model->mwp_details_main_font_color('r', $color);
	}
	public function get_mwp_details_secondary_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_secondary_background'];
		return $this->theme_model->mwp_details_secondary_background('r', $color);
	}
	public function get_mwp_details_secondary_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_secondary_font_color'];
		return $this->theme_model->mwp_details_secondary_font_color('r', $color);
	}
	public function get_mwp_details_content_main_fontcolor(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_content_main_fontcolor'];
		return $this->theme_model->mwp_details_content_main_fontcolor('r', $color);
	}
	public function get_mwp_details_content_main_heading_fontcolor(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_content_main_heading_fontcolor'];
		return $this->theme_model->mwp_details_content_main_heading_fontcolor('r', $color);
	}
	public function get_mwp_details_content_secondary_fontcolor(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_content_secondary_fontcolor'];
		return $this->theme_model->mwp_details_content_secondary_fontcolor('r', $color);
	}
	public function get_mwp_details_tab_hover_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_tab_hover_font_color'];
		return $this->theme_model->mwp_details_tab_hover_font_color('r', $color);
	}
	public function get_mwp_details_tab_hover_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_tab_hover_background'];
		return $this->theme_model->mwp_details_tab_hover_background('r', $color);
	}
	//details overall
	//form
	public function get_mwp_search_main_page_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_search_main_page_background'];
		return $this->theme_model->mwp_search_main_page_background('r', $color);
	}
	public function get_mwp_button_main_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_button_main_background'];
		return $this->theme_model->mwp_button_main_background('r', $color);
	}
	public function get_mwp_button_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_button_font_color'];
		return $this->theme_model->mwp_button_font_color('r', $color);
	}
	public function get_mwp_button_secondary_background(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_button_secondary_background'];
		return $this->theme_model->mwp_button_secondary_background('r', $color);
	}
	public function get_mwp_button_secondary_fontcolor(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_button_secondary_fontcolor'];
		return $this->theme_model->mwp_button_secondary_fontcolor('r', $color);
	}
	public function get_mwp_button_border_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_button_border_color'];
		return $this->theme_model->mwp_button_border_color('r', $color);
	}
	public function get_mwp_details_content_border_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_details_content_border_color'];
		return $this->theme_model->mwp_details_content_border_color('r', $color);
	}
	
	//form
	//header
	public function get_mwp_header_main_background_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_header_main_background_color'];
		return $this->theme_model->mwp_header_main_background_color('r', $color);
	}
	public function get_mwp_header_secondary_background_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_header_secondary_background_color'];
		return $this->theme_model->mwp_header_secondary_background_color('r', $color);
	}
	public function get_mwp_header_primary_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_header_primary_font_color'];
		return $this->theme_model->mwp_header_primary_font_color('r', $color);
	}
	public function get_mwp_header_secondary_font_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_header_secondary_font_color'];
		return $this->theme_model->mwp_header_secondary_font_color('r', $color);
	}
	public function get_mwp_header_heading_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_header_heading_color'];
		return $this->theme_model->mwp_header_heading_color('r', $color);
	}
	public function get_mwp_header_border_color(){
		$config = $this->mwp_config;
		$color = $config['template']['mwp_header_border_color'];
		return $this->theme_model->mwp_header_border_color('r', $color);
	}
	//header
	public function db_update_list_color($input = array()){
		if( count($input) > 0 && is_array($input) ){
			foreach($input as $key => $val){
				$this->theme_model->$key('u', $val);
			}
		}
	}
	
	public function db_update($input = array()){
		$config = $this->mwp_config;
		$color = $config['template']['color'];
		if( isset($input['color']) ){
			$color = $input['color'];
		}
		return $this->theme_model->md_wp_theme_style('u', $color);
	}
	
	public function db_delete_all_options(){}
	
	public function __construct(){
		global $mwp;
		$this->mwp_config = $mwp;
		$this->theme_model = new Mwp_Theme_Style_Model;
	}
}
