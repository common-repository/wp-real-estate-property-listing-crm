<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm MLS Adapter
 *
 * Instantiate and use the API/CRM.php
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_MLS_Adapter{
	protected static $instance = null;
	protected $client;
	protected $key;
	protected $token;
	protected $endpoint;
	protected $version;
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
	public function setCredentials( $key , $token , $endpoint, $version)
	{
		$this->key 		= $key;
		$this->token 	= $token;
		$this->endpoint = $endpoint;
		$this->version 	= $version;
		return $this;
	}

	public function get_key(){
		return $this->key;
	}

	public function get_token(){
		return $this->token;
	}

	public function get_endpoint(){
		return $this->endpoint;
	}

	public function get_version(){
		return $this->version;
	}

	/**
	 * get single / full details of property, singular
	 * @var		$property_id		int		get the unique ID
	 * @var		$broker_id			int		default is null, if null will grab the broker id via api credentials
	 * @return	array object
	 * */
	public function get_property($property_id, $broker_id = null){
		return $this->get_client()->getPropertyByMatrixID($property_id, $broker_id);
	}

	/**
	 * get all properties base on search data.
	 * @var		$search_data	array	default is null
	 * @return	array	object
	 * */
	public function get_properties($search_data = null){
		return $this->get_client()->getProperties($search_data);
	}
	
	public function add_property_alert($data = array()){
		return $this->get_client()->addPropertyAlert($data);
	}
	
	/**
	 * get the marketing coverage lookup, mostly locations
	 * */
	public function get_coverage_lookup($location = null){
		return $this->get_client()->getCoverageLookup($location);
	}
	
	public function get_cities_by_mls($mls = array()){
		return $this->get_client()->getCitiesByMls($mls);
	}

	public function get_communities_by_city_id($city_id){
		return $this->get_client()->getCommunitiesByCityId($city_id);
	}

	public function get_property_types(){
		return $this->get_client()->getPropertyTypes();
	}

	public function get_photos_by_matrixID($matrix_id){
		return $this->get_client()->getPhotosByMatrixID($matrix_id);
	}

	public function get_photos_object_by_matrix_id($matrix_id){
		return $this->get_client()->getPhotosObjectByMatrixID($matrix_id);
	}
	
	public function set_client($arg = null){
		$mls_config = mwp_mls_config();
		/**
		* get the api credentials
		* @see /config.php
		* */
		$this->key 		= mwp_get_crm_key();
		$this->token 	= mwp_get_crm_token();
		$this->endpoint = $mls_config['api_endpoint'];
		$this->version  = $mls_config['api_version'];
		
		$key = $this->key;
		if( isset($arg['key']) ){
			$key = $arg['key'];
		}
		$token = $this->token;
		if( isset($arg['token']) ){
			$token = $arg['token'];
		}
		$endpoint = $this->endpoint;
		if( isset($arg['endpoint']) ){
			$endpoint = $arg['endpoint'];
		}
		$version = $this->version;
		if( isset($arg['version']) ){
			$version = $arg['version'];
		}
		$this->client = new Mwp_API_MLS( $key, $token, $endpoint , $version );
	}

	public function get_client(){
		return $this->client;
	}
	
	public function __construct($arg = null){
		$this->set_client($arg);
	}
}
