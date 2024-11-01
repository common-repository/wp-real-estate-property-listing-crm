<div>
<?php if( is_user_logged_in() ){ ?>
	<?php if( Mwp_Actions_XOut::get_instance()->check_property($property_id) ){ ?>
		<a
			class="butonactions property_xout_remove xout <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="<?php echo $property_id;?>"
			data-property-feed="<?php echo $feed;?>"
		>
			<span 
				class="glyphicon glyphicon-remove" 
				aria-hidden="true" 
				data-toggle="tooltip" 
				data-placement="left" 
				title="Un-Xout property"
				data-original-title="Un-Xout property"
			>
			</span>
		</a>
	<?php }else{ ?>
		<a
			class="butonactions property_xout xout <?php echo $class;?>"
			href="javascript:void(null)"
			data-property-id="<?php echo $property_id;?>"
			data-property-feed="<?php echo $feed;?>"
		>
			<span 
				class="glyphicon glyphicon-remove" 
				aria-hidden="true" 
				data-toggle="tooltip" 
				data-placement="left" 
				title="Xout property"
				data-original-title="Xout property"
			></span>
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
				class="glyphicon glyphicon-remove" 
				aria-hidden="true" 
				data-toggle="tooltip" 
				data-placement="left" 
				title="<?php _e('Register or login to Xout property', mwp_localize_domain());?>"
				data-original-title="<?php _e('Register or login to Xout property', mwp_localize_domain());?>"
			></span>
		</a>
		<?php if( !is_user_logged_in() ) { ?>
			<div class="content-<?php echo $action;?> hidden" style="display:hiden !important;"><?php echo $content;?></div>
		<?php } ?>

<?php } ?>
</div>
