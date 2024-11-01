<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Popup Model
 * */
class Mwp_Admin_Settings_Mail_DBEntity {
	protected static $instance = null;
	protected $model_mail = null;
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

	public function default_mail_settings_data(){
		$this->put_default_subject();
		$this->put_default_content();
	}
	
	public function get_email(){
		return $this->model_mail->email('r', mwp_conf_email());
	}

	public function put_default_subject(){
		/**
		 * check mail content if in the database
		 * if not get the default content
		 * and save it
		 * */
		if( !$this->model_mail->subject('r') ){
			$subject = $this->admin_entity_mail->default_subject();
			$this->model_mail->subject('u', $subject);
		}
	}

	public function put_default_content(){
		/**
		 * check mail content if in the database
		 * if not get the default content
		 * and save it
		 * */
		if( !$this->model_mail->content('r') ){
			$content = $this->admin_entity_mail->default_content();
			$this->model_mail->content('u', $content);
		}
	}

	public function db_update_mail($input = array()){
		$subject = sanitize_text_field( $input['subject'] );
		$content = $input['md_mail_content'];
		$mail_server = $input['mail_server'];

		$this->model_mail->subject('u', $subject);
		$this->model_mail->content('u', $content);
		$this->model_mail->email('u', $mail_server);
	}


	public function delete_all(){
		$this->model_mail->content('d');
		$this->model_mail->subject('d');
		$this->model_mail->email('d');
	}

	public function __construct(){
		$this->model_mail = new Mwp_Settings_Mail_Model;
		$this->admin_entity_mail = new Mwp_Admin_Settings_Mail_Entity;
	}

}
