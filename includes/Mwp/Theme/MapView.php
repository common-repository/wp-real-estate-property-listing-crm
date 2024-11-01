<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get and locate template
 * */
class Mwp_Theme_MapView{
	protected static $instance = null;

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	
	public function init(){
		$map_data = array();
		$map_data['container'] = Mwp_Theme_Locator::get_instance()->locate_template(mwp_default_template_list_file());
		$map_data['map_view'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/part-map-view.php');
		$map_data['content'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/part-content-map.php');
		$map_data['header'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/part-header-map.php');
		$map_data['footer'] = '';
		$map_data['col_left'] = 'col-md-7';
		$map_data['col_map'] = 'col-md-5';
		$map_data['col'] = 4;
		$map_data['content'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/part-content-map.php');
		$map_data['header'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/part-header-map.php');
		$map_data['footer'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/part-footer-map.php');
		$map_data['limit'] = 25;
		$basename = pathinfo(getcwd());
		$map_data['basename'] = '';
		if (strpos($basename['basename'], ".") === false) {
			$map_data['basename'] = $basename['basename'];
		}
		$map_data += Mwp_Theme_List::get_instance()->grid_layout();
		return $map_data;
	}	
			
	public function __construct(){}	
	
}
