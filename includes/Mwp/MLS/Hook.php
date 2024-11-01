<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Masterdigm CRM Model
 *
 * This class handles the CRM database like keys from Masterdigm
 *
 * @since      4
 * @package    Mwp
 * @subpackage Mwp/includes
 * @author     Allan Casilum <allan.paul.casilum@gmail.com>
 */
class Mwp_MLS_Hook{
	protected static $instance = null;
	public $plugin_obj;
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
	
	public function fields_type_mls(){
		$fields =  Mwp_CRM_PropertyFields::get_instance()->get_field_type();
		$fields_type = array();
		if( $fields ){
			$fields_type = $fields;
		}
		return $fields_type;
	}
	
	public function property_data($data = array()){
		if( isset($data['current_view']) && $data['current_view'] == 'map' ){
			$data['search_data']['limit'] = 1;
		}
		$query_arg = array(
			'search_keyword' => $data['search_data'],
			'property_single_photo' => 0,
		);

		$q = new Mwp_MLS_PropertyQuery($query_arg);
		return $q;
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
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_single_photo' => 1,
		);
		$loop_data = new Mwp_MLS_PropertyQuery($query_arg);

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
	public function md_single_property_mls($attr = array()){
		$search_data = array();
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => $attr['id'],
		);
		$loop_data = new Mwp_MLS_PropertyQuery($query_arg);
		return $loop_data;
	}
	
	public function property_nearby_property_mls($array_data){
		if($array_data['property_data']->has_property){
			$search_data	= array();
			$communityid 	= '';
			$cityid 		= '';
			$location 		= '';
			$property 		= $array_data['property_data']->property_data[0];

			$loc = Mwp_MLS_CoverageLookup::get_instance()->coverage_lookup();
			$ret = get_mls_hierarchy_location($property, $loc);

			if( isset($property->community_id) ){
				$communityid = $property->community_id;
			}else{
				if( isset($ret['city']) && isset($ret['city']['id']) && $ret['city']['id'] != 0 ){
					$cityid = $ret['city']['id'];
				}
				if( isset($ret['community']) && isset($ret['community']['id']) && $ret['community']['id'] != 0 ){
					$communityid = $ret['community']['id'];
					$cityid = '';
				}
			}
			$limit = 6;

			$type = '';
			if(
				isset($property->Type)
				&& $property->Type != ''
				|| strlen($type) >= 5
			){
				$type = $property->Type;
			}

			$max_price = 0;
			if( isset($property->ListPrice) && $property->ListPrice != 0 ){
				$max_price = $property->ListPrice;
			}

			$search_data['countyid'] 		= '';
			$search_data['stateid'] 		= '';
			$search_data['countyid'] 		= '';
			$search_data['countryid'] 		= '';
			$search_data['communityid'] 	= $communityid;
			$search_data['cityid'] 			= $cityid;
			$search_data['location'] 		= $location;
			$search_data['bathrooms'] 		= '';
			$search_data['bedrooms'] 		= '';
			$search_data['transaction'] 	= '';
			$search_data['property_type'] 	= $type;
			$search_data['property_status'] = '';
			$search_data['min_listprice'] 	= 0;
			$search_data['max_listprice'] 	= $max_price;
			$search_data['limit']			= $limit;
			
			$query_arg = array(
				'search_keyword' => $search_data,
				'property_id' => 0,
			);
			$similar_data = new Mwp_MLS_PropertyQuery($query_arg);
			return $similar_data;
		}
	}
	
	public function favorites_property_mls($p_id){
		$data = array();
		$search_keyword = array();
		$query_arg = array(
			'search_keyword' => $search_keyword,
			'property_id' => $p_id,
		);
		
		$q = new Mwp_MLS_PropertyQuery($query_arg);
		$data['loop_mls'] = $q;

		return $data;
	}

	public function xout_property_mls($p_id){
		$data = array();
		$search_keyword = array();
		$query_arg = array(
			'search_keyword' => $search_keyword,
			'property_id' => $p_id,
		);
		
		$q = new Mwp_MLS_PropertyQuery($query_arg);
		$data['loop_mls'] = $q;

		return $data;
	}
	public function breadcrumb($parse_url, $property_data = array()){
		$breadcrumb = array();
		$property = $property_data->property_data[0];
		$loc = Mwp_MLS_HookLocation::get_instance()->location_autocomplete();
		$city = '';
		$city_full = '';
		$state = '';
		$county = '';
		$community = '';
		$subdivision = '';
		$get_location_postalcode = array();
		$cnt_breadcrumb = 0;
		if( isset($loc->result) && $loc->result == 'success' ){
			foreach($loc->zips as $k => $v){
				if($property->PostalCode ==  $v->zip){
					$get_location_postalcode = $loc->zips[$k];
				}
			}
			foreach($get_location_postalcode as $loc_k => $loc_v){
				
			}
			$url_city = '#';
			$city_title_location = '';
			if( isset($get_location_postalcode->city) ){
				list($city_title_location) = explode(',', $get_location_postalcode->city);
				if( mwp_get_page_by_name($city_title_location) ){
					$url_city = esc_url( get_permalink( get_page_by_title( $city_title_location ) ) );
					$cnt_breadcrumb++;
				}elseif( mwp_get_page_by_name('city') ){
					$url_city = esc_url( get_permalink( get_page_by_title( 'city' ) ) ) . 'mls-'.$get_location_postalcode->city_id.'-'.urlencode($city_title_location);
					$cnt_breadcrumb++;
				}
			}
			$url_county = '#';
			$county_title_location = '';
			if( isset($get_location_postalcode->county) ){
				list($county_title_location) = explode(',', $get_location_postalcode->county);
				if( mwp_get_page_by_name($county_title_location) ){
					$url_county = esc_url( get_permalink( get_page_by_title( $county_title_location ) ) );
					$cnt_breadcrumb++;
				}elseif( mwp_get_page_by_name('city') ){
					$url_county = esc_url( get_permalink( get_page_by_title( 'county' ) ) ) . 'mls-'.$get_location_postalcode->county_id.'-'.urlencode($county_title_location);
					$cnt_breadcrumb++;
				}
			}
			$breadcrumb = array(
				'city' => array(
					'label' => $city_title_location,
					'url' => $url_city,
				),
				'county' => array(
					'label' => $county_title_location,
					'url' => $url_county,
				),
			);
			if( $cnt_breadcrumb > 0 ){
				return $breadcrumb;
			}
			return false;
		}
		return false;
	}
	
	public function get_property_by($id, $page_name){
		$search_data	= array();
		$community = array();
		$cityid = 0;
		$data['child'] = false;
		if( $page_name == 'city' ){
			$cityid = $id;
			$community_city_id = array('cityid'=>$id);
			$mls = new Mwp_MLS_Adapter;
			$child = $mls->get_communities_by_city_id($community_city_id);

			if( $child 	){
				foreach($child as $k => $v){
					$url_community = '#';
					$title_location = $v->community;
					if( mwp_get_page_by_name($title_location) ){
						$url_community = esc_url( get_permalink( get_page_by_title( $title_location ) ) );
					}elseif( mwp_get_page_by_name('community') ){
						$url_community = esc_url( get_permalink( get_page_by_title( 'community' ) ) ) . 'mls-'.$v->community_id.'-'.urlencode($title_location);
					}
					$data['child'][] = array(
						'label' => $title_location,
						'url' => $url_community,
					);
				}
			}
		}
		if( $page_name == 'community' ){
			$search_data['communityid']	= $id;
		}
		$search_data['cityid'] 	= $cityid;
		$search_data['pagination'] 	= 1;
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => 0,
		);

		$data['properties'] = new Mwp_MLS_PropertyQuery($query_arg);

		return $data;
	}
	
	public function create_location_page_action_mls_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$current_user = mwp_wp_get_current_user();
		$model = new Mwp_MLS_Model;
		$msg 	= '';
		$status = false;

		$page_location 	= array();
		//hook, get the default
		$account 					= Mwp_MLS_CoverageLookup::get_instance()->coverage_lookup();
		$shortcode_tag 				= 'mls_list_properties';

		if( isset($account->result) == 'success' ){
			$locations 	= $account->lookups;
			if( count($locations) > 0 ){

				$post_status = 'publish';
				if( isset($_POST['post_status']) ){
					$post_status = sanitize_text_field($_POST['post_status']);
				}

				$page_location['total']	= count($locations);
				$count = 0;

				wp_defer_term_counting(true);
				wp_defer_comment_counting(true);

				foreach($locations as $key => $val){
					$content_shortcode = '';
					$page_location['date_added'] 	= date("F j, Y, g:i a");
					list($title_location) = explode(',',$val->full);
					$page_location[$val->id]['full'] 			= $title_location;
					$page_location[$val->id]['location_type'] 	= $val->location_type;
					$page_location[$val->id]['id'] 				= $val->id;

					$location = $page_location[$val->id]['location_type'].'id';
					$id = $page_location[$val->id]['id'];

					$content_shortcode 	= '[md_sc_search_property_form template="/searchform/mwp-search-form.php" ]'.'<br>';
					$content_shortcode .= '['.$shortcode_tag.' '.$location.'="'.$id.'" limit="'.mwp_get_limit().'" col="4" infinite="true" pagination="true"]';

					$page_location[$val->id]['shortcode'] = $content_shortcode;
					$post_title		= $page_location[$val->id]['full'];
					$post_insert_arg = array(
					  'post_title'    => $post_title,
					  'post_content'  => $page_location[$val->id]['shortcode'],
					  'post_status'   => $post_status,
					  'post_author'   => $current_user->ID,
					  'post_type'	  => 'page',
					);
					$is_in_post = false;
					$post = get_page_by_title($page_location[$val->id]['full']);
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
					update_post_meta($post_id, 'location_id', $val->id);
					update_post_meta($post_id, 'location_data', $page_location[$val->id]);
				}

				wp_defer_term_counting( false );
				wp_defer_comment_counting( false );

				$option_name = 'create_page_by_location_'.date("m.d.Y.H.i.s");
				$date 		 = date("F j, Y, g:i a");
				$option_value = array(
					'data'=>$page_location,
					'date'=>$date
				);
				update_option($option_name, $option_value);
				$msg = 'Done, total '.$post_status.' page : '.$option_value['data']['count'];
				$status = true;
			}
		}
		echo json_encode(array('msg'=>$msg,'status'=>$status));
		die();
	}
	public function md_single_property_pdf($attr = array()){
		$search_data = array();
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => $attr['id'],
		);
		$loop_data = new Mwp_MLS_PropertyQuery($query_arg);
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
		$data['pagination']  = 1;
		$data['search_data'] = $search_query;
		$query_arg = array(
			'search_keyword' => $data['search_data'],
			'property_single_photo' => 0,
		);
		$q = new Mwp_MLS_PropertyQuery($query_arg);
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
}
