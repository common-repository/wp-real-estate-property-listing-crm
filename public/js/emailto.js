(function( $ ) {
	'use strict';

	var SendToFriend = function () {
		return {
			init:function(){
				$('.sendtofriend').text("Send").attr("disabled", false);
				$('.closemodal').attr("disabled", false);
				$('.frm_send_link_mail').on('submit',function(){
					var data = $(this).serializeArray();

					data.push({name: 'action', value: 'sendtofriend_action'});
					data.push({name: 'security', value: MDAjax.security});

					$('.sendtofriend-alert').removeClass('alert-success alert-danger');

					$('.sendtofriend').text("Processing..").attr("disabled", true);
					$('.closemodal').attr("disabled", true);
					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						if( data.status ){
							$('.sendtofriend-alert').removeClass('hide alert-danger').addClass('alert-success').html(data.msg);
							setTimeout(function(){
								$('.send-to-friend-modal').modal('hide');
								location.reload(true);
							},2000);
						}else{
							$('.sendtofriend-alert').removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						$('.sendtofriend').text("Send").attr("disabled", false);
						$('.closemodal').attr("disabled", false);
					});

					return false;
				});
			}
		};
	}();

	$(window).load(function(){
		$(document).on("click", ".send-to-friend", function(e) {
			var property_address = $(this).data('property-address');
			var property_url = $(this).data('property-url');

			$('.send-to-friend-modal').modal('show');
			$('.send-to-friend-modal').on('shown.bs.modal', function (e) {
				$('.send-to-friend-modal #url').val(property_url);
				var localize_mail_msg = MDAjax.email_to_msg;
				$('.send-to-friend-modal #message').val(localize_mail_msg + ' ' + property_address);
				/*console.log(property_url);
				console.log(property_address);*/
			});
			e.preventDefault();
		});
		SendToFriend.init();
	});

})( jQuery );

