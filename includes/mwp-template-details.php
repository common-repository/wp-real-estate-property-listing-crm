<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function mwp_greatschool_api(){
	$model = new Mwp_API_Greatschool_Model;
	$api = $model->md_greatschool_api_key('r');
	if( $api ){
		return $api;
	}
	return false;
}
function mwp_display_school_info($data){
	$model = new Mwp_API_Greatschool_Model;
	$entity = new Mwp_API_Greatschool_Entity;
	$address = '';
	if( isset($data['address']) ){
		$address = $data['address'];
	}	
	$state = '';
	if( isset($data['state']) ){
		$state = $data['state'];
	}	
	$arg = array(
		'address' => $address,
		'state' => $state,
	);

	if( mwp_greatschool_api() ){
		$res = $entity->school_nearby($arg);
		$data['res'] = $res;
		Mwp_View::get_instance()->display($data['template'], $data); 
	}
	return false;
}
function mwp_display_similar_property($parse_url, $data = array()){
	if( has_filter('property_nearby_property_' . $parse_url['url_source']) ){
		$similar_properties = apply_filters('property_nearby_property_' . $parse_url['url_source'], $data);
		if( $similar_properties->loop_property()
			&& $similar_properties->property_data_count > 1
		){
			$similar_homes = Mwp_Theme_Locator::get_instance()->locate_template('property-details/similar-homes.php');
			$data['grid_layout'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/mwp-loop-property-list-v2.php');
			$data['col'] = 2;
			$data['loop_data'] = $similar_properties;
			$data['parse_url'] = $parse_url;
			Mwp_View::get_instance()->display($similar_homes, $data);
		}
	}
}
function mwp_has_bookaview(){
	$db_book_a_viewing_url = Mwp_Settings_Property_DBEntity::get_instance()->get_book_a_viewing_url();
	$db_book_a_viewing_label = Mwp_Settings_Property_DBEntity::get_instance()->get_book_a_viewing_label();
	if( $db_book_a_viewing_url
		&& trim($db_book_a_viewing_url) != ''
		&& $db_book_a_viewing_label
		&& trim($db_book_a_viewing_label) != '' 
	){
		return true;
	}
	return false;
}
function mwp_bookaview_url(){
	return Mwp_Settings_Property_DBEntity::get_instance()->get_book_a_viewing_url();
}
function mwp_bookaview_label(){
	return Mwp_Settings_Property_DBEntity::get_instance()->get_book_a_viewing_label();
}
function mwp_bookaview_align(){
	return Mwp_Settings_Property_DBEntity::get_instance()->get_book_a_viewing_align();
}
