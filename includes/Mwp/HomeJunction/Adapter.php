<?php
/*homejunction*/
class Mwp_HomeJunction_Adapter{
	public $client;
	public $key;
	protected static $instance = null;

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
	 * connect to the api
	 * @return	object
	 * */
	public function connect(){
		$endpoint = mwp_config_homejunction_endpoint();
		$key	  = mwp_get_crm_key();
		$token	  = mwp_get_crm_token();
		$this->client = new Mwp_API_HomeJunction($key, $token, $endpoint);
	}

	/**
	 * get client return
	 * @see connect() method
	 * */
	public function get_client(){
		$this->connect();
		return $this->client;
	}

	public function authenticate(){
		//http://wdjindustries.com/dev/slipstream/test.php?s=custom&request=checkaccount
		return $this->get_client()->customRequest('checkaccount');
	}

	public function listings($array_arg = array()){
		return $this->get_client()->getListings($array_arg);
	}

	public function listing_by_id($array_arg = array()){
		return $this->get_client()->getListingById($array_arg);
	}

	public function get_property_type(){
		return $this->get_client()->customRequest('getpropertytypes');
	}

	public function get_locations($term = ''){
		$data = array();
		$data['keyword'] = $term;
		return $this->get_client()->getMatchedAddress($data);
	}

	public function __construct(){
		$this->connect();
	}
}
