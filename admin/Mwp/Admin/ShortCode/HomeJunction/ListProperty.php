<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Load template
 * */
class Mwp_Admin_ShortCode_HomeJunction_ListProperty{
	protected static $instance = null;
	protected $hji_adapter = null;
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
			'source' => 'crm',
		);
		return Mwp_AutocompleteLocation::get_instance()->build_location($arg);
	}
	
	public function list_property_view_hji(){
		$data =  array();
		$data['obj_this'] = $this;
		Mwp_View::get_instance()->admin_partials('shortcode/homejunction/list-property.php', $data);
		wp_die();
	}

	public function get_fields_type(){
		$type = $this->property_fields->get_property_type();
		return array();
	}
	
	/**
	 * Add shortcode JS to the page
	 *
	 * @return HTML
	 */
	public function md_get_shortcodes(){
		?>
			<script type="text/javascript">
				function md_sc_hji_shortcode(editor){
					var current_feed = '<?php echo mwp_hji_prefix();?>';

					var search_type = [];

					var submenu_array =
						{
							text:'<?php _e('HJI List Properties', mwp_localize_domain());?>',
							onclick: function() {
								editor.windowManager.open(
									{
										width:1000,
										height:600,
										title: '<?php _e('Insert Property by search criteria API', mwp_localize_domain());?>',
										file: ajaxurl + '?action=list_property_view_hji',
										inline:1,
									},
									{
										editor:editor,
										jquery:jQuery,
										search_type:search_type,
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

		$data['class'] = '';
		$atts['details'] = true;
		$query_arg = array(
			'search_keyword' => $atts
		);

		$q = new Mwp_HomeJunction_PropertyQuery($query_arg);
		$theme = Mwp_Theme_List::get_instance()->grid_layout();
		$template_filename = mwp_default_template_list_file();
		$container_template = Mwp_Theme_Locator::get_instance()->locate_template($template_filename);
		$part_template = Mwp_Theme_Locator::get_instance()->locate_template('partials/mwp-loop-property-list.php');
		$data['part_loop_template'] = $part_template;
		$data['shortcode_atts'] = $atts;
		$data['loop_data'] = $q;
		
		$data['show_pagination'] = true;
		if( isset($atts['pagination']) && $atts['pagination'] == 'false' ){
			$data['show_pagination'] = false;
		}
		if( isset($atts['limit']) && trim($atts['limit']) !='' ){
			set_query_var('limit',$atts['limit']);
		}
		$data['col'] = mwp_bootstrap_grid_col_md();
		if( isset($atts['col']) ){
			$data['col'] = $atts['col'];
		}
		$data['location_name'] = '';

		ob_start();
		Mwp_View::get_instance()->display($container_template, $data);
		$output = ob_get_clean();
		return $output;
	}
	
	public function __construct(){
		$this->hji_adapter = new Mwp_HomeJunction_Adapter;
		$this->property_fields = new Mwp_HomeJunction_PropertyFields();
		add_action('admin_footer', array($this, 'md_get_shortcodes'));
		add_action('wp_ajax_list_property_view_hji', array($this,'list_property_view_hji') );
		add_action('wp_ajax_nopriv_list_property_view_hji',array($this,'list_property_view_hji') );
		add_shortcode('hji_list_properties', array($this,'init_shortcode'));
	}
}
