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
class Mwp_CRM_Hook{
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
	
	public function fields_type_crm(){
		$fields =  Mwp_CRM_PropertyFields::get_instance()->get_field_type();
		$fields_type = array();
		if( $fields ){
			$fields_type = $fields;
		}
		return $fields_type;
	}
	
	public function property_data($data = array()){
		if( $data['current_view'] == 'map' ){
			$data['search_data']['limit'] = 25;
		}
		$query_arg = array(
			'search_keyword' => $data['search_data'],
			'property_single_photo' => 1,
		);
		
		$q = new Mwp_CRM_PropertyQuery($query_arg);
		return $q;
	}
	
	public function get_property_data_crm(){
		$_data = array();
		$setup_data = array();
		$search_property_data = urldecode(stripslashes($_GET['search_property_data']));
		$search_data = json_decode($search_property_data, true);
		$map_boundaries = urldecode(stripcslashes($_GET['map_boundaries']));
		$map_boundaries = json_decode($map_boundaries, true);
		
		if( $_GET['current_view'] == 'map' ){
			$search_data['limit'] = 25;
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
		$loop_data = new Mwp_CRM_PropertyQuery($query_arg);
		if( $loop_data->loop_property() ):
			$index = 0;
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
					'source' => 'crm',
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
	
	public function md_single_property_crm($attr = array()){
		$search_data = array();
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => $attr['id']
		);
		$loop_data = new Mwp_CRM_PropertyQuery($query_arg);
		return $loop_data;
	}

	public function md_single_property_pdf_crm($attr = array()){
		$search_data = array();
		$query_arg = array(
			'search_keyword' => $search_data,
			'property_id' => $attr['id'],
		);
		$loop_data = new Mwp_CRM_PropertyQuery($query_arg);
		return $loop_data;
	}
	
	public function property_nearby_property_crm($array_data){
		if($array_data['property_data']->has_property){
			$property_data = $array_data['property_data']->property_data[0];
			$communityid = '';
			$cityid = '';

			if( isset($property_data->communityid) == 0 ){
				$communityid = $property_data->communityid;
				$city = '';
			}elseif( isset($property_data->cityid) ){
				$cityid = $property_data->cityid;
				$communityid = '';
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
			$search_data['transaction'] 	= $property_data->transaction_type;
			$search_data['property_type'] 	= $property_data->property_type;
			$search_data['property_status'] = $property_data->property_status;
			$search_data['min_listprice'] 	= 0;
			$search_data['max_listprice'] 	= 0;
			$search_data['orderby'] 		= '';
			$search_data['order_direction']	= '';
			$search_data['limit']			= $limit;
			$query_arg = array(
				'search_keyword' => $search_data,
				'property_id' => 0,
				'property_single_photo' => 1
			);
			$similar_data = new Mwp_CRM_PropertyQuery($query_arg);
			return $similar_data;
		}
	}
	
	public function favorites_property_crm($p_id){
		$data = array();
		$search_keyword = array();
		$query_arg = array(
			'search_keyword' => $search_keyword,
			'property_id' => $p_id,
			'property_single_photo' => 1
		);
		$q = new Mwp_CRM_PropertyQuery($query_arg);

		$data['loop_crm'] = $q;

		return $data;
	}

	public function xout_property_crm($p_id){
		$data = array();
		$search_keyword = array();
		$query_arg = array(
			'search_keyword' => $search_keyword,
			'property_id' => $p_id,
			'property_single_photo' => 1
		);
		
		$q = new Mwp_CRM_PropertyQuery($query_arg);
		$data['loop_crm'] = $q;

		return $data;
	}
	
	public function breadcrumb($parse_url, $property_data = array()){
		$breadcrumb = array();
		$property = $property_data->property_data[0];
		$arg = array('output' => 'aarray', 'keyword'=> 'keyword');
		$loc = Mwp_CRM_HookLocation::get_instance()->location_autocomplete($arg);
		$city = '';
		$city_full = '';
		$state = '';
		$community = '';
		$subdivision = '';
		if( isset($loc->result) && $loc->result == 'success' ){
			foreach($loc->lookups as $k => $v){
				if( $property->cityid == $v->id && $v->location_type == 'city' ){
					$city = $v->keyword;
					$city_full = $v->full;
				}
				if( $property->communityid == $v->id && $v->location_type == 'community' ){
					$community = $v->keyword;
				}
				if( $property->subdivisionid == $v->id && $v->location_type == 'subdivision' ){
					$subdivision = $v->keyword;
				}
			}
			//show city
			//show state
			$url_city = '#';
			list($city_title_location) = explode(',',$city_full);
			if( mwp_get_page_by_name($city_title_location) ){
				$url_city = esc_url( get_permalink( get_page_by_title( $city_title_location ) ) );
			}elseif( mwp_get_page_by_name('city') ){
				$url_city = esc_url( get_permalink( get_page_by_title( 'city' ) ) ) . 'crm-'.$property->cityid.'-'.urlencode($city_title_location);
			}
			if( $city_title_location != '' ){
				$breadcrumb = array(
					'city' => array(
						'label' => $city_title_location,
						'url' => $url_city,
					)
				);
			}
			return $breadcrumb;
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
			$community_city_id = array('city_id'=>$id);
			$crm = new Mwp_CRM_Adapter;
			$child = $crm->get_communities_by_cityId($community_city_id);
			if( $child 
				&& isset($child->result)
				&& $child->result == 'success'
			){
				foreach($child->communities as $k => $v){
					$url_community = '#';
					$title_location = $v->community_name;
					if( mwp_get_page_by_name($title_location) ){
						$url_community = esc_url( get_permalink( get_page_by_title( $title_location ) ) );
					}elseif( mwp_get_page_by_name('community') ){
						$url_community = esc_url( get_permalink( get_page_by_title( 'community' ) ) ) . 'crm-'.$v->community_id.'-'.urlencode($title_location);
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

		$data['properties'] = new Mwp_CRM_PropertyQuery($query_arg);
		return $data;
	}
	
	public function create_location_page_action_crm_callback(){
		check_ajax_referer( 'md-ajax-request', 'security' );
		$current_user = mwp_wp_get_current_user();

		$msg 	= '';
		$status = false;

		$page_location 	= array();
		//hook, get the default
		$account 					= Mwp_CRM_CoverageLookup::get_instance()->coverage_lookup();
		$shortcode_tag 				= 'crm_list_properties';

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

					$content_shortcode 	= '[md_sc_search_property_form template="/searchform/search-form.php" ]'.'<br>';

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

					$post = get_page_by_title($page_location[$val->id]['full']);

					$page_location['count']	= $count++;

					if( $post && $post_status == 'trash' ){
						wp_delete_post($post->ID, true);
					}elseif( $post_status == 'draft' || $post_status == 'publish' ){
						if( $post ){
							$post_id = $post->ID;
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
			'property_single_photo' => 1,
		);
		$q = new Mwp_CRM_PropertyQuery($query_arg);
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
	
	public function mwp_hook_featured_img($mwp_loop, $pm_img){
		if( $mwp_loop->get_data()->is == 'featured_property' ){
			$p_img = $mwp_loop->property_details_image_data;
			$curr_id = $mwp_loop->get_data()->id();
			if( isset($p_img[$curr_id][0]) ){
				return $p_img[$curr_id][0];
			}
		}
		return $pm_img;
	}
}
