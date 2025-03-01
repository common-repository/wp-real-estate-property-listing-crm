<h3><?php _e('You have', mwp_localize_domain());?> <span class="badge"><?php echo count($search_data); ?></span> <?php _e('Save Search', mwp_localize_domain());?></h3>
<div class="saved-search">
	<?php if( $has_saved_search ){//if $search_data ?>
		<form role="form" class="save-search-form" method="POST" action="<?php echo $redirect; ?>">
			<ul class="list-group list-saved-search">
				<?php foreach($search_data as $key => $val){//foreach $search_data ?>
						<li class="list-group-item" style="text-align:left;background:#eeeeee;">
							<div class="content-saved-search">
								<input type="text" name="save_search_name[<?php echo $val['md5_save_search_name'];?>]" value="<?php echo $val['save_search_name'];?>">
								<a href="trash?id=<?php echo $val['md5_save_search_name'];?>&_nonce=<?php echo wp_create_nonce('trash-saved-search-'. $val['md5_save_search_name'] . $user_account->ID);?>" class="btn btn-default btn-xs" role="button"><?php _e('delete', mwp_localize_domain());?></a>
								<?php if( isset($val['subscribed_property_alert']) && $val['subscribed_property_alert'] == 1 ){// if subscribed_property_alert ?>
								<?php }elseif(isset($val['subscribed_property_alert']) && $val['subscribed_property_alert'] == 0){ ?>
									- <a href="subscribe?id=<?php echo $val['md5_save_search_name'];?>&_nonce=<?php echo wp_create_nonce('subscribe-saved-search-'. $val['md5_save_search_name'] . $user_account->ID);?>" class="btn btn-default btn-xs" role="button"><?php _e('Subscribe to property alert', mwp_localize_domain());?></a>
								<?php }// if subscribed_property_alert ?>
								- <a href="<?php echo $val['http_referrer'];?>" class="btn btn-default btn-xs" role="button" target="_blank">
									<?php _e('Run this search', mwp_localize_domain());?>
								</a>
							</div>
						</li>
				<?php }//loop $search_data ?>
			</ul>
			<input type="hidden" name="task" value="update_save_search">
			<p>
			<button type="submit" class="btn btn-primary"><?php _e('Update', mwp_localize_domain());?></button>
			</p>
		</form>
	<?php }//if $search_data ?>
</div>
<div id="unsubscribe-button">
	<?php Mwp_Propertyalert_Entity::get_instance()->display_unsubscribe_button('');?>
</div>
