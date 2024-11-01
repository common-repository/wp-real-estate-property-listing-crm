(function( $ ) {
	'use strict';
	var ReloadThis = function(){
		return {
			init:function(){
				setTimeout(function(){
					$('.register-modal').modal('hide');
					location.reload(true);
				},2000);
			}
		};
	}();
	var sharePop = function(){
		return {
			init:function(){
				$(document).on("click", ".share-popup", function(e){
					var url = this.href;
					var domain = url.split("/")[2];
					var window_size = "width=585,height=511";
					window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,' + window_size);
					e.preventDefault();
					return false;
				});
			}
		};
	}();
	var printPdf = function(){
		return {
			init:function(){

				function url_query( url, query ) {
					query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
					var expr = "[\\?&]"+query+"=([^&#]*)";
					var regex = new RegExp( expr );
					var results = regex.exec( url );
					if ( results !== null ) {
						return results[1];
					} else {
						return false;
					}
				}
				
				$(document).on('click','.print-pdf-action',function(e){
					var url = $(this).attr('href');
					var parser = url_query(url, 'k');

					if( !parser ){
						var newwindow = window.open(url,'print pdf','height=700,width=900');
						if (window.focus) {newwindow.focus()}
						return false;
					}
					//e.preventDefault();
				});
			}
		};
	}();
	var imgListLazy = function(){
		return {
			init:function(){
			  $("div.lazy-list").lazyload({
				  effect : "fadeIn",
				  threshold : 200
			  });
			}
		};
	}();
	$(window).load(function(){
		sharePop.init();
		printPdf.init();
		$('[data-toggle="tooltip"]').tooltip();
		$('.ajax-indicator').hide();
		//imgListLazy.init();
	});
})( jQuery );

