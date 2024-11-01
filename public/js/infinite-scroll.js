// js file
var total_data;
var no_more_data = 0;
var paged = 2; // replaced when loading more
var current_paged = 0; // replaced when loading more
var next_paged = 0; // replaced when loading more
var next_data_url; // replaced when loading more
var prev_data_url; // replaced when loading more
var next_data_cache;
var prev_data_cache;
var last_scroll = 0;
var is_loading = false; // simple lock to prevent loading when loading
var hide_on_load = false; // ID that can be hidden when content has been loaded
var html_pagination = '';

function loadFollowing(){
	feed = MDAjax.default_feed;
	is_loading = true;
	var ajax_indicator = jQuery('.ajax-indicator');
	var _ajax_data = [
		{name : 'security', value: MDAjax.security},
		{name : 'action', value : 'infinite_scroll_' + feed},
		{name : 'limit', value : '10'},
		{name : 'total', value : total_properties},
		{name : 'paged', value : paged},
		{name : 'search_uri_query', value : JSON.stringify(search_uri_query)},
	];
	jQuery('.ajax-md-pagination').remove();
	
	jQuery.ajax({
		type: "POST",
		url: MDAjax.ajaxurl,
		data: _ajax_data,
		dataType: "html"
	}).done(function( data ) {
		//console.log(data);
		jQuery(".md-pagination").html("");
		paged = jQuery(data).find('.mwp-pagination .next-page').data('next-pageid');
		html_pagination = jQuery(data).find('.ajax-md-pagination .mwp-pagination');
		total_data = jQuery(data).find('.ajax-md-pagination .last_page');
		if (typeof paged === 'undefined'){
			paged = total_data.val();
		}
		if (total_data.val() == paged){
			no_more_data = 1;
			jQuery(data).find('.ajax-md-pagination').hide();
		}
		//console.log('paged ' + paged);
		//console.log('total data ' + total_data.val());
		//html_pagination.remove();
		jQuery('#md-listing-results .row').append(data);
		jQuery('#md-listing-results .row').find('.ajax-md-pagination').hide();
        //jQuery("#md-listing-results .md-pagination").html(html_pagination);
        jQuery("#md-listing-results .md-pagination").hide();
		is_loading = false;
		jQuery('#md-listing-results .row .image-loader').remove();
	});
}

function loadPrevious(){
}

function mostlyVisible(element) {
  // if ca 25% of element is visible
  var scroll_pos = jQuery(window).scrollTop();
  var window_height = jQuery(window).height();
  var el_top = jQuery(element).offset().top;
  var el_height = jQuery(element).height();
  var el_bottom = el_top + el_height;
  return ((el_bottom - el_height*0.25 > scroll_pos) && 
          (el_top < (scroll_pos+0.5*window_height)));
}

function initPaginator() {
  jQuery(window).scroll(function() {
    // handle scroll events to update content
    var scroll_pos = jQuery(window).scrollTop();
    if (scroll_pos >= 0.9*(jQuery(document).height() - jQuery(window).height())) {
      if (is_loading==0 && no_more_data==0) {
		jQuery('#md-listing-results .row').append('<p class="image-loader text-center"><img src="'+MDAjax.ajax_indicator+'" alt="Loading Data"></p>');   
		loadFollowing();
	  }
    }
    if (scroll_pos <= 0.9*jQuery(".navbar").height()) {
      //if (is_loading==0) loadPrevious();
    }
    // Adjust the URL based on the top item shown
    // for reasonable amounts of items
    if (Math.abs(scroll_pos - last_scroll)>jQuery(window).height()*0.1) {
      last_scroll = scroll_pos;
      //$(".listitempage").each(function(index) {
        if (is_loading == 0) {
          //history.replaceState(null, null, paged);
          //history.replaceState(null, null, $(this).attr("data-url"));
          //$("#pagination").html($(this).attr("data-pagination"));
          return(false);
        }
      //});
      //console.log(paged);
    }
  });
  jQuery(document).ready(function () {
    // if we have enough room, load the next batch
    if (jQuery(window).height()>jQuery("#md-listing-results").height()) {
      if (!is_loading && no_more_data==0) {
		loadFollowing();
      } else {
        var filler = document.createElement("div");
        filler.id = "filler";
        filler.style.height = (jQuery(window).height() - 
                jQuery("#md-listing-results").height())+ "px";
        jQuery("#md-listing-results").after(filler);
        hide_on_load = "filler";
      }
    }
    // scroll down to hide empty room
    head_height = jQuery(".navbar-custom").height();
   // window.scrollTo(0, head_height); 
  });
}
