<link rel="stylesheet" href="<?php echo mwp_admin_url_path() . 'css/jquery-ui.css'; ?>" />
<script src="<?php echo mwp_public_url() . 'js/underscore-min.js';?>"></script>
<style>
.ui-autocomplete-loading {
background: white url("<?php echo mwp_admin_url_path() . 'image/ajax-loader.gif';?>") right center no-repeat;
}
.ui-autocomplete {
max-height: 150px;
overflow-y: auto;
/* prevent horizontal scrollbar */
overflow-x: hidden;
}
/* IE 6 doesn't support max-height
* we use height instead, but this forces the menu to always be this tall
*/
*
html .ui-autocomplete {
height: 300px;
}
#location{
	width:80%;
}
.remove-item{
	font-size:10px;
}
.col-left{
	float: left;
    width: 50%;
}
</style>
<form>
	<div class="ui-widget">
	  <label for="tags"><?php _e('Type Location', mwp_localize_domain());?> : </label>
	  <input id="location" name="location" value="">
	  <div id="log" style="height: 150px;overflow-y: auto;overflow-x: hidden;width: 100%; overflow: auto;" class="ui-widget-content"></div>
	</div>
	<div class="row">
		<div class="col-left col-md-6 col-xs-12">
			<p><?php _e('List by how many Bathrooms in property',mwp_localize_domain());?> <input name="bath" value=""></p>
			<p><?php _e('List by how many Bedrooms in property',mwp_localize_domain());?> <input name="bed" value=""></p>
			<p><?php _e('List by minimum listprice in property (number format only, example: 123456)',mwp_localize_domain());?> <input name="min_price" value=""></p>
			<p><?php _e('List by maximum listprice in property (number format only, example: 123456)',mwp_localize_domain());?> <input name="max_price" value=""></p>
			<p><?php _e('List Type',mwp_localize_domain());?> <select id="list_type" name="list_type"></select></p>
			<p><?php _e('Property Type',mwp_localize_domain());?> <select id="property_type" name="property_type"></select></p>
			<p>
				Days on market
				<select name="daysonmarket_condition" id="daysonmarket_condition">
					<option value="equal">Equal</option>
					<option value="greater">Greater than</option>
					<option value="less">Less than</option>
				</select>
				<input type="daysonmarket_value" id="daysonmarket_value">
			</p>
		</div>
		<div class="col-md-6 col-xs-12">
			<p><?php _e('How many property to display', mwp_localize_domain());?> <input name="limit" value="<?php echo mwp_get_limit();?>"></p>
			<p><?php _e('Show Pagination?', mwp_localize_domain());?> <input type="checkbox" name="pagination" id="pagination" checked></p>
			<p><?php _e('Set property per columns ( should be divided by 12 )', mwp_localize_domain());?> <input name="col" value="<?php echo mwp_bootstrap_grid_col_md();?>"></p>
		</div>
	</div>
	<p></p>
	<button name="Insert Shortcode" id="insert-shortcode"><?php _e('Insert Shortcode', mwp_localize_domain());?></button>
</form>
<script>
	//var crm_jquery_auto_location = <?php echo $obj_this->get_location(); ?>;
	var args 					= top.tinymce.activeEditor.windowManager.getParams();
	var $ 						= args.jquery;
	var editor 					= args.editor;
	var mdajax 					= args.mdajax;
	var current_feed 			= args.current_feed;
	var property_type_def 		= '';
	var list_type_def 			= '<?php echo mwp_default_list_type();?>';
	var template 				= args.template;
	var search_type 			= args.search_type;
	var context 				= document.getElementsByTagName("body")[0];
	var loc_data				= [];
	var url_location_search = mdajax.ajaxurl + '?callback=&action=get_location_'+current_feed;
	
	var hji_property_types = mdajax.hji_getpropertytypes;
	var hji_property_types_keys =_.keys(hji_property_types);
	var property_types = $('#property_type', context); 
	var change_list_type = false;

	function populate_property_types(list_type){
		property_types.attr('disable');
		
		property_types.empty();
		
		property_types.append('<option value="">Any</option>');
		
		$(hji_property_types[list_type]).each(function(k,v){
			property_types.append('<option value="'+v+'">'+v+'</option>');
		});
		
		property_types.val('').attr('selected',true);
		
		property_types.removeAttr('disable');
	}
	
	function listType_init(){
		var list_type = $('#list_type', context);
		
		list_type.append('<option value="0">Any</option>');
		$(hji_property_types_keys).each(function(k,v){
			list_type.append('<option value="'+v+'">'+v+'</option>');
		});
				
		list_type.on('change',function(){
			var selected = $('option:selected', this);
			change_list_type = true;
			populate_property_types(selected.text());
		});
				
	}

	listType_init();
	if( !change_list_type ){
		property_types.append('<option value="">Any</option>');
	}
	
	function log_location( sel_loc ) {
		$('#location',context).val('');
		loc_data.push({value:sel_loc.item.id,type:sel_loc.item.type});

		var data_select = sel_loc.item.value;

		$( "#log", context ).prepend( '<div class="loc-item-'+sel_loc.item.id+'" >'+ data_select + ' [' + sel_loc.item.type + '] - <a href="#" class="remove-item" onClick="remove_item('+sel_loc.item.id+');" data-id="'+sel_loc.item.id+'">Remove</a></div>' );
		$( "#log", context ).scrollTop( 0 );
	}

	function remove_item(id){
		loc_data = $.grep(loc_data,function(e){
			return e.value != id;
		});
		$('.loc-item-' + id, context).remove();
	}

	function get_exact_match(source, request, response){
		var filtered = [];
		var match = [];
		var filtered = $.ui.autocomplete.filter(
			source,
			request.term
		);
		for (var j = 0; j < filtered.length; j++){
			if ( filtered[j].value.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
				match.push(filtered[j]);
			}
		}
		response(match);
	}

	function get_match_on_top(source, request, response){
		var filtered = [];
		var match = [];
		var other_match = [];
		var filtered = $.ui.autocomplete.filter(
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
		var merge_array = $.merge(match, other_match);
		response(merge_array);
	}
	$( "#location", context ).autocomplete({
		minLength: 3,
		source: url_location_search,
		select:function(event, ui){
			log_location(ui);
			$('#location',context).val('');
		}
	});
	$('#insert-shortcode', context).on('click',function(e){
		var shortcode = '';
		var loc_input = $( 'input[name^="loc_"]', context );

		var city_id 	 = '';
		var community_id = '';
		var subdivision_id = '';

		var city_shortcode 		= ' cityid="" ';

		var infinite_check = 'false';
		if( $('#infinite',context).is(":checked") ){
			infinite_check = 'true';
		}

		var pagination_check = 'false';
		if( $('#pagination',context).is(":checked") ){
			pagination_check = 'true';
		}
		
		if( $('#list_type',context).val() != 0 ){
			list_type_def = $('#list_type',context).val();
		}
		
		property_type_def = $('#property_type',context).val();
		
		var daysonmarket 	= ' daysonmarket="' + $('#daysonmarket_value',context).val() + '" ';
		var daysonmarket_condition 	= ' daysonmarket_condition="' + $('#daysonmarket_condition',context).val() + '" ';
		var bathromms 		= ' bathrooms="' + $('input[name="bath"]',context).val() + '" ';
		var bedrooms 		= ' bedrooms="' + $('input[name="bed"]',context).val() + '" ';
		var min_listprice 	= ' min_listprice="' + $('input[name="min_price"]',context).val() + '" ';
		var max_listprice 	= ' max_listprice="' + $('input[name="max_price"]',context).val() + '" ';
		var list_type		= ' list_type="' + list_type_def + '" ';
		var property_type	= ' property_type="' + property_type_def + '" ';
		var limit 			= ' limit="' + $('input[name="limit"]',context).val() + '" ';
		var infinite 		= ' infinite="' + infinite_check + '" ';
		var pagination 		= ' pagination="' + pagination_check + '" ';
		var col_grid 		= ' col="' + $('input[name="col"]',context).val() + '" ';

		$(loc_data).each(function(k, v) {
			if( v.type == 'city' ){
				city_id += v.value +',';
			}
		});

		city_shortcode 		= ' city="'+city_id.replace(/,+$/,'')+'" ';
		shortcode = '[hji_list_properties'
						+ city_shortcode
						+ bathromms
						+ bedrooms
						+ min_listprice
						+ max_listprice
						+ list_type
						+ property_type
						+ daysonmarket_condition
						+ daysonmarket
						+ limit
						+ col_grid
						+ infinite
						+ pagination
					+ ']';
		editor.selection.setContent(shortcode);
		editor.windowManager.close();
		e.preventDefault();
	});
</script>
