<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php _e('Personal Info', mwp_localize_domain());?></h3>
  </div>
  <div class="panel-body">
    <div class="profile-alert alert hide"><?php _e('Error', mwp_localize_domain());?></div>

    <form role="form" class="profile-form" method="POST" action="<?php echo $url; ?>">
		<div class="form-group">
			<label><?php _e('First Name', mwp_localize_domain());?></label>
			<input type="text" class="form-control" value="<?php echo $user_account->user_firstname;?>" id="firstname" name="firstname" placeholder="<?php _e('First Name', mwp_localize_domain());?>">
		</div>
		<div class="form-group">
			<label><?php _e('Last Name', mwp_localize_domain());?></label>
			<input type="text" class="form-control" value="<?php echo $user_account->user_lastname;?>" id="lastname" name="lastname" placeholder="<?php _e('Last Name', mwp_localize_domain());?>">
		</div>
		<div class="form-group">
			<label><?php _e('Email Address', mwp_localize_domain());?></label>
			<input type="email" class="form-control" value="<?php echo $user_account->user_email;?>" id="emailaddress" name="emailaddress" placeholder="<?php _e('Enter email', mwp_localize_domain());?>">
		</div>
		<div class="form-group">
			<label><?php _e('Phone', mwp_localize_domain());?></label>
			<input type="text" class="form-control" id="phone" value="<?php echo $phone_number;?>" name="phone" placeholder="<?php _e('Phone Number', mwp_localize_domain());?>">
		</div>
		<input type="hidden" name="task" value="update_profile">
		<button type="submit" class="btn btn-primary update-profile-btn"><?php _e('Update', mwp_localize_domain());?></button>
		<div class="profile_msg"></div>
	</form>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php _e('Password', mwp_localize_domain());?></h3>
  </div>
  <div class="panel-body">
	<div class="password-alert alert hide"><?php _e('Error', mwp_localize_domain());?></div>
    <form role="form" class="password-form" method="POST" action="<?php echo $url; ?>">
		<div class="form-group">
			<input type="password" class="form-control" value="" id="password" name="password" placeholder="<?php _e('New Password', mwp_localize_domain());?>" required>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" value="" id="confirm-password" name="confirm-password" placeholder="<?php _e('Confirm New Password', mwp_localize_domain());?>" required>
		</div>
		<input type="hidden" name="task" value="update_password">
		<button type="submit" class="btn btn-primary set-password"><?php _e('Update', mwp_localize_domain());?></button>
		<div class="password_msg"></div>
	</form>
  </div>
</div>
