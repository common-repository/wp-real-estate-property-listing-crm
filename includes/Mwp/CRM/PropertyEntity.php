<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Handle logic for fetching properties
 * */
class Mwp_CRM_PropertyEntity{

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

	public function __get( $argument ){
		return NULL;
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

	public function community(){
		return trim($this->community);
	}

	public function address(){
		return $this->address;
	}

	public function city(){
		return $this->city;
	}

	public function cityid(){
		return $this->cityid;
	}

	public function stateid(){
		return $this->stateid;
	}
	
	public function communityid(){
		return $this->communityid;
	}

	public function subdivisionid(){
		return $this->subdivisionid;
	}

	public function state(){
		return $this->state;
	}

	public function zip(){
		return $this->zip;
	}

	public function tag_line(){
		return $this->tag_line;
	}

	public function photo_url(){
		return $this->photo_url;
	}

	public function description(){
		return $this->description;
	}

	public function price(){
		return $this->price;
	}

	public function transaction_type(){
		return $this->transaction_type ? $this->transaction_type:false;
	}

	public function property_type(){
		return $this->property_type;
	}

	public function property_types(){
		return $this->property_types;
	}

	public function property_status(){
		return $this->property_status;
	}

	public function lot_area(){
		return $this->lot_area;
	}

	public function floor_area(){
		return $this->floor_area;
	}

	public function floor_area_unit(){
		return $this->floor_area_unit;
	}

	public function lot_area_unit(){
		return $this->lot_area_unit;
	}

	public function params(){
		return $this->params;
	}

	public function bed(){
		return $this->beds;
	}

	public function bath(){
		return $this->baths;
	}

	public function year_built(){
		return $this->year_built;
	}

	public function agent(){
		return $this->agent;
	}

	public function mlsid(){
		return $this->mlsid;
	}
	
	public function get_mls(){
		return $this->mlsid() ? $this->mlsid():$this->id();
	}

	public function garage(){
		return $this->garage;
	}

	public function id(){
		return $this->id;
	}

	public function idx(){
		return $this->idx;
	}

	public function latitude(){
		return $this->latitude;
	}

	public function longitude(){
		return $this->longitude;
	}

	public function posted_at(){
		return $this->posted_at;
	}
	
	public function get_floor_area(){
		return number_format($this->floor_area());
	}
	
	public function html_floor_area(){
		$account_data = mwp_get_account_data();
		$unit_area = $account_data->unit_area;
		if( trim($this->floor_area_unit()) != '' ){
			$unit_area = $this->floor_area_unit();
		}
		return $this->get_floor_area() .' '. $unit_area;
	}

	public function html_lot_area(){
		$account_data = mwp_get_account_data();
		if( $account_data && isset($account_data->unit_area) ){
			$unit_area = $account_data->unit_area;
			if( trim($this->lot_area_unit()) != '' ){
				$unit_area = $this->lot_area_unit();
			}
			return $this->get_lot_area() .' '. $unit_area;
		}
		return false;
	}

	public function get_lot_area(){
		return number_format($this->lot_area());
	}
	
	public function area_measurement($type){
		$area = '';
		$measure_area = 0;
		$array_measure = array();
		$account_data = mwp_get_account_data();
		$unit_area = $account_data->unit_area;
		$by = ($this->floor_area() == 0) ? 'lot':'floor';

		$array_measure['area_type'] = $unit_area;
		$array_measure['by'] = $type;
		
		switch($type){
			case 'floor':
				$array_measure['raw_measure'] = $this->floor_area();
				$array_measure['measure'] = number_format($this->floor_area());
			break;
			case 'lot':
				$array_measure['raw_measure'] = $this->lot_area();
				$array_measure['measure'] = number_format($this->lot_area());
			break;
			default:
				if( $this->floor_area() == 0 ){
					$area = $this->lot_area();
				}else{
					$area = $this->floor_area();
				}
				$array_measure['raw_measure'] = $area;
				$array_measure['by'] = $by;
				$array_measure['measure'] = number_format($area);
			break;
		}
		return (object)$array_measure;
	}

	/**
	 * @param string $type
	 * 		- type can be long or short. Long address has zip on it
	 * return string
	 */
	public function get_address($type = 'long')
	{
		$name = '';
		switch( $type ){
			default:
			case 'long':
				$community = $this->community() . ' ';
				if( trim($community) == '' ){
					$community = '';
				}
				$address = $this->address() . ', ';
				if( trim($address) == '' ){
					$address = '';
				}
				$city = $this->city() . ', ';
				if( trim($city) == '' ){
					$city = '';
				}
				$state = $this->state() . ', ';
				if( trim($state) == '' ){
					$state = '';
				}
				$zip = $this->zip();
				if( trim($zip) == '' ){
					$zip = '';
				}
				$name = $community . $address . $city . $state . $zip;
			break;
			case 'short':
				$name = $this->address();
			break;
			case 'tiny':
				$name = $this->address();
			break;
		}
		return rtrim($name, ', ');
	}
	
	public function area_unit( $type = 'floor' ){
		$unit = '';
		$unit_area = Mwp_CRM_AccountDetails::get_instance()->get_account_data('unit_area');
		switch($type){
			case 'floor':
				$unit = $this->floor_area_unit();
			break;
			case 'lot':
				$unit = $this->lot_area_unit();
			break;
			case 'account':
				$unit = $unit_area;
			break;
		}
		return $unit;
	}

	public function get_property_status(){
		$status = Mwp_CRM_AccountDetails::get_instance()->get_fields();
		if( $status->result == 'success' || $status->success ){
			$property_status = json_decode(json_encode($status->fields->status), true);
			if( isset($property_status[$this->property_status]) ){
				return $property_status[$this->property_status];
			}
		}
		return false;
	}

	public function get_primary_photo(){
		if( $this->photo_url() != '' ){
			return $this->photo_url();
		}
		return false;
	}
	
	/**
	 * return string
	 */
	public function get_property_url(){

		if( Mwp_Settings_Property_DBEntity::get_instance()->get_property_title() == 'tagline' ){
			$tag_line = str_replace(' ','-',$this->tag_line());
			$second_uri = $tag_line;
		}else{
			$address = str_replace(' ','-',$this->get_address());
			$tag_line = str_replace(' ','-',$this->tag_line());
			$second_uri = ($address == '') ? $tag_line:$address;
		}
		
		$urlencoded_address = urlencode( preg_replace("/[^A-Za-z0-9 \-]/", '', $this->id() . '-' . $second_uri . '-crm' ) );
		
		return $urlencoded_address;
	}

	public function get_property_type_label(){
		$type = Mwp_CRM_PropertyFields::get_instance()->get_field_type();
		if( $type ){
			$property_type = json_decode(json_encode($type), true);
			if( isset($property_type[$this->property_type]) ){
				return $property_type[$this->property_type];
			}
		}
		return false;
	}
	public function get_property_status_label(){
		$status = Mwp_CRM_PropertyFields::get_instance()->get_field_status();
		if( $status ){
			$property_status = json_decode(json_encode($status), true);
			if( isset($property_status[$this->property_status]) ){
				return $property_status[$this->property_status];
			}
		}
		return false;
	}
	//single
	public function single_photos(){
		if( $this->get_property_photo() ){
			return $this->get_property_photo();
		}
	}
	public function test_crm(){
		return 'for crm only';
	}
	
	public function get_params($val = null){
		$param = unserialize($this->params);
		if( !is_null($val) && isset($param[$val]) ) {
			return $param[$val];
		}elseif($val == 'all'){
			return $param;
		}
		return false;
	}
	
	public function assigned_to(){
		return $this->assigned_to;
	}
	
	public function flyer_file_key(){
		return $this->flyer_file_key;
	}
	
	public function pricing_period(){
		return $this->pricing_period;
	}
}
