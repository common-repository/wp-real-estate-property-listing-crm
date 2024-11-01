<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get and locate template
 * the display uses template_include hook
 * */
class Mwp_Theme_SearchResult{
	protected static $instance = null;
	public $view;
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
	
	public function get_template(){
		return mwp_search_result_template();
	}
	
	public function set_view_type(){
		$this->view = mwp_search_result_current_view();
	}

	public function get_view_type(){
		return $this->view;
	}

	public function is_map_view(){
		return ($this->view == 'map') ? true:false;
	}

	/**
	 * display the property details layout
	 * this uses template_include hook
	 * https://codex.wordpress.org/Plugin_API/Filter_Reference/template_include
	 * */	
	public function display($template){
		global $wp_query, $mwp, $plugin;
		$url = new Mwp_SearchPropertyURL;
		if( mwp_is_search_result_page() ){
			
			$data = array();
			$arr_layout = array();
			$config = $url->config();
			$data['class'] = '';
			$paged = 1;
			$_REQUEST['paged'] = $paged;
			if( get_query_var( 'paged' ) ){
				$_REQUEST['paged'] = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ):$paged;
			}
			$_REQUEST['pagination'] = true;
			$data['wp_query'] = $wp_query;
			$_REQUEST['pagination'] = 1;
			$data['search_data'] = $_REQUEST;
			$data['current_view'] = $this->get_view_type();
			//get data

			$data['loop_data'] = apply_filters('mwp_hook_property_data_search_result_' . mwp_get_current_api_source(), $data);
			//mwp_dump($data['loop_data'],1);
			//view logic
			$view = $this->get_view_type();
			$content_template = apply_filters('mwp_hook_search_result_template_' . $view, array());
			//header
			$partial_header = $content_template['header'];
			//content
			$partial_content = $content_template['content'];
			//footer
			$partial_footer = $content_template['footer'];
			$arr_layout['container'] = mwp_search_result_template();
			$data['container_template'] = $content_template['container'];
			$data['part_header'] = $partial_header;
			$data['part_content'] = $partial_content;
			$data['part_footer'] = $partial_footer;
			$data['part_loop_template'] = $content_template['part_loop_template'];
			$data['class'] = 'mwp-thumbnail';
			$data['col'] = $content_template['col'];
			$data['limit'] = $content_template['limit'];
			$data['show_pagination'] = true;
			$data['switch_view'] = Mwp_Theme_Locator::get_instance()->locate_template('mwp-switch-view.php');
			$data['location_name'] = '';
			if( isset($_GET['location']) ){
				$data['location_name'] = urldecode($_GET['location']);
			}
			$data['search_keyword'] = array();
			
			if( isset($data['loop_data']) ){
				$data['search_keyword'] = $data['loop_data']->search_query_vars;
			}else{
				$data['search_keyword'] = $data['wp_query']->query;
			}
			$data['mls_type'] = '';
			if( isset($data['loop_data']->get_raw_property_api_data->mls) ){
				$data['mls_type'] = $data['loop_data']->get_raw_property_api_data->mls;
			}
			$data['atts_save_search']['search_keyword'] = $data['search_keyword'];
			$data['atts_save_search']['mls_type'] = $data['mls_type'];
			$data['total_data'] = 0;
			if( isset($data['loop_data']->property_data_total) ){
				$data['total_data'] = $data['loop_data']->property_data_total;
			}
			$data['no_data'] = false;
			if( $data['total_data'] == 0 ){
				$data['no_data'] = true;
			}
			$data['search_uri_query'] = '';
			if( isset($data['wp_query']->query['location']) ){
				unset($data['wp_query']->query['mwppage']);
				$data['search_uri_query'] = $data['wp_query']->query;
			}
			Mwp_View::get_instance()->search_uri_query = $data['search_uri_query'];
			$data['mwp_body_class'] = 'mwp-search-result-page-background mwp-search-result-page mwp-property-details-page-search-form mwp-current-view-'.$data['current_view'];
			$data['mwp_header_class'] = 'mwp-property-details-page-search-form mwp-current-view-'.$data['current_view'];
			$data['class_nav_bar'] = 'navbar-fixed-top';
			Mwp_View::get_instance()->obj = $this;
			Mwp_View::get_instance()->data = $data;
			Mwp_View::get_instance()->current_view = $data['part_content'];
			Mwp_View::get_instance()->container_template = $data['container_template'];
			Mwp_View::get_instance()->col_left = $content_template['col_left'];
			Mwp_View::get_instance()->col_map = $content_template['col_map'];
			Mwp_View::get_instance()->basename_map = $content_template['basename'];
			Mwp_View::get_instance()->header = Mwp_Theme_Locator::get_instance()->locate_template('mwp-header.php');
			Mwp_View::get_instance()->paged = $_REQUEST['paged'];
			Mwp_View::get_instance()->footer = Mwp_Theme_Locator::get_instance()->locate_template('mwp-footer.php');
			Mwp_View::get_instance()->data_switch_view = array();
			Mwp_View::get_instance()->switch_view = $data['switch_view'];
			Mwp_View::get_instance()->method_data = $_GET;
			Mwp_View::get_instance()->current_view_type = $view;
			Mwp_View::get_instance()->title = 'Search Result';
			Mwp_View::get_instance()->current_uri = $wp_query->get( $url->uri_var() );
			Mwp_View::get_instance()->col = $data['col'];
			Mwp_View::get_instance()->no_data = $data['no_data'];
			Mwp_View::get_instance()->header_four_oh_four = Mwp_Theme_Locator::get_instance()->locate_template('header-404.php');	
			$template_file = Mwp_Theme_Locator::get_instance()->locate_template($arr_layout['container']);
			$template_file = apply_filters('mwp_hook_search_result_main_template', $template_file);
			$template = Mwp_View::get_instance()->display($template_file, $data, false);
		}
		return $template;
	}

	public function __construct(){
		$this->set_view_type();
	}	
}
