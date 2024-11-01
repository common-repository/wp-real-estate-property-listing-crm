<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_AutocompleteLocation{
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
	
	public function get_current_api_source(){
		return mwp_get_current_api_source();
	}
	/**
	 * @param $arg  array accept values
	 * $arg['keyword']
	 * $arg['output']
	 * - output is json or aaray (associative array)
	 * */
	public function build_location($arg = array()){
		$source = $this->get_current_api_source();
		if( isset($arg['source']) && $arg['source'] != '' ){
			$source = $arg['source'];
		}
		return apply_filters('location_lookup_build_' . $source, $arg);
	}
	
	public function get_location($keyword = 'full'){
		global $plugin;
		$source = $this->get_current_api_source();
		$location = null;

		$location_lookup = apply_filters('location_lookup_' . $source, $location, $keyword);
		return $location_lookup;
	}
	
	public function print_footer_scripts() {
        ?>
			<script type="text/javascript">
				var mwp_locations = <?php echo Mwp_AutocompleteLocation::get_instance()->build_location(); ?>;
			</script>
		<?php
    }
    
    public function init($id){
		//add_action('wp_footer', array($this,'print_footer_scripts'));
	}
	
}
