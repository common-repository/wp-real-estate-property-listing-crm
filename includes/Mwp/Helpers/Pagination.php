<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
class Mwp_Helpers_Pagination{
	protected static $instance = null;

	public function __construct(){
		//set default values
	}

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

	public function md_pagination($pages = '', $range = 2, $max_num_pages = null, $paged = null){
		$showitems = ($range * 2)+1;
		
		if( is_null($paged) && !get_query_var( 'paged' ) ){
			$paged = 1;
		}else{
			if( get_query_var( 'paged' ) ){
				$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ):$paged;
			}
		}
		
		$limit = get_query_var( 'limit' ) ? absint( get_query_var( 'limit' ) ) : mwp_get_limit();
		$max   = ceil( intval( $max_num_pages ) / $limit );
		if($pages == ''){
		 global $wp_query;
		 $pages = $max;
		 if(!$pages)
		 {
			 $pages = 1;
		 }
		}

		$this->_md_pagination_layout($pages, $range, $showitems, $paged);
	}

	private function _md_pagination_layout($pages, $range, $showitems, $paged){
		echo "<div class='mwp-pagination'><span>Page ".$paged." of ".$pages."</span>";
		if(1 != $pages)
		{
			 if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."' class='first-page' data-first-page='1' data-first-url='".get_pagenum_link(1)."'>&laquo; First</a>";
			 if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."' class='previous-page' data-previous-page='".($paged - 1)."' data-previous-url='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";

			 for ($i=1; $i <= $pages; $i++)
			 {
				 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				 {
					 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' data-current-page='".$i."' data-current-url='".get_pagenum_link($i)."'>".$i."</a>";
				 }
			 }

			 if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."' class='next-page' data-next-pageid='".($paged + 1)."' data-next-url='".get_pagenum_link($paged + 1)."'>Next &rsaquo;</a>";
			 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."' class='last-page' data-last-page='".($pages)."' data-last-url='".get_pagenum_link($pages)."'>Last &raquo;</a>";
			 
		}
		echo '<input type="hidden" class="last_page" value="'.$pages.'">';
		echo "</div>\n";
	}
}
