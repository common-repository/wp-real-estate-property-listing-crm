<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php _e('Personal Info', PLUGIN_NAME);?></h3>
  </div>
  <div class="panel-body">
    <form role="form" class="profile-form" method="POST">
		<div class="form-group">
			<input type="text" class="form-control" value="<?php echo $user_account->user_firstname;?>" id="firstname" name="firstname" placeholder="<?php _e('First Name', PLUGIN_NAME);?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" value="<?php echo $user_account->user_lastname;?>" id="lastname" name="lastname" placeholder="<?php _e('Last Name', PLUGIN_NAME);?>">
		</div>
		<div class="form-group">
			<input type="email" class="form-control" value="<?php echo $user_account->user_email;?>" id="emailaddress" name="emailaddress" placeholder="<?php _e('Enter email', PLUGIN_NAME);?>">
		</div>
		<div class="form-group">
			<input type="text" class="form-control" id="phone" name="phone" placeholder="<?php _e('Phone Number', PLUGIN_NAME);?>">
		</div>
		<button type="submit" class="btn btn-primary registersend"><?php _e('Update', PLUGIN_NAME);?></button>
	</form>
  </div>
</div>
