<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-config.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-cache.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-crm.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-flexmls.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-homejunction.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-template-layout.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-property-query.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-crm-account.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-user.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-helper-function.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-search-settings.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-page-url.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-pagination.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/mwp-template-details.php';
if( get_option('plugin-settings') ){
	require_once plugin_dir_path( __FILE__ ) . 'includes/md-option-functions.php';
}
