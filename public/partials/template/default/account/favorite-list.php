<?php //mwp_dump($favorite_properties['flexmls'], 1);?>
<?php foreach($properties_key as $key => $val_source){ ?>
	<?php if( isset($favorite_properties[$val_source]) && $favorite_properties[$val_source]->loop_property() ): ?>
		<div class="mwp-bootstrap">
			<div id="md-listing-results">
				<div class="row">
				<?php while($favorite_properties[$val_source]->loop_property()): $favorite_properties[$val_source]->md_set_property();mwp_set_loop($favorite_properties[$val_source]); ?>
						<div class="col-md-<?php echo mwp_bootstrap_grid_col_md($col);?> <?php echo 'source-'.mwp_get_source();?> md-listing-contain md-listing-image col-sm-6 col-xs-12" style="background-image:url(<?php echo mwp_primary_photo(); ?>);">
							<?php 
								Mwp_View::get_instance()->display($part_loop_template, $data); 
							?>
						</div>
				<?php endwhile; ?>
				</div>
			</div>
		</div>
		<hr>
	<?php endif; ?>
<?php } ?>
