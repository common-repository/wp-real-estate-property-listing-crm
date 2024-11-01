<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get and locate template
 * */
class Mwp_Theme_List{
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
	
	/**
	 * get the grid layout template
	 * this is for the loop box only
	 * also added hook for more convenient 
	 * @param	$template	array 
	 * 						store the container layout and other related layout
	 * 						if the current index is empty we grab the default
	 * 						else it is a customize layout
	 * @return	string
	 * */
	public function grid_layout($template = array()){
		$grid_layout = array();
		$grid_layout['container'] = Mwp_Theme_Locator::get_instance()->locate_template(mwp_default_template_list_file());
		if( isset($template['container'])
			&& $template['container'] != ''
		){
			$grid_layout['container'] = $template['container'];
		}
		$grid_layout['container'] = apply_filters('mwp_hook_grid_layout_container', $grid_layout['container']);
		$loop_template = mwp_default_template_loop_list_file();
		$grid_layout['part_loop_template'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/' . $loop_template);
		//$grid_layout['part_loop_template'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/mwp-loop-property-grid.php');
		$grid_layout['part_loop_template'] = apply_filters('mwp_hook_grid_layout_part_loop', $grid_layout['part_loop_template']);
		if( isset($template['part_loop_template'])
			&& $template['part_loop_template'] != ''
		){
			$grid_layout['part_loop_template'] = $template['part_loop_template'];
		}

		return $grid_layout;
	}
	
	public function init(){
		$arr_list = array();
		$arr_list['col_left'] = 'col-md-12';
		$arr_list['col_map'] = 'hidden';
		$arr_list['col'] = mwp_get_search_result_col();
		$arr_list['content'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/part-content-list.php');
		$arr_list['header'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/part-header-list.php');
		$arr_list['footer'] = '';
		$arr_list['limit'] = mwp_get_limit();
		$arr_list['basename'] = '';
		$arr_list += $this->grid_layout();
		return $arr_list;
	}
		
	public function __construct(){}	
	
}
