<div id="md-settings-theme" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<form name="md_api" method="post" action="<?php echo $url_slug;?>">
		<div class="two-col">
			<input type="hidden" name="_method" value="update_theme_property">
			<div class="col">
				<p><?php _e('Display property address or tag-line', mwp_localize_domain());?></p>
				<select name="property_name">
					<?php foreach($show_default_property_name as $key => $val){ ?>
							<option value="<?php echo $key;?>"
								<?php echo ( $db_property_title == $key ) ? 'selected':'';?>>
								<?php echo $val;?>
							</option>
					<?php } ?>
				</select>
				<h3><?php _e('Book a Viewing', mwp_localize_domain());?></h3>
				<p>
					<p><?php _e('Text Alignment', mwp_localize_domain());?></p>
					<select name="property_bookaviewingurl_align">
					<?php foreach($book_a_viewing_align as $k => $v){ ?>
						<option value="<?php echo $k;?>" <?php echo ($db_book_a_viewing_align == $k) ? 'selected':'';?>><?php echo $v;?></option>
					<?php } ?>
					</select>
				</p>
				<p>
					<p><?php _e('Label', mwp_localize_domain());?></p>
					<input type="text" name="property_bookaviewingurl_label" value="<?php echo trim($db_book_a_viewing_label);?>" style="width:90%;">
				</p>
				<p>
					<p><?php _e('URL', mwp_localize_domain());?></p>
					<input type="text" name="property_bookaviewingurl" value="<?php echo trim($db_book_a_viewing_url);?>" style="width:90%;">
				</p>
			</div>
			<div class="col">
				<h3><?php _e('Fields', mwp_localize_domain());?></h3>
				<p>
					<?php _e('Display Bed', mwp_localize_domain());?> ?
					<select name="show_bed">
						<?php foreach($arr_show_bed as $key => $val){ ?>
							<option value="<?php echo $key;?>" <?php echo ($db_show_bed == $key ) ? 'selected':'';?>><?php echo $val;?></option>
						<?php } ?>
					</select>
				</p>
				<p>
					<?php _e('Display Bath', mwp_localize_domain());?> ?
					<select name="show_bath">
						<?php foreach($arr_show_bath as $key => $val){ ?>
							<option value="<?php echo $key;?>" <?php echo ($db_show_bath == $key ) ? 'selected':'';?>><?php echo $val;?></option>
						<?php } ?>
					</select>
				</p>
				<p>
					<?php _e('Display Garage', mwp_localize_domain());?> ?
					<select name="show_garage">
						<?php foreach($arr_show_garage as $key => $val){ ?>
							<option value="<?php echo $key;?>" <?php echo ($db_show_garage == $key ) ? 'selected':'';?>><?php echo $val;?></option>
						<?php } ?>
					</select>
				</p>
			</div>

		</div>
		<div class="form-button-container">
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()) ?>" />
		</div>
	</form>
</div>

