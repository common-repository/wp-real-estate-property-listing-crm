<?php
if( Mwp_View::get_instance()->has_filter_single_property && !is_nonviewable_status() ){
	if( Mwp_View::get_instance()->data['property_data']->loop_property() ){
		if( mwp_get_headers() == 0 ){
			$header_name = mwp_get_headers_name();
			get_header($header_name);
		}else{
			Mwp_View::get_instance()->display(Mwp_View::get_instance()->header, Mwp_View::get_instance()->data);
		}
		Mwp_View::get_instance()->display(Mwp_View::get_instance()->data['part_content'], Mwp_View::get_instance()->data);
	}
}else{
	Mwp_View::get_instance()->display(Mwp_View::get_instance()->header_four_oh_four, Mwp_View::get_instance()->data);
	$four_oh_four = Mwp_Theme_Locator::get_instance()->locate_template('mwp-content-404.php');
	Mwp_View::get_instance()->display($four_oh_four, Mwp_View::get_instance()->data);
}
if( mwp_get_footers() == 0 ){
	$footer_name = mwp_get_footers_name();
	get_footer($footer_name);
}else{
	Mwp_View::get_instance()->display(Mwp_View::get_instance()->footer, Mwp_View::get_instance()->data);
}

