<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Load template
 * */
class Mwp_Admin_ShortCode_Crm_ListProperty{
	protected static $instance = null;
	protected $crm_adapter = null;
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
	
	public function list_property_view_crm(){
		$data =  array();
		$data['obj_this'] = $this;
		Mwp_View::get_instance()->admin_partials('shortcode/crm/list-property.php', $data);
		wp_die();
	}
	
	public function get_fields_status(){
		$fields = $this->property_fields->get_field_status();
		if( $fields ){
			return $fields;
		}
		return false;
	}

	public function get_fields_type(){
		$fields = $this->property_fields->get_field_type();
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
				function crm_list_properties(editor){
					var current_feed = 'crm';
					var search_status = [
						<?php if( $this->get_fields_status() ){ ?>
									{text: 'All', value: '0'},
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
										title: '<?php _e('Insert Property by search criteria API', mwp_localize_domain());?>',
										file: ajaxurl + '?action=list_property_view_crm',
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
		if( isset($atts['limit']) && trim($atts['limit']) !='' ){
			set_query_var('limit',$atts['limit']);
		}
		$data['class'] = '';
		$query_arg = array(
			'search_keyword' => $atts,
			'property_single_photo' => 1
		);
		
		$q = new Mwp_CRM_PropertyQuery($query_arg);
		//$q = array();
		$theme = Mwp_Theme_List::get_instance()->grid_layout();

		$template_filename = mwp_default_template_list_file();
		$container_template = Mwp_Theme_Locator::get_instance()->locate_template($template_filename);
		$loop_template = mwp_default_template_loop_list_file();
		$part_template = Mwp_Theme_Locator::get_instance()->locate_template('partials/' . $loop_template);
		$data['part_loop_template'] = $part_template;
		$data['shortcode_atts'] = $atts;
		$data['loop_data'] = $q;
		
		$data['show_pagination'] = true;
		if( isset($atts['pagination']) && $atts['pagination'] == 'false' ){
			$data['show_pagination'] = false;
		}

		$data['col'] = mwp_bootstrap_grid_col_md();
		if( isset($atts['col']) ){
			$data['col'] = $atts['col'];
		}
		$data['location_name'] = '';

		ob_start();
		//echo $container_template;
		Mwp_View::get_instance()->display($container_template, $data);
		$output = ob_get_clean();
		return $output;
	}
	
	public function __construct(){
		$this->crm_adapter = new Mwp_CRM_Adapter;
		$this->property_fields = new Mwp_CRM_PropertyFields($this->crm_adapter);
		add_action('admin_footer', array($this, 'md_get_shortcodes'));
		add_action('wp_ajax_list_property_view_crm', array($this,'list_property_view_crm') );
		add_action('wp_ajax_nopriv_list_property_view_crm',array($this,'list_property_view_crm') );
		//add_shortcode('crm_list_properties', array($this,'init_shortcode'));
	}
}
