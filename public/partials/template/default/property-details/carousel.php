<?php if( count($photos) > 0 && is_array($photos) ){ ?>
	<style>
	#galleria{height:550px;}
	.galleria-stage{height:85% !important;}
	</style>
	<div class="single-property-photos single-property-slider">
		<div class="galleria crm-galleria" id="galleria">
		</div>
	</div>
	<script>
	jQuery(document).ready(function() {
		<?php if( count($photos) > 0 && is_array($photos) ){ ?>
			var galleria_img_data = [
				<?php foreach( $photos as $photo ){ ?>
					{
						thumb: '<?php echo $photo;?>',
						image: '<?php echo $photo;?>',
					},
				<?php } ?>
			];
		<?php } ?>
		// Load the classic theme
		Galleria.loadTheme('<?php echo mwp_public_url() . 'plugin/galleria/themes/classic/galleria.classic.min.js';?>');
		// Initialize Galleria
		Galleria.configure({
			lightbox: true,
			responsive:true,
			imageCrop: true,
			preload:2,
			dummy: '<?php echo mwp_asset_url() . 'house.png';?>'
		});
		
		function run_galleria(img_data){
			Galleria.run('#galleria',{
				dataSource: galleria_img_data
			});
		}
		run_galleria(galleria_img_data);
		jQuery(document).on('shown.bs.tab','a[data-toggle="tab"]', function (e) {
			var currentTab = jQuery(e.target).text(); // get current tab
			var LastTab = jQuery(e.relatedTarget).text(); // get last tab
			var currentHref = jQuery(e.target).attr('href'); // get last tab
			if( currentHref == '#property-details' ){
				run_galleria(galleria_img_data);
			}
		});
	});
	</script>
<?php } ?>
