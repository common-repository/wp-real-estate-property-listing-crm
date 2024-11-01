(function( $ ) {
	'use strict';
	var ajax_process = MDAjax.lang_register_ajx_pls_wait_msg;
	var ajax_btn_signup = MDAjax.lang_register_btn_signup;
	var ajax_btn_login = MDAjax.lang_register_btn_login;
	var ajax_send_msg = MDAjax.lang_register_ajx_send_msg;

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

	var LoginForm = function () {
		return {
			init:function(){
				//$('.login-form')[0].reset();
				$('.modal-login').text("Login").attr("disabled", false);
				$('.login-form').on('submit',function(){
					var data = jQuery(this).serializeArray();
					var finish = 1;
					data.push({name: 'action', value: 'login_action'});
					data.push({name: 'security', value: MDAjax.security});

					$('.register-login-alert').removeClass('alert-success alert-danger');
					$('.register-login-alert').html('');
					$('.modal-login').text(ajax_process + "...").attr("disabled", true);
					$('.closemodal').attr("disabled", true);

					jQuery.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						$('.register-login-alert').html( data.msg );
						if( data.status ){
							$('.register-login-alert').removeClass('hide alert-danger').addClass('alert-success').html(data.msg);
							if( data.callback_action != 0 ){
								var data_callback = {
									action: data.callback_action,
									security: MDAjax.security,
									post_data: data.ret_data
								};
								jQuery.post(
									MDAjax.ajaxurl,
									data_callback,
									function(response){
										ReloadThis.init();
									}
								);
							}else{
								finish = 1;
							}
							ReloadThis.init();
						}else{
							$('.register-login-alert').removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						$('.modal-login').text(ajax_btn_login).attr("disabled", false);
						$('.closemodal').attr("disabled", false);
					});

					return false;
				});
			}
		};
	}();

	var RegisterForm = function () {

		return {
			init:function(){
				$('.register-form')[0].reset();
				$('.registersend').text(ajax_btn_signup).attr("disabled", false);
				$('.register-form').on('submit',function(){
					var data = jQuery(this).serializeArray();
					var finish = 1;
					data.push({name: 'action', value: 'signup_action'});
					data.push({name: 'security', value: MDAjax.security});

					$('.register-login-alert').removeClass('alert-success alert-danger');
					$('.registersend').text(ajax_process).attr("disabled", true);
					$('.closemodal').attr("disabled", true);
					var finish = 0;
					$.ajax({
						type: "POST",
						url: MDAjax.ajaxurl,
						data: data,
						dataType: "json"
					}).done(function( data ) {
						console.log(data);
						$('.register-login-alert').html( data.msg );
						if( data.status ){
							$('.register-login-alert').removeClass('hide alert-danger').addClass('alert-success').html(data.msg);
							if( data.callback_action != 0 ){
								var data_callback = {
									action: data.callback_action,
									security: MDAjax.security,
									post_data: data.ret_data
								};
								jQuery.post(
									MDAjax.ajaxurl,
									data_callback,
									function(response){
										ReloadThis.init();
									}
								);
							}else{
								finish = 1;
							}
							ReloadThis.init();
						}else{
							$('.register-login-alert').removeClass('hide alert-success').addClass('alert-danger').html(data.msg);
						}
						$('.registersend').text(ajax_btn_signup).attr("disabled", false);
						$('.closemodal').attr("disabled", false);
					});

					return false;
				});
			}
		};
	}();

	$(window).load(function(){
		if ( $('.register-form').length ) {
			RegisterForm.init();
		}
		if( $('.login-form').length ){
			LoginForm.init();
		}
	});

})( jQuery );

