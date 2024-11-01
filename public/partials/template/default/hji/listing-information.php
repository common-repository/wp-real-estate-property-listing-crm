<div class="row md-propdtr">
	<div class="col-md-6 md-propdtr-details">
		<ul class="list-unstyled left-details">
			<li class="tab-light"><strong><?php _e('Property ID', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->get_mlsid();?></li>
			<li class="tab-dark"><strong><?php _e('Status', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->property_status();?></li>
			<li class="tab-light"><strong><?php _e('Location', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->get_address();?></li>
			<li class="tab-dark"><strong><?php _e('Bedroom', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->bed();?></li>
			<li class="tab-light"><strong><?php _e('Living Sq. Ft', mwp_localize_domain());?>: </strong><?php echo mwp_get_data_loop()->get_sqft_heated();?></li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-unstyled right-details">
			<li class="tab-light"><strong><?php _e('Lot Area', mwp_localize_domain());?>: </strong>
				<?php echo apply_filters('property_area_' . mwp_get_source(), mwp_get_property_area('lot'));?>
			</li>
			<li class="tab-dark"><strong><?php _e('Price', mwp_localize_domain());?> : </strong><?php echo mwp_html_property_price(false);?></li>
			<li class="tab-light"><strong><?php _e('Bathroom', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->bath();?></li>
			<li class="tab-dark"><strong><?php _e('Year Built', mwp_localize_domain());?> : </strong><?php echo mwp_get_data_loop()->year_built();?></li>
		</ul>
	</div>
</div>
<div class="row md-propdtr">
	<div class="col-md-12 md-propdtr-details">
		<div class="single-property-desc md-container">
			<h2><span><?php _e('Details on', mwp_localize_domain());?> </strong><?php echo mwp_get_data_loop()->get_address('short');?></span></h2>
			<p></strong><?php echo mwp_get_data_loop()->get_description();?></p>
		</div>
	</div>
</div>
<div id="md-details" class="row">
<?php if( mwp_get_data_loop()->features() ){ ?>
	<?php foreach(mwp_get_data_loop()->features() as $k => $v ){ ?>
			<div class="md-details-list col-md-12">
				<h3><span><?php echo $k;?></span></h3>
				<?php if( is_array($v) && count($v) > 0 ){ ?>
					<?php $c = 0; ?>
					<ul class="list-unstyled left-details">
						<?php foreach($v as $k_info=>$info){ ?>
							<li class="tab-<?=($c++%2==1) ? 'light' : 'dark' ?>">
								<?php echo $info;?>
							</li>
						<?php } ?>
					</ul>	
				<?php } ?>
			</div>
	<?php } ?>
<?php } ?>
</div>
<?php if( mwp_get_data_loop()->tour_url() ){ ?>
<h3><?php _e('Tour Guide Video',mwp_localize_domain());?></h3>
<div align="center" class="embed-responsive embed-responsive-16by9">
    <video controls loop class="embed-responsive-item">
        <source src="<?php echo mwp_get_data_loop()->tour_url();?>" type="video/mp4">
    </video>
</div>
<?php } ?>
