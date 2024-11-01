	
	<a href="<?php echo mwp_property_detail_link(); ?>" style="display:block; height:100%; width:90%; text-decoration:none; outline:none;">&nbsp;</a>
    <div class="md-listing-info">
		<a href="<?php echo mwp_property_detail_link(); ?>">
		<div class="md-listing-price"><?php mwp_html_property_price();?> <?php mwp_property_display_unit();?></div>
		<div class="md-listing-address"><?php echo mwp_property_title();?></div>
		</a>
		<?php if( mwp_property_beds(false) > 0 || mwp_property_bathrooms(false) > 0 || mwp_property_garage(false) > 0 ){ ?>
		<div class="md-listings-stats">
			<?php if(mwp_show_bed() && mwp_property_beds(false) > 0){ ?>
				<div class="md-listings-stats-label inline-block">
					<div class="value"><?php mwp_property_beds();?></div>
					<div class="label"><?php echo _label('beds');?></div>
				</div>
			<?php } ?>
			<?php if(mwp_show_bath() && mwp_property_bathrooms(false) > 0){ ?>
				<div class="md-listings-stats-label inline-block">
					<div class="value"><?php mwp_property_bathrooms();?></div>
					<div class="label"><?php echo _label('baths');?></div>
				</div>
			<?php } ?>
			<?php if(mwp_show_garage() && mwp_property_garage(false) > 0){ ?>
				<div class="md-listings-stats-label inline-block last">
					<div class="value"><?php mwp_property_garage();?></div>
					<div class="label"><?php echo _label('garage');?></div>
				</div>
			<?php } ?>
		</div>
		<?php } ?>
		<?php if(!has_filter('list_display_area_'.mwp_get_source())){ ?>
			<div class="md-listings-stats2">
				<?php if( mwp_get_property_floor_area() > 0 ){ ?>
				<div class="md-listings-stats-label inline-block">
					<div class="value"><?php echo mwp_get_data_loop()->html_floor_area();?></div>
					<div class="label"><?php echo _label('floor-area-size');?></div>
				</div>
				<?php } ?>
				<?php if( mwp_get_property_lot_area() > 0 ){ ?>
				<div class="md-listings-stats-label inline-block last">
					<div class="value"><?php echo mwp_get_data_loop()->html_lot_area();?></div>
					<div class="label"><?php echo _label('lot-area-size');?></div>
				</div>
				<?php } ?>
			</div>
		<?php } ?>
		
	</div>
	<div class="md-listing-sash">
		<?php if( mwp_transaction(false) != '' ){ ?>
			<div class="sash active"><?php mwp_transaction();?></div>
		<?php } ?>
		<?php if(mwp_display_property_types_tag() != ''){ ?>
			<div class="sash active"><?php echo mwp_display_property_types_tag();?></div>
		<?php } ?>
		<?php if( mwp_property_status() != '' ){ ?>
			<div class="sash active"><?php echo mwp_property_status();?></div>
		<?php } ?>
		<div class="sash active"><?php echo count(mwp_property_photos());?> <?php echo _label('list_photos');?></div>
		<?php if( mwp_hji_show_days_on_market() ){ ?>
			<div class="sash new"><?php _label('list-just-listed'); ?></div>
		<?php } ?>
	</div>
	<div class="md-listing-btn">
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
					'address' => mwp_raw_property_address('long', false)
				),
			);
			Mwp_Actions_Buttons::get_instance()->display($args_button_action);
		?>
	</div>
