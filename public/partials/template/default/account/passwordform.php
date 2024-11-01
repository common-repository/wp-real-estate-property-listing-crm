<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php _e('Password', PLUGIN_NAME);?></h3>
  </div>
  <div class="panel-body">
	<div class="password-alert alert hide"><?php _e('Error', PLUGIN_NAME);?></div>
    <form role="form" class="password-form" method="POST" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>profile">
		<div class="form-group">
			<input type="password" class="form-control" value="" id="password" name="password" placeholder="<?php _e('New Password', PLUGIN_NAME);?>" required>
		</div>
		<div class="form-group">
			<input type="password" class="form-control" value="" id="confirm-password" name="confirm-password" placeholder="<?php _e('Confirm New Password', PLUGIN_NAME);?>" required>
		</div>
		<input type="hidden" name="task" value="update_password">
		<button type="submit" class="btn btn-primary set-password"><?php _e('Save', PLUGIN_NAME);?></button>
		<div class="password_msg"></div>
	</form>
  </div>
</div>
