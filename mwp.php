<?php
/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * Dashboard. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 *
 * @link              http://masterdigm.com
 * @since             1.0.0
 * @package           Masterdigm_Api
 *
 * @wordpress-plugin
 * Plugin Name:       Masterdigm Real Estate
 * Plugin URI:        http://www.masterdigm.com/realestatewordpressplugin
 * Description:		  Used by Professional Real Estate companies around the world! A true all-in-one WP real estate solution Visit plugin page : <a href="http://www.masterdigm.com/masterdigm-plugin-documentation" target="_blank">http://www.masterdigm.com/masterdigm-plugin-documentation</a>
 * Version:           4.3.35
 * Author:            Masterdigm
 * Author URI:        http://masterdigm.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       masterdigm-api
 * Domain Path:       /languages
 * Bitbucket Plugin URI: https://bitbucket.org/allan_paul_casilum/masterdigm
 * Bitbucket Branch:     master
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
ini_set("memory_limit","640M");
add_action('plugins_loaded', 'mwp_wp_init');
spl_autoload_register('mwp_autoload_class');
function mwp_autoload_class($class_name){
    if ( false !== strpos( $class_name, 'Mwp' ) ) {
		$include_classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR;
		$admin_classes_dir = realpath( plugin_dir_path( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR;
		$class_file = str_replace( '_', DIRECTORY_SEPARATOR, $class_name ) . '.php';
		if( file_exists($include_classes_dir . $class_file) ){
			require_once $include_classes_dir . $class_file;
		}
		//echo $admin_classes_dir . $class_file.'<br>';
		if( file_exists($admin_classes_dir . $class_file) ){
			require_once $admin_classes_dir . $class_file;
		}
	}
}
//include libraries
require_once plugin_dir_path( __FILE__ ) . 'includes/lib/phpfastcache/phpfastcache.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/lib/flexmls/Core.php';
//pdf lib
require_once(plugin_dir_path( __FILE__ ) . 'includes/lib/tcpdf/config/tcpdf_config.php');
// Include the main TCPDF library (search the library on the following directories).
$tcpdf_include_dirs = array(
	realpath('../tcpdf.php'),
	plugin_dir_path( __FILE__ ) . 'includes/lib/tcpdf/tcpdf.php',
	'/usr/share/php/tcpdf/tcpdf.php',
	'/usr/share/tcpdf/tcpdf.php',
	'/usr/share/php-tcpdf/tcpdf.php',
	'/var/www/tcpdf/tcpdf.php',
	'/var/www/html/tcpdf/tcpdf.php',
	'/usr/local/apache2/htdocs/tcpdf/tcpdf.php'
);
foreach ($tcpdf_include_dirs as $tcpdf_include_path) {
	if (@file_exists($tcpdf_include_path)) {
		require_once($tcpdf_include_path);
		break;
	}
}
//include functions
require_once plugin_dir_path( __FILE__ ) . 'config.php';
require_once plugin_dir_path( __FILE__ ) . 'inc_functions.php';

register_activation_hook( __FILE__, 'activate_mwp' );
register_deactivation_hook( __FILE__, 'deactivate_mwp' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mwp-activator.php
 */
function activate_mwp() {
	update_option('api_keys_changed', true);
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwp-activator.php';
	Mwp_Activator::activate();
	update_option('api_keys_changed', true);
	update_option('MWP_ACTIVATE', 1);
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mwp-deactivator.php
 */
function deactivate_mwp() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mwp-deactivator.php';
	Mwp_Deactivator::deactivate();
	delete_option('MWP_ACTIVATE', 1);
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mwp.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mwp() {
	$plugin = new Mwp();
	$GLOBALS['plugin'] = $plugin;
	$mwp_crm = new Mwp_CRM_Model;
	//get default source
	$source = mwp_get_current_api_source();

	if( mwp_has_crm_credentials() && is_admin() ){
		//load admin dependencies
		require plugin_dir_path( __FILE__ ) . 'admin/admin.php';
		Mwp_ImportOld::get_instance()->run();

	}
	if( mwp_has_crm_credentials() ){
		//populate default settings
		Mwp_Admin_Settings_Jspluginlib_Entity::get_instance()->default_jsplugin_lib();
		//populate mail settings
		Mwp_Admin_Settings_Mail_DBEntity::get_instance()->default_mail_settings_data();
		//add style js
		$plugin->get_loader()->add_action('admin_enqueue_scripts', Mwp_Admin_Theme_Style_WPEntity::get_instance(), 'enqueue_scripts');
		//hook
		$plugin->get_loader()->add_filter('mwp_hook_search_result_template_map', Mwp_Theme_MapView::get_instance(), 'init', 10, 1);
		$plugin->get_loader()->add_filter('mwp_hook_search_result_template_list', Mwp_Theme_List::get_instance(), 'init', 10, 1);
		//crm
		$plugin->get_loader()->add_filter('mwp_hook_property_data_search_result_crm', Mwp_CRM_Hook::get_instance(), 'property_data', 10, 1);
		$plugin->get_loader()->add_filter('location_lookup_crm', Mwp_CRM_HookLocation::get_instance(), 'location_autocomplete', 10, 2);
		$plugin->get_loader()->add_filter('location_lookup_build_crm', Mwp_CRM_HookLocation::get_instance(), 'location_build_up', 10, 1);

		$plugin->get_loader()->add_action('fields_type_crm', Mwp_CRM_Hook::get_instance(), 'fields_type_crm', 10, 1);
		$plugin->get_loader()->add_filter('md_single_property_crm', Mwp_CRM_Hook::get_instance(),'md_single_property_crm',10, 1);
		$plugin->get_loader()->add_filter('md_single_property_pdf_crm', Mwp_CRM_Hook::get_instance(),'md_single_property_pdf_crm',10, 1);
		$plugin->get_loader()->add_filter('property_nearby_property_crm', Mwp_CRM_Hook::get_instance(), 'property_nearby_property_crm', 10, 1);
		$plugin->get_loader()->add_filter('hook_favorites_property_crm', Mwp_CRM_Hook::get_instance(), 'favorites_property_crm', 10, 1);
		$plugin->get_loader()->add_filter('hook_xout_property_crm', Mwp_CRM_Hook::get_instance(), 'xout_property_crm', 10, 1);
		$plugin->get_loader()->add_filter('mwp_breadcrumb_crm', Mwp_CRM_Hook::get_instance(), 'breadcrumb', 10, 2);
		$plugin->get_loader()->add_filter('get_property_by_crm', Mwp_CRM_Hook::get_instance(), 'get_property_by', 10, 2);

		$plugin->get_loader()->add_filter('mwp_hook_primary_img_crm', Mwp_CRM_Hook::get_instance(), 'mwp_hook_featured_img', 10, 2);
		//mls
		$plugin->get_loader()->add_filter('md_single_property_pdf_mls', Mwp_MLS_Hook::get_instance(),'md_single_property_pdf',10, 1);
		$plugin->get_loader()->add_filter('location_lookup_mls', Mwp_MLS_HookLocation::get_instance(), 'location_autocomplete', 10, 2);
		$plugin->get_loader()->add_filter('location_lookup_build_mls', Mwp_MLS_HookLocation::get_instance(), 'location_build_up', 10, 1);
		$plugin->get_loader()->add_filter('mwp_hook_property_data_search_result_mls', Mwp_MLS_Hook::get_instance(), 'property_data', 10, 1);

		$plugin->get_loader()->add_filter('md_single_property_mls', Mwp_MLS_Hook::get_instance(),'md_single_property_mls',10, 1);
		$plugin->get_loader()->add_filter('property_nearby_property_mls', Mwp_MLS_Hook::get_instance(), 'property_nearby_property_mls', 10, 1);
		$plugin->get_loader()->add_filter('hook_favorites_property_mls', Mwp_MLS_Hook::get_instance(), 'favorites_property_mls', 10, 1);
		$plugin->get_loader()->add_filter('hook_xout_property_mls', Mwp_MLS_Hook::get_instance(), 'xout_property_mls', 10, 1);
		$plugin->get_loader()->add_filter('mwp_breadcrumb_mls', Mwp_MLS_Hook::get_instance(), 'breadcrumb', 10, 2);
		$plugin->get_loader()->add_filter('get_property_by_mls', Mwp_MLS_Hook::get_instance(), 'get_property_by', 10, 2);
		$plugin->get_loader()->add_filter('wp_ajax_create_location_page_action_mls', Mwp_MLS_Hook::get_instance(), 'create_location_page_action_mls_callback', 10, 1);
		$plugin->get_loader()->add_filter('wp_ajax_infinite_scroll_mls', Mwp_MLS_Hook::get_instance(), 'infinite_scroll', 10, 1);
		$plugin->get_loader()->add_filter('wp_ajax_nopriv_infinite_scroll_mls', Mwp_MLS_Hook::get_instance(), 'infinite_scroll', 10, 1);
		$plugin->get_loader()->add_filter('mwp_location_build_up_crm', Mwp_CRM_HookLocation::get_instance(), 'location_build_up', 10, 1);
		$plugin->get_loader()->add_filter('mwp_location_build_up_mls', Mwp_MLS_HookLocation::get_instance(), 'location_build_up', 10, 1);

		Mwp_Admin_ShortCode_Init::get_instance();
		Mwp_Admin_ShortCode_Subscriber::get_instance();
		Mwp_Admin_ShortCode_Crm_ListProperty::get_instance();
		Mwp_Admin_ShortCode_Crm_FeaturedProperty::get_instance();
		Mwp_Admin_ShortCode_SearchForm::get_instance();
		Mwp_Admin_ShortCode_UnSubscriber::get_instance();
		$plugin->get_loader()->add_action('wp_ajax_nopriv_get_location_crm', Mwp_CRM_HookLocation::get_instance(), 'get_location_crm');
		$plugin->get_loader()->add_action('wp_ajax_get_location_crm', Mwp_CRM_HookLocation::get_instance(), 'get_location_crm');
		$plugin->get_loader()->add_action('wp_ajax_get_property_data_crm', Mwp_CRM_Hook::get_instance(), 'get_property_data_crm');
		$plugin->get_loader()->add_action('wp_ajax_nopriv_get_property_data_crm', Mwp_CRM_Hook::get_instance(), 'get_property_data_crm');
		$plugin->get_loader()->add_filter('wp_ajax_create_location_page_action_crm', Mwp_CRM_Hook::get_instance(), 'create_location_page_action_crm_callback', 10, 1);
		$plugin->get_loader()->add_filter('wp_ajax_infinite_scroll_crm', Mwp_CRM_Hook::get_instance(), 'infinite_scroll', 10, 1);
		$plugin->get_loader()->add_filter('wp_ajax_nopriv_infinite_scroll_crm', Mwp_CRM_Hook::get_instance(), 'infinite_scroll', 10, 1);
		$plugin->get_loader()->add_action('wp_ajax_nopriv_get_location_mls', Mwp_MLS_HookLocation::get_instance(), 'get_location_mls');
		$plugin->get_loader()->add_action('wp_ajax_get_location_mls', Mwp_MLS_HookLocation::get_instance(), 'get_location_mls');
		$plugin->get_loader()->add_action('wp_ajax_get_property_data_mls', Mwp_MLS_Hook::get_instance(), 'get_property_data_mls');
		$plugin->get_loader()->add_action('wp_ajax_nopriv_get_property_data_mls', Mwp_MLS_Hook::get_instance(), 'get_property_data_mls');

		if( mwp_get_headers() == 0 ){
			add_action('wp_head', 'mwp_header_function', 9999);
			add_filter('pre_get_document_title', 'mwp_filter_title',9999, 1);
			add_filter('body_class', 'mwp_body_class', 10, 1);

		}
		add_action('wp_footer', 'mwp_footer_function', 100);
		Mwp_Actions_SignupForm::get_instance();
		Mwp_API_Facebook::get_instance();
		//run shortcode
		add_shortcode('crm_list_properties', array(Mwp_Admin_ShortCode_Crm_ListProperty::get_instance(),'init_shortcode'));
		add_shortcode('crm_featured_properties', array(Mwp_Admin_ShortCode_Crm_FeaturedProperty::get_instance(),'init_shortcode'));
		add_shortcode('md_account',array(Mwp_Admin_ShortCode_Subscriber::get_instance(),'init_shortcode'));
		add_shortcode('md_sc_search_property_form', array(Mwp_Admin_ShortCode_SearchForm::get_instance(),'init_shortcode'));
		add_shortcode('md_sc_unsubscribe_api',array(Mwp_Admin_ShortCode_UnSubscriber::get_instance(),'init_shortcode'));
		//route permalink
		Mwp_PropertyRoute::get(mwp_get_property_details_url(), array(Mwp_PropertyDetailsURL::get_instance(), 'route'));
		Mwp_PropertyRoute::get(mwp_get_search_url(), array(Mwp_SearchPropertyURL::get_instance(), 'route'));
		//inquire form
		Mwp_Theme_Inquire::get_instance()->init(mwp_plugin_name(), mwp_plugin_version());
		//Button Actions
		Mwp_Actions_Buttons::get_instance()->init();
		//My Account
		Mwp_MyAccount_Dashboard::get_instance();
		Mwp_MyAccount_Profile::get_instance();
		Mwp_MyAccount_SaveSearch::get_instance();
		Mwp_Actions_ShowPopup::get_instance();
		Mwp_SearchBy::get_instance();
		Mwp_Actions_EmailTo::get_instance();
		Mwp_Actions_SaveSearch::get_instance();
		Mwp_Propertyalert_Entity::get_instance();
		//load theme style
		$plugin->get_loader()->add_action('wp_head', Mwp_Theme_Style_Entity::get_instance(), 'mwp_wp_styling', 100);
		//load the template mwp-functions.php
		$templte_function = Mwp_Theme_Locator::get_instance()->locate_template('mwp-function.php');
		Mwp_View::get_instance()->display($templte_function);
		add_action('widgets_init', 'mwp_widgets_init' );
		//theme support
		Mwp_Theme_Support_Enfold::get_instance();
		/*$r = Mwp_CRM_PropertyFields::get_instance()->get_field_nonviewable_status();
		$t = Mwp_CRM_PropertyFields::get_instance()->get_field_status();
		mwp_dump($t);
		mwp_dump($r,1);*/
	}

	$plugin->run();
}

function mwp_body_class($classes){
	if( mwp_is_property_details_page() ) {
		return array_merge( $classes, array( 'mwp-property-details-page' ) );
	}
	if( mwp_is_search_result_page() ){
		return array_merge( $classes, array( 'mwp-search-result-page' ) );
	}
	return $classes;
}

function mwp_widgets_init(){
	$textdomain = mwp_localize_domain();
	register_sidebar( array(
        'name'          => __( 'MWP Property Details Right Above', $textdomain ),
        'id'            => 'mwp-property-details-right-above',
        'description'   => __( 'Widgets in this area will be shown right above.', $textdomain ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );
	register_sidebar( array(
        'name'          => __( 'MWP Property Details Below Photo Gallery', $textdomain ),
        'id'            => 'mwp-property-details-photo-gallery',
        'description'   => __( 'Widgets in this area will be shown below photo gallery.', $textdomain ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );
	register_sidebar( array(
        'name'          => __( 'MWP Property Details Below Header Title', $textdomain ),
        'id'            => 'mwp-property-details-below-header-title',
        'description'   => __( 'Widgets in this area will be shown below header title.', $textdomain ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );
	register_sidebar( array(
        'name'          => __( 'MWP Property Details Above Header Title', $textdomain ),
        'id'            => 'mwp-property-details-above-header-title',
        'description'   => __( 'Widgets in this area will be shown Above header title.', $textdomain ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );
	register_sidebar( array(
        'name'          => __( 'MWP Property Details Below Inquiry Forms', $textdomain ),
        'id'            => 'mwp-property-details-below-inquire-forms',
        'description'   => __( 'Widgets in this area will be shown below inquire forms.', $textdomain ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );
	register_sidebar( array(
        'name'          => __( 'MWP Property Details Above Map', $textdomain ),
        'id'            => 'mwp-property-details-above-map',
        'description'   => __( 'Widgets in this area will be shown above MAP in property details.', $textdomain ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );
	register_sidebar( array(
        'name'          => __( 'MWP Property Details Below Similar Homes', $textdomain ),
        'id'            => 'mpb-property-details-below-similar',
        'description'   => __( 'Widgets in this area will be shown below similar homes.', $textdomain ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => '',
    ) );
}
function mwp_header_function(){
	 if(mwp_is_search_view_list()){
		if( Mwp_View::get_instance()->data && Mwp_View::get_instance()->data['total_data'] > 0){
			$data = Mwp_View::get_instance()->data;
			if( isset($data['total_data']) &&
				$data['total_data'] > mwp_get_limit()
			){
				?>
					<script>
						var total_properties = <?php echo $data['total_data']; ?>;
						var search_uri_query = <?php echo json_encode(Mwp_View::get_instance()->search_uri_query); ?>;
						initPaginator();
					</script>
				<?php
			}
		}
	}
	if( mwp_is_property_details_page() ){
		add_filter('wpseo_opengraph_url', 'mwp_remove_meta_yoast', 10, 1);
		add_filter('wpseo_opengraph_type', 'mwp_remove_meta_yoast', 10, 1);
		add_filter('wpseo_opengraph_title', 'mwp_remove_meta_yoast', 10, 1);
		add_filter('wpseo_opengraph_site_name', 'mwp_remove_meta_yoast', 10, 1);
		?>
		<link rel="stylesheet" id="masterdigm-public" href="<?php echo mwp_default_template_url() . '/masterdigm-public.css';?>">
		<link rel="stylesheet" id="masterdigm-style" href="<?php echo mwp_default_template_url() . '/masterdigm-style.css';?>">
		<?php
		$templte_function = Mwp_Theme_Locator::get_instance()->locate_template('property-details/header.php');
		Mwp_View::get_instance()->display($templte_function);
		echo '<style type="text/css">';
		echo Mwp_Theme_Layout_Entity::get_instance()->get_custom_css();
		echo '</style>';
	}
}
function mwp_filter_title($title){
	if( Mwp_View::get_instance()->data
		&& isset(Mwp_View::get_instance()->data['property_data'])
		&& Mwp_View::get_instance()->data['property_data']->has_property()
		&& mwp_is_property_details_page()
	){
		if( mwp_get_current_api_source() == 'crm' ){
			if( mwp_is_display_tag_line() ){
				$title = Mwp_View::get_instance()->data['property_data']->property_data[0]->tag_line();
			}else{
				$title = Mwp_View::get_instance()->data['property_data']->property_data[0]->get_address();
			}
		}else{
			$title = Mwp_View::get_instance()->data['property_data']->property_data[0]->get_address();
		}
		//echo $title;exit();
	}
	if( mwp_is_search_result_page() ){
		if( isset($_GET['location']) && trim($_GET['location']) != '' ){
			$title = 'Search Result Properties for '.$_GET['location'];
		}else{
			$title = 'Search Result Properties';
		}
	}
	return $title;
}
function mwp_footer_function(){
	if( mwp_get_headers() == 0 ){
		if( mwp_google_map_api() ){
			?><script src="https://maps.googleapis.com/maps/api/js?key=<?php echo mwp_google_map_api();?>"></script><?php
		}else{
			?><script src="https://maps.googleapis.com/maps/api/js?v=3.23"></script><?php
		}
		if( mwp_is_property_details_page() ){
			$templte_function = Mwp_Theme_Locator::get_instance()->locate_template('property-details/footer.php');
			Mwp_View::get_instance()->display($templte_function);
		}
	}
	Mwp_Actions_EmailTo::get_instance()->display();
}
add_action( 'init', 'mwp_flush_rewrite_rules_maybe', 20 );
function mwp_flush_rewrite_rules_maybe(){
	if ( get_option('api_keys_changed') == true ) {
		flush_rewrite_rules();
		update_option('api_keys_changed', false);
	}
}
/** Yoast **/
add_action( 'wp', 'mwp_wp', 9999 );
function mwp_wp(){
	global $wpseo_og;
	if( mwp_is_property_details_page() ){
		//remove this if in property details page
		add_filter('wpseo_opengraph_url', '__return_false', 10, 1);
		add_filter('wpseo_opengraph_type', '__return_false', 10, 1);
		add_filter('wpseo_opengraph_title', '__return_false', 10, 1);
		add_filter('wpseo_opengraph_site_name', '__return_false', 10, 1);
		add_filter('wpseo_opengraph_locale', '__return_false', 10, 1);
		if ( isset( $wpseo_og ) ) {
			remove_action( 'wpseo_opengraph', [ $wpseo_og, 'locale' ], 1 );
    	}
	}
}
/** Yoast **/
function mwp_wp_init(){
	run_mwp();
}
