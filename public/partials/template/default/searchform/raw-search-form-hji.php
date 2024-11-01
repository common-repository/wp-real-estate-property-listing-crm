<?php
/*
Template Name: Raw Search Form HJI
*/
?>
<?php md_search_form_start(); ?>
	<div id="msg" class="label label-info"></div>
	<div class="row">
		<div class="col-xs-12 col-md-6 no-padding-right-col">
			<?php md_search_input_location(); ?>
		</div>
		<div class="col-xs-12 col-md-6 no-padding-right-col">
			<div class="form-group">
				<button type="submit" class="search-form-btn btn btn-primary wp-site-color-theme">
					<?php echo _label('search-form-input-search-v2');?>
				</button>
			</div>
			<div class="form-group">
				<button class="btn btn-primary btn-more-search-option" aria-label="Left Align" type="button" data-toggle="collapse" data-target="#more-search-options" aria-expanded="false" aria-controls="more-search-options">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					<?php echo _label('search-form-input-more-search-v2'); ?>
				</button>
				<?php 
				if( mwp_is_search_result_page() ){
					Mwp_View::get_instance()->display(Mwp_View::get_instance()->switch_view, Mwp_View::get_instance()->data_switch_view); 
				}
				?>
			</div>
		</div>
	</div>
	<div class="md-divider"></div>
	<div class="collapse" id="more-search-options">
		<div class="row md-container">
			<div class="col-md-2 col-xs-12 no-padding-right-col">
				<select id="list_type" name="list_type" class="form-control col-md-10"></select>
			</div>
			<div class="col-md-2 col-xs-12 no-padding-right-col">
				<select id="property_type" name="property_type" class="form-control col-md-10"></select>
			</div>
			<div class="col-md-2 col-xs-12 no-padding-right-col">
				<?php md_search_form_select_min_price(); ?>
			</div>
			<div class="col-md-2 col-xs-12 no-padding-right-col">
				<?php md_search_form_select_max_price(); ?>
			</div>
			<?php if(mwp_show_bed()){ ?>
				<?php if(!has_filter('list_display_bed')){ ?>
					<div class="col-md-2 col-xs-12 no-padding-right-col">
						<?php md_search_form_select_bed();?>
					</div>
				<?php } ?>
			<?php } ?>
			<?php if(mwp_show_bath()){ ?>
				<?php if(!has_filter('list_display_baths')){ ?>
					<div class="col-md-2 col-xs-12 no-padding-right-col">
						<?php md_search_form_select_bath(); ?>
					</div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
	<?php md_search_form_input_lat(); ?>
	<?php md_search_form_input_lon();?>
	<?php md_search_form_input_communityid(); ?>
	<?php md_search_form_input_cityid(); ?>
	<?php md_search_form_input_countyid(); ?>
	<?php md_search_form_input_subdivisionid(); ?>
	<?php md_search_form_input_locationname(); ?>
	<?php md_search_result_view(); ?>
<?php md_search_form_end(); ?>
