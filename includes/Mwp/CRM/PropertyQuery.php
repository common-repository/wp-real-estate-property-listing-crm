<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get CRM property , list, featured or single
 * */
class Mwp_CRM_PropertyQuery extends Mwp_PropertyQuery{
	protected static $instance = null;
	/**
	 * holder of the api crm
	 * */
	public $api_crm;
	public $property_source = 'crm';
	/**
	 * request featured property
	 * */
	public $query_featured_property 		= false;
	public $featured_property_query_var		= null;
	public $has_featured_property			= false;
	public $featured_property_data			= null;
	public $featured_property_data_raw		= null;
	public $featured_property_data_count	= 0;

	public $featured_property_locations				= null;
	public $featured_property_locations_query_var	= array();
	public $request_featured_property_locations		= false;
	public $has_featured_property_locations			= false;

	public $featured_property_userid			= null;
	public $featured_property_userid_query_var 	= null;
	public $request_featured_property_userid	= false;
	public $has_featured_property_userid		= false;

	public $featured_property_transaction = array();
	public $featured_property_transaction_query_var = null;
	public $request_featured_property_transaction = false;
	public $has_featured_property_transaction = true;
	public $featured_array_ids = array();
	public $single_property_id = 0;
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

	public function masterdigm_crm(){
		$this->api_crm = new Mwp_CRM_Adapter;
	}

	public function get_source(){
		return $this->property_source;
	}

	public function search_query($search = ''){
		$location = '';
		if( isset($search['location']) ){
			$location = $this->search_query_address($search['location']);
		}

		$map_boundaries = array();
		
		if( isset($search['map_boundaries']) ){
			$map_boundaries = $this->search_query_map_boundaries($search);
		}

		//$use_location_search = 0;
		//if( isset($search['use_location_search']) ){
			$use_location_search = $this->search_query_use_location_search();
		//}

		$subdivisionid = 0;
		if( isset($search['subdivisionid']) ){
			$subdivisionid = $this->search_query_subdivision_id($search['subdivisionid']);
		}

		$cityid = 0;
		if( isset($search['cityid']) ){
			$cityid = $this->search_query_city_id($search['cityid']);
		}

		$communityid = 0;
		if( isset($search['communityid']) ){
			$communityid = $this->search_query_community_id($search['communityid']);
		}

		$countryid = 0;
		if( isset($search['countryid']) ){
			$countryid = $this->search_query_country_id($search['countryid']);
		}

		$stateid = 0;
		if( isset($search['stateid']) ){
			$stateid = $this->search_query_state_id($search['stateid']);
		}

		$countyid = 0;
		if( isset($search['countyid']) ){
			$countyid = $this->search_query_county_id($search['countyid']);
		}

		$zip = 0;
		if( isset($search['zip']) ){
			$zip = $this->search_query_zip($search['zip']);
		}

		$lat = 0;
		if( isset($search['lat']) ){
			$lat = $this->search_query_lat($search['lat']);
		}

		$lng = 0;
		if( isset($search['lng']) ){
			$lng = $this->search_query_lng($search['lng']);
		}

		$bath = 0;
		if( isset($search['bathrooms']) ){
			$bath = $this->search_query_bath($search['bathrooms']);
		}

		$bed = 0;
		if( isset($search['bedrooms']) ){
			$bed = $this->search_query_bed($search['bedrooms']);
		}

		$min_listprice = 0;
		if( isset($search['min_listprice']) ){
			$min_listprice = $this->search_query_min_listprice($search['min_listprice']);
		}

		$max_listprice = 0;
		if( isset($search['max_listprice']) ){
			$max_listprice = $this->search_query_max_listprice($search['max_listprice']);
		}

		$property_status = '';
		if(
			isset($search['property_status'])
			&& $search['property_status'] != ''
		){
			$property_status = $search['property_status'];
		}else{
			$property_status = $this->search_query_property_status($property_status);
		}

		$property_type = 0;
		if( isset($search['property_type']) ){
			$property_type = $this->search_query_property_type($search['property_type']);
		}
		
		//transaction
		$transaction = array('For Sale','Foreclosure','For Rent');
		if(
			isset($search['transaction'])
			&& $search['transaction'] != 'any'
			&& $search['transaction'] != ''
		){
			$transaction = array(
				urldecode($search['transaction'])
			);
		}
		if(
			isset($_REQUEST['transaction'])
			&& $_REQUEST['transaction'] != 'any'
			&& $_REQUEST['transaction'] != ''
		){
			$transaction = array(
				urldecode($_REQUEST['transaction'])
			);
		}

		if( $transaction == 'For Sale' || $transaction == '' ){
			$transaction = array('For Sale', 'Foreclosure');
		}
		//transaction
		$transaction = $this->search_query_transaction($transaction);
		$orderby = 'price';
		if(
			isset($search['orderby'])
			&& $search['orderby'] != ''
		){
			$orderby = $this->search_query_orderby($search['orderby']);
		}

		$order_direction = 'DESC';
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
		
		$keyword = '';
		$use_fulltext_search = 0;
		if(
			isset($_REQUEST['search_keyword'])
			&& sanitize_text_field($_REQUEST['search_keyword']) != ''
		){
			$use_fulltext_search = 1;
			$keyword = sanitize_text_field($_REQUEST['search_keyword']);
		}
		if(
			isset($search_data['search_keyword'])
			&& sanitize_text_field($search['search_keyword']) != ''
		){
			$use_fulltext_search = 1;
			$keyword = sanitize_text_field($search['search_keyword']);
		}
		
		$lot_area = 0;
		if(
			sanitize_text_field(isset($search_data['lot_area']))
			&&  $search_data['lot_area'] != ''
		){
			$lot_area = sanitize_text_field($search_data['lot_area']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['lot_area']))
			&& $_REQUEST['lot_area'] != ''
		){
			$lot_area = sanitize_text_field($_REQUEST['lot_area']);
		}

		$floor_area = 0;
		if(
			sanitize_text_field(isset($search_data['floor_area']))
			&&  $search_data['floor_area'] != ''
		){
			$floor_area = sanitize_text_field($search_data['floor_area']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['floor_area']))
			&& $_REQUEST['floor_area'] != ''
		){
			$floor_area = sanitize_text_field($_REQUEST['floor_area']);
		}
		
		$search = array(
			'use_fulltext_search' 	=> $use_fulltext_search,
			'q' 					=> $keyword,
			'map_boundaries'		=> $map_boundaries,
			'use_location_search' 	=> sanitize_text_field($use_location_search),
			'subdivisionid'			=> sanitize_text_field($subdivisionid),
			'cityid'				=> sanitize_text_field($cityid),
			'communityid'			=> sanitize_text_field($communityid),
			'countryid'				=> sanitize_text_field($countryid),
			'countyid'				=> sanitize_text_field($countyid),
			'stateid'				=> sanitize_text_field($stateid),
			'zip'					=> sanitize_text_field($zip),
			'lat' 					=> sanitize_text_field($lat),
			'lon' 					=> sanitize_text_field($lng),
			'bathrooms' 			=> sanitize_text_field($bath),
			'bedrooms' 				=> sanitize_text_field($bed),
			'lot_area' 				=> $lot_area,
			'floor_area' 			=> $floor_area,
			'min_listprice' 		=> sanitize_text_field($min_listprice),
			'max_listprice' 		=> sanitize_text_field($max_listprice),
			'property_status'		=> sanitize_text_field($property_status),
			'property_type'			=> sanitize_text_field($property_type),
			'transaction'			=> $transaction,
			'orderby'				=> sanitize_text_field($orderby),
			'order_direction'		=> sanitize_text_field($order_direction),
			'limit'					=> sanitize_text_field($limit),
			'page'					=> sanitize_text_field($paged)
		);
		//mwp_dump($search);
		$this->search_query_vars = $search;
	}

	public function parse_crm_query(){
		//check if its featured
		if(
			isset($this->query_vars['featured'])
		){
			$this->query_featured_property 		= true;
			$this->featured_property_query_var 	= $this->query_vars['featured'];
			if( count($this->query_vars['featured']) > 0 ){
				/**
				 *more query like:
				 * locations = array
				 * user_id = int
				 * */
				//parse featured locations
				if(
					isset($this->query_vars['featured']['location'])
					&& is_array($this->query_vars['featured']['location'])
					&& count($this->query_vars['featured']['location']) > 0
				){
					$this->featured_property_locations_query_var = $this->query_vars['featured']['location'];
					$this->request_featured_property_locations = true;
				}
				//parse featured locations user id
				if(
					isset($this->query_vars['featured']['user_id'])
					&& is_int($this->query_vars['featured']['user_id'])
				){
					$this->featured_property_userid_query_var = $this->query_vars['featured']['user_id'];
					$this->request_featured_property_userid = true;
				}else{
					//default
					$this->featured_property_userid_query_var 	= Mwp_CRM_AccountDetails::get_instance()->get_account_data('userid');
				}
				$this->has_featured_property_userid = true;
				//transaction
				if(
					isset($this->query_vars['featured']['transaction'])
					&& is_array($this->query_vars['featured']['transaction'])
					&& count($this->query_vars['featured']['transaction']) > 0
				){
					$this->featured_property_transaction_query_var = $this->query_vars['featured']['transaction'];
					$this->request_featured_property_transaction = true;
				}else{
					//default
					$this->featured_property_transaction_query_var = array('For Sale', 'Foreclosure');
				}
				$this->has_featured_property_transaction = true;
			}
		}
	}

	/**
	 * parse getProperties method
	 * */
	private function parse_get_property(){
		$data_properties = array();
		$this->property_data 	= '';
		$cache_keyword 			= 'crm_get_property_' . md5(json_encode($this->search_query_vars));
		//mwp_cache_del($cache_keyword);
		if( mwp_cache_get($cache_keyword) ){
			$this->has_property = true;
			$this->property_data = mwp_cache_get($cache_keyword);
			$this->property_data_count 	= mwp_cache_get($cache_keyword.'_count');
			$this->property_data_total 	= mwp_cache_get($cache_keyword.'_total');
			$this->property_list_data	= mwp_cache_get($cache_keyword.'_list_data');
		}else{
			//mwp_dump($this->get_raw_property_api_data);
			//get all properties
			$this->get_raw_property_api_data = $this->api_crm->get_properties($this->search_query_vars);
			//mwp_dump($this->get_raw_property_api_data,1);
			if(
				$this->get_raw_property_api_data
				&& $this->get_raw_property_api_data->result == 'success' 
				&& $this->get_raw_property_api_data->total > 0
			){
				$this->has_property = true;
				$property_index = 0;
				foreach( $this->get_raw_property_api_data->properties as $property ){
					$p =	new Mwp_CRM_PropertyEntity;
					$p->bind( $property );

					$data_properties[] = $p;
					$data_properties[$property_index]->is = 'get_property_crm';
					$property_index++;
				}

				$this->property_data_count 	= $this->get_raw_property_api_data->count;
				$this->property_data_total 	= $this->get_raw_property_api_data->total;
				$this->property_list_data	= $data_properties;
				$this->property_data 		= $data_properties;
				
				mwp_cache_set($cache_keyword . '_count', $this->property_data_count);
				mwp_cache_set($cache_keyword . '_total', $this->property_data_total);
				mwp_cache_set($cache_keyword . '_list_data', $this->property_list_data);
				mwp_cache_set($cache_keyword, $this->property_data);
				mwp_cache_set($cache_keyword.'_raw', $this->get_raw_property_api_data);
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
				foreach($this->get_property_data() as $property){
					if( isset($property->id ) ){
						$property_id 	= $property->id;
						$cache_keyword 	= 'crm_property_details_' . md5($property_id);
						//mwp_cache_del($cache_keyword);
						if( mwp_cache_get($cache_keyword) ){
							$this->property_details_data = mwp_cache_get($cache_keyword);
						}else{
							$property_details = $this->api_crm->get_property($property_id);
							//mwp_dump($property_details,1);
							if( $property_details->result == 'success' ){
								$this->property_details_data[$property_id] = $property_details;
								mwp_cache_set($cache_keyword, $this->property_details_data[$property_id]);
							}
						}
					}
				}
			}
		}
	}
	
	public function parse_property_details_photo(){
		if( $this->request_property_details_image() ){
			if( $this->has_property() ){
				$this->property_details_image_data = array();
				foreach($this->get_property_data() as $property){
					$property_id 	= $property->id;
					$cache_keyword 	= 'crm_parse_property_details_photo_' . $property_id;
					if( mwp_cache_get($cache_keyword) ){
						$this->property_details_image_data[$property_id] = mwp_cache_get($cache_keyword);
					}else{
						$property_details_image = $this->api_crm->get_photos_by_propertyId($property_id);
						if( $property_details_image->result == 'success' ){
							$this->property_details_image_data[$property_id] = $property_details_image->photos;
							mwp_cache_set($cache_keyword, $this->property_details_image_data[$property_id]);
						}
					}
				}
			}
		}
	}

	public function has_featured_property(){
		return $this->has_featured_property;
	}

	public function parse_featured_property(){
		$this->featured_property_data = array();
		$featured_locations = array();
		$featured_user_id 	= null;
		$featured_data 		= array();
		
		if( $this->query_featured_property ){
			if( $this->request_featured_property_locations ){
				foreach( $this->featured_property_locations_query_var as $key => $val ){
					if( is_array($val) ){
						$featured_locations = $val;
					}
				}
			}
			if( $this->has_featured_property_userid ){
				$featured_user_id = $this->featured_property_userid_query_var;
			}
			$other_data = array();
			if( $this->request_featured_property_transaction ){
				$transaction_data = $this->featured_property_transaction_query_var;
				$other_data = ($other_data + array('transaction' => $transaction_data[0]));
			}
			$cache_keyword	=  'crm_featured_properties_' . md5(json_encode($featured_locations + $other_data));

			if( mwp_cache_get($cache_keyword) ){
				$this->has_property = true;
				$this->property_data = mwp_cache_get($cache_keyword);
				$this->featured_property_data_count = mwp_cache_get($cache_keyword . '_count');
				$this->property_data_count = mwp_cache_get($cache_keyword . '_count');
				$this->featured_property_data_raw = mwp_cache_get($cache_keyword . '_raw');
			}else{
				$featured = $this->api_crm->get_featured_properties($featured_user_id, $featured_locations, $other_data);
				if(
					$featured
					&& (isset($featured->result) && $featured->result == 'success' )
					&& (isset($featured->count) && $featured->count > 0 )
				){
					$this->has_property = true;
					$this->has_featured_property			= true;
					$this->featured_property_data_count 	= $featured->count;
					$this->property_data_count 				= $featured->count;
					$this->featured_property_data_raw 		= $featured->properties;
					$property_index = 0;
					foreach( $featured->properties as $property ){
						$p =	new Mwp_CRM_PropertyEntity;
						$p->bind( $property );
						$data_properties[] = $p;
						$data_properties[$property_index]->is = 'featured_property';
						$this->featured_array_ids[] = $p->id();
						$property_index++;
					}
					//merge
					$this->property_data = ($this->property_data + $data_properties);
					$this->featured_property_data = $data_properties;
					mwp_cache_set($cache_keyword, $this->featured_property_data);
					mwp_cache_set($cache_keyword . '_count', $this->featured_property_data_count);
					mwp_cache_set($cache_keyword . '_raw', $this->featured_property_data_raw);
				}
			}
		}
	}

	public function get_featured_property(){
		return $this->featured_property_data;
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
					$cache_keyword = 'crm_property_id_' . $p_id;
					//mwp_cache_del($cache_keyword);
					if(  mwp_cache_get($cache_keyword) ){
						$property_data = mwp_cache_get($cache_keyword);
						if( isset($property_data[$property_index]) ){
							$this->property_data[$property_index] = $property_data[$property_index];
							$this->property_data[$property_index]->photos = $property_data[$property_index]->photos;
							
							$photo_obj = new ArrayObject($property_data[$property_index]->photos);
							if($photo_obj->count() > 0){
								$this->has_property_details_image = true;
								$this->property_details_image_data = $property_data[$property_index]->photos;
							}
							
							$this->property_data[$property_index]->agent = $property_data[$property_index]->agent_details;
							$this->property_data[$property_index]->is = 'single_property_crm';
							$this->property_data[$property_index]->is_id = 'single_property_crm_' . $p_id;
							$this->single_property_id = $p_id;
							$property_index++;
						}
					}else{
						$p_data = $this->api_crm->get_property( $p_id, $broker_id );
						
						if(
							$p_data
							&& isset($p_data->result)
							&& $p_data->result == 'success'
						){
							
							$this->property_id_raw_data[$property_index] = $p_data;

							$p =	new Mwp_CRM_PropertyEntity;
							$p->bind( $p_data->property );

							$this->property_data[$property_index] = $p;
							$this->property_data[$property_index]->photos = $p_data->photos;
							$this->property_data[$property_index]->features = $p_data->features;
							$this->property_data[$property_index]->documents = $p_data->documents;
							$this->property_data[$property_index]->property_types = $p_data->property_types;
							$this->property_data[$property_index]->custom_fields = $p_data->custom_fields;
							$this->property_data[$property_index]->videos = $p_data->videos;
							$this->property_data[$property_index]->currency = $p_data->currency;
							$this->property_data[$property_index]->unit_area = $p_data->unit_area;
							$this->property_data[$property_index]->agent_details = $p_data->agent_details;
							
							$photo_obj = new ArrayObject($this->property_data[$property_index]->photos);
							if($photo_obj->count() > 0){
								$this->has_property_details_image = true;
								$this->property_details_image_data = $this->property_data[$property_index]->photos;
							}
							
							$this->property_data[$property_index]->agent = $p_data->agent_details;
							$this->property_data[$property_index]->is = 'single_property_crm';
							$this->property_data[$property_index]->is_id = 'single_property_crm_' . $p_id;
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

	/**
	 *
	 * */
	public function get_property_data_raw(){
		return $this->get_raw_property_api_data;
	}
	
	public function get_property_photo(){
		if( $this->has_property() ){
			if( count($this->property_details_image_data) > 0 ){
				$json_decode = json_decode(json_encode($this->property_details_image_data), true);
				return array_values($json_decode);
			}
		}
		return false;
	}
	
	public function get_property_cat_photos(){
		if( $this->has_property() && $this->single_property_id ){
			$property_id = $this->single_property_id;
			$property_details_image = $this->api_crm->get_photos_by_propertyId($property_id);
			return $property_details_image;
		}
	}
	
	public function get_property(){
		if(
			$this->is_fetch_all()
			|| $this->has_search_query()
		){
			if( !$this->query_featured_property ){
				//get all properties
				//$this->get_raw_property_api_data = $this->api_crm->get_properties($this->search_query_vars);
				//parse list properties
				$this->parse_get_property();
			}
		}
		//parse featured properties
		$this->parse_featured_property();
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
			return true;
		}
		return false;
	}

	public function query($query = ''){
		$this->parse_query($query);
		$this->parse_crm_query();
		$this->get_property();
	}

	public function __construct($query = ''){
		if( !empty($query) ){
			$this->masterdigm_crm();
			$this->query($query);
		}
	}
}
