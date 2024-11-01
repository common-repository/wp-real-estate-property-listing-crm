<?php if( $loop_data->loop_property() ){ ?>
<h3><?php _e('Similar Properties to ', mwp_localize_domain());?> <?php echo $property_address;?></h3>
<div id="md-listing-results">
<?php
while($loop_data->loop_property()): $loop_data->md_set_property();mwp_set_loop($loop_data);
	if( $parse_url['id'] != mwp_property_id() ){
		?>
			<div class="md-listing-contain md-listing-image col-lg-4 col-md-6 col-sm-6 col-xs-12" style="background-image:url(<?php echo mwp_primary_photo(); ?>);">
				<?php Mwp_View::get_instance()->display($grid_layout, array()); ?>
			</div>
		<?php
	}
endwhile;
?>
</div>
<?php }//if ?>
