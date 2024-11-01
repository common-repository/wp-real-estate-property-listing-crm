<div class="thumbnail md-listing-grid <?php echo 'source-'.mwp_get_source();?>" id="property-details">
	<div class="md-label">
		<header>
			<span><?php mwp_transaction();?></span>
		</header>
	</div>
	<div class="md-listing-img">
		<a href="<?php echo mwp_property_detail_link(); ?>">
			<?php mwp_html_primary_photo(); ?>
		</a>
	</div>
	<div class="caption">
		<p class="mwp-price"><?php mwp_html_property_price();?></p>
		<a href="<?php echo mwp_property_detail_link();?>"><?php echo mwp_property_title();?></a>
		<ul class="list-unstyled list-inline">
			<?php if(mwp_show_bed()){ ?>
				<li class="border-mute">
					<?php mwp_property_beds();?> <?php echo _label('beds');?> 
				</li>
			<?php } ?>
			<?php if(mwp_show_bath()){ ?>
				<li>
					<?php mwp_property_bathrooms();?> <?php echo _label('baths');?> 
				</li>
			<?php } ?>
			<?php if(!has_filter('list_display_area_'.mwp_get_source())){ ?>
				<li>
					<?php echo apply_filters('property_area_' . mwp_get_source(), mwp_get_property_area());?> <?php echo mwp_get_account_data()->unit_area; ?>
				</li>
			<?php } ?>
		</ul>
	</div>
	<div class="footer">
		<?php
			$args_button_action = array(
				'favorite'	=> array(
					'show' => 1,
					'feed' => mwp_get_source(),
					'property_id' => mwp_property_id(),
				),
				'xout'	=> array(
					'show' => 1,
					'feed' => mwp_get_source(),
					'property_id' => mwp_property_id(),
				),
				'print' => array(
					'show' => 1,
					'url' => print_pdf(mwp_property_id(), mwp_get_source()),
				),
				'share'	=> array(
					'show' => 1,
					'property_id' => mwp_property_id(),
					'feed' => mwp_get_source(),
					'url' => mwp_property_detail_link(false),
					'address' => mwp_property_address('long', false)
				),
			);
			Mwp_Actions_Buttons::get_instance()->display($args_button_action);
		?>
	</div>
</div>
