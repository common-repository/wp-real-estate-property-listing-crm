<?php
class Mwp_HomeJunction_Hook{
	protected static $instance = null;
	public $flexmls;

	public function __construct(){}

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

	public function md_single_property_hji($attr = array()){
		$search_data = array();
		$search_data['property_id'] = $attr['id'];
		$query_arg = array(
			'property_id' => $attr['id']
		);

		$loop_data = new Mwp_HomeJunction_PropertyQuery($query_arg);

		return $loop_data;
	}
	public function property_nearby_property_hji($array_data){
		if($array_data['property_data']->has_property){
			$search_data['zip'] = '';
			if( isset($array_data['property_data']->property_data[0]->address->zip) ){
				$search_data['zip'] = $array_data['property_data']->property_data[0]->address->zip;
			}

			$search_data['limit'] = 6;
			$search_data['list_type'] = '';
			if( isset($array_data['property_data']->property_data[0]->listingType) ){
				$search_data['list_type'] = $array_data['property_data']->property_data[0]->listingType;
			}
			$search_data['property_type'] = '';
			if( isset($array_data['property_data']->property_data[0]->propertyType) ){
				$search_data['property_type'] = $array_data['property_data']->property_data[0]->propertyType;
			}
			$query_arg = array(
				'search_keyword' => $search_data,
			);
			$similar_data = new Mwp_HomeJunction_PropertyQuery($query_arg);
			return $similar_data;
		}
	}
	public function property_data($data = array()){
		if( isset($data['current_view']) && $data['current_view'] == 'map' ){
			$data['search_data']['limit'] = 1;
		}
		if( isset($data['search_data']['bedrooms']) && $data['search_data']['bedrooms'] == '0' ){
			$data['search_data']['bedrooms'] = '';
			$_REQUEST['bedrooms'] = '';
		}
		if( isset($data['search_data']['bathrooms']) && $data['search_data']['bathrooms'] == '0' ){
			$data['search_data']['bathrooms'] = '';
			$_REQUEST['bathrooms'] = '';
		}
		if( isset($data['search_data']['communityid']) && $data['search_data']['communityid'] == '0' ){
			$data['search_data']['communityid'] = '';
			$_REQUEST['communityid'] = '';
		}
		$data['search_data']['cityid'] = '';
		if( $data['search_data']['cityid'] == '0' ){
			$data['search_data']['cityid'] = '';
			$_REQUEST['cityid'] = '';
		}
		
		if( isset($data['search_data']['location']) ){
			$_REQUEST['cityid'] = $data['search_data']['location'];
			$data['search_data']['cityid'] = $data['search_data']['location'];
		}
		
		if( isset($data['search_data']['min_listprice']) && $data['search_data']['min_listprice'] == '0' ){
			$data['search_data']['min_listprice'] = '';
			$_REQUEST['min_listprice'] = '';
		}
		if( isset($data['search_data']['max_listprice']) && $data['search_data']['max_listprice'] == '0' ){
			$data['search_data']['max_listprice'] = '';
			$_REQUEST['max_listprice'] = '';
		}
		if( isset($data['search_data']['subdivisionid']) && $data['search_data']['subdivisionid'] == '0' ){
			$data['search_data']['subdivisionid'] = '';
			$_REQUEST['subdivisionid'] = '';
		}
		if( isset($data['search_data']['transaction']) && $data['search_data']['transaction'] == 'For Sale' ){
			$data['search_data']['transaction'] = '';
			$_REQUEST['transaction'] = '';
		}

		$query_arg = array(
			'search_keyword' => $data['search_data'],
		);

		$q = new Mwp_HomeJunction_PropertyQuery($query_arg);

		return $q;
	}
	
	public function infinite_scroll(){
		global $paged;
		$search_query = array();
		if( isset($_POST['search_uri_query']) ){
			$search_query = json_decode(stripslashes($_POST['search_uri_query']), true);
		}
		$search_query['paged'] = 2;
		if( isset($_POST['paged']) ){
			$paged = $_POST['paged'];
			$search_query['paged'] = $paged;
		}
		if( $search_query['bedrooms'] == 0 ){
			$search_query['bedrooms'] = '';
			$_REQUEST['bedrooms'] = '';
		}
		if( $search_query['bathrooms'] == 0 ){
			$search_query['bathrooms'] = '';
			$_REQUEST['bathrooms'] = '';
		}
		if( $search_query['communityid'] == 0 ){
			$search_query['communityid'] = '';
			$_REQUEST['communityid'] = '';
		}
		
		if( $search_query['cityid'] == 0 ){
			$search_query['cityid'] = '';
			$_REQUEST['cityid'] = '';
		}
		
		if( isset($search_query['location']) ){
			$_REQUEST['cityid'] = $search_query['location'];
			$search_query['cityid'] = $search_query['location'];
		}
		
		if( $search_query['min_listprice'] == 0 ){
			$search_query['min_listprice'] = '';
			$_REQUEST['min_listprice'] = '';
		}
		if( $search_query['max_listprice'] == 0 ){
			$search_query['max_listprice'] = '';
			$_REQUEST['max_listprice'] = '';
		}
		if( $search_query['subdivisionid'] == 0 ){
			$search_query['subdivisionid'] = '';
			$_REQUEST['subdivisionid'] = '';
		}
		if( $search_query['transaction'] == 'For Sale' ){
			$search_query['transaction'] = '';
			$_REQUEST['transaction'] = '';
		}

		$data['pagination']  = 1;
		$data['search_data'] = $search_query;
		$data['search_data']['details'] = true;
		$query_arg = array(
			'search_keyword' => $data['search_data'],
		);

		$q = new Mwp_HomeJunction_PropertyQuery($query_arg);

		$data['loop_data'] = $q;
		$data['class'] = '';
		$data['col'] = '3';
		$data['show_pagination'] = true;
		$loop_template = mwp_default_template_loop_list_file();
		$data['part_loop_template'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/' . $loop_template);
		$data['paged'] = $search_query['paged'];
		$template_file = Mwp_Theme_Locator::get_instance()->locate_template('ajax/property-list-v2.php');
		Mwp_View::get_instance()->display($template_file, $data);
		die();
	}
	public function get_property_data_hji(){
		$_data = array();
		$setup_data = array();
		$search_property_data = urldecode(stripslashes($_GET['search_property_data']));
		$search_data = json_decode($search_property_data, true);
		$map_boundaries = urldecode(stripcslashes($_GET['map_boundaries']));
		$map_boundaries = json_decode($map_boundaries, true);
		//$data = ['box'=>'north,east,south,wes'] 
		if( $_GET['current_view'] == 'map' ){
			$search_data['limit'] = 25;
			$search_data['use_location_search'] = 1;
		}
		$_search_map_boundaries = array(
			
		);
		if( isset($map_boundaries['has_boundary']) && $map_boundaries['has_boundary'] == 1 ){
			$_search_map_boundaries = array(
				$map_boundaries['map_bound']['bound_ne']['lat'],
				$map_boundaries['map_bound']['bound_ne']['lng'],
				$map_boundaries['map_bound']['bound_sw']['lat'],
				$map_boundaries['map_bound']['bound_sw']['lng'],
			);
			$search_map_boundaries = implode(",", $_search_map_boundaries);
		}

		if( $search_data['bedrooms'] == 0 ){
			$search_data['bedrooms'] = '';
			$_REQUEST['bedrooms'] = '';
		}
		if( $search_data['bathrooms'] == 0 ){
			$search_data['bathrooms'] = '';
			$_REQUEST['bathrooms'] = '';
		}
		if( $search_data['communityid'] == 0 ){
			$search_data['communityid'] = '';
			$_REQUEST['communityid'] = '';
		}
		
		if( $search_data['cityid'] == 0 ){
			$search_data['cityid'] = '';
			$_REQUEST['cityid'] = '';
		}
		
		if( isset($search_data['location']) ){
			$_REQUEST['cityid'] = $search_data['location'];
			$search_data['cityid'] = $search_data['location'];
		}
		
		if( $search_data['min_listprice'] == 0 ){
			$search_data['min_listprice'] = '';
			$_REQUEST['min_listprice'] = '';
		}
		if( $search_data['max_listprice'] == 0 ){
			$search_data['max_listprice'] = '';
			$_REQUEST['max_listprice'] = '';
		}
		if( $search_data['subdivisionid'] == 0 ){
			$search_data['subdivisionid'] = '';
			$_REQUEST['subdivisionid'] = '';
		}
		if( $search_data['transaction'] == 'For Sale' ){
			$search_data['transaction'] = '';
			$_REQUEST['transaction'] = '';
		}

		$search_data['map_boundaries'] = $search_map_boundaries;
		
		$query_arg = array(
			'search_keyword' => $search_data,
		);
		$loop_data = new Mwp_HomeJunction_PropertyQuery($query_arg);
		if( $loop_data->loop_property() ):
			while($loop_data->loop_property()): $loop_data->md_set_property();mwp_set_loop($loop_data);
				$has_map_coordinate = 1;
				if( mwp_latitude() == 0 &&  mwp_longitude() == 0 ){
					$has_map_coordinate = 0;
				}
				$favorite_args = array(
						'show' => 1,
						'feed' => mwp_get_source(),
						'property_id' => mwp_property_id(),
						'is_favorite' =>  Mwp_Actions_Favorite::get_instance()->check_property(mwp_property_id()),
						'label' =>  _label('button-favorite'),
						'action' => 'saveproperty_action',
						'content' => __('Must register or login to mark as favorite', mwp_localize_domain()),
				);
				$xout_args = array(
						'show' => 1,
						'feed' => mwp_get_source(),
						'property_id' => mwp_property_id(),
						'is_favorite' =>  Mwp_Actions_XOut::get_instance()->check_property(mwp_property_id()),
						'label' =>  _label('button-xout'),
						'action' => 'xoutproperty_action',
						'content' => __('Must register or login to mark as x-out', mwp_localize_domain()),
				);
				$print_args = array(
						'show' => 1,
						'url' => print_pdf(mwp_property_id(), mwp_get_source()),
						'label' => _label('button-printpdf'),
				);
				$_data[] = array(
					'id' => (int)mwp_property_id(),
					'title' => mwp_property_title(),
					'lat' => mwp_latitude(),
					'long' => mwp_longitude(),
					'property_id' => mwp_property_id(),
					'desc' => 'content ' . mwp_property_id(),
					'has_map_coordinate' => $has_map_coordinate,
					'photos' => mwp_property_photos(),
					'count_photos' => count(mwp_property_photos()),
					'primary_photo' => mwp_primary_photo(),
					'url' => mwp_property_detail_link(false),
					'price' => mwp_html_property_price(false),
					'bed' => mwp_property_beds(false),
					'bath' => mwp_property_bathrooms(false),
					'area' => apply_filters('property_area_' . mwp_get_source(), mwp_get_property_area()),
					'area_unit' => apply_filters('property_area_unit_' . mwp_get_source(), mwp_get_property_area_unit()),
					'raw_price' => (int)mwp_property_price(),
					'posted_at' => mwp_posted_at(),
					'marker_price' => mwp_get_account_currency().Mwp_Helpers_Text::bd_nice_number(mwp_property_price()),
					'transaction' => mwp_transaction(false),
					'source' => 'mls',
					'is_user_logged_in' => is_user_logged_in(),
					'favorite' => $favorite_args,
					'xout' => $xout_args,
					'printpdf' => $print_args,
				);
			endwhile;
		endif;
		echo json_encode($_data);
		exit();
	}
	public function fields_type_hji(){
		$fields =  Mwp_HomeJunction_PropertyFields::get_instance()->get_property_type();
		return $fields;
	}
	
	public function md_single_property_pdf_hji($attr = array()){
		$search_data = array();
		$query_arg = array(
			'property_id' => $attr['id'],
		);
		$loop_data = new Mwp_HomeJunction_PropertyQuery($query_arg);
		return $loop_data;
	}
	public function favorites_property_hji($p_id){
		$search_data = array();
		$search_data['limit'] = count($p_id);
		$search_data['details'] = true;
		$search_data['property_id'] = $p_id;
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => 0,
		);
		$hji_data['loop_hji'] = new Mwp_HomeJunction_PropertyQuery($query_arg);
		return $hji_data;
	}
	public function xout_property_hji($p_id){
		$search_data = array();
		$search_data['limit'] = count($p_id);
		$search_data['details'] = true;
		$search_data['property_id'] = $p_id;
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => 0,
		);
		$hji_data['loop_hji'] = new Mwp_HomeJunction_PropertyQuery($query_arg);
		return $hji_data;
	}
	public function create_location_page_action_callback(){

	}
}
