<div class="wrap about-wrap">
	<h1>
		<?php _e('Welcome to ', mwp_localize_domain()); ?>
		<?php echo esc_html( get_admin_page_title() ); ?>
		<?php echo mwp_plugin_version();?>
	</h1>

	<div class="about-text">
		<h3>
			<?php _e('An All-in-One Real Estate Plugin Solution for Brokerages and Agents Integrated with a High Powered Real Estate CRM Solution.', mwp_localize_domain());?>
		</h3>
	</div>
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<?php Mwp_View::get_instance()->admin_partials($tab, $data); ?>
	<div class="about-text">
		<a href="https://wordpress.org/support/view/plugin-reviews/wp-real-estate-property-listing-crm" target="_blank">
			<img src="<?php echo mwp_asset_url() . 'rate-us.jpg';?>" alt="rate us"/>
		</a>
	</div>
</div>
