<table class="form-table">
	<tbody>
		<tr>
			<th scope="row"><label for="settings_api_default_feed"><?php _e('Property Data Feed', mwp_localize_domain());?></label></th>
			<td>
				<select name="settings_api_default_feed">
					<option value="0"><?php _e('Select Data Feed', mwp_localize_domain());?></option>
					<option value="crm" <?php echo ($api_feed == 'crm') ? 'selected':''; ?>>CRM</option>
					<option value="mls" <?php echo ($api_feed == 'mls') ? 'selected':''; ?>>MLS</option>
				</select>
				<p><?php _e('Search Property, Choose which default data to get properties feed, mostly the default is CRM ( unless masterdigm setup a MLS data on your account )', mwp_localize_domain());?></p>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="settings_api_key">API KEY : </label></th>
			<td><input type="text" name="settings_api_key" value="<?php echo $key;?>" style="width:100%;"></td>
		</tr>
		<tr>
			<th scope="row"><label for="settings_api_token">API TOKEN : </label></th>
			<td><input type="text" name="settings_api_token" value="<?php echo $token;?>" style="width:100%;"></td>
		</tr>
		<tr>
			<th scope="row"><label for="settings_api_broker_id">Broker ID : </label></th>
			<td><input type="text" name="settings_api_broker_id" value="<?php echo $broker_id;?>" style="width:100%;"></td>
		</tr>
	</tbody>
</table>
<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php _e('Update', mwp_localize_domain()) ?>" />
</p>
