<ul class="nav navbar-nav navbar-right" style="padding-right:10px;margin-right: 0;">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Hello, <?php echo $user_login;?> <span class="caret"></span></a>
		<ul class="dropdown-menu">
			<?php 
				if ( current_user_can( 'manage_options' ) ) {
					/* A user with admin privileges */
					echo '<li><a href="'.admin_url().'">WordPress Admin Dashboard</a></li>';
				}
			?>
			<li><a href="<?php echo $my_account_url;?>">My Profile</a></li>
			<li><a href="<?php echo $favorite_url;?>">Favorites</a></li>
			<li><a href="<?php echo $xout_url;?>">Xout</a></li>
			<li><a href="<?php echo $save_search_url;?>">Save Search</a></li>
			<li><a href="<?php echo wp_logout_url();?>">Logout</a></li>
		</ul>
	</li>
</ul>
