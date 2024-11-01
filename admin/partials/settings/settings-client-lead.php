<div id="md-settings-clientlead" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<div class="clientlead-content">
		<form name="md_api" method="post" action="<?php echo $url_slug;?>">
			<input type="hidden" name="_method" value="update_clientlead">
			<input type="hidden" name="tab" value="<?php echo $_tab;?>">

			<h3><?php _e('Client Lead', mwp_localize_domain());?></h3>

			<p>
				<?php _e('Choose lead status', mwp_localize_domain());?>,
				<?php _e('This will be the status of the lead in the CRM', mwp_localize_domain());?>
			</p>
			<select name="lead_status">
				<?php foreach($lead_status as $key => $val){ ?>
						<option value="<?php echo $key;?>" <?php echo ( $db_lead_status == $key ) ? 'selected':'';?>>
							<?php echo $val;?>
						</option>
				<?php } ?>
			</select>
			<!-- select -->
			<p>
				<?php _e('Choose lead type', mwp_localize_domain());?>,
				<?php _e('This will be the type of the lead in the CRM', mwp_localize_domain());?>
			</p>
			<select name="lead_type">
				<?php foreach($lead_type as $key => $val){ ?>
						<option value="<?php echo $key;?>" <?php echo ( $db_lead_type == $key ) ? 'selected':'';?>>
							<?php echo $val;?>
						</option>
				<?php } ?>
			</select>
			<!-- select -->
			<p>
				<?php _e('Choose lead source', mwp_localize_domain());?>,
			</p>
			<select name="lead_source">
				<?php foreach($lead_source as $key => $val){ ?>
						<option value="<?php echo $key;?>" <?php echo ( $db_lead_source == $key ) ? 'selected':'';?>>
							<?php echo $val;?>
						</option>
				<?php } ?>
			</select>
			<!-- select -->
			<p></p>
			<hr>
			<p><?php _e('This is use for the following lead forms', mwp_localize_domain());?>:</p>
			<ul>
				<li><?php _e('User register form', mwp_localize_domain());?></li>
				<li><?php _e('Inquire form', mwp_localize_domain()); ?></li>
				<li><?php _e('Email to form', mwp_localize_domain());?></li>
			</ul>

			<p>
				<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update', mwp_localize_domain()) ?>" />
			</p>
		</form>
	</div>
</div>
