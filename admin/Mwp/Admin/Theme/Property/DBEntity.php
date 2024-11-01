<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Theme_Property_DBEntity {
	protected static $instance = null;
	protected $property_model = null;
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

	public function db_update($input = array()){
		global $mwp;
		$config = $mwp['template'];

		$property_name = $config['property_title'];
		if( isset($input['property_name']) ){
			$property_name = $input['property_name'];
		}
		$this->property_model->property_title('u', $property_name);

		$show_bed = $config['show_bed'];
		if( isset($input['show_bed']) ){
			$show_bed = $input['show_bed'];
		}
		$this->property_model->show_bed('u', $show_bed);

		$show_bath = $config['show_bath'];
		if( isset($input['show_bath']) ){
			$show_bath = $input['show_bath'];
		}
		$this->property_model->show_bath('u', $show_bath);

		$show_garage = $config['show_garage'];
		if( isset($input['show_garage']) ){
			$show_garage = $input['show_garage'];
		}
		$this->property_model->show_garage('u', $show_garage);

		$bookaviewing_url = '';
		if( isset($input['property_bookaviewingurl']) ){
			$bookaviewing_url = $input['property_bookaviewingurl'];
		}
		$this->property_model->bookaviewing_url('u', $bookaviewing_url);

		$property_bookaviewingurl_label = '';
		if( isset($input['property_bookaviewingurl_label']) ){
			$property_bookaviewingurl_label = $input['property_bookaviewingurl_label'];
		}
		$this->property_model->bookaviewing_label('u', $property_bookaviewingurl_label);
		
		$property_bookaviewingurl_align = $config['bookaviewing_align'];
		if( isset($input['property_bookaviewingurl_align']) ){
			$property_bookaviewingurl_align = $input['property_bookaviewingurl_align'];
		}
		$this->property_model->bookaviewing_align('u', $property_bookaviewingurl_align);
	}

	public function db_delete_all_options(){
		$this->property_model->property_title('d');
		$this->property_model->bookaviewing_url('d');
		$this->property_model->show_bed('d');
		$this->property_model->show_bath('d');
		$this->property_model->show_garage('d');
	}

	public function __construct(){
		$this->property_model = new Mwp_Settings_Property_Model;
	}
}
