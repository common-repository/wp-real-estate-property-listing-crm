<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setup CRM Key
 * */
class Mwp_Controllers_CreatePageByLocation_Init extends Mwp_Base{
	protected static $instance = null;
	protected $wpentity = null;
	protected $entity = null;
	
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
	
	public function update_theme_property(){

	}

	/**
	 * display form
	 *
	 * form to subscribe masterdigm crm api keys
	 * */
	public function index(){
		$data =  array();
		$last_log = '';
		$log 	 = $this->entity->parse_option_log();
		$raw_log = $this->entity->get_option_log();

		$notice = 'Create pages base on the market coverage you choose in CRM.<br>';
		$notice .= 'You can set the status of the page default is Publish <br>';
		$button = 'Create Page by Location';
		$status = array(
			'publish' => 'Publish',
			'draft'   => 'Draft',
		);
		$option_name = '';
		if( $log->total > 0 ){
			$last_log = end($raw_log);
			$option_name = $last_log->option_name;

			$notice = __('It seems you have already create pages by location.', mwp_localize_domain()) . '<br>';
			$notice .= __('you can set status of the pages, If you want to update the pages re-run it and it will auto detect those locations you add in the CRM', mwp_localize_domain()) . '<br>';
			$notice .= __('You can also set status or delete it ( not the delete is force, it will not mark as trash ) it will remove those last pages you created ( check the date below "last activity" )', mwp_localize_domain()) . '<br>';
			$button = __('Update Page', mwp_localize_domain());
			$status = array(
				'publish' => __('Publish', mwp_localize_domain()),
				'draft'   => __('Draft', mwp_localize_domain()),
				'trash'	  => __('Trash', mwp_localize_domain()),
			);
		}
		$data['notice'] = $notice;
		$data['log'] = $log;
		$data['raw_log'] = $raw_log;
		$data['button'] = $button;
		$data['status'] = $status;
		$data['option_name'] = $option_name;
		$data['last_log'] = $last_log;

		Mwp_View::get_instance()->admin_partials('createpagebylocation/index.php', $data);
	}

	/**
	 * Index
	 * */
	public function md_create_page_by_location(){
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
		$this->wpentity = new Mwp_Admin_CreatePageByLocation_WPEntity;
		$this->entity = new Mwp_Admin_CreatePageByLocation_Entity;
	}
}
