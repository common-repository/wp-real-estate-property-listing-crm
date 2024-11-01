<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Settings_Search_Price_DBEntity{
	protected static $instance = null;
	protected $price_range_model = null;
	protected $mwp_config;
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

	public function get_mwp_config(){
		return $this->mwp_config;
	}

	public function get_ten_start(){
		$config_ten_start = $this->get_mwp_config();
		$ten_start = $config_ten_start['ten']['start'];
		return $this->price_range_model->ten_start('r', $ten_start);
	}

	public function get_ten_end(){
		$config_ten = $this->get_mwp_config();
		$ten = $config_ten['ten']['end'];
		return $this->price_range_model->ten_end('r', $ten);
	}

	public function get_ten_step(){
		$config_ten = $this->get_mwp_config();
		$ten = $config_ten['ten']['step'];
		return $this->price_range_model->ten_step('r', $ten);
	}

	public function get_hundred_start(){
		$config_hundred = $this->get_mwp_config();
		$hundred = $config_hundred['hundred']['start'];
		return $this->price_range_model->hundred_start('r', $hundred);
	}

	public function get_hundred_end(){
		$config_hundred = $this->get_mwp_config();
		$hundred = $config_hundred['hundred']['end'];
		return $this->price_range_model->hundred_end('r', $hundred);
	}

	public function get_hundred_step(){
		$config_hundred = $this->get_mwp_config();
		$hundred = $config_hundred['hundred']['step'];
		return $this->price_range_model->hundred_step('r', $hundred);
	}

	public function get_million_start(){
		$config_million = $this->get_mwp_config();
		$million = $config_million['million']['start'];
		return $this->price_range_model->million_start('r', $million);
	}

	public function get_million_end(){
		$config_million = $this->get_mwp_config();
		$million = $config_million['million']['end'];
		return $this->price_range_model->million_end('r', $million);
	}

	public function get_million_step(){
		$config_million = $this->get_mwp_config();
		$million = $config_million['million']['step'];
		return $this->price_range_model->million_step('r', $million);
	}


	public function __construct(){
		global $mwp;
		$this->mwp_config = $mwp['search_settings_price'];
		$this->price_range_model = new Mwp_Settings_Search_Price_Model;
	}
}
