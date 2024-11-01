<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_ImportOld{

	protected static $instance = null;

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

	public function run(){
		$option = get_option('plugin-settings');
		if( $option ){
			$old_setting_array = md_options_plugin_settings();
			$masterdigm_prefix = md_get_options_db('masterdigm_');
			$md_prefix = md_get_options_db('md_');
			$save_search = get_option('save-search');
			//import settings
			//--popup
			if(isset($old_setting_array['showpopup']) ){
				$popup = array(
					'masterdigm_popup_show' => $old_setting_array['showpopup']['show'],
					'masterdigm_popup_close' => $old_setting_array['showpopup']['close'],
					'masterdigm_popup_clicks' => $old_setting_array['showpopup']['clicks'], 
				);
				Mwp_Admin_Settings_Popup_DBEntity::get_instance()->update_popup_data($popup);
			}
			//--popup
			//--mail
			if(isset($old_setting_array['mail']) ){
				$mail_server = '';
				if(isset($old_setting_array['mail']['server'])){
					$mail_server = $old_setting_array['mail']['server'];
				}
				$mail_content = '';
				if(isset($old_setting_array['mail']['content'])){
					$mail_content = $old_setting_array['mail']['content'];
				}
				$mail_subject = '';
				if(isset($old_setting_array['mail']['subject'])){
					$mail_subject = $old_setting_array['mail']['subject'];
				}
				$mail = array(
					'subject' => $mail_subject,
					'md_mail_content' => $mail_content,
					'mail_server' => $mail_server, 
				);
				Mwp_Admin_Settings_Mail_DBEntity::get_instance()->db_update_mail($mail);
			}
			//--mail
			//--lead
			if(isset($old_setting_array['lead'])){
				$lead = array(
					'lead_status' => $old_setting_array['lead']['status'],
					'lead_type' => $old_setting_array['lead']['type'],
					'lead_source' => $old_setting_array['lead']['source'], 
				);
				Mwp_Admin_Settings_Clientlead_DBEntity::get_instance()->update_lead($lead);
			}
			//--lead
			//--search
			if(isset($old_setting_array['search']) ){
				$search = array(
					'setting_search_title' => $old_setting_array['search']['title'],
					'search_forsale_button' => 'y',
					'search_forrent_button' => 'y', 
					'property_status' => isset($old_setting_array['search_criteria']['status']) ? $old_setting_array['search_criteria']['status']:'', 
				);
				Mwp_Admin_Search_DBEntity::get_instance()->db_update_general_search($search);
			}
			
			//--search
			//--price_range
			if(isset($old_setting_array['price_range']) ){
				$price_range = array();
				if( isset($old_setting_array['price_range']['ten']) ){
					$price_range['price_range_ten_start'] = $old_setting_array['price_range']['ten']['start'];
					$price_range['price_range_ten_end'] = $old_setting_array['price_range']['ten']['end'];
					$price_range['price_range_ten_step'] = $old_setting_array['price_range']['ten']['step'];
				}
				if( isset($old_setting_array['price_range']['hundred']) ){
					$price_range['price_range_hundred_start'] = $old_setting_array['price_range']['hundred']['start'];
					$price_range['price_range_hundred_end'] = $old_setting_array['price_range']['hundred']['end'];
					$price_range['price_range_hundred_step'] = $old_setting_array['price_range']['hundred']['step'];
				}
				if( isset($old_setting_array['price_range']['million']) ){
					$price_range['price_range_million_start'] = $old_setting_array['price_range']['million']['start'];
					$price_range['price_range_million_end'] = $old_setting_array['price_range']['million']['end'];
					$price_range['price_range_million_step'] = $old_setting_array['price_range']['million']['step'];
				}
				Mwp_Admin_Search_Pricerange_DBEntity::get_instance()->db_update_price_range($price_range);
			}

			//--price_range
			//--theme/property
			if(isset($old_setting_array['property']) ){
				$property_bookaviewingurl = isset($old_setting_array['property']['bookaviewingurl']) ? $old_setting_array['property']['bookaviewingurl']:'';
				$property_name = isset($old_setting_array['property']['name']) ? $old_setting_array['property']['name']:'';
				$theme_property = array(
					'property_name' => $property_name,
					'property_bookaviewingurl' => $property_bookaviewingurl,
				);
				Mwp_Admin_Theme_Property_DBEntity::get_instance()->db_update($theme_property);
			}
			//--theme/property
			//--theme/style
			//--theme/style
			//--property-alert
			$property_alert = array();
			if(get_option('success-unsubscribe')){
				$property_alert['success-unsubscribe'] = get_option('success-unsubscribe');
				Mwp_Propertyalert_Model::get_instance()->success_unsubscribe('u',$property_alert['success-unsubscribe']);
			}
			if(get_option('fail-unsubscribe')){
				$property_alert['fail-unsubscribe'] = get_option('fail-unsubscribe');
				Mwp_Propertyalert_Model::get_instance()->fail_unsubscribe('u',$property_alert['fail-unsubscribe']);
			}
			//--property-alert
			//--flexmls
			if(get_option('md_flexmls_api_key')){
				$md_flexmls_api_key = get_option('md_flexmls_api_key');
				Mwp_API_Flexmls_Model::get_instance()->md_flexmls_api_key('u',$md_flexmls_api_key);
			}
			if(get_option('md_flexmls_api_secret')){
				$md_flexmls_api_secret['md_flexmls_api_secret'] = get_option('md_flexmls_api_secret');
				Mwp_API_Flexmls_Model::get_instance()->md_flexmls_api_secret('u',$md_flexmls_api_secret);
			}
			//--flexmls
			//--md_greatschool_api_key
			if(get_option('md_greatschool_api_key')){
				$md_greatschool_api_key = get_option('md_greatschool_api_key');
				Mwp_API_Greatschool_Model::get_instance()->md_greatschool_api_key('u',$md_greatschool_api_key);
			}
			//--md_greatschool_api_key
			//import the crm keys
			$api_key = md_api_key();
			$api_token = md_api_token();
			$broker_id = get_option('broker_id');
			$property_data_feed = get_option('property_data_feed');
			$crm_keys = array(
				'settings_api_key' => $api_key,
				'settings_api_token' => $api_token,
				'settings_api_broker_id' => $broker_id,
				'settings_api_default_feed' => $property_data_feed,
			);

			Mwp_Admin_Settings_CRMkeyEntity::get_instance()->put_update_api($crm_keys);
			//import the crm keys
			mwp_del_page();
			//back up and rename plugin settings
			$old_plugin_settings = get_option('plugin-settings');
			update_option('md_old_plugin-settings', $old_plugin_settings);
			delete_option('plugin-settings');
		}
	}
	
}
