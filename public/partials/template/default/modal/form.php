<div class="mwp-bootstrap">
	<div class="register-login-alert alert hide"><?php _e('Error', mwp_localize_domain());?></div>
	<div class="row">
		<div class="col-md-12">
			<div class="content-text"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<form role="form" class="register-form" method="POST">
				<h3><?php echo _label('popup-register');?></h3>
				<div class="form-group">
					<input type="text" class="form-control" id="firstname" name="firstname" placeholder="<?php _e('First Name', mwp_localize_domain());?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="lastname" name="lastname" placeholder="<?php _e('Last Name', mwp_localize_domain());?>">
				</div>
				<div class="form-group">
					<input type="email" class="form-control" id="emailaddress" name="emailaddress" placeholder="<?php _e('Enter email', mwp_localize_domain());?>">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="phone" name="phone" placeholder="<?php _e('Phone Number', mwp_localize_domain());?>">
				</div>
				<input type="hidden" name="current_action" class="current_action">
				<input type="hidden" name="data_post" class="data_post">
				<button type="submit" class="btn btn-primary registersend"><?php _e('Sign Up', mwp_localize_domain());?></button>
			</form>
		</div>
		<div class="col-md-6">
			<form role="form" class="login-form">
				<h3><?php echo _label('popup-login');?></h3>
				<div class="form-group">
					<input type="text" class="form-control" name="emailaddress" id="emailaddress" placeholder="<?php _e('Email Address', mwp_localize_domain());?>">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" name="password" id="password" placeholder="<?php _e('Password', mwp_localize_domain());?>">
				</div>
				<div class="form-group">
					<a href="<?php echo home_url('wp-login.php?action=lostpassword');?>"><?php _e('Forgot password', mwp_localize_domain());?></a>
				</div>
				<input type="hidden" name="current_action" class="current_action">
				<input type="hidden" name="data_post" class="data_post">
				<button type="submit" class="btn btn-primary modal-login"><?php _e('Login', mwp_localize_domain());?></button>
			</form>
			
			<div class="social-login">
				<?php if( !is_user_logged_in() &&  Mwp_API_Social_Model::get_instance()->masterdigm_facebook_id('r') ){ ?>
					<h3>Or</h3>
					<div class="social-signin">
						<div id="status"></div>
						<?php Mwp_API_Facebook::get_instance()->login_button(); ?>
					</div>
				<?php } ?>
				<div class="login-indicator"></div>
			</div>
			<p></p>
		</div>
	</div>
</div>
