<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function mwp_default_template(){
	global $mwp;
	return $mwp['template']['template_layout'];
}
function mwp_default_template_dir(){
	global $mwp;
	$template = $mwp['template'];
	return mwp_public_partials() . $template['dir'] . '/' . $template['template_layout'];
}
function mwp_default_template_url(){
	global $mwp;
	$template = $mwp['template'];
	return mwp_public_partials_url() . $template['dir'] . '/' . $template['template_layout'];
}
function mwp_default_template_list_file(){
	global $mwp;
	$template = $mwp['template'];
	return $template['template_list'];
}
function mwp_default_template_loop_list_file(){
	global $mwp;
	$template = $mwp['template'];
	return $template['loop_template_list'];
}
function mwp_property_details_template(){
	global $mwp;
	$template = $mwp['template']['template_property_details'];
	$template = apply_filters('mwp_hook_current_template_property_details', $template);
	return $template;
}
function mwp_bootstrap_grid_col_md($col = null, $divide = true){
	global $mwp;
	if( is_null($col) ){
		return $mwp['template']['grid_col_md'];
	}
	if( $divide ){
		$col = floor(12 / $col);
	}

	return $col;
}
function mwp_get_theme_style(){
	return Mwp_Theme_Style_DBEntity::get_instance()->get_wp_style();
}
function mwp_user_dropdown(){
	if( is_user_logged_in() ){
		$current_user = mwp_wp_get_current_user();
		$data = array();
		$data['wp_get_current_user'] = $current_user;
		$data['user_login'] = $current_user->user_login;
		$data['my_account_url'] = Mwp_MyAccount_Profile::get_instance()->url();
		$data['favorite_url'] = Mwp_MyAccount_Favorite::get_instance()->url();
		$data['xout_url'] = Mwp_MyAccount_Xout::get_instance()->url();
		$data['save_search_url'] = Mwp_MyAccount_SaveSearch::get_instance()->url();
		$template = Mwp_Theme_Locator::get_instance()->locate_template('mwp-user-dropdown.php');
		Mwp_View::get_instance()->display($template, $data);
	}else{
		$data = array();
		$template = Mwp_Theme_Locator::get_instance()->locate_template('mwp-user-signup-register.php');
		Mwp_View::get_instance()->display($template, $data);
	}
}
function mwp_header(){
	global $mwp;
	return $mwp['template']['mwp_header'];
}
function mwp_get_headers(){
	return Mwp_Admin_Theme_Layout_DBEntity::get_instance()->get_wp_header();
}
function mwp_get_headers_name(){
	return Mwp_Theme_Layout_Model::get_instance()->mwp_get_headers_name();
}
function mwp_footer(){
	global $mwp;
	return $mwp['template']['mwp_footer'];
}
function mwp_get_footers(){
	return Mwp_Admin_Theme_Layout_DBEntity::get_instance()->get_wp_footer();
}
function mwp_get_footers_name(){
	return Mwp_Theme_Layout_Model::get_instance()->mwp_get_footers_name();
}
function mwp_angularjs_ng(){
	if( mwp_get_headers() == 0 && mwp_search_result_current_view() == 'map' ){
		return (Mwp_View::get_instance()->current_view_type == 'map') ? 'searchResultApp':'';
	}
}
function mwp_show_bed(){
	$show_bed = Mwp_Settings_Property_DBEntity::get_instance()->get_show_bed();
	if( $show_bed == 'y' ){
		return true;
	}
	return false;
}
function mwp_show_bath(){
	$show_bath = Mwp_Settings_Property_DBEntity::get_instance()->get_show_bath();
	if( $show_bath == 'y' ){
		return true;
	}
	return false;
}
function mwp_show_garage(){
	$show_garage = Mwp_Settings_Property_DBEntity::get_instance()->get_show_garage();
	if( $show_garage == 'y' ){
		return true;
	}
	return false;
}
function mwp_get_search_result_col($col = null){
	global $mwp;
	if( !is_null($col) ){
		return $col;
	}
	return $mwp['template']['mwp_search_result_grid_col_md'];
}
