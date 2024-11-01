<h2 class="nav-tab-wrapper">
	<a href="<?php echo Mwp_Admin_Settings_Popup_WPEntity::get_instance()->get_admin_url_slug() . '&tab=popup';?>" class="nav-tab <?php echo ($current_tab == '' || $current_tab == 'popup') ? 'nav-tab-active':'';?>">Pop-Up</a>
	<a href="<?php echo Mwp_Admin_Settings_Mail_WPEntity::get_instance()->get_admin_url_slug() . '&tab=mail';?>" class="nav-tab <?php echo ($current_tab == 'mail') ? 'nav-tab-active':'';?>">Mail</a>
	<a href="<?php echo Mwp_Admin_Settings_Jspluginlib_WPEntity::get_instance()->get_admin_url_slug() . '&tab=jsplugin-library';?>" class="nav-tab <?php echo ($current_tab == 'jsplugin-library') ? 'nav-tab-active':'';?>">JS Plugin / Library</a>
	<a href="<?php echo Mwp_Admin_Settings_Clientlead_WPEntity::get_instance()->get_admin_url_slug() . '&tab=client-lead';?>" class="nav-tab <?php echo ($current_tab == 'client-lead') ? 'nav-tab-active':'';?>">Client Lead</a>
</h2>
