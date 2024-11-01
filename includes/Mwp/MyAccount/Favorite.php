<?php
class Mwp_MyAccount_Favorite extends Mwp_MyAccount_Dashboard{
	protected static $instance = null;
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function __construct(){
		//add_filter( 'content_favorite', array($this,'controller'),10, 1 );
		add_filter( 'dashboard_content_favorites', array($this,'controller'),10, 1 );
	}

	public function get_dashboard_page(){
		if( parent::get_instance()->get_dashboard_page() ){
			return parent::get_instance()->get_dashboard_page();
		}
	}

	public function url(){
		if( $this->get_dashboard_page() ){
			return get_permalink($this->get_dashboard_page()->ID).'favorites';
		}
	}

	public function controller($args){
		global $wp_query;
		$arr_action = parent::get_instance()->md_get_query_vars();

		$action_args = $arr_action;

		$action = '';
		if( isset($arr_action->action) ){
			$action = $arr_action->action;
		}
		$task = '';
		if( isset($arr_action->task) ){
			$task = $arr_action->task;
		}

		switch($task){
			default:
				$this->get_favorites_property();
			break;
		}
	}

	public function get_favorites_property(){
		$fav = $this->get_db_favorites();
		
		if( count($fav) > 0 && $fav ){
			$data 				= array();
			$property			= array();
			$favorite_properties	= array();
			$data_properties	= array();
			$res				= array();
			$source = mwp_get_source();
			foreach($fav as $key_db => $val_db){
				$data_property 	= unserialize($val_db->meta_value);
				$source 		= $data_property['feed'];
				$id 			= $data_property['id'];
				$property[$source][] = $id;
			}
			//mwp_dump($property,1);
			$properties_key = array_keys($property);
			$data['properties_key'] = $properties_key;
			$source_template = array();
			foreach(mwp_valid_api() as $key => $val_source){
				if(in_array($val_source, $properties_key) ){
					$favorite_properties[$val_source] = apply_filters('hook_favorites_property_' . $val_source, $property[$source]);
					if( isset($favorite_properties[$source]['loop_'.$source]) ){
						$data['favorite_properties'][$source] = $favorite_properties[$source]['loop_'.$source];
					}
				}
			}
			$data['col'] = 3;
			$data['part_loop_template'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/mwp-loop-property-list-v2.php');
			$container_template = Mwp_Theme_Locator::get_instance()->locate_template('account/favorite-list.php');
			
			
			Mwp_View::get_instance()->display($container_template, $data);
		}else{
			return false;
		}
	}

	public function get_db_favorites(){
		global $wpdb;
		$user_account = mwp_wp_get_current_user();
		$query = "SELECT * FROM $wpdb->usermeta	WHERE user_id = {$user_account->ID} AND meta_key LIKE '%save-property%'";
		return $wpdb->get_results( $query, OBJECT );
	}
}
