<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Load template
 * */
class Mwp_Admin_ShortCode_Crm_FeaturedProperty{
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
	
	public function get_transaction(){
		return array(
			'for sale' 		=> 'For Sale',
			'for rent' 		=> 'For Rent',
			'foreclosure' 	=> 'Foreclosure',
		);
	}
	
	public function get_template(){
		$path = mwp_default_template_dir();
		$replace_path = mwp_default_template_dir();
		$list = 'Featured';

		return Mwp_TemplateDetails::get_instance()->get_theme_page_template($path, $replace_path, $list);
	}
			
		
	/**
	 * Add shortcode JS to the page
	 *
	 * @return HTML
	 */
	public function md_get_shortcodes(){
		?>
			<script type="text/javascript">
				function crm_featured_properties(editor){
						var template = [
							<?php if( count($this->get_template()) > 0 ){ ?>
									<?php foreach($this->get_template() as $key=>$val){ ?>
											{text: '<?php echo $val; ?>',value: '<?php echo $key;?>'},
									<?php } ?>
							<?php } ?>
						];
						var transaction = [
							<?php if( count($this->get_transaction()) > 0 ){ ?>
									<?php foreach($this->get_transaction() as $key=>$val){ ?>
											{text: '<?php echo $val; ?>',value: '<?php echo $key;?>'},
									<?php } ?>
							<?php } ?>
						];
						var submenu_array =
						{
							text: '<?php _e('Featured Properties', mwp_localize_domain());?>',
							onclick: function() {
								editor.windowManager.open( {
									title: 'Display Featured CRM properties',
									width:980,
									height:350,
									body: [
										{
											type: 'listbox',
											name: 'listboxTemplate',
											label: '<?php _e('Choose template to display', mwp_localize_domain());?>',
											'values': template
										},
										{
											type: 'textbox',
											name: 'textboxGridCol',
											label: '<?php _e('Set property per columns ( should be divided by 12 )', mwp_localize_domain());?>',
											value:'1'
										},
										{
											type: 'textbox',
											name: 'textboxDisplay',
											label: '<?php _e('How many to display (zero means all)', mwp_localize_domain());?>',
											value:'0'
										},
										{
											type:'listbox',
											name:'listboxTransaction',
											label:'<?php _e('Choose Transaction', mwp_localize_domain());?>',
											'values':transaction
										},
									],
									onsubmit: function( e ) {
										var template_path = ' template="' + e.data.listboxTemplate + '" ';
										var col_grid = ' col="' + e.data.textboxGridCol + '" ';
										var transaction = ' transaction="' + e.data.listboxTransaction + '" ';
										var display = ' items="' + e.data.textboxDisplay + '" ';
										editor.insertContent(
											'[crm_featured_properties ' + template_path + col_grid + display + transaction + ']'
										);
									}
								});
							}
						};

						return submenu_array;
					}
			</script>
		<?php
	}
	
	public function init_shortcode($atts){
		global $crm_hook;
		
		$data = array();
		
		if( isset($atts['template']) ){
			$att_template = $atts['template'];
		}
		if( isset($atts['items']) ){
			$items = $atts['items'];
		}
		if( isset($atts['col']) && is_numeric($atts['col']) ){
			$col = $atts['col'];
		}

		$transaction = '';
		if( isset($atts['transaction']) ){
			$transaction = $atts['transaction'];
		}

		$atts = shortcode_atts(
			array(
				'template' 		=> $att_template,
				'col' 			=> $col,
				'transaction' 	=> $transaction,
				'items'			=> $items,
				'infinite'		=> false,
				'source'		=> 'crm',
			),
			$atts, 'crm_featured_properties'
		);
		$data['class'] = '';
		$user_id = null;
		$location_id = array();
		$atts['limit'] = mwp_get_limit();
		if( isset($atts['items']) && $atts['items'] != '0' ){
			$atts['limit'] = $atts['items'];
		}
		$query_arg = array(
			'search_keyword' => $atts,
			'featured' => array(
				'transaction' => array($transaction)
			),
			'property_single_photo' => 1
		);
		$q = new Mwp_CRM_PropertyQuery($query_arg);
		$template_filename = mwp_default_template_list_file();
		$container_template = Mwp_Theme_Locator::get_instance()->locate_template($template_filename);
		$loop_template = mwp_default_template_loop_list_file();
		$part_template = Mwp_Theme_Locator::get_instance()->locate_template('partials/' . $loop_template);
		$data['col'] = ceil( 12 / mwp_bootstrap_grid_col_md($col));
		$data['loop_data'] = $q;
		$data['show_pagination'] = true;
		if( isset($atts['pagination']) && $atts['pagination'] == 'false' ){
			$data['show_pagination'] = false;
		}

		$data['col'] = mwp_bootstrap_grid_col_md();
		if( isset($atts['col']) ){
			$data['col'] = $atts['col'];
		}
		$data['part_loop_template'] = $part_template;
		$data['location_name'] = '';
		$data['limit'] = $atts['limit'];
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
		//add_shortcode('crm_featured_properties', array($this,'init_shortcode'));
	}
}
