<!-- Modal -->
<?php //if( have_properties() ){ ?>
<div class="mwp-bootstrap">
	<div class="modal fade register-modal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">

		<div class="modal-content">

		  <div class="modal-header">
			<?php if( !mwp_showpopup_close() ){ ?>
				<button type="button" class="close" title="Close" data-dismiss="modal">
					 <span aria-hidden="true">&times;</span>
					 <span class="hide">Close</span>
				</button>
			<?php } ?>
			<h4 class="modal-title" id="register-modal-revealLabel">
				<?php echo _label('popup-title');?>
			</h4>
		  </div>

		  <div class="modal-body">
			<?php Mwp_View::get_instance()->display($template_form, array()); ?>
		  </div>

		  <div class="modal-footer">
			  <?php if( !mwp_showpopup_close() ){ ?>
				<button type="button" class="btn btn-primary closemodal" data-dismiss="modal">
					<?php _e('Close', mwp_localize_domain());?>
				</button>
			  <?php } ?>
		  </div>

		</div>
	   </div>
	</div>
</div>
<?php //} ?>
