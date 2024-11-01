<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get and locate template
 * the display uses template_include hook
 * */
class Mwp_Theme_PropertyDetails{
	protected static $instance = null;

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
		return mwp_property_details_template();
	}
	
	private function _parse_url($url){
		$uri_source = mwp_valid_api();
		$parse_url = array(
			'id' => '',
			'url_source' => '',
			'default_source' => mwp_get_current_api_source(),
		);
		$arr = explode( '-', $url);
		$default_source = mwp_get_current_api_source();
		
		if( count($arr) > 0 ){
			foreach($arr as $key => $val){
				if( in_array($val, $uri_source) ){
					$parse_url['url_source'] = $val;
				}else{
					$parse_url['url_source'] = mwp_get_current_api_source();
				}
			}
		}
		if( has_filter('md_property_details_parse_uri_' . $parse_url['url_source']) ){
			$parse_url['id'] = apply_filters('md_property_details_parse_uri_' . $parse_url['url_source'], $arr);
		}else{
			$parse_url['id'] = $arr[0];
		}
		return $parse_url;
	}
	
	/**
	 * display the property details layout
	 * this uses template_include hook
	 * https://codex.wordpress.org/Plugin_API/Filter_Reference/template_include
	 * */	
	public function display($template){
		global $wp_query, $plugin, $mwp_loop;
		if( mwp_is_property_details_page() ) {
			$property_page = new Mwp_PropertyDetailsURL;
			$data = array();
			$arr_property_details_layout = array();
			$url = $wp_query->get( 'url' );
			$parse_url = $this->_parse_url($url);
			$config = $property_page->config_property_details();
			$arr_property_details_layout['container'] = mwp_property_details_template();
			$template_file = Mwp_Theme_Locator::get_instance()->locate_template($arr_property_details_layout['container']);

			$data['breadcrumb'] = false;
			$data['mwp_loop'] = $mwp_loop;
			$data['wp_query'] = $wp_query;
			$data['parse_url'] = $parse_url;
			$data['part_header'] = Mwp_Theme_Locator::get_instance()->locate_template('property-details/header.php');
			$data['part_photo_carousel'] = Mwp_Theme_Locator::get_instance()->locate_template('property-details/carousel.php');
			$data['part_footer'] = Mwp_Theme_Locator::get_instance()->locate_template('property-details/footer.php');
			$data['part_content'] = Mwp_Theme_Locator::get_instance()->locate_template('property-details/content.php');
			$listing_information = $parse_url['url_source'] . '/listing-information.php';
			$data['part_listing_information'] = Mwp_Theme_Locator::get_instance()->locate_template($listing_information);
			$more_listing_information = $parse_url['url_source'] . '/more-listing-information.php';
			$data['part_more_listing_information'] = Mwp_Theme_Locator::get_instance()->locate_template($more_listing_information);
			$tab_map = 'property-details/tab-map.php';
			$data['tab_map'] = Mwp_Theme_Locator::get_instance()->locate_template($tab_map);
			$data['tab_walkscore'] = Mwp_Theme_Locator::get_instance()->locate_template('property-details/tab-walkscore.php');
			
			if( mwp_get_current_api_source() == 'crm' ){
				$data['tab_photos'] = Mwp_Theme_Locator::get_instance()->locate_template('property-details/tab-photo-crm.php');
			}else{
				$data['tab_photos'] = Mwp_Theme_Locator::get_instance()->locate_template('property-details/tab-photo.php');
			}
			
			$data['tab_school'] = Mwp_Theme_Locator::get_instance()->locate_template('property-details/tab-school.php');
			Mwp_View::get_instance()->has_filter_single_property = false;
			$data['property_data'] = array();
			$data['property_address'] = '';
			if( has_filter('md_single_property_' . $parse_url['url_source']) ){
				$data['property_data'] = apply_filters('md_single_property_' . $parse_url['url_source'], $parse_url);
				Mwp_View::get_instance()->has_filter_single_property = true;
				if( isset($data['property_data']->property_data[0]) ){
					$data['property_address'] = $data['property_data']->property_data[0]->get_address();
				}
			}
			if( has_filter('mwp_breadcrumb_' . $parse_url['url_source']) ){
				$data['breadcrumb'] = apply_filters('mwp_breadcrumb_' . $parse_url['url_source'], $parse_url, $data['property_data']);
			}
			$data['switch_view'] = Mwp_Theme_Locator::get_instance()->locate_template('mwp-switch-view.php');
			$data['total_data'] = 0;
			$data['search_uri_query'] = array();
			$data['mwp_body_class'] = 'mwp-property-details-page';
			$data['class_nav_bar'] = 'navbar-static-top';
			$data['mwp_header_class'] = 'mwp-property-details-page-search-form ';
			//mwp_dump($data['property_data']->property_data[0]);
			Mwp_View::get_instance()->switch_view = $data['switch_view'];
			Mwp_View::get_instance()->data_switch_view = array();
			Mwp_View::get_instance()->obj = $this;
			Mwp_View::get_instance()->data = $data;
			Mwp_View::get_instance()->header = Mwp_Theme_Locator::get_instance()->locate_template('mwp-header.php');
			Mwp_View::get_instance()->header_four_oh_four = Mwp_Theme_Locator::get_instance()->locate_template('header-404.php');
			Mwp_View::get_instance()->footer = Mwp_Theme_Locator::get_instance()->locate_template('mwp-footer.php');
			if( mwp_get_current_api_source() == 'crm' ){
				if( mwp_is_display_tag_line() ){
					Mwp_View::get_instance()->title = $data['property_data']->property_data[0]->tag_line;
				}else{
					Mwp_View::get_instance()->title = $data['property_address'];
				}
			}else{
				Mwp_View::get_instance()->title = $data['property_address'];
			}
			
			Mwp_View::get_instance()->current_uri = $wp_query->get( $property_page->property_detail_uri_var() );
			Mwp_View::get_instance()->current_view_type = '';

			$template_file = apply_filters('mwp_hook_property_details_main_template', $template_file);
			$template = Mwp_View::get_instance()->display($template_file, $data, false);
		}
		return $template;
	}
		
	public function __construct(){}	
}
