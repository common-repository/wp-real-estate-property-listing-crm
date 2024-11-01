<?php
class Mwp_Actions_ShowPopup {
	protected static $instance = null;
	protected $settings_popup_db;
	protected $mwp_cookie;
	
	public function __construct(){
		$this->settings_popup_db = new Mwp_Settings_Popup_DBEntity;
		$this->mwp_cookie = new Mwp_Helpers_Cookie;
	}

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
	
	public function mwp_cookie(){}
	
	public function display_popup(){
		$cookie = $this->mwp_cookie;
		if(
			!$cookie->wp_cookie_is_user_logged() 
			&& mwp_manual_is_property_details_page()
		){
			if(
				$this->settings_popup_db->get_popup_show() == 1
				&& $cookie->get('guest_page_view') >= $this->settings_popup_db->get_popup_clicks()
			){
				return true;
			}
		}
		return false;
	}

	public function display(){
		if( $this->display_popup() ){
		}
	}
	public function deleteShowPopup(){
		$cookie = $this->mwp_cookie;
		$cookie->delete('guest_page_view');
	}

	public function is_popup_reg_form(){
		if($this->display_popup()){
			?>
			<script>
				var popup_reg_form = 1;
			</script>
			<?php
		}
	}

	public function showPopup(){
		if($this->display_popup()){
			?>
			<script>
				jQuery(document).ready(function(){
					jQuery('.register-modal').on('shown.bs.modal', function () {
					   jQuery('.modal-backdrop').addClass('blur');
					});
					jQuery('.register-modal').modal({
						backdrop: 'static',
						keyboard: false
					});
				});
			</script>
			<?php
		}
	}
}
