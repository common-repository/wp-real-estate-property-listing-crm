<?php
/*
Template Name: MWP Search Form - for HJI account
*/

$part_template = Mwp_Theme_Locator::get_instance()->locate_template('searchform/raw-search-form-hji.php');
Mwp_View::get_instance()->display($part_template, array()); 
?>
