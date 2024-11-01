<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Handle logic for fetching agent details
 * */
class Mwp_Agent_Entity{

	protected static $instance = null;

	public function __construct(){

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

	/**
	 * Bind a Property taken from API to this object
	 */
	public function bind( $property )
	{
		foreach( get_object_vars( $property )  as $k => $v ){
			$this->$k = $v;
		}
		return $this;
	}

	public function hasProperty( $name ) {
        return array_key_exists( $name, get_object_vars( $this ) );
    }

	public function displayAgentPhoto( $size = 'small' ){
		return ($size == 'small') ?
					(is_null($this->contact_photo_url)) ? $this->photo_url:$this->contact_photo_url
						: $this->photo_url;
	}

	public function get_name(){
		$first_name = '';
		if( isset($this->first_name) ){
			$first_name = $this->first_name;
		}elseif( isset($this->manager_first_name) ){
			$first_name = $this->manager_first_name;
		}
		$last_name = '';
		if( isset($this->last_name) ){
			$last_name = $this->last_name;
		}elseif( isset($this->manager_last_name) ){
			$last_name = $this->manager_last_name;
		}
		return $first_name.' '.$last_name;
	}

	public function get_company(){
		if( isset($this->company) ){
			return $this->company;
		}elseif( isset($this->contact_company) ){
			return $this->contact_company;
		}
	}

	public function get_website(){
		if( isset($this->contact_website) ){
			return $this->contact_website;
		}elseif( isset($this->website) ){
			return $this->website;
		}
	}

	public function get_email(){
		if( isset($this->email) ){
			return $this->email;
		}elseif( isset($this->manager_email) ){
			return $this->manager_email;
		}
	}

	public function get_mobile_num(){
		if( isset($this->contact_mobile) ){
			return $this->contact_mobile;
		}elseif( isset($this->mobile_phone) ){
			return $this->mobile_phone;
		}
	}

	public function get_phone(){
		if( isset($this->contact_phone) ){
			return $this->contact_phone;
		}elseif( isset($this->work_phone) ){
			return $this->work_phone;
		}
	}

	public function get_photo(){
		if( isset($this->photo_url) && $this->photo_url != '' ){
			return $this->photo_url;
		}elseif( isset($this->personal_photo) ){
			return $this->personal_photo;
		}elseif( isset($this->company_logo) ){
			return $this->company_logo;
		}
		return mwp_asset_url() . 'agent-blank.jpg';
	}

	public function get_fb(){
		return $this->facebook;
	}

	public function get_twitter(){
		return $this->twitter;
	}

	public function get_linkedin(){
		return $this->linkedin;
	}

	public function get_youtube(){
		return $this->youtube;
	}
	
	public function has_social_url(){
		$has_social_url = true;
		$count_social = 0;

		if( trim($this->get_fb()) == '' ){
			$count_social++;
		}
		if( trim($this->get_twitter()) == '' ){
			$count_social++;
		}
		if( trim($this->get_linkedin()) == '' ){
			$count_social++;
		}
		if( trim($this->get_youtube()) == '' ){
			$count_social++;
		}
		
		if( $count_social >= 4 ){
			$has_social_url = false;
		}

		return $has_social_url;
	}
}
