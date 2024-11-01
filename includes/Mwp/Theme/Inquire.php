<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Inquire Form
 * */
class Mwp_Theme_Inquire{
	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;
	private $plugin_name;
	private $version;

	public function __construct(){}
	
	public function init($plugin_name, $plugin_version){
		$this->plugin_name 	= $plugin_name;
		$this->version 	 	= $plugin_version;
		
		//add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('wp_ajax_inquireform_action', array($this,'inquireform_action_callback') );
		add_action('wp_ajax_nopriv_inquireform_action',array($this,'inquireform_action_callback') );
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
			$this->plugin_name . '-inquire-actions', 
			mwp_default_template_url() . '/js/inquire.js', 
			array(), 
			$this->version, 
			true 
		);
	}

	/**
	 * @param	array	$att
	 * */
	public function display($att){
		$show = 0;
		$data['msg'] = '';
		if( 
			isset($att['msg']) 
			&& $att['msg'] != ''
		){
			$data['msg'] = $att['msg'];
		}
		$data['assigned_to'] = '';
		if( 
			isset($att['assigned_to']) 
			&& $att['assigned_to'] != ''
		){
			$data['assigned_to'] = $att['assigned_to'];
		}
		//current property details url
		$data['source_url'] = '';
		if( 
			isset($att['source_url']) 
			&& $att['source_url'] != ''
		){
			$data['source_url'] = $att['source_url'];
		}
		$data['yourname']		= '';
		$data['yourlastname'] 	= '';
		$data['email1'] 		= '';
		$data['phone_mobile'] 	= '';
		
		if( is_user_logged_in() ){
			$current_user = mwp_wp_get_current_user();
			$data['yourname'] = $current_user->user_firstname;
			$data['yourlastname'] = $current_user->user_lastname;
			$data['email1'] = $current_user->user_email;
			$data['phone_mobile'] = get_user_meta($current_user->ID,'phone_num',true);
		}

		if( isset($att['show']) && $att['show'] == 1 ){
			$show = 1;
		}

		if( $show == 1 ){
			$inquire_form = Mwp_Theme_Locator::get_instance()->locate_template('inquire/inquire.php');
			Mwp_View::get_instance()->display($inquire_form, $data);
		}
	}

	/**
	 * Ajax call back in function ajax_request
	 * */
	public function inquireform_action_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$sitename = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
		$source = get_bloginfo('url').', '. get_bloginfo('name') . ', Inquire Form';
		$msg = '';
		$status = false;
		$array_data = array();
		$yourname 		= sanitize_text_field($_POST['yourname']);
		$yourlastname 	= sanitize_text_field($_POST['yourlastname']);
		$email 			= sanitize_text_field($_POST['email1']);
		$phone 			= sanitize_text_field($_POST['phone_mobile']);
		$inquire_msg	= sanitize_text_field($_POST['message']);
		$_POST['note']	= $source.' '.$inquire_msg;
		$fullname = $yourname.' '.$yourlastname;
		$subject  = __('Inquiry from', mwp_localize_domain()).' '.$fullname;

		$message		 = __("Name",mwp_localize_domain())." : " . $fullname . "\n\n";
		$message		.= __("Email", mwp_localize_domain()). " # : " . $email . "\n\n";
		$message		.= __("Phone", mwp_localize_domain())." # : " . $phone . "\n\n";
		$message		.= sanitize_text_field($_POST['message']);
		
		if( sanitize_text_field( trim($yourname) ) == '' ){
			$msg = "<p class='text-danger'>" . __('Please input your name', mwp_localize_domain()) . "</p>";
		}

		if( sanitize_text_field( trim($yourlastname) ) == '' ){
			$msg .= "<p class='text-danger'>".__('Please input your  last name', mwp_localize_domain())."</p>";
		}

		if( sanitize_text_field( trim($email) ) == '' ){
			$msg .= "<p class='text-danger'>".__('Please input your Email Address', mwp_localize_domain()). "</p>";
		}

		if( sanitize_text_field( !is_email($email) ) ){
			$msg .= "<p class='text-danger'>".__e('Email Address is invalid', mwp_localize_domain())."</p>";
		}

		if( $msg == '' ){
			$status = true;
			$msg = "<p class='text-success'>".__('Inquiry successfully sent. Our staff will review it as soon as possible. Thank You.', mwp_localize_domain()). "</p>";

			$headers = __('From', mwp_localize_domain()).': '.$fullname.' <'.mwp_get_email().'>' . "\r\n";
			$to 	 = mwp_get_email();
			wp_mail($to, $subject, $message, $headers );

			$_POST['lead_source'] = $source;
			$ret = Mwp_CRM_AccountDetails::get_instance()->push_crm_data($_POST);
			md_add_campaign($ret);
		}

		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die(); // this is required to return a proper result
	}
}
