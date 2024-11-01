<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.realestatewpplugin.com/
 * @since      1.0.0
 *
 * @package    Mwp
 * @subpackage Mwp/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		Mwp_Subscribe_Model::get_instance()->delete_all();
	}

}
