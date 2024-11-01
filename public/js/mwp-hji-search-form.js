jQuery(document).ready(function($){
	var hji_property_types = MDAjax.hji_getpropertytypes;
	var hji_property_types_keys =_.keys(hji_property_types);
	var property_types = $('#property_type'); 
	var change_list_type = false;
	// Remove the '?' at the start of the string and split out each assignment
	var mwp_uri = _.chain( location.search.slice(1).split('&') )
    // Split each array item into [key, value]
    // ignore empty string if search is empty
    .map(function(item) { if (item) return item.split('='); })
    // Remove undefined in the case the search is empty
    .compact()
    // Turn [key, value] arrays into object parameters
    .object()
    // Return the value of the chain operation
    .value();

	function populate_property_types(list_type){
		property_types.attr('disable');
		
		property_types.empty();
		
		property_types.append('<option value="0">Property Type / Any</option>');
		
		$(hji_property_types[list_type]).each(function(k,v){
			property_types.append('<option value="'+v+'">'+v+'</option>');
		});
		
		if( mwp_uri.property_type !== undefined && !change_list_type){
			property_types.val(mwp_uri.property_type).attr('selected',true);
		}else{
			property_types.val('0').attr('selected',true);
		}
		
		property_types.removeAttr('disable');
	}
	
	function listType_init(){
		var list_type = $('#list_type');
		
		list_type.append('<option value="0">List Type / Any</option>');
		
		$(hji_property_types_keys).each(function(k,v){
			list_type.append('<option value="'+v+'">'+v+'</option>');
		});
		
		if( mwp_uri.list_type !== undefined){
			list_type.val(mwp_uri.list_type).attr('selected',true);
			populate_property_types(mwp_uri.list_type);
		}

		list_type.on('change',function(){
			var selected = $('option:selected', this);
			change_list_type = true;
			populate_property_types(selected.text());
		});
				
	}
	
	listType_init();
	if( !change_list_type ){
		property_types.append('<option value="0">Property Type / Any</option>');
	}
});

