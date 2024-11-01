<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Load template
 * */
class Mwp_Admin_ShortCode_Mls_ListProperty{
	protected static $instance = null;
	protected $mls_adapter = null;
	protected $crm_adapter = null;
	protected $mls_property_fields = null;
	protected $property_fields = null;
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
	
	public function get_location($keyword = 'full', $output = 'json'){
		$json = array();
		$arg = array(
			'keyword' => $keyword,
			'output' => $output,
			'source' => 'mls',
		);
		$json = Mwp_AutocompleteLocation::get_instance()->build_location($arg);
		if( $json && count($json) > 0 ){
			return $json;
		}
		return json_encode($json);
	}
	
	public function mls_list_property_view(){
		$data =  array();
		$data['obj_this'] = $this;
		Mwp_View::get_instance()->admin_partials('shortcode/mls/list-property.php', $data);
		wp_die();
	}
	
	public function get_fields_status(){
		$fields = $this->mls_property_fields->get_field_status();
		if( $fields ){
			return $fields;
		}
		return false;
	}

	public function get_fields_type(){
		$fields = $this->mls_property_fields->get_property_type();
		if( $fields ){
			return $fields;
		}
		return false;
	}
	
	/**
	 * Add shortcode JS to the page
	 *
	 * @return HTML
	 */
	public function md_get_shortcodes(){
		?>
			<script type="text/javascript">
				function mls_list_properties(editor){
					var current_feed = 'mls';
					var search_status = [
						<?php if( $this->get_fields_status() ){ ?>
							<?php foreach($this->get_fields_status() as $key => $val ) { ?>
									{text: '<?php echo $val;?>', value: '<?php echo $key;?>'},
							<?php } ?>
						<?php } ?>
					];

					var search_type = [
						<?php if( $this->get_fields_type() ){ ?>
								  {text: 'All', value: '0'},
							<?php foreach($this->get_fields_type() as $key => $val ) { ?>
									{text: '<?php echo $val;?>', value: '<?php echo $key;?>'},
							<?php } ?>
						<?php } ?>
					];

					var submenu_array =
						{
							text:'<?php _e('List Properties', mwp_localize_domain());?>',
							onclick: function() {
								editor.windowManager.open(
									{
										width:1000,
										height:600,
										title: '<?php _e('Insert Property by search criteria API MLS', mwp_localize_domain());?>',
										file: ajaxurl + '?action=mls_list_property_view',
										inline:1,
									},
									{
										editor:editor,
										jquery:jQuery,
										search_type:search_type,
										search_status:search_status,
										mdajax:MDAjax,
										current_feed:current_feed
									}
								);
							}
						};
					return submenu_array;
				}
			</script>
		<?php
	}
	
	public function init_shortcode($atts){
		$data = array();
		
		$paged = 1;
		if( isset($_REQUEST['paged']) ){
			$atts['paged'] = $_REQUEST['paged'];
		}elseif( get_query_var( 'paged' ) ){
			$atts['paged'] = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ):$paged;
		}
		$listing_office_id = '';
		if( isset($atts['listing_office_id']) && $atts['listing_office_id'] == 'true' ){
			$listing_office_id = Mwp_CRM_AccountDetails::get_instance()->get_account_data('listing_office_id');
		}
		if( isset($atts['limit']) && trim($atts['limit']) !='' ){
			set_query_var('limit',$atts['limit']);
		}
		$atts['listing_office_id'] = $listing_office_id;
		$query_arg = array(
			'search_keyword' => $atts,
			'property_single_photo' => 0
		);
		$q = new Mwp_MLS_PropertyQuery($query_arg);
		$theme = Mwp_Theme_List::get_instance()->grid_layout();

		$template_filename = mwp_default_template_list_file();
		$container_template = Mwp_Theme_Locator::get_instance()->locate_template($template_filename);
		$loop_template = mwp_default_template_loop_list_file();
		$part_template = Mwp_Theme_Locator::get_instance()->locate_template('partials/' . $loop_template);
		$data['part_loop_template'] = $part_template;
		$data['shortcode_atts'] = $atts;
		$data['loop_data'] = $q;
		$data['col'] = mwp_bootstrap_grid_col_md();
		if( isset($atts['col']) ){
			$data['col'] = $atts['col'];
		}
		$data['show_pagination'] = true;
		if( isset($atts['pagination']) && $atts['pagination'] == 'false' ){
			$data['show_pagination'] = false;
		}
		$data['class'] = '';
		$data['location_name'] = '';
		ob_start();
		Mwp_View::get_instance()->display($container_template, $data);
		$output = ob_get_clean();
		return $output;
	}
	
	public function __construct(){
		$this->mls_adapter = new Mwp_MLS_Adapter;
		$this->crm_adapter = new Mwp_CRM_Adapter;
		$this->property_fields = new Mwp_CRM_PropertyFields($this->crm_adapter);
		$this->mls_property_fields = new Mwp_MLS_PropertyFields();
		add_action('admin_footer', array($this, 'md_get_shortcodes'));
		add_action('wp_ajax_mls_list_property_view', array($this,'mls_list_property_view') );
		add_action('wp_ajax_nopriv_mls_list_property_view',array($this,'mls_list_property_view') );
		add_shortcode('mls_list_properties', array($this,'init_shortcode'));
	}
}
