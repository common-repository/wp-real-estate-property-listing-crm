<h2 class="nav-tab-wrapper">
	<a href="<?php echo Mwp_Admin_Search_WPEntity::get_instance()->get_admin_url_slug() . '&tab=general';?>" class="nav-tab <?php echo ($current_tab == '' || $current_tab == 'general') ? 'nav-tab-active':'';?>">General</a>
	<a href="<?php echo Mwp_Admin_Search_Pricerange_WPEntity::get_instance()->get_admin_url_slug() . '&tab=pricerange';?>" class="nav-tab <?php echo ($current_tab == 'pricerange') ? 'nav-tab-active':'';?>">Price Range</a>
</h2>
