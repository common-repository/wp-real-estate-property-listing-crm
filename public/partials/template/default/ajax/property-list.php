<?php if( $loop_data->loop_property() ): ?>
		<div class="mwp-list-result-items paged-<?php echo $paged;?>" data-paged="<?php echo $paged;?>"><!-- mwp-list-result-items" -->
			<div class="mwp-list-properties">
			<?php while($loop_data->loop_property()): $loop_data->md_set_property();mwp_set_loop($loop_data); ?>
					<div class="col-md-<?php echo mwp_bootstrap_grid_col_md($col);?> col-sm-6 col-xs-12 infinite_scroll">
						<?php 
							Mwp_View::get_instance()->display($part_loop_template, $data); 
						?>
					</div>
			<?php endwhile; ?>
			</div>
			<div class="ajax-md-pagination"><!-- md-pagination -->
				<input type="hidden" class="mwp-total-data" value="<?php echo $loop_data->property_data_total;?>">
				<?php if($show_pagination){ ?>
					<?php mwp_infinite_pagination('', 2, $loop_data->property_data_total, true, $paged); ?>
				<?php } ?>
			</div><!-- md-pagination -->
		</div><!-- mwp-list-result-items" -->
<?php endif; ?>

