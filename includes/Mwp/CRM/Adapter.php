<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm CRM Adapter
 *
 * Instantiate and use the API/CRM.php
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_CRM_Adapter{
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
	 * for testing purposes only
	 * */
	public function test_connection(){
		return $this->get_client()->testConnection();
	}

	public function set_account_Id($account_id){
		return $this->get_client()->setAccountId($account_id);
	}

	public function set_source_Id($source_id){
		$this->get_client()->setSourceId($source_id);
	}

	/**
	 * get single / full details of property, singular
	 * @var		$property_id		int		get the unique ID
	 * @var		$broker_id			int		default is null, if null will grab the broker id via api credentials
	 * @return	array object
	 * */
	public function get_property($property_id, $broker_id = null){
		return $this->get_client()->getPropertyById($property_id, $broker_id);
	}

	/**
	 * get all properties base on search data.
	 * @var		$search_data	array	default is null
	 * @return	array	object
	 * */
	public function get_properties($search_data = null){
		return $this->get_client()->getProperties($search_data);
	}

	public function get_location($location = null){
		return $this->get_client()->getCoverageLookup($location);
	}

	/**
	 * get the current account details of the current CRM key
	 * */
	public function get_account_details(){
		return $this->get_client()->getAccountDetails();
	}

	/**
	 * @param	$user_id	int		get the userid in the get_account_details()
	 * @paran	$array_location		default array, else list of location id
	 * 								acceptable data are:
	 * 								cityid and communityid both are array base
	 * 								example:
	 * 								array(
	 *									'cityid'=>array( 1707 , 1421 ),
	 *									'communityid' => array( 13 )
	 *								)
	 * @return	array object
	 * */
	public function get_featured_properties($user_id = null, $array_location_id = array(), $other_data = array()){
		return $this->get_client()->getFeaturedProperties($user_id, $array_location_id, $other_data);
	}

	/**
	 * get the marketing coverage lookup, mostly locations
	 * */
	public function get_coverage_lookup($location = null){
		return $this->get_client()->getCoverageLookup($location);
	}
	
	public function get_fields($data = array()){
		return $this->get_client()->getFields($data);
	}

	public function get_account_coverage(){
		return $this->get_client()->getAccountCoverage();
	}

	public function get_cities_by_stateId($state_id){
		return $this->get_client()->getCitiesByStateid($state_id);
	}

	public function get_communities_by_cityId($city_id){
		return $this->get_client()->getCommunitiesByCityId($city_id);
	}

	public function get_states_by_countryId($country_id){
		return $this->get_client()->getStatesByCountryId($country_id);
	}

	public function get_photos_by_propertyId($property_id){
		return $this->get_client()->getPhotosByPropertyId($property_id);
	}

	public function save_lead($data){
		return $this->get_client()->saveLead($data);
	}

	public function get_agent_details($data){
		return $this->get_client()->getAgentDetails($data);
	}
	
	public function set_client($arg = null){
		$mwp_crm = new Mwp_CRM_Model;
		/**
		* get the api credentials
		* @see /config.php
		* */
		$this->key 		= mwp_get_crm_key();
		$this->token 	= mwp_get_crm_token();
		$this->endpoint = mwp_crm_api_endpoint();
		$this->version  = mwp_crm_api_version();
		
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
		$this->client = new Mwp_API_CRM( $key, $token, $endpoint , $version );
	}

	public function get_client(){
		return $this->client;
	}
	
	public function __construct($arg = null){
		$this->set_client($arg);
	}
}
