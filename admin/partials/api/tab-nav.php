<h2 class="nav-tab-wrapper">
	<a href="<?php echo Mwp_Admin_API_Social_WPEntity::get_instance()->get_admin_url_slug() . '&tab=social-api';?>" class="nav-tab <?php echo ($current_tab == '' || $current_tab == 'social-api') ? 'nav-tab-active':'';?>">Social API</a>
	<a href="<?php echo Mwp_Admin_API_Flexmls_WPEntity::get_instance()->get_admin_url_slug() . '&tab=flexmls';?>" class="nav-tab <?php echo ($current_tab == 'flexmls') ? 'nav-tab-active':'';?>">Flex MLS</a>
	<a href="<?php echo Mwp_Admin_API_Greatschool_WPEntity::get_instance()->get_admin_url_slug() . '&tab=great-school';?>" class="nav-tab <?php echo ($current_tab == 'great-school') ? 'nav-tab-active':'';?>">Great School</a>
	<a href="<?php echo Mwp_Admin_API_Google_WPEntity::get_instance()->get_admin_url_slug() . '&tab=google';?>" class="nav-tab <?php echo ($current_tab == 'google') ? 'nav-tab-active':'';?>">Google</a>
</h2>
