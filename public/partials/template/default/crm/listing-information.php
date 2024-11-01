<div class="row md-propdtr">
	<div class="col-md-6 md-propdtr-details">
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong><?php _e('Status', mwp_localize_domain());?> :</strong> <?php echo mwp_get_data_loop()->get_property_status_label();?></li>
			<li class="tab-dark"><strong><?php _e('Transaction Type', mwp_localize_domain());?> :</strong> <?php echo mwp_get_data_loop()->transaction_type();?></li>
			<li class="tab-light"><strong><?php _e('Type', mwp_localize_domain());?> :</strong> <?php echo mwp_display_property_types_tag();?></li>
			<li class="tab-dark"><strong><?php _e('Location', mwp_localize_domain());?> :</strong> <?php echo mwp_get_data_loop()->city();?></li>
			<?php if(!has_filter('show_community_details_crm')){ ?>
				<li class="tab-light"><strong><?php _e('Community', mwp_localize_domain());?> :</strong> <?php echo mwp_get_data_loop()->community();?></li>
			<?php } ?>
			<?php if(!has_filter('single_display_area') && mwp_get_data_loop()->html_lot_area() != 0){ ?>
			<li class="<?php has_filter('show_community_details_crm') ? 'tab-dark':'tab-light';?>">
				<strong><?php do_action( 'single_before_lot_area' ); ?><?php echo _label('lot-area-size');?>:</strong>
				<?php echo mwp_get_data_loop()->html_lot_area(); ?>
			</li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-md-6 md-propdtr-details">
		<ul class="list-unstyled right-details md-propdtr-details">
			<li class="tab-light"><strong><?php echo _label('mls');?> :</strong> <?php echo mwp_get_mls();?></li>
			<li class="tab-dark"><strong><?php _e('Price', mwp_localize_domain());?> :</strong> <?php echo mwp_html_property_price();?> <?php mwp_property_display_unit();?></li>
			<?php if(mwp_show_bed() && mwp_get_data_loop()->bed() != 0){ ?>
				<li class="tab-light"><strong><?php _e('Bedroom', mwp_localize_domain());?> :</strong> <?php echo mwp_get_data_loop()->bed();?></li>
			<?php } ?>
			<?php if(mwp_show_bath() && mwp_get_data_loop()->baths != 0){ ?>
				<li class="tab-dark"><strong><?php _e('Bathroom', mwp_localize_domain());?> :</strong> <?php echo mwp_get_data_loop()->baths;?></li>
			<?php } ?>
			<?php if(!has_filter('show_floor_area_details_crm') && mwp_get_data_loop()->html_floor_area() != 0){ ?>
			<li  class="tab-light">
				<?php do_action( 'single_before_floor_area' ); ?>
				<strong><?php echo _label('floor-area-size');?> : </strong>
				<?php echo mwp_get_data_loop()->html_floor_area(); ?>
				<?php //echo apply_filters('property_area_unit_' . mwp_get_source(), mwp_get_property_area_unit());?>
			</li>
			<?php } ?>
			<?php if(!has_filter('single_display_year_built') && mwp_get_data_loop()->year_built != 0){ ?>
				<li class="<?php has_filter('show_floor_area_details_crm') ? 'tab-dark':'tab-light';?>"><strong><?php _e('Year Built', mwp_localize_domain());?> :</strong> <?php echo mwp_get_data_loop()->year_built;?></li>
			<?php } ?>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="single-property-desc md-container">
			<div class="details-txt">
                <h2><span><?php _e('Details on', mwp_localize_domain());?> <?php echo mwp_property_title();?></span></h2>
				<div class="description">
					<?php echo mwp_get_data_loop()->description;?>
				</div>
			</div>
		</div>
	</div>
</div>
