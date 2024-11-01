<?php if( mwp_is_search_result_page() ){//mwp_is_search_result_page ?>
<div class="btn-group mwp-switch-view" role="group" aria-label="...">
  <a class="btn mwp-theme-bk-color" href="<?php echo mwp_search_uri_query('view=list');?>">List</a>
  <a class="btn mwp-theme-bk-color" href="<?php echo mwp_search_uri_query('view=map');?>">Map</a>
  <?php 
	if( md_search_form_locationname() != '' ){
		Mwp_Actions_SaveSearch::get_instance()->display_button(Mwp_View::get_instance()->data['atts_save_search']); 
	}
  ?>
</div>
<?php } ?>
