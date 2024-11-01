<div id="md-settings-theme" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<h3><?php _e('Social API - Settings', mwp_localize_domain());?></h3>
	<form name="md_api" method="post" action="<?php echo $url_slug;?>">
		<input type="hidden" name="_method" value="update_api_social">
		<div>
			<p>Facebook APP ID</p>
			<input type="text" name="masterdigm_facebook_id" value="<?php echo $masterdigm_facebook_id;?>" style="width:60%;">
			<p>Facebook APP Secret token</p>
			<input type="text" name="masterdigm_facebook_secret" value="<?php echo $masterdigm_facebook_secret;?>" style="width:60%;">
			<p>Facebook APP Version</p>
			<input type="text" name="masterdigm_facebook_version" value="<?php echo $masterdigm_facebook_version;?>" style="width:60%;">
			<p><a href="https://developers.facebook.com/docs/apps/register" target="_blank"><?php _e('Link to create facebook app', mwp_localize_domain()); ?></a></p>
		</div>
		<div style="display:none;">
			<p>Google APP ID</p>
			<input type="text" name="masterdigm_google_id" value="<?php //echo $obj->getSocialApiByKey('google','id');?>" style="width:60%;">
			<p>Google APP Secret token</p>
			<input type="text" name="masterdigm_google_secret" value="<?php //echo $obj->getSocialApiByKey('google','secret');?>" style="width:60%;">
		</div>
		<p>
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()) ?>" />
		</p>
	</form>
</div>	
