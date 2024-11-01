<?php
/**
 * Handle logic for fetching properties
 * */
class Mwp_HomeJunction_PropertyEntity{
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

	public function id(){
		if(isset($this->id)){
			return $this->id;
		}
	}
	
	public function address(){
		if( isset($this->address) ){
			return $this->address;
		}
		return '';
	}

	public function city(){
		if( isset($this->address->city) ){
			return $this->address->city;
		}
		return '';
	}

	public function state(){
		if( isset($this->address->state) ){
			return $this->address->state;
		}	
		return '';
	}

	public function street(){
		if( isset($this->address->street) ){
			return $this->address->street;
		}
		return '';
	}
	
	public function zip(){
		if(isset($this->address->zip)){
			return $this->address->zip;
		}
	}
	
	public function market(){
		if( isset($this->address->market) ){
			return $this->address->market;
		}
	}

	public function deliveryLine(){
		if( isset($this->address->deliveryLine) ){
			return $this->address->deliveryLine;
		}
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
			case 'short':
			case 'tiny':
				$name = $this->deliveryLine();
			break;
			default:
			case 'long':
				$name = $this->street().', '.$this->city().', '.$this->state().', '.$this->zip();
			break;
		}
		return $name;
	}

	public function get_property_url(){
		$address = str_replace(' ','-',$this->get_address());
		$second_uri = $address;
		$prefix = mwp_hji_prefix();
		$urlencoded_address = urlencode( preg_replace("/[^A-Za-z0-9 \-]/", '', $this->id() . '-' . $second_uri . '-' . $prefix ) );
		return $urlencoded_address;
	}

	public function floor_area(){
		if( isset($this->size) ){
			return $this->size;
		}
		return 0;
	}
	
	public function get_sqft_heated(){
		return $this->floor_area();
	}
	
	public function lotsize(){
		return $this->lotSize;
	}

	public function lotsize_sqft(){
		if( isset($this->lotSize->sqft) ){
			return $this->lotSize->sqft;
		}
		return 0;
	}

	public function lotsize_acres(){
		return $this->lotSize->acres;
	}
	
	public function lot_area(){
		return $this->lotsize_sqft();
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
	public function get_floor_area(){
		return number_format($this->floor_area());
	}
	public function html_lot_area(){
		$unit_area = $this->area_unit('account');
		return $this->get_lot_area() .' '. $unit_area;
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
					'measure'		=>	number_format($area,2)
				);
			break;
		}
		return (object)$array_measure;
	}
	
	public function bed(){
		if( isset($this->beds) ){
			return $this->beds;
		}
		return 0;
	}
	
	public function baths(){
		if( isset($this->baths) ){
			return $this->baths;
		}
		return 0;
	}
	
	public function baths_total(){
		if( isset($this->baths) ){
			return $this->baths->total;
		}
		return 0;
	}
	
	public function baths_full(){
		if( isset($this->baths) ){
			return $this->baths->full;
		}
		return 0;
	}
	
	public function baths_half(){
		return $this->baths->half;
	}
		
	public function bath(){
		return $this->baths_total();
	}

	public function garage(){
		return 0;
	}

	public function price(){
		if(isset($this->listPrice)){
			return $this->listPrice;
		}
		return 0;
	}
	
	public function images(){
		if( isset($this->images) ){
			return $this->images;
		}
		return false;
	}
	
	public function get_primary_photo(){
		$photos = $this->images();
		if( isset($photos[0]) ){
			return $photos[0];
		}
		return false;
	}
	
	public function days_on_hji(){
		if( isset($this->daysOnHJI) ){
			return $this->daysOnHJI;
		}
	}
	
	public function transaction_type()
	{
		if( isset($this->status) ){
			return $this->status;
		}
		return 'For Sale';
	}
	
	public function displayPrice()
	{
		$account  = Mwp_CRM_AccountDetails::get_instance()->get_account_data();
		$get_currency = ($account->currency) ? $account->currency:'$';
		if( $this->price() == 0 ){
			$price = "Call for pricing ".$account->work_phone;
			return $price;
		}else{
			return $get_currency.number_format( $this->price(), 2);
		}
	}

	public function property_type(){
		if( isset($this->propertyType) ){
			return $this->propertyType;
		}
	}

	public function displayPropertyStatus(){
		if( isset($this->status) ){
			return $this->status;
		}
	}

	public function property_status(){
		return $this->displayPropertyStatus();
	}
	
	public function latitude(){
		return $this->coordinates->latitude;
	}

	public function longitude(){
		return $this->coordinates->longitude;
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
		return $this->description;
	}
	
	public function description(){
		if( isset($this->description) ){
			return $this->description;
		}
	}

	public function get_description( $word_limit = 0 ){
		return $this->description();
	}

	public function year_built(){
		if( isset($this->yearBuilt) ){
			return $this->yearBuilt;
		}
	}

	public function get_lot_area(){
		return ($this->lot_area() != '') ? number_format($this->lot_area(), 2):0;
	}
	
	public function posted_at(){
		if( isset($this->listingDate) ){
			return $this->listingDate;
		}
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
		return false;
	}
	
	public function features(){
		if( isset($this->features) ){
			return $this->features;
		}
		return false;
	}
	
	public function last_mls_update(){
		if( isset($this->modifiedDate) ){
			return $this->modifiedDate;
		}
	}
	public function get_mlsid(){
		return $this->get_mls();
	}
	public function get_mls(){
		if(isset($this->xf_mlnumber) ){
			return $this->xf_mlnumber;
		}
		return $this->id();
	}
	
	public function tour_url(){
		if(isset($this->tourURL)){
			return $this->tourURL;
		}
	}
}
