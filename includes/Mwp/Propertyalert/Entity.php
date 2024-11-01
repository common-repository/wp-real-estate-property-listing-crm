<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Propertyalert_Entity{
	protected static $instance = null;
	public $http_api_args = array();

	public function __construct(){
		$this->http_api_args = array(
			'timeout' => 100, 
			'redirection' => 100
		);
		$this->plugin_name 	= mwp_plugin_name();
		$this->version 	 	= mwp_plugin_version();
		$this->init_wp_hook();
	}

	public function init_wp_hook(){
		add_action( 'wp_ajax_property_alert_action', array($this,'property_alert_action_callback') );
		add_action( 'wp_ajax_nopriv_property_alert_action',array($this,'property_alert_action_nopriv_callback') );
		add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action( 'execute_after_signup',array($this, 'property_alert_init'),10, 2 );
	}

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

	public function enqueue_scripts(){
		wp_enqueue_script( 
			$this->plugin_name . '-property-alert-actions', 
			mwp_public_url() . 'js/property-alert-min.js', 
			array( 'jquery' ), 
			$this->version, 
			true 
		);
	}
	
	public function get_coverage_lookup_key($string, $array_key = 'keyword'){
		$result 	= array();
		$string 	= strtolower($string);
		$location 	= Mwp_MLS_CoverageLookup::get_instance()->coverage_lookup();
		$city_id 	= 0;
		$city 		= '';
		if( $location->result == 'success' && isset($location->result) ){
			foreach($location->lookups as $key => $val){
				$find = strtolower($val->$array_key);
				if( $find == $string ){
					$result = array(
						'keyword'	=>	$val->keyword,
						'full'		=>	$val->full,
						'id'		=>	$val->id,
						'type'		=>	$val->location_type,
						'city'		=>	isset($val->city_id) ? $val->city:'',
						'city_id'	=>	isset($val->city_id) ? $val->city_id:0,
					);
				}
			}
		}
		return $result;
	}
	
	public function subscribe_property_alert($post_data = array()){
		$current_user = mwp_wp_get_current_user();

		$user_meta = get_user_meta($current_user->ID);
		if( $user_meta && isset($user_meta['lead-data']) ){
			$crm_company 					= mwp_get_account_data_key('company');
			$lead_data 						= unserialize($user_meta['lead-data'][0]);
			$post_data['leadid'] 			= $lead_data->leadid;
			$post_data['lead_name'] 		= $current_user->user_firstname.' '.$current_user->user_lastname;
			$post_data['lead_email'] 		= $current_user->user_email;
			$post_data['source_website']	= $post_data['source_website'];
			$post_data['source_url']		= $post_data['source_url'];
			$post_data['source'] 			= $crm_company;

			strtolower($post_data['transaction']);

			if( $post_data['communityid'] != 0 ){
				$loc = $this->get_coverage_lookup_key($post_data['communityid'],'id');
				if( $loc['type'] == 'community' ){
					$post_data['city'] 		= $loc['city'];
					$post_data['community'] = $loc['keyword'];
				}
			}

			if( $post_data['cityid'] != 0 ){
				$loc = $this->get_coverage_lookup_key($post_data['cityid'],'id');
				if( $loc['type'] == 'city' ){
					$post_data['city'] 		= $loc['keyword'];
				}
			}

			return Mwp_MLS_Adapter::get_instance()->add_property_alert($post_data);
		}

		return false;
	}

	public function ajax_subscribe_property_alert($data = array()){
		$current_user = mwp_wp_get_current_user();
		$post_data = array();
		if( isset($_POST['post_data']) ){
			$post_data = $_POST['post_data'];
			parse_str($post_data['post']['data_post'],$ajax_data_post);
		}

		return $this->subscribe_property_alert($ajax_data_post);
	}

	// for logged in users
	public function property_alert_action_callback(){
		$ret = $this->ajax_subscribe_property_alert();
		$msg = 'logged in users';
		$status = true;
		echo json_encode(
			array(
				'msg'=>$msg,
				'status'=>$status,
				'is_loggedin'=>1,
				'ret'=>$ret
			)
		);
		die();
	}

	// for not logged in users
	public function property_alert_action_nopriv_callback(){
		$msg = 'not logged in user';
		$status = true;
		echo json_encode(
			array(
				'msg'=>$msg,
				'status'=>$status,
				'is_loggedin'=>0
			)
		);
		die();
	}

	public function display_unsubscribe_button($atts){
		$count_subscribe_property_alert = 0;
		$user_account 					= mwp_wp_get_current_user();
		$get_savesearch_by_userid 		= Mwp_Actions_SaveSearch::get_instance()->get_all_by_userid($user_account->ID);
		if( $get_savesearch_by_userid && count($get_savesearch_by_userid) > 0 ){
			foreach($get_savesearch_by_userid as $key => $val){
				$meta_value = unserialize($val->meta_value);
				if( isset($meta_value['subscribed_property_alert']) && $meta_value['subscribed_property_alert'] == 1 ){
					$count_subscribe_property_alert++;
				}
			}
		}
		$data['class'] 		= '';
		$data['count'] 		= $count_subscribe_property_alert;
		$data['user_id'] 	= $user_account->ID;

		if( mwp_get_current_api_source() == 'mls' ){
			$template = Mwp_Theme_Locator::get_instance()->locate_template('save-search/un-subscribe.php');
			Mwp_View::get_instance()->display($template, $data);
		}
	}



	public function crm_unsubscribe($email = null){
		$user_account = mwp_wp_get_current_user();

		if( is_null($email) ){
			if( isset($_GET['email']) && sanitize_text_field($_GET['email']) ){
				$email = sanitize_email($_GET['email']);
			}
			if( isset($_POST['email']) && sanitize_text_field($_POST['email']) ){
				$email = sanitize_email($_POST['email']);
			}
		}

		if(
			trim($email) !=''
			&& is_email($email)
			&& email_exists( $email )
		){
			$api_http = "http://masterdigmserver1.com/alert/unsubscribe?email={$email}";
			$response = wp_remote_get( $api_http, $this->http_api_args );
			if( $response['response']['code'] == 200 ){
				$crm_response = $response['body'];
				$crm_response = json_decode($crm_response);
				if( $crm_response->result == 'success' ){
					if( !is_user_logged_in() ){
						$user_account = get_user_by( 'email', $email );
					}
					$get_savesearch_by_userid 	= Mwp_Actions_SaveSearch::get_instance()->get_all_by_userid($user_account->ID);
					if( $get_savesearch_by_userid && count($get_savesearch_by_userid) > 0 ){
						foreach($get_savesearch_by_userid as $key => $val){
							$meta_value = unserialize($val->meta_value);
							$meta_value['subscribed_property_alert'] = 0;
							update_user_meta( $user_account->ID, $meta_value['user_meta_name'], $meta_value );
						}
					}
					return true;
				}
			}
		}
		return false;
	}

}

