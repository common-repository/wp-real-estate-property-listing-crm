<div class="mwp-account-info">
	<h3>Account Info</h3>
	<?php if(isset($account_info->company)) { ?>
			<p><?php echo $account_info->company;?></p>
	<?php } ?>
	<?php if( isset($account_info->manager_first_name)  ) { ?>
			<p><?php echo $account_info->manager_first_name;?></p>
	<?php } ?>
	<?php if( isset($account_info->manager_last_name)  ) { ?>
			<p><?php echo $account_info->manager_last_name;?></p>
	<?php } ?>
	<?php if( isset($account_info->company_logo)  ) { ?>
			<img src="<?php echo $account_info->company_logo;?>" style="width:150px;height:150px;" alt="Company Logo" />
	<?php } ?>
</div>
<hr>
<div class="mwp-reset-cache">
	<h3>Reset Cache</h3>
	<form name="md_api" method="post" action="<?php echo admin_url('admin.php?page=md-settings-account&noheaders=true'); ?>">
		<input type="hidden" name="_method" value="mwp_delete_all_cache">
		<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="<?php _e('Delete All Cache' ) ?>" />
		</p>
	</form>
</div>
<hr>

