<?php //Mwp_Controllers_Theme_Map ?>
<div id="md-settings-map" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<form name="md_api" class="md_api" method="post" action="<?php echo $url_slug;?>">
		<input type="hidden" name="_method" value="update_theme_map">
		<p><?php _e("This is the default address of google map when there is no location searched.", mwp_localize_domain());?></p>
		<p><?php _e("Default Geo Code Address is: ", mwp_localize_domain());?></p>
		<input type="textbox" name="mwp_geo_address" value="<?php echo $geocode_address;?>" style="width:100%;">
		<p><?php _e("Google map zoom", mwp_localize_domain());?></p>
		<input type="textbox" name="mwp_map_zoom" value="<?php echo $mwp_zoom;?>" >
		<div class="form-button-container">
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()); ?>" />
		</div>
	</form>
</div>
<script>
</script>
