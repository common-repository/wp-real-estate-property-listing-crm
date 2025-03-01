<link rel="stylesheet" id="masterdigm-public-style" href="<?php echo mwp_public_url() . 'css/mwp-public.css';?>">
<link rel="stylesheet" id="masterdigm-style" href="<?php echo mwp_public_url() . 'css/md-style.css';?>">
<?php //custom script and css ?>
<style type="text/css">
html,body{
  	height:100%;
}

body{
  	padding-top:50px; /*padding for navbar*/
}

.navbar-custom .icon-bar {
	background-color:#fff;
}

.navbar-custom {
	background-color: #168ccc;
    color:#fff;
}

.navbar-custom li>a:hover,.navbar-custom li>a:focus {
	background-color:#49bfff;
}

.navbar-custom a{
    color:#fefefe;
}

.navbar-custom .form-control:focus {
	border-color: #49bfff;
	outline: 0;
	-webkit-box-shadow: inset 0 0 0;
	box-shadow: inset 0 0 0;
}

#main, #main>.row {
	height:100%;
}

#main>.row {
    overflow-y:scroll;
}

#left {
	height:100%;
}

#map-canvas {
    height:calc(100% - 0);
    position:absolute;
    right:16px;
    top:50px;
    bottom:0;
    overflow:hidden;
}
.ui-autocomplete { z-index:1031 !important;} 
</style>
