<?php
class Mwp_Flexmls_Adapter{
	public $client;
	public $key;
	public $secret;
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
	 * Setup for new client connection credentials
	 * - needed for such cases that we need not use the default config credential
	 *
	 * @param string $key
	 * @param string $token
	 * @param string $endpoint
	 */
	public function setCredentials( $key , $secret)
	{
		$this->key 		= $key;
		$this->secret 	= $secret;

		return $this;
	}

	/**
	 * connect to the api
	 * @return	object
	 * */
	public function connect(){
		$this->client = new SparkAPI_APIAuth($this->key, $this->secret);
		$this->client->SetApplicationName("masterdigm-flexmls");

		if( $this->client->authenticate() === false ){
			echo "API Error Code: {$this->client->last_error_code}<br>\n";
			echo "API Error Message: {$this->client->last_error_mess}<br>\n";
			return false;
		}
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
		return $this->get_client()->Authenticate();
	}

	public function get_system_info(){
		return $this->get_client()->GetSystemInfo();
	}

	public function listings($array_arg = array()){
		return $this->get_client()->GetListings($array_arg);
	}

	public function get_property_type(){
		return $this->get_client()->GetPropertyTypes();
	}

	public function get_standard_field_list($field = ''){
		return $this->get_client()->GetStandardFieldList($field);
	}

	public function get_cities(){
		return $this->get_standard_field_list('City');
	}

	public function get_standard_fields(){
		return $this->get_client()->GetStandardFields();
	}

	public function __construct(){
		/**
		 * get the api credentials
		 * @see /config.php
		 * */
		$this->key 		= mwp_flexmls_key();
		$this->secret 	= mwp_flexmls_secret();
	}
}
