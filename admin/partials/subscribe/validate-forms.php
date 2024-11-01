<h3><?php _e('Validate Code', mwp_localize_domain());?></h3>
<?php if( $model_subscribe->masterdigm_subscribe_msg_step_2('r') ){ ?>
	<p><?php echo $model_subscribe->masterdigm_subscribe_msg_step_2('r'); ?></p>
<?php } ?>
<form name="md_api" method="post" action="<?php echo $url_slug;?>">
	<input type="hidden" name="_method" value="activate_code">
	<table class="form-table">
		<tbody>
			<tr>
				<td>
					<input type="text" name="activation_code" value="" style="width:100%;">
				</td>
			</tr>
		</tbody>
	</table>
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="<?php _e('Activate Code', mwp_localize_domain() ) ?>" />
	</p>
</form>
<hr>
