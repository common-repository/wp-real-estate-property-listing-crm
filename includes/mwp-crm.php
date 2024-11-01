<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get api key
 * */
function mwp_get_crm_key(){
	global $mwp_crm;
	return $mwp_crm->key('r', 0);
}
/**
 * get api token
 * */
function mwp_get_crm_token(){
	global $mwp_crm;
	return $mwp_crm->token('r', 0);
}
/**
 * get api broker id
 * */
function mwp_get_crm_brokerid(){
	global $mwp_crm;
	return $mwp_crm->brokerid('r', 0);
}
/**
 * get current feed
 * */
function mwp_get_current_api_source(){
	global $mwp_crm;
	return $mwp_crm->default_feed('r', 'crm');
} 
/**
 * check if has crm credentials key
 * */
function mwp_has_crm_credentials(){
	if( mwp_get_crm_key() && mwp_get_crm_token() ){
		return true;
	}
	return false;
}
/**
 * crm api details
 * */
function mwp_crm_api_endpoint(){
	return mwp_config_crm('api_endpoint');
}
function mwp_crm_api_version(){
	return mwp_config_crm('api_version');
}
function mwp_valid_api(){
	global $mwp;
	return $mwp['api_feed'];
}
function mwp_get_property_transaction_type(){
	return array(
		'for sale' => 'For Sale',
		'for rent' => 'For Rent',
		'foreclosure' => 'Foreclosure',
		'private sales' => 'Private Sales',
		'to let' => 'To Let'
	);
}
