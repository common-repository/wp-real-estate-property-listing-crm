<div class="wrap">
	<h1><?php _e('Welcome to', mwp_localize_domain());?> Masterdigm <?php echo mwp_plugin_version();?></h1>
	<div class="about-wrap">
		<div>
			<?php if($get_error){ ?>
				<div class="error">
					<ul>
						<?php foreach($get_error as $val) { ?>
								<li><p class="error"><?php echo $val;?></p></li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
		</div>
		<div class="feature-section two-col">
			<div class="col">
				<?php ($validate_form) ? require_once $validate_form:''; ?>
				<?php $subscribe_crm->controller('display_form'); ?>
			</div>
			<div class="col">
				<?php $input_keys->controller('display_form'); ?>
			</div>
		</div><!-- feature-section -->
	</div><!-- about wrap -->
</div>

