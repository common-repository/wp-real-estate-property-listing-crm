<?php
/*
Template Name: Search Form Shortcode - V4 full text search, toggle more options
*/
?>
<div class="mwp-bootstrap">
	<div class="search-form-ui md-search-form-ui-v4 center-block md-container search-property">
		<h3 class="search-heading"><i class="fa fa-search"></i><?php echo _label('search-title');?></h3>
		<div class="as-form-wrap">
			<?php md_search_form_start(); ?>
				<div id="msg" class="label label-info"></div>
				<div id="more-search-options">
					<div class="row md-container">
						<div class="col-md-2 col-xs-12 no-padding-right-col">
							<label for="transaction">For Sale / Rent</label>
							<?php mwp_crm_dropdown_transaction_type(); ?>
						</div>
						<div class="col-md-2 col-xs-12 no-padding-right-col">
							<label for="property_type">Type</label>
							<?php
								md_search_form_select_property_type(
									array('label'=>'Any')
								);
							?>
						</div>
						<div class="col-md-2 col-xs-12 no-padding-right-col">
							<label for="max_listprice">Min Price</label>
							<?php
								md_search_form_select_min_price(
									array('label'=>'Any')
								);
							?>
						</div>
						<div class="col-md-2 col-xs-12 no-padding-right-col">
							<label for="max_listprice">Max Price</label>
							<?php
								md_search_form_select_max_price(
									array('label'=>'Any')
								);
							?>
						</div>
						<?php if(mwp_show_bed()){ ?>
							<?php if(!has_filter('list_display_bed')){ ?>
								<div class="col-md-2 col-xs-12 no-padding-right-col">
									<label for="bedrooms">Bed</label>
									<?php
										md_search_form_select_bed(
											array('label'=>'Any')
										);
									?>
								</div>
							<?php } ?>
						<?php } ?>
						<?php if(mwp_show_bath()){ ?>
							<?php if(!has_filter('list_display_baths')){ ?>
								<div class="col-md-2 col-xs-12 no-padding-right-col">
									<label for="bathrooms">Bath</label>
									<?php
										md_search_form_select_bath(
											array('label'=>'Any')
										);
									?>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
				<div class="md-divider"></div>
				<div class="row">
					<div class="col-xs-12 col-md-6 no-padding-right-col">
						<?php md_search_input_location(); ?>
					</div>
					<div class="col-xs-12 col-md-6 no-padding-right-col">
						<?php md_search_keyword_input();?>
					</div>
				</div>
				<div class="md-divider"></div>
				<div class="row">
					<div class="col-xs-12 col-md-12 no-padding-right-col">
						<div class="form-group">
							<button type="submit" class="search-form-btn btn btn-primary wp-site-color-theme">
								<?php echo _label('search-form-input-search-v2');?>
							</button>
						</div>
					</div>
				</div>
				<?php md_search_form_input_lat(); ?>
				<?php md_search_form_input_lon();?>
				<?php md_search_form_input_communityid(); ?>
				<?php md_search_form_input_cityid(); ?>
				<?php md_search_form_input_countyid(); ?>
				<?php md_search_form_input_subdivisionid(); ?>
				<?php md_search_form_input_stateid(); ?>
				<?php md_search_form_input_locationname(); ?>
			<?php md_search_form_end(); ?>
			<?php md_js_autocomplete_location_var(); ?>
		</div>
	</div>
</div>
