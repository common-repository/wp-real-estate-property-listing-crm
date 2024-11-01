<?php
class Mwp_Actions_EmailTo{
	protected static $instance = null;
	private $plugin_name;
	private $version;

	public function __construct(){
		$this->plugin_name 	= mwp_plugin_name();
		$this->version 	 	= mwp_plugin_version();

		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action( 'wp_ajax_sendtofriend_action', array($this,'sendtofriend_action_callback') );
		add_action( 'wp_ajax_nopriv_sendtofriend_action',array($this,'sendtofriend_action_callback') );
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
			$this->plugin_name . '-emailto-actions', 
			mwp_public_url() . 'js/emailto-min.js', 
			array( 'jquery' ), 
			$this->version, 
			true 
		);
	}

	public function sendtofriend_action_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );

		$current_user = mwp_wp_get_current_user();

		$source = get_bloginfo('url').', '. get_bloginfo('name') . ', ' . __('Send to friend Form', mwp_localize_domain());

		$msg 	= '';
		$status = false;
		$yourname = '';
		if( isset($_POST['yourname']) ){
			$yourname = sanitize_text_field($_POST['yourname']);
		}
		$friendsemail = '';
		if( isset($_POST['friendsemail']) ){
			$friendsemail = sanitize_text_field($_POST['friendsemail']);
		}
		$youremail = '';
		if( isset($_POST['youremail']) ){
			$youremail = sanitize_text_field($_POST['youremail']);
		}
		$message = '';
		if( isset($_POST['message']) ){
			$message = sanitize_text_field($_POST['message']);
		}
		$friendsemail 	= $friendsemail;
		$yourname 		= $yourname;
		$youremail 		= $youremail;
		$message 		= $message;

		//check user exists
		$check_user = username_exists($youremail);
		//check email address if its unique
		$email_exists = email_exists($youremail);

		//check if already login
		$is_user_login = is_user_logged_in();

		if( !$is_user_login ){
			if( sanitize_text_field( trim($yourname) ) == ''){
				$msg = "<p class='text-danger'>" . __('Please input your name', mwp_localize_domain()) . "</p>";
			}
		}

		if( sanitize_text_field( trim($friendsemail) ) == '' ){
			$msg .= "<p class='text-danger'>" . __('Please input friends email', mwp_localize_domain()) . "</p>";
		}

		if( !is_email($friendsemail) ){
			$msg .= "<p class='friendsemail text-danger'>" . __('Email Address is invalid', mwp_localize_domain()) . "</p>";
		}
		if( !$is_user_login ){
			if( sanitize_text_field( trim($youremail) ) == '' ){
				$msg = "<p class='text-danger'>". __('Please input your email', mwp_localize_domain()) . "</p>";
			}
		}

		if( is_user_logged_in() ){
			$yourname  = $current_user->display_name;
			$youremail = $current_user->user_email;
		}

		if( !is_email($youremail) ){
			$msg .= "<p class='youremail text-danger'>" . __('Email Address is invalid', mwp_localize_domain()). "</p>";
		}

		//$status
		if( $msg == '' ){
			$status = true;
			if( !$is_user_login ){
				if( !$check_user && !$email_exists){
					// create user
					$password 	= wp_generate_password(12, false);
					$user_id 	= Mwp_Actions_SignupForm::get_instance()->register_user($youremail, $password, $youremail, array('nickname'=>$yourname));
					$notify = array(
						'name' => $yourname,
						'username' => $youremail,
						'password' => $password,
						'email' => $youremail,
					);
					md_user_new_notification($notify);
					$credentials = array(
						'user_id' 	=> $user_id,
					);
					md_login_user($credentials, true);
				}
			}

			$array_data['lead_source'] 	= $source;
			$array_data['email1'] 		= $friendsemail;
			$array_data['note'] 		= $source.' '.$message;
			$ret_push_crm = Mwp_CRM_AccountDetails::get_instance()->push_crm_data($array_data);
			md_add_campaign($ret_push_crm);

			// send email here
			$msg = "<p class='text-success'>" . __('Successfully Send Email to Friend. Thank You.', mwp_localize_domain()) . "</p>";

			$headers  = 'From: '.$yourname.' <'.mwp_get_email().'>' . "\r\n";
			$headers  .= 'Cc: '.$yourname.' <'.$youremail.'>' . "\r\n" ;
			$to 	  = $friendsemail;
			$subject  = __('Send to friend from ', mwp_localize_domain()) . ': '.$yourname;
			$message  = $_POST['message']."r\n".$_POST['url'];
			wp_mail($to, $subject, $message, $headers );
		}
		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die(); // this is required to return a proper result
	}


	public function display(){
		$template = Mwp_Theme_Locator::get_instance()->locate_template('actionbuttons/emailto.php');
		Mwp_View::get_instance()->display($template, array());
	}
}
