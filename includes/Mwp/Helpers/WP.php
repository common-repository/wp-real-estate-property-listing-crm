<?php
class Mwp_Helpers_WP {
	public function __construct(){
        add_action( 'plugins_loaded', array( $this, 'check_if_user_logged_in' ) );
    }
    public function check_if_user_logged_in(){
        return is_user_logged_in();
    }
} // End WP
