<?php
class Mwp_Admin_ShortCode_Init{
	protected static $instance = null;
	public $parent_menu_label = 'Masterdigm API';
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
	
	/**
     * Create a shortcode button for tinymce
     *
     * @return [type] [description]
     */
    public function md_shortcode_button(){
        if( current_user_can('edit_posts') &&  current_user_can('edit_pages') ){
            add_filter( 'mce_external_plugins', array($this, 'md_add_buttons' ));
            add_filter( 'mce_buttons', array($this, 'md_register_buttons' ));
        }
    }
    
    /**
     * Add new Javascript to the plugin scrippt array
     *
     * @param  Array $plugin_array - Array of scripts
     *
     * @return Array
     */
    public function md_add_buttons( $plugin_array ){
		global $mwp;

        $plugin_array['mdshortcodes'] = $mwp['plugin_path']['admin_url_path'] . 'js/shortcode-tinymce-button.js';

        return $plugin_array;
    }
    
    /**
     * Add new button to tinymce
     *
     * @param  Array $buttons - Array of buttons
     *
     * @return Array
     */
    public function md_register_buttons( $buttons ){
        array_push( $buttons, 'separator', 'mdshortcodes' );
        return $buttons;
    }
    
    /**
     * Add shortcode JS to the page
     *
     * @return HTML
     */
    public function md_get_shortcodes(){
        ?>
			<script type="text/javascript">
				var menu_button_label 	= 'Masterdigm API';
				var has_mls_key 		= '<?php echo mwp_has_crm_credentials() ? 1:0;?>';
				var has_crm_key 		= '<?php echo mwp_has_crm_credentials() ? 1:0;?>';
				var has_flexmls_key 	= '<?php echo mwp_has_flexmls() ? 1:0;?>';
				var has_homejunction_conn 	= '0';

				if( has_flexmls_key == '0' ){
					function md_sc_flexmls_shortcode(editor){}
				}
				if( has_homejunction_conn == '0' ){
					function md_sc_hji_shortcode(editor){}
				}
			</script>
        <?php
    }
    
	public function __construct(){
        add_action('admin_init', array($this, 'md_shortcode_button'));
		add_action('admin_footer', array($this, 'md_get_shortcodes'));
    }
}
