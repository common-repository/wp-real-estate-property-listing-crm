<div class="row md-container">
	<div class="col-md-12">
		<!-- Nav tabs -->
		<p></p>
		<ul class="nav nav-pills desktop" role="tablist">
			<li role="presentation" class="active"><a href="#map-view" aria-controls="map-view" role="tab" data-toggle="tab">Map View</a></li>
			<li role="presentation"><a href="#street-view" aria-controls="street-view" role="tab" data-toggle="tab">Street View</a></li>
			<li role="presentation"><a href="#birdseye-view" aria-controls="birdseye-view" role="tab" data-toggle="tab">Birds Eye View</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content md-container">
			<div role="tabpanel" class="tab-pane active" id="map-view">
				<div class="map_view"></div>
				<h3>Distance & Driving Directions</h3>
				<form id="get_directions">
				  <div class="form-group">
					<label for="From">From</label>
					<input type="text" class="form-control" id="from" placeholder="From">
				  </div>
				  <div class="form-group">
					<label for="to">To</label>
					<input type="text" class="form-control" id="from" placeholder="To" value="<?php echo mwp_property_address('long',false);?>" readonly>
				  </div>
				  <button type="submit" class="btn btn-default">Get Directions</button>
				</form>
				<div class="directions"></div>
			</div>
			<div role="tabpanel" class="tab-pane" id="street-view">
				<div class="street_view" id="street_view"></div>
			</div>
			<div role="tabpanel" class="tab-pane" id="birdseye-view">
				<div class="birdseye_view"></div>
			</div>
		</div>

	</div>
</div>
<script type="text/javascript">
	var origin_place = '<?php echo mwp_raw_property_address();?>';
	var propertyList =[
		{
			latLng:[<?php echo mwp_latitude();?>, <?php echo mwp_longitude();?>],
			data:'<div style="width: 100%; min-height: 120px;">'+
						'<div style="width: 100%; overflow: hidden;">'+
							'<div class="row">'+
								'<div class="col-md-5 col-sm-12">'+
									'<img src="<?php echo mwp_single_photos_key();?>" style="width:150px;">'+
								'</div>'+
								'<div class="col-md-7 col-sm-12">'+
									'<h3 style="margin:0;padding:0;color:#428bca;">'+
										'<?php echo mwp_raw_property_address();?>'+
									'</h3>'+
									'<h3 style="margin:0;padding:0;color:#d9534f;">'+
										'<?php echo mwp_property_html_price();?> - <?php echo mwp_transaction();?>'+
									'</h3>'+
									'<div>'+
										'<span><?php echo apply_filters('property_area_' . mwp_get_source(), mwp_get_property_area('floor'));?> Floor Area</span></br>'+
										'<span><?php echo mwp_property_beds();?> Bedrooms</span></br>'+
										'<span><?php echo mwp_property_bathrooms();?> Bathrooms</span></br>'+
									'</div>'+
									'<h4>'+
										'<a href="https://www.google.com/maps/place/<?php echo mwp_raw_property_address();?>">Get Driving Directions</a>' + 
									'</h4>'+
								'</div>'+
							'</div>'+
						'</div>'+
			'</div>',
			options:{icon: "http://maps.google.com/mapfiles/marker_green.png"}
		}
	];
</script>

