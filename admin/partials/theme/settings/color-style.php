<?php //Mwp_Controllers_Theme_Style ?>
<style>
#md-settings-theme form input[type=text]{
	width:50%;
}
.current-default-color{
	width:50%;
	height:130px;
}
#md-settings-theme .ui-tabs .ui-tabs-panel{
	display:inline-block;
}
.sample-color{
	height:50px;
	border:2px solid #ddd;
}
.mwp-notice{
	font-size:16px;
	font-style:italic;
	font-weight:bold;
	clear:both;
	padding-top:20px;
}
.color-scheme-container{
	margin:30px 0;
}
.color-scheme-container span{
	margin:10px;
}
.mwp-description{
	font-size: 11px;
    color: #7d8388;
}
</style>
<div id="md-settings-theme" class="wrap about-wrap">
	<?php Mwp_Admin_TabNav::get_instance()->tab_nav($tab_nav_template, $tab_nav); ?>
	<form name="md_api" class="md_api" method="post" action="<?php echo $url_slug;?>">
		<input type="hidden" name="_method" value="update_theme_colorstyle">
		<h3><?php _e('Choose theme for: ', mwp_localize_domain());?></h3>
		<div class="predefined-color-scheme">
			<h4><?php _e('Select a predefined color scheme', mwp_localize_domain());?></h4>
			<div class="color-scheme-container">
				<span style="background:#542549;padding:10px;font-color:#ffffff;">
					<a href="#" class="berkshire-hathaway" style="color:#ffffff;text-decoration:none;">Purple</a>
				</span>
				<span style="background:#ecb429;padding:10px;font-color:#000000;">
					<a href="#" class="century-twenty-one" style="color:#000000;text-decoration:none;">Gold and Black</a>
				</span>
				<span style="background:#0d5696;padding:10px;font-color:#ffffff;">
					<a href="#" class="coldwell-banker" style="color:#ffffff;text-decoration:none;">Splash Blue</a>
				</span>
				<span style="background:#00275e;padding:10px;font-color:#ffffff;">
					<a href="#" class="digmrealty" style="color:#ffffff;text-decoration:none;">Dark Blue</a>
				</span>
				<span style="background:#6e1614;padding:10px;font-color:#d9cfac;">
					<a href="#" class="dreamhomesofcabo" style="color:#d9cfac;text-decoration:none;">Brown and Maroon</a>
				</span>
				<span style="background:#c9042f;padding:10px;font-color:#ffffff;">
					<a href="#" class="era" style="color:#ffffff;text-decoration:none;">Splash Roase </a>
				</span>
				<span style="background:#007788;padding:10px;font-color:#ffffff;">
					<a href="#" class="exit-realty" style="color:#ffffff;text-decoration:none;">Aqua </a>
				</span>
			</div>
			<div class="color-scheme-container">
				<span style="background:#a60008;padding:10px;font-color:#ffffff;">
					<a href="#" class="keller-williams" style="color:#ffffff;text-decoration:none;">Splash Red </a>
				</span>
				<span style="background:#16354a;padding:10px;font-color:#ffffff;">
					<a href="#" class="prodigy-capital" style="color:#ffffff;text-decoration:none;">Bluish </a>
				</span>
				<span style="background:#000000;padding:10px;font-color:#ffffff;">
					<a href="#" class="realty-one" style="color:#ffffff;text-decoration:none;">Black and White </a>
				</span>
			</div>
		</div>
		<h4><?php _e('Or manually defined color', mwp_localize_domain());?></h4>
		<div id="tabs">
		  <ul>
			<li class="hiddenx"><a href="#tabs-list-property"><?php _e('List Property', mwp_localize_domain());?></a></li>
			<li><a href="#tabs-property-details"><?php _e('Property Details', mwp_localize_domain());?></a></li>
			<li><a href="#tabs-search-form"><?php _e('Search Result &amp; Form', mwp_localize_domain());?></a></li>
			<li><a href="#tabs-header"><?php _e('Header', mwp_localize_domain());?></a></li>
		  </ul>
		  <div id="tabs-list-property" class="hiddenx">
			  <div class="two-col">
				<div class="col">
					<p>
						<?php _e('Status label.', mwp_localize_domain());?>
						<span class="mwp-description"><?php _e('default background color', mwp_localize_domain());?></span>
					</p>
					<div class="mwp_list_active_label-sample" style="background:<?php echo $mwp_list_active_label;?>;">
						<input type="text" name="list[mwp_list_active_label]" id="mwp_list_active_label" value="<?php echo $mwp_list_active_label;?>" />
					</div>
					<div class="hidden">
						<p>
							<?php _e('Main Content background color.', mwp_localize_domain());?>
							<span class="mwp-description"><?php _e('default background color', mwp_localize_domain());?></span>
						</p>
						<div class="mwp_list_main_background-sample" style="background:<?php echo $mwp_list_main_background;?>;">
							<input type="text" name="list[mwp_list_main_background]" id="mwp_list_main_background" value="<?php echo $mwp_list_main_background;?>" />
						</div>
						<p><?php _e('Primary Font color', mwp_localize_domain());?>
						<span class="mwp-description"><?php _e('link color', mwp_localize_domain());?></span>
						</p>
						<div class="mwp_list_font_color-sample" style="background:<?php echo $mwp_list_font_color;?>;">
							<input type="text" name="list[mwp_list_font_color]" id="mwp_list_font_color" value="<?php echo $mwp_list_font_color;?>" />
						</div>
						<p><?php _e('Main Content Font color', mwp_localize_domain());?>
						<span class="mwp-description"><?php _e('Font color for links, dropcaps and other elements', mwp_localize_domain());?></span>
						</p>
						<div class="mwp_list_main_content_font_color-sample" style="background:<?php echo $mwp_list_main_content_font_color;?>;">
							<input type="text" name="list[mwp_list_main_content_font_color]" id="mwp_list_main_content_font_color" value="<?php echo $mwp_list_main_content_font_color;?>" />
						</div>
						<p><?php _e('Main Content Heading color', mwp_localize_domain());?>
						</p>
						<div class="mwp_list_main_content_heading_color-sample" style="background:<?php echo $mwp_list_main_content_heading_color;?>;">
							<input type="text" name="list[mwp_list_main_content_heading_color]" id="mwp_list_main_content_heading_color" value="<?php echo $mwp_list_main_content_heading_color;?>" />
						</div>
					</div>
				</div>
				<div class="col">
					<div class="hidden">
						<p><?php _e('Secondary Background color.', mwp_localize_domain());?></p>
						<div class="mwp_list_secondary_background-sample" style="background:<?php echo $mwp_list_secondary_background;?>;">
							<input type="text" name="list[mwp_list_secondary_background]" id="mwp_list_secondary_background" value="<?php echo $mwp_list_secondary_background;?>" />
						</div>
						<p>
							<?php _e('Secondary font color.', mwp_localize_domain());?>
							<span class="mwp-description"><?php _e('highlight color for link and hover', mwp_localize_domain());?></span>
						</p>
						<div class="mwp_list_hover_font_color-sample" style="background:<?php echo $mwp_list_hover_font_color;?>;">
							<input type="text" name="list[mwp_list_hover_font_color]" id="mwp_list_hover_font_color" value="<?php echo $mwp_list_hover_font_color;?>" />
						</div>
						<p><?php _e('Main Content Secondary Font color', mwp_localize_domain());?>
						<span class="mwp-description"><?php _e('link color', mwp_localize_domain());?></span>
						</p>
						<div class="mwp_list_main_content_second_font_color-sample" style="background:<?php echo $mwp_list_main_content_second_font_color;?>;">
							<input type="text" name="list[mwp_list_main_content_second_font_color]" id="mwp_list_main_content_second_font_color" value="<?php echo $mwp_list_main_content_second_font_color;?>" />
						</div>
						<p><?php _e('Border color', mwp_localize_domain());?>
						<span class="mwp-description"><?php _e('link color', mwp_localize_domain());?></span>
						</p>
						<div class="mwp_list_border_color-sample" style="background:<?php echo $mwp_list_border_color;?>;">
							<input type="text" name="list[mwp_list_border_color]" id="mwp_list_border_color" value="<?php echo $mwp_list_border_color;?>" />
						</div>
					</div>
				</div>
			  </div>
			  <p class="mwp-notice"><?php _e('Click on the numbers or the white left side to change color', mwp_localize_domain());?></p>
		  </div>
		  <div id="tabs-property-details">
			 <div class="two-col"><!-- two col -->
				<div class="col">
					 <div class="two-col">
						<h3>Color for Tabs</h3> 
						<div class="col">
							<p><?php _e('Active Background color.', mwp_localize_domain());?></p>
							<div class="mwp_details_tab_active_background-sample" style="background:<?php echo $mwp_details_tab_active_background;?>;">
								<input type="text" name="details[mwp_details_tab_active_background]" id="mwp_details_tab_active_background" value="<?php echo $mwp_details_tab_active_background;?>" />
							</div>
							<p><?php _e('Active Font color.', mwp_localize_domain());?></p>
							<div class="mwp_details_tab_active_fontcolor-sample" style="background:<?php echo $mwp_details_tab_active_fontcolor;?>;">
								<input type="text" name="details[mwp_details_tab_active_fontcolor]" id="mwp_details_tab_active_fontcolor" value="<?php echo $mwp_details_tab_active_fontcolor;?>" />
							</div>
							<p><?php _e('Hover background color.', mwp_localize_domain());?></p>
							<div class="mwp_details_tab_hover_background-sample" style="background:<?php echo $mwp_details_tab_hover_background;?>;">
								<input type="text" name="details[mwp_details_tab_hover_background]" id="mwp_details_tab_hover_background" value="<?php echo $mwp_details_tab_hover_background;?>" />
							</div>
						</div>
						<div class="col">
							<p><?php _e('Inactive Background color.', mwp_localize_domain());?></p>
							<div class="mwp_details_tab_inactive_background-sample" style="background:<?php echo $mwp_details_tab_inactive_background;?>;">
								<input type="text" name="details[mwp_details_tab_inactive_background]" id="mwp_details_tab_inactive_background" value="<?php echo $mwp_details_tab_inactive_background;?>" />
							</div>
							<p><?php _e('Inactive Font color.', mwp_localize_domain());?></p>
							<div class="mwp_details_tab_inactive_fontcolor-sample" style="background:<?php echo $mwp_details_tab_inactive_fontcolor;?>;">
								<input type="text" name="details[mwp_details_tab_inactive_fontcolor]" id="mwp_details_tab_inactive_fontcolor" value="<?php echo $mwp_details_tab_inactive_fontcolor;?>" />
							</div>
							<p><?php _e('Hover font color.', mwp_localize_domain());?></p>
							<div class="mwp_details_tab_hover_font_color-sample" style="background:<?php echo $mwp_details_tab_hover_font_color;?>;">
								<input type="text" name="details[mwp_details_tab_hover_font_color]" id="mwp_details_tab_hover_font_color" value="<?php echo $mwp_details_tab_hover_font_color;?>" />
							</div>
						</div>
					  </div><!-- two col -->
				</div>
					<div class="col">
						<div class="two-col">
						<h3>Content Color</h3>   
						<div class="col">
							<p><?php _e('Main Page Background color.', mwp_localize_domain());?></p>
							<div class="mwp_details_main_page_background-sample" style="background:<?php echo $mwp_details_main_page_background;?>;">
								<input type="text" name="details[mwp_details_main_page_background]" id="mwp_details_main_page_background" value="<?php echo $mwp_details_main_page_background;?>" />
							</div>
							<p><?php _e('Main Background color.', mwp_localize_domain());?></p>
							<div class="mwp_details_main_background-sample" style="background:<?php echo $mwp_details_main_background;?>;">
								<input type="text" name="details[mwp_details_main_background]" id="mwp_details_main_background" value="<?php echo $mwp_details_main_background;?>" />
							</div>
							<p><?php _e('Primary Font color', mwp_localize_domain());?>
							<span class="mwp-description"><?php _e('Font color for links, dropcaps and other elements', mwp_localize_domain());?></span>
							</p>
							
							<div class="mwp_details_main_font_color-sample" style="background:<?php echo $mwp_details_main_font_color;?>;">
								<input type="text" name="details[mwp_details_main_font_color]" id="mwp_details_main_font_color" value="<?php echo $mwp_details_main_font_color;?>" />
							</div>
							<p><?php _e('Content Main Font color', mwp_localize_domain());?></p>
							<div class="mwp_details_content_main_fontcolor-sample" style="background:<?php echo $mwp_details_content_main_fontcolor;?>;">
								<input type="text" name="details[mwp_details_content_main_fontcolor]" id="mwp_details_content_main_fontcolor" value="<?php echo $mwp_details_content_main_fontcolor;?>" />
							</div>
							<p><?php _e('Content Main Heading Font color', mwp_localize_domain());?></p>
							<div class="mwp_details_content_main_heading_fontcolor-sample" style="background:<?php echo $mwp_details_content_main_heading_fontcolor;?>;">
								<input type="text" name="details[mwp_details_content_main_heading_fontcolor]" id="mwp_details_content_main_heading_fontcolor" value="<?php echo $mwp_details_content_main_heading_fontcolor;?>" />
							</div>
						</div>
						<div class="col">
							<p><?php _e('Secondary Background color.', mwp_localize_domain());?></p>
							<div class="mwp_details_secondary_background-sample" style="background:<?php echo $mwp_details_secondary_background;?>;">
								<input type="text" name="details[mwp_details_secondary_background]" id="mwp_details_secondary_background" value="<?php echo $mwp_details_secondary_background;?>" />
							</div>
							<p><?php _e('Highlight Font color.', mwp_localize_domain());?>
							<span class="mwp-description"><?php _e('Secondary color for link and button hover, etc', mwp_localize_domain());?></span>
							</p>
							<div class="mwp_details_secondary_font_color-sample" style="background:<?php echo $mwp_details_secondary_font_color;?>;">
								<input type="text" name="details[mwp_details_secondary_font_color]" id="mwp_details_secondary_font_color" value="<?php echo $mwp_details_secondary_font_color;?>" />
							</div>
							<p><?php _e('Content Secondary Font color.', mwp_localize_domain());?></p>
							<div class="mwp_details_content_secondary_fontcolor-sample" style="background:<?php echo $mwp_details_content_secondary_fontcolor;?>;">
								<input type="text" name="details[mwp_details_content_secondary_fontcolor]" id="mwp_details_content_secondary_fontcolor" value="<?php echo $mwp_details_content_secondary_fontcolor;?>" />
							</div>
							<p><?php _e('Border Color.', mwp_localize_domain());?></p>
							<div class="mwp_details_content_border_color-sample" style="background:<?php echo $mwp_details_content_border_color;?>;">
								<input type="text" name="details[mwp_details_content_border_color]" id="mwp_details_content_border_color" value="<?php echo $mwp_details_content_border_color;?>" />
							</div>
						</div>
					  </div>
				</div>
			 </div><!-- two col -->
			 <p class="mwp-notice"><?php _e('Click on the numbers or the white left side to change color', mwp_localize_domain());?></p>
		  </div>
		  <div id="tabs-search-form">
			<p>
				<?php _e('Page background color.', mwp_localize_domain());?>
			</p>
			<div class="mwp_search_main_page_background-sample" style="background:<?php echo $mwp_search_main_page_background;?>;">
				<input type="text" name="form[mwp_search_main_page_background]" id="mwp_search_main_page_background" value="<?php echo $mwp_search_main_page_background;?>" />
			</div>
			<p>
				<?php _e('Button background color.', mwp_localize_domain());?>
			</p>
			<div class="mwp_button_main_background-sample" style="background:<?php echo $mwp_button_main_background;?>;">
				<input type="text" name="form[mwp_button_main_background]" id="mwp_button_main_background" value="<?php echo $mwp_button_main_background;?>" />
			</div>
			<p><?php _e('Button Font color', mwp_localize_domain());?></p>
			<div class="mwp_button_font_color-sample" style="background:<?php echo $mwp_button_font_color;?>;">
				<input type="text" name="form[mwp_button_font_color]" id="mwp_button_font_color" value="<?php echo $mwp_button_font_color;?>" />
			</div>
			<p>
				<?php _e('Button secondary background color.', mwp_localize_domain());?>
			</p>
			<div class="mwp_button_secondary_background-sample" style="background:<?php echo $mwp_button_secondary_background;?>;">
				<input type="text" name="form[mwp_button_secondary_background]" id="mwp_button_secondary_background" value="<?php echo $mwp_button_secondary_background;?>" />
			</div>
			<p><?php _e('Button secondary Font color', mwp_localize_domain());?></p>
			<div class="mwp_button_secondary_fontcolor-sample" style="background:<?php echo $mwp_button_secondary_fontcolor;?>;">
				<input type="text" name="form[mwp_button_secondary_fontcolor]" id="mwp_button_secondary_fontcolor" value="<?php echo $mwp_button_secondary_fontcolor;?>" />
			</div>
			<p><?php _e('Button Border color', mwp_localize_domain());?></p>
			<div class="mwp_button_border_color-sample" style="background:<?php echo $mwp_button_border_color;?>;">
				<input type="text" name="form[mwp_button_border_color]" id="mwp_button_border_color" value="<?php echo $mwp_button_border_color;?>" />
			</div>
			<p class="mwp-notice"><?php _e('Click on the numbers or the white left side to change color', mwp_localize_domain());?></p>
		  </div>
		  <div id="tabs-header">
			<h3><?php _e('This is applicable only on search result and property details page', mwp_localize_domain());?></h3>
			<p>
				<?php _e('Main background color.', mwp_localize_domain());?>
			</p>
			<div class="mwp_header_main_background_color-sample" style="background:<?php echo $mwp_header_main_background_color;?>;">
				<input type="text" name="header[mwp_header_main_background_color]" id="mwp_header_main_background_color" value="<?php echo $mwp_header_main_background_color;?>" />
			</div>
			<p>
				<?php _e('Secondary background color.', mwp_localize_domain());?>
			</p>
			<div class="mwp_header_secondary_background_color-sample" style="background:<?php echo $mwp_header_secondary_background_color;?>;">
				<input type="text" name="header[mwp_header_secondary_background_color]" id="mwp_header_secondary_background_color" value="<?php echo $mwp_header_secondary_background_color;?>" />
			</div>
			<p>
				<?php _e('Primary font color.', mwp_localize_domain());?>
			</p>
			<div class="mwp_header_primary_font_color-sample" style="background:<?php echo $mwp_header_primary_font_color;?>;">
				<input type="text" name="header[mwp_header_primary_font_color]" id="mwp_header_primary_font_color" value="<?php echo $mwp_header_primary_font_color;?>" />
			</div>
			<p>
				<?php _e('Secondary font color.', mwp_localize_domain());?>
			</p>
			<div class="mwp_header_secondary_font_color-sample" style="background:<?php echo $mwp_header_secondary_font_color;?>;">
				<input type="text" name="header[mwp_header_secondary_font_color]" id="mwp_header_secondary_font_color" value="<?php echo $mwp_header_secondary_font_color;?>" />
			</div>
			<p>
				<?php _e('Heading font color.', mwp_localize_domain());?>
			</p>
			<div class="mwp_header_heading_color-sample" style="background:<?php echo $mwp_header_heading_color;?>;">
				<input type="text" name="header[mwp_header_heading_color]" id="mwp_header_heading_color" value="<?php echo $mwp_header_heading_color;?>" />
			</div>
			<p>
				<?php _e('Border color.', mwp_localize_domain());?>
			</p>
			<div class="mwp_header_border_color-sample" style="background:<?php echo $mwp_header_border_color;?>;">
				<input type="text" name="header[mwp_header_border_color]" id="mwp_header_border_color" value="<?php echo $mwp_header_border_color;?>" />
			</div>
		</div>
		</div><!-- tabs -->
		
		<div class="form-button-container">
			<input type="submit" name="Submit" class="mwp-form-button" value="<?php _e('Update', mwp_localize_domain()) ?>" />
		</div>
		<input type="hidden" name="current_tab" class="current_tab" value="#tabs-list-property" />
	</form>
</div>
<script>
	var current_color = '<?php echo $current_color;?>';
	var mwp_list_main_background = '<?php echo $mwp_list_main_background;?>';
	var mwp_list_secondary_background = '<?php echo $mwp_list_secondary_background;?>';
	var mwp_list_font_color = '<?php echo $mwp_list_font_color;?>';
	var mwp_list_hover_font_color = '<?php echo $mwp_list_hover_font_color;?>';
	//details
	var mwp_details_tab_active_background = '<?php echo $mwp_details_tab_active_background;?>';
	var mwp_details_tab_active_fontcolor = '<?php echo $mwp_details_tab_active_fontcolor;?>';
	var mwp_details_tab_inactive_background = '<?php echo $mwp_details_tab_inactive_background;?>';
	var mwp_details_tab_inactive_fontcolor = '<?php echo $mwp_details_tab_inactive_fontcolor;?>';
	//details overall
	var mwp_details_main_background = '<?php echo $mwp_details_main_background;?>';
	var mwp_details_main_font_color = '<?php echo $mwp_details_main_font_color;?>';
	var mwp_details_secondary_background = '<?php echo $mwp_details_secondary_background;?>';
	var mwp_details_secondary_font_color = '<?php echo $mwp_details_secondary_font_color;?>';
	//form
	var mwp_button_main_background = '<?php echo $mwp_button_main_background;?>';
	var mwp_button_font_color = '<?php echo $mwp_button_font_color;?>';
</script>
