<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Theme_Style_Model{
	protected static $instance = null;
	public $md_wp_theme_style = 'masterdigm_wp_theme_style';
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

	public function md_wp_theme_style($action = '', $value = ''){
		$prefix = $this->md_wp_theme_style;
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_list_main_background($action = '', $value = ''){
		$prefix = 'mwp_list_main_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_list_active_label($action = '', $value = ''){
		$prefix = 'mwp_list_active_label';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_list_secondary_background($action = '', $value = ''){
		$prefix = 'mwp_list_secondary_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_list_font_color($action = '', $value = ''){
		$prefix = 'mwp_list_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_list_hover_font_color($action = '', $value = ''){
		$prefix = 'mwp_list_hover_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_list_main_content_font_color($action = '', $value = ''){
		$prefix = 'mwp_list_main_content_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_list_main_content_second_font_color($action = '', $value = ''){
		$prefix = 'mwp_list_main_content_second_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_list_main_content_heading_color($action = '', $value = ''){
		$prefix = 'mwp_list_main_content_heading_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_list_border_color($action = '', $value = ''){
		$prefix = 'mwp_list_border_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	//details
	public function mwp_details_tab_active_background($action = '', $value = ''){
		$prefix = 'mwp_details_tab_active_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_details_tab_hover_background($action = '', $value = ''){
		$prefix = 'mwp_details_tab_hover_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_details_tab_hover_font_color($action = '', $value = ''){
		$prefix = 'mwp_details_tab_hover_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_details_tab_active_fontcolor($action = '', $value = ''){
		$prefix = 'mwp_details_tab_active_fontcolor';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_details_tab_inactive_background($action = '', $value = ''){
		$prefix = 'mwp_details_tab_inactive_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_details_tab_inactive_fontcolor($action = '', $value = ''){
		$prefix = 'mwp_details_tab_inactive_fontcolor';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	//details overall
	public function mwp_details_main_page_background($action = '', $value = ''){
		$prefix = 'mwp_details_main_page_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_details_main_background($action = '', $value = ''){
		$prefix = 'mwp_details_main_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_details_main_font_color($action = '', $value = ''){
		$prefix = 'mwp_details_main_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_details_secondary_background($action = '', $value = ''){
		$prefix = 'mwp_details_secondary_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_details_secondary_font_color($action = '', $value = ''){
		$prefix = 'mwp_details_secondary_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_details_content_main_fontcolor($action = '', $value = ''){
		$prefix = 'mwp_details_content_main_fontcolor';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_details_content_main_heading_fontcolor($action = '', $value = ''){
		$prefix = 'mwp_details_content_main_heading_fontcolor';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_details_content_secondary_fontcolor($action = '', $value = ''){
		$prefix = 'mwp_details_content_secondary_fontcolor';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	//details
	public function mwp_search_main_page_background($action = '', $value = ''){
		$prefix = 'mwp_search_main_page_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_details_content_border_color($action = '', $value = ''){
		$prefix = 'mwp_details_content_border_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_button_main_background($action = '', $value = ''){
		$prefix = 'mwp_button_main_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_button_font_color($action = '', $value = ''){
		$prefix = 'mwp_button_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_button_secondary_background($action = '', $value = ''){
		$prefix = 'mwp_button_secondary_background';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}

	public function mwp_button_secondary_fontcolor($action = '', $value = ''){
		$prefix = 'mwp_button_secondary_fontcolor';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_button_border_color($action = '', $value = ''){
		$prefix = 'mwp_button_border_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	//header
	public function mwp_header_main_background_color($action = '', $value = ''){
		$prefix = 'mwp_header_main_background_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_header_secondary_background_color($action = '', $value = ''){
		$prefix = 'mwp_header_secondary_background_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_header_primary_font_color($action = '', $value = ''){
		$prefix = 'mwp_header_primary_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_header_secondary_font_color($action = '', $value = ''){
		$prefix = 'mwp_header_secondary_font_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_header_heading_color($action = '', $value = ''){
		$prefix = 'mwp_header_heading_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function mwp_header_border_color($action = '', $value = ''){
		$prefix = 'mwp_header_border_color';
		switch($action){
			case 'd':
				delete_option($prefix);
			break;
			case 'u':
				update_option($prefix, $value);
			break;
			default:
			case 'r':
				return get_option($prefix, $value);
			break;
		}
	}
	public function __construct(){}
}
