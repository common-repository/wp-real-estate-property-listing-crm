<?php while(Mwp_View::get_instance()->data['property_data']->loop_property()): Mwp_View::get_instance()->data['property_data']->md_set_property();mwp_set_loop(Mwp_View::get_instance()->data['property_data']); ?>
	<script type="text/javascript">
		var mainLat = "<?php echo mwp_latitude();?>";
		var mainLng = "<?php echo mwp_longitude();?>";
		var mainAddress = "<?php echo mwp_raw_property_address();?>";
		var mwp_tb_pathToImage = "<?php echo mwp_public_url();?>images/loadingAnimation.gif";
	</script>
	<div class="mwp-bootstrap mwp-property-details-container container-fluid">
		<div class="container">
			<div class="page-header">
				<?php mwp_html_property_title(); ?>
			</div>
			<?php 
			if( $breadcrumb ) { ?>
				<ol class="breadcrumb">
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
			<div class="row property-details-row">
			<div class="col-sm-12 col-md-8"><!--col-sm-12 col-md-8-->
				<div>
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs <?php do_action('single_nav_tab');?> <?php //do_action('single_nav_tab_'.get_single_property_source());?>" role="tablist">
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

				  <!-- Tab panes -->
				  <div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="property-details">
						<ul class="list-inline mwp-list-inline single-property-quick-info <?php do_action('quick_info');?> <?php do_action('quick_info_'.mwp_get_current_api_source());?>">
							<li class="price">
								<?php echo mwp_property_html_price();?> [<?php mwp_property_display_unit();?>]
							</li>
							<?php if(mwp_show_bed()){ ?>
								<?php if( mwp_property_beds(false) > 0 || mwp_property_beds(false) != '' ){ ?>
								<li class="beds">
									<?php mwp_property_beds();?>
									<span><?php echo _label('beds');?></span>
								</li>
								<?php } ?>
							<?php } ?>
							<?php if(mwp_show_bath()){ ?>
								<?php if( mwp_property_bathrooms(false) > 0 || mwp_property_bathrooms(false) != '' ){ ?>
									<li class="baths">
										<?php mwp_property_bathrooms();?>
										<span><?php echo _label('baths');?></span>
									</li>
								<?php } ?>
							<?php } ?>

							<?php if(!has_filter('list_display_area')){ ?>
								<li class="area-measurement">
									<?php
										if( has_action('single_area_measurement_'.mwp_get_source()) ){
											do_action('single_area_measurement_'.mwp_get_source());
										}else{
											echo apply_filters('property_area_' . mwp_get_source(), mwp_get_property_area());
										}
									?>
									<span>
										<?php do_action( 'single_before_area_measurement' ); ?>
										<?php
											if( has_action('single_area_measurement_unit_'.mwp_get_source()) ){
												do_action('single_area_measurement_unit_'.mwp_get_source());
											}else{
												echo apply_filters('property_area_unit_' . mwp_get_source(), mwp_get_property_area_unit());
											}
										?>
									</span>
								</li>
							<?php } ?>
							<li class="yr-built">
								<?php
									if( has_filter('year_built_'.mwp_get_source()) ){
										echo apply_filters('year_built_'.mwp_get_source(), mwp_year_built());
									}else{
										echo mwp_year_built();
										?><span><?php echo _label('year-built');?></span><?php
									}
								?>
							</li>
							<?php if(!has_filter('list_display_mls')){ ?>
							<li class="mls">
								<?php echo mwp_get_mls();?>
								<span><?php echo _label('mls');?></span>
							</li>
							<?php } ?>
						</ul>
						<div class="mwp-single-property-image-gallery">
							<?php 
								$photo_data['photos'] = mwp_single_photos();
								Mwp_View::get_instance()->display(Mwp_View::get_instance()->data['part_photo_carousel'], $photo_data);
							?>
						</div>
						<?php Mwp_View::get_instance()->display(Mwp_View::get_instance()->data['part_listing_information'], Mwp_View::get_instance()->data); ?>
						<div class="mini-map">
							<h2><span><?php _e('Map on', mwp_localize_domain());?> <?php echo mwp_property_title();?></span></h2>
						   <div class="quick_map_view" style="height:450px;"></div>
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
				  </div>
				</div>
			</div><!-- Left Side -->
			<!-- Right -->
			<div class="col-sm-12 col-md-4">
				<?php if( mwp_has_bookaview() ){ ?>
				<div class="mwp-book-a-viewing">
					<h3 class="<?php echo mwp_bookaview_align();?>">
						<a href="<?php echo mwp_bookaview_url();?>" target="_blank">
						<?php echo mwp_bookaview_label();?>
						</a>
					</h3>
				</div>
				<?php } ?>
				<div class="panel panel-default">
					<div class="panel-body mwp-property-details-action-buttons">
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
				<div class="mwp-agent-box">
					<?php
						$attr_agent = array(
							'agent' => mwp_get_agent(),
							'property' => mwp_get_data_loop()
						);
						mwp_display_agent_details($attr_agent);
					?>
				</div>	
				<?php
					$attr_inquire = array(
						'assigned_to' => mwp_get_data_loop()->assigned_to(),
						'source_url' => mwp_property_detail_link(false),
						'show' => 1,
						'msg' => __("I would like to get more information regarding", mwp_localize_domain()) . mwp_get_mls() .' '. mwp_property_address('long', false),
					);
					Mwp_Theme_Inquire::get_instance()->display($attr_inquire);
				?>
			</div>
			<!-- Right -->
		</div>
		</div>
	</div>
<?php endwhile; ?>
<div class="mwp-bootstrap container-fluid mwp-similar-homes">
	<div class="container">
		<div class="col-sm-12">
			<?php
				if( !has_filter('do_not_show_this_similarhomes') ){
					mwp_display_similar_property($parse_url, Mwp_View::get_instance()->data);
				}
			?>
		</div>
	</div>
</div>

