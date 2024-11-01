<div id="md-settings-theme" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<hr>
	<form name="md_api" method="post" action="<?php echo $url_slug;?>">
		<input type="hidden" name="_method" value="update_google_api">
		<p><?php _e('MAP API Key', mwp_localize_domain());?></p>
		<p><a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"><?php _e('Get google map api key here', mwp_localize_domain()); ?></a></p>
		<input type="text" name="md_google_map_api_key" id="md_google_map_api_key" class="md-input-text" value="<?php echo $md_google_map_api_key;?>" style="width:95%;"/>
		<p></p>
		<p>
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()) ?>" />
		</p>
	</form>
	<hr>
</div>	
