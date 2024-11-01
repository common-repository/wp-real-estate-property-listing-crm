<?php
/*
Template Name: Search Form Shortcode - For HJI account
*/
?>
<div class="mwp-bootstrap">
	<div class="search-form-ui md-search-form-ui-v4 center-block md-container search-property">
		<h3 class="search-heading"><i class="fa fa-search"></i><?php echo _label('search-title');?></h3>
		<div class="as-form-wrap">
			<?php 
				$part_template = Mwp_Theme_Locator::get_instance()->locate_template('searchform/raw-search-form-hji.php');
				Mwp_View::get_instance()->display($part_template, array()); 
			?>
		</div>
	</div>
</div>
