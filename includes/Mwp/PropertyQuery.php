<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
abstract class Mwp_PropertyQuery{
	/**
	 * array of variables
	 * */
	public $query;
	/**
	 * holder of the query
	 * */
	public $query_vars;
	/**
	 * holder of search query data
	 * */
	public $search_query_vars = array();
	/**
	 * check if search query is not empty
	 * */
	public $has_search_query = false;
	/**
	 * holder of search query map boundaries
	 * */
	public $search_query_map_boundaries_data = array();
	/**
	 * check if there is a query map boundaries
	 * */
	public $has_search_query_map_boundaries = false;
	/**
	 * check if we need to geocode service to get map boundaries
	 * */
	public $is_geocode_map_boundaries = false;
	/**
	 * default is zero, use location search must be set to 1 if there is
	 * search query map boundaries or if want to use map boundaries
	 * */
	public $use_location_search = 0;
	/**
	 * check if use search location
	 * */
	public $is_use_location_search = false;
	/**
	 * check if search query has an address
	 * */
	public $has_search_query_address = false;
	/**
	 * holder of search query address location
	 * */
	public $search_query_address_data;
	/**
	 * check if search query has subdivision
	 * */
	public $has_search_query_subdivision = false;
	/**
	 * subdivision id default to zero
	 * */
	public $search_query_subdivision_id_data = 0;
	/**
	 * check if search query has city
	 * */
	public $has_search_query_city = false;
	/**
	 * subdivision id default to zero
	 * */
	public $search_query_city_id_data = 0;
	/**
	 * check if search query has community
	 * */
	public $has_search_query_community = false;
	/**
	 * community id default to zero
	 * */
	public $search_query_community_id_data = 0;
	/**
	 * check if search query has country
	 * */
	public $has_search_query_country = false;
	/**
	 * country id default to zero
	 * */
	public $search_query_country_id_data = 0;
	/**
	 * check if search query has county
	 * */
	public $has_search_query_county = false;
	/**
	 * county id default to zero
	 * */
	public $search_query_county_id_data = 0;
	/**
	 * check if search query has zip
	 * */
	public $has_search_query_zip = false;
	/**
	 * zip id default to zero
	 * */
	public $search_query_zip_data = 0;
	/**
	 * check if search query has state
	 * */
	public $has_search_query_state = false;
	/**
	 * state id default to zero
	 * */
	public $search_query_state_id_data = 0;
	/**
	 * check if search query has lat
	 * */
	public $has_search_query_lat = false;
	/**
	 * lat default to zero
	 * */
	public $search_query_lat_data = 0;
	/**
	 * check if search query has lng
	 * */
	public $has_search_query_lng = false;
	/**
	 * lng default to zero
	 * */
	public $search_query_lng_data = 0;
	/**
	 * check if search query has bath
	 * */
	public $has_search_query_bath = false;
	/**
	 * bath default to zero
	 * */
	public $search_query_bath_data = 0;
	/**
	 * check if search query has bed
	 * */
	public $has_search_query_bed = false;
	/**
	 * bed default to zero
	 * */
	public $search_query_bed_data = 0;
	/**
	 * check if search query has max_listprice
	 * */
	public $has_search_query_max_listprice = false;
	/**
	 * max_listprice default to zero
	 * */
	public $search_query_max_listprice_data = 0;
	/**
	 * check if search query has min_listprice
	 * */
	public $has_search_query_min_listprice = false;
	/**
	 * min_listprice default to zero
	 * */
	public $search_query_min_listprice_data = 0;
	/**
	 * check if search query has property_status
	 * */
	public $has_search_query_property_status = false;
	/**
	 * property_status default to zero
	 * */
	public $search_query_property_status_data = '';
	/**
	 * check if search query has property_type
	 * */
	public $has_search_query_property_type = false;
	/**
	 * property_type default to zero
	 * */
	public $search_query_property_type_data = '';
	/**
	 * check if search query has transaction
	 * */
	public $has_search_query_transaction = false;
	/**
	 * transaction default to zero
	 * */
	public $search_query_transaction_data = '';
	/**
	 * check if search query has orderby
	 * */
	public $has_search_query_orderby = false;
	/**
	 * orderby default to blank
	 * */
	public $search_query_orderby_data = '';
	/**
	 * check if search query has limit
	 * */
	public $has_search_query_limit = false;
	/**
	 * limit default to zero
	 * */
	public $search_query_limit_data = 0;
	/**
	 * check if search query has paged
	 * */
	public $has_search_query_paged = false;
	/**
	 * paged default to 1
	 * */
	public $search_query_paged_data = 1;
	/**
	 * if variabel query is empty then we get properties by default search query
	 * */
	public $is_fetch_all = false;
	/**
	 * check if were on the single property page
	 * */
	public $is_single_property = false;
	/**
	 * holder of the properties data result from api
	 * */
	public $property_data = array();
	public $property_data_total = 0;
	public $property_data_count = 0;
	public $property_source = '';
	/**
	 * property details
	 * */
	public $has_property_details_data 	= false;
	public $property_details_data 		= null;
	public $request_property_details 	= false;

	public $property_details_image_data		= null;
	public $has_property_details_image 		= false;
	public $request_property_details_image 	= false;

	/**
	 *
	 * */
	public $property_details_agent 			= null;
	/**
	 * property id - single property
	 * */
	public $request_property_id 	= false;
	public $property_id_query_var	= null;
	public $property_id_data 		= array();
	public $property_id_raw_data 	= array();
	public $has_property_id 		= false;
	/**
	 * raw result of method getProperties
	 * */
	public $get_raw_property_api_data = null;
	/**
	 * get the property data images
	 * */
	public $property_img = array();
	public $has_property = false;
	/**
	 * this will tell if the request is from shortcode
	 * */
	public $is_from_shortcode = false;
	/**
	* property index in loop
	* default value is -1 means the loop haven't started
	* */
	public $current_property_index = -1;
	/**
	 * check if the event is inside the loop
	 * */
	public $in_the_property_loop = false;
	public function reset_var(){
		$this->query_vars 			= '';
		$this->is_get_all 			= false;
		$this->has_search_query 	= false;
		$this->search_query_vars 	= array();
		$this->is_fetch_all 		= false;
		$this->property_data 		= array();
		$this->property_img 		= array();
		$this->search_query_map_boundaries_data = array();
		$this->has_search_query_map_boundaries = false;
		$this->is_geocode_map_boundaries = false;
		$this->use_location_search = 0;
		$this->is_use_location_search = false;
		$this->has_search_query_address = false;
		$this->search_query_address_data = '';
		$this->has_search_query_subdivision = false;
		$this->search_query_subdivision_id_data = 0;
		$this->has_search_query_city = false;
		$this->search_query_city_id_data = 0;
		$this->has_search_query_community = false;
		$this->search_query_community_id_data = 0;
		$this->has_search_query_country = false;
		$this->search_query_country_id_data = 0;
		$this->has_search_query_county = false;
		$this->search_query_county_id_data = 0;
		$this->has_search_query_zip = false;
		$this->search_query_zip_data = 0;
		$this->has_search_query_state = false;
		$this->search_query_state_id_data = 0;
		$this->has_search_query_lat = false;
		$this->search_query_lat_data = 0;
		$this->has_search_query_lng = false;
		$this->has_search_query_bath = false;
		$this->search_query_bath_data = 0;
		$this->has_search_query_bed = false;
		$this->search_query_bed_data = 0;
		$this->has_search_query_max_listprice = false;
		$this->search_query_max_listprice_data = 0;
		$this->has_search_query_min_listprice = false;
		$this->search_query_min_listprice_data = 0;
		$this->has_search_query_property_status = false;
		$this->search_query_property_status_data = '';
		$this->has_search_query_property_type = false;
		$this->search_query_property_type_data = '';
		$this->has_search_query_transaction = false;
		$this->search_query_transaction_data = '';
		$this->has_search_query_orderby = false;
		$this->search_query_orderby_data = '';
		$this->has_search_query_limit = false;
		$this->search_query_limit_data = 0;
		$this->has_search_query_paged = false;
		$this->search_query_paged_data = 1;
		$this->is_fetch_all = false;
		$this->property_data = array();
		$this->property_data_total = 0;
		$this->property_data_count = 0;
		$this->property_source = '';
		$this->has_property_details_data 	= false;
		$this->property_details_data 		= null;
		$this->request_property_details 	= false;
		$this->property_details_image_data 		= null;
		$this->has_property_details_image 	= false;
		$this->request_property_details_image 	= false;
		$this->request_property_id 	= false;
		$this->property_id_data 	= array();
		$this->has_property_id 		= false;
		$this->get_raw_property_api_data = array();
		$this->property_img = array();
		$this->has_property = false;
		$this->is_from_shortcode = false;
		$this->current_property_index = -1;
		$this->in_the_property_loop = false;
	}
	public function is_geocode_map_boundaries(){
		return $this->is_geocode_map_boundaries;
	}
	//geocode address
	public function geocode_address($address){
		return Mwp_Helpers_Gmap::geocode($address);
	}
	//map boundaries
	public function has_search_query_map_boundaries(){
		return $this->has_search_query_map_boundaries;
	}

	public function search_query_map_boundaries($data){
		$map_boundaries_data =  array();
		if(
			isset($data['map_boundaries'])
			&& is_array($data['map_boundaries'])
			&& count($data['map_boundaries'])  > 0
			&& !$this->is_geocode_map_boundaries()
		){
			$map_boundaries_data = $data['map_boundaries'];
			$this->has_search_query_map_boundaries = true;
		}

		if(
			$this->is_geocode_map_boundaries()
			&& $this->has_search_query_address()
		){
			$this->has_search_query_map_boundaries = true;
			$geocode = $this->geocode_address($this->search_query_address);
			$boundaries = array(
				'ne_lat' => 0,
				'ne_lng' => 0,
				'sw_lat' => 0,
				'sw_lng' => 0
			);
			$geocode_array = $geocode['results'][0]['geometry']['viewport'];
			$boundaries = array(
				'ne_lat' => $geocode_array['northeast']['lat'],
				'ne_lng' => $geocode_array['northeast']['lng'],
				'sw_lat' => $geocode_array['southwest']['lat'],
				'sw_lng' => $geocode_array['southwest']['lng']
			);
			$map_boundaries_data = $boundaries;
		}
		$this->search_query_map_boundaries_data = $map_boundaries_data;
		return $map_boundaries_data;
	}
	//map boundaries
	//address
	public function has_search_query_address(){
		return $this->has_search_query_address;
	}

	public function search_query_address($location){
		if(
			$location != ''
			&& !empty($location)
		){
			$location;
			$this->has_search_query_address = true;
			$this->search_query_address_data = $location;
			$address = $location;
			return $address;
		}
		return '';
	}
	//address

	//use location search
	public function search_query_use_location_search($data = ''){
		if( $this->has_search_query_map_boundaries() ){
			return 1;
		}
		return 0;
	}

	public function is_use_location_search(){
		return $this->is_use_location_search;
	}
	//use location search

	//subdivision
	public function search_query_subdivision_id($subdivision_id){
		if(
			isset($subdivision_id)
			&& !empty($subdivision_id)
		){
			$this->has_search_query_subdivision = true;
			$this->search_query_subdivision_id_data = $subdivision_id;
			return $subdivision_id;
		}
		return 0;
	}
	public function has_search_query_subdivision(){
		return $this->has_search_query_subdivision;
	}
	//subdivision

	//cityid
	public function search_query_city_id($city_id){
		if(
			isset($city_id)
			&& !empty($city_id)
		){
			$this->has_search_query_city = true;
			$this->search_query_city_id_data = $city_id;
			return $city_id;
		}
		return 0;
	}
	public function has_search_query_city(){
		return $this->has_search_query_city;
	}
	//cityid

	//community id
	public function search_query_community_id($community_id){
		if(
			isset($community_id)
			&& !empty($community_id)
		){
			$this->has_search_query_community = true;
			$this->search_query_community_id_data = $community_id;
			return $community_id;
		}
		return 0;
	}
	public function has_search_query_community(){
		return $this->has_search_query_community;
	}
	//community id

	//country id
	public function search_query_country_id($country_id){
		if(
			isset($country_id)
			&& !empty($country_id)
		){
			$this->has_search_query_country = true;
			$this->search_query_country_id_data = $country_id;
			return $country_id;
		}
		return 0;
	}
	public function has_search_query_country(){
		return $this->has_search_query_country;
	}
	//country id

	//county id
	public function search_query_county_id($county_id){
		if(
			isset($county_id)
			&& !empty($county_id)
		){
			$this->has_search_query_county = true;
			$this->search_query_county_id_data = $county_id;
			return $county_id;
		}
		return 0;
	}
	public function has_search_query_county(){
		return $this->has_search_query_county;
	}
	//county id

	//state id
	public function search_query_state_id($state_id){
		if(
			isset($state_id)
			&& !empty($state_id)
		){
			$this->has_search_query_state = true;
			$this->search_query_state_id_data = $state_id;
			return $state_id;
		}
		return 0;
	}
	public function has_search_query_state(){
		return $this->has_search_query_state;
	}
	//country id

	//zip id
	public function search_query_zip($zip){
		if(
			isset($zip)
			&& !empty($zip)
		){
			$this->has_search_query_zip = true;
			$this->search_query_zip_data = $zip;
			return $zip;
		}
		return 0;
	}
	public function has_search_query_zip(){
		return $this->has_search_query_zip;
	}
	//zip id

	//lat
	public function search_query_lat($lat){
		if(
			isset($lat)
			&& !empty($lat)
		){
			$this->has_search_query_lat = true;
			$this->search_query_lat_data = $lat;
			return $lat;
		}
		return 0;
	}
	public function has_search_query_lat(){
		return $this->has_search_query_lat;
	}
	//lat

	//lng
	public function search_query_lng($lng){
		if(
			isset($lng)
			&& !empty($lng)
		){
			$this->has_search_query_lng = true;
			$this->search_query_lng_data = $lng;
			return $lng;
		}
		return 0;
	}
	public function has_search_query_lng(){
		return $this->has_search_query_lng;
	}
	//lat

	//bath
	public function search_query_bath($bath){
		if(
			isset($bath)
			&& !empty($bath)
		){
			$this->has_search_query_bath = true;
			$this->search_query_bath_data = $bath;
			return $bath;
		}
		return 0;
	}
	public function has_search_query_bath(){
		return $this->has_search_query_bath;
	}
	//bath

	//bed
	public function search_query_bed($bed){
		if(
			isset($bed)
			&& !empty($bed)
		){
			$this->has_search_query_bed = true;
			$this->search_query_bed_data = $bed;
			return $bed;
		}
		return 0;
	}
	public function has_search_query_bed(){
		return $this->has_search_query_bed;
	}
	//bath

	//min_listprice
	public function search_query_min_listprice($min_listprice){
		if(
			isset($min_listprice)
			&& !empty($min_listprice)
		){
			$this->has_search_query_min_listprice = true;
			$this->search_query_min_listprice_data = $min_listprice;
			return $min_listprice;
		}
		return 0;
	}
	public function has_search_query_min_listprice(){
		return $this->has_search_query_min_listprice;
	}
	//min_listprice

	//max_listprice
	public function search_query_max_listprice($max_listprice){
		if(
			isset($max_listprice)
			&& !empty($max_listprice)
		){
			$this->has_search_query_max_listprice = true;
			$this->search_query_max_listprice_data = $max_listprice;
			return $max_listprice;
		}
		return 0;
	}
	public function has_search_query_max_listprice(){
		return $this->has_search_query_max_listprice;
	}
	//max_listprice

	//property_status
	public function search_query_property_status($property_status){
		$search_status 			= '';
		$default_search_status 	= Mwp_Settings_Search_General_DBEntity::get_instance()->get_search_property_status();
		if(
			isset($property_status)
			&& !empty($property_status)
		){
			$this->has_search_query_property_status = true;
			$search_status = $property_status;
		}else{
			$search_status = $default_search_status;
		}
		$this->has_search_query_property_status = true;
		$this->search_query_property_status_data = $search_status;
		return $this->search_query_property_status_data;
	}
	public function has_search_query_property_status(){
		return $this->has_search_query_property_status;
	}
	//property_status

	//property_type
	public function search_query_property_type($property_type){
		if(
			isset($property_type)
			&& !empty($property_type)
		){
			$this->has_search_query_property_type = true;
			$this->search_query_property_type_data = $property_type;
			return $property_type;
		}
		return 0;
	}
	public function has_search_query_property_type(){
		return $this->has_search_query_property_type;
	}
	//property_type

	//search_query_transaction
	public function search_query_transaction($transaction){
		if(
			isset($transaction)
			&& !empty($transaction)
		){
			$this->has_search_query_transaction 	= true;
			$this->search_query_transaction_data 	= $transaction;
		}
		return $this->search_query_transaction_data;
	}
	public function has_search_query_transaction(){
		return $this->has_search_query_transaction;
	}
	//search_query_transaction

	//orderby
	public function search_query_orderby($orderby){
		if(
			isset($orderby)
			&& !empty($orderby)
		){
			$this->has_search_query_orderby = true;
			$this->search_query_orderby_data = $orderby;
			return $orderby;
		}
		return '';
	}
	public function has_search_query_orderby(){
		return $this->has_search_query_orderby;
	}
	//orderby

	//order_direction
	public function search_query_order_direction($order_direction){
		if(
			isset($order_direction)
			&& !empty($order_direction)
		){
			$this->has_search_query_order_direction = true;
			$this->search_query_order_direction_data = $order_direction;
			return $order_direction;
		}
		return '';
	}
	public function has_search_query_order_direction(){
		return $this->has_search_query_order_direction;
	}
	//orderby

	//limit
	public function search_query_limit($limit = null){
		global $mwp;
		$this->search_query_limit_data = $mwp['pagination']['limit'];
		if(
			!is_null($limit)
		){
			$this->search_query_limit_data = $limit;
		}

		$this->has_search_query_limit = true;
		return $this->search_query_limit_data;
	}
	public function has_search_query_limit(){
		return $this->has_search_query_limit;
	}
	//limit

	//paged
	public function search_query_paged($paged){
		if(
			isset($paged)
			&& !empty($paged)
		){
			$this->search_query_paged_data = $paged;
		}
		$this->has_search_query_paged = true;
		return $this->search_query_paged_data;
	}
	public function has_search_query_paged(){
		return $this->has_search_query_paged;
	}
	//paged
	
	public function show_pagination(){
		if( $this->has_search_query && isset($this->query_vars['search_keyword']['pagination']) ){
			return $this->query_vars['search_keyword']['pagination'];
		}
		return false;
	}
	
	public function has_search_query(){
		return $this->has_search_query;
	}

	public function is_fetch_all(){
		return $this->is_fetch_all;
	}

	public function query_vars(){
		return $this->query_vars;
	}

	public function parse_query($query = ''){
		$this->query_vars = $query;
		if(
			( isset($this->query_vars['get_properties'])
			&& $this->query_vars['get_properties'] )
		){
			//get all
			$this->is_fetch_all = true;
		}

		if(
			isset($this->query_vars['geocode_map_boundaries'])
			&& $this->query_vars['geocode_map_boundaries'] == true
		){
			$this->is_geocode_map_boundaries = true;
		}

		//check if its single
		if(
			isset($this->query_vars['property_id'])
			&& !empty($this->query_vars['property_id'])
		){
			$this->request_property_id = true;
			if( !is_array($this->query_vars['property_id']) ){
				$this->property_id_query_var[] = $this->query_vars['property_id'];
			}else{
				$this->property_id_query_var = $this->query_vars['property_id'];
			}
		}

		if(
			isset($this->query_vars['property_single_photo'])
			&& $this->query_vars['property_single_photo'] == 1
		){
			$this->request_property_details_image = true;
		}

		if(
			isset($this->query_vars['property_details'])
			&& $this->query_vars['property_details']
		){
			$this->request_property_details = true;
		}

		//default search query
		
		//default search query

		if(
			isset($this->query_vars['search_keyword'])
			&& is_array($this->query_vars['search_keyword'])
			&& !empty($this->query_vars['search_keyword'])
		){
			$search_query = $this->query_vars['search_keyword'];
			$this->has_search_query = true;
			$this->search_query($search_query);
		}

	}

	public function request_property_details_image(){
		return $this->request_property_details_image;
	}

	public function property_details_image_data(){
		return $this->property_details_image_data;
	}

	public function get_property_data(){
		return $this->property_data;
	}
	public function get_data(){
		$current_index = ($this->get_current_property_index() - 1);
		$data = $this->get_property_data();
		if(
			isset($data[$current_index])
		){
			return $data[$current_index];
		}
	}
	public function rewind_property_index(){
		$this->current_property_index = -1;
	}
	public function get_current_property_index(){
		return $this->current_property_index;
	}
	public function next_property_index(){
		return $this->current_property_index++;
	}
	public function md_set_property(){
		$this->in_the_property_loop = true;
		$this->properties = $this->get_property_data();
	}
	public function loop_property(){
		$current_property_count_total = $this->property_data_count;
		if( $this->has_property() ){
			if( ($this->next_property_index() + 0) < $current_property_count_total ){
				return true;
			}elseif( ($this->next_property_index() + 1) == $current_property_count_total ){
				$this->rewind_property();
			}
			$this->in_the_property_loop = false;
		}
		return false;
	}
	abstract public function has_property();
	abstract public function query();
}
