<?php 
	Mwp_View::get_instance()->display(Mwp_View::get_instance()->map_view, Mwp_View::get_instance()->data); 
?>
<?php if( Mwp_View::get_instance()->obj->is_map_view() ){ ?>
	<?php Mwp_View::get_instance()->display(Mwp_View::get_instance()->map_view, Mwp_View::get_instance()->data); ?>
<?php } ?>	
<div class="container-fluid" id="main">
  <div class="row">
  	<div class="<?php echo Mwp_View::get_instance()->col_left;?> hidden-sm hidden-xs" id="left">
		<h4>
			<?php echo Mwp_View::get_instance()->data['loop_data']->property_data_count;?> 
			Of
			<?php echo Mwp_View::get_instance()->total_data;?> 
			Properties Found
		</h4>
		<?php Mwp_View::get_instance()->display(Mwp_View::get_instance()->container_template, Mwp_View::get_instance()->data);?> 
    </div>
    <div class="<?php echo Mwp_View::get_instance()->col_map;?> col-sm-12 col-xs-12"><!--map-canvas will be postioned here--></div>
  </div>
</div>
