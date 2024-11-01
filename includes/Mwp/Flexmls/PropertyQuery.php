<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get MLS property , list or single
 * */
class Mwp_Flexmls_PropertyQuery extends Mwp_PropertyQuery{
	protected static $instance = null;
	public $has_search_query_listing_office_id 	= false;
	public $search_query_listing_office_id_data = null;
	/**
	 * holder of the api mls
	 * */
	public $api_mls;
	public $property_source = 'flexmls';
	
	public $has_search_flexmls_id = false;
	public $search_flexmls_id_data = '';
	public $has_property_id = true;
	public $property_id_data = '';
	public $has_cityid = true;
	public $cityid_data = '';
	public $has_subdivision= true;
	public $subdivision_data = '';
	public $has_bathrooms= true;
	public $bathrooms_data = '';
	public $has_bedrooms= true;
	public $bedrooms_data = '';
	public $has_property_type= true;
	public $property_type_data = '';
	public $has_expand= true;
	public $expand_data = '';
	public $has_map_boundaries= true;
	public $map_boundaries_data = '';
	public $property_details_custom_fields = null;
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

	public function masterdigm_flexmls(){
		$this->api_mls = new Mwp_Flexmls_Adapter;
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
	
	//id
	public function search_flexmls_id($id){
		if(
			isset($id)
			&& !empty($id)
		){
			$this->has_search_flexmls_id = true;
			$this->search_flexmls_id_data = sanitize_text_field($id);
		}
		return $this->search_flexmls_id_data;
	}
	public function has_search_flexmls_id(){
		return $this->has_search_flexmls_id;
	}
	//id
	//property_id
	public function property_id($property_id){
		if(
			isset($property_id)
			&& !empty($property_id)
		){
			$this->has_property_id = true;

			if(count($property_id) > 1 ){
				foreach($property_id as $p_key => $p_id){
					$this->property_id_data .= "ListingId Eq '" . sanitize_text_field($p_id) . "' OR ";
				}
			}else{
				$this->property_id_data = "ListingId Eq '" . sanitize_text_field($property_id) . "' OR ";
			}	
		}
		return $this->property_id_data;
	}
	public function has_property_id(){
		return $this->has_property_id;
	}
	//property_id
	//cityid
	public function cityid($cityid){
		if(
			isset($cityid)
			&& !empty($cityid)
		){
			$this->has_cityid = true;
			//$this->cityid_data = "City Eq '" . sanitize_text_field($cityid) . "' AND ";
			$this->cityid_data = sanitize_text_field($cityid);
		}
		return $this->cityid_data;
	}
	public function has_cityid(){
		return $this->has_cityid;
	}
	//property_id
	//subdivision
	public function subdivision($subdivision){
		if(
			isset($subdivision)
			&& !empty($subdivision)
		){
			$this->has_subdivision= true;
			$this->subdivision_data = " SubdivisionName Eq '" . sanitize_text_field($subdivision) . "' AND ";
		}
		return $this->subdivision_data;
	}
	public function has_subdivision(){
		return $this->has_subdivision;
	}
	//subdivision
	//bathrooms
	public function bathrooms($bathrooms){
		if(
			isset($bathrooms)
			&& !empty($bathrooms)
		){
			$this->has_bathrooms= true;
			$this->bathrooms_data = " BathsTotal Le " . sanitize_text_field($bathrooms) ." AND ";
		}
		return $this->bathrooms_data;
	}
	public function has_bathrooms(){
		return $this->has_bathrooms;
	}
	//$bathrooms
	//bedrooms
	public function bedrooms($bedrooms){
		if(
			isset($bedrooms)
			&& !empty($bedrooms)
		){
			$this->has_bedrooms= true;
			$this->bedrooms_data = " BedsTotal Le " . sanitize_text_field($bedrooms) ." AND ";
		}
		return $this->bedrooms_data;
	}
	public function has_bedrooms(){
		return $this->has_bedrooms;
	}
	//$bedrooms
	//property_type
	public function property_type($property_type){
		if(
			isset($property_type)
			&& !empty($property_type)
		){
			
			$fields_type =  Mwp_Flexmls_PropertyFields::get_instance()->get_property_type();
			if(
				is_array($fields_type) && array_key_exists($property_type, $fields_type)
			){
				$this->has_property_type= true;
				$this->property_type_data = " PropertyType Eq '" . sanitize_text_field($property_type) . "' AND ";
			}
		}
		return $this->property_type_data;
	}
	public function has_property_type(){
		return $this->has_property_type;
	}
	//property_type
	//expand
	public function expand($expand){
		if(
			isset($expand)
			&& !empty($expand)
		){
			
			$this->has_expand= true;
			$this->expand_data = sanitize_text_field($expand);
		}
		return $this->expand_data;
	}
	public function has_expand(){
		return $this->has_expand;
	}
	//expand
	//map_boundaries
	public function map_boundaries($map_boundaries){
		$ret_map_boundaries = '';
		if(
			isset($map_boundaries['map_boundaries'])
			&& is_array($map_boundaries['map_boundaries'])
			&& count($map_boundaries['map_boundaries']) >= 4
		){
			$lat1 = $map_boundaries['map_boundaries']['ne_lat'];
			$lng1 = $map_boundaries['map_boundaries']['ne_lng'];
			$lat2 = $map_boundaries['map_boundaries']['sw_lat'];
			$lng2 = $map_boundaries['map_boundaries']['sw_lng'];
			$ret_map_boundaries = "Location Eq rectangle('{$lat1} {$lng1}, {$lat2} {$lng2}') AND ";
		}
			
		$this->has_map_boundaries= true;
		$this->map_boundaries_data = $ret_map_boundaries;
		return $this->map_boundaries_data;
	}
	public function has_map_boundaries(){
		return $this->has_map_boundaries;
	}
	//map_boundaries
	
	public function search_query($search = ''){
		$id = '';
		if(
			isset($search['id'])
			&& $search['id'] != ''
		){
			$id = $this->search_flexmls_id($search['id']);
		}
		$property_id = '';
		if(
			isset($search['property_id'])
			&& $search['property_id'] != ''
		){
			$property_id = $this->property_id($search['property_id']);
		}
		
		$limit = $this->search_query_limit();
		if(
			isset($search['limit'])
			&& $search['limit'] != ''
		){
			$limit = $this->search_query_limit($search['limit']);
		}
		
		$cityid = '';
		if( isset($search['cityid']) ){
			$cityid = $this->cityid($search['cityid']);
		}else{
			if( isset($search['location']) && $search['location'] != '' ){
				$cityid = $this->cityid($search['location']);
			}
		}
		if( $cityid != '' ){
			$cityid = $cityid . ' AND ';
		}
		
		$subdivision = '';
		if(
			isset($search['subdivision'])
			&& $search['subdivision'] != ''
		){
			$subdivision = $this->subdivision($search['subdivision']);
		}

		$bathrooms = '';
		if(
			isset($search['bathrooms'])
			&& $search['bathrooms'] != ''
		){
			$bathrooms = $this->bathrooms($search['bathrooms']);
		}
		$bedrooms = '';
		if(
			isset($search['bedrooms'])
			&& $search['bedrooms'] != ''
		){
			$bedrooms = $this->bedrooms($search['bedrooms']);
		}
		
		$property_type = '';
		if(
			isset($search['property_type'])
			&& $search['property_type'] != ''
		){
			$property_type = $this->property_type($search['property_type']);
		}

		$min_listprice = '';
		if( isset($search['min_listprice']) ){
			$min_listprice = $this->search_query_min_listprice($search['min_listprice']);
		}

		$max_listprice = '';
		if( isset($search['max_listprice']) ){
			$max_listprice = $this->search_query_max_listprice($search['max_listprice']);
		}

		$filter_price = '';
		if( $min_listprice < $max_listprice && ($min_listprice > 0 || $max_listprice > 0) ){
			$filter_price = " ListPrice Bt " . $min_listprice .", ".$max_listprice . " AND ";
		}

		$expand = '';
		if(
			isset($search['expand'])
			&&  $search['expand'] != ''
		){
			$expand = $this->expand($search['expand']);
		}

		$orderby = 'posted_at';
		if(
			isset($search['orderby'])
			&& $search['orderby'] != ''
		){
			$orderby = $this->search_query_orderby($search['orderby']);
		}

		if( $orderby == 'price' ){
			$orderby = 'ListPrice';
		}
		if( $orderby == 'posted_at' ){
			$orderby = 'ModificationTimestamp';
		}

		$order_direction = 'DESC';
		if(
			isset($search['order_direction'])
			&& $search['order_direction'] != ''
		){
			$order_direction = $this->search_query_order_direction($search['order_direction']);
		}
		if( $order_direction == 'ASC' ){
			$order_direction = '+';
		}elseif( $order_direction == 'DESC' ){
			$order_direction = '-';
		}
		
		$map_boundaries = '';
		if( isset($search['map_boundaries']) ){
			$map_boundaries = $this->map_boundaries($search);
		}
		
		$flex_orderby = '';
		if( $orderby != '' && $order_direction != '' ){
			$flex_orderby = $order_direction.$orderby;
		}

		$filter = $id
		. $property_id
		. $cityid
		. $subdivision
		. $bathrooms
		. $bedrooms
		. $property_type
		. $filter_price
		. $map_boundaries;
		$filter = rtrim($filter, ' AND ');
		$filter = rtrim($filter, ' OR ');
		
		$paged = '';
		if(
			isset($search['paged'])
			&& $search['paged'] != ''
		){
			$paged = $search['paged'];
		}else{
			$paged = $this->search_query_paged($paged);
		}
		
		$search_criteria_data = array(
			'_pagination' => 1,
			'_page' => $paged,
			'_limit' => $limit,
			'_expand' => $expand,
			'_filter' => $filter,
			'_orderby' => $flex_orderby
		);
		$this->search_query_vars = $search_criteria_data;
	}

	public function parse_flexmls_query(){

	}

	/**
	 * parse getProperties method
	 * */
	private function parse_get_property(){
		$data_properties = array();
		$this->property_data 	= '';
		$cache_keyword 			= 'flexmls_get_property_' . md5(json_encode($this->search_query_vars));
		//mwp_cache_del($cache_keyword);
		if( mwp_cache_get($cache_keyword) ){
			$this->property_data = mwp_cache_get($cache_keyword);
			$this->get_raw_property_api_data = mwp_cache_get($cache_keyword.'_raw');
			$this->property_data_count = mwp_cache_get($cache_keyword.'_count');
			$this->property_data_total = mwp_cache_get($cache_keyword.'_total');
			$this->property_list_data = mwp_cache_get($cache_keyword.'_list');
		}else{
			if(
				$this->get_raw_property_api_data
			){
				$this->has_property = true;
				$count_data_properties = 0;
				$property_index = 0;
				foreach( $this->get_raw_property_api_data as $property ){
					$count_data_properties++;
					$p =	new Mwp_Flexmls_PropertyEntity;
					$p->bind( $property['StandardFields'] );

					$data_properties[] = $p;
					$data_properties[$property_index]->is = 'get_property_flexmls';
					$property_index++;
				}
				$data_properties['flexmls'] = array(
					'page_size' => $this->api_mls->client->page_size,
					'total_pages' => $this->api_mls->client->total_pages,
					'current_page' => $this->api_mls->client->current_page,
				);
				$this->property_data_count 	= $count_data_properties;
				$this->property_data_total 	= $this->api_mls->client->last_count;
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
						$cache_keyword 	= 'flexmls_parse_property_details_' . md5($property_id);
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
					$cache_keyword 	= 'flexmls_parse_property_details_photo_' . md5($property_id);
					//cache_del($cache_keyword);
					if( mwp_cache_get($cache_keyword) ){
						$this->property_details_image_data = mwp_cache_get($cache_keyword);
					}else{
						//$property_details_image = $this->api_mls->get_photos_by_matrixID($property_id);
						$property_details_image = false;
						if( $property_details_image && $property_details_image->result == 'success' ){
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
				//loop property id
				//check if multiple
				$property_id = '';
				if(count($this->property_id_query_var) > 1 ){
					foreach($this->property_id_query_var as $p_key => $p_id){
						$property_id .= "ListingId Eq '" . sanitize_text_field($p_id) . "' OR ";
					}
					$property_id = rtrim($property_id, ' OR ');
					$this->search_query_vars['_filter'] = $property_id;
				}
				
				foreach($this->property_id_query_var as $key => $p_id){
					$cache_keyword = 'flexmls_property_id_' . str_replace('-','_',$p_id);
					//mwp_cache_del($cache_keyword);
					if(  mwp_cache_get($cache_keyword) ){
						$property_data = mwp_cache_get($cache_keyword);

						$this->property_data[$property_index] = $property_data[$property_index];
						$this->has_property_details_image = true;
						$this->property_details_image_data = $property_data[$property_index]->photos;
						$this->property_data[$property_index]->CustomFields = $property_data[$property_index]->CustomFields;
						$this->property_details_custom_fields = $property_data[$property_index]->CustomFields;
						$this->property_data[$property_index]->is = 'single_property_flexmls';
						$this->property_data[$property_index]->is_id = 'single_property_flexmls_' . $p_id;
						$property_index++;
					}else{
						$p_data = $this->api_mls->listings($this->search_query_vars);
						if(
							$p_data
						){
							$this->property_id_raw_data[$property_index] = $p_data;
							
							$p =	new Mwp_Flexmls_PropertyEntity;
							$p->bind( $p_data[$property_index]['StandardFields']  );
							
							$this->property_data[$property_index] = $p;
							
							$custom_fields = array();
							if( isset($p_data[$property_index]['CustomFields']) ){
								$custom_fields = $p_data[$property_index]['CustomFields'];
								$this->property_data[$property_index]->CustomFields = $custom_fields;
								$this->property_details_custom_fields = $custom_fields;
							}
														
							if( isset($p_data[$property_index]['StandardFields']['Photos']) ){
								if(count($p_data[$property_index]['StandardFields']['Photos']) > 0){
									$this->property_data[$property_index]->photos = $p_data[$property_index]['StandardFields']['Photos'];
									$this->has_property_details_image = true;
									$this->property_details_image_data = $this->property_data[$property_index]->photos;
								}
							}

							$this->property_data[$property_index]->mls_type = 'flexmls';
							$this->property_data[$property_index]->is = 'single_property_flexmls';
							$this->property_data[$property_index]->is_id = 'single_property_flexmls_' . $p_id;
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
	
	public function get_custom_fields(){
		$md_custom_fields_data = false;
		$custom_fields_data = array();
		$custom_fields = false;
		$data_custom_fields = $this->property_details_custom_fields;
		if( $data_custom_fields[0]['Main'] && isset($data_custom_fields[0]['Main']) ){
			$custom_fields = true;
			$custom_fields_data = $data_custom_fields[0]['Main'];
		}
		if($this->has_property && $custom_fields){
			foreach($custom_fields_data as $cf_key => $cf_val ){
				if(is_array($cf_val) && count($cf_val) > 0){
					foreach($cf_val as $cf_val_key => $cf_val_val){//loop $cf_val
						if(is_array($cf_val_val) && count($cf_val_val) > 0){
							foreach($cf_val_val as $child_key => $child_val){
								if(is_array($child_val) && count($child_val) > 0){
									foreach($child_val as $ch_child_key => $ch_child_val){
										$md_custom_fields_data[$cf_val_key][$ch_child_key] = $ch_child_val;
									}
								}
							}
						}
					}
				}
			}
			return $md_custom_fields_data;
		}//if has property
	}
	
	/**
	 *
	 * */
	public function get_property_data(){
		return $this->property_data;
	}
	public function get_property_details_image_data(){
		return $this->property_details_image_data;
	}
	public function get_property_photo($size = 'Uri640'){
		$img_array = array();
		if( count($this->property_details_image_data) > 0 ){
			foreach($this->property_details_image_data as $key => $val){
				$img_array[] = $val[$size];
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
			!$this->request_property_id && $this->has_search_query()
		){
			//get all properties
			$this->get_raw_property_api_data = $this->api_mls->listings($this->search_query_vars);
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
		$this->parse_flexmls_query();
		$this->get_property();
	}

	public function __construct($query = ''){
		if( !empty($query) ){
			$this->masterdigm_flexmls();
			$this->query($query);
		}
	}
}
