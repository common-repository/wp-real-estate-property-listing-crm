    <!-- Latest compiled and minified JavaScript -->
    <script type='text/javascript'>
		var MDAjax = <?php echo json_encode(mwp_localize_script()); ?>;
		var total_properties = <?php echo $total_data; ?>;
		var search_uri_query = <?php echo json_encode($search_uri_query); ?>;
	</script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.js"></script>
	<script src="https://npmcdn.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>
	<script src="http://cdn.jsdelivr.net/jquery.lazyload/1.8.4/jquery.lazyload.js"></script>
	<script src="<?php echo mwp_public_url() . 'js/underscore-min.js';?>"></script>
	<script src="<?php echo mwp_public_url() . 'js/mwp-public-search.js';?>"></script>
	<script src="<?php echo mwp_public_url() . 'js/mwp-public.js';?>"></script>
	<script src="<?php echo mwp_public_url() . 'plugin/galleria/galleria-1.4.2.min.js';?>"></script>
	<script src="<?php echo mwp_public_url() . 'js/jquery.magnific-popup.min.js';?>"></script>
	<script src="<?php echo mwp_public_url() . 'js/buttonaction-min.js';?>"></script>
	<script src="<?php echo mwp_public_url() . 'js/signup-min.js';?>"></script>
	<script src="<?php echo mwp_public_url() . 'js/save-search-min.js';?>"></script>
	<script src="<?php echo mwp_public_url() . 'js/property-alert-min.js';?>"></script>
	<?php if( mwp_get_current_api_source() == 'hji' ){ ?>
	<script src="<?php echo mwp_public_url() . 'js/mwp-hji-search-form.js';?>"></script>
	<?php } ?>

	<?php Mwp_Actions_SignupForm::get_instance()->display(); ?>
	<?php Mwp_Actions_EmailTo::get_instance()->display(); ?>
	<?php if( mwp_google_map_api() ){ ?>
		<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo mwp_google_map_api();?>"></script>
	<?php }else{ ?>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.23"></script>
	<?php } ?>
	<?php Mwp_View::get_instance()->display($part_footer, Mwp_View::get_instance()->data); ?>
	<script src="<?php echo mwp_public_url() . 'js/emailto.js';?>"></script>
  </body>
</html>


