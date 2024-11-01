<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function mwp_get_property_details_url(){
	global $mwp;
	return $mwp['property_details']['url'];
}
