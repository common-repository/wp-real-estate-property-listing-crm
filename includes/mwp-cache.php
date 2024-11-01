<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function mwp_cache_set($name, $value, $time = 0){
	return Mwp_Cache::get_instance()->set($name, $value, $time);
}
function mwp_cache_get($name){
	return Mwp_Cache::get_instance()->get($name);
}
function mwp_cache_del($name){
	return Mwp_Cache::get_instance()->del($name);
}
function mwp_cache_clean(){
	return Mwp_Cache::get_instance()->clean();
}
function mwp_cache_stats(){
	return Mwp_Cache::get_instance()->stats();
}
