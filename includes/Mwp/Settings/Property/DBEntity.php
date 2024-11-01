<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Property_DBEntity{
	protected static $instance = null;
	protected $property_model = null;
	protected $mwp_config = null;
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

	public function get_property_title(){
		$mwp_config = $this->mwp_config;
		$default_title = $mwp_config['template']['property_title'];
		return $this->property_model->property_title('r', $default_title);
	}

	public function get_show_bed(){
		$mwp_config = $this->mwp_config;
		$show_bed = $mwp_config['template']['show_bed'];
		return $this->property_model->show_bed('r', $show_bed);
	}

	public function get_show_bath(){
		$mwp_config = $this->mwp_config;
		$show_bath = $mwp_config['template']['show_bath'];
		return $this->property_model->show_bath('r', $show_bath);
	}

	public function get_show_garage(){
		$mwp_config = $this->mwp_config;
		$show_garage = $mwp_config['template']['show_garage'];
		return $this->property_model->show_garage('r', $show_garage);
	}

	public function get_book_a_viewing_url(){
		return $this->property_model->bookaviewing_url('r');
	}

	public function get_book_a_viewing_label(){
		$mwp_config = $this->mwp_config;
		$bookaviewing_label = $mwp_config['template']['bookaviewing_label'];
		return $this->property_model->bookaviewing_label('r', $bookaviewing_label);
	}

	public function get_book_a_viewing_align(){
		$mwp_config = $this->mwp_config;
		$bookaviewing_align = $mwp_config['template']['bookaviewing_align'];
		return $this->property_model->bookaviewing_align('r', $bookaviewing_align);
	}

	public function __construct(){
		global $mwp;
		$this->mwp_config = $mwp;
		$this->property_model = new Mwp_Settings_Property_Model;
	}
}
