<?php
class Mwp_Admin_ShortCode_Breadcrumb{
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

	public function __construct(){
		add_action('admin_footer', array($this, 'md_get_shortcodes'));
		add_shortcode('md_list_properties_by_breadcrumb', array($this,'init_shortcode'));
	}

	public function init_shortcode($atts){
		global $wp_query;

		$data = false;
		if( $wp_query && isset($wp_query->query['url']) ){
			$parse = explode('-', $wp_query->query['url']);
			$source = '';
			$property_id = '';
			foreach($parse as $k => $v){
				if( in_array($v, mwp_valid_api()) ){
					$source = $v;
					$property_id = $parse[$k+1];
				}
			}
			$page_name = $wp_query->query_vars['pagename'];
			if( has_filter('get_property_by_' . $source) ){
				$data = apply_filters('get_property_by_' . $source, $property_id, $page_name);
			}
		}
	
		if( $data ){
			$template = Mwp_Theme_Locator::get_instance()->locate_template('mwp-property-list-by.php');
			$data['part_loop_template'] = Mwp_Theme_Locator::get_instance()->locate_template('partials/mwp-loop-property-list.php');
			$data['show_pagination'] = true;
			$data['col'] = $atts['col'];
			$data['show_child'] = ($atts['show_child'] == 'true') ? true:false;

			ob_start();
			Mwp_View::get_instance()->display($template, $data);
			$output = ob_get_clean();
			return $output;
		}
	}

	/**
	 * Add shortcode JS to the page
	 *
	 * @return HTML
	 */
	public function md_get_shortcodes()
	{
		?>
			<script type="text/javascript">
				function md_list_properties_by(editor){
					var submenu_array =
					{
						text: '<?php _e('List Property By Location', mwp_localize_domain());?>',
						onclick: function() {
							editor.windowManager.open( {
								title: '<?php _e('Display properties base on breadcrumb url landing page or url filter by breadcrumb.', mwp_localize_domain());?>',
								width:1120,
								height:350,
								body: [
									{
										type: 'textbox',
										name: 'textboxGridCol',
										label: '<?php _e('Set property per columns ( should be divided by 12 )', mwp_localize_domain());?>',
										width: 50,
										value:'1'
									},
									{
										type: 'checkbox',
										name: 'checkboxShowChild',
										label: '<?php _e('Show child location? If the location is state it will show list of city, if its city it will show list of communities', mwp_localize_domain());?>',
										checked:false
									},
									{
										type: 'checkbox',
										name: 'checkboxShowInfiniteScroll',
										label: '<?php _e('Show Pagination?', mwp_localize_domain());?>',
										checked:false
									},
								],
								onsubmit: function( e ) {
									var col_grid 	= ' col="' + e.data.textboxGridCol + '" ';
									var show_child 	= ' show_child="' + e.data.checkboxShowChild + '" ';
									var infinite 	= ' infinite="' + e.data.checkboxShowInfiniteScroll + '" ';
									editor.insertContent(
										'[md_list_properties_by_breadcrumb ' + col_grid + show_child + infinite + ']'
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
}
