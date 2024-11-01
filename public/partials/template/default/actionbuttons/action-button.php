<?php if( is_user_logged_in() ){ ?>
	<?php if( Mwp_Actions_Favorite::get_instance()->check_property($property_id) ){ ?>
		<a
			class="btn-outline butonactions btn btn-primary favorite property_favorite_remove btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="<?php echo $property_id;?>"
			data-property-feed="<?php echo $feed;?>"
			data-toggle="tooltip"
			data-placement="top"
			title="<?php _e('Remove to favorite', mwp_localize_domain());?>"
			role="button"
		>
			<i class="fa fa-heart"></i> <?php echo $label;?>
		</a>
	<?php }else{ ?>
		<a
			class="btn-outline butonactions btn btn-default favorite property_favorite btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="<?php echo $property_id;?>"
			data-property-feed="<?php echo $feed;?>"
			data-toggle="tooltip"
			data-placement="top"
			title="<?php _e('Add to favorite', mwp_localize_domain());?>"
			role="button"
		>
			<i class="fa fa-heart-o"></i> <?php echo $label;?>
		</a>
	<?php } ?>
<?php }else{ ?>
		<a
			class="btn-outline butonactions btn btn-default register-open btn-xs <?php echo $class;?>"
			href="javascript:void(null)"
			data-post="<?php echo "property-id={$property_id}&property-feed={$feed}"; ?>"
			data-current-action="<?php echo $action;?>"
			data-toggle="tooltip"
			data-placement="top"
			title="<?php _e('Register or login to add as favorites', mwp_localize_domain());?>"
			role="button"
		>
			<i class="fa fa-heart-o"></i> <?php echo $label;?>
		</a>
		<?php if( !is_user_logged_in() ) { ?>
			<div class="content-<?php echo $action;?> hidden" style="display:hiden !important;"><?php echo $content;?></div>
		<?php } ?>
<?php } ?>
