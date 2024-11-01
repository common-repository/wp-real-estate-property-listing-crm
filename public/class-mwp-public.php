<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.realestatewpplugin.com/
 * @since      1.0.0
 *
 * @package    Mwp
 * @subpackage Mwp/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Mwp
 * @subpackage Mwp/public
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_Public {

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
	 * array of localize data
	 * */
	private $localize_array;
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->localize_array = array();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mwp-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-md-style', plugin_dir_url( __FILE__ ) . 'css/md-style.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-md-style-listing', plugin_dir_url( __FILE__ ) . 'css/md-listing.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-md-property-details', plugin_dir_url( __FILE__ ) . 'css/md-property-page.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
			
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		//wp_enqueue_script( 'jquery-ui-accordion' );
		wp_enqueue_script( 'underscore' );
		
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
		$this->js_plugin_lib($this->plugin_name);
		$this->css_plugin_lib($this->plugin_name);
		if( mwp_get_headers() == 0 || mwp_is_search_view_list() ){
			$this->mwp_js_plugin_lib($this->plugin_name);
			$this->mwp_css_plugin_lib($this->plugin_name);
		}
		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/mwp-public.js',
			array( 'jquery' ),
			$this->version,
			true
		);
		$this->localize_script($this->plugin_name);
		wp_enqueue_script(
			$this->plugin_name . '-search',
			plugin_dir_url( __FILE__ ) . 'js/mwp-public-search.js',
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
	}

	public function localize_script($handle){
		wp_localize_script(
			$handle,
			'MDAjax',
			mwp_localize_script()
		);
	}

	public function add_localize_script($data = array()){
		$this->localize_array[] = $data;
	}

	public function js_plugin_lib($handle){
		global $mwp;
		foreach($mwp['jsplugin-library-script'] as $key => $val){
			wp_enqueue_script(
				$this->plugin_name . $key,
				$val['src'],
				$val['deps'],
				$val['version'],
				$val['in_footer']
			);
		}
	}

	public function css_plugin_lib($handle){
		global $mwp;
		foreach($mwp['jsplugin-library-css'] as $key => $val){
			wp_enqueue_style(
				$this->plugin_name . $key,
				$val['src'],
				$val['deps'],
				$val['version'],
				$val['in_footer']
			);
		}
	}
	
	public function mwp_js_plugin_lib($handle){
		global $mwp;
		foreach($mwp['mwp-jsplugin-library-script'] as $key => $val){
			wp_enqueue_script(
				$this->plugin_name . $key,
				$val['src'],
				$val['deps'],
				$val['version'],
				$val['in_footer']
			);
		}
	}

	public function mwp_css_plugin_lib($handle){
		global $mwp;
		foreach($mwp['mwp-jsplugin-library-css'] as $key => $val){
			wp_enqueue_style(
				$this->plugin_name . $key,
				$val['src'],
				$val['deps'],
				$val['version'],
				$val['in_footer']
			);
		}
	}

}
