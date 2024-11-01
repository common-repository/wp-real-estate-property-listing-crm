<?php
class Mwp_Flexmls_Hook{
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

	public function property_data($data = array()){
		if( $data['current_view'] == 'map' ){
			$data['search_data']['limit'] = 25;
		}
		$data['search_data']['expand'] = "PrimaryPhoto";
		if( isset($data['search_data']['cityid']) 
			&& ($data['search_data']['cityid'] != '' || $data['search_data']['cityid'] != '0') 
		){
			$data['search_data']['cityid'] = "City Eq '" . sanitize_text_field($data['search_data']['cityid']) . "'";
		}
		$query_arg = array(
			'search_keyword' => $data['search_data'],
			'property_single_photo' => 0,
		);
		
		$q = new Mwp_Flexmls_PropertyQuery($query_arg);

		return $q;
	}
	public function md_property_details_parse_uri_flexmls($parse_uri){
		if( count($parse_uri) >= 2 && isset($parse_uri[0]) && isset($parse_uri[1]) ){
			return $parse_uri[0].'-'.$parse_uri[1];
		}
	}
	public function md_single_property_flexmls($attr = array()){
		$search_data = array();
		$search_data['limit'] = 1;
		$search_data['expand'] = 'Photos, CustomFields';
		$search_data['property_id'] = $attr['id'];
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => $attr['id'],
		);
		$loop_data = new Mwp_Flexmls_PropertyQuery($query_arg);

		return $loop_data;
	}
	
	public function get_property_data_mls(){
		$_data = array();
		$setup_data = array();
		$search_property_data = urldecode(stripslashes($_GET['search_property_data']));
		$search_data = json_decode($search_property_data, true);
		$map_boundaries = urldecode(stripcslashes($_GET['map_boundaries']));
		$map_boundaries = json_decode($map_boundaries, true);

		if( $_GET['current_view'] == 'map' ){
			$search_data['limit'] = 25;
			$search_data['use_location_search'] = 1;
		}
		
		$search_map_boundaries = array(
			'ne_lat' => 0,
			'ne_lng' => 0,
			'sw_lat' => 0,
			'sw_lng' => 0,
		);
		if( isset($map_boundaries['has_boundary']) && $map_boundaries['has_boundary'] == 1 ){
			$search_map_boundaries = array(
				'ne_lat' => $map_boundaries['map_bound']['bound_ne']['lat'],
				'ne_lng' => $map_boundaries['map_bound']['bound_ne']['lng'],
				'sw_lat' => $map_boundaries['map_bound']['bound_sw']['lat'],
				'sw_lng' => $map_boundaries['map_bound']['bound_sw']['lng'],
			);
		}
		$search_data['map_boundaries'] = $search_map_boundaries;
		$search_data['expand'] = 'PrimaryPhoto';
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_single_photo' => 0,
		);
		
		$loop_data = new Mwp_Flexmls_PropertyQuery($query_arg);

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
					'source' => 'flexmls',
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
	
	public function property_nearby_property_flexmls($array_data){
		if($array_data['property_data']->has_property){
			$property 		= $array_data['property_data']->property_data[0];
			$communityid = '';
			$cityid = '';
			
			if( $property->city() ){
				$cityid = "City Eq '".$property->city()."'";
			}

			$limit = 6;

			$search_data	= array();
			$search_data['countyid'] 		= 0;
			$search_data['stateid'] 		= 0;
			$search_data['countryid'] 		= 0;
			$search_data['cityid'] 			= $cityid;
			$search_data['zip'] 			= '';
			$search_data['communityid'] 	= $communityid;
			$search_data['bathrooms'] 		= '';
			$search_data['bedrooms'] 		= '';
			$search_data['property_type'] 	= $property->property_type();
			$search_data['orderby'] 		= '';
			$search_data['order_direction']	= '';
			$search_data['limit']			= $limit;
			$search_data['expand']			= 'PrimaryPhoto';
			$query_arg = array(
				'search_keyword' => $search_data,
				'property_id' => 0,
			);

			$similar_data = new Mwp_Flexmls_PropertyQuery($query_arg);
			return $similar_data;
		}
	}
	public function favorites_property_flexmls($p_id){
		$search_data = array();
		$search_data['limit'] = count($p_id);
		$search_data['expand'] = 'PrimaryPhoto';
		$search_data['property_id'] = $p_id;
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => 0,
		);
		$flex_data['loop_flexmls'] = new Mwp_Flexmls_PropertyQuery($query_arg);
		return $flex_data;
	}
	public function xout_property_flexmls($p_id){
		$search_data = array();
		$search_data['limit'] = count($p_id);
		$search_data['expand'] = 'PrimaryPhoto';
		$search_data['property_id'] = $p_id;
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => 0,
		);
		$flex_data['loop_flexmls'] = new Mwp_Flexmls_PropertyQuery($query_arg);
		return $flex_data;
	}
	public function md_single_property_pdf($attr = array()){
		$search_data = array();
		$search_data['limit'] = 1;
		$search_data['expand'] = 'Photos, CustomFields';
		$search_data['property_id'] = $attr['id'];
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => $attr['id'],
		);
		$loop_data = new Mwp_Flexmls_PropertyQuery($query_arg);

		return $loop_data;
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
		$data['search_data'] = $search_query;
		$data['search_data']['paged'] = $search_query['paged'];
		$data['search_data']['expand'] = "PrimaryPhoto";
		if( isset($data['search_data']['cityid']) 
			&& ($data['search_data']['cityid'] != '' || $data['search_data']['cityid'] != '0') 
		){
			$data['search_data']['cityid'] = "City Eq '" . sanitize_text_field($data['search_data']['cityid']) . "'";
		}
		$query_arg = array(
			'search_keyword' => $data['search_data'],
			'property_single_photo' => 0,
		);

		$q = new Mwp_Flexmls_PropertyQuery($query_arg);
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
	
	public function create_location_page_action_callback(){
		$locations = Mwp_Flexmls_HookLocation::get_instance()->location_build_up(array('output'=>'aarray'));
		$current_user = mwp_wp_get_current_user();
		$model = new Mwp_MLS_Model;
		$msg 	= '';
		$status = false;

		$page_location 	= array();

		if( count($locations) > 0 ){
			$post_status = 'publish';
			if( isset($_POST['post_status']) ){
				$post_status = sanitize_text_field($_POST['post_status']);
			}

			$page_location['total']	= count($locations);
			$count = 0;

			wp_defer_term_counting(true);
			wp_defer_comment_counting(true);
			$indx = 0;
			foreach($locations as $key => $val){
					$content_shortcode = '';
					$page_location['date_added'] 	= date("F j, Y, g:i a");
					
					$loc_id = $val['id'];
					$page_location[$loc_id]['value'] 			= $val['value'];
					$page_location[$loc_id]['location_type'] 	= $val['type'];
					$page_location[$loc_id]['id'] 				= $val['id'];
					
					$id = $page_location[$loc_id]['value'];
					$location = 'cityid="City Eq \''.$id.'\'"';

					$content_shortcode 	= md_search_shortcode() . '<br>';
					$content_shortcode .= '[md_sc_flexmls_listings '.$location.' limit="'.mwp_get_limit().'" col="4" infinite="false" pagination="true"]';

					$page_location[$loc_id]['shortcode'] = $content_shortcode;
					$post_title		= $page_location[$loc_id]['value'];
					$post_insert_arg = array(
					  'post_title'    => $post_title,
					  'post_content'  => $page_location[$loc_id]['shortcode'],
					  'post_status'   => $post_status,
					  'post_author'   => $current_user->ID,
					  'post_type'	  => 'page',
					);

					$is_in_post = false;
					$post = get_page_by_title($post_title);
					$post_id = 0;
					if( $post ){
						$is_in_post = true;
						$post_id = $post->ID;
					}elseif( $model->md_query_page_title($post_title) ){
						$post = $model->md_query_page_title($post_title);
						$post_id = $post[0]->ID;
						$is_in_post = true;
					}

					$page_location['count']	= $count++;

					if( $is_in_post && $post_status == 'trash' ){
						wp_delete_post($post->ID, true);
					}elseif( $post_status == 'draft' || $post_status == 'publish' ){
						if( $is_in_post ){
							$post_arg = array(
								'ID' => $post_id,
								'post_status' => $post_status
							);
							wp_update_post( $post_arg );
						}else{
							$post_id = wp_insert_post( $post_insert_arg );
						}
					}
					//mark in the post_meta as breadcrumb
					update_post_meta($post_id, 'page_breadcrumb', 1);
					update_post_meta($post_id, 'page_title', $post_title);
					update_post_meta($post_id, 'location_id', $loc_id);
					update_post_meta($post_id, 'location_data', $page_location[$loc_id]);
				}
				
				wp_defer_term_counting( false );
				wp_defer_comment_counting( false );
			//}
		}
	}
}
