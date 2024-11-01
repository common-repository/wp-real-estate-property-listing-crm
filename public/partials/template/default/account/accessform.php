<form role="form" class="profile-form" method="POST">
	<h2><?php _e('Profile', PLUGIN_NAME);?></h2>
	<div class="form-group">
		<input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?php _e('First Name', PLUGIN_NAME);?>">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" id="lastname" name="lastname" placeholder="<?php _e('Last Name', PLUGIN_NAME);?>">
	</div>
	<div class="form-group">
		<input type="email" class="form-control" id="emailaddress" name="emailaddress" placeholder="<?php _e('Enter email', PLUGIN_NAME);?>">
	</div>
	<div class="form-group">
		<input type="text" class="form-control" id="phone" name="phone" placeholder="<?php _e('Phone Number', PLUGIN_NAME);?>">
	</div>
	<button type="submit" class="btn btn-primary registersend"><?php _e('Update', PLUGIN_NAME);?></button>
</form>
