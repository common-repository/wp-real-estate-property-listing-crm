<div class="row">
	<div class="col-md-6">
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong><?php _e('Property ID', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->get_mlsid();?></li>
			<li class="tab-dark"><strong><?php _e('Status', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->property_status();?></li>
			<li class="tab-light"><strong><?php _e('Location', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->get_address();?></li>
			<li class="tab-dark"><strong><?php _e('Bedroom', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->bed();?></li>
			<li class="tab-light"><strong><?php _e('Living Sq. Ft', mwp_localize_domain());?>: </strong><?php echo mwp_get_data_loop()->get_sqft_heated();?></li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-unstyled right-details">
			<li class="tab-light"><strong><?php _e('Lot Area', mwp_localize_domain());?>: </strong>
				<?php echo apply_filters('property_area_' . mwp_get_source(), mwp_get_property_area('lot'));?>
				<?php echo apply_filters('property_area_unit_' . mwp_get_source(), mwp_get_property_area_unit());?>
			</li>
			<li class="tab-dark"><strong><?php _e('Price', mwp_localize_domain());?> : </strong><?php echo mwp_html_property_price(false);?></li>
			<li class="tab-light"><strong><?php _e('Bathroom', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->bath();?></li>
			<li class="tab-dark"><strong><?php _e('Year Built', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->year_built();?></li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="single-property-desc md-container">
			<h2><span><?php _e('Details on', mwp_localize_domain());?> </strong><?php echo mwp_get_data_loop()->get_address('short');?></span></h2>
			<p></strong><?php echo wp_strip_all_tags(mwp_get_data_loop()->get_description());?></p>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span><?php _e('Location Information', mwp_localize_domain());?> </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong><?php _e('County', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->get_county_name();?> </li>
			<li class="tab-dark"><strong>HOA :  </strong><?php echo mwp_get_data_loop()->hoa();?> </li>
			<li class="tab-light"><strong><?php _e('Subdivision', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->community();?> </li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span><?php _e('Interior Features', mwp_localize_domain());?> </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong><?php _e('Interior Features', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_interior_features();?> </li>
			<li class="tab-dark"><strong><?php _e('Fireplace', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_fireplace_yn() == 0 ? 'No':'Yes';?> </li>
			<li class="tab-light"><strong><?php _e('Heating and Fuel', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_heating_fuel();?> </li>
			<li class="tab-dark"><strong><?php _e('Flooring', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_floor_covering();?> </li>
			<li class="tab-light"><strong><?php _e('Full Baths', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_bath_full();?> </li>
			<li class="tab-dark"><strong><?php _e('Air Conditioning', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_air_conditioning();?> </li>
			<li class="tab-light"><strong><?php _e('Heat / Air Conditioning', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_heat_air_conditioning();?> </li>
			<li class="tab-dark"><strong><?php _e('Appliances Included', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_appliances_included();?> </li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span><?php _e('Exterior Features', mwp_localize_domain());?> </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong><?php _e('Construction', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_exterior_construction();?> </li>
			<li class="tab-dark"><strong><?php _e('Foundation', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_foundation();?> </li>
			<li class="tab-light"><strong><?php _e('Garage Features', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_garage_features();?> </li>
			<li class="tab-dark"><strong><?php _e('Garage / Carport', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_garage_carport();?> </li>
			<li class="tab-light"><strong><?php _e('Lot Size Sq Ft', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_lot_size_sqft();?> </li>
			<li class="tab-dark"><strong><?php _e('Exterior Features', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_exterior_features();?> </li>
			<li class="tab-light"><strong><?php _e('Roof', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_roof();?> </li>
			<li class="tab-dark"><strong><?php _e('Utilities', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_utilities();?> </li>
			<li class="tab-light"><strong><?php _e('Lot Size Acres', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_lot_size_acres();?> </li>
			<li class="tab-dark"><strong><?php _e('Water Frontage', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_water_frontage_yn() == 0 ? 'No':'Yes';?> </li>
			<li class="tab-light"><strong><?php _e('Pool', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_pool();?> </li>
			<li class="tab-dark"><strong><?php _e('Pool Type', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_pool_type();?> </li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<h3><span><?php _e('Additional Information', mwp_localize_domain());?> </span></h3>
		<ul class="list-unstyled left-details">
			<li class="tab-dark"><strong><?php _e('Year Built', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->year_built();?> </li>
			<li class="tab-light"><strong><?php _e('Property SubType', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_property_type();?> </li>
			<li class="tab-dark"><strong><?php _e('Taxes', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_taxes();?> </li>
			<li class="tab-light"><strong><?php _e('Tax Year', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_tax_year();?> </li>
			<li class="tab-dark"><strong><?php _e('Listing Office', mwp_localize_domain());?> :  </strong><?php echo mwp_get_data_loop()->display_listing_office();?> </li>
		</ul>
	</div>
</div>
<?php if(Mwp_View::get_instance()->data['property_data']->get_custom_fields()){ ?>
	<?php foreach(Mwp_View::get_instance()->data['property_data']->get_custom_fields() as $key => $val){//loop $md_custom_fields_data ?>
			<div class="row">
				<div class="col-md-12">
					<h3><span><?php echo $key;?></span></h3>
					<?php $c = 0; ?>
					<?php if(is_array($val) && count($val) > 0 ){ ?>
							<ul class="list-unstyled left-details">
							<?php foreach($val as $child_key => $child_val){ ?>
									<li class="tab-<?=($c++%2==1) ? 'dark' : 'light' ?>">
										<strong><?php echo $child_key;?> : </strong>
										<?php 
											if( $child_val == 1 ){
												echo 'Yes';
											}elseif( $child_val == 0){
												echo 'No';
											}else{
												echo $child_val;
											}
										?> 
									</li>
							<?php } ?>
							</ul>
					<?php } ?>
				</div>
			</div>
	<?php } ?>
<?php }//if $md_custom_fields_data ?>

