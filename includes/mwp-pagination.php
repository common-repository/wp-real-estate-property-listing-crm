<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function mwp_get_limit(){
	global $mwp;
	return $mwp['pagination']['limit'];
}
function mwp_pagination($pages, $range, $max_num_pages = null, $show_pagination = false){
	global $mwp_loop;
	if( $show_pagination || $mwp_loop->show_pagination() ){
		if( is_null($max_num_pages) ){
			$max_num_pages = $mwp_loop->property_data_total;
		}
		Mwp_Helpers_Pagination::get_instance()->md_pagination($pages, $range, $max_num_pages);
	}
}
function mwp_infinite_pagination($pages, $range, $max_num_pages = null, $show_pagination = false, $paged = null){
	global $mwp_loop;
	if( $show_pagination || $mwp_loop->show_pagination() ){
		if( is_null($max_num_pages) ){
			$max_num_pages = $mwp_loop->property_data_total;
		}
		Mwp_Helpers_Pagination::get_instance()->md_pagination($pages, $range, $max_num_pages, $paged);
	}
}
