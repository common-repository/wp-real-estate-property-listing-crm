<div class="md-listing mwp_list_main_background <?php echo 'source-'.mwp_get_source();?>" id="property-details">
	<div class="md-label">
		<header>
			<span class="mwp_list_main_content_second_fontcolor mwp_list_main_second_background"><?php mwp_transaction();?></span>
			<?php if( mwp_hji_show_days_on_market() ){ ?>
				<span class="mwp_list_main_content_second_fontcolor mwp_list_main_second_background"><?php echo _e('Just Listed', mwp_localize_domain());?></span>
			<?php } ?>
		</header>
	</div>
	<div class="md-listing-img">
		<a href="<?php echo mwp_property_detail_link(); ?>">
			<?php mwp_html_primary_photo(); ?>
		</a>
	</div>
	<div class="md-listing-info">
		<header class="text-center">
			<h5><a class="" href="<?php echo mwp_property_detail_link();?>"><?php echo mwp_property_title();?></a></h5>
		</header>
		<p class="md-location text-center hidden"></p>
		<header><p class="md-price text-center mwp_list_secondary_background mwp_list_font_color"><?php mwp_html_property_price();?></p></header>
		<div class="md-ameni">
		<ul class="list-unstyled">
			<?php if(mwp_show_bed()){ ?>
				<li class="border-mute">
					<span class="pull-left"><?php echo _label('beds');?></span>
					<span class="pull-right"><?php mwp_property_beds();?></span>
				</li>
			<?php } ?>
			<?php if(mwp_show_bath()){ ?>
				<li>
					<span class="pull-left"><?php echo _label('baths');?></span>
					<span class="pull-right"><?php mwp_property_bathrooms();?></span>
				</li>
			<?php } ?>
			<?php if(mwp_show_garage()){ ?>
				<?php //if( mwp_property_garage(false) != '0' ){ ?>
					<li>
						<?php //if( md_crm_property_type_compare(get_property_type(), 'residential') ){ ?>
							<span class="pull-left"><?php echo _label('garage');?></span>
							<span class="pull-right"><?php mwp_property_garage();?></span>
					</li>
				<?php //} ?>
			<?php } ?>
			<?php if(!has_filter('list_display_area_'.mwp_get_source())){ ?>
				<li class="area-measurement">
					<span class="pull-left"><?php echo _label('floor-area-size');?></span>
					<span class="pull-right"><?php echo mwp_get_data_loop()->html_floor_area();?></span>
				</li>
				<li class="area-measurement">
					<span class="pull-left"><?php echo _label('lot-area-size');?></span>
					<span class="pull-right"><?php echo mwp_get_data_loop()->html_lot_area();?></span>
				</li>
			<?php } ?>
		</ul>
		<div class="clearfix">&nbsp;</div>
		</div>
	</div>
	<div class="md-listing-footer text-center">
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
</div>
