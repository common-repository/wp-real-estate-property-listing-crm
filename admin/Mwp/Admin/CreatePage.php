<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * create property related page content
 * */
class Mwp_Admin_CreatePage{

	protected static $instance = null;

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

	public function __construct(){}

	/**
	 * Create Search Properties page
	 * in this plugin we are going to create two page
	 * 1) Search Properties - hold the list of all properties
	 * 2) Property - hold the single page for property
	 *
	 * @since 1.0.0
	 *
	 * @return object | resource
	 * */
	public function create_property_page(){
		$current_user 	= mwp_wp_get_current_user();
		$get_user_id 	= $current_user->ID;
		if( !get_page_by_title('State') ){
			$shortcode = '[md_list_properties_by_breadcrumb col="4" show_child="true" infinite="true" ]';
			$post = array(
			  'post_title'    => 'State',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}
		if( !get_page_by_title('County') ){
			$shortcode = '[md_list_properties_by_breadcrumb col="4" show_child="true" infinite="true" ]';
			$post = array(
			  'post_title'    => 'County',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}
		if( !get_page_by_title('City') ){
			$shortcode = '[md_list_properties_by_breadcrumb col="4" show_child="true" infinite="true" ]';
			$post = array(
			  'post_title'    => 'City',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}
		if( !get_page_by_title('Community') ){
			$shortcode = '[md_list_properties_by_breadcrumb col="4" show_child="true" infinite="true" ]';
			$post = array(
			  'post_title'    => 'Community',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}

		if( !get_page_by_title('Un Subscribe') ){
			$shortcode = '[md_sc_unsubscribe_api]';
			$post = array(
			  'post_title'    => 'Un Subscribe',
			  'post_name'     => 'unsubscribe',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $get_user_id,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}

		if( !get_page_by_title('My Account') ){
			$user_account = mwp_wp_get_current_user();
			$shortcode = Mwp_Admin_ShortCode_Subscriber::get_instance()->get_shortcode();
			$post = array(
			  'post_title'    => 'My Account',
			  'post_content'  => $shortcode,
			  'post_status'   => 'publish',
			  'post_author'   => $user_account->ID,
			  'post_type'	  => 'page',
			);
			wp_insert_post( $post );
		}
	}
}
