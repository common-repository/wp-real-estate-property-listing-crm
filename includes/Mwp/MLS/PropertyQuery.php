<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get MLS property , list or single
 * */
class Mwp_MLS_PropertyQuery extends Mwp_PropertyQuery{
	protected static $instance = null;
	public $has_search_query_listing_office_id 	= false;
	public $search_query_listing_office_id_data = null;
	/**
	 * holder of the api mls
	 * */
	public $api_mls;
	public $property_source = 'mls';

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

	public function masterdigm_mls(){
		$this->api_mls = new Mwp_MLS_Adapter;
	}

	public function get_source(){
		return $this->property_source;
	}

	private function get_default_location(){
		$zip 		= '';
		$account 	= Mwp_CRM_AccountDetails::get_instance()->account_details();
		if( isset($account->zipcode) ){
			$zip = $account->zipcode;
		}
		return $zip;
	}

	//listing_office_id
	public function search_query_listing_office_id($listing_office_id){
		if(
			isset($listing_office_id)
			&& !empty($listing_office_id)
		){
			$this->has_search_query_listing_office_id = true;
			$this->search_query_listing_office_id_data = $listing_office_id;
			return $listing_office_id;
		}
		return 0;
	}
	public function has_search_query_listing_office_id(){
		return $this->has_search_query_listing_office_id;
	}
	//listing_office_id
	//property_status for mls
	public function search_query_mls_property_status($property_status){
		if(
			isset($property_status)
			&& !empty($property_status)
		){
			$this->has_search_query_property_status = true;
			$this->search_query_property_status_data = $property_status;
			return $property_status;
		}
		return '';
	}
	//property_status

	public function search_query($search = ''){
		$location = $this->get_default_location();
		if(
			isset($search['location'])
			&& $search['location'] != ''
		){
			$location = $this->search_query_address($search['location']);
		}

		$map_boundaries = array();
		if( isset($search['map_boundaries']) ){
			$map_boundaries = $this->search_query_map_boundaries(array('map_boundaries' => $search['map_boundaries']));
		}
		$use_location_search = 0;
		if( isset($search['use_location_search']) ){
			$use_location_search = $this->search_query_use_location_search();
		}

		$listing_office_id = '';
		if(
			isset($search['listing_office_id'])
		){
			$listing_office_id = $this->search_query_listing_office_id($search['listing_office_id']);
		}

		$cityid = '';
		if( isset($search['cityid']) ){
			$cityid = $this->search_query_city_id($search['cityid']);
		}

		$communityid = '';
		if( isset($search['communityid']) ){
			$communityid = $this->search_query_community_id($search['communityid']);
		}

		$countryid = '';
		if( isset($search['countryid']) ){
			$countryid = $this->search_query_country_id($search['countryid']);
		}

		$stateid = '';
		if( isset($search['stateid']) ){
			$stateid = $this->search_query_state_id($search['stateid']);
		}

		$countyid = '';
		if( isset($search['countyid']) ){
			$countyid = $this->search_query_county_id($search['countyid']);
		}

		$zip = '';
		if( isset($search['zip']) ){
			$zip = $this->search_query_zip($search['zip']);
		}

		$lat = '';
		if( isset($search['lat']) ){
			$lat = $this->search_query_lat($search['lat']);
		}

		$lng = '';
		if( isset($search['lng']) ){
			$lng = $this->search_query_lng($search['lng']);
		}

		$bath = '';
		if( isset($search['bathrooms']) ){
			$bath = $this->search_query_bath($search['bathrooms']);
		}

		$bed = '';
		if( isset($search['bedrooms']) ){
			$bed = $this->search_query_bed($search['bedrooms']);
		}

		$min_listprice = '';
		if( isset($search['min_listprice']) ){
			$min_listprice = $this->search_query_min_listprice($search['min_listprice']);
		}

		$max_listprice = '';
		if( isset($search['max_listprice']) ){
			$max_listprice = $this->search_query_max_listprice($search['max_listprice']);
		}

		$property_status = 'Active';
		if(
			isset($search['property_status'])
			&& $search['property_status'] != ''
		){
			$property_status = $this->search_query_mls_property_status($search['property_status']);
		}

		$property_type = '';
		if( isset($search['property_type']) ){
			$property_type = $this->search_query_property_type($search['property_type']);
			$property_type = mwp_trim_tolower($property_type);

			$property_type_account = Mwp_MLS_AccountDetails::get_instance()->get_property_type();

			if( is_array($property_type_account) && array_key_exists($property_type, $property_type_account) ){
				$property_type = $property_type_account[$property_type];
			}
		}
		
		$transaction = 'sale';
		if(
			isset($search['transaction'])
			&& $search['transaction'] != ''
		){
			$transaction = $this->search_query_transaction($search['transaction']);
		}else{
			$transaction = $this->search_query_transaction($transaction);
		}
		$ex_string = explode(' ',urldecode($transaction));
		if( count($ex_string) == 2 && isset($ex_string[1]) ){
			$transaction = strtolower($ex_string[1]);
		}else{
			if(
				$transaction &&
				$transaction != '' &&
				$transaction != 'all'
			){
				$ex_string = explode(' ',$transaction);
				if( count($ex_string) == 2 && isset($ex_string[1]) ){
					$transaction = $ex_string[1];
				}else{
					$transaction = sanitize_text_field($transaction);
				}
			}else{
				$transaction = 'sale';
			}
		}

		$orderby = 'posted_at';
		if(
			isset($search['orderby'])
			&& $search['orderby'] != ''
		){
			$orderby = $this->search_query_orderby($search['orderby']);
		}
		if( $orderby == 'posted_at' ){
			$orderby = 'TimeStampModified';
		}
		if( $orderby == 'price' ){
			$orderby = 'ListPrice';
		}

		$order_direction = 'ASC';
		if(
			isset($search['order_direction'])
			&& $search['order_direction'] != ''
		){
			$order_direction = $this->search_query_order_direction($search['order_direction']);
		}

		$limit = $this->search_query_limit();
		if(
			isset($search['limit'])
			&& $search['limit'] != ''
		){
			$limit = $this->search_query_limit($search['limit']);
		}

		$paged = '';
		if(
			isset($search['paged'])
			&& $search['paged'] != ''
		){
			$paged = $search['paged'];
		}else{
			$paged = $this->search_query_paged($paged);
		}

		$search = array(
			'mlsid'	=> '',
			'map_boundaries'		=> $map_boundaries,
			'use_location_search'	=> $use_location_search,
			'return_query'			=> 1,
			'q' 					=> sanitize_text_field($location),
			'map_boundaries'		=> $map_boundaries,
			'use_location_search' 	=> sanitize_text_field($use_location_search),
			'listing_office_id'		=> sanitize_text_field($listing_office_id),
			'cityid'				=> sanitize_text_field($cityid),
			'communityid'			=> sanitize_text_field($communityid),
			'countryid'				=> sanitize_text_field($countryid),
			'countyid'				=> sanitize_text_field($countyid),
			'stateid'				=> sanitize_text_field($stateid),
			'lat' 					=> sanitize_text_field($lat),
			'lon' 					=> sanitize_text_field($lng),
			'bathrooms' 			=> sanitize_text_field($bath),
			'bedrooms' 				=> sanitize_text_field($bed),
			'min_listprice' 		=> sanitize_text_field($min_listprice),
			'max_listprice' 		=> sanitize_text_field($max_listprice),
			'status'				=> sanitize_text_field($property_status),
			'property_type'			=> sanitize_text_field($property_type),
			'transaction'			=> sanitize_text_field($transaction),
			'orderby'				=> sanitize_text_field($orderby),
			'order_direction'		=> sanitize_text_field($order_direction),
			'limit'					=> sanitize_text_field($limit),
			'page'					=> sanitize_text_field($paged),
		);
		$this->search_query_vars = $search;
	}

	public function parse_mls_query(){

	}

	/**
	 * parse getProperties method
	 * */
	private function parse_get_property(){
		$this->property_data 	= '';
		$data_properties = array();
		$cache_keyword 			= 'mls_get_property_' . md5(json_encode($this->search_query_vars));
		if( mwp_cache_get($cache_keyword) ){
			$this->property_data = mwp_cache_get($cache_keyword);
			$this->get_raw_property_api_data = mwp_cache_get($cache_keyword.'_raw');
			$this->property_data_count = mwp_cache_get($cache_keyword.'_count');
			$this->property_data_total = mwp_cache_get($cache_keyword.'_total');
			$this->property_list_data = mwp_cache_get($cache_keyword.'_list');
		}else{
			if(
				$this->get_raw_property_api_data
				&& (isset($this->get_raw_property_api_data->result) && $this->get_raw_property_api_data->result == 'success')
				&& $this->get_raw_property_api_data->total > 0
			){
				$this->has_property = true;
				$count_data_properties = 0;
				$property_index = 0;
				foreach( $this->get_raw_property_api_data->properties as $property ){
					$count_data_properties++;
					$p =	new Mwp_MLS_PropertyEntity;
					$p->bind( $property );

					$data_properties[] = $p;
					$data_properties[$property_index]->is = 'get_property_mls';
					$property_index++;
				}
				$this->property_data_count 	= $count_data_properties;
				$this->property_data_total 	= $this->get_raw_property_api_data->total;
				$this->property_list_data	= $data_properties;
				$this->property_data 		= $data_properties;
				mwp_cache_set($cache_keyword, $this->property_data);
				mwp_cache_set($cache_keyword.'_raw', $this->get_raw_property_api_data);
				mwp_cache_set($cache_keyword.'_count', $this->property_data_count);
				mwp_cache_set($cache_keyword.'_total', $this->property_data_total);
				mwp_cache_set($cache_keyword.'_list', $this->property_list_data);
			}
		}
	}
	/**
	 * parse property detail
	 * this is use to parse single property
	 * primarily used to class-property-single
	 * */
	public function parse_property_details(){
		if( $this->request_property_details ){
			if( $this->has_property() ){
				foreach($this->has_property() as $property){
					if( isset($property->ListingId ) ){
						$property_id 	= $property->ListingId;
						$cache_keyword 	= 'mls_parse_property_details_' . md5($property_id);
						//cache_del($cache_keyword);
						if( mwp_cache_get($cache_keyword) ){
							$this->property_details_data = mwp_cache_get($cache_keyword);
						}else{
							$property_details = $this->api_mls->get_property($property_id);
							if(
								isset($property_details->result)
								&& $property_details->result == 'success'
							){
								$this->property_details_data[$property_id] = $property_details;
							}
						}
					}
				}
			}
		}
	}

	public function parse_property_details_photo(){
		if( $this->request_property_details_image ){
			if( $this->has_property() ){
				foreach($this->has_property() as $property){
					$property_id 	= $property->ListingId;
					$cache_keyword 	= 'mls_parse_property_details_photo_' . md5($property_id);
					//cache_del($cache_keyword);
					if( mwp_cache_get($cache_keyword) ){
						$this->property_details_image_data = mwp_cache_get($cache_keyword);
					}else{
						$property_details_image = $this->api_mls->get_photos_by_matrixID($property_id);
						if( $property_details_image->result == 'success' ){
							$this->property_details_image_data[$property_id] = $property_details_image->photos;
						}
					}
				}
			}
		}
	}
	
	/**
	 *
	 * */
	public function parse_property_id(){
		$p_id = array();
		$p_details_data = array();
		$p_details_image_data = array();
		$p_details_image_agent = array();
		$property_index = 0;
		$property_count = 0;
		if( $this->request_property_id ){
			$broker_id = Mwp_CRM_AccountDetails::get_instance()->get_account_data('accountid');
			if(
				is_array($this->property_id_query_var)
				&& !empty($this->property_id_query_var)
			){
				foreach($this->property_id_query_var as $key => $p_id){
					$cache_keyword = 'mls_property_id_' . $p_id;
					if(  mwp_cache_get($cache_keyword) ){
						$property_data = mwp_cache_get($cache_keyword);
						if( isset($property_data[$property_index]) ){
							$this->property_data[$property_index] = $property_data[$property_index];
							$this->property_data[$property_index]->photos = $property_data[$property_index]->photos;
							
							if( isset($property_data[$property_index]->photos) ){
								$photo_obj = new ArrayObject($property_data[$property_index]->photos);
								if($photo_obj->count() > 0){
									$this->has_property_details_image = true;
									$this->property_details_image_data = $property_data[$property_index]->photos;
								}
							}
							$this->property_data[$property_index]->is = 'single_property_mls';
							$this->property_data[$property_index]->is_id = 'single_property_mls_' . $p_id;
							$property_index++;
						}
					}else{
						$p_data = $this->api_mls->get_property( $p_id, $broker_id );
						
						if(
							$p_data
							&& isset($p_data->result)
							&& $p_data->result == 'success'
						){
							
							$this->property_id_raw_data = $p_data;

							$p =	new Mwp_MLS_PropertyEntity;
							$p->bind( $p_data->property );
														
							$this->property_data[$property_index] = $p;
							
							if( isset($p_data->photos) ){
								$this->property_data[$property_index]->photos = $p_data->photos;
								$photo_obj = new ArrayObject($this->property_data[$property_index]->photos);
								if($photo_obj->count() > 0){
									$this->has_property_details_image = true;
									$this->property_details_image_data = $this->property_data[$property_index]->photos;
								}
							}

							$community 	= '';
							$mls_type	= '';
							if( isset($p_data->mls) ){
								$mls_type	= $p_data->mls;
							}
							$last_mls_update = '';
							if( isset($p_data->last_mls_update) ){
								$last_mls_update = $p_data->last_mls_update;
							}
							$listing_id = 0;
							if( isset($p_data->listing_id) ){
								$listing_id = $p_data->listing_id;
							}

							$this->property_data[$property_index]->mls_type = $mls_type;
							$this->property_data[$property_index]->last_mls_update = $last_mls_update;
							$this->property_data[$property_index]->listing_id = $listing_id;
							$this->property_data[$property_index]->is = 'single_property_mls';
							$this->property_data[$property_index]->is_id = 'single_property_mls_' . $p_id;
							mwp_cache_set($cache_keyword, $this->property_data);
							$property_index++;
						}
					}//if cache get
					
				}//foreach
				$this->property_data_count = $property_index;
				if( $this->property_data_count > 0 ){
					$this->has_property_id 	= true;
					$this->has_property = true;
				}
			}//if
		}//if request id
	}//function
		

	/**
	 *
	 * */
	public function get_property_data(){
		return $this->property_data;
	}
	public function get_property_photo(){
		$img_array = array();
		if( count($this->property_details_image_data) > 0 ){
			$cache_id = '';
			if( isset($this->property_data[0]->is_id) ){
				$cache_id = $this->property_data[0]->is_id.'-photos';
			}
			$cache_keyword = $cache_id;
			if(  mwp_cache_get($cache_keyword) ){
				$img_array = mwp_cache_get($cache_keyword);
			}else{
				foreach($this->property_details_image_data as $key => $val){
					if( @getimagesize($val->url) ){
						$img_array[] = $val->url;
					}
				}
				mwp_cache_set($cache_keyword, $img_array);
				$img_array = mwp_cache_get($cache_keyword);
			}
		}
		return $img_array;
	}
	/**
	 *
	 * */
	public function get_property_data_raw(){
		return $this->get_raw_property_api_data;
	}

	public function get_property(){
		if(
			$this->is_fetch_all()
			|| $this->has_search_query()
		){
			//get all properties
			$this->get_raw_property_api_data = $this->api_mls->get_properties($this->search_query_vars);
			//parse list properties
			$this->parse_get_property();
		}
		//parse single property
		$this->parse_property_id();
		//parse property details photo
		$this->parse_property_details_photo();
		//parse property details
		$this->parse_property_details();
		//parse get_property
		return $this->get_raw_property_api_data;
	}

	public function has_property(){
		if(
			$this->property_data
			|| $this->has_property
		){
			return $this->property_data;
		}
		return false;
	}

	public function query($query = ''){
		$this->parse_query($query);
		$this->parse_mls_query();
		$this->get_property();
	}

	public function __construct($query = ''){
		if( !empty($query) ){
			$this->masterdigm_mls();
			$this->query($query);
		}
	}
}
