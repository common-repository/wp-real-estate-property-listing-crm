<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function _label($str_label){
	global $mwp;
	
	$arr_label = $mwp['property_label'];
	if( has_filter('mwp_append_label_array') ){
		$hook_label 	= apply_filters('mwp_append_label_array',$arr_label);
		$arr_label	= array_merge($hook_label, $arr_label);
	}

	if( has_filter('mwp_change_key_label') ){//filter first
		$arr_label = apply_filters('mwp_change_key_label', $arr_label);
		return __($arr_label[$str_label], mwp_localize_domain());
	}else{
		$db_label = Mwp_Theme_Text_Model::get_instance()->mwp_theme_text();
		if( $db_label && 
			isset($db_label[$str_label]) 
			&& trim($db_label[$str_label]) != ''
		){//check text db first
			return $db_label[$str_label];
		}elseif( isset($arr_label[$str_label]) ){//else original text
			return __($arr_label[$str_label], mwp_localize_domain());
		}	
	}
}
function mwp_trim_tolower($str){
	return strtolower(mwp_remove_whitespace(mwp_remove_nonaplha($str)));
}
function mwp_remove_whitespace($string){
	return preg_replace('/\s+/', '', $string);
}
function mwp_remove_nonaplha($string){
	return Mwp_Helpers_Text::remove_non_alphanumeric($string);
}
function mwp_is_property_details_page(){
	global $wp_query;
	$property_page = new Mwp_PropertyDetailsURL;
	if( $wp_query->get( $property_page->property_detail_uri_var() ) 
		&& $wp_query->get( $property_page->property_detail_uri_var() ) == $property_page->property_detail_url()
	) {
		return true;
	}
	return false;
}
function mwp_manual_is_property_details_page(){
	$is_property_details_page = false;
	if( isset($_SERVER['REQUEST_URI']) ){
		$property_page = new Mwp_PropertyDetailsURL;
		$explode = explode('/', $_SERVER['REQUEST_URI']);
		if( in_array($property_page->property_detail_url(), $explode) ){
			$is_property_details_page = true;
		}
	}
	return $is_property_details_page;
}
function mwp_is_search_result_page(){
	global $wp_query;
	$url = new Mwp_SearchPropertyURL;
	if( $wp_query->get( $url->uri_var() )
		&& $wp_query->get( $url->uri_var() ) == $url->url()
	){
		return true;
	}
	return false;
}
function md_add_campaign($ret_push_crm, $key = null){
	if( is_null($key) ){
		$key = mwp_get_crm_key();
	}
	if(
		isset($ret_push_crm->result)
		&&  $ret_push_crm->result == 'success'
	){
		$lead_id = $ret_push_crm->leadid;
		$url = "http://www.masterdigm.com/campaigns/lead_campaign_setup.php?leadid={$lead_id}&key={$key}";
		$add_campaign = file_get_contents($url);
	}
}
function mwp_localize_script(){
	return array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'security' => wp_create_nonce( 'md-ajax-request' ),
		'ajax_indicator' => '',
		'ajax_indicator' => mwp_asset_url() . 'ajax-loader-big-circle.gif',
		'masonry_container' => 'search-result',
		'fb_key'	=>	'',
		'has_map_boundaries_support' =>	'',
		'msg_search_form_get_coordinates' =>	__('Please wait while we get current location coordinates', mwp_localize_domain()),
		'email_to_msg'	=>	__('Check this property located at', mwp_localize_domain()),
		'lang_save_search_btn_txt'	=>	__('Saved Search', mwp_localize_domain()),
		'lang_save_search_ajx_msg'	=>	__('Saving search', mwp_localize_domain()),
		'lang_register_btn_signup'	=>	__('Sign Up', mwp_localize_domain()),
		'lang_register_btn_login'	=>	__('Login', mwp_localize_domain()),
		'lang_register_ajx_pls_wait_msg'	=>	__('Please wait signing-up', mwp_localize_domain()),
		'lang_register_ajx_process_msg'	=>	__('Processing', mwp_localize_domain()),
		'lang_loading' => __('Loading', mwp_localize_domain()),
		'lang_map_fetch_property_details'	=>	__('Fetching property details, please wait', mwp_localize_domain()),
		'lang_map_get_data'	=>	__('Please wait while getting data', mwp_localize_domain()),
		'lang_inquire_send'	=>	__('Sending Inquiry', mwp_localize_domain()),
		'lang_send_btn_txt'	=>	__('Send', mwp_localize_domain()),
		'lang_account_msg_update'	=>	__('Please wait, updating profile', mwp_localize_domain()),
		'lang_account_msg_update_pw'	=>	__('Please wait, updating password', mwp_localize_domain()),
		'default_search_by'	=>	'use_fulltext_search',	
		'default_feed'	=>	mwp_get_current_api_source(),
		'hji_getpropertytypes' => mwp_hji_get_property_types()	
	);
}
/**
 * get hierarchy location of mls
 * @param	$obj_property_data 		array | mls object entity			pass the mls property entity
 * @param	$get_coverage_lookup	array | data set of getCoverageLookup
 * @param	$gc_array_key			string | key of getCoverageLookup	default is keyword, another is full
 *
 * @return associative array
 * */
function get_mls_hierarchy_location($obj_property_data, $get_coverage_lookup, $gc_array_key = 'keyword'){
	$matches = array();
	$ret = array();
	$search_location = '';
	$community = '';
	$city = '';
	$location = $get_coverage_lookup;

	if( $location->result == 'success' ){
		$array_location = json_decode(json_encode($location->lookups), true);
		if( isset($obj_property_data->Community) && trim($obj_property_data->Community) != '' ){
			$obj_community = mwp_remove_nonaplha($obj_property_data->Community);
			$community 	= trim(strtolower($obj_community));
			$community  = explode(' ',$community );
			if( count($community ) >= 3 ){
				$community  = strtolower($community[0].' '.$community[1]);
			}elseif( count($community ) >= 2 ){
				$community  = trim(strtolower($community [0]));
			}else{
				$community  = trim(strtolower($community [0]));
			}
		}
		if(isset($obj_property_data->City) && $obj_property_data->City != ''){
			$obj_city = mwp_remove_nonaplha($obj_property_data->City);
			$city = trim(strtolower($obj_city));
		}
		$matches['country'] = array(
			'id' => 0,
			'city_id' => 0,
			'type' => 'city',
			'full' => '-1',
			'keyword' => '-1',
		);

		if(isset($obj_property_data->State) && $obj_property_data->State != ''){
			$matches['state'] = array(
				'keyword' => $obj_property_data->State,
				'id' => 0,
				'city_id' => 0,
				'type' => 'city',
				'full' => '-1',
			);
		}else{
			$matches['state'] = array(
				'id' => 0,
				'city_id' => 0,
				'type' => 'city',
				'full' => '-1',
				'keyword' => '-1',
			);
		}
		if(isset($obj_property_data->County) && $obj_property_data->County != ''){
			$matches['county'] = array(
				'keyword' => $obj_property_data->County,
				'id' => 0,
				'city_id' => 0,
				'type' => 'city',
				'full' => '-1',
			);
		}else{
			$matches['county'] = array(
				'keyword' => '',
				'id' => 0,
				'city_id' => 0,
				'type' => 'city',
				'full' => '-1',
			);
		}
		/**
		 * loop through array_location
		 * */
		$city_id = 0;
		$indx_community = 0;
		$matches['city'] = array(
			'id' => 0,
			'city_id' => 0,
			'type' => 'city',
			'full' => '-1',
			'keyword' => '-1',
		);
		foreach($array_location as $key => $val){
			$keyword = strtolower(trim($val[$gc_array_key]));

			if ($city != '' && strcmp($city, $keyword) == 0) {
				$city_id = $val['id'];
				if( $val['location_type'] == 'city' ){
					$matches['city'] = array(
						'id' => $val['id'],
						'type' => $val['location_type'],
						'full' => $val['full'],
						'keyword' => $val['keyword'],
					);
				}
			}

			if ( $community != '' && preg_match("/$community/", $keyword) ) {
				if( $val['location_type'] == 'community' && $matches['city']['id'] == $val['city_id'] ){
					$matches['community'][] = array(
						'id' 		=> $val['id'],
						'city_id' 	=> $val['city_id'],
						'type' 		=> $val['location_type'],
						'full' 		=> $val['full'],
						'keyword' 	=> $val['keyword'],
					);
				}
			}
		}

		if( isset($matches['community']) && count($matches['community']) > 0 ){
			foreach($matches['community'] as $key => $val){
				if( $matches['city']['id'] == $val['city_id'] ){
					$matches['community'] = array(
						'id' 		=> $val['id'],
						'city_id' 	=> $val['city_id'],
						'type' 		=> 'community',
						'full' 		=> $val['full'],
						'keyword' 	=> $val['keyword'],
					);
				}
			}
		}else{
			$matches['community'] = array(
				'id' => 0,
				'city_id' => 0,
				'type' => 'community',
				'full' => '-1',
				'keyword' => '-1',
			);
		}

		$matches['zip'] = array(
			'id' => 0,
			'city_id' => 0,
			'type' => 'city',
			'full' => '-1',
			'keyword' => '-1',
		);

		return $matches;
	}
}
function print_pdf($property_id, $source_api = null){
	$data = mwp_get_data_loop();
	if( is_null($source_api) ){
		$source_api = mwp_get_current_api_source();
	}
	if(
		$source_api == 'crm'
		&& $data->flyer_file_key() != ''
	){
		$k = $data->flyer_file_key();
		return "http://www.masterdigm.com/cdoc?k={$k}";
	}else{
		return get_option('siteurl') . '/printpdf/' . $property_id . '/' . $source_api;
	}
}
function mwp_showpopup_close(){
	if( 
		Mwp_Settings_Popup_DBEntity::get_instance()->get_popup_show() == 1 
		&& mwp_manual_is_property_details_page()
		&& Mwp_Settings_Popup_DBEntity::get_instance()->get_popup_close() == 0
	){
		return true;
	}
	return false;
}
function mwp_get_page_by_name($pagename){
	$pages = get_pages();
	$pagename = strtolower( str_replace(' ','-',$pagename) );
	foreach ($pages as $page){
		 if ($page->post_name == $pagename) return $page;
	}
	return false;
}
function mwp_get_query_view_uri(){
	$query_string = '';
	if( isset($_SERVER['QUERY_STRING']) ){
		$r = parse_url($_SERVER['QUERY_STRING']);
		parse_str($r['path'],$get_arr);
		unset($get_arr['view']);
		unset($get_arr['fullscreen']);
		if( count($get_arr) > 1 && isset($get_arr['location']) ){
			$query = '?' . http_build_query($get_arr) . '&';
		}else{
			$query = '?';
		}
	}
	return $query;
}
function mwp_search_uri_query($view_query_string){
	$query 	= mwp_get_query_view_uri();
	$uri 	= Mwp_SearchPropertyURL::get_instance()->get_url() . $query . $view_query_string;
	return $uri;
}
function mwp_get_email(){
	$mail = new Mwp_Admin_Settings_Mail_DBEntity;
	return $mail->get_email();
}
function mwp_get_plugin_data(){
	if ( !function_exists( 'get_plugin_data' ) ) { 
		require_once ABSPATH . '/wp-admin/includes/plugin.php'; 
		return get_plugin_data( __FILE__ );
	}
	return false;
}
function mwp_get_map_zoom(){
	return Mwp_Admin_Theme_Map_DBEntity::get_instance()->get_mwp_zoom();
}
function mwp_search_result_current_view(){
	$view = 'list';
	if( isset($_GET['view']) && $_GET['view'] == 'map' ){
		$view = $_GET['view'];
	}
	return $view;
}
function mwp_is_search_view_list(){
	return mwp_search_result_current_view() == 'list' ? true:false;
}
function mwp_is_search_view_map(){
	return mwp_search_result_current_view() == 'map' ? true:false;
}
function mwp_can_create_page_locations(){
	if( mwp_get_current_api_source() == 'hji' ){
		return false;
	}
	return true;
}
function mwp_set_page_list($items, $index){

	if( $items >= $index ){
		return true;
	}
	return false;
}
function mwp_urlencode($url){
	return str_replace(' ','%20',$url);
}
//check start execution time
function mwp_start_execution_time(){
	if( defined('MWP_EXECUTION_TIME') ){
		Mwp_Loadtime::get_instance()->start();
	}
}
function mwp_end_execution_time($msg){
	if( defined('MWP_EXECUTION_TIME') ){
		Mwp_Loadtime::get_instance()->end($msg);
	}
}
function mwp_seo_plugin(){
	/**
	 * Detect plugin. For use on Front End only.
	 */
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	// check for plugin using plugin name
	if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) 
	) {
	  //plugin is activated
	  return true;
	} 
	return false;
}
function mwp_geocode_coordinates($lat, $lng){
	$geocode = Mwp_Helpers_Gmap::getLocationByCoordinates($lat,$lng);
	if( $geocode && isset($geocode['results']) && isset($geocode['results'][0]) ){
		return $geocode['results'][0]['formatted_address'];
	}
	return false;
}
