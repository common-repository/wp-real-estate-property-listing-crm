<div id="map-canvas" class="<?php echo Mwp_View::get_instance()->col_map;?> col-sm-12 col-xs-12"></div>
<div class="container-fluid" id="main" ng-controller="ctrlPropertyGetData">
  <div class="row">
  	<div class="<?php echo Mwp_View::get_instance()->col_left;?> hidden-sm hidden-xs" id="left">
		<div class="page-header">
			Filter by:
			<select ng-model="queryBy">
			  <option value="raw_price">Price</option>
			  <option value="bed">Bed</option>
			  <option value="bath">Bath</option>
			</select>
			<p></p>
			<input ng-model="query[queryBy]" placeholder="Select filter by first">
			<p></p>
			Sort by:
			<select ng-model="orderProp">
			  <option value="raw_price">Price (Lo-Hi)</option>
			  <option value="-raw_price">Price (Hi-Lo)</option>
			  <option value="-posted_at">Newest</option>
			  <option value="posted_at">Oldest</option>
			</select>
		</div>
		<div id="search-result-map-left">
			<p>{{mwpproperties.status}}</p>
			<div class="row">
				<div ng-repeat="mdproperties in mwpproperties | filter:query | orderBy:orderProp" repeat-done="layoutDone()" ng-cloak><!-- ngRepeat -->
					<div class="col-sm-12 col-md-<?php echo Mwp_View::get_instance()->col;?>"><!--col-->
						<div class="thumbnail md-listing-grid <?php echo 'source-'.mwp_get_source();?>"> <!--thumbnail-->
							<div class="md-label">
								<header>
									<span>{{mdproperties.transaction}}</span>
								</header>
							</div>
							<div class="md-listing-img">
								<img href="{{mdproperties.url}}" src="{{mdproperties.primary_photo}}" alt="" class="img-responsive">
							</div>
							<div class="caption">
								<p class="mwp-price">{{mdproperties.price}}</p>
								<a href="<?php echo mwp_property_detail_link();?>"><?php echo mwp_property_title();?></a>
								<a href="{{mdproperties.url}}" ng-mouseover="openInfoWindow($event, mdproperties)">
									{{mdproperties.title}}
								</a>
								<ul class="list-unstyled list-inline">
									<?php if(mwp_show_bed()){ ?>
										<li class="border-mute">
											{{mdproperties.bed}} <?php echo _label('beds');?> 
										</li>
									<?php } ?>
									<?php if(mwp_show_bath()){ ?>
										<li>
											{{mdproperties.bath}} <?php echo _label('baths');?> 
										</li>
									<?php } ?>
									<?php if(!has_filter('list_display_area_'.mwp_get_source())){ ?>
										<li>
											{{mdproperties.area}} {{mdproperties.area_unit}}
										</li>
									<?php } ?>
								</ul>
							</div>
							<div class="footer">
								<div ng-include ="'/wp-content/plugins/<?php echo mwp_folder_name();?>/public/partials/template/default/angularjs/action-button.php'"></div>
							</div>
						</div><!--thumbnail-->
					</div><!-- col -->
				</div><!-- ngRepeat -->
			</div><!-- row -->
		</div>
		<?php //Mwp_View::get_instance()->display($container_template, Mwp_View::get_instance()->data);?> 
    </div>
    <div class="<?php echo Mwp_View::get_instance()->col_map;?> col-sm-12 col-xs-12"><!--map-canvas will be postioned here--></div>
    <div class="hidden-lg col-xs-12 marker-mobile" style="background-image:url('{{property_img}}');background-size: 100% 100%;"><h3>{{property_price}}</h3></div>
  </div> <!-- row -->
  <div id="veil" ng-show="isLoading"></div>
  <div id="feedLoading" ng-show="isLoading">Loading...</div>
</div><!-- ctrlPropertyGetData -->
