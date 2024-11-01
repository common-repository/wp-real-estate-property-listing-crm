<div id="md-settings-mail" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<div class="jsplugin-content">
		<form name="md_api" method="post" action="<?php echo $url_slug;?>">
			<input type="hidden" name="_method" value="update_jspluginlib">
			<input type="hidden" name="tab" value="<?php echo $_tab;?>">
			<h3><?php _e('This plugin uses the following javascript plugin / library', mwp_localize_domain());?></h3>
			<h3 class="warning" style="color:red !important;"><?php _e('Warning! Uncheck them at your own risk!', mwp_localize_domain());?></h3>
			<p><?php _e('The below are part of the MD plugin framework. The purpose is to disallow two instances of plugin/library which can cause conflicts.', mwp_localize_domain());?></p>
			<p><?php _e('Template plugin / library', mwp_localize_domain()); ?></p>

			<ul>
			<?php foreach($jspluginlib as $key => $val){ ?>
					<li>
						<input
							type="checkbox"
							name="jspluginlib[<?php echo $key;?>]"
							<?php echo in_array($key, $db_jspluginlib) ? 'checked':'';?> >
						<?php echo $val['name'];?> <?php echo $val['version'];?>
					</li>
			<?php } ?>
			</ul>

			<p>
				<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update', mwp_localize_domain()) ?>" />
			</p>
		</form>
	</div>
</div>
