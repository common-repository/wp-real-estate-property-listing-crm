<?php
/*
Template Name: Featured - Box Style
*/
?>
<?php if( $loop_data->loop_property() ): ?>
	<?php $index_items = 1; ?>
	<div class="mwp-bootstrap">
		<div id="md-listing-results">
			<div class="row">
				<?php while($loop_data->loop_property()): $loop_data->md_set_property();mwp_set_loop($loop_data); ?>
						<?php if(mwp_set_page_list($limit,$index_items) ){ ?>
							<div class="col-md-<?php echo $col;?> col-sm-6 col-xs-12">
								<?php 
									Mwp_View::get_instance()->display($part_loop_template, $data); 
								?>
							</div>
						<?php } ?>
						<?php $index_items++; ?>
				<?php endwhile; ?>
			</div>
		</div>
		<div class="md-pagination">
			<?php //mwp_pagination('', 2); ?>
		</div>
	</div>
<?php endif; ?>
