<?php
class Mwp_Actions_SignupForm{
	protected static $instance = null;
	private $plugin_name;
	private $version;

	public function __construct(){
		$this->init();
	}
	
	public function init(){
		add_action('wp_footer', array($this, 'display'));
		if( !is_user_logged_in() ){
			$this->plugin_name 	= mwp_plugin_name();
			$this->version 	 	= mwp_plugin_version();
			add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		}
		add_action( 'signup_action', array($this,'signup_action_callback') );
		add_action( 'wp_ajax_nopriv_signup_action',array($this,'signup_action_callback') );

		add_action( 'wp_ajax_login_action', array($this,'login_action_callback') );
		add_action( 'wp_ajax_nopriv_login_action',array($this,'login_action_callback') );
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
			$this->plugin_name . '-signup-actions', 
			mwp_public_url() . 'js/signup-min.js', 
			array( 'jquery' ), 
			$this->version, 
			true 
		);
	}

	public function user_signon($user_login, $password, $remember = true){
		$creds 					= array();
		$creds['user_login'] 	= $user_login;
		$creds['user_password'] = $password;
		$creds['remember'] 		= $remember;
		return wp_signon( $creds, false );
	}

	public function register_user($username, $password, $email, $other_data = array()){
		if( !is_user_logged_in() ){
			//username_exists
			if( !username_exists($username) && !email_exists($email) ){
				// create
				$user_id = wp_create_user($username, $password, $email);
				// Set the nickname
				wp_update_user(
					array(
						'ID'          =>    $user_id,
						'nickname'    =>    $other_data['nickname'],
						'first_name'  =>    $other_data['first_name'],
						'last_name'   =>    $other_data['last_name'],
					)
				);

				return $user_id;
			}//username_exists
		}//is_user_logged_in
		return false;
	}

	public function signup_action_callback(){
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			check_ajax_referer( 'md-ajax-request', 'security' );
		}

		$error 				= '';
		$checkuser 			= '';
		$array_data 		= array();
		$ret_data 			= array();
		$save_lead 			= array();
		$current_action 	= 0;

		if( isset($_POST['current_action']) ){
			$current_action = $_POST['current_action'];
		}

		$user_id 		= false;
		$crm_company 	= mwp_get_account_data_key('company');
		$source 		= $crm_company;
		$source_note	= $crm_company . ', Register Form';
		$source_url		= site_url();
		$msg 			= '';
		$status 		= false;
		$propertyid 	= 0;

		$firstname 		= sanitize_text_field(isset($_POST['firstname'])) ? sanitize_text_field($_POST['firstname']):'';
		$lastname 		= sanitize_text_field(isset($_POST['lastname'])) ? sanitize_text_field($_POST['lastname']):'';
		$emailaddress 	= sanitize_text_field(isset($_POST['emailaddress'])) ? sanitize_text_field($_POST['emailaddress']):'';
		$phone 			= sanitize_text_field(isset($_POST['phone'])) ? sanitize_text_field($_POST['phone']):'';
		$propertyid		= sanitize_text_field(isset($_POST['property_id'])) ? sanitize_text_field($_POST['property_id']):'';

		$name = $firstname.' '.$lastname;
		//check user exists
		$check_user = username_exists($emailaddress);
		//check email address if its unique
		$email_exists = email_exists($emailaddress);
		//check if already login
		$is_user_login = is_user_logged_in();
		if( sanitize_text_field( trim($firstname) ) == '' ){
			$msg = "<p class='text-danger'>".__('Please input your name', mwp_localize_domain())."</p>";
		}
		if( sanitize_text_field( trim($lastname) ) == '' ){
			$msg = "<p class='text-danger'>".__('Please input your last name', mwp_localize_domain())."</p>";
		}
		if( sanitize_text_field( trim($emailaddress) ) == '' ){
			$msg = "<p class='text-danger'>".__('Please input your email', mwp_localize_domain())."</p>";
		}
		if( sanitize_text_field( !is_email($emailaddress) ) ){
			$msg .= "<p class='text-danger'>".__('Email Address is invalid', mwp_localize_domain())."</p>";
		}
		if( sanitize_text_field( trim($phone) ) == '' ){
			$msg .= "<p class='text-danger'>".__('Phone is required', mwp_localize_domain())."</p>";
		}
		
		if( $msg == '' ){
			$status = true;
			// create user
			if( !$is_user_login ){
				if( !$check_user && !$email_exists){
					// create user
					$username = $emailaddress;
					$user_array = array(
						'email'			=>	$emailaddress,
						'username'		=>	$username,
						'nickname'		=>	$firstname,
						'first_name'	=>	$firstname,
						'last_name'		=>	$lastname,
					);

					$user = md_create_user($user_array);
					$user_id = $user['user_id'];
					$user_password = $user['password'];
					update_user_meta($user_id, 'phone_num', $phone);
					$notify = array(
						'name' => $firstname.' '.$lastname,
						'username' => $username,
						'password' => $user_password,
						'email' => $emailaddress,
					);
					md_user_new_notification($notify);

					$credentials = array(
						'user_id' 	=> $user_id,
					);
					md_login_user($credentials, true);
					// create user
					//push to crm
					$array_data['yourname'] 	= $firstname;
					$array_data['yourlastname'] = $lastname;
					$array_data['email1'] 		= $emailaddress;
					$array_data['phone_home'] 	= $phone;
					$array_data['lead_source'] 	= $source;
					$array_data['source_url'] 	= $source_url;

					if( !isset($array_data['note']) ){
						$array_data['note'] = $source_note;
					}
					
					$save_lead = Mwp_CRM_AccountDetails::get_instance()->push_crm_data($array_data);
					md_add_campaign($save_lead);
					//push to crm
					update_user_meta($user_id, 'lead-data', $save_lead);
					$msg = "<p class='text-success'>".__('Successfully Registered. Thank You.', mwp_localize_domain())."</p>";
				}else{
					$status = false;
					$error = 'User already exists : wp user id: '.$email_exists.' or '.$checkuser;
					//$msg = "<p class='text-danger'>".__('There was an error please contact', PLUGIN_NAME)." Masterdigm Support. <a href='mailto:support@masterdigm.com'>support@masterdigm.com</a></p>";
					$msg = "<p class='text-danger'>".$error."</p>";
					update_option('error-signup-'.$email_exists, $error);
				}
			}
		}

		$ret_data = array(
			'save_lead' => $save_lead,
			'array_data' => $array_data,
			'post' => $_POST,
		);
		$json_array = array(
			'msg'=>$msg,
			'status'=>$status,
			'ret_data' => $ret_data,
			'callback_action'=>$current_action
		);
		echo json_encode($json_array);
		die();
	}

	public function login_action_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$ret_data = array();
		$save_lead = array();
		$current_action = 0;
		if( isset($_POST['current_action']) ){
			$current_action = $_POST['current_action'];
		}
		$msg 		= '';
		$status 	= false;
		$propertyid = 0;

		$user_login = sanitize_text_field($_POST['emailaddress']);
		$password 	= sanitize_text_field($_POST['password']);
		$user 		= $this->user_signon($user_login, $password);
		
		if ( is_wp_error($user) ){
			$msg = $user->get_error_message().' Error in login';
		}else{
			$lead_data = get_user_meta($user->ID,'lead-data',true);
			if( !$lead_data || $lead_data && (!is_numeric($lead_data->leadid)) ){
				//push to crm
				$array_data['email1'] 		= $user->user_email;
				$save_lead = Mwp_CRM_AccountDetails::get_instance()->push_crm_data($array_data);
				md_add_campaign($save_lead);
				update_user_meta($user->ID, 'lead-data', $save_lead);
				//push to crm
			}
			$msg = "<p class='text-success'>".__('Successfully Loged In. Wait while we redirect you.', mwp_localize_domain())." </p>";
			$status = true;
		}
		$ret_data = array(
			'post' => $_POST,
		);
		echo json_encode(
			array(
				'msg'=>$msg,
				'status'=>$status,
				'ret_data' => $ret_data,
				'callback_action'=>$current_action
			)
		);
		die();
	}

	public function get_template_modal(){
		$data = array();
		$template = Mwp_Theme_Locator::get_instance()->locate_template('modal/signup.php');
		if( has_filter('shortcode_signup_template_modal') ){
			$template = apply_filters('shortcode_signup_template_modal', $template);
		}
		return $template;
	}

	public function get_template_form(){
		$data = array();
		$template = Mwp_Theme_Locator::get_instance()->locate_template('modal/form.php');
		if( has_filter('shortcode_signup_template_form') ){
			$template = apply_filters('shortcode_signup_template_form', $template);
		}
		return $template;
	}

	public function display(){
		if( !is_user_logged_in() ){
			// hook filter, incase we want to just use hook
			$data['template_form'] = $this->get_template_form();
			Mwp_View::get_instance()->display($this->get_template_modal(), $data);
		}
	}
}

