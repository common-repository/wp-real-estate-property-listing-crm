<?php
/**
 * Handle logic for fetching properties
 * */
class Mwp_Flexmls_PropertyEntity{
	protected static $instance = null;
	public $standard_fields = null;
	public function __construct(){

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *ad
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

	public function remove_asterisk($string = ''){
		return preg_replace('/[\*]+/', '', $string);
	}

	/**
	 * Bind a Property taken from API to this object
	 */
	public function bind( $property )
	{
		foreach( $property as $k => $v ){
			$this->$k = $v;
		}
		return $this;
	}

	public function array_implode($data){
		if( is_array($data) ){
			$get_key = array_keys($data);
			return implode(", ", $get_key);
		}
		return '';
	}

	public function set_standard_fields(){
		$this->standard_fields = $this->StandardFields;
	}

	public function get_standard_fields(){
		return $this->standard_fields;
	}

	public function listing_key(){
		if(isset($this->ListingKey)){
			return $this->ListingKey;
		}
		return false;
	}

	public function id(){
		return $this->listing_id();
	}

	public function listing_id(){
		if( isset($this->ListingId) ){
			return $this->ListingId;
		}
	}

	/**
	 * @param string $type
	 * 		- type can be long or short. Long address has zip on it
	 * return string
	 */
	public function get_address($type = 'long')
	{
		return $this->UnparsedAddress;
	}

	public function get_property_url(){
		$address = str_replace(' ','-',$this->get_address());
		$second_uri = $address;
		$urlencoded_address = urlencode( preg_replace("/[^A-Za-z0-9 \-]/", '', $this->listing_id() . '-' . $second_uri . '-flexmls' ) );
		return $urlencoded_address;
	}

	public function floor_area(){
		return $this->LivingArea;
	}

	public function lot_area(){
		if( isset($this->LotSizeSquareFeet) ){
			return $this->LotSizeSquareFeet;
		}
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
	
	public function get_floor_area(){
		return number_format($this->floor_area());
	}
	public function area_measurement($type){
		$area = 0;
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
				if( $this->floor_area() == 0 ){
					$area = $this->lot_area();
				}else{
					$area = $this->floor_area();
				}
				if( is_string($area) ){
					$area = 0;
				}
				$array_measure = array(
					'area_type'		=>	$unit_area,
					'by'			=>	$by,
					'raw_measure'	=>	$area,
					'measure'		=>	number_format($area)
				);
			break;
		}
		return (object)$array_measure;
	}

	public function bed(){
		return $this->remove_asterisk($this->BedsTotal);
	}
	
	public function get_mlsid(){
		return $this->get_mls();
	}

	public function get_mls(){
		return $this->listing_id();
	}

	public function bath(){
		if( isset($this->BathroomsTotalNotational) ){
			return $this->remove_asterisk($this->BathroomsTotalNotational);
		}
		return 0;
	}

	public function garage(){
		return $this->GarageYN ? $this->GarageYN:0;
	}

	public function price(){
		return $this->ListPrice;
	}

	public function get_primary_photo($get_img_size = 'Uri640'){
		$photos = $this->Photos;
		if( isset($photos[0]) ){
			return $photos[0][$get_img_size];
		}
		return false;
	}

	public function get_photo_url($array, $key = 0){
		$data = array();
		$photo = $this->flexmls_photos();
		$data = array($photo);
		return $data;
	}

	public function flexmls_all_photos(){
		if( isset($this->Photos) ){
			return $this->Photos;
		}
	}

	public function transaction_type()
	{
		return 'For Sale';
	}

	public function displaySqFt(){
		return $this->displayFloorArea();
	}

	public function displayFloorArea(){
		return number_format($this->floor_area(),2);
	}

	public function displayAreaUnit( $type = '' ){
		$unit = '';
		$unit_area = Mwp_CRM_AccountDetails::get_instance()->get_account_data('unit_area');
		return $unit;
	}

	public function displayPrice()
	{
		$account  = Mwp_CRM_AccountDetails::get_instance()->get_account_data();
		$get_currency = ($account->currency) ? $account->currency:'$';
		if( $this->price() == 0 ){
			$price = "Call for pricing ".$account->work_phone;
			return $price;
		}else{
			return $get_currency.number_format( $this->price(),2 );
		}
	}

	public function property_type(){
		return $this->PropertyType;
	}

	public function displayPropertyType(){
		$type = Mwp_Flexmls_Adapter::get_instance()->get_property_type();
		$p_type = $this->property_type();
		return $type[$p_type];
	}

	public function displayPropertyStatus(){
		return 'Active';
	}

	public function property_status(){
		return $this->displayPropertyStatus();
	}

	public function get_sqft_heated(){
		return $this->floor_area() ? number_format($this->floor_area()) : 0;
	}
	
	public function get_city_name(){
		return $this->get_address();
	}

	public function address(){
		return $this->get_address();
	}

	public function latitude(){
		return $this->Latitude;
	}

	public function longitude(){
		return $this->Longitude;
	}

	public function displayParams($val = null){
		return '';
	}

	/**
	 * @param integer $word_limit
	 * return string
	 */
	public function displayDescription( $word_limit = 0 )
	{
		$desc = $this->PublicRemarks;
		if( $word_limit ){
			return 	Mwp_Helpers_Text::limit_words( strip_tags($desc) , $word_limit );
		}
		return $desc;
	}
	
	public function description(){
		$this->get_description();
	}

	public function get_description( $word_limit = 0 ){
		$desc = $this->PublicRemarks;
		if( $word_limit ){
			$desc = preg_replace('/(\s)+/', ' ', $desc);
			$desc = ereg_replace("[^A-Za-z0-9]", "", $desc );
			$desc = strip_tags($desc);

			return Mwp_Helpers_Text::limit_words( $desc , $word_limit );
		}
	}

	public function year_built(){
		return $this->YearBuilt;
	}

	public function get_lot_area(){
		return ($this->lot_area() != '') ? number_format($this->lot_area()):0;
	}

	public function get_county_name(){
		return $this->CountyOrParish;
	}

	public function hoa(){
		return 'No';
	}

	public function community(){
		return $this->SubdivisionName;
	}

	public function display_interior_features(){
		if( is_array($this->InteriorFeatures) ){
			return $this->array_implode($this->InteriorFeatures);
		}else{
			return $this->InteriorFeatures;
		}
	}

	public function display_fireplace_yn(){
		return $this->FireplacesTotal;
	}

	public function display_heating_fuel(){
		return $this->Heating;
	}

	public function display_floor_covering(){
		return $this->Flooring;
	}

	public function display_bath_full(){
		return $this->bath();
	}

	public function display_air_conditioning(){
		return '';
	}

	public function display_heat_air_conditioning(){
		return '';
	}

	public function display_appliances_included(){
		$appliances = $this->array_implode($this->Inclusions);
		$kitchen = $this->display_kitchen_appliances();
		return $appliances .', '. $kitchen;
	}

	public function display_kitchen_appliances(){
		return $this->array_implode($this->KitchenAppliances);
	}

	public function display_exterior_construction(){
		return $this->ConstructionMaterials;
	}

	public function display_foundation(){
		return $this->FoundationDetails;
	}

	public function display_garage_features(){
		return $this->GarageSpaces;
	}

	public function display_garage_carport(){
		return $this->GarageYN;
	}

	public function display_lot_size_sqft(){
		return $this->lot_area();
	}

	public function display_exterior_features(){
		return $this->array_implode($this->ExteriorFeatures);
	}

	public function display_roof(){
		return $this->Roof;
	}

	public function display_utilities(){
		return $this->Utilities;
	}

	public function display_lot_size_acres(){
		return isset($this->LotSizeAcres) ? $this->LotSizeAcres : $this->lot_area();
	}

	public function display_water_frontage_yn(){
		return '';
	}

	public function display_pool(){
		if( $this->display_pool_type() != '' ){
			return 'Yes';
		}
	}

	public function display_pool_type(){
		return $this->array_implode($this->PoolFeatures);
	}

	public function display_property_type(){
		$this->displayPropertyType();
	}

	public function display_taxes(){
		$currency 		= Mwp_CRM_AccountDetails::get_instance()->get_account_data('currency');
		$get_currency 	= ($currency) ? $currency:'$';
		$taxes = 0;
		if( isset($this->TaxAmount) ){
			$taxes = $this->TaxAmount;
		}
		return $get_currency.number_format( $taxes,2 );
	}

	public function display_tax_year(){
		return $this->TaxYear;
	}

	public function display_listing_office(){
		return $this->ListOfficeId;
	}

	public function city(){
		return $this->City;
	}

	public function debug(){
		echo '<pre>';
			echo 'country : '.$this->countryid.':'.$this->country.'<br>';
			echo 'county : '.$this->countyid.':'.$this->county.'<br>';
			echo 'state : '.$this->stateid.':'.$this->state.'<br>';
			echo 'city : '.$this->cityid.':'.$this->city.'<br>';
			echo 'community : '.$this->communityid.':'.$this->community.'<br>';
		echo '</pre>';
	}

	public function posted_at(){
		return $this->ModificationTimestamp;
	}
	
	public function tag_line(){
		return $this->get_address();
	}

	public function get_params(){
		return false;
	}
	
	public function agent(){
		return array();
	}
	
	public function assigned_to(){
		return 0;
	}
	
	public function get_custom_fields(){
		//return $this->get_custom_fields();
	}
}
