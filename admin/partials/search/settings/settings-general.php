<div id="md-settings-search" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<div class="general-content">
		<form name="md_api" method="post" action="<?php echo $url_slug;?>">
			<input type="hidden" name="_method" value="update_general">
			<div class="three-col">
				<div class="col">
					<h3><?php _e('Show For Sale Button', mwp_localize_domain());?>?</h3>
					<select name="search_forsale_button">
						<?php foreach($arr_show_button_forsale as $key => $val) { ?>
								<option value="<?php echo $key;?>" <?php echo ($db_show_button_forsale == $key) ? 'selected':'';?>>
									<?php echo $val;?>
								</option>
						<?php } ?>
					</select>

					<h3><?php _e('Show For Rent Button', mwp_localize_domain());?>?</h3>
					<select name="search_forrent_button">
						<?php foreach($arr_show_button_forrent as $key => $val) { ?>
								<option value="<?php echo $key;?>" <?php echo ($db_show_button_forrent == $key) ? 'selected':'';?>>
									<?php echo $val;?>
								</option>
						<?php } ?>
					</select>

					<h3><?php _e('Show Foreclosure dropdown / button', mwp_localize_domain());?>?</h3>
					<select name="show_foreclosure_button">
						<?php foreach($arr_show_button_foreclosure as $key => $val) { ?>
								<option value="<?php echo $key;?>" <?php echo ($db_show_button_foreclosure == $key) ? 'selected':'';?>>
									<?php echo $val;?>
								</option>
						<?php } ?>
					</select>

					<h3><?php _e('Show Private Sales dropdown / button', mwp_localize_domain());?>?</h3>
					<select name="show_privatesales_button">
						<?php foreach($arr_show_button_privatesales as $key => $val) { ?>
								<option value="<?php echo $key;?>" <?php echo ($db_show_button_privatesales == $key) ? 'selected':'';?>>
									<?php echo $val;?>
								</option>
						<?php } ?>
					</select>

					<h3><?php _e('Show To Let dropdown / button', mwp_localize_domain());?>?</h3>
					<select name="show_tolet_button">
						<?php foreach($arr_show_button_tolet as $key => $val) { ?>
								<option value="<?php echo $key;?>" <?php echo ($db_show_button_tolet == $key) ? 'selected':'';?>>
									<?php echo $val;?>
								</option>
						<?php } ?>
					</select>
				</div>
				<div class="col">
					<h3><?php _e('Search Result', mwp_localize_domain());?></h3>
					<p><?php _e('Search property by default search criteria, Default status, when visitor search property, they will see this search criteria status', mwp_localize_domain());?></p>
					<select name="property_status">
						<option value="0"><?php _e('All', mwp_localize_domain());?></option>
						<?php foreach($arr_property_fields_status as $key => $val) { ?>
								<option value="<?php echo $key;?>" <?php echo ($db_property_fields_status == $key) ? 'selected':'';?>>
									<?php echo $val;?>
								</option>
						<?php } ?>
					</select>
				</div>
				<div class="col"></div>
			</div>
			<div class="form-button-container">
				<p>
					<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()) ?>" />
				</p>
			</div>
		</form>
	</div>
</div>
