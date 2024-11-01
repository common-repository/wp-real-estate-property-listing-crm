<div class="container-fluid search-result search-result-list" id="main">
  <div class="row">
  	<div class="col-md-12" id="left">
		<div class="mwp-bootstrap mwp-list-result-items">
			<?php
			$part_search_form = Mwp_Theme_Locator::get_instance()->locate_template(Mwp_Theme_Layout_Entity::get_instance()->get_search_form());
			Mwp_View::get_instance()->display($part_search_form); 
			?>
			<div id="md-listing-results" class="mwp-thumbnail"><!-- md-listing-results -->
				<div class="row mwp-list-properties">
					<div class="page-header text-center">
						<h1>
							<?php _e('No Properties meet the Search Criteria. Please Search Again!', mwp_localize_domain());?>
						</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
