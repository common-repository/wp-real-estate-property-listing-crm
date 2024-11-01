<div class="container-fluid search-result search-result-list" id="main">
  <div class="">
	  <div class="row">
		<div class="<?php echo Mwp_View::get_instance()->col_left;?>" id="left">
			<?php Mwp_View::get_instance()->display($container_template, Mwp_View::get_instance()->data);?> 
		</div>
		<div class="<?php echo Mwp_View::get_instance()->col_map;?> col-sm-12 col-xs-12"><!--map-canvas will be postioned here--></div>
	  </div>
  </div>
</div>
