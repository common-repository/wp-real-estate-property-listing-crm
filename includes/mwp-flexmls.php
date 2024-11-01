<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function mwp_flexmls_key(){
	return Mwp_API_Flexmls_Model::get_instance()->md_flexmls_api_key('r');
}
function mwp_flexmls_secret(){
	return Mwp_API_Flexmls_Model::get_instance()->md_flexmls_api_secret('r');
}
function mwp_has_flexmls(){
	if( mwp_flexmls_key() && mwp_flexmls_secret() ){
		return true;
	}
	return false;
}
