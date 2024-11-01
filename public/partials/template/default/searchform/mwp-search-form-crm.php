<?php
/*
Template Name: MWP Search Form - for CRM with keyword
*/
?>
<?php md_search_form_start(); ?>
	<div id="msg" class="label label-info"></div>
	<div class="row">
		<div class="col-xs-12 col-md-4 no-padding-right-col">
			<?php md_search_input_location(); ?>
		</div>
		<div class="col-xs-12 col-md-8 no-padding-right-col">
			<div class="form-group">
				<?php mwp_crm_dropdown_transaction_type(); ?>
			</div>
			<div class="form-group">
				<button type="submit" class="search-form-btn btn mwp-theme-bk-color">
					<?php echo _label('search-form-input-search-v2');?>
				</button>
			</div>
			<div class="form-group">
				<button class="btn btn-more-search-option" aria-label="Left Align" type="button" data-toggle="collapse" data-target="#more-search-options" aria-expanded="false" aria-controls="more-search-options">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
					<?php echo _label('search-form-input-more-search-v2'); ?>
				</button>
				<?php Mwp_View::get_instance()->display(Mwp_View::get_instance()->switch_view, Mwp_View::get_instance()->data_switch_view); ?>
			</div>
		</div>
	</div>
	<div class="md-divider"></div>
	<div class="collapse" id="more-search-options">
		<div class="row md-container">
			<div class="col-xs-12 col-md-6 no-padding-right-col">
				<?php md_search_keyword_input();?>
			</div>
			<div class="col-md-2 col-xs-12 no-padding-right-col">
				<?php md_search_form_select_property_type(); ?>
			</div>
			<div class="col-md-2 col-xs-12 no-padding-right-col">
				<?php md_search_form_select_min_price(); ?>
			</div>
			<div class="col-md-2 col-xs-12 no-padding-right-col">
				<?php md_search_form_select_max_price(); ?>
			</div>
		</div>
		<div class="md-divider"></div>
		<div class="row md-container">
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
			<?php if( mwp_get_current_api_source() == 'crm' ){ ?>
			<div class="col-md-2 col-xs-12 no-padding-right-col hidden">
				<?php md_search_form_select_floor_area();?>
			</div>
			<div class="col-md-2 col-xs-12 no-padding-right-col hidden">
				<?php md_search_form_select_lot_area();?>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="md-divider"></div>
	<?php //md_search_form_input_transaction(); ?>
	<?php md_search_form_input_lat(); ?>
	<?php md_search_form_input_lon();?>
	<?php md_search_form_input_communityid(); ?>
	<?php md_search_form_input_cityid(); ?>
	<?php md_search_form_input_countyid(); ?>
	<?php md_search_form_input_subdivisionid(); ?>
	<?php md_search_form_input_stateid(); ?>
	<?php md_search_form_input_locationname(); ?>
	<?php md_search_result_view(); ?>
<?php md_search_form_end(); ?>
<?php md_js_autocomplete_location_var(); ?>
