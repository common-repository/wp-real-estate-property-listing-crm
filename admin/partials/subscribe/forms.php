<h3><?php _e('The simple and powerful real estate plugin', mwp_localize_domain());?> - Masterdigm</h3>
<form name="md_api" method="post" action="<?php echo $url_slug;?>">
	<input type="hidden" name="_method" value="subscribe_api_key">
	<p style="font-size:15px;">
		<?php _e('Masterdigm Wordpress plugin is unlike other simple WP plugins.  Within minutes you will see demo properties on your site!   Easy to use, packed with features and awesome plugin support.  Start today and see the Masterdigm WP Plugin difference.  We respect your privacy and can opt-out anytime.   Simply add your email below.. we will send you a verification link and you are ready to go!', mwp_localize_domain());?>
	</p>
	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row"><label for="email"><?php _e('Email', mwp_localize_domain());?> <span> *</span>: </label></th>
				<td>
					<input type="text" name="email" value="<?php echo get_option('admin_email');?>" style="width:100%;">
					<p style="font-style:italic;font-size:12px;">
						<?php _e('please provide email, or change email address, this will be use to signup an account in masterdigm', mwp_localize_domain());?>
					</p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="company"><?php _e('Company', mwp_localize_domain());?> : </label></th>
				<td><input type="text" name="company" value="<?php echo get_option('blogname');?>" style="width:100%;"></td>
			</tr>
			<tr>
				<th scope="row"><label for="first_name"><?php _e('First Name', mwp_localize_domain());?> : </label></th>
				<td><input type="text" name="first_name" value="<?php echo $current_user->user_firstname;?>" style="width:100%;"></td>
			</tr>
			<tr>
				<th scope="row"><label for="last_name"><?php _e('Last Name', mwp_localize_domain());?> : </label></th>
				<td><input type="text" name="last_name" value="<?php echo $current_user->user_lastname;?>" style="width:100%;"></td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="<?php _e('Subscribe', mwp_localize_domain() ) ?>" />
	</p>
	<p style="font-weight:bold;"><?php _e('Important! Username and password will be sent to you\'re email address you provide, please check your email inbox or in spam', mwp_localize_domain());?></p>
</form>
