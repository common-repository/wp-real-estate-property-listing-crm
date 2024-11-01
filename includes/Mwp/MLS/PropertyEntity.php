<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Handle logic for fetching properties
 * */
class Mwp_MLS_PropertyEntity{

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

	/**
	 * Bind a Property taken from API to this object
	 */
	public function bind( $property ){
		foreach( get_object_vars( $property )  as $k => $v ){
			$this->$k = $v;
		}
		return $this;
	}

	public function __get( $argument ){
		return NULL;
	}

	public function hasProperty( $name ) {
        return array_key_exists( $name, get_object_vars( $this ) );
    }


	public function address(){}

	public function city(){
		return $this->City;
	}

	public function state(){
		return $this->State;
	}

	public function subdivision(){
		return $this->Subdivision;
	}

	public function postal_code(){
		return $this->PostalCode;
	}

	public function zip(){}

	public function photo_url(){
		return $this->PrimaryPhotoUrl;
	}

	public function description(){
		return $this->Description;
	}
	
	/**
	 * @param integer $word_limit
	 * return string
	 */
	public function get_description( $word_limit = 0 )
	{

		if( $word_limit ){
			return 	Mwp_Helpers_Text::limit_words( $this->Description , $word_limit );
		}

		return $this->Description;
	}
	
	public function price(){
		return $this->ListPrice;
	}

	public function transaction_type(){
		return $this->Transaction;
	}

	public function property_type(){
		return $this->Type;
	}

	public function property_sub_type(){
		return $this->PropertySubType;
	}

	public function property_status(){
		return $this->Status;
	}

	public function lot_area(){
		return $this->LotArea;
	}

	public function floor_area(){
		return $this->FloorArea;
	}

	public function params(){
		return $this->params;
	}
	
	public function get_sqft_heated(){
		return isset($this->FloorArea) ? number_format($this->FloorArea,2) : 0;
	}
	
	public function bed(){
		return $this->Bedrooms;
	}

	public function bath(){
		return $this->Baths;
	}

	public function bath_half(){
		return $this->BathsHalf;
	}

	public function bath_full(){
		return $this->BathsFull;
	}

	public function year_built(){
		return $this->YearBuilt;
	}

	public function mlsid(){
		return $this->MLSID;
	}

	public function get_mls(){
		return $this->mlsid();
	}

	public function garage(){
		return $this->Garage;
	}

	public function id(){
		return $this->ListingId;
	}

	public function latitude(){
		return $this->Latitude;
	}

	public function longitude(){
		return $this->Longitude;
	}

	public function posted_at(){
		return $this->TimestampModified;
	}

	public function time_stamp_modified(){
		return $this->TimestampModified;
	}

	public function property_id(){
		return $this->Propertyid;
	}

	public function street_name(){
		return $this->StreetName;
	}

	public function street_number(){
		return $this->StreetNumber;
	}

	public function street_suffix(){
		return $this->StreetSuffix;
	}

	public function county(){
		return $this->County;
	}

	public function fireplace(){
		return $this->Fireplace;
	}

	public function heating(){
		return $this->Heating;
	}

	public function flooring(){
		return $this->Flooring;
	}

	public function airconditioning(){
		return $this->Airconditioning;
	}
	public function appliances(){
		return $this->Appliances;
	}
	public function construction(){
		return $this->Construction;
	}
	public function foundation(){
		return $this->Foundation;
	}
	public function garage_features(){
		return $this->GarageFeatures;
	}
	public function exterior_features(){
		return $this->ExteriorFeatures;
	}
	public function roof(){
		return $this->Roof;
	}
	public function utilities(){
		return $this->Utilities;
	}
	public function pool(){
		return $this->Pool;
	}
	public function pool_type(){
		return $this->PoolType;
	}
	public function listing_office(){
		return $this->ListingOffice;
	}
	public function listing_agent_full_name(){
		return $this->ListingAgentFullName;
	}

	public function LO_Code(){
		return $this->LO_Code;
	}
	public function tax(){
		return $this->Tax;
	}
	public function tax_year(){
		return $this->TaxYear;
	}

	public function get_primary_photo($type = 'low_res', $property_photos = null){
		$url = '';
		if( !is_null($property_photos) ){
			$url = $property_photos;
		}else{
			if( isset( $this->PrimaryPhotoUrl ) || $this->PrimaryPhotoUrl ){
				$url = substr( $this->PrimaryPhotoUrl , 0 ,4 ) == 'http' ? $this->PrimaryPhotoUrl : 'http://www.masterdigmserver1.com/'.$this->PrimaryPhotoUrl;
			}
		}
		return $url;
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

	public function get_address($type = 'long'){
		$address = '';
		
		$state 			= strlen( $this->State ) == 2 ? strtoupper( $this->State ) : $this->State;
		$street_suffix	= strlen( $this->StreetSuffix ) < 3 ? strtoupper( $this->StreetSuffix ) : $this->StreetSuffix;
		$street_name 	= ucwords( strtolower( $this->StreetName ) ).' '.$street_suffix;

		switch( $type ){
			default:
			case 'long':
				$address = $this->StreetNumber.' '.$street_name.' '.$this->City.', '.$state.' '.$this->PostalCode;
			break;
			case 'short':
				$address = $this->StreetNumber.' '.$street_name.' '.$this->City;
			break;
			case 'tiny':
				$address = $this->StreetNumber.' '.$street_name;
			break;
		}
		
		return Mwp_Helpers_Text::remove_non_alphanumeric($address);
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
	
	public function html_floor_area(){
		$unit_area = $this->area_unit('account');
		return $this->get_floor_area() .' '. $unit_area;
	}

	public function html_lot_area(){
		$unit_area = $this->area_unit('account');
		return $this->get_lot_area() .' '. $unit_area;
	}
	public function get_lot_area(){
		return number_format($this->lot_area());
	}
	public function get_floor_area(){
		return number_format($this->floor_area());
	}
	public function area_measurement($type){
		$area = '';
		$measure_area = 0;
		$array_measure = array();
		$unit_area = Mwp_CRM_AccountDetails::get_instance()->get_account_data('unit_area');
		$by = ($this->floor_area() == 0) ? 'lot':'floor';
		switch($type){
			case 'floor':
				$array_measure = array(
					'area_type'		=>	$unit_area,
					'by'			=>	$type,
					'raw_measure'	=>	$this->floor_area(),
					'measure'		=>	number_format($this->floor_area())
				);
			break;
			case 'lot':
				$array_measure = array(
					'area_type'		=>	$unit_area,
					'by'			=>	$type,
					'raw_measure'	=>	$this->lot_area(),
					'measure'		=>	number_format($this->lot_area())
				);
			break;
			default:
				if( $this->floor_area == 0 ){
					$area = $this->lot_area();
				}else{
					$area = $this->floor_area();
				}
				$array_measure = array(
					'area_type'		=>	$unit_area,
					'by'			=>	$by,
					'raw_measure'	=>	$area,
					'measure'		=>	number_format($area,2)
				);

			break;
		}
		return (object)$array_measure;
	}
	
	public function tag_line(){
		if( isset($this->tag_line) ){
			return $this->tag_line;
		}
		return $this->get_address();
	}
	
	public function get_params(){
		return false;
	}

	public function get_property_url(){
		$address 			= str_replace(' ','-',$this->get_address());
		$second_uri 		= $address;
		$urlencoded_address = urlencode( preg_replace("/[^A-Za-z0-9 \-]/", '', $this->ListingId . '-' . $second_uri . '-mls' ) );
		return $urlencoded_address;
	}
	/*
	* Use for check if the property status is 'Active' , 'Backup Offer' , 'Pending Sale'
	* return boolean
	* */
	public function display_property()
	{
		$status = array( 'Active' , 'Backup Offer' , 'Pending Sale' );

		if( in_array($this->property_status(), $status) ){
			return true;
		}
	}
	
	//single
	public function single_photos(){
		if( $this->get_property_photo() ){
			return $this->get_property_photo();
		}
	}
	
	public function agent(){
		return array();
	}
	
	public function get_mlsid(){
		return $this->MLSID ? $this->MLSID:$this->ListingId;
	}
	
	public function get_county_name(){
		return $this->County;
	}

	public function get_city(){
		return $this->City;
	}

	public function get_city_name(){
		return $this->City;
	}

	public function get_state_name(){
		return $this->State;
	}

	public function get_property_id(){
		return $this->Propertyid;
	}

	public function get_listing_id(){
		return $this->Propertyid;
	}

	public function display_garage(){
		return $this->Garage;
	}

	public function display_air_conditioning(){
		return $this->Airconditioning;
	}

	public function display_heat_air_conditioning(){
		return $this->Airconditioning;
	}

	public function display_appliances_included(){
		return $this->Appliances;
	}

	public function display_architectural_style(){
		return $this->ArchitecturalStyle;
	}

	public function display_association_fee_includes(){
		return $this->AssociationFeeIncludes;
	}

	public function display_bath_full(){
		return $this->Baths;
	}

	public function display_bath_half(){
		return $this->BathsHalf;
	}

	public function display_bed_total(){
		return $this->Bedrooms;
	}

	public function display_close_date(){
		return $this->CloseDate;
	}

	public function display_close_price(){
		return $this->ClosePrice;
	}

	public function display_community_features(){
		return $this->CommunityFeatures;
	}

	public function display_county_or_parish(){
		return $this->County;
	}

	public function display_current_price(){
		return $this->ListPrice;
	}

	public function display_elem_school(){
		return $this->ElementarySchool;
	}

	public function display_exterior_construction(){
		return $this->Construction;
	}

	public function display_exterior_features(){
		return $this->ExteriorFeatures;
	}

	public function display_fences(){
		return $this->Fences;
	}

	public function display_fireplace_yn(){
		return $this->Fireplace;
	}

	public function display_floor_covering(){
		return $this->Flooring;
	}

	public function display_foundation(){
		return $this->Foundation;
	}

	public function displayGarage(){
		return $this->Garage;
	}

	public function display_garage_carport(){
		return $this->Garage;
	}

	public function display_garage_features(){
		return $this->GarageFeatures;
	}

	public function display_heating_fuel(){
		return $this->Heating;
	}

	public function display_high_school(){
		return $this->HighSchool;
	}

	public function display_housing_for_older_person(){
		return $this->HousingForOlderPersons;
	}

	public function display_interior_features(){
		return $this->InteriorFeatures;
	}

	public function display_interior_layout(){
		return $this->InteriorLayout;
	}

	public function display_kitchen_features(){
		return $this->KitchenFeatures;
	}

	public function community(){
		if( isset($this->Community) ){
			return $this->Community;
		}else{
			return $this->Subdivision;
		}
	}

	public function display_legal_subdivision_name(){
		return $this->LegalSubdivisionName;
	}

	public function display_list_office_name(){
		return $this->ListingOffice;
	}

	public function display_lot_size_acres(){
		return isset($this->LotSizeAcres) ? $this->LotSizeAcres : $this->Area;
	}

	public function display_lot_size_sqft(){
		return $this->LotArea;
	}

	public function display_maintenance_includes(){
		return $this->MaintenanceIncludes;
	}

	public function display_middleor_junior_school(){
		return $this->MiddleorJuniorSchool;
	}

	public function display_mls_number(){
		return $this->MLSID;
	}

	public function display_pool(){
		return $this->Pool;
	}

	public function display_pool_type(){
		return $this->PoolType;
	}

	public function display_postal_code(){
		return $this->PostalCode;
	}

	public function display_property_type(){
		if( isset($this->PropertyTypeNumber) ){
			return \mls\AccountEntity::get_instance()->get_property_type_key($this->PropertyTypeNumber);
		}else{
			return $this->Type;
		}
	}

	public function display_public_remarks_new(){
		return $this->PublicRemarksNew;
	}

	public function display_roof(){
		return $this->Roof;
	}

	public function display_sqft_heated(){
		return $this->FloorArea;
	}

	public function display_sqft_total(){
		return $this->SqFtTotal;
	}

	public function display_state_or_province(){
		return $this->State;
	}

	public function display_status(){
		return $this->Status;
	}

	public function display_street_city(){
		return $this->StreetCity;
	}

	public function display_tax_year(){
		return $this->TaxYear;
	}

	public function display_taxes(){
		$currency 		= mwp_get_account_currency();
		$get_currency 	= ($currency) ? $currency:'$';
		$taxes = 0;
		if( isset($this->Tax) ){
			$taxes = $this->Tax;
		}
		return $get_currency.number_format( $taxes );
	}

	public function display_total_acreage(){
		return $this->TotalAcreage;
	}

	public function display_utilities(){
		return $this->Utilities;
	}

	public function display_virtual_tour_link(){
		return $this->VirtualTourLink;
	}

	public function display_virtual_tour_link2(){
		return $this->VirtualTourURL2;
	}

	public function display_water_frontage(){
		return $this->WaterFrontage;
	}

	public function display_water_frontage_yn(){
		return $this->WaterFrontageYN;
	}

	public function legal_subdivision_name(){
		return isset($this->LegalSubdivisionName) ? $this->LegalSubdivisionName : $this->Subdivision;
	}

	public function hoa(){
		if( isset($this->HOA) ){
			return $this->HOA == 0 ? 'Yes':'No';
		}elseif( isset($this->HOACommonAssn) ){
			return $this->HOACommonAssn == 'Required' ? 'Yes':'No';
		}
	}

	public function display_listing_office(){
		return $this->ListingOffice;
	}

	public function getPhotoUrl($array, $key = 0, $object = 'url'){
		$data = array();
		if( $array && is_array($array) && count($array) > 0 ){
			if( isset($array[$key]->$object) ){
				$data[] = $array[$key]->$object;
			}
			return $data;
		}else{
			return array();
		}

	}
	public function assigned_to(){
		return 0;
	}
	
	public function pricing_period(){
		return '';
	}
}
