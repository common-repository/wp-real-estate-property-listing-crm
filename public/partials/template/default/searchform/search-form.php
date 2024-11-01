<?php
/*
Template Name: Search Form Shortcode - Default UI
*/
?>
<div class="mwp-bootstrap">
	<div class="md-search-form-ui md-container" id="md-search-property">
		<h3 class="search-heading">
		<i class="fa fa-search"></i><?php echo _label('search-title');?></h3>
		<div class="as-form-wrap">
			<?php 
				$part_search_form = Mwp_Theme_Locator::get_instance()->locate_template('partials/part-search-form.php');
				Mwp_View::get_instance()->display($part_search_form);
			?>
		</div>
	</div>
</div>
