<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_Search_SettingsPriceRange extends Mwp_Base{
	protected static $instance = null;
	protected $search_admin_entity = null;
	protected $search_admin_wpentity = null;
	protected $db_entity = null;
	protected $admin_db_entity = null;
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
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function index(){
		$data =  array();
		$tab_nav = $this->search_admin_entity->tab_nav();
		$data['url_slug'] = $this->search_admin_wpentity->get_admin_url_slug() . '&tab=' . $tab_nav['_tab'];
		$data['price_range_ten_start'] = $this->db_entity->get_ten_start();
		$data['price_range_ten_end'] = $this->db_entity->get_ten_end();
		$data['price_range_ten_step'] = $this->db_entity->get_ten_step();
		$data['price_range_hundred_start'] = $this->db_entity->get_hundred_start();
		$data['price_range_hundred_end'] = $this->db_entity->get_hundred_end();
		$data['price_range_hundred_step'] = $this->db_entity->get_hundred_step();
		$data['price_range_million_start'] = $this->db_entity->get_million_start();
		$data['price_range_million_end'] = $this->db_entity->get_million_end();
		$data['price_range_million_step'] = $this->db_entity->get_million_step();

		$data += $tab_nav;
		Mwp_View::get_instance()->admin_partials('search/settings/settings-pricerange.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_settings_search_pricerange(){
		$this->index();
	}
	/**
	 * update
	 * */
	public function update_price_range(){
		$this->admin_db_entity->db_update_price_range($_POST);
		$this->index();
	}

	/**
	 * Controller
	 *
	 * @param	$action		string | empty
	 * @parem	$arg		array
	 * 						optional, pass data for controller
	 * @return mix
	 * */
	public function controller($action = '', $arg = array()){
		$this->call_method($this, $action);
	}

	public function __construct(){
		$this->search_admin_entity = new Mwp_Admin_Search_Settings;
		$this->search_admin_wpentity = new Mwp_Admin_Search_Pricerange_WPEntity;
		$this->db_entity = new Mwp_Settings_Search_Price_DBEntity;
		$this->admin_db_entity = new Mwp_Admin_Search_Pricerange_DBEntity;
	}
}
