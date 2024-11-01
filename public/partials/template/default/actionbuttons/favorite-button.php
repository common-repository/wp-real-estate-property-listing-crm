<div>
<?php if( is_user_logged_in() ){ ?>
	<?php if( Mwp_Actions_Favorite::get_instance()->check_property($property_id) ){ ?>
		<a
			class="butonactions favorite property_favorite_remove <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="<?php echo $property_id;?>"
			data-property-feed="<?php echo $feed;?>"
		>
			<span 
				class="glyphicon glyphicon-star" 
				data-toggle="tooltip"
				data-placement="left"
				aria-hidden="true" 
				data-original-title="<?php _e('Remove to favorite', mwp_localize_domain());?>">
			</span>
		</a>
	<?php }else{ ?>
		<a
			class="butonactions favorite property_favorite <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="<?php echo $property_id;?>"
			data-property-feed="<?php echo $feed;?>"
		>
			<span 
				class="glyphicon glyphicon-star" 
				data-toggle="tooltip" 
				data-placement="left" 
				aria-hidden="true" 
				title="<?php _e('Add to favorite', mwp_localize_domain());?>"
				data-original-title="<?php _e('Add to favorite', mwp_localize_domain());?>">
			</span>
		</a>
	<?php } ?>
<?php }else{ ?>
		<a
			class="butonactions register-open <?php echo $class;?>"
			href="javascript:void(null)"
			data-post="<?php echo "property-id={$property_id}&property-feed={$feed}"; ?>"
			data-current-action="<?php echo $action;?>"
		>
			<span 
				class="glyphicon glyphicon-star" 
				data-toggle="tooltip" 
				data-placement="left" 
				aria-hidden="true" 
				title="<?php _e('Register or login to add as favorites', mwp_localize_domain());?>"
				data-original-title="<?php _e('Register or login to add as favorites', mwp_localize_domain());?>">
			</span>
		</a>
		<?php if( !is_user_logged_in() ) { ?>
			<div class="content-<?php echo $action;?> hidden" style="display:hiden !important;"><?php echo $content;?></div>
		<?php } ?>
		
<?php } ?>
</div>
