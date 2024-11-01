<?php
if( mwp_get_headers() == 0 && mwp_is_search_view_list()){
	$header_name = mwp_get_headers_name();
	get_header($header_name);

	if( Mwp_View::get_instance()->no_data ){
		echo '<div class="mwp-bootstrap">';
			$part_search_form = Mwp_Theme_Locator::get_instance()->locate_template(Mwp_Theme_Layout_Entity::get_instance()->get_search_form());
			Mwp_View::get_instance()->display($part_search_form); 
		echo '</div>';
	}
}else{
	Mwp_View::get_instance()->display(Mwp_View::get_instance()->header, Mwp_View::get_instance()->data);
}
if( Mwp_View::get_instance()->no_data ){
	$four_oh_four = Mwp_Theme_Locator::get_instance()->locate_template('mwp-content-404.php');
	Mwp_View::get_instance()->display($four_oh_four, Mwp_View::get_instance()->data);	
}else{
	if( mwp_get_headers() == 0 && mwp_is_search_view_list() ){
		echo '<div class="mwp-bootstrap">';
			$part_search_form = Mwp_Theme_Locator::get_instance()->locate_template(Mwp_Theme_Layout_Entity::get_instance()->get_search_form());
			Mwp_View::get_instance()->display($part_search_form); 
	}
		Mwp_View::get_instance()->display(Mwp_View::get_instance()->data['part_content'], Mwp_View::get_instance()->data);
	if( mwp_get_headers() == 0 && mwp_is_search_view_list() ){	
		echo '</div>';
	}
}

if( mwp_get_footers() == 0 && mwp_is_search_view_list()){
	$footer_name = mwp_get_footers_name();
	get_footer($footer_name);
}else{
	Mwp_View::get_instance()->display(Mwp_View::get_instance()->footer, Mwp_View::get_instance()->data);
}

