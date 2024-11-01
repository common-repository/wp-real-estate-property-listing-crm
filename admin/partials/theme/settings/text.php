<?php //Mwp_Controllers_Theme_Layout ?>
<div id="md-settings-text" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<form name="md_api" class="md_api" method="post" action="<?php echo $url_slug;?>">
		<div class="form-button-container">
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()); ?>" />
		</div>
		<input type="hidden" name="_method" value="update_theme_text">
		<?php foreach($label as $key => $val) { ?>
			<p><?php _e('Original / Translated Text', mwp_localize_domain());?> : <span style="color:red;"><?php echo $val;?></span></p>
			<p><?php _e('Changed to : ', mwp_localize_domain());?></p>
			<p>
				<input type="text" name="mwp_theme_text[<?php echo $key;?>]" value="<?php echo (isset($db_label[$key]) && trim($db_label[$key]) != '' ) ? $db_label[$key]:'';?>" style="width:90%;">
				<br><span><?php _e('Note: empty the text field to use original text or transtaled text', mwp_localize_domain());?></span>
			</p>
			<hr/>
		<?php } ?>
		<div class="form-button-container">
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()); ?>" />
		</div>
	</form>
</div>
<script>

</script>
