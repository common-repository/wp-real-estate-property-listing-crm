<?php
class Mwp_Actions_Favorite{
	protected static $instance = null;

	protected $key_save_property = 'save-property-';

	public function __construct(){
		$this->init();
	}
	
	public function init(){
		if( is_user_logged_in() ){
			add_action( 'wp_ajax_saveproperty_action', array($this,'saveproperty_action_callback') );
			add_action( 'wp_ajax_nopriv_saveproperty_action',array($this,'saveproperty_action_nopriv_callback') );
			add_action( 'wp_ajax_remove_property_action', array($this,'remove_property_action_callback') );
			add_action( 'wp_ajax_nopriv_remove_property_action',array($this,'remove_property_action_nopriv_callback') );
			add_action( 'execute_after_signup_add-favorite',array($this,'add_favorite'),10, 2 );
		}
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

	public function saveproperty_action_callback(){
		$current_user = mwp_wp_get_current_user();

		$current_action = 0;
		$ret_data = array();
		$post = array();
		if( isset($_POST['post_data']) ){
			$post = $_POST['post_data'];
		}

		$post_data = array();
		if( isset($_POST['post_data']) ){
			$post_data = $_POST['post_data'];
			parse_str($post_data['post']['data_post'],$ajax_data_post);
		}

		$post_property_id = 0;
		if( isset($ajax_data_post['property-id']) ){
			$post_property_id = $ajax_data_post['property-id'];
		}else{
			$post_property_id = $_POST['property-id'];
		}

		$post_property_feed = mwp_get_current_api_source();
		if( isset($ajax_data_post['property-feed']) ){
			$post_property_feed = $ajax_data_post['property-feed'];
		}else{
			$post_property_feed = $_POST['property-feed'];
		}

		$msg 	= '';
		$status = false;

		$msg 		 = 'Successfully save property';
		$status 	 = true;
		$user_id 	 = $current_user->ID;
		$property_id = sanitize_text_field($post_property_id);
		$feed 		 = sanitize_text_field($post_property_feed);

		if( $property_id != 0 || $property_id != '' ){
			$save_property = array(
				'id' => $property_id,
				'feed' => $feed
			);
			update_user_meta($user_id, 'save-property-' . $property_id, $save_property);
			delete_user_meta($user_id, 'xout-property-' . $property_id);
		}

		$json_return = array(
			'msg'=>$msg,
			'status'=>$status,
			'ret_data' => $ret_data,
			'callback_action'=>$current_action
		);
		echo json_encode(
			$json_return
		);
		die();
	}

	public function saveproperty_action_nopriv_callback(){
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

	public function remove_property_action_nopriv_callback(){
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
	public function remove_property_action_callback(){
		$current_user = mwp_wp_get_current_user();

		$msg 	= '';
		$status = false;

		$msg = 'Successfully Remove property';
		$status = true;
		$user_id = $current_user->ID;
		$property_id = sanitize_text_field($_POST['property-id']);
		delete_user_meta($user_id, 'save-property-' . $property_id);

		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die();
	}

	public function check_property($property_id, $user_id = null){
		$current_user = mwp_wp_get_current_user();
		if( !$user_id ){
			$user_id = $current_user->ID;
		}

		if(is_user_logged_in()) {
			$get = get_user_meta($user_id, $this->key_save_property . $property_id, true);
			if( $get && count($get) > 0 ){
				return true;
			}
		}
		return false;
	}

}
