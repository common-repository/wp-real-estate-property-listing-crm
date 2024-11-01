<div id="md-settings-theme" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<h1><a href="http://www.greatschools.org/" target="_blank"><img src="<?php echo mwp_asset_url() . 'logo_GS_200x50.gif';?>" alt="GreatSchool Logo"></a> API Credentials</h1>
	<p><?php _e('Cost = FREE', mwp_localize_domain());?>.</p>
	<p><?php _e('If you live in the USA, go to', mwp_localize_domain());?> <a href="http://www.greatschools.org/api/registration.page" target="_blank"><?php _e('Registration Page', mwp_localize_domain());?></a> <?php _e('and ask to receive your GreatSchool API key.', mwp_localize_domain());?></p>
	<p><?php _e('Note: Please read Terms of Use', mwp_localize_domain());?>: <a href="http://www.greatschools.org/api/docs/terms.page" target="_blank"><?php _e('Terms Page', mwp_localize_domain());?></a></p>
	<hr>
	<form name="md_api" method="post" action="<?php echo $url_slug;?>">
		<input type="hidden" name="_method" value="update_api_greatschool">
		<p><?php _e('API Key', mwp_localize_domain());?></p>
		<input type="text" name="md_greatschool_api_key" id="md_greatschool_api_key" class="md-input-text" value="<?php echo $md_greatschool_api_key;?>" style="width:95%;"/>
		<p></p>
		<p>
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()) ?>" />
		</p>
	</form>
</div>	
