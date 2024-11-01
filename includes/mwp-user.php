<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * create user function
 * - create user
 * @param	$data	array()		possible items:
 * 								this is for create user
 * 									email: the main base of the account
 * 									username: the login username, the default is the email
 * 									password: it not set will generate password, if set then user has preference password
 * 									first_name: the first name of the current user
 * 									last_name: the last name of the current user
 * 									nickname: if not set, first_name will be used
 * */
function md_create_user($data = array()){
	//check user must not logged in
	$return_msg 	= '';
	$return_status 	= false;

	$email = '';
	if( isset($data['email']) ){
		$email = $data['email'];
	}
	$username = '';
	if( isset($data['username']) ){
		$username = $data['username'];
	}
	$password = wp_generate_password(12, false);
	if( isset($data['password']) ){
		$password = $data['password'];
	}
	$first_name = '';
	if( isset($data['first_name']) ){
		$first_name = $data['first_name'];
	}
	$last_name = '';
	if( isset($data['last_name']) ){
		$last_name = $data['last_name'];
	}
	$nickname = $first_name;
	if( isset($data['nickname']) ){
		$nickname = $data['nickname'];
	}
	//continue
	//check email and username must not exists
	if( !email_exists($email) && !username_exists($username) ){
		//create user here
		$create_user_array = array(
			'email' 		=> $email,
			'username' 		=> $username,
			'password' 		=> $password,
			'first_name' 	=> $first_name,
			'last_name' 	=> $last_name,
			'nickname' 		=> $nickname
		);
		$user = Mwp_User::get_instance()->create($create_user_array);
	}

	if( $user ){
		return $user;
	}else{
		return false;
	}
}
/* *
 * login user
 * @param $credentials		array()			for login user data:
 * 											user_login: username
 * 											user_password: password
 * 											remember: default is true
 * */
function md_login_user($credentials = array(), $direct = false){
	return Mwp_User::get_instance()->login($credentials, $direct);
}
/**
 * register user function
 * - create user
 * - auto login
 * - send user credentials
 * - push to crm
 * @param	$data	array()		possible items:
 * 								this is for create user
 * 									email: the main base of the account
 * 									username: the login username, the default is the email
 * 									password: it not set will generate password, if set then user has preference password
 * 									first_name: the first name of the current user
 * 									last_name: the last name of the current user
 * 									nickname: if not set, first_name will be used
 * 								for login user
 * 									user_login: username will be use instead
 * 									user_password: password will be use instead
 * 									remember: default is true
 * */
function md_register_user($data = array()){
	if( !is_user_logged_in() ){
		return md_create_user($data);
	}else{
		//login
	}
}
/**
 * un-subscribe user in property alert
 * */
function md_unsubscribe_palert($email){

}

function md_user_new_notification($notify_array){
	global $wp_login_url;

	$content = Mwp_Settings_Mail_Model::get_instance()->content('r');
	$subject = Mwp_Settings_Mail_Model::get_instance()->subject('r');

	$name = '';
	if( isset($notify_array['name']) ){
		$name = $notify_array['name'];
	}

	$username = '';
	if( isset($notify_array['username']) ){
		$username = $notify_array['username'];
	}

	$password = '';
	if( isset($notify_array['password']) ){
		$password = $notify_array['password'];
	}

	$email = '';
	if( isset($notify_array['email']) ){
		$email = $notify_array['email'];
	}

	$sitename = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	if( isset($notify_array['sitename']) ){
		$sitename = $notify_array['sitename'];
	}

	$loginurl = wp_login_url();
	if( isset($notify_array['loginurl']) ){
		$loginurl = $notify_array['loginurl'];
	}

	$array_mail_content 		= array('%name%', '%username%', '%password%', '%email%', '%sitename%', '%loginurl%');
	$array_mail_content_convert = array($name, 	  $username, 	$password, 	  $email,    $sitename,    $loginurl);
	$content = str_replace($array_mail_content, $array_mail_content_convert, $content);
	$subject = str_replace($array_mail_content, $array_mail_content_convert, $subject);

	$mail_content = wpautop(stripslashes($content));
	$array_data_mail = array(
		'to' => $email,
		'subject' => $subject,
		'from' => $sitename,
		'message' => $mail_content,
	);
	md_wp_mail($array_data_mail);
}
/**
 * array_data['to']
 * array_data['subject']
 * array_data['from']
 * array_data['message']
 * array_data['headers']
 * */
function md_wp_mail($array_data = array()){
	require_once( ABSPATH . 'wp-includes/pluggable.php' );

	$from = $array_data['from'];
	$to = $array_data['to'];
	$message = $array_data['message'];
	$subject = $array_data['subject'];
	$array_data['headers'][] = 'From: '.$from.' <'.mwp_get_email().'>' . "\r\n";
	$array_data['headers'][] = 'CC: Admin <' . mwp_get_email().'>' . "\r\n";
	$array_data['headers'][] = 'Content-Type: text/html; charset=UTF-8';
	wp_mail(
		$to,
		$subject,
		$message,
		$array_data['headers']
	);
}
function mwp_wp_get_current_user(){
	return Mwp_User::get_instance()->wp_get_current_user();
}
