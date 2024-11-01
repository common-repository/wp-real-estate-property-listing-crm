<div class="row md-container md-photo-cat">
	<div class="col-md-12">
		<!-- Nav tabs -->
		<?php if(mwp_crm_get_property_cat_photos()){ ?>
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a></li>
				<?php foreach(mwp_crm_get_property_cat_photos() as $key => $val){ ?>
						<li role="presentation"><a href="#<?php echo str_replace(' ','-',$key);?>" aria-controls="<?php echo str_replace(' ','-',$key);?>" role="tab" data-toggle="tab"><?php echo $key;?></a></li>
				<?php }//foreach ?>
			</ul>
		<?php }//if ?>
		<div class="tab-content md-container">
			<div role="tabpanel" class="tab-pane active" id="all">
				<ul class="list-inline photos-single-container">
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
			</div><!-- all -->
			<?php if(mwp_crm_get_property_cat_photos()){ ?>
					<?php foreach(mwp_crm_get_property_cat_photos() as $key => $val){ ?>
							<div role="tabpanel" class="tab-pane" id="<?php echo str_replace(' ','-',$key);?>">
								<?php if($val && is_array($val) && count($val) >= 1){//if ?>
									<ul class="list-inline photos-single-container">
										<?php foreach($val as $val_k => $val_img){//foreach ?>
												<li class="col-xs-6 col-md-4 photos-item-single">
													<a href="<?php echo $val_img->url;?>" title="<?php mwp_property_address();?>" class="thumbnail" rel="gallery-photos">
														<img class="img-responsive mwp-single-img" src="<?php echo $val_img->url;?>">
													</a>
												</li>
										<?php }//foreach ?>
									</ul>
								<?php }//if ?>
							</div>
					<?php }//foreach ?>
			<?php }//if ?>
		</div>
	</div>
</div>
