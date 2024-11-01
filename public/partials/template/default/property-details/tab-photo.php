<ul class="list-inline" id="photos-single-container">
	<?php if( mwp_single_photos() > 0 ){ ?>
		<?php foreach(mwp_single_photos() as $key => $val ){ ?>
			<li class="col-xs-6 col-md-4 photos-item-single">
				<a href="<?php echo $val;?>" title="<?php mwp_property_address();?>" class="thumbnail" rel="gallery-photos">
					<img class="img-responsive mwp-single-img" src="<?php echo $val;?>">
				</a>
			</li>
		<?php } ?>
	<?php } ?>
</ul>
