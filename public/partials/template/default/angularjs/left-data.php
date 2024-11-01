<div class="col-sm-12 col-md-4">
	<div class="thumbnail" ng-mouseover="openInfoWindow($event, mdproperties)">
		<img href="{{mdproperties.url}}" src="{{mdproperties.primary_photo}}" alt="" class="img-responsive">
		<div class="caption">
			<a href="{{mdproperties.url}}" ng-mouseover="openInfoWindow($event, mdproperties)">
				{{mdproperties.price}} - {{mdproperties.title}}
			</a>
			<p>{{mdproperties.count_photos}} Photos</p>
			<ul class="list-unstyled">
				<?php if(mwp_show_bed()){ ?>
				<li class="border-mute">
					<span class=""><?php echo _label('beds');?></span>
					<span class="">{{mdproperties.bed}}</span>
				</li>
				<?php } ?>
				<?php if(mwp_show_bath()){ ?>
				<li class="border-mute">
					<span class=""><?php echo _label('baths');?></span>
					<span class="">{{mdproperties.bath}}</span>
				</li>
				<?php } ?>
				<li class="border-mute">
					<span class="">{{mdproperties.area}}</span>
					<span class="">{{mdproperties.area_unit}}</span>
				</li>
			</ul>
		</div>
		<div>
			
		</div>
	</div><!-- thumbnail -->
</div><!-- col -->
