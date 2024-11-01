<?php //Mwp_Controllers_Theme_Layout ?>
<div id="md-settings-layout" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<form name="md_api" class="md_api" method="post" action="<?php echo $url_slug;?>">
		<input type="hidden" name="_method" value="update_theme_layout">
		<div class="mwp-menu">
			<h3><?php _e('Choose Menu for the header in search properties and property details', mwp_localize_domain());?></h3>
			<?php if($wp_registered_menu){ //if?>
					<select name="mwp_menu">
					<option value="-1">Select</option>	
					<?php foreach($wp_registered_menu as $key=>$val){ //foreach?>
								<option value="<?php echo $key;?>" <?php echo ($db_menu == $key) ? 'selected':'';?>><?php echo $val;?></option>
					<?php } //foreach?>
					</select>
			<?php } //if?>
		</div>
		<div class="mwp-logo-header">
			<h3><?php _e('Choose Logo image for the header in search properties and property details', mwp_localize_domain());?></h3>
			<img class="mwp-logo-preview" src="<?php echo $db_logo;?>" alt="<?php _e('Logo Preview', mwp_localize_domain());?>" style="width:150px;height:150px;display:block;">
			<input id="image-url" type="text" name="mwp_logo" value="<?php echo $db_logo;?>"/>
			<input id="upload-button" type="button" class="button" value="<?php _e('Upload / Choose Logo Image', mwp_localize_domain());?>" />
		</div>
		<div>
			<h3><?php _e('Use plugin default header?', mwp_localize_domain()); ?></h3>
			<select name="mwp_get_headers" class="mwp_get_headers">
				<option value="1" <?php echo ($use_mwp_header == 1) ? 'selected':'';?>>Yes</option>
				<option value="0" <?php echo ($use_mwp_header == 0) ? 'selected':'';?>>No</option>
			</select>
			<div class="header_name_wrap">
				<p><?php _e('Calls for header-name.php', mwp_localize_domain());?></p>
				<input type="textbox" name="header_name" class="header_name" value="<?php echo $use_mwp_header_name;?>">
			</div>
			<h3><?php _e('Use plugin default footer?', mwp_localize_domain()); ?></h3>
			<select name="mwp_get_footers" class="mwp_get_footers">
				<option value="1" <?php echo ($use_mwp_footer == 1) ? 'selected':'';?>>Yes</option>
				<option value="0" <?php echo ($use_mwp_footer == 0) ? 'selected':'';?>>No</option>
			</select>
			<div class="footer_name_wrap">
				<p><?php _e('Calls for footer-name.php', mwp_localize_domain());?></p>
				<input type="textbox" name="footer_name" class="footer_name" value="<?php echo $use_mwp_footer_name;?>">
			</div>
		</div>
		<div class="mwp-choose-search-form">
			<h3><?php _e('Choose search form for the header in search properties and property details', mwp_localize_domain());?></h3>
			<?php if( $search_form ){ ?>
					<select name="mwp_search_form">
						<option value="-1">Select</option>
					<?php foreach($search_form as $key => $val){ ?>
								<option value="<?php echo $key;?>" <?php echo ($db_search_form == $key) ? 'selected':'';?>><?php echo $val;?></option>
					<?php }?>
					</select>
			<?php }?>
		</div>
		<div class="custom-css">
			<h3><?php _e('Custom CSS', mwp_localize_domain());?></h3>
			<textarea name="mwp_custom_css" style="width:100%;height:400px;"><?php echo $get_custom_css;?></textarea>
		</div>
		<div class="form-button-container">
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()); ?>" />
		</div>
	</form>
</div>
<script>
jQuery(document).ready(function($){
	
  var mediaUploader;
  var $header_name_wrap = $('.header_name_wrap');
  var $header_name = $('.mwp_get_headers');
  var $footer_name_wrap = $('.footer_name_wrap');
  var $footer_name = $('.mwp_get_footers');
  var $header_name_server = '<?php echo $use_mwp_header; ?>';
  var $footer_name_server = '<?php echo $use_mwp_footer_name; ?>';
  
  $header_name_wrap.hide();
  $footer_name_wrap.hide();
  
  if( $footer_name.val() == 0 ){
	  $footer_name_wrap.show();
  }
  
  $footer_name.change(function(){
	  if( $(this).val() == 0 ){
		  $footer_name_wrap.show();
	  }else{
		  $footer_name_wrap.hide();
	  }
  });
  
  if( $header_name.val() == 0 ){
	  $header_name_wrap.show();
  }	
  $header_name.change(function(){
	  if( $(this).val() == 0 ){
		  $header_name_wrap.show();
	  }else{
		  $header_name_wrap.hide();
	  }
  });
  
  $('#upload-button').click(function(e) {
    e.preventDefault();
    // If the uploader object has already been created, reopen the dialog
      if (mediaUploader) {
      mediaUploader.open();
      return;
    }
    // Extend the wp.media object
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: 'Choose Logo Image',
      button: {
      text: 'Choose Logo Image'
    }, multiple: false });

    // When a file is selected, grab the URL and set it as the text field's value
    mediaUploader.on('select', function() {
      attachment = mediaUploader.state().get('selection').first().toJSON();
      $('.mwp-logo-preview').attr('src',attachment.url);
      $('#image-url').val(attachment.url);
    });
    // Open the uploader dialog
    mediaUploader.open();
  });

});
</script>
