<!-- Modal -->
<div class="mwp-bootstrap">
	<div class="modal fade send-to-friend-modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="frm_send_link_mail" method="POST" name="frm_send_link_mail"  class="custom">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="emailme-revealLabel"><?php _e('Send this to a Friend', mwp_localize_domain()); ?></h4>
			  </div>
			  <div class="modal-body">

					<div class="sendtofriend-alert alert hide"><?php _e('Error', mwp_localize_domain()); ?></div>
					<div class="row">
						<div class="col-xs-6 col-lg-4"><div class="well well-sm"><?php _e('Friends Email Address', mwp_localize_domain()); ?></div></div>
						<div class="col-xs-6 col-lg-8">
							<input type="email" name="friendsemail" required="required" class="form-control">
						</div>
					</div>
					<?php if( !is_user_logged_in() ){ ?>
						<div class="row">
							<div class="col-xs-6 col-lg-4"><div class="well well-sm"><?php _e('Your Name', mwp_localize_domain()); ?></div></div>
							<div class="col-xs-6 col-lg-8">
								<input type="text" name="yourname" required="required" class="form-control">
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-lg-4"><div class="well well-sm"><?php _e('Your Email Address', mwp_localize_domain()); ?></div></div>
							<div class="col-xs-6 col-lg-8">
								<input type="text" name="youremail" class="form-control">
							</div>
						</div>
					<?php } ?>
					<div class="row">
						<div class="col-xs-12 col-lg-12">
							<textarea class="form-control" rows="10" cols="5" name="message" id="message"></textarea>
						</div>
					</div>

			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default closemodal" data-dismiss="modal"><?php _e('Close', mwp_localize_domain()); ?></button>
				<button type="submit" class="btn btn-primary sendtofriend"><?php _e('Send', mwp_localize_domain()); ?></button></div>
				<input name="action" value="sendtofriend" type="hidden">
				<input name="address" id="address" value="" type="hidden">
				<input name="url" id="url" value="" type="hidden">
			  </div>
			 </form>
		</div>
	</div>
</div>
