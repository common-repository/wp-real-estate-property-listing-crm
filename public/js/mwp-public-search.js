jQuery(document).ready(function($){
	var select_input = '#locations';
	var default_feed = MDAjax.default_feed;
	var mwp_locations = '';
	var url_location_search = MDAjax.ajaxurl + '?callback=&action=get_location_'+default_feed;
	jQuery("#advanced_search").on('submit',function(e){
		//e.preventDefault();
		//console.log(jQuery('#location').val());
		if( jQuery('#location').val() == '' ){
			jQuery('#locationname').val('');
			jQuery('#communityid').val(0);
			jQuery('#cityid').val(0);
			jQuery('#subdivisionid').val(0);
			jQuery('#stateid').val(0);
		}
	});
	//var mwp_locations = mwp_locations;
	function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
	function get_match_on_top(source, request, response){
		var filtered = [];
		var match = [];
		var other_match = [];
		var filtered = jQuery.ui.autocomplete.filter(
			source,
			request.term
		);
		for (var j = 0; j < filtered.length; j++){
			if ( filtered[j].value.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
				match.push(filtered[j]);
			}else{
				other_match.push(filtered[j]);
			}
		}
		var merge_array = jQuery.merge(match, other_match);
		response(merge_array);
	}
	function mwp_location_lookup_select(event, ui){
		console.log(ui.item ?
			"Selected: " + ui.item.value + " aka " + ui.item.id + " type " + ui.item.type.toLowerCase() :
			"Nothing selected, input was " + this.value);
		//event.preventDefault();	
		var location_type = ui.item.type.toLowerCase();
		var loc_id = ui.item.id;
		
		jQuery('#locationname').val('');
		jQuery('#communityid').val(0);
		jQuery('#cityid').val(0);
		jQuery('#subdivisionid').val(0);

		if( location_type == 'community' ){
			jQuery('#communityid').val(loc_id);
		} else if( location_type == 'city' ){
			jQuery('#cityid').val(loc_id);
		} else if( location_type == 'county' ){
			jQuery('#countyid').val(loc_id);
		} else if( location_type == 'subdivision' ){
			jQuery('#subdivisionid').val(loc_id);
		} else if( location_type == 'state' ){
			jQuery('#stateid').val(loc_id);
		}
		jQuery('#cityid').val();
		jQuery('#locationname').val(ui.item.value);
		//jQuery("#advanced_search").submit();
	}
	if( MDAjax.default_feed == 'crm' || MDAjax.default_feed == 'mls' ){
		jQuery('#location').autocomplete({
			minLength: 3,
			source: function( request, response ) {
				get_match_on_top(location_autocomplete, request, response);
			},
			select:function(event, ui){
				mwp_location_lookup_select(event, ui);
			}
		});
	}else{
		jQuery('#location').autocomplete({
			minLength: 3,
			source:url_location_search,
			select:function(event, ui){
				mwp_location_lookup_select(event, ui);
			}
		});
	}
	
});

