<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Admin_Search_Pricerange_DBEntity{
	protected static $instance = null;
	protected $db_entity = null;
	protected $price_range_model = null;
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

	public function db_update_price_range($input = array()){
		$price_range_ten_start = $input['price_range_ten_start'];
		$this->price_range_model->ten_start('u', $price_range_ten_start);
		$price_range_ten_end = $input['price_range_ten_end'];
		$this->price_range_model->ten_end('u', $price_range_ten_end);
		$price_range_ten_step = $input['price_range_ten_step'];
		$this->price_range_model->ten_step('u', $price_range_ten_step);

		$price_range_hundred_start = $input['price_range_hundred_start'];
		$this->price_range_model->hundred_start('u', $price_range_hundred_start);
		$price_range_hundred_end = $input['price_range_hundred_end'];
		$this->price_range_model->hundred_end('u', $price_range_hundred_end);
		$price_range_hundred_step = $input['price_range_hundred_step'];
		$this->price_range_model->hundred_step('u', $price_range_hundred_step);

		$price_range_million_start = $input['price_range_million_start'];
		$this->price_range_model->million_start('u', $price_range_million_start);
		$price_range_million_end = $input['price_range_million_end'];
		$this->price_range_model->million_end('u', $price_range_million_end);
		$price_range_million_step = $input['price_range_million_step'];
		$this->price_range_model->million_step('u', $price_range_million_step);
	}


	public function delete_all(){
		$this->price_range_model->ten_start('d');
		$this->price_range_model->ten_end('d');
		$this->price_range_model->ten_step('d');
		$this->price_range_model->hundred_start('d');
		$this->price_range_model->hundred_end('d');
		$this->price_range_model->hundred_step('d');
		$this->price_range_model->million_start('d');
		$this->price_range_model->million_end('d');
		$this->price_range_model->million_step('d');
	}

	public function __construct(){
		$this->price_range_model = new Mwp_Settings_Search_Price_Model;
	}
}


