<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Load template
 * */
class Mwp_Admin_ShortCode_Flexmls_ListProperty{
	protected static $instance = null;
	protected $crm_adapter = null;
	protected $flexmls_adapter = null;
	protected $mls_property_fields = null;
	protected $property_fields = null;
	protected $flexmls_property_fields = null;
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
			'source' => 'flexmls',
		);
		return Mwp_AutocompleteLocation::get_instance()->build_location($arg);
	}
	
	public function flexmls_list_property_view(){
		$data =  array();
		$data['obj_this'] = $this;
		Mwp_View::get_instance()->admin_partials('shortcode/flexmls/list-property.php', $data);
		wp_die();
	}
	
	public function get_property_type(){
		$fields = $this->flexmls_property_fields->get_property_type();
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
				function md_sc_flexmls_shortcode(editor){
					var current_feed = 'flexmls';
					var flexmls_search_status = [{text: 'Active', value: 'Active'}];
					var flexmls_search_type = [
						{text: 'All', value: '0'},
						<?php if($this->get_property_type()){ ?>
							<?php foreach($this->get_property_type() as $key => $val ) { ?>
									{text: '<?php echo $val;?>', value: '<?php echo $key;?>'},
							<?php } ?>
						<?php } ?>
					];
					var submenu_array =
						{
							text:'<?php _e('Flexmls List Properties', mwp_localize_domain());?>',
							onclick: function() {
								editor.windowManager.open(
									{
										width:1000,
										height:600,
										title: '<?php _e('Insert Property by search criteria API', mwp_localize_domain());?>',
										file: ajaxurl + '?action=flexmls_list_property_view',
										inline:1,
									},
									{
										editor:editor,
										jquery:jQuery,
										search_type:flexmls_search_type,
										search_status:flexmls_search_status,
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
		$atts["expand"] = "PrimaryPhoto";
		
		$query_arg = array(
			'search_keyword' => $atts,
			'property_single_photo' => 0
		);
		$q = new Mwp_Flexmls_PropertyQuery($query_arg);
		
		$theme = Mwp_Theme_List::get_instance()->grid_layout();

		$template_filename = mwp_default_template_list_file();
		$container_template = Mwp_Theme_Locator::get_instance()->locate_template($template_filename);
		$part_template = Mwp_Theme_Locator::get_instance()->locate_template('partials/mwp-loop-property-list.php');
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
		if( isset($atts['limit']) && trim($atts['limit']) !='' ){
			set_query_var('limit',$atts['limit']);
		}
		$data['class'] = '';
		$data['location_name'] = '';
		ob_start();
		Mwp_View::get_instance()->display($container_template, $data);
		$output = ob_get_clean();
		return $output;
	}
	
	public function __construct(){
		if( mwp_has_flexmls() ){
			$this->crm_adapter = new Mwp_CRM_Adapter;
			$this->flexmls_adapter = new Mwp_Flexmls_Adapter;
			$this->flexmls_property_fields = new Mwp_Flexmls_PropertyFields;
			add_action('admin_footer', array($this, 'md_get_shortcodes'));
			add_action('wp_ajax_flexmls_list_property_view', array($this,'flexmls_list_property_view') );
			add_action('wp_ajax_nopriv_flexmls_list_property_view',array($this,'flexmls_list_property_view') );
			add_shortcode('md_sc_flexmls_listings', array($this,'init_shortcode'));
		}
	}
}
