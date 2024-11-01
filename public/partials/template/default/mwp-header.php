<!DOCTYPE html>
<html lang="en" ng-app="<?php echo (Mwp_View::get_instance()->current_view_type == 'map') ? 'searchResultApp':'';?>">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Robots -->
<meta name="robots" content="index,follow" />
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title><?php echo Mwp_View::get_instance()->title;?></title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src = "<?php echo mwp_public_url() . 'js/angular.min.js';?>"></script>
<script src = "<?php echo mwp_public_url() . 'js/angular-route.min.js';?>"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" id="masterdigm-public-style" href="<?php echo mwp_public_url() . 'css/mwp-public.css';?>">
<link rel="stylesheet" id="masterdigm-style" href="<?php echo mwp_public_url() . 'css/md-style.css';?>">
<link rel="stylesheet" id="masterdigm-style" href="<?php echo mwp_public_url() . 'css/magnific-popup.css';?>">
<?php if( Mwp_View::get_instance()->current_view_type == 'map' ) { ?>
<link rel="stylesheet" id="masterdigm-style" href="<?php echo mwp_public_url() . 'css/mwp-spa.css';?>">
<?php } ?>
<link rel="stylesheet" id="masterdigm-style" href="<?php echo mwp_public_url() . 'css/md-property-page.css';?>">
<link rel="stylesheet" id="masterdigm-style" href="<?php echo mwp_public_url() . 'css/md-listing.css';?>">
<?php Mwp_View::get_instance()->display($part_header, Mwp_View::get_instance()->data); ?>
<?php Mwp_Theme_Style_Entity::get_instance()->mwp_wp_styling(); ?>
<style>
<?php 
	echo Mwp_Theme_Layout_Entity::get_instance()->get_custom_css(); 
?>
</style>
</head>
<body class="<?php echo $mwp_body_class;?>">
<div class="navbar navbar-custom navbar-collapse <?php echo $class_nav_bar;?>">
    <div class="navbar-header">
      <a class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
    </div>
    <div class="navbar-collapse navbar-custom collapse"><!-- top menu nav -->
    <div class="mwp-header-contain">
		<?php Mwp_Theme_Layout_Entity::get_instance()->show_menu();?>
		 <?php mwp_user_dropdown(); ?>
    </div>
    </div><!-- top menu nav -->
    <div class="nav-bar mwp-navbar-header row"><!-- second nav menu -->
    <div class="mwp-header-contain">
	  <div class="col-lg-3 col-md-12">
		  <a href="<?php echo site_url();?>">
			<?php if(Mwp_Theme_Layout_Entity::get_instance()->get_logo()){ //if logo?>
				<img src="<?php echo Mwp_Theme_Layout_Entity::get_instance()->get_logo();?>" class="img-responsive" style="height:76px;">
			<?php }else{//if logo ?>
					<h2 style="color:#000000;"><?php echo get_option('blogname');?></h2>
			<?php }//if logo ?>
		  </a>
	  </div>
	  <div class="col-lg-9 col-md-12 <?php echo $mwp_header_class;?>-search-form ">
		<?php
			$part_search_form = Mwp_Theme_Locator::get_instance()->locate_template(Mwp_Theme_Layout_Entity::get_instance()->get_search_form());
			Mwp_View::get_instance()->display($part_search_form);
		?>
	  </div>
    </div>
    </div><!-- second nav menu -->
</div>

