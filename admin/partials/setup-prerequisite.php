<div class="wrap about-wrap">
	<h1>
		<?php _e('Welcome to', mwp_localize_domain());?> <?php echo esc_html( get_admin_page_title() ); ?>
		<?php echo $plugin_version;?>
	</h1>
	<div class="about-text">
		<p><?php _e('Thank you for choosing Masterdigm CRM as your property solutions', mwp_localize_domain());?></p>
	</div>
	<div class="changelog point-releases">
		<h2><?php _e('Before signing-up for API Keys, we would like you to check on these issues below and please fix them :', mwp_localize_domain());?></h2>
		<?php foreach($msg as $key => $val){ ?>
				<p style="font-size:18px;color:red;"><?php echo $val?></p>
		<?php } ?>
	</div>
	<form name="mwp_activate_notice" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="submit" name="Submit" class="button-primary" value="<?php _e('Refresh', mwp_localize_domain() ) ?>" />
	</form>
</div>
