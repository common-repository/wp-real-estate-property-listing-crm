<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.realestatewpplugin.com/
 * @since      1.0.0
 *
 * @package    Mwp
 * @subpackage Mwp/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwp
 * @subpackage Mwp/admin
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name . '-jquery-ui-theme', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mwp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Mwp_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Mwp_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'jquery-ui-accordion' );

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/mwp-admin.js',
			array( 'jquery' ),
			$this->version,
			false
		);
		wp_enqueue_script( 
			$this->plugin_name . '-createlocationpage', 
			plugin_dir_url( __FILE__ ) . 'js/createlocationpage.js', 
			array( 'jquery' ), 
			$this->version, 
			true 
		);
		if( mwp_get_current_api_source() == 'hji' ){
			wp_enqueue_script( 
				$this->plugin_name . '-hji-search-form', 
				mwp_public_url() . 'js/mwp-hji-search-form.js', 
				array( 'jquery' ), 
				$this->version, 
				true 
			);
		}
		wp_localize_script( $this->plugin_name,
			'MDAjax',
			array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'security' => wp_create_nonce( 'md-ajax-request' ),
				'ajax_indicator' => mwp_asset_url() . 'ajax-loader-big-circle.gif',
				'default_feed' => mwp_get_current_api_source(),
				'create_page_location_html_indicator' => __('Warning! Do not interrupt, Updating / Creating page by location now, please wait', mwp_localize_domain()),
				'hji_getpropertytypes' => mwp_hji_get_property_types()	
			)
		);
		wp_enqueue_media();
	}
	
	/**
	 * after plugin activate send notice to the user to setup CRM keys
	 * */
	public function mwp_admin_notice(){
		if( !mwp_has_crm_credentials() ){
			?>
				<div class="update-nag notice is-dismissible">
						<?php _e("Thank you for installing Masterdigm API, to use and obtain a KEY, please click right link\r", mwp_localize_domain()); ?>
						<a href="http://www.masterdigm.com/wordpress-plugin-sign/" target="_blank">Signup for CRM Credentials</a>
						<?php _e('. Check your Email for your CRM login', mwp_localize_domain()); ?>
						<?php _e('. After that you login to your CRM, and get your CRM API Credentials', mwp_localize_domain()); ?>
						<?php _e('. For questions and support EMAIL us at support@masterdigm.com', mwp_localize_domain()); ?>
				</div>
			<?php
		}
	}
	
	/**
	 * after plugin activate send notice to the user to setup CRM keys
	 * */
	public function _mwp_admin_notice(){
		if( !mwp_has_crm_credentials() ){
			?>
				<div class="update-nag notice is-dismissible">
					<h3>
						<?php _e('Thank you for installing Masterdigm API, to use and obtain a KEY, please click right link', mwp_localize_domain()); ?>
						<a href="<?php echo admin_url('admin.php?page='.mwp_localize_domain().'');?>">
							<?php echo _e('Plugin Dashboard page', mwp_localize_domain()); ?>
						</a>
					</h3>
				</div>
			<?php
		}
	}

	/**
	 * Create menu and submenu
	 * */
	public function admin_menu(){
		//main menu
		Mwp_Admin_MasterdigmEntity::get_instance()->admin_menu();
		//sub menu - subscribe
		Mwp_Admin_SubscribeCRMEntity::get_instance()->add_submenu_page();
		//sub menu - settings - crm
		Mwp_Admin_Settings_CRMkeyEntity::get_instance()->add_submenu_page();
		if( mwp_has_crm_credentials() ){
			//sub menu - settings
			Mwp_Admin_Settings_Entity::get_instance()->add_submenu_page();
			Mwp_Admin_Account_Settings::get_instance()->add_submenu_page();
			Mwp_Admin_Search_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_Search_Pricerange_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_Theme_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_Theme_Style_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_API_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_API_Flexmls_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_API_Greatschool_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_API_Google_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_Propertyalert_WPEntity::get_instance()->add_submenu_page();
			//settings sub menu
			Mwp_Admin_Settings_Popup_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_Settings_Mail_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_Settings_Jspluginlib_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_Settings_Clientlead_WPEntity::get_instance()->add_submenu_page();
			if( mwp_can_create_page_locations() ){
				Mwp_Admin_CreatePageByLocation_WPEntity::get_instance()->add_submenu_page();
			}
			Mwp_Admin_Theme_Layout_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_Theme_Map_WPEntity::get_instance()->add_submenu_page();
			Mwp_Admin_Theme_Text_WPEntity::get_instance()->add_submenu_page();
		}
	}
}
