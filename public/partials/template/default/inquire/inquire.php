<div class="inqform">
    <h2><span><?php _e('Inquiry Form', mwp_localize_domain());?></span></h2>
	<form class="inquiry_form" method="POST" name="inquiry_form"  role="form">
		<div class="form-group">
			<input type="text" value="<?php echo $yourname;?>" name="yourname" required="required" placeholder="<?php _e('Your First Name', mwp_localize_domain());?>" class="form-control">
		</div>
		<div class="form-group">
			<input type="text" value="<?php echo $yourlastname;?>" name="yourlastname" required="required" placeholder="<?php _e('Your Last Name', mwp_localize_domain());?>" class="form-control">
		</div>
		<div class="form-group">
			<input type="email" value="<?php echo $email1;?>" name="email1" required="required" placeholder="<?php _e('Your Valid Email', mwp_localize_domain());?>" class="form-control">
		</div>
		<div class="form-group">
			<input type="text" value="<?php echo $phone_mobile;?>" name="phone_mobile" placeholder="<?php _e('Your (Area Code) + Phone Number', mwp_localize_domain());?>" class="form-control">
		</div>
		<div class="form-group">
			<textarea class="form-control" rows="10" cols="5" name="message" style="resize: none;" ><?php echo $msg;?></textarea>
		</div>
		<button type="submit" class="btn inquireform mwp-theme-bk-color"><?php _e('Send', mwp_localize_domain());?></button>
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="ajax-msg">

				</div>
			</div>
		</div>
	<input type="hidden" name="assigned_to" value="<?php echo $assigned_to; ?>">
	<input type="hidden" name="source_url" value="<?php echo $source_url; ?>">
	</form>
</div>
