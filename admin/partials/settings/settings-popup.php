<div id="md-settings-popup" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<div class="popup-content">
		<form name="md_api" method="post" action="<?php echo $url_slug;?>">
			<input type="hidden" name="_method" value="update_popup">
			<h3><?php _e('Show pop-up on certain clicks?', mwp_localize_domain());?></h3>
			<p>
				<?php
					_e('How this works? When a visitor visits your website, you can ', mwp_localize_domain());
					_e('select how many properties they can view before forcing them ', mwp_localize_domain());
					_e('to sign-up. When the visitors signs up the lead will ', mwp_localize_domain());
					_e('automatically enter into your CRM account. You can ', mwp_localize_domain());
					_e('automatically create marketing campaigns within the CRM. ', mwp_localize_domain());
				?>
			</p>
			<select name="<?php echo $model_popup->masterdigm_popup_show;?>">
				<?php foreach($show_popup_choose as $key=>$val){ ?>
						<option value="<?php echo $key;?>" <?php echo ($popup_show == $key) ? 'selected':'';?>><?php echo $val;?></option>
				<?php } ?>
			</select>
			<p>
				<?php _e('Display close button? do you want the ability to close the popup?', mwp_localize_domain());?>
			</p>
			<select name="<?php echo $model_popup->masterdigm_popup_close;?>">
				<?php foreach($show_popup_close_button as $key=>$val){ ?>
						<option value="<?php echo $key;?>" <?php echo ($popup_close == $key) ? 'selected':'';?>><?php echo $val;?></option>
				<?php } ?>
			</select>
			<p>
				<?php _e('Show popup after certain clicks. This will show popup after certain click or view of individual property', mwp_localize_domain()); ?>
			</p>
			<select name="<?php echo $model_popup->masterdigm_popup_clicks;?>">
				<?php foreach($show_popup_after as $key=>$val){ ?>
						<option value="<?php echo $key;?>" <?php echo ( $popup_clicks == $key ) ? 'selected':'';?>><?php echo $val;?></option>
				<?php } ?>
			</select>
			<p>
				<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update', mwp_localize_domain()) ?>" />
			</p>
		</form>
	</div>
</div>
