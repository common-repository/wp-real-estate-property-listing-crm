<?php
/*
Template Name: List - Default Box Style
*/
?>
<?php if( $loop_data->loop_property() ): ?>
	<div class="mwp-bootstrap mwp-list-result-items">
		<div id="md-listing-results" class="<?php echo $class;?>"><!-- md-listing-results test -->
			<div class="row mwp-list-properties">
			<?php if( $location_name != '' ){ ?>
				<div class="page-header text-center">
					<h1>
						<?php echo $location_name; ?>
						<small><?php echo $total_data;?> <?php _e('Total Properties', mwp_localize_domain());?></small>
					</h1>
				</div>
			<?php } ?>
			<?php while($loop_data->loop_property()): $loop_data->md_set_property();mwp_set_loop($loop_data); ?>
					<div class="col-md-<?php echo mwp_bootstrap_grid_col_md($col);?> <?php echo 'source-'.mwp_get_source();?> md-listing-contain md-listing-image col-sm-6 col-xs-12 lazy-list" 
					data-original="<?php echo mwp_primary_photo(); ?>"
					style="background-image:url(<?php echo mwp_primary_photo(); ?>);">
						<?php 
							Mwp_View::get_instance()->display($part_loop_template, $data); 
						?>
					</div>
			<?php endwhile; ?>
			</div>
			<div class="md-pagination"><!-- md-pagination -->
				<?php if($show_pagination){ ?>
					<?php mwp_pagination('', 2); ?>
				<?php } ?>
			</div><!-- md-pagination -->
		</div><!-- md-listing-results -->
	</div>
	<?php //Mwp_Actions_EmailTo::get_instance()->display();?>
<?php endif; ?>

