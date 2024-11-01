<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Load template
 * */
class Mwp_Admin_ShortCode_SearchForm{
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
	
	public function get_template(){
		$path = mwp_search_form_template_dir();
		$replace_path = mwp_default_template_dir();
		$list = 'Search Form Shortcode';

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
				function md_search_form(editor){
					var template = [
						<?php if( count($this->get_template()) > 0 ){ ?>
								<?php foreach($this->get_template() as $key=>$val){ ?>
										{text: '<?php echo $val; ?>',value: '<?php echo $key;?>'},
								<?php } ?>
						<?php } ?>
					];
					var submenu_array =
					{
						text: '<?php _e('Search Property Form', mwp_localize_domain());?>',
						onclick: function() {
							editor.windowManager.open( {
								title: '<?php _e('Search Property Form', mwp_localize_domain());?>',
								width:980,
								height:350,
								body: [
									{
										type: 'listbox',
										name: 'listboxTemplate',
										label: '<?php _e('Choose template UI', mwp_localize_domain());?>',
										'values': template
									},
								],
								onsubmit: function( e ) {
									var template_path = ' template="' + e.data.listboxTemplate + '" ';
									editor.insertContent(
										'[md_sc_search_property_form ' + template_path + ']'
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
		$data = array();
		
		$template = mwp_search_form_template_path();
		if( isset($atts['template']) ){
			$template = $atts['template'];
		}
		
		$part_template = Mwp_Theme_Locator::get_instance()->locate_template($template);
		//hook the template
		$part_template = apply_filters('mwp_hook_search_template_form', $part_template);
		
		ob_start();
		Mwp_View::get_instance()->display($part_template, $data);
		$output = ob_get_clean();
		return $output;
	}
	
	public function __construct(){
		add_action('admin_footer', array($this, 'md_get_shortcodes'));
		//add_shortcode('md_sc_search_property_form', array($this,'init_shortcode'));
	}
}
