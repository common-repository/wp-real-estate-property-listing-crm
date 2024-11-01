<div class="two-col">
	<div class="col">
		<h3 style="color:#0d3965;"><?php _e('Hello', mwp_localize_domain()); ?></h3>
		<p>
		<?php _e('Welcome to Masterdigm!  A full Real Estate plugin highly integrated with Masterdigm real estate CRM!', mwp_localize_domain()); ?>
		</br>
		<?php _e('You will notice several tabs above, i.e., CRM, Webinars, etc.. That will guide you through the Masterdigm processes.', mwp_localize_domain()); ?>
		</br>
		<?php _e('We want to see you succeed as a Broker, Agent or Web Development Team!  Therefore, we have a "support" tab to connect with us to ensure your success!', mwp_localize_domain()); ?>
		</br>
		<?php _e('Cheers, and we look forward to hearing from you.', mwp_localize_domain()); ?>
		</br>
		</br>
		Team Masterdigm<br>800-982-1276
		</p>
		<h3><?php _e('Plugin is fully setup', mwp_localize_domain()); ?></h3>
		<hr>
		<h3><?php _e('Setup Mail', mwp_localize_domain()); ?></h3>
		<p><a href="<?php echo admin_url( Mwp_Admin_Settings_Mail_WPEntity::get_instance()->get_admin_url_slug() ); ?>&tab=mail" target="_blank"><?php _e('Setup mail settings to update subscription content', mwp_localize_domain()); ?></a></p>
		<hr>
		<h3><?php _e('Setup Lead', mwp_localize_domain()); ?></h3>
		<p><a href="<?php echo admin_url( Mwp_Admin_Settings_Clientlead_WPEntity::get_instance()->get_admin_url_slug() ); ?>&tab=client-lead" target="_blank"><?php _e('Setup lead status and type', mwp_localize_domain()); ?></a></p>
		<hr>
		<h3><?php _e('See Properties', mwp_localize_domain()); ?></h3>
		<p><a href="<?php echo Mwp_SearchPropertyURL::get_instance()->get_url();?>" target="_blank"><?php _e('Click to see properties', mwp_localize_domain()); ?></a></p>
	</div>
	<div class="col">
		<h3 style="color:#0d3965;"><?php _e('Watch this video first!', mwp_localize_domain()); ?></h3>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLavLSlMVm_F970AGFX2Bk3tZIfP7l97dd" frameborder="0" allowfullscreen></iframe>
	</div>
</div>
<hr>
<div class="changelog">
	<h3>What's New in Masterdigm CRM and MD Plugin</h3>
	<?php //require_once $update_notice; ?>
</div>
<hr>
<div class="changelog point-releases">
	<h3 class="warning" style="color:red;"><?php _e('PLEASE NOTE | CAUTION: Do not delete the following pages OR the Masterdigm plugin will not work!', mwp_localize_domain());?></h3>
	<ul>
		<li><?php _e('City - Display list of properties base in City', mwp_localize_domain());?></li>
		<li><?php _e('State - Display list of properties base in State', mwp_localize_domain());?></li>
		<li><?php _e('Community - Display list of properties base in Community', mwp_localize_domain());?></li>
		<li><?php _e('County - Display list of properties base in County', mwp_localize_domain());?></li>
	</ul>
	<p></p>
</div>
<div class="mwp-webinar">
	<h3><?php _e('And you want to know more of our plugin and CRM?', mwp_localize_domain());?></h3>
	<p><?php _e('Want to discuss anything else? We offer a free 30 minute Gotomeeting screen-share where we go into answering questions you may have.', mwp_localize_domain());?></p>
	<iframe width="100%" height="500" src="https://www.vcita.com/v/masterdigmcrm/online_scheduling?service_id=59f30ff5&staff_id=dcdf8984#/schedule" frameborder="0" allowfullscreen></iframe>
</div>

