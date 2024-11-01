<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$crm_adapter = new Mwp_CRM_Adapter;
$crm_account_details = new Mwp_CRM_AccountDetails($crm_adapter);
$GLOBALS['crm_account_details'] = $crm_account_details;

function mwp_get_account_details(){
	global $crm_account_details;
	$res = $crm_account_details->account_details();
	if( $res && isset($res->result) && $res->result == 'success' ){
		return $res->data;
	}
	return false;
}
function mwp_get_account_data(){
	$account = mwp_get_account_details();
	return $account;
}
function mwp_get_account_data_key($key = null){
	global $crm_account_details;
	return $crm_account_details->get_account_data($key);
}
function mwp_get_account_currency(){
	$data = mwp_get_account_data();
	if( $data && isset($data->currency) ){
		return $data->currency;
	}
	return false;
}
function mwp_get_account_address(){
	$data = mwp_get_account_details();
	$country = '';
	$state = '';
	$settings_theme_map = Mwp_Theme_Map_Model::get_instance()->mwp_geo_address();
	if( $settings_theme_map ){
		return $settings_theme_map;
	}else{
		if( isset($data->country) ){
			$country = $data->country;
		}
		if( isset($data->state) ){
			$state = $data->state;
		}
		return $address = $country .', '. $state;
	}
}
function mwp_geocode_account_address(){
	$array_geo_location = array();
	$address = mwp_get_account_address();
	$address = Mwp_Admin_Theme_Map_DBEntity::get_instance()->get_geocode_address();
	$geocode = Mwp_Helpers_Gmap::geocode($address);
	
	if( $geocode['status'] == 'OK' ) {
		$array_geo_location = array(
			'lat' 		=> 	$geocode['results'][0]['geometry']['location']['lat'],
			'lng' 		=> 	$geocode['results'][0]['geometry']['location']['lng'],
			'result'	=>	true
		);
	}
	return $array_geo_location;
}
function mwp_great_school_api(){
	return Mwp_API_Greatschool_Model::get_instance()->md_greatschool_api_key('r');
}
function mwp_agent_details($attr = array()){
	$has_property = false;
	$property = array();
	$agent = array();
	if( isset($attr['property']) ){
		$property = $attr['property'];
		$has_property = true;
	}
	if( $has_property ){
		$agent = new Mwp_Agent_Init();
		$agent->set_agent_data($attr);
		return $agent;
	}
	return false;
}
function mwp_display_agent_details($attr = array()){
	$data['agent'] = mwp_agent_details($attr);
	if( $data['agent'] ){
		$template = Mwp_Theme_Locator::get_instance()->locate_template('partials/agent.php');
		Mwp_View::get_instance()->display($template, $data);
	}
}
function mwp_get_lead_status(){
	return Mwp_Settings_Lead_DBEntity::get_instance()->get_lead_status();
}
function mwp_get_lead_type(){
	return Mwp_Settings_Lead_DBEntity::get_instance()->get_lead_type();
}
function mwp_get_lead_source(){
	return Mwp_Settings_Lead_DBEntity::get_instance()->get_lead_source();
}
function mwp_get_property_types(){
	global $crm_account_details;
	return $crm_account_details->get_account_data('property_types');
}

