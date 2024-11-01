<div id="md-settings-theme" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<h3>Flex MLS</h3>
	<form name="md_api" method="post" action="<?php echo $url_slug;?>">
		<input type="hidden" name="_method" value="update_api_flexmls">
		<p><?php _e('API Key', mwp_localize_domain());?></p>
		<input type="text" name="md_flexmls_api_key" id="md_flexmls_api_key" class="md-input-text" value="<?php echo $md_flexmls_api_key;?>" style="width:95%;" />
		<p><?php _e('API Secret', mwp_localize_domain());?></p>
		<input type="text" name="md_flexmls_api_secret" id="md_flexmls_api_secret" class="md-input-text" value="<?php echo $md_flexmls_api_secret;?>" style="width:95%;"/>
		<p></p>
		<p>
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()) ?>" />
		</p>
	</form>
</div>	
