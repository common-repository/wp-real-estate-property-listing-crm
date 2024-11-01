<h2 class="nav-tab-wrapper">
	<a href="<?php echo Mwp_Admin_Theme_Property_WPEntity::get_instance()->get_admin_url_slug() . '&tab=property';?>" class="nav-tab <?php echo ($current_tab == '' || $current_tab == 'property') ? 'nav-tab-active':'';?>">Property</a>
	<a href="<?php echo Mwp_Admin_Theme_Style_WPEntity::get_instance()->get_admin_url_slug() . '&tab=color-style';?>" class="nav-tab <?php echo ($current_tab == 'color-style') ? 'nav-tab-active':'';?>">Color Style</a>
	<a href="<?php echo Mwp_Admin_Theme_Layout_WPEntity::get_instance()->get_admin_url_slug() . '&tab=layout';?>" class="nav-tab <?php echo ($current_tab == 'layout') ? 'nav-tab-active':'';?>">Layout</a>
	<a href="<?php echo Mwp_Admin_Theme_Map_WPEntity::get_instance()->get_admin_url_slug() . '&tab=map';?>" class="nav-tab <?php echo ($current_tab == 'map') ? 'nav-tab-active':'';?>">Map</a>
	<a href="<?php echo Mwp_Admin_Theme_Text_WPEntity::get_instance()->get_admin_url_slug() . '&tab=text';?>" class="nav-tab <?php echo ($current_tab == 'text') ? 'nav-tab-active':'';?>">Text</a>
</h2>
