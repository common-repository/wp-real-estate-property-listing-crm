<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function mwp_set_loop($loop = null){
	$GLOBALS['mwp_loop'] = $loop;
}
function mwp_get_data_loop(){
	global $mwp_loop;
	return $mwp_loop->get_data();
}
function mwp_property_id(){
	global $mwp_loop;
	return $mwp_loop->get_data()->id();
}
function mwp_is_display_tag_line(){
	if( Mwp_Settings_Property_DBEntity::get_instance()->get_property_title() == 'tagline' ){
		return true;
	}	
	return false;
}
function mwp_property_title(){
	global $mwp_loop;
	$type = 'long';
	if( Mwp_Settings_Property_DBEntity::get_instance()->get_property_title() == 'tagline' ){
		$title = $mwp_loop->get_data()->tag_line();
	}else{
		$title = $mwp_loop->get_data()->get_address($type);
	}
	return $title;
}
function mwp_html_property_title($type = 'long'){
	global $mwp_loop;
	if( mwp_get_current_api_source() == 'crm' ){
		if( Mwp_Settings_Property_DBEntity::get_instance()->get_property_title() == 'tagline' ){
			$header =  $mwp_loop->get_data()->tag_line();
			$sub_header = $mwp_loop->get_data()->get_address($type);
		}else{
			$sub_header =  $mwp_loop->get_data()->tag_line();
			$header = $mwp_loop->get_data()->get_address($type);
		}
	}else{
		$header = $mwp_loop->get_data()->get_address($type);
		$sub_header = '';
	}
	echo '<h1>';
	echo $header;
		echo ' <br><small>';
			echo $sub_header;
		echo '</small>';
	echo '</h1>';
}
function mwp_raw_property_address($type = 'long'){
	global $mwp_loop;
	$address = str_replace(', ', ' ', $mwp_loop->get_data()->get_address($type));
	return trim(preg_replace('/\s+/', ' ', $address));
}
function mwp_property_address($type = 'long', $echo = TRUE){
	global $mwp_loop;
	if( $echo ){
		echo $mwp_loop->get_data()->get_address($type);
	}else{
		return $mwp_loop->get_data()->get_address($type);
	}
}
function mwp_property_price(){
	global $mwp_loop;
	return $mwp_loop->get_data()->price();
}
function mwp_html_property_price($echo = true){
	if( $echo ){
		echo mwp_get_account_currency() . number_format( mwp_property_price() );
	}else{
		return mwp_get_account_currency() . number_format( mwp_property_price() );
	}
}
function mwp_property_photos(){
	global $mwp_loop;
	$photos = array();
	$property_id = mwp_property_id();
	if( is_array($mwp_loop->property_details_image_data) ){
		$photos = $mwp_loop->property_details_image_data[$property_id];
	}else{
		if( isset($mwp_loop->property_details_image_data->$property_id) ){
			$photos = $mwp_loop->property_details_image_data->$property_id;
		}
	}
	return $photos;
}
function mwp_primary_photo(){
	global $mwp_loop;
	$asset_url = mwp_asset_url();
	$pm_img = $asset_url . 'house.png';
	
	if($mwp_loop->get_data()->get_primary_photo()){
		$pm_img = $mwp_loop->get_data()->get_primary_photo();
	}else{
		$source = mwp_get_current_api_source();
		if( has_filter('mwp_hook_primary_img_' . $source ) && $mwp_loop->get_data()->is == 'featured_property' ){
			$pm_img = apply_filters('mwp_hook_primary_img_' . $source, $mwp_loop, $pm_img, 10, 2);
		}else{
			if( isset($mwp_loop->get_data()->photos) ){
				$photos = json_decode(json_encode($mwp_loop->get_data()->photos), true);
				$arr_photos = array_values($photos);
				if( count($arr_photos) > 0 ){
					$pm_img = $arr_photos[0];
				}
			}
		}
	}
	
	return $pm_img;
}
function mwp_html_primary_photo(){
	$pm_img = mwp_primary_photo();
	$class = '';
	if( $pm_img ){
		$class = 'no-primary-img';
	}
	$class = apply_filters('mwp_hook_class_listing_img', $class);
	$img = '<img class="img-responsive '.$class.'" src="'.mwp_primary_photo().'" alt="">';

	echo $img;
}
function mwp_property_detail_link($echo = TRUE){
	global $mwp_loop;
	$urlencoded_address = $mwp_loop->get_data()->get_property_url();
	$url = Mwp_PropertyDetailsURL::get_instance()->get_property_url($urlencoded_address);

	if( $echo ){
		echo $url;
	}else{
		return $url;
	}
}
function mwp_get_source(){
	global $mwp_loop;
	if( isset($mwp_loop->property_source) ){
		return $mwp_loop->property_source;
	}
}
function mwp_property_beds($echo = true){
	global $mwp_loop;
	$bed = $mwp_loop->get_data()->bed();
	if( $echo ){
		echo $bed;
	}else{
		return $bed;
	}
}
function mwp_property_bathrooms($echo = true){
	global $mwp_loop;
	$bath = $mwp_loop->get_data()->bath();
	if( $echo ){
		echo $bath;
	}else{
		return $bath;
	}
}
function mwp_get_property_floor_area(){
	global $mwp_loop;
	return $mwp_loop->get_data()->floor_area();
}
function mwp_get_property_lot_area(){
	global $mwp_loop;
	return $mwp_loop->get_data()->lot_area();
}
function mwp_property_garage($echo = true){
	global $mwp_loop;
	if( $echo ){
		echo $mwp_loop->get_data()->garage();
	}else{
		return $mwp_loop->get_data()->garage();
	}
}
function mwp_property_area_by($by = '', $source = null){
	global $mwp_loop;
	if( is_null($source)){
		$source = mwp_get_source();
	}
	$by = apply_filters('property_area_by_' . $source, $by);
	$md_area = $mwp_loop->get_data()->area_measurement($by);
	$unit_type = apply_filters('property_area_by_unit_' . $source, $md_area->area_type);
	if( $md_area->by == 'floor' ){
		$md_area->by = _label('floor-area-size');
	}elseif( $md_area->by == 'lot' ){
		$md_area->by = _label('lot-area-size');
	}
	$data = array(
		'measurement'	=> $md_area->measure,
		'unit'		 	=> $unit_type,
		'by'		 	=> $md_area->by,
		'unit_str'   	=> $md_area->by . ' ' . $unit_type,
	);
	return apply_filters('property_area_' . $source, $data);
}
function mwp_get_property_area(){
	$unit = mwp_property_area_by();
	return $unit['measurement'];
}
function mwp_get_property_area_unit(){
	$area = mwp_property_area_by();
	return $area['unit_str'];
}
function mwp_transaction($echo = true){
	global $mwp_loop;
	if( $echo ){
		echo $mwp_loop->get_data()->transaction_type();
	}else{
		return $mwp_loop->get_data()->transaction_type();
	}
}
function mwp_latitude(){
	global $mwp_loop;
	return $mwp_loop->get_data()->latitude();
}
function mwp_longitude(){
	global $mwp_loop;
	return $mwp_loop->get_data()->longitude();
}
function mwp_geocode_search_location(){
	$geocode_address = mwp_geocode_account_address();

	if( count($geocode_address) == 0 ){
		$geocode_address = array(0,0);
	}

	if( isset($_GET['location']) 
		&& $_GET['location'] != '' 
		&& count($geocode_address) > 0
	){
		$get_location = urldecode($_GET['location']);
		$geocode = Mwp_Helpers_Gmap::geocode($get_location);
		if( $geocode['status'] == 'OK' ) {
			$geocode_address = array(
				'lat' 		=> 	$geocode['results'][0]['geometry']['location']['lat'],
				'lng' 		=> 	$geocode['results'][0]['geometry']['location']['lng'],
				'result'	=>	true
			);
		}
	}
	return $geocode_address;
}
function mwp_property_html_price(){
	$price = '';
	$account  = mwp_get_account_data();
	$get_currency = ($account->currency) ? $account->currency:'$';
	if( mwp_property_price() == 0 ){
		$price = __('Call for pricing', mwp_localize_domain()).' ';
		$price .= '<span>'.$account->work_phone.'</span>';
	}else{
		$price = $get_currency.number_format( mwp_property_price() );
		$price .= '<span>';
		$price .= apply_filters('single_price_label',__('Price', mwp_localize_domain()));
		$price .= '</span>';

	}
	return $price;
}
function mwp_posted_at(){
	global $mwp_loop;
	return $mwp_loop->get_data()->posted_at();
}
function mwp_single_photos(){
	global $mwp_loop;
	return $mwp_loop->get_property_photo();
}
function mwp_single_photos_key($index = 0){
	$photos = mwp_single_photos();
	if( isset($photos[$index]) ){
		return $photos[$index];
	}
	return false;
}
function mwp_year_built(){
	global $mwp_loop;
	return ($mwp_loop->get_data()->year_built() == '') ? '&nbsp;':$mwp_loop->get_data()->year_built();
}
function mwp_get_mls(){
	global $mwp_loop;
	return $mwp_loop->get_data()->get_mls();
}
function mwp_get_state(){
	global $mwp_loop;
	return $mwp_loop->get_data()->state();
}
function mwp_get_param_video(){
	global $mwp_loop;
	return $mwp_loop->get_data()->get_params('videos');
}
function mwp_display_video(){
	$videos = mwp_get_param_video();
	if( $videos && is_array($videos) ){
		foreach($videos as $v){
			parse_str( parse_url( $v, PHP_URL_QUERY ), $youtube_array_vars );
			$youtube_id = $v;
			if( isset($youtube_array_vars['v']) && $youtube_array_vars['v'] != '' ){
				$youtube_id = $youtube_array_vars['v'];
			}
			?>
				<div class="embed-responsive embed-responsive-16by9">
					<iframe class="youtube-video" width="853" height="480" src="https://www.youtube.com/embed/<?php echo $youtube_id;?>" frameborder="0" allowfullscreen></iframe>
				</div>
			<?php
		}
	}
	return false;
}
function mwp_get_agent(){
	global $mwp_loop;
	return $mwp_loop->get_data()->agent();
}
function mwp_get_total_data(){
	global $mwp_loop;
	return $mwp_loop->property_data_total;
}
function mwp_hji_days_on_market(){
	global $mwp_loop;
	if( mwp_get_current_api_source() == 'hji' ){
		return $mwp_loop->get_data()->days_on_hji();
	}
	return false;
}
function mwp_crm_get_property_cat_photos(){
	global $mwp_loop;
	$cat_photo = array();
	if( mwp_get_current_api_source() == 'crm' ){
		$loop_photo = $mwp_loop->get_property_cat_photos();
		if( isset($loop_photo->result) 
			&& $loop_photo->result == 'success' 
			&& isset($loop_photo->photo_details)
		){
			foreach($loop_photo->photo_details as $key => $val){
				if( $val->category != '' ){
					$cat_photo[$val->category][] = $val;
				}
			}
			return $cat_photo;
		}
	}
	return false;
}
function mwp_property_status(){
	global $mwp_loop;
	if( mwp_get_current_api_source() == 'crm' ){
		return mwp_get_data_loop()->get_property_status_label();
	}else{
		return mwp_get_data_loop()->property_status();
	}
	return false;
}
function mwp_property_details_unit(){
	global $mwp_loop;
	if( mwp_get_current_api_source() == 'crm' ){
		return $mwp_loop->get_data()->pricing_period();
	}
	return false;
}
function mwp_property_display_unit(){
	echo strtoupper(mwp_property_details_unit());
}
function mwp_display_property_types_tag(){
	global $mwp_loop;
	if( mwp_get_current_api_source() == 'crm' ){
		$current_property_type = $mwp_loop->get_data()->property_types();
		if( $current_property_type ){
			$property_types = mwp_get_property_types();
			$str_property_types = '';
			if( $property_types && count($property_types) > 0 ){
				foreach($property_types as $k => $val){
					if( in_array($k, $current_property_type) ){
						$str_property_types .= $val.', ';
					}
				}
				return rtrim($str_property_types,', ');
			}
		}
		return false;
	}
}
function is_nonviewable_status(){
	global $mwp_loop;
	if( mwp_get_current_api_source() == 'crm' ){
		$non_view = Mwp_CRM_PropertyFields::get_instance()->get_field_nonviewable_status();
		$to_array = (array)$non_view;
		$to_array_keys = array_keys($to_array);
		$status = 0;
		if( isset(Mwp_View::get_instance()->data['property_data']) ){
			$status = Mwp_View::get_instance()->data['property_data']->property_data[0]->property_status();
		}
		return in_array($status,$to_array_keys);
	}
	return false;
}
