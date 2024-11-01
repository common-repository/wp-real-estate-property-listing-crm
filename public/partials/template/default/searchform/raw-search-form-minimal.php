<?php
/*
Template Name: Raw Search Form - Minimal
*/
?>
<?php md_search_form_start(); ?>
	<div id="msg" class="label label-info"></div>
	<div class="row">
		<div class="col-xs-12 col-md-2 col-nopad-3">
			<?php md_search_input_location(); ?>
		</div>
		<div class="col-md-2 col-xs-12 col-nopad-3">
			<?php md_search_form_select_min_price(); ?>
		</div>
		<div class="col-md-2 col-xs-12 col-nopad-3">
			<?php md_search_form_select_max_price(); ?>
		</div>
		<div class="col-md-2 col-xs-12 col-nopad-3">
			<?php md_search_form_select_property_type(); ?>
		</div>
		<?php if(mwp_show_bed()){ ?>
			<?php if(!has_filter('list_display_bed')){ ?>
				<div class="col-md-2 col-xs-12 col-nopad-3">
					<?php md_search_form_select_bed();?>
				</div>
			<?php } ?>
		<?php } ?>
		<?php if(mwp_show_bath()){ ?>
			<?php if(!has_filter('list_display_baths')){ ?>
				<div class="col-md-2 col-xs-12 col-nopad-3">
					<?php md_search_form_select_bath(); ?>
				</div>
			<?php } ?>
		<?php } ?>
		<div class="col-md-12 col-xs-12 col-nopad-3">
			<?php md_search_button_sale(); ?>
			<?php md_search_button_rent(); ?>
		</div>
	</div>

	<p></p>
	<?php md_search_form_input_transaction(); ?>
	<?php md_search_form_input_lat(); ?>
	<?php md_search_form_input_lon();?>
	<?php md_search_form_input_communityid(); ?>
	<?php md_search_form_input_cityid(); ?>
	<?php md_search_form_input_countyid(); ?>
	<?php md_search_form_input_subdivisionid(); ?>
	<?php md_search_form_input_stateid(); ?>
	<?php md_search_form_input_locationname(); ?>
<?php md_search_form_end(); ?>
