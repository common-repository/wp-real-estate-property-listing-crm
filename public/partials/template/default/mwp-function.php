<?php
function css_form($css_class_array = array()){
	if( get_query_var('mwppage') ){
		$css_class_array = array('navbar-form');
	}
	return $css_class_array;
}
add_filter('md_hook_css_class_form_start', 'css_form', 10, 1);
if( Mwp_Settings_Popup_DBEntity::get_instance()->get_popup_show() == 1 ){
	function clear_cookie() {
		Mwp_Actions_ShowPopup::get_instance()->deleteShowPopup();
		session_destroy();
	}
	add_action('wp_logout', 'clear_cookie');
	function show_popup() {
		$popup_show = Mwp_Settings_Popup_DBEntity::get_instance()->get_popup_clicks();
		$cookie_name = 'guest_page_view';
		$cookie = new Mwp_Helpers_Cookie;
		if(
			!is_user_logged_in() &&
			mwp_manual_is_property_details_page()
		){
			$get_cookie = $cookie->get($cookie_name);
			if( $get_cookie ){
				if( $get_cookie != $popup_show ){
					$cookie->set($cookie_name,($get_cookie + 1));
				}
			}else{
				$cookie->set($cookie_name,1);
			}
		}
	}
	add_action( 'wp', 'show_popup');
}
