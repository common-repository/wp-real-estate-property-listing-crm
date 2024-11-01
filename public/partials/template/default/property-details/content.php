<div class="mwp-property-details-pagex">
	<?php while(Mwp_View::get_instance()->data['property_data']->loop_property()): Mwp_View::get_instance()->data['property_data']->md_set_property();mwp_set_loop(Mwp_View::get_instance()->data['property_data']); ?>
		<script type="text/javascript">
			var mainLat = "<?php echo mwp_latitude();?>";
			var mainLng = "<?php echo mwp_longitude();?>";
			var mainAddress = "<?php echo mwp_raw_property_address();?>";
			var mwp_tb_pathToImage = "<?php echo mwp_public_url();?>images/loadingAnimation.gif";
		</script>
		<div class="mwp-bootstrap mwp-property-details-container ">
			<!-- md-property-page -->
			<div class="md-property-page">
				<!-- md-property-header-contain -->
				<div class="md-property-header-contain">
					<?php if( mwp_get_headers() == 0 ){ ?>
						<?php
							$part_search_form = Mwp_Theme_Locator::get_instance()->locate_template(Mwp_Theme_Layout_Entity::get_instance()->get_search_form());
							Mwp_View::get_instance()->display($part_search_form);
						?>
					<?php } ?>
					<!-- md-property-header -->
					<div class="md-property-header">
						<div class="md-property-title col-md-6">
							<?php if ( is_active_sidebar( 'mwp-property-details-above-header-title' ) ) : ?>
								<div class="mwp-property-details-above-header-title">
									<?php dynamic_sidebar( 'mwp-property-details-above-header-title' ); ?>
								</div>
							<?php endif; ?>
							<div class="address">
								<?php mwp_html_property_title(); ?>
							</div>
							<ul>
								<li class="price"><?php mwp_html_property_price();?> <?php mwp_property_display_unit();?></li>
								<li class="status"><?php echo _label('status');?>: <span><?php echo mwp_property_status(); ?></span></li>
								<li class="idno"><?php echo _label('mls');?>: <span><?php echo mwp_get_mls();?></span></li>
							</ul>
							<?php if ( is_active_sidebar( 'mwp-property-details-below-header-title' ) ) : ?>
								<div class="mwp-property-details-below-header-title">
									<?php dynamic_sidebar( 'mwp-property-details-below-header-title' ); ?>
								</div>
							<?php endif; ?>
						</div>
						<div class="md-header-btn col-md-6">
							<?php if( mwp_has_bookaview() ){ ?>
							<span class="<?php echo mwp_bookaview_align();?>">
								<a href="<?php echo mwp_bookaview_url();?>" class="md-more-btn" target="_blank">
								<?php echo mwp_bookaview_label();?>
								</a>
							</span>
							<?php } ?>
							<div class="md-property-btn">
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
					</div>
					<!-- md-property-header -->
				</div>
				<!-- md-property-header-contain -->
				<?php 
				if( $breadcrumb ) { ?>
					<ol class="breadcrumb hidden">
						<?php if( isset($breadcrumb['city']) ){ ?>
								<li><a href="<?php echo $breadcrumb['city']['url'];?>"><?php echo $breadcrumb['city']['label'];?></a></li>
						<?php } ?>
						<?php if( isset($breadcrumb['county']) ){ ?>
								<li><a href="<?php echo $breadcrumb['county']['url'];?>"><?php echo $breadcrumb['county']['label'];?></a></li>
						<?php } ?>
						<?php if( isset($breadcrumb['community']) ){ ?>
								<li><a href="<?php echo $breadcrumb['community']['url'];?>"><?php echo $breadcrumb['community']['label'];?></a></li>
						<?php } ?>
					</ol>
				<?php } ?>
				
				<div class="md-property-section"><!-- md-property-section -->
					<div class="md-property-contain"><!-- md-property-contain -->
						<div class="col-md-8"><!-- col-md-8 -->
							<!-- Nav tabs -->
							<ul class="nav nav-pills desktop <?php do_action('single_nav_tab');?> <?php //do_action('single_nav_tab_'.get_single_property_source());?>" role="tablist">
								<li role="presentation" class="active"><a href="#property-details" aria-controls="property-details" role="tab" data-toggle="tab"><?php echo _label('property-details');?></a></li>
								<li role="presentation"><a href="#map-directions" aria-controls="map-directions" role="tab" data-toggle="tab"><?php echo _label('map-and-directions');?></a></li>
								<?php if(!has_filter('show_walkscore')){ ?>
									<li role="presentation"><a href="#walkscore" aria-controls="walkscore" role="tab" data-toggle="tab"><?php echo _label('walk-score');?></a></li>
								<?php } ?>
								<li role="presentation"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab"><?php echo _label('single-photos');?></a></li>
								<?php if( mwp_get_param_video() ){ ?>
									<li role="presentation"><a href="#video" role="tab" data-toggle="tab"><?php echo _label('video');?></a></li>
								<?php } ?>
								<?php if( mwp_greatschool_api() ){ ?>
									<li role="presentation"><a href="#school" role="tab" data-toggle="tab"><?php echo _label('school');?></a></li>
								<?php } ?>
							</ul>
							<ul class="nav nav-pills mobile <?php do_action('single_nav_tab');?> <?php //do_action('single_nav_tab_'.get_single_property_source());?>" role="tablist">
								<li role="presentation" class="dropdown">
								<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Select Tab<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li role="presentation" class="active"><a href="#property-details" aria-controls="property-details" role="tab" data-toggle="tab"><?php echo _label('property-details');?></a></li>
										<li role="presentation"><a href="#map-directions" aria-controls="map-directions" role="tab" data-toggle="tab"><?php echo _label('map-and-directions');?></a></li>
										<?php if(!has_filter('show_walkscore')){ ?>
											<li role="presentation"><a href="#walkscore" aria-controls="walkscore" role="tab" data-toggle="tab"><?php echo _label('walk-score');?></a></li>
										<?php } ?>
										<li role="presentation"><a href="#photos" aria-controls="photos" role="tab" data-toggle="tab"><?php echo _label('single-photos');?></a></li>
										<?php if( mwp_get_param_video() ){ ?>
											<li role="presentation"><a href="#video" role="tab" data-toggle="tab"><?php echo _label('video');?></a></li>
										<?php } ?>
										<?php if( mwp_greatschool_api() ){ ?>
											<li role="presentation"><a href="#school" role="tab" data-toggle="tab"><?php echo _label('school');?></a></li>
										<?php } ?>
									</ul>
								</li>
							</ul>
							<!-- Nav tabs -->
							<!-- Tab panes -->
							  <div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="property-details">
									<div class="mwp-single-property-image-gallery">
										<?php 
											$photo_data['photos'] = mwp_single_photos();
											Mwp_View::get_instance()->display(Mwp_View::get_instance()->data['part_photo_carousel'], $photo_data);
										?>
									</div>
									<?php if ( is_active_sidebar( 'mwp-property-details-photo-gallery' ) ) : ?>
										<div class="mwp-property-details-photo-gallery">
											<?php dynamic_sidebar( 'mwp-property-details-photo-gallery' ); ?>
										</div>
									<?php endif; ?>
									<?php Mwp_View::get_instance()->display(Mwp_View::get_instance()->data['part_listing_information'], Mwp_View::get_instance()->data); ?>
									
									<?php if ( is_active_sidebar( 'mwp-property-details-above-map' ) ) : ?>
										<div class="mwp-property-details-above-map">
											<?php dynamic_sidebar( 'mwp-property-details-above-map' ); ?>
										</div>
									<?php endif; ?>
									
									<div class="mini-map">
									   <h2><span><?php _e('Map on', mwp_localize_domain());?> <?php echo mwp_property_title();?></span></h2>
									   <div class="quick_map_view" style="height:450px;"></div>
									   <?php $address = mwp_geocode_coordinates(mwp_latitude(), mwp_longitude()); ?>
									   <?php if($address) { ?>
										<h3><a href="https://www.google.com/maps/place/<?php echo $address;?>">Open Google Map</a></h3>
									   <?php } ?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="map-directions">
									<div class="mwp-tab-map">
										<?php 
											Mwp_View::get_instance()->display($tab_map, Mwp_View::get_instance()->data); 
										?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="walkscore">
									<div class="mwp-tab-container">
										<?php 
											Mwp_View::get_instance()->display($tab_walkscore, Mwp_View::get_instance()->data); 
										?>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="photos">
									<div class="mwp-tab-container">
										<?php 
											Mwp_View::get_instance()->display($tab_photos, Mwp_View::get_instance()->data); 
										?>
									</div>
								</div>
								<?php if( mwp_get_param_video() ){ ?>
									<div role="tabpanel" class="tab-pane" id="video">
										<div class="mwp-tab-container">
											<?php mwp_display_video(); ?>
										</div>
									</div>
								<?php } ?>
								<?php if( mwp_greatschool_api() ){ ?>
									<div role="tabpanel" class="tab-pane" id="school">
										<div class="mwp-tab-container">
											<?php 
												$school_data = array(
													'address' => mwp_property_address('long', false),
													'state' => mwp_get_state(),
													'template' => $tab_school
												);
												mwp_display_school_info($school_data); 
											?>
										</div>
									</div>
								<?php } ?>
							 </div><!-- Tab panes -->
						</div><!-- col-md-8 -->
						<div class="md-propdtr col-md-4 clearfix"><!-- md-propdtr col-md-4 clearfix -->
							<?php if ( is_active_sidebar( 'mwp-property-details-right-above' ) ) : ?>
								<div class="mwp-property-details-right-above">
									<?php dynamic_sidebar( 'mwp-property-details-right-above' ); ?>
								</div>
							<?php endif; ?>
							<div class="md-propdtr-box wd-100 float-left">
								<div class="md-propdtr-stats">
									<div class="value ft-blue"><?php mwp_html_property_price();?> <?php mwp_property_display_unit();?></div>
									<div class="label"><?php echo _label('price');?></div>
								</div>
							</div>
							<?php if( mwp_property_beds(false) == '' && mwp_property_bathrooms(false) == ''){ ?>
								<?php if(mwp_show_bed()){ ?>
									<div class="md-propdtr-box wd-50 float-left">
										<div class="md-propdtr-stats">
											<?php if( mwp_property_beds(false) > 0 && mwp_property_beds(false) != '' ){ ?>
												<div class="value"><?php mwp_property_beds();?></div>
												<div class="label"><?php echo _label('beds');?></div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
								<?php if(mwp_show_bath()){ ?>
										<div class="md-propdtr-box wd-50 float-left">
											<div class="md-propdtr-stats">
												<?php if( mwp_property_bathrooms(false) > 0 && mwp_property_bathrooms(false) != '' ){ ?>
													<div class="value"><?php mwp_property_bathrooms();?></div>
													<div class="label"><?php echo _label('baths');?></div>
												<?php } ?>
											</div>
										</div>
								<?php } ?>
							<?php }//if bed and bath is empty ?>
							<?php if(!has_filter('list_display_area') ){ ?>
								<div class="md-propdtr-box wd-50 float-left">
									<div class="md-propdtr-stats">
										<?php if( mwp_get_property_area() != 0 ){ ?>
											<div class="value">
											<?php
												if( has_action('single_area_measurement_'.mwp_get_source()) ){
													do_action('single_area_measurement_'.mwp_get_source());
												}else{
													echo apply_filters('property_area_' . mwp_get_source(), mwp_get_property_area());
												}
											?>
											</div>
											<div class="label">
											<?php do_action( 'single_before_area_measurement' ); ?>
											<?php
												if( has_action('single_area_measurement_unit_'.mwp_get_source()) ){
													do_action('single_area_measurement_unit_'.mwp_get_source());
												}else{
													echo apply_filters('property_area_unit_' . mwp_get_source(), mwp_get_property_area_unit());
												}
											?>
											</div>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
							
							<div class="md-propdtr-box wd-50 float-left">
								<div class="md-propdtr-stats">
									<?php if( mwp_year_built() != 0 ){ ?>
										<div class="value"><?php echo mwp_year_built(); ?></div>
										<div class="label"><?php echo _label('year-built');?></div>
									<?php } ?>
								</div>
							</div>
							<div class="md-propdtr-box wd-100 float-left">
								<div class="md-propdtr-stats">
									<div class="value"><?php echo mwp_get_mls();?></div>
									<div class="label"><?php echo _label('mls');?></div>
								</div>
							</div>
							<div class="md-propdtr-box wd-100 float-left">
								<?php
									$attr_agent = array(
										'agent' => mwp_get_agent(),
										'property' => mwp_get_data_loop()
									);
									mwp_display_agent_details($attr_agent);
								?>
							</div>
							<div class="mgt-20 wd-100 float-left">
								<?php
									$attr_inquire = array(
										'assigned_to' => mwp_get_data_loop()->assigned_to(),
										'source_url' => mwp_property_detail_link(false),
										'show' => 1,
										'msg' => __("I would like to get more information regarding", mwp_localize_domain()) . mwp_get_mls() .' '. mwp_property_address('long', false),
									);
									Mwp_Theme_Inquire::get_instance()->display($attr_inquire);
								?>
								<?php if ( is_active_sidebar( 'mwp-property-details-below-inquire-forms' ) ) : ?>
									<div class="mwp-property-details-below-inquire-forms">
										<?php dynamic_sidebar( 'mwp-property-details-below-inquire-forms' ); ?>
									</div>
								<?php endif; ?>
							</div>
						</div><!-- md-propdtr col-md-4 clearfix -->
					</div><!-- md-property-contain -->
				</div><!-- md-property-section -->
				
			</div><!-- md-property-page -->
		</div><!-- mwp-bootstrap -->
	<?php endwhile; ?>
	<div class="mwp-bootstrap md-property-page">
		<div class="md-property-section">
			<div class="md-property-contain">
				<div class="col-md-12 mgt-20">
					<?php
						if( !has_filter('do_not_show_this_similarhomes') ){
							mwp_display_similar_property($parse_url, Mwp_View::get_instance()->data);
						}
					?>
					<?php if ( is_active_sidebar( 'mpb-property-details-below-similar' ) ) : ?>
						<div class="mpb-property-details-below-similar">
							<?php dynamic_sidebar( 'mpb-property-details-below-similar' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php //Mwp_Actions_EmailTo::get_instance()->display(); ?>
