<?php
/**
 * default template search form
 * */
function mwp_get_search_form_template(){
	global $mwp;
	return $mwp['template']['template_search_form'];
}
function mwp_search_form_template_path(){
	$path = mwp_default_template_dir();
	return $path . '/searchform/' . mwp_get_search_form_template();
}
function mwp_search_form_template_dir(){
	$path = mwp_default_template_dir();
	return $path . '/searchform';
}
function mwp_search_result_template(){
	global $mwp;
	$template = $mwp['template']['template_search_result'];
	$template = apply_filters('mwp_hook_current_template_search_result', $template);
	return $template;
}
function mwp_get_search_url(){
	global $mwp;
	return $mwp['search_settings_general']['search_property_url'];
}
function md_search_form_template($template = '', $args = null){
}
/**
 * get property type by hook
 *
 * crm and mls data feed have different property type
 * so we create a hook to filter fields type base on the default feed
 * */
function md_get_account_field_type(){
	$property_type = array();
	// The DEFAULT_FEED can be change in the WP admin
	// Masterdigm - CRM tab
	return apply_filters('fields_type_' . mwp_get_current_api_source(), $property_type);
}
/**
 *standard form tag
 *
 * this is the open tag form of the search form
 * @params	$array_form_settings	array		this is the value of the form tag
 * 												acceptable values are:
 * 												css_class_array - the class name of the form
 * 												form_name - form name
 * 												form_action - form action, the url of the landing search form
 * 												form_method - form method
 * */
function md_search_form_start($array_form_settings = array()){
	$css_class_array = array('form-inline', 'search_property');
	if( isset($array_form_settings['css_class_array']) ){
		foreach($array_form_settings['css_class_array'] as $key => $val){
			array_push($css_class_array, $val);
		}
	}
	/**
	* hook to change or add css of the form
	* */
	$css_class_array = apply_filters('md_hook_css_class_form_start', $css_class_array);
	$css_class = implode(" ", $css_class_array);

	$form_name = 'search_property';
	if( isset($array_form_settings['form_name']) ){
		$form_name = $array_form_settings['form_name'];
	}
	$form_name = apply_filters('md_hook_search_form_name', $form_name);

	$form_action = Mwp_SearchPropertyURL::get_instance()->get_url();
	if( isset($array_form_settings['form_action']) ){
		$form_action = $array_form_settings['form_action'];
	}
	$form_action = apply_filters('md_hook_search_form_action', $form_action);

	$form_method = 'GET';
	if( isset($array_form_settings['form_method']) ){
		$form_method = $array_form_settings['form_method'];
	}
	$form_method = apply_filters('md_hook_search_form_method', $form_method);

	echo '<form class="'.$css_class.'" method="'.$form_method.'" id="advanced_search" name="'.$form_name.'" action="'.$form_action.'"  role="form">';
}
/**
 * closing tag form of search
 * */
function md_search_form_end(){
	echo '</form>';
}
/**
 * get the location value from form input GET or POST
 * */
function md_search_form_location(){
	$location = '';
	if(
		isset($_GET['location'])
		&& $_GET['location'] != ''
	){
		$location = sanitize_text_field($_GET['location']);
	}elseif(
		isset($_POST['location'])
		&& $_POST['location'] != ''
	){
		$location = sanitize_text_field($_POST['location']);
	}
	return $location;
}
/**
 * show the search form location input
 * with autocomplete feature
 * uses bootstrap typeahead plugin
 * */
function md_search_input_location(){
	$location = md_search_form_location();
	$css_class_array = array('form-control');
	$css_class_array = apply_filters('md_hook_css_class_location', $css_class_array);
	$css_class = implode(" ", $css_class_array);
	$placeholder = _label('search-form-input-location');
	$placeholder = apply_filters('mwp_search_input_location', $placeholder);
	echo '<input type="text" id="location" name="location" placeholder="'.$placeholder.'" class="'.$css_class.'" value="'.$location.'" >';
}
//get the locationname value from form input GET or POST
function md_search_form_locationname(){
	$locationname = '';
	if(
		isset($_GET['locationname'])
		&& $_GET['locationname'] != ''
	){
		$locationname = sanitize_text_field($_GET['locationname']);
	}elseif(
		isset($_POST['locationname'])
		&& $_POST['locationname'] != ''
	){
		$locationname = sanitize_text_field($_POST['locationname']);
	}
	return $locationname;
}
/**
 * get the min_listprice variable
 * from GET or POST method
 * */
function md_search_form_min_price(){
	$min_listprice = 0;
	if(
		isset($_GET['min_listprice'])
		&& $_GET['min_listprice'] != ''
	){
		$min_listprice = sanitize_text_field($_GET['min_listprice']);
	}elseif(
		isset($_POST['min_listprice'])
		&& $_POST['min_listprice'] != ''
	){
		$min_listprice = sanitize_text_field($_POST['min_listprice']);
	}
	return $min_listprice;
}
/**
 * display minimum price select form
 *
 * */
function md_search_form_select_min_price(){
	$min_listprice = md_search_form_min_price();
	$css_class_array = array('form-control');
	$css_class_array = apply_filters('md_hook_css_class_min_listprice', $css_class_array);
	$css_class = implode(" ", $css_class_array);
	$currency = mwp_get_account_currency();
	echo '<select id="min_listprice" name="min_listprice" class="'.$css_class.'">';
		echo '<option value="0">';
				if( has_action('min_price_val') ){
					do_action('min_price_val');
				}else{
					echo _label('min-price');
				}
		echo '</option>';
		if( count(search_form_by_price_range()) > 0 ){
			foreach(search_form_by_price_range() as $key => $val) {
				echo '<option value="'.$val.'" '.($min_listprice == $val ? "selected":"").'>';
					echo $currency.number_format($val,2);
				echo '</option>';
			}
		}
	echo '</select>';
}
/**
 * get the max_listprice variable
 * from GET or POST method
 * */
function md_search_form_max_price(){
	$max_listprice = 0;
	if(
		isset($_GET['max_listprice'])
		&& $_GET['max_listprice'] != ''
	){
		$max_listprice = sanitize_text_field($_GET['max_listprice']);
	}elseif(
		isset($_POST['max_listprice'])
		&& $_POST['max_listprice'] != ''
	){
		$max_listprice = sanitize_text_field($_POST['max_listprice']);
	}
	return $max_listprice;
}
/**
 * display the mas price dropdown select tag
 * */
function md_search_form_select_max_price($arg = array()){
	$max_listprice = md_search_form_max_price();
	$css_class_array = array('form-control');
	$css_class_array = apply_filters('md_hook_css_class_max_listprice', $css_class_array);
	$css_class = implode(" ", $css_class_array);
	$currency = mwp_get_account_currency();
	$label = _label('max-price');
	if( isset($arg['label']) && $arg['label'] != '' ){
		$label = $arg['label'];
	}
	echo '<select id="max_listprice" name="max_listprice" class="'.$css_class.'">';
		echo '<option value="0">';
				if( has_action('max_price_val') ){
					do_action('max_price_val');
				}else{
					echo $label;
				}
		echo '</option>';
		if( count(search_form_by_price_range()) > 0 ){
			foreach(search_form_by_price_range() as $key => $val) {
				echo '<option value="'.$val.'" '.($max_listprice == $val ? "selected":"") . '>';
					echo $currency.number_format($val,2);
				echo '</option>';
			}
		}
	echo '</select>';
}
/**
 * get the property type from GET or POST form method
 * */
function md_search_form_property_type(){
	$property_type = '';
	if(
		isset($_GET['property_type'])
		&& $_GET['property_type'] != ''
	){
		$property_type = sanitize_text_field($_GET['property_type']);
	}elseif(
		isset($_POST['property_type'])
		&& $_POST['property_type'] != ''
	){
		$property_type = sanitize_text_field($_POST['property_type']);
	}
	return $property_type;
}
/**
 * display the property dropdown select tag
 * it has a filter condition if display or not
 * */
function md_search_form_select_property_type($arg = array()){
	if( !has_filter('show_button_property_type_' . mwp_get_current_api_source()) ){
		$label = _label('search-form-property-type');
		if( isset($arg['label']) && $arg['label'] != '' ){
			$label = $arg['label'];
		}
		$fields_type = md_get_account_field_type();
		$property_type = md_search_form_property_type();
		echo '<select name="property_type" id="property_type" class="form-control">';
			echo '<option value="0">';
				echo $label;
			echo '</option>';
			if( $fields_type && count($fields_type) > 0 ){
				foreach($fields_type as $key => $val){
					echo '<option value="'.$key.'" '.($property_type == $key ? 'selected':'').'>';
						echo $val;
					echo '</option>';
				}
			}
		echo '</select>';
	}
}
/**
 * get the bed from GET or POST form method
 * */
function md_search_form_bed(){
	$bedrooms = '';
	if(
		isset($_GET['bedrooms'])
		&& $_GET['bedrooms'] != ''
	){
		$bedrooms = sanitize_text_field($_GET['bedrooms']);
	}elseif(
		isset($_POST['bedrooms'])
		&& $_POST['bedrooms'] != ''
	){
		$bedrooms = sanitize_text_field($_POST['bedrooms']);
	}
	return $bedrooms;
}
/**
 * display the bed dropdown select tag
 * */
function md_search_form_select_bed($arg = array()){
	$bedrooms = md_search_form_bed();

	$css_class_array = array('form-control');
	$css_class_array = apply_filters('md_hook_css_class_bed', $css_class_array);
	$css_class = implode(" ", $css_class_array);
	$label = _label('search-form-bedroom');
	if( isset($arg['label']) && $arg['label'] != '' ){
		$label = $arg['label'];
	}
	echo '<select id="bedrooms" name="bedrooms" class="'.$css_class.'">';
		echo '<option value="0">';
			echo $label;
		echo '</option>';
		foreach (range(1, 5) as $number){
			echo '<option value="'.$number.'" '.($bedrooms == $number ? "selected":"").'>';
				echo $number;
			echo '</option>';
		}
	echo '</select>';
}
/**
 * get the bath from GET or POST form method
 * */
function md_search_form_bath(){
	$bathrooms = '';
	if(
		isset($_GET['bathrooms'])
		&& $_GET['bathrooms'] != ''
	){
		$bathrooms = sanitize_text_field($_GET['bathrooms']);
	}elseif(
		isset($_POST['bathrooms'])
		&& $_POST['bathrooms'] != ''
	){
		$bathrooms = sanitize_text_field($_POST['bathrooms']);
	}
	return $bathrooms;
}
/**
 * display the bath dropdown select tag
 * */
function md_search_form_select_bath(){
	$bathrooms = md_search_form_bath();

	$css_class_array = array('form-control');
	$css_class_array = apply_filters('md_hook_css_class_bath', $css_class_array);
	$css_class = implode(" ", $css_class_array);
	$label = _label('search-form-bath');
	if( isset($arg['label']) && $arg['label'] != '' ){
		$label = $arg['label'];
	}
	echo '<select id="bathrooms" name="bathrooms" class="'.$css_class.'">';
		echo '<option value="0">';
			echo $label;
		echo '</option>';
		foreach (range(1, 5) as $number){
			echo '<option value="'.$number.'" '.($bathrooms == $number ? "selected":"").'>';
				echo $number;
			echo '</option>';
		}
	echo '</select>';
}
/**
 * display search button sale
 * */
function md_search_button_sale(){
	$css_class_array = array(
		'search-form-btn',
		'btn',
		'mwp-theme-bk-color',
	);
	$css_class_array = apply_filters('md_hook_css_class_sale', $css_class_array);
	$css_class = implode(" ", $css_class_array);

	$show_button_for_sale = md_show_button_for_sale();

	if( $show_button_for_sale ){
		echo '<button type="submit" class="'.$css_class.'" value="For Sale">';
			$button_for_sale = __('For Sale', mwp_localize_domain());
			if( has_filter('search_form_button_for_sale') ){
				$button_for_sale = apply_filters('search_form_button_for_sale', $button_for_sale);
			}
			echo $button_for_sale;
		echo '</button>';
	}
}
function md_show_button_for_sale(){
	$show_button_for_sale = false;

	if(
		Mwp_Settings_Search_General_DBEntity::get_instance()->get_form_show_forsale_button('r') == 'y'
	){
		$show_button_for_sale = true;
	}
	//force
	if( has_filter('show_button_for_sale') ){
		$show_button_for_sale = apply_filters('show_button_for_sale', $show_button_for_sale);
	}
	return $show_button_for_sale;
}
/**
 * display search button rent
 * */
function md_search_button_rent(){
	$css_class_array = array(
		'search-form-btn',
		'btn',
		'mwp-theme-bk-color'
	);
	$css_class_array = apply_filters('md_hook_css_class_rent', $css_class_array);
	$css_class = implode(" ", $css_class_array);

	$show_button_for_rent = md_show_button_for_rent();
	if( $show_button_for_rent ){
		echo '<button type="submit" class="'.$css_class.'" value="For Rent">';
			$button_for_rent = __('For Rent', mwp_localize_domain());
			if( has_filter('search_form_button_for_rent') ){
				$button_for_rent = apply_filters('search_form_button_for_rent', $button_for_rent);
			}
			echo $button_for_rent;
		echo '</button>';
	}
}
function md_show_button_for_rent(){
	$show_button_for_rent = false;
	if(
		Mwp_Settings_Search_General_DBEntity::get_instance()->get_form_show_forrent_button('r') == 'y'
	){
		$show_button_for_rent = true;
	}
	if( has_filter('show_button_for_rent') ){
		$show_button_for_rent = apply_filters('show_button_for_rent', $show_button_for_rent);
	}
	return $show_button_for_rent;
}
function md_show_foreclosure(){
	$show = false;
	if(
		Mwp_Settings_Search_General_DBEntity::get_instance()->get_form_show_foreclosure_button('r') == 'y'
	){
		$show = true;
	}
	if( has_filter('show_button_foreclosure') ){
		$show = apply_filters('show_button_foreclosure', $show);
	}
	return $show;
}
function md_show_privatesales(){
	$show = false;
	if(
		Mwp_Settings_Search_General_DBEntity::get_instance()->get_form_show_privatesales_button('r') == 'y'
	){
		$show = true;
	}
	if( has_filter('show_button_privatesales') ){
		$show = apply_filters('show_button_privatesales', $show);
	}
	return $show;
}
function md_show_tolet(){
	$show = false;
	if(
		Mwp_Settings_Search_General_DBEntity::get_instance()->get_form_show_tolet_button('r') == 'y'
	){
		$show = true;
	}
	if( has_filter('show_button_tolet') ){
		$show = apply_filters('show_button_tolet', $show);
	}
	return $show;
}
//hidden input
function md_search_form_view(){
	echo '<input type="hidden" name="view" value="'.get_current_view_query().'" id="view">';
}
//hidden input
function md_search_form_isfullscreen(){
	echo '<input type="hidden" name="fullscreen" value="'.is_fullscreen().'" id="fullscreen">';
}
//hidden input
function md_search_form_input_locationname(){
	echo '<input type="hidden" name="locationname" value="'.md_search_form_locationname().'" id="locationname">';
}
/**
 * get the subdivisionid value from GET or POST form method
 * */
function md_search_form_subdivisionid(){
	$subdivisionid = '';
	if(
		isset($_GET['subdivisionid'])
		&& $_GET['subdivisionid'] != ''
	){
		$subdivisionid = sanitize_text_field($_GET['subdivisionid']);
	}elseif(
		isset($_POST['subdivisionid'])
		&& $_POST['subdivisionid'] != ''
	){
		$subdivisionid = sanitize_text_field($_POST['subdivisionid']);
	}
	return $subdivisionid;
}
//hidden input
function md_search_form_input_subdivisionid(){
	echo '<input type="hidden" name="subdivisionid" value="'.md_search_form_subdivisionid().'" id="subdivisionid">';
}
/**
 * get the cityid value from GET or POST form method
 * */
function md_search_form_cityid(){
	$cityid = 0;
	if(
		isset($_GET['cityid'])
		&& $_GET['cityid'] != 0
	){
		$cityid = sanitize_text_field($_GET['cityid']);
	}elseif(
		isset($_POST['cityid'])
		&& $_POST['cityid'] != 0
	){
		$cityid = sanitize_text_field($_POST['cityid']);
	}
	return $cityid;
}
//hidden input
function md_search_form_input_cityid(){
	echo '<input type="hidden" name="cityid" value="'.md_search_form_cityid().'" id="cityid">';
}
function md_search_form_transaction(){
	$transaction = 'For Sale';
	if(
		isset($_GET['transaction'])
		&& $_GET['transaction'] != ''
	){
		$transaction = sanitize_text_field($_GET['transaction']);
	}elseif(
		isset($_POST['transaction'])
		&& $_POST['transaction'] != ''
	){
		$transaction = sanitize_text_field($_POST['transaction']);
	}
	return $transaction;
}
//hidden input
function md_search_form_input_transaction(){
	echo '<input type="hidden" name="transaction" value="'.md_search_form_transaction().'" id="transaction">';
}
/**
 * get the countyid value from GET or POST form method
 * */
function md_search_form_countyid(){
	$countyid = '';
	if(
		isset($_GET['countyid'])
		&& $_GET['countyid'] != ''
	){
		$countyid = sanitize_text_field($_GET['countyid']);
	}elseif(
		isset($_POST['countyid'])
		&& $_POST['countyid'] != ''
	){
		$countyid = sanitize_text_field($_POST['countyid']);
	}

	return $countyid;
}
//hidden
function md_search_form_input_countyid(){
	echo '<input type="hidden" name="countyid" value="'.md_search_form_countyid().'" id="countyid">';
}
/**
 * get the communityid value from GET or POST form method
 * */
function md_search_form_communityid(){
	$communityid = '';
	if(
		isset($_GET['communityid'])
		&& $_GET['communityid'] != ''
	){
		$communityid = sanitize_text_field($_GET['communityid']);
	}elseif(
		isset($_POST['communityid'])
		&& $_POST['communityid'] != ''
	){
		$communityid = sanitize_text_field($_POST['communityid']);
	}
	return $communityid;
}
function md_search_form_input_communityid(){
	echo '<input type="hidden" name="communityid" value="'.md_search_form_communityid().'" id="communityid">';
}
/**
 * get the stateid value from GET or POST form method
 * */
function md_search_form_stateid(){
	$stateid = '';
	if(
		isset($_GET['stateid'])
		&& $_GET['stateid'] != ''
	){
		$stateid = sanitize_text_field($_GET['stateid']);
	}elseif(
		isset($_POST['stateid'])
		&& $_POST['stateid'] != ''
	){
		$stateid = sanitize_text_field($_POST['stateid']);
	}
	return $stateid;
}
function md_search_form_input_stateid(){
	echo '<input type="hidden" name="stateid" value="'.md_search_form_stateid().'" id="stateid">';
}
/**
 * get the lattitude value from GET or POST form method
 * */
function md_search_form_lat(){
	$lat = '';
	if(
		isset($_GET['lat'])
		&& $_GET['lat'] != ''
	){
		$lat = sanitize_text_field($_GET['lat']);
	}elseif(
		isset($_POST['lat'])
		&& $_POST['lat'] != ''
	){
		$lat = sanitize_text_field($_POST['lat']);
	}
	return $lat;
}
function md_search_form_input_lat(){
	echo '<input type="hidden" name="lat" value="'.md_search_form_lat().'" id="lat_front">';
}
/**
 * get the longitude value from GET or POST form method
 * */
function md_search_form_lon(){
	$lon = '';
	if(
		isset($_GET['lon'])
		&& $_GET['lon'] != ''
	){
		$lon = sanitize_text_field($_GET['lon']);
	}elseif(
		isset($_POST['lon'])
		&& $_POST['lon'] != ''
	){
		$lon = sanitize_text_field($_POST['lon']);
	}
	return $lon;
}
function md_search_form_input_lon(){
	echo '<input type="hidden" name="lon" value="'.md_search_form_lon().'" id="lon_front">';
}
/**
* get the lot area value from GET or POST form method
* */
function md_search_form_lot_area(){
	$lot_area = 0;
	if(
		isset($_GET['lot_area'])
		&& $_GET['lot_area'] != ''
	){
		$lot_area = sanitize_text_field($_GET['lot_area']);
	}elseif(
		isset($_POST['lot_area'])
		&& $_POST['lot_area'] != ''
	){
		$lot_area = sanitize_text_field($_POST['lot_area']);
	}
	return $lot_area;
}
/**
* display lot area dropdown select tag
* */
function md_search_form_select_lot_area(){
	$unit_area = mwp_get_account_data()->unit_area;
	print_r($unit_area);
	if( $unit_area ){
		$lot_area = md_search_form_lot_area();
		$css_class_array = array('form-control');
		$css_class_array = apply_filters('md_hook_css_class_floor_area', $css_class_array);
		$css_class = implode(" ", $css_class_array);
		echo '<select name="lot_area" id="lot_area" class="'.$css_class.'">';
			echo '<option value="0">';
			echo _label('search-form-input-min-lot-area');
			echo '</option>';
			if( count(get_search_form_lot_range()) > 0 ){
				foreach(get_search_form_lot_range() as $key=>$val) {
					echo '<option value="'.$val.'" '.($lot_area == $val  ? "selected":"").'>';
						echo $val.' '.$unit_area;
					echo '</option>';
				}
			}
		echo '</select>';
	}
}
/**
* get the floor area value from GET or POST form method
* */
function md_search_form_floor_area(){
	$floor_area = 0;
	if(
		isset($_GET['floor_area'])
		&& $_GET['floor_area'] != ''
	){
		$floor_area = sanitize_text_field($_GET['floor_area']);
	}elseif(
		isset($_POST['floor_area'])
		&& $_POST['floor_area'] != ''
	){
		$floor_area = sanitize_text_field($_POST['floor_area']);
	}
	return $floor_area;
}
/**
* display floor area dropdown select tag
* */
function md_search_form_select_floor_area(){
	$unit_area = mwp_get_account_data()->unit_area;
	if( $unit_area ){
		$floor_area = md_search_form_floor_area();
		$css_class_array = array('form-control');
		$css_class_array = apply_filters('md_hook_css_class_floor_area', $css_class_array);
		$css_class = implode(" ", $css_class_array);
		echo '<select name="floor_area" id="floor_area" class="'.$css_class.'">';
			echo '<option value="0">';
			echo _label('search-form-input-min-floor-area');
			echo '</option>';
			if( count(get_search_form_floor_range()) > 0 ){
				foreach(get_search_form_floor_range() as $key=>$val) {
					echo '<option value="'.$val.'" '.($floor_area == $val  ? "selected":"").'>';
						echo $val.' '.$unit_area;
					echo '</option>';
				}
			}
		echo '</select>';
	}
}
//javascript variable
function md_js_autocomplete_location_var(){
	if(  mwp_get_current_api_source() == 'crm' || mwp_get_current_api_source() == 'mls' ) {
		?>
		<script>
			var location_autocomplete = <?php echo apply_filters('mwp_location_build_up_' . mwp_get_current_api_source(), 'json'); ?>;
		</script>
		<?php
	}
}
/**
 * search form price range
 * */
function search_form_by_price_range(){
	$arr_price_range = Mwp_Settings_Search_Price_Entity::get_instance()->get_price_range_by();
	// incase we want to just totally change the whole array
	if( has_filter('filter_get_price_range_by') ){
		$arr_price_range = apply_filters('filter_get_price_range_by', $arr_price_range);
	}
	return $arr_price_range;
}
/**
 * search form floor range
 * */
function get_search_form_floor_range(){
	$arr_floor_range = Mwp_Settings_Search_Area_Entity::get_instance()->get_floor_area_range();
	// incase we want to just totally change the whole array
	if( has_filter('filter_arr_floor_range') ){
		$arr_floor_range = apply_filters('filter_arr_floor_range', $arr_floor_range);
	}
	return $arr_floor_range;
}
/**
 * search form lot range
 * */
function get_search_form_lot_range(){
	$arr_lot_range = Mwp_Settings_Search_Area_Entity::get_instance()->get_lot_area_range();
	// incase we want to just totally change the whole array
	if( has_filter('filter_arr_lot_range') ){
		$arr_lot_range = apply_filters('filter_arr_lot_range', $arr_lot_range);
	}
	return $arr_lot_range;
}
add_filter('filter_price_range_by_tens', 'func_filter_price_range_by_tens', 10, 1);
function func_filter_price_range_by_tens($ten){
	$array_ten = Mwp_Settings_Search_Price_Entity::get_instance()->price_range_by_tens();
	if( $array_ten ){
		if( $array_ten['start'] > 0 && $array_ten['end'] > 0 && $array_ten['step'] > 0 ){
			return Mwp_Helpers_Text::create_array_range($array_ten['start'], $array_ten['end'], $array_ten['step']);
		}else{
			return array();
		}
	}
	return $ten;
}
add_filter('filter_range_by_hundred', 'func_filter_price_range_by_hundred', 10, 1);
function func_filter_price_range_by_hundred($hundred){
	$array_hundred = Mwp_Settings_Search_Price_Entity::get_instance()->price_range_by_hundred();
	if( $array_hundred ){
		if( $array_hundred['start'] > 0 && $array_hundred['end'] > 0 && $array_hundred['step'] > 0 ){
			return Mwp_Helpers_Text::create_array_range($array_hundred['start'], $array_hundred['end'], $array_hundred['step']);
		}else{
			return array();
		}
	}
	return $hundred;
}
add_filter('filter_range_by_million', 'func_filter_price_range_by_million', 10, 1);
function func_filter_price_range_by_million($million){
	$array_million = Mwp_Settings_Search_Price_Entity::get_instance()->price_range_by_million();
	if( $array_million ){
		if( $array_million['start'] > 0 && $array_million['end'] > 0 && $array_million['step'] > 0 ){
			return Mwp_Helpers_Text::create_array_range($array_million['start'], $array_million['end'], $array_million['step']);
		}else{
			return array();
		}
	}
	return $million;
}
function md_searchyby($searchby = 'use_fulltext_search'){
	if( isset($_GET['searchby']) ){
		$searchby = $_GET['searchby'];
	}
	if( isset($_POST['searchby']) ){
		$searchby = $_POST['searchby'];
	}
	?>
	<select id="searchby" name="searchby" class="form-control">
		<option value="use_fulltext_search" <?php echo ($searchby == 'use_fulltext_search') ? 'selected':'';?>>Search by Keyword</option>
		<option value="location" <?php echo ($searchby == 'location') ? 'selected':'';?> >Search by Location</option>
	</select>
	<?php
}
function md_get_search_keyword(){
	$search_keyword = '';
	if( isset($_GET['search_keyword']) && sanitize_text_field($_GET['search_keyword']) != '' ){
		$search_keyword = $_GET['search_keyword'];
	}
	if( isset($_POST['search_keyword']) && sanitize_text_field($_POST['search_keyword']) != '' ){
		$search_keyword = $_POST['search_keyword'];
	}
	return $search_keyword;
}
function md_search_keyword_input(){
	$search_keyword = md_get_search_keyword();
	$css_class_array = array('form-control');
	$css_class_array = apply_filters('md_hook_css_class_keyword', $css_class_array);
	$css_class = implode(" ", $css_class_array);

	echo '<input type="text" id="search_keyword" name="search_keyword" placeholder="'._label('search-form-input-keyword').'" class="'.$css_class.'" value="'.$search_keyword.'" >';
}
function md_search_result_view(){
	$current_view = mwp_search_result_current_view();
	echo '<input type="hidden" name="view" value="'.$current_view.'">';
}
function md_search_shortcode(){
	return '[md_sc_search_property_form template="/searchform/search-form.php" ]';
}
function mwp_localize_transaction_type(){
	global $mwp;
	$property_label = $mwp['property_label'];
	return array(
		'for sale' => _label('transaction-type-forsale'),
		'for rent' => _label('transaction-type-forrent'),
		'foreclosure' => _label('transaction-type-foreclosure'),
		'private sales' => _label('transaction-type-privatesales'),
		'to let' => _label('transaction-type-tolet')
	);
}
function mwp_crm_dropdown_transaction_type(){
	echo '<select id="transaction" name="transaction" class="transaction form-control">';
		foreach(mwp_localize_transaction_type() as $k => $v){
			$sel = '';
			if( md_show_button_for_sale() && $k == 'for sale' ){
				if( md_search_form_transaction() == 'for sale' ){
					$sel = 'selected';
				}
				echo '<option value="'.$k.'" '.$sel.'>';
			}elseif( md_show_button_for_rent()  && $k == 'for rent'){
				if( md_search_form_transaction() == 'for rent' ){
					$sel = 'selected';
				}
				echo '<option value="'.$k.'" '.$sel.'>';
			}elseif( md_show_foreclosure() && $k == 'foreclosure'){
				if( md_search_form_transaction() == 'foreclosure' ){
					$sel = 'selected';
				}
				echo '<option value="'.$k.'" '.$sel.'>';
			}elseif( md_show_privatesales() && $k == 'private sales'){
				if( md_search_form_transaction() == 'private sales' ){
					$sel = 'selected';
				}
				echo '<option value="'.$k.'" '.$sel.'>';
			}elseif( md_show_tolet() && $k == 'to let'){
				if( md_search_form_transaction() == 'to let' ){
					$sel = 'selected';
				}
				echo '<option value="'.$k.'" '.$sel.'>';
			}
				echo $v;
			echo '</option>';
		}
	echo '</select>';
}
