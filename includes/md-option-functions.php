<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
//THIS is for reference only for the old
/**
 * Functions for table options
 *
 * options name for globally use
 * */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function cleanup_options(){
	md_api_key('d');
	md_api_token('d');
	md_options_plugin_settings('d');
	md_options_finish_install('d');
	//create function to query _options, *masterdigm_* | *md_* and delete them
	md_cleanup_db('masterdigm_');
	md_cleanup_db('md_');
	md_cleanup_db('save-search');
	md_cleanup_db('log_crm');
	md_cleanup_db('create_page_by');
	md_cleanup_db('property_data_feed');
	md_cleanup_db('user_id');
	md_cleanup_db('broker_id');
	md_cleanup_db('mls_');
	md_cleanup_db('social-api');
	md_cleanup_db('success-unsubscribe');
	md_cleanup_db('fail-unsubscribe');
}
function md_get_options_db($option_name){
	global $wpdb;
	$sql = "SELECT * FROM $wpdb->options WHERE option_name like '%".$option_name."%'";
	return $wpdb->get_results($sql);
}
function md_cleanup_db($option_name){
	$get = md_get_options_db($option_name);
	if( count($get) > 0 ){
		foreach($get as $key => $val){
			delete_option($val->option_name);
		}
	}
}
/**
 * get options
 *
 * get the options save
 *
 * @var $key	mix		name of the option
 * @var	$edfault	mixed | optional The default value to return if no value is returned (ie. the option is not in the database).
 * @see https://codex.wordpress.org/Function_Reference/get_option
 * @return get_option function
 * */
function md_get_options($key, $default = ''){
	return get_option($key, $default);
}
/**
 * update options
 *
 * @var $key	(string) (required) Name of the option to update. Must not exceed 64 characters. A list of valid default options to update can be
 * @var $value	(mixed) (required) The NEW value for this option name. This value can be an integer, string, array, or object.
 * */
function md_update_options($key, $value){
	update_option($key, $value);
}
/**
 * masterdigm api key
 *
 * read, update api key
 *
 * @var $action	string	allowed action are:
 * 						r = read, get
 * 						u = update
 * 						d = delete
 *	@var $u_value	mix		put value if the action is U / update
 * */
function md_api_key($action = 'r', $u_value = null){
	$option_name = 'api_key';
	switch($action){
		case 'u':
			if( !is_null($u_value) ){
				md_update_options($option_name, $u_value);
			}
		break;
		case 'd':
			delete_option($option_name);
		break;
		case 'r':
		default:
			return md_get_options($option_name);
		break;
	}
}
/**
 * masterdigm api token
 *
 * read, update api token
 *
 * @var $action	string	allowed action are:
 * 						r = read, get
 * 						u = update
 * 						d = delete
 *	@var $u_value	mix		put value if the action is U / update
 * */
function md_api_token($action = 'r', $u_value = null){
	$option_name = 'api_token';
	switch($action){
		case 'u':
			if( !is_null($u_value) ){
				md_update_options($option_name, $u_value);
			}
		break;
		case 'd':
			delete_option($option_name);
		break;
		case 'r':
		default:
			return md_get_options($option_name);
		break;
	}
}
function md_options_search_criteria(){
	return md_get_options('search_criteria', 'status');
}
/**
 * masterdigm plugin settings / plugin-settings option name
 *
 * read, update plugin settings
 *
 * @var $action	string	allowed action are:
 * 						r = read, get
 * 						u = update
 * 						d = delete
 *	@var $u_value	mix		put value if the action is U / update_option
 * */
function md_options_plugin_settings($action = 'r', $u_value = null){
	global $md_settings;
	$option_name = 'plugin-settings';
	switch($action){
		case 'u':
			if( !is_null($u_value) ){
				md_update_options($option_name, $u_value);
			}
		break;
		case 'd':
			delete_option($option_name);
		break;
		case 'r':
		default:
			return md_get_options($option_name);
		break;
	}
}
/**
 * masterdigm finish install
 *
 * read, update finish install
 *
 * @var $action	string	allowed action are:
 * 						r = read, get
 * 						u = update
 * 						d = delete
 *	@var $u_value	mix		put value if the action is U / update_option
 * */
function md_options_finish_install($action = 'r', $u_value = null){
	global $md_settings;
	$option_name = 'md_finish_install';
	switch($action){
		case 'u':
			if( !is_null($u_value) ){
				md_update_options($option_name, $u_value);
			}
		break;
		case 'd':
			delete_option($option_name);
		break;
		case 'r':
		default:
			return md_get_options($option_name);
		break;
	}
}
/**
 * masterdigm broker_id
 *
 * read, update broker id
 *
 * @var $action	string	allowed action are:
 * 						r = read, get
 * 						u = update
 * 						d = delete
 *	@var $u_value	mix		put value if the action is U / update_option
 * */
function md_options_broker_id($action = 'r', $u_value = null){
	global $md_settings;
	$option_name = 'broker_id';
	switch($action){
		case 'u':
			if( !is_null($u_value) ){
				md_update_options($option_name, $u_value);
			}
		break;
		case 'd':
			delete_option($option_name);
		break;
		case 'r':
		default:
			return md_get_options($option_name);
		break;
	}
}
function mwp_del_page(){
	$inc_page = array(
		'Property',
		'Search Properties',
	);
	foreach($inc_page as $key => $val){
		$page = get_page_by_title($val);
		if( $page ){
			wp_delete_post($page->ID, true);
		}
	}
}
function md_clean_up_page(){
	$inc_page = array(
		'State',
		'County',
		'City',
		'Community',
		'Un Subscribe',
		'My Account',
	);
	foreach($inc_page as $key => $val){
		$page = get_page_by_title($val);
		if( $page ){
			wp_delete_post($page->ID, true);
		}
	}
}
