<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * get HomeJunction property , list or single
 * */
class Mwp_HomeJunction_PropertyQuery extends Mwp_PropertyQuery{
	protected static $instance = null;
	public $has_search_query_listing_office_id 	= false;
	/**
	 * holder of the api mls
	 * */
	public $hji_mls;
	public $property_source;

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

	public function masterdigm_api(){
		$this->hji_mls = new Mwp_HomeJunction_Adapter;
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
	
	public function search_query($search = ''){

		$details = false;
		if(
			sanitize_text_field(isset($search['details']))
			&& is_bool($search['details'])
		){
			$details = sanitize_text_field($search['details']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['details']))
			&& is_bool($_REQUEST['details'])
		){
			$details = sanitize_text_field($_REQUEST['details']);
		}
		$keyword = '';
		if(
			sanitize_text_field(isset($search['keyword']))
			&&  $search['keyword'] != ''
		){
			$keyword = sanitize_text_field($search['keyword']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['keyword']))
			&& $_REQUEST['keyword'] != ''
		){
			$keyword = sanitize_text_field($_REQUEST['keyword']);
		}
		$lot_area = '';
		if(
			sanitize_text_field(isset($search['lot_area']))
			&&  $search['lot_area'] != ''
		){
			$lot_area = sanitize_text_field($search['lot_area']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['lot_area']))
			&& $_REQUEST['lot_area'] != ''
		){
			$lot_area = sanitize_text_field($_REQUEST['lot_area']);
		}
		$lsu = '';
		if(
			sanitize_text_field(isset($search['lsu']))
			&&  $search['lsu'] != ''
		){
			$lsu = sanitize_text_field($search['lsu']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['lsu']))
			&& $_REQUEST['lsu'] != ''
		){
			$lsu = sanitize_text_field($_REQUEST['lsu']);
		}
		$floor_area = '';
		if(
			sanitize_text_field(isset($search['floor_area']))
			&&  $search['floor_area'] != ''
		){
			$floor_area = sanitize_text_field($search['floor_area']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['floor_area']))
			&& $_REQUEST['floor_area'] != ''
		){
			$floor_area = sanitize_text_field($_REQUEST['floor_area']);
		}
		$deliveryLine = '';
		if(
			sanitize_text_field(isset($search['deliveryLine']))
			&&  $search['deliveryLine'] != ''
		){
			$deliveryLine = sanitize_text_field($search['deliveryLine']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['deliveryLine']))
			&& $_REQUEST['deliveryLine'] != ''
		){
			$deliveryLine = sanitize_text_field($_REQUEST['deliveryLine']);
		}
		
		$map_boundaries = array();
		if( isset($search['map_boundaries']) ){
			$map_boundaries = $search['map_boundaries'];
		}
		$city = '';
		if( !$this->has_search_query_city ){
			if( isset($search['city']) ){
				$city = $search['city'];
			}
			if( isset($search['cityid']) ){
				$city = $search['cityid'];
			}
		}
	
		$state = '';
		if( isset($search['state']) ){
			$state = $this->search_query_state_id($search['state']);
		}

		$zip = '';
		if( isset($search['zip']) ){
			$zip = $this->search_query_zip($search['zip']);
		}
		
		$bath = '';
		if(
			sanitize_text_field(isset($search['bathrooms']))
			&&  $search['bathrooms'] != ''
		){
			$bath = sanitize_text_field($search['bathrooms']);
			$bath = '>='.$bath;
		}elseif(
			sanitize_text_field(isset($_REQUEST['bathrooms']))
			&& $_REQUEST['bathrooms'] != ''
		){
			$bath = sanitize_text_field($_REQUEST['bathrooms']);
			$bath = '>='.$bath;
		}
		

		$bed = '';
		if(
			sanitize_text_field(isset($search['bedrooms']))
			&&  $search['bedrooms'] != ''
		){
			$bed = sanitize_text_field($search['bedrooms']);
			$bed = '>='.$bed;
		}elseif(
			sanitize_text_field(isset($_REQUEST['bedrooms']))
			&& $_REQUEST['bedrooms'] != ''
		){
			$bed = sanitize_text_field($_REQUEST['bedrooms']);
			$bed = '>='.$bed;
		}
		

		$min_listprice = '';
		if(
			sanitize_text_field(isset($search['min_listprice']))
			&&  $search['min_listprice'] != ''
		){
			$min_listprice = sanitize_text_field($search['min_listprice']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['min_listprice']))
			&& $_REQUEST['min_listprice'] != ''
		){
			$min_listprice = sanitize_text_field($_REQUEST['min_listprice']);
		}
		$max_listprice = '';
		if(
			sanitize_text_field(isset($search['max_listprice']))
			&&  $search['max_listprice'] != ''
		){
			$max_listprice = sanitize_text_field($search['max_listprice']);
		}elseif(
			sanitize_text_field(isset($_REQUEST['max_listprice']))
			&& $_REQUEST['max_listprice'] != ''
		){
			$max_listprice = sanitize_text_field($_REQUEST['max_listprice']);
		}

		if( isset($search['property_type']) && $search['property_type'] != '0'){
			$property_type = $search['property_type'];
		}elseif( isset($_REQUEST['property_type']) && $_REQUEST['property_type'] != '0' ){
			$property_type = $_REQUEST['property_type'];
		}else{
			$property_type = '';
		}
		if( isset($search['list_type']) && $search['list_type'] != '0'){
			$list_type = $search['list_type'];
		}elseif( isset($_REQUEST['list_type']) && $_REQUEST['list_type'] != '0' ){
			$list_type = $_REQUEST['list_type'];
		}else{
			$list_type = mwp_default_list_type();
		}

		if( isset($search['daysonmarket']) && $search['daysonmarket'] != ''){
			$daysonmarket = $search['daysonmarket'];
		}elseif( isset($_REQUEST['daysonmarket']) && $_REQUEST['daysonmarket'] != '' ){
			$daysonmarket = $_REQUEST['daysonmarket'];
		}else{
			$daysonmarket = '';
		}
		if( isset($search['daysonmarket_condition']) && $search['daysonmarket_condition'] != ''){
			$daysonmarket_condition = $search['daysonmarket_condition'];
		}elseif( isset($_REQUEST['daysonmarket_condition']) && $_REQUEST['daysonmarket_condition'] != '' ){
			$daysonmarket_condition = $_REQUEST['daysonmarket_condition'];
		}else{
			$daysonmarket_condition = '';
		}
		$hji_days_on_market = $daysonmarket;
		if( $daysonmarket_condition == 'greater' ){
			$hji_days_on_market = '<=' . $daysonmarket;
		}
		if( $daysonmarket_condition == 'less' ){
			$hji_days_on_market = '<=' . $daysonmarket;
		}
		//order
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
		//order
		
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
			'details'			=> $details,
			'keyword'			=> $keyword,
			'lot_area'			=> $lot_area,
			'lsu'				=> $lsu,
			'floor_area'		=> sanitize_text_field($floor_area),
			'box'				=> $map_boundaries,
			'deliveryLine' 		=> sanitize_text_field($deliveryLine),
			'city'				=> $city,
			'zip'				=> sanitize_text_field($zip),
			'state'				=> sanitize_text_field($state),
			'bathrooms' 		=> sanitize_text_field($bath),
			'bedrooms' 			=> sanitize_text_field($bed),
			'min_listprice' 	=> sanitize_text_field($min_listprice),
			'max_listprice' 	=> sanitize_text_field($max_listprice),
			'list_type'			=> sanitize_text_field($list_type),
			'property_type'		=> sanitize_text_field($property_type),
			'daysonmarket'		=> $hji_days_on_market,
			'orderby'			=> 'listPrice',
			'order_direction'	=> 'desc',
			'limit'				=> sanitize_text_field($limit),
			'page'				=> sanitize_text_field($paged),
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
		$cache_keyword 			= 'homejunction_get_property_' . md5(json_encode($this->search_query_vars));
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
				&& isset($this->get_raw_property_api_data->success)
				&& $this->get_raw_property_api_data->result->total > 0
			){
				$this->has_property = true;
				$count_data_properties = 0;
				$property_index = 0;
				foreach( $this->get_raw_property_api_data->result->listings as $property ){
					$count_data_properties++;
					$p =	new Mwp_HomeJunction_PropertyEntity;
					$p->bind( $property );

					$data_properties[] = $p;
					$data_properties[$property_index]->is = 'get_property_homejunction';
					$property_index++;
				}
				$this->property_data_count 	= $count_data_properties;
				$this->property_data_total 	= $this->get_raw_property_api_data->result->total;
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
					if( isset($property->id ) ){
						$property_id 	= $property->id;
						$cache_keyword 	= 'hji_parse_property_details_' . md5($property_id);
						//cache_del($cache_keyword);
						if( mwp_cache_get($cache_keyword) ){
							$this->property_details_data = mwp_cache_get($cache_keyword);
						}else{
							$property_details = $this->hji_mls->listing_by_id($property_id);
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
		//check if hji support images for id only
		return false;
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
					$cache_keyword = 'hji_property_id_' . $p_id;
					//mwp_cache_del($cache_keyword);
					if(  mwp_cache_get($cache_keyword) ){
						$property_data = mwp_cache_get($cache_keyword);
						if( isset($property_data[$property_index]) ){
							$this->property_data[$property_index] = $property_data[$property_index];
							if( isset($property_data[$property_index]->photos) ){
								$this->property_data[$property_index]->photos = $property_data[$property_index]->photos;
								$this->property_details_image_data = $property_data[$property_index]->photos;
							}
							$this->property_data[$property_index]->is = 'single_property_hji';
							$this->property_data[$property_index]->is_id = 'single_property_hji_' . $p_id;
							$property_index++;
						}
					}else{
						$p_data = $this->hji_mls->listing_by_id( $p_id );
						if(
							$p_data
							&& isset($p_data->success)
							&& $p_data->success
						){
							$this->property_id_raw_data = $p_data;
							$property_data = $p_data->result->listings[0];
							$p =	new Mwp_HomeJunction_PropertyEntity;
							$p->bind( $property_data );
														
							$this->property_data[$property_index] = $p;

							if( isset($property_data->images) ){
								$images = $property_data->images;
								$this->property_data[$property_index]->photos = $images;
								if(count($images)){
									$this->has_property_details_image = true;
									$this->property_details_image_data = $this->property_data[$property_index]->photos;
								}
							}

							$mls_type	= '';
							if( isset($property_data->market) ){
								$mls_type	= $property_data->market;
							}
							$listing_id = 0;
							if( isset($property_data->id) ){
								$listing_id = $property_data->id;
							}
							$last_mls_update = '';
							if( isset($property_data->modifiedDate) ){
								$last_mls_update = $property_data->modifiedDate;
							}
							$this->property_data[$property_index]->mls_type = $mls_type;
							$this->property_data[$property_index]->last_mls_update = $last_mls_update;
							$this->property_data[$property_index]->listing_id = $listing_id;
							$this->property_data[$property_index]->is = 'single_property_hji';
							$this->property_data[$property_index]->is_id = 'single_property_hji_' . $p_id;
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
				$cache_id = 'hji_'.$this->property_data[0]->is_id.'_photos';
			}
			$cache_keyword = $cache_id;
			if(  mwp_cache_get($cache_keyword) ){
				$img_array = mwp_cache_get($cache_keyword);
			}else{
				foreach($this->property_details_image_data as $key => $val){
					$img_array[] = $val;
				}
				mwp_cache_set($cache_keyword, $img_array);
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
			$this->get_raw_property_api_data = $this->hji_mls->listings($this->search_query_vars);
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
		$this->property_source = mwp_hji_prefix();
		if( !empty($query) ){
			$this->masterdigm_api();
			$this->query($query);
		}
	}
}
