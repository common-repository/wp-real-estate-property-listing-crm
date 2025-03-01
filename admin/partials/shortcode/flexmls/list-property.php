<link rel="stylesheet" href="<?php echo mwp_admin_url_path() . 'css/jquery-ui.css'; ?>" />
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
			<p><?php _e('List by how many Bathrooms in property',mwp_localize_domain());?> <input name="bath" value="0"></p>
			<p><?php _e('List by how many Bedrooms in property',mwp_localize_domain());?> <input name="bed" value="0"></p>
			<p><?php _e('List by minimum listprice in property (number format only, example: 123456)',mwp_localize_domain());?> <input name="min_price" value="0"></p>
			<p><?php _e('List by maximum listprice in property (number format only, example: 123456)',mwp_localize_domain());?> <input name="max_price" value="0"></p>
			<p><?php _e('Status',mwp_localize_domain());?> <select id="search_status" name="search_status"></select></p>
			<p><?php _e('Type',mwp_localize_domain());?> <select id="search_type" name="search_type"></select></p>
		</div>
		<div class="col-md-6 col-xs-12">
			<p>
				<?php _e('Transaction',mwp_localize_domain());?>
				<select name="transaction" id="transaction">
					<option value="For Sale"><?php _e('For Sale', mwp_localize_domain());?></option>
					<option value="For Rent"><?php _e('For Rent', mwp_localize_domain());?></option>
					<option value="Foreclosure"><?php _e('Foreclosure', mwp_localize_domain());?></option>
				</select>
			</p>
			<p><?php _e('How many property to display', mwp_localize_domain());?> <input name="limit" value="<?php echo mwp_get_limit();?>"></p>
			<p><?php _e('Show Infinite Scroll? this will show the scrolling ajax instead of tix "how many display"', mwp_localize_domain());?> <input type="checkbox" name="infinite" id="infinite"></p>
			<p><?php _e('Show Pagination?', mwp_localize_domain());?> <input type="checkbox" name="pagination" id="pagination" checked></p>
			<p><?php _e('Set property per columns ( should be divided by 12 )', mwp_localize_domain());?> <input name="col" value="4"></p>
		</div>
	</div>
	<p></p>
	<button name="Insert Shortcode" id="insert-shortcode"><?php _e('Insert Shortcode', mwp_localize_domain());?></button>
</form>
<script>
	//var jquery_auto_location 	= <?php echo $obj_this->get_location(); ?>;
	var args 					= top.tinymce.activeEditor.windowManager.getParams();
	var $ 						= args.jquery;
	var editor 					= args.editor;
	var mdajax 					= args.mdajax;
	var current_feed 					= args.current_feed;
	var template 				= args.template;
	var search_status 			= args.search_status;
	var search_type 			= args.search_type;
	var context 				= document.getElementsByTagName("body")[0];
	var loc_data				= [];
	var url_location_search = mdajax.ajaxurl + '?callback=&action=get_location_'+current_feed;
	$(template).each(function(k,v){
		$('#template',context).append('<option value="'+v.value+'">'+v.text+'</option>');
	});
	$(search_status).each(function(k,v){
		$('#search_status',context).append('<option value="'+v.value+'">'+v.text+'</option>');
	});
	$(search_type).each(function(k,v){
		$('#search_type',context).append('<option value="'+v.value+'">'+v.text+'</option>');
	});

	function log_location( sel_loc ) {
		$('#location',context).val('');
		console.log(sel_loc);
		loc_data.push({
			value:sel_loc.item.id,
			type:sel_loc.item.type,
			label:sel_loc.item.label
		});

		var data_select = sel_loc.item.value;

		$( "#log", context ).prepend( '<div class="loc-item-'+sel_loc.item.id+'" >'+ data_select + ' [' + sel_loc.item.type + '] - <a href="#" class="remove-item" onClick="remove_item(\''+sel_loc.item.id+'\');" data-id="'+sel_loc.item.id+'" data-label="'+sel_loc.item.label+'">Remove</a></div>' );
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

		var city_shortcode 		= ' cityid="0" ';
		var community_shortcode = ' communityid="0" ';
		var subdivision_shortcode = ' subdivisionid="0" ';

		var infinite_check = 'false';
		if( $('#infinite',context).is(":checked") ){
			infinite_check = 'true';
		}

		var pagination_check = 'false';
		if( $('#pagination',context).is(":checked") ){
			pagination_check = 'true';
		}

		var trim = (function () {
			"use strict";

			function escapeRegex(string) {
				return string.replace(/[\[\](){}?*+\^$\\.|\-]/g, "\\$&");
			}

			return function trim(str, characters, flags) {
				flags = flags || "g";
				if (typeof str !== "string" || typeof characters !== "string" || typeof flags !== "string") {
					throw new TypeError("argument must be string");
				}

				if (!/^[gi]*$/.test(flags)) {
					throw new TypeError("Invalid flags supplied '" + flags.match(new RegExp("[^gi]*")) + "'");
				}

				characters = escapeRegex(characters);

				return str.replace(new RegExp("^[" + characters + "]+|[" + characters + "]+$", flags), '');
			};
		}());

		var bathromms 		= ' bathrooms="' + $('input[name="bath"]',context).val() + '" ';
		var bedrooms 		= ' bedrooms="' + $('input[name="bed"]',context).val() + '" ';
		var min_listprice 	= ' min_listprice="' + $('input[name="min_price"]',context).val() + '" ';
		var max_listprice 	= ' max_listprice="' + $('input[name="max_price"]',context).val() + '" ';
		var property_status = ' property_status="' + $('#search_status',context).val() + '" ';
		var property_type	= ' property_type="' + $('#search_type',context).val() + '" ';
		var transaction 	= ' transaction="' + $('#transaction',context).val() + '" ';
		var limit 			= ' limit="' + $('input[name="limit"]',context).val() + '" ';
		var infinite 		= ' infinite="' + infinite_check + '" ';
		var pagination 		= ' pagination="' + pagination_check + '" ';
		var template_path 	= ' template="' + $('#template',context).val() + '" ';
		var col_grid 		= ' col="' + $('input[name="col"]',context).val() + '" ';

		$(loc_data).each(function(k, v) {
			city_id += 'City Eq \'' + v.label + '\' AND ';
		});

		city_shortcode 	= ' cityid="'+trim(city_id,' AND ')+'" ';
		shortcode = '[md_sc_flexmls_listings'
						+ city_shortcode
						+ community_shortcode
						+ subdivision_shortcode
						+ bathromms
						+ bedrooms
						+ min_listprice
						+ max_listprice
						+ property_status
						+ property_type
						+ transaction
						+ limit
						+ template_path
						+ col_grid
						+ infinite
						+ pagination
					+ ']';
		editor.selection.setContent(shortcode);
		editor.windowManager.close();
		e.preventDefault();
	});
</script>
