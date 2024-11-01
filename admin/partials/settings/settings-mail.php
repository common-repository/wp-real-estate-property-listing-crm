<div id="md-settings-mail" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<div class="mail-content">
		<form name="md_api" method="post" action="<?php echo $url_slug;?>">
			<input type="hidden" name="_method" value="update_mail">
			<h3><?php _e('Mail Content', mwp_localize_domain());?></h3>
			<p><?php _e('Outgoing email.  Use this mail system to send an email from the mail server.', mwp_localize_domain());?></p>
			<input type="text" style="width:50%;" name="mail_server" value="<?php echo $mail_server;?>">
			<p>
				<?php _e('The email content below is the email the user receives upon subscribing.  Be sure to include the string variable, e.g., %username% and %password% so they will receive their log in credentials.', mwp_localize_domain()); ?>
			</p>
			<div>
				<p><?php _e('Use the below string variables to create your email below.', mwp_localize_domain());?></p>
				<ul>
					<li>%name% - <?php _e('The name of the registered user', mwp_localize_domain()); ?></li>
					<li>%username% - <?php _e('The user-name of the registered user', mwp_localize_domain()); ?></li>
					<li>%password% - <?php _e('The password of the registered user', mwp_localize_domain()); ?></li>
					<li>%email% - <?php _e('The email of the registered user', mwp_localize_domain()); ?></li>
					<li>%sitename% - <?php _e('The name the current website', mwp_localize_domain()); ?></li>
					<li>%loginurl% - <?php _e('The url of the current website', mwp_localize_domain()); ?></li>
				</ul>
			</div>
			<p><?php _e('Subject', mwp_localize_domain()); ?></p>
			<input type="text" name="subject" value="<?php echo $subject;?>" style="width:100%;">
			<p><?php _e('Message', mwp_localize_domain()); ?></p>
			<?php wp_editor( $content, $editor_id, $settings ); ?>
			<p>
				<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update', mwp_localize_domain()) ?>" />
			</p>
		</form>
	</div>
</div>
