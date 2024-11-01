<?php if( $child && $show_child ){ ?>
		<ul>
			<?php foreach($child as $k => $v){ ?>
					<li>
						<a href="<?php echo $v['url'];?>">
							<?php echo $v['label'];?>
						</a>
					</li>
			<?php } ?>
		</ul>
<?php } ?>
<?php if( $properties->loop_property() ): ?>
	<div class="mwp-bootstrap">
		<div id="md-listing-results">
			<div class="row">
			<?php while($properties->loop_property()): $properties->md_set_property();mwp_set_loop($properties); ?>
					<div class="col-md-<?php echo mwp_bootstrap_grid_col_md($col);?> col-sm-6 col-xs-12">
						<?php 
							Mwp_View::get_instance()->display($part_loop_template, $data); 
						?>
					</div>
			<?php endwhile; ?>
			</div>
		</div>
		<div class="md-pagination">
			<?php if($show_pagination){ ?>
				<?php mwp_pagination('', 2); ?>
			<?php } ?>
		</div>
	</div>
	<?php Mwp_Actions_EmailTo::get_instance()->display();?>
<?php endif; ?>

