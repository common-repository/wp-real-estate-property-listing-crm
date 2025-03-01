(function( $ ) {
	'use strict';

	var SendInquiryForm = function () {
		return {
			init:function(){
				var lang_inquire_send = MDAjax.lang_inquire_send;
				var lang_send_btn_txt = MDAjax.lang_send_btn_txt;
				$('.inquiry_form')[0].reset();
				$('.inquireform').text("Send").attr("disabled", false);
				$('.inquiry_form').on('submit',function(){
					var data = jQuery(this).serializeArray();

					data.push({name: 'action', value: 'inquireform_action'});
					data.push({name: 'security', value: MDAjax.security});

					$('.inquireform').text(lang_inquire_send + "...").attr("disabled", true);
					$('.ajax-msg').html("");
					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						$('.ajax-msg').html( data.msg ).fadeOut('5000');
						if( data.status ){
							console.log('success');
						}else{
							console.log('fail');
						}
						$('.inquireform').text(lang_send_btn_txt).attr("disabled", false);
					});

					return false;
				});
			}
		};
	}();

	$(window).load(function(){
		if ( $('.inquiry_form').length ) {
			SendInquiryForm.init();
		}
	});

})( jQuery );

