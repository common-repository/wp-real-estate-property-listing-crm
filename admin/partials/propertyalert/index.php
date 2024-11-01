<div class="wrap about-wrap">
	<h1>
		Property Alert
	</h1>
	<form name="md_api" method="post" action="<?php echo $url_slug;?>">
		<input type="hidden" name="_method" value="update_theme_property">
		<div>
			<h3><?php _e('Add Message for successfully un-subscribe', mwp_localize_domain());?> </h3>
			<?php wp_editor( $success_editor_content, $success_editor_editor_id, $editor_settings ); ?>
		</div>
		<hr/>
		<div>
			<h3><?php _e('Add Message for fail un-subscribe', mwp_localize_domain()); ?> </h3>
			<?php wp_editor( $fail_editor_content, $fail_editor_editor_id, $editor_settings ); ?>
		</div>
		<div class="form-button-container">
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()) ?>" />
		</div>
	</form>	
</div>
