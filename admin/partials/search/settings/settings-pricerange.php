<div id="md-settings-search" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<h3><?php _e('Price Range', mwp_localize_domain());?></h3>
	<form name="md_api" method="post" action="<?php echo $url_slug;?>">
		<div class="three-col">
			<input type="hidden" name="_method" value="update_price_range">
			<div class="col tens">
				<p>
					<?php _e('Change price range by Tens', mwp_localize_domain());?>
					<span style="font-style:italic;color:red;">
						(<?php _e('if you want the by tens not to show, put zero in start, end and step',mwp_localize_domain()); ?>)
					</span>
				</p>
				<p>
					<?php _e('Start', mwp_localize_domain());?>
					<input type="text" name="price_range_ten_start" value="<?php echo $price_range_ten_start;?>">
				</p>
				<p>
					<?php _e('End', mwp_localize_domain());?>
					<input type="text" name="price_range_ten_end" value="<?php echo $price_range_ten_end;?>">
				</p>
				<p>
					<?php _e('Step', mwp_localize_domain());?>
					<input type="text" name="price_range_ten_step" value="<?php echo $price_range_ten_step;?>">
				</p>
			</div>
			<div class="col hundreds">
				<p>
					<?php _e('Change price range by Hundred', mwp_localize_domain());?>
					<span style="font-style:italic;color:red;">
						(<?php _e('if you want the by hundreds not to show, put zero in start, end and step',mwp_localize_domain()); ?>)
					</span>
				</p>
				<p>
					<?php _e('Start', mwp_localize_domain());?>
					<input type="text" name="price_range_hundred_start" value="<?php echo $price_range_hundred_start;?>">
				</p>
				<p>
					<?php _e('End', mwp_localize_domain());?>
					<input type="text" name="price_range_hundred_end" value="<?php echo $price_range_hundred_end;?>">
				</p>
				<p>
					<?php _e('Step', mwp_localize_domain());?>
					<input type="text" name="price_range_hundred_step" value="<?php echo $price_range_hundred_step;?>">
				</p>
			</div>
			<div class="col millions">
				<p>
					<?php _e('Change price range by Million', mwp_localize_domain());?>
					<span style="font-style:italic;color:red;">
						(<?php _e('if you want the by millions not to show, put zero in start, end and step', mwp_localize_domain()); ?>)
					</span>
				</p>
				<p>
					<?php _e('Start', mwp_localize_domain());?>
					<input type="text" name="price_range_million_start" value="<?php echo $price_range_million_start;?>">
				</p>
				<p>
					<?php _e('End', mwp_localize_domain());?>
					<input type="text" name="price_range_million_end" value="<?php echo $price_range_million_end;?>">
				</p>
				<p>
					<?php _e('Step', mwp_localize_domain());?>
					<input type="text" name="price_range_million_step" value="<?php echo $price_range_million_step;?>">
				</p>
			</div>
		</div>
		<div class="form-button-container">
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()) ?>" />
		</div>
	</form>
</div>

