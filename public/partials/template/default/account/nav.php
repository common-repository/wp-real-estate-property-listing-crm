<ul class="nav nav-pills nav-stacked">
	<li role="presentation" class="<?php echo ($action == 'profile') ? 'active':'';?>">
		<a href="<?php echo Mwp_MyAccount_Profile::get_instance()->url();?>"><?php _e('Profile', mwp_localize_domain());?></a>
	</li>
	<li role="presentation" class="<?php echo ($action == 'favorites') ? 'active':'';?>">
		<a href="<?php echo Mwp_MyAccount_Favorite::get_instance()->url();?>"><?php _e('Favorites', mwp_localize_domain());?></a>
	</li>
	<li role="presentation" class="<?php echo ($action == 'xout') ? 'active':'';?>">
		<a href="<?php echo Mwp_MyAccount_Xout::get_instance()->url();?>">X-Out</a>
	</li>
	<li role="presentation" class="<?php echo ($action == 'savesearch') ? 'active':'';?>">
		<a href="<?php echo \Mwp_MyAccount_SaveSearch::get_instance()->url();?>"><?php _e('Save Search', mwp_localize_domain());?></a>
	</li>
</ul>
