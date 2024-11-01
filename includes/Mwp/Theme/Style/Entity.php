<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Theme_Style_Entity{
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
	
	public function mwp_wp_styling(){
		$styling = new Mwp_Admin_Theme_Style_DBEntity;
		?>
<style type='text/css' media='screen'>
.navbar-collapse {background-color: <?php echo $styling->get_mwp_header_secondary_background_color();?>;}
.navbar-collapse {color: <?php echo $styling->get_mwp_header_secondary_font_color();?>;}
.navbar-collapse a {color:<?php echo $styling->get_mwp_header_secondary_font_color();?>;}
.navbar-collapse {border-color:<?php echo $styling->get_mwp_header_border_color();?>;}
.nav-bar {background-color:<?php echo $styling->get_mwp_header_main_background_color();?>;}
.nav-bar {color:<?php echo $styling->get_mwp_header_primary_font_color();?>;}
.nav-bar a {color:<?php echo $styling->get_mwp_header_secondary_font_color();?>;}
#advanced_search .mwp-theme-bk-color {color:<?php echo $styling->get_mwp_header_secondary_font_color();?>;}
#advanced_search .mwp-theme-bk-color {background-color:<?php echo $styling->get_mwp_button_secondary_background();?>;}
.nav-bar {border-color:<?php echo $styling->get_mwp_header_border_color();?>;}
#advanced_search .mwp-theme-bk-color {border-color:<?php echo $styling->get_mwp_header_border_color();?>;}
.mwp-property-details-page {background-color: <?php echo $styling->get_mwp_details_main_page_background();?>;}
.md-propdtr .md-propdtr-details ul li {background-color:<?php echo $styling->get_mwp_details_secondary_background();?>;}
.mwp-property-details-page {color:<?php echo $styling->get_mwp_details_main_font_color();?>;}
.md-property-title .address h1 {color: <?php echo $styling->get_mwp_details_main_font_color();?>;}
.md-propdtr .md-propdtr-stats .label {color:<?php echo $styling->get_mwp_details_main_font_color();?>;}
.mwp-property-details-page a {color:<?php echo $styling->get_mwp_details_secondary_font_color();?>;}
.md-property-title .price {color: <?php echo $styling->get_mwp_details_secondary_font_color();?>;}
.md-property-page .ft-blue {color:<?php echo $styling->get_mwp_details_secondary_font_color();?>;}
.right-details strong {color:<?php echo $styling->get_mwp_details_secondary_font_color();?>;}
.left-details strong {color:<?php echo $styling->get_mwp_details_secondary_font_color();?>;}
.single-property-desc .details-txt h2 {color:<?php echo $styling->get_mwp_details_secondary_font_color();?>;}
.profmail a {color:<?php echo $styling->get_mwp_details_content_main_fontcolor();?>;}
.md-header-btn .md-property-btn a {color:<?php echo $styling->get_mwp_details_main_background();?>;}
.md-property-page .nav-pills > li > a {background-color:<?php echo $styling->get_mwp_details_main_background();?>;}
.profmail a {background-color:<?php echo $styling->get_mwp_details_main_background();?>;}
.md-property-page .nav-pills > li > a:hover {color:<?php echo $styling->get_mwp_details_secondary_font_color();?>;}
.md-property-page .nav-pills > li.active > a, .md-property-page .nav-pills > li.active > a:focus {color:<?php echo $styling->get_mwp_details_secondary_font_color();?>;}
.profmail a {color:<?php echo $styling->get_mwp_details_secondary_font_color();?>;}
.md-header-btn .md-property-btn a:hover {color: <?php echo $styling->get_mwp_details_secondary_background();?>;}
.md-property-page .nav-pills > li > a:hover {background-color:<?php echo $styling->get_mwp_details_secondary_background();?>;}
.md-property-page .nav-pills > li.active > a, .md-property-page .nav-pills > li.active > a:focus {background-color:<?php echo $styling->get_mwp_details_secondary_background();?>;}
.profmail a {background-color:<?php echo $styling->get_mwp_details_secondary_background();?>;}
.md-propdtr .md-propdtr-box {border-color:<?php echo $styling->get_mwp_details_content_border_color();?>;}
.md-property-page .nav-pills > li > a {color: <?php echo $styling->get_mwp_details_tab_inactive_fontcolor();?>;}
.md-property-page .nav-pills > li.active > a, .md-property-page .nav-pills > li.active > a:focus {
 background-color: <?php echo $styling->get_mwp_details_tab_active_background();?>;
}
.md-property-page .nav-pills > li.active > a, .md-property-page .nav-pills > li.active > a:focus {color: <?php echo $styling->get_mwp_details_tab_active_fontcolor();?>;}
.md-property-page .nav-pills > li > a {background-color: <?php echo $styling->get_mwp_details_tab_inactive_background();?>;}
.md-property-page .nav-pills > li > a:hover { background-color: <?php echo $styling->get_mwp_details_tab_hover_background();?>; color: <?php echo $styling->get_mwp_details_tab_hover_font_color();?>;}
#advanced_search .mwp-theme-bk-color {background-color: <?php echo $styling->get_mwp_button_main_background();?>;}
#advanced_search .mwp-theme-bk-color {color: <?php echo $styling->get_mwp_button_font_color();?>;}
.mwp-search-result-page-background {background-color:<?php echo $styling->get_mwp_details_main_page_background();?>;}
.md-listing-sash .active {background-color: <?php echo $styling->get_mwp_list_active_label();?>;color: #fff;
}
</style>
		<?php
		//load quick css
	}
	
	public function __construct(){}
}
