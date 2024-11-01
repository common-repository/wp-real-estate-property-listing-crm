<?php if( isset($agent->set_agent_data) && !is_null($agent->set_agent_data) ){ ?>
	<div class="md-propdtr-prof">
		<div class="profpic">
			<img src="<?php echo $agent->get_photo();?>" class="img-responsive" style="" />
		</div>
		<div class="details">
			<div class="profname"><?php echo $agent->get_name();?></div>
			<div class="proftag">Real Estate Agent</div>
			<div class="profmail">
				<a class="agent-email-to" href="mailto:<?php echo $agent->get_email();?>" target="_blank" title="Click to Email">
					<?php _e('Click to Email', mwp_localize_domain());?>
				</a>
			</div>
			<div class="profphone"><?php _e('Work Phone', mwp_localize_domain());?>: <a href="tel:<?php echo $agent->get_phone();?>"><?php echo $agent->get_phone();?></a></div>
			<div class="profmob"><?php _e('Mobile Phone', mwp_localize_domain());?>: <a href="tel:<?php echo $agent->get_mobile_num();?>"><?php echo $agent->get_mobile_num();?></a></div>
		</div>
	</div>
<?php } ?>
