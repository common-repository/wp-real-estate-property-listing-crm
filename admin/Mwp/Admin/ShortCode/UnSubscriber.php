<?php
class Mwp_Admin_ShortCode_UnSubscriber{
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
		//add_shortcode('md_sc_unsubscribe_api',array($this,'init_shortcode'));
	}

	public function init_shortcode(){
		$email = null;
		if( isset($_GET['email']) && sanitize_text_field($_GET['email']) ){
			$email = sanitize_email($_GET['email']);
		}
		if( isset($_POST['email']) && sanitize_text_field($_POST['email']) ){
			$email = sanitize_email($_POST['email']);
		}
		$return = Mwp_Propertyalert_Entity::get_instance()->crm_unsubscribe($email);

		ob_start();
		if( $return ){
			$msg = Mwp_Propertyalert_Model::get_instance()->success_unsubscribe();
		}else{
			$msg = Mwp_Propertyalert_Model::get_instance()->fail_unsubscribe();
		}
		echo $msg;
		$output = ob_get_clean();
		return $output;
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
				function md_sc_unsubscribe_api(editor){
					var submenu_array =
						{
							text:'<?php _e('Unsubscribe Process', mwp_localize_domain());?>',
							onclick: function() {
								editor.insertContent( '[md_sc_unsubscribe_api]');
							}
						};
					return submenu_array;
				}
			</script>
		<?php
	}

}
