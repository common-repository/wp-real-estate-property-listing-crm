<?php
class Mwp_Admin_ShortCode_Subscriber{
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
		//add_shortcode('md_account',array($this,'init_shortcode'));
	}
	
	private function signup_template(){
		return Mwp_Actions_SignupForm::get_instance()->get_template_form();
	}

	public function init_shortcode($atts){
		$user = mwp_wp_get_current_user();
		$is_my_account_page = 0;
		$ret = array();
		$action = '';
		$task = '';
		$action_args = '';
		$content = '';
		if( is_user_logged_in() ){
			$content = 'default';
			$action_args = array();
			$action = '';
			if(!get_query_var('action')){
				$action_args = array(
					'action'=>'profile',
					'task'=>'edit',
				);
				$action = 'profile';
				Mwp_MyAccount_Dashboard::get_instance()->md_set_query_var($action_args);
			}else{
				$ret = Mwp_MyAccount_Dashboard::get_instance()->md_get_query_vars();
				$action = $ret->action;
				$task = $ret->task;
			}
			$template = Mwp_MyAccount_Dashboard::get_instance()->template();
		}else{
			$is_my_account_page = is_page('my-account');
			$template = $this->signup_template();
		}
		$data['ret'] = $ret;
		$data['action'] = $action;
		$data['task'] = $task;
		$data['action_args'] = $action_args;
		$data['content'] = $content;
		$data['user'] = $user;
		$data['is_my_account_page'] = $is_my_account_page;
		ob_start();
		Mwp_View::get_instance()->display($template, $data);
		$output = ob_get_clean();
		return $output;
	}

	public function get_shortcode(){
		return '[md_account]';
	}

	public function md_get_shortcodes(){
		?>
			<script type="text/javascript">
				function md_account(editor){
					var submenu_array =
						{
							text:'<?php _e('Subscriber Dashboard', mwp_localize_domain());?>',
							onclick: function() {
								editor.insertContent( '<?php echo $this->get_shortcode();?>');
							}
						};
					return submenu_array;
				}
			</script>
		<?php
	}

}
