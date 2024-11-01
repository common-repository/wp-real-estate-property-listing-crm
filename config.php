<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function mwp_folder_name(){
	$plugin_foldername = explode('/',plugin_basename( __FILE__ ));
	return $plugin_foldername[0];
}
$mwp = array();
/**
 * config setup
 * */
$mwp['setup'] = array(
	'plugin_version' => '4.3.35',
	'plugin_name' => 'masterdigm',
	'plugin_page' => 'http://www.realestatewpplugin.com/',
	'localize_domain' => 'masterdigm',
	'menu_position' => '66',
	'admin_url' =>	'admin.php?page=',
	'uri_query' => 'mwppage',
	'mail' => get_option('admin_email')
);
/**
 * config path
 * */
$mwp['plugin_path'] = array(
	'admin_dir' => plugin_dir_path( __FILE__ ) .  'admin/',
	'admin_dir_partials' => plugin_dir_path( __FILE__ ) .  'admin/partials/',
	'admin_url_path' => plugin_dir_url( __FILE__ ) .  'admin/',
	'plugin_dir_path' => plugin_dir_path( __FILE__ ),
	'plugin_url_path' => plugin_dir_url( __FILE__ ) . 'public/',
	'public_partials' => plugin_dir_path( __FILE__ ) .  'public/partials/',
	'public_url_partials' => plugin_dir_url( __FILE__ ) .  'public/partials/',
	'theme_view' => get_stylesheet_directory(),
	'plugin_folder_name' => mwp_folder_name(),
	'asset_dir' => plugin_dir_path( __FILE__ ) .  'assets/',
	'asset_url' => WP_PLUGIN_URL .'/'. mwp_folder_name() . '/assets/',
);
/**
* Masterdigm CRM API
**/
$mwp['crm'] = array(
	'api_endpoint' => 'http://masterdigm.com/api2/',
	'api_version' => 'v2',
	'prefix' => 'crm'
);
$mwp['mls'] = array(
	'api_endpoint' => 'http://www.masterdigmserver1.com/api/',
	'api_version' => 'v2',
	'prefix' => 'mls'
);
$mwp['homejunction'] = array(
	'api_endpoint' => 'http://api2.masterdigm.net/hji',
	'api_version' => '',
	'list_type' => 'residential',
	'prefix' => 'hji'
);
$mwp['flexmls'] = array(
	'prefix' => 'flexmls'
);
$mwp['jsplugin-library-script'] = array(
	'bootstrapjs' => array(
		'name' => 'Bootstrap JS',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'plugin/bootstrap/js/bootstrap.min.js',
		'version' => $mwp['setup']['plugin_version'],
		'deps' => array(),
		'in_footer' => true,
	)
);
$mwp['mwp-jsplugin-library-script'] = array(
	'masonry-imagesloaded' => array(
		'name' => 'Masonry Images Loaded',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'js/imagesloaded.pkgd.js',
		'version' => null,
		'deps' => array(),
		'in_footer' => true,
	),
	'masonry-min' => array(
		'name' => 'Masonry Min',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'js/masonry.pkgd.min.js',
		'version' => null,
		'deps' => array(),
		'in_footer' => true,
	),
	'lazyload' => array(
		'name' => 'Lazy Load',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'js/jquery.lazyload.min.js',
		'version' => array(),
		'deps' => null,
		'in_footer' => true,
	),
	'galleria' => array(
		'name' => 'Galerria',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'plugin/galleria/galleria-1.4.2.min.js',
		'version' => $mwp['setup']['plugin_version'],
		'deps' => array(),
		'in_footer' => true,
	),
	'jquery.magnific-popup.min' => array(
		'name' => 'Maginific Popup',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'js/jquery.magnific-popup.min.js',
		'version' => $mwp['setup']['plugin_version'],
		'deps' => array(),
		'in_footer' => true,
	),
	'emailto' => array(
		'name' => 'Email To',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'js/emailto.js',
		'version' => $mwp['setup']['plugin_version'],
		'deps' => array(),
		'in_footer' => true,
	),
	'mwp-infinite-scroll' => array(
		'name' => 'MWP Infinite Scroll',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'js/infinite-scroll.js',
		'version' => $mwp['setup']['plugin_version'],
		'deps' => array(),
		'in_footer' => false,
	)
);
$mwp['jsplugin-library-css'] = array(
	'bootstrapcss' => array(
		'name' => 'MWP - Bootstrap CSS',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'plugin/bootstrap/css/mwp-bootstrap.css',
		'deps' => array(),
		'version' => $mwp['setup']['plugin_version'],
		'in_footer' => 'all',
	),
);
$mwp['mwp-jsplugin-library-css'] = array(
	'magnificpopupcss' => array(
		'name' => 'Magnific Popup CSS',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'css/magnific-popup.css',
		'deps' => array(),
		'version' => $mwp['setup']['plugin_version'],
		'in_footer' => 'all',
	),
	'jqueryui-css' => array(
		'name' => 'JQueryUI Theme Smooth',
		'src' => $mwp['plugin_path']['plugin_url_path'] . 'css/jquery-ui.css',
		'version' => $mwp['setup']['plugin_version'],
		'deps' => array(),
		'in_footer' => 'all',
	)
);
$mwp['localize'] = '';
$mwp['search_settings_general'] = array(
	'search_title' => 'Find your home',
	'show_forsale_button' => 'y',
	'show_forrent_button' => 'y',
	'show_foreclosure_button' => 'y',
	'show_privatesales_button' => 'y',
	'show_tolet_button' => 'y',
	'property_status' => 'active',
	'search_property_url' => 'search-properties',
);
$mwp['settings_popup'] = array(
	'show_popup' => '1',
	'close_popup' => '0',
	'show_popup_after_certain_clicks' => '3',
);
$mwp['search_settings_price'] = array(
	'ten' => array(
		'start' => 10000,
		'end' => 90000,
		'step' => 10000,
	),
	'hundred' => array(
		'start' => 100000,
		'end' => 900000,
		'step' => 25000,
	),
	'million' => array(
		'start' => 1000000,
		'end' => 9000000,
		'step' => 250000,
	),
);
$mwp['template'] = array(
	'property_title' => 'tagline',
	'show_bed' => 'y',
	'show_bath' => 'y',
	'show_garage' => 'y',
	'color' => '#01b7e8',
	'template_layout' => 'default',
	'template_list' => 'mwp-property-list-v2.php',
	'loop_template_list' => 'mwp-loop-property-list-v2.php',
	'template_property_details' => 'mwp-property-details.php',
	'template_property_details' => 'mwp-property-details.php',
	'template_search_form' => 'mwp-search-form.php',
	'template_search_result' => 'mwp-search-result.php',
	'dir' => 'template',
	'grid_col_md' => '3',
	'mwp_search_result_grid_col_md' => '3',
	'mwp_list_active_label' => '#060',
	'mwp_list_main_background' => '#ffffff',
	'mwp_list_secondary_background' => '#01b7e8',
	'mwp_list_font_color' => '#ffffff',
	'mwp_list_hover_font_color' => '#20578b',
	'mwp_list_main_content_font_color' => '#000000',
	'mwp_list_main_content_second_font_color' => '#000000',
	'mwp_list_main_content_heading_color' => '#000000',
	'mwp_list_border_color' => '#dddddd',
	'mwp_details_tab_active_background' => '#ffffff',
	'mwp_details_tab_active_fontcolor' => '#555555',
	'mwp_details_tab_inactive_background' => '#eeeeee',
	'mwp_details_tab_inactive_fontcolor' => '#337ab7',
	'mwp_details_main_page_background' => '#ffffff',
	'mwp_details_main_background' => '#0d3965',
	'mwp_details_main_font_color' => '#000000',
	'mwp_details_secondary_background' => '#eeeeee',
	'mwp_details_secondary_font_color' => '#000000',
	'mwp_details_content_main_fontcolor' => '#428bca',
	'mwp_details_content_main_heading_fontcolor' => '#000000',
	'mwp_details_content_secondary_fontcolor' => '#000000',
	'mwp_details_content_border_color' => '#ffffff',
	'mwp_search_main_page_background' => '#ffffff',
	'mwp_button_main_background' => '#428bca',
	'mwp_button_font_color' => '#ffffff',
	'mwp_button_secondary_background' => '#999999',
	'mwp_button_secondary_fontcolor' => '#000000',
	'mwp_button_border_color' => '#999999',
	'mwp_header_main_background_color' => '#0d3965',
	'mwp_header_secondary_background_color' => '#eeeeee',
	'mwp_header_primary_font_color' => '#ffffff',
	'mwp_header_secondary_font_color' => '#000000',
	'mwp_header_heading_color' => '#000000',
	'mwp_header_border_color' => '#ffffff',
	'mwp_details_tab_hover_font_color' => '#ffffff',
	'mwp_details_tab_hover_background' => '#ffffff',
	'raw_search_form' => '/searchform/mwp-search-form-v1.php',
	'bookaviewing_label' => __('Book a viewing', $mwp['setup']['localize_domain']),
	'bookaviewing_align' => 'text-center',
	'mwp_header' => '1',
	'mwp_footer' => '1'
);
$mwp['pagination'] = array(
	'limit' => 10,
);
$mwp['property_details'] = array(
	'url' => 'property',
);
$mwp['search_result'] = array(
	'url' => 'search-properties',
);
$mwp['property_label'] = array(
	'property-details' 				=> __('Property Details', $mwp['setup']['localize_domain']),
	'map-and-directions' 			=> __('Map and Directions', $mwp['setup']['localize_domain']),
	'school-and-information' 		=> __('School and Information', $mwp['setup']['localize_domain']),
	'walk-score' 					=> __('Walk Score', $mwp['setup']['localize_domain']),
	'single-photos' 				=> __('Photos', $mwp['setup']['localize_domain']),
	'video' 						=> __('Video', $mwp['setup']['localize_domain']),
	'school' 						=> __('School', $mwp['setup']['localize_domain']),
	'price' 						=> __('Price', $mwp['setup']['localize_domain']),
	'baths' 						=> __('Baths', $mwp['setup']['localize_domain']),
	'beds' 							=> __('Beds', $mwp['setup']['localize_domain']),
	'year-built' 					=> __('Year Built', $mwp['setup']['localize_domain']),
	'mls' 							=> 'MLS# ',
	'garage'						=> __('Garage', $mwp['setup']['localize_domain']),
	'next'							=> __('Next', $mwp['setup']['localize_domain']),
	'prev'							=> __('Previous', $mwp['setup']['localize_domain']),
	'property-code'					=> __('Property Code', $mwp['setup']['localize_domain']),
	'price'							=> __('Price', $mwp['setup']['localize_domain']),
	'min-price'						=> __('Min Price', $mwp['setup']['localize_domain']),
	'max-price'						=> __('Max Price', $mwp['setup']['localize_domain']),
	'search-title'					=> __('Find your Home', $mwp['setup']['localize_domain']),
	'search-form-property-type'		=> __('Type', $mwp['setup']['localize_domain']),
	'search-form-bedroom'			=> __('Any Bed', $mwp['setup']['localize_domain']),
	'search-form-bath'				=> __('Any Bath', $mwp['setup']['localize_domain']),
	'search-form-input-location'	=> __('Enter Location here', $mwp['setup']['localize_domain']),
	'search-form-input-keyword'		=> __('Type any Keyword here', $mwp['setup']['localize_domain']),
	'search-form-input-search-v2'	=> __('Search', $mwp['setup']['localize_domain']),
	'search-form-input-more-search-v2'	=> __('More Search Options', $mwp['setup']['localize_domain']),
	'search-form-input-min-floor-area'	=> __('Min Floor Area', $mwp['setup']['localize_domain']),
	'search-form-input-min-lot-area'	=> __('Min Lot Area', $mwp['setup']['localize_domain']),
	'search-forsale' => __('For Sale / Rent', $mwp['setup']['localize_domain']),
	'lot-area-size'	=> __('Lot Area', $mwp['setup']['localize_domain']),
	'floor-area-size'	=> __('Floor Area', $mwp['setup']['localize_domain']),
	'real-estate-agent'	=> __('Real Estate Agent', $mwp['setup']['localize_domain']),
	'button-favorite'	=> __('Favorite', $mwp['setup']['localize_domain']),
	'button-xout'	=> __('X-Out', $mwp['setup']['localize_domain']),
	'button-printpdf'	=> __('Print PDF', $mwp['setup']['localize_domain']),
	'button-share'	=> __('Share', $mwp['setup']['localize_domain']),
	'popup-title'	=> __('No Account Yet? Sign Up Now!', $mwp['setup']['localize_domain']),
	'popup-login'	=> __('Login', $mwp['setup']['localize_domain']),
	'popup-register'	=> __('Register', $mwp['setup']['localize_domain']),
	'list-just-listed'	=> __('Just Listed', $mwp['setup']['localize_domain']),
	'status'	=> __('Status', $mwp['setup']['localize_domain']),
	'list_photos'	=> __('Photos', $mwp['setup']['localize_domain']),
	'transaction-type-forsale'	=> __('For Sale', $mwp['setup']['localize_domain']),
	'transaction-type-forrent'	=> __('For Rent', $mwp['setup']['localize_domain']),
	'transaction-type-foreclosure'	=> __('Foreclosure', $mwp['setup']['localize_domain']),
	'transaction-type-privatesales'	=> __('Private Sales', $mwp['setup']['localize_domain']),
	'transaction-type-tolet'	=> __('To Let', $mwp['setup']['localize_domain'])
);
$mwp['allan-System-Product-Name'] = array(
	'google-map-api' => 'AIzaSyBy6vTWwrkvvUBVaIYfXtOIQ4LjEg2HDPA',
);
$mwp['host.wdjindustries.com'] = array(
	'google-map-api' => 'AIzaSyCqvs6Lpa_5hy92rItrr_772ZmURJRoP9M',
);
$mwp['walkscore'] = array(
	'api' => '20237ca07492bb7c6a97bdc2677a1540'
);
$mwp['api_feed'] = array(
	'crm',
	'mls',
	'flexmls',
	'hji'
);
