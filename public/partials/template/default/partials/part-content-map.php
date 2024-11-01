<div id="map-canvas" class="<?php echo Mwp_View::get_instance()->col_map;?> col-sm-12 col-xs-12 mwp-map-container"></div>
<div class="container-fluid" id="main" ng-controller="ctrlPropertyGetData">
  <div class="row">
  	<div class="<?php echo Mwp_View::get_instance()->col_left;?> hidden-sm hidden-xs" id="left">
		<div id="search-result-map-left">
			<div class="page-header">
			<?php if( $location_name != '' ){ ?>
					<h1><?php echo $location_name; ?></h1>
			<?php } ?>
			<h3>{{mwp_total_properties}} <?php _e('Current Properties Shown.', mwp_localize_domain());?></h3>
			<p></p>
			<form class="form-inline">
			  <div class="form-group">
				<label for="Filterby"><?php _e('Filter by:', mwp_localize_domain());?></label>
				<select ng-model="queryBy" id="Filterby">
				  <option value="raw_price"><?php _e('Price', mwp_localize_domain());?></option>
				  <option value="bed"><?php _e('Bed', mwp_localize_domain());?></option>
				  <option value="bath"><?php _e('Bath', mwp_localize_domain());?></option>
				</select>
			  </div>
			  <div class="form-group">
				  <input ng-model="query[queryBy]" placeholder="Select filter by first">
			  </div>
			  <div class="form-group">
			    <label for="sortby"><?php _e('Sort by:', mwp_localize_domain());?></label>
				<select ng-model="orderProp" id="sortby">
				  <option value="raw_price"><?php _e('Price (Lo)', mwp_localize_domain());?></option>
				  <option value="-raw_price"><?php _e('Price (Hi)', mwp_localize_domain());?></option>
				  <option value="-posted_at"><?php _e('Newest', mwp_localize_domain());?></option>
				  <option value="posted_at"><?php _e('Oldest', mwp_localize_domain());?></option>
				</select>
			  </div>
			  <div class="form-group">
			  </div>
			</form>
		</div>
			<p>{{mwpproperties.status}}</p>
			<div class="row">
				<div ng-repeat="mdproperties in mwpproperties | filter:query | orderBy:orderProp" repeat-done="layoutDone(null)"><!-- ngRepeat -->
					<div class="col-sm-12 col-md-<?php echo Mwp_View::get_instance()->col;?> mwp-thumbnail"><!--col-->
						<div class="thumbnail md-listing-grid" ng-mouseover="openInfoWindow($event, mdproperties)"> <!--thumbnail-->
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
								<a href="{{mdproperties.url}}" target="_blank">
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
									<?php if( !has_filter('list_display_area_{{mdproperties.source}}') ){ ?>
										<li>
											{{mdproperties.area}} {{mdproperties.area_unit}}
										</li>
									<?php } ?>
								</ul>
							</div>
							<div class="footer"><!-- footer -->
								<?php if( is_user_logged_in() ){ ?>
									<?php if( Mwp_Actions_Favorite::get_instance()->check_property("{{mdproperties.id}}") ){ ?>
										<a
											class="btn-outline butonactions btn btn-primary favorite property_favorite_remove btn-xs <?php echo $class;?>"
											href="javascript:void(null)"
											data-property-id="{{mdproperties.id}}"
											data-property-feed="{{mdproperties.favorite.feed}}"
											data-toggle="tooltip"
											data-placement="top"
											title="<?php _e('Remove to favorite', mwp_localize_domain());?>"
											role="button"
										>
											<i class="fa fa-heart"></i> {{mdproperties.favorite.label}}
										</a>
									<?php }else{ ?>
										<a
											class="btn-outline butonactions btn btn-default favorite property_favorite btn-xs <?php echo $class;?>"
											href="javascript:void(null)"
											data-property-id="{{mdproperties.id}}"
											data-property-feed="{{mdproperties.favorite.feed}}"
											data-toggle="tooltip"
											data-placement="top"
											title="<?php _e('Add to favorite', mwp_localize_domain());?>"
											role="button"
										>
											<i class="fa fa-heart-o"></i> {{mdproperties.favorite.label}}
										</a>
									<?php } ?>
								<?php }else{ ?>
										<a
											class="btn-outline butonactions btn btn-default register-open btn-xs <?php echo $class;?>"
											href="javascript:void(null)"
											data-post="<?php echo "property-id={{mdproperties.id}}&property-feed={{mdproperties.favorite.feed}}"; ?>"
											data-current-action="{{mdproperties.favorite.action}}"
											data-toggle="tooltip"
											data-placement="top"
											title="<?php _e('Register or login to add as favorites', mwp_localize_domain());?>"
											role="button"
										>
											<i class="fa fa-heart-o"></i> {{mdproperties.favorite.label}}
										</a>
										<?php if( !is_user_logged_in() ) { ?>
											<div class="content-{{mdproperties.favorite.action}} hidden" style="display:hiden !important;">{{mdproperties.favorite.content}}</div>
										<?php } ?>
								<?php } ?>
								<?php if( is_user_logged_in() ){ ?>
									<?php if( Mwp_Actions_XOut::get_instance()->check_property("{{mdproperties.id}}") ){ ?>
										<a
											class="btn-outline butonactions btn btn-primary property_xout_remove xout btn-xs <?php echo $class;?>"
											href="javascript:void(null)"
											data-property-id="{{mdproperties.id}}"
											data-property-feed="{{mdproperties.xout.feed}}"
											data-toggle="tooltip"
											data-placement="top"
											title="Un-Xout property"
											role="button"
										>
											<i class="fa fa-times-circle"></i> {{mdproperties.xout.label}}
										</a>
									<?php }else{ ?>
										<a
											class="btn-outline butonactions btn btn-default property_xout xout btn-xs <?php echo $class;?>"
											href="javascript:void(null)"
											data-property-id="{{mdproperties.id}}"
											data-property-feed="{{mdproperties.xout.feed}}"
											data-toggle="tooltip"
											data-placement="top"
											title="Xout property"
											role="button"
										>
											<i class="fa fa-times-circle-o"></i> {{mdproperties.xout.label}}
										</a>
									<?php } ?>
								<?php }else{ ?>
										<a
											class="btn-outline butonactions btn btn-default register-open btn-xs <?php echo $class;?>"
											href="javascript:void(null)"
											data-post="<?php echo "property-id={{mdproperties.id}}&property-feed={{mdproperties.xout.feed}}"; ?>"
											data-current-action="{{mdproperties.xout.action}}"
											data-toggle="tooltip"
											data-placement="top"
											title="<?php _e('Register or login to Xout property', mwp_localize_domain());?>"
											role="button"
										>
											<i class="fa fa-times-circle"></i> {{mdproperties.xout.label}}
										</a>
										<?php if( !is_user_logged_in() ) { ?>
											<div class="content-{{mdproperties.xout.action}} hidden" style="display:hiden !important;">{{mdproperties.xout.content}}</div>
										<?php } ?>
								<?php } ?>
								<a class="btn-outline butonactions btn btn-default btn-xs <?php echo $class;?> print-pdf-action" href="{{mdproperties.printpdf.url}}" target="_blank" role="button">{{mdproperties.printpdf.label}}</a>
								<!-- Single button -->
								<div class="btn-group md-butonactions ">
								  <a role="button" class="btn-outline btn btn-default btn-xs <?php echo $class;?>" data-toggle="dropdown" aria-expanded="false">
									Share <span class="caret"></span>
								  </a>
								  <ul class="dropdown-menu" role="menu">
									<li><a class="send-to-friend" href="javascript:void(null)" data-property-id="{{mdproperties.id}}" data-property-url="{{mdproperties.url}}" data-property-address="{{mdproperties.title}}"><?php _e('Email to friend', mwp_localize_domain());?></a></li>
									<li><a class="share-popup" href="https://www.facebook.com/sharer/sharer.php?u={{mdproperties.url}}" rel="nofollow" target="_blank">Facebook</a></li>
									<li><a class="share-popup" href="http://twitter.com/intent/tweet?text=Check out this property! <?php echo urldecode("{{mdproperties.title}}").' ';?>{{mdproperties.title}}" rel="nofollow" target="_blank">Twitter</a></li>
									<li><a class="share-popup" href="https://plus.google.com/share?url={{mdproperties.url}}" rel="nofollow" target="_blank">Google+</a></li>
								  </ul>
								</div>
							</div><!-- footer -->
						</div><!--thumbnail-->
					</div><!-- col -->
				</div><!-- ngRepeat -->
			</div><!-- row -->
			 <div id="veil" ng-show="isLoading"></div>
			 <div id="feedLoading" ng-show="isLoading">Loading...</div>
		</div><!-- left -->
    </div>
    <div class="<?php echo Mwp_View::get_instance()->col_map;?> col-sm-12 col-xs-12"><!--map-canvas will be postioned here--></div>
  </div> <!-- row -->
</div><!-- ctrlPropertyGetData -->
