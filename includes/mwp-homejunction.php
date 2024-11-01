<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function mwp_has_homejunction_connection(){
	$ret = Mwp_HomeJunction_Adapter::get_instance()->authenticate();
	if( isset($ret->status)
		&& $ret->status == 'active' 
		&& $ret->success 
	){
		return true;
	}
	return false;
}
function mwp_default_list_type(){
	global $mwp;
	return $mwp['homejunction']['list_type'];
}
function mwp_hji_prefix(){
	global $mwp;
	return $mwp['homejunction']['prefix'];
}
function mwp_hji_get_property_types(){
	if( mwp_get_current_api_source() == 'hji' ){
		$f = new Mwp_HomeJunction_PropertyFields;
		return $f->get_property_type();
	}
}
function mwp_hji_list_type(){
}
function mwp_hji_property_type(){
}
function mwp_hji_show_days_on_market(){
	if( mwp_hji_days_on_market() && mwp_hji_days_on_market() <= 7 ){
		return true;
	}
	return false;
}
