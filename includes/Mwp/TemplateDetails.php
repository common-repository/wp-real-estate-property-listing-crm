<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Load template
 * */
class Mwp_TemplateDetails{
	protected static $instance = null;

	public function __construct(){}

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

	public function get_list_template_desc($path, $str_replace_path = null){
		$files = Mwp_Helpers_File::scandir($path, 'php');

		$header_array = array(
			'Template Name'=>'Template Name'
		);

		$template_file = array();
		if( count($files) > 0 ){
			foreach($files as $file){
				$get_file_data = Mwp_Helpers_File::get_file_data($file, $header_array);
				$template_file[str_replace($str_replace_path, '', $file)] = $get_file_data['Template Name'];
			}
		}

		return $template_file;
	}

	/**
	 * @param	$list_only	string
	 * */
	public function get_theme_page_template($path, $str_replace_path, $list_only = null){
		$plugin_template_theme = array();

		if( trim($path) != '' && file_exists($path)){
			$plugin_template 		= $this->get_list_template_desc($path, $str_replace_path);
			$plugin_template_theme 	= array();
			if( count($plugin_template) > 0 ){
				foreach($plugin_template as $key => $val ){
					if( !is_null($list_only) ){
						if( stripos($val, $list_only) !== false ){
							$plugin_template_theme[$key] = $val;
						}
					}else{
						$plugin_template_theme[$key] = $val;
					}
				}
			}
		}

		$wp_page_template 	= array();
		$wp_get_page_template 	= wp_get_theme()->get_page_templates();
		if( count($wp_get_page_template) > 0 ){
			foreach($wp_get_page_template as $key => $val){
				if( stripos($val, $list_only) !== false ){
					$wp_page_template[$key] = $val;
				}
			}
		}
		return $plugin_template_theme + $wp_page_template;
	}
}
