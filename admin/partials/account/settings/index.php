<div id="md-settings" class="wrap">
	<h1>
		Account Settings
	</h1>
	<div>
		<form name="md_api" method="post" action="<?php echo $url_slug; ?>">
			<input type="hidden" name="_method" value="<?php echo $method;?>">
			<?php require_once($crm_form); ?>
		</form>
	</div>
</div>
