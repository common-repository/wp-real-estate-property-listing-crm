<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.realestatewpplugin.com/
 * @since      1.0.0
 *
 * @package    Mwp
 * @subpackage Mwp/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_i18n {

	/**
	 * The domain specified for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $domain    The domain identifier for this plugin.
	 */
	private $domain;

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		$domain = $this->domain;
		$md_lang_dir = dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/';
		$locale = apply_filters('plugin_locale', get_locale(), $domain);
		$mofile = sprintf( '%1$s-%2$s.mo', $domain, $locale );
		$mo_file_wp = WP_LANG_DIR . "/{$domain}/". $mofile;
		
		if( file_exists($mo_file_wp) ){
			load_textdomain($domain, $mo_file_wp);
		}else{
			load_plugin_textdomain(
				$domain,
				false,
				$md_lang_dir
			);
		}
	}

	/**
	 * Set the domain equal to that of the specified domain.
	 *
	 * @since    1.0.0
	 * @param    string    $domain    The domain that represents the locale of this plugin.
	 */
	public function set_domain( $domain ) {
		$this->domain = $domain;
	}
}
