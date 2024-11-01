<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get array config setup
 * */
function mwp_config_setup($key = ''){
	global $mwp;
	return $mwp['setup'][$key];
}
function mwp_conf_email(){
	global $mwp;
	return mwp_config_setup('mail');
}
/**
 * get array config path
 * */
function mwp_config_path($key = ''){
	global $mwp;
	return $mwp['plugin_path'][$key];
}
/**
 * get array crm config
 * */
function mwp_config_crm($key = ''){
	global $mwp;
	return $mwp['crm'][$key];
}
/**
 * get plugin name
 * */
function mwp_plugin_name(){
	return mwp_config_setup('plugin_name');
}
function mwp_public_partials(){
	return mwp_config_path('public_partials');
}
function mwp_public_partials_url(){
	return mwp_config_path('public_url_partials');
}
/**
 * get plugin version
 * */
function mwp_plugin_version(){
	return mwp_config_setup('plugin_version');
}
/**
 * get wordpress localize domain
 * */
function mwp_localize_domain(){
	return mwp_config_setup('localize_domain');
}
/**
 * get admin menu position
 * the main menu
 * */
function mwp_menu_position(){
	return mwp_config_setup('menu_position');
}
/**
 * get the plugin dir path
 * */
function mwp_plugin_dir_path(){
	return mwp_config_path('plugin_dir_path');
}
function mwp_public_url(){
	return mwp_config_path('plugin_url_path');
}
function mwp_admin_url_path(){
	return mwp_config_path('admin_url_path');
}
/**
 * get the admin dir partials
 * */
function mwp_admin_dir_partials(){
	return mwp_config_path('admin_dir_partials');
}
/**
 * get the admin url
 * */
function mwp_admin_url(){
	return mwp_config_setup('admin_url');
}
/**
 * get crm property default status
 * */
function mwp_property_default_status($status = ''){
	if( trim($status) != '' ){
		return $status;
	}
	return mwp_config_crm('property_status');
}
/**
 * get crm property default title
 * */
function mwp_property_default_title($title = ''){
	if( trim($title) != '' ){
		return $title;
	}
	return mwp_config_crm('property_title');
}
function mwp_asset_url(){
	return mwp_config_path('asset_url');
}
function mwp_current_machine(){
	global $mwp;
	$current_name = apply_filters('mwp_google_map_key', gethostname());
	if( isset($mwp[$current_name]) ){
		return $mwp[$current_name];
	}
	return false;
}
function mwp_google_map_api(){
	$map = Mwp_API_Google_Model::get_instance()->md_google_map_api_key();
	if( $map ){
		return $map;
	}
	return false;
}
function mwp_mls_config(){
	global $mwp;
	return $mwp['mls'];
}
function mwp_config_walkscore(){
	global $mwp;
	return $mwp['walkscore']['api'];
}
function mwp_config_homejunction(){
	global $mwp;
	return $mwp['homejunction'];
}
function mwp_config_homejunction_endpoint(){
	global $mwp;
	return $mwp['homejunction']['api_endpoint'];
}
/**
 * dump
 * */
function mwp_dump($array, $exit = false){
	echo '<pre>';
		print_r($array);
	echo '</pre>';
	if( $exit ){
		exit();
	}
}
