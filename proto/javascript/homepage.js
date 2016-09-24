

$(document).ready(function() {
	
	
	/** toggle between login and register **/
	$( "#loginSignup" ).load( "../templates/homepage/login.html" );
	$("#loginSignup").on('click','#login-form #btn-get-registered', function () {
		$( "#loginSignup" ).load( "../templates/homepage/signup.html" );
	});
	$("#loginSignup").on('click','#registration-form #btn-go-login', function () {
		$( "#loginSignup" ).load( "../templates/homepage/login.html" );
	
	});

	
	/** Modal **/
	function showInformationDialog(title, body, actionOnClose){
	
		var dialog = document.getElementById("modal");
		$(dialog).find("#yesBtn").remove();
		$(dialog).find("#noBtn").text("Okay");
		$( "#confirmation" ).text( body );
		$('#modal .modal-title').text(title);
		
		if(actionOnClose === "reload"){
			$(dialog).find("#noBtn").on('click', function(){
				location.reload();
			});
		}
		
		
		$(dialog).modal('show');
	
	
	}

	

	/************************************************************/
	/********************** Login *******************************/
	/************************************************************/
	$("#loginSignup").on('click','#login-form #btn-login', function () {

		$.ajax({
			type: "POST",
			url: "../api/login.php",
			//url: "test.php",
			data: {	username :  $('#login-form input[name=username]').val(),
					password :  $('#login-form input[name=password]').val(),
				},
			success: function (res){
				console.log(res);
						
				correctUser();
				correctPsw();
				
				$('#login-inactive-warning').hide();	
				window.location.replace("../pages/wallPage.php");
				
				
			},
			error: function(res, status) {
				console.log(res);
				console.log(status);
				if(res.responseText==='Invalid Username'){
					resetPsw();
					wrongUser();
					$('#login-inactive-warning').hide();
				}
				else if(res.responseText==='Invalid Password'){
					correctUser();
					wrongPsw();
					$('#login-inactive-warning').hide();
				}
				else if(res.responseText==='inactive account'){
					correctUser();
					correctPsw();
					
					$('#login-inactive-warning').show();
					
				}				
				return false;
			}
		});
	});
	
	function correctUser(){
		$('.span-error').remove();
		
		$('#login-username').removeClass('has-error');
		$('#login-username').addClass('has-success has-feedback');
		
		$('<span class="glyphicon glyphicon-ok form-control-feedback span-success" aria-hidden="true"></span>').insertAfter('input[name=username]');
		
	}
	
	function correctPsw(){
		$('.span-error').remove();
		
		$('#login-password').removeClass('has-error');
		$('#login-password').addClass('has-success has-feedback');
		
		$('<span class="glyphicon glyphicon-ok form-control-feedback span-success" aria-hidden="true"></span>').insertAfter('input[name=password]');
		
	}
		
	function wrongUser(){
		$('.span-success').remove();
		
		$('#login-username').removeClass('has-success');
		$('#login-username').addClass('has-error has-feedback');
		
		$('<span class="glyphicon glyphicon-remove form-control-feedback span-error" aria-hidden="true"></span>').insertAfter('input[name=username]');
	}
	
	function wrongPsw(){
		$('.span-success').remove();
		
		$('#login-password').removeClass('has-success');
		$('#login-password').addClass('has-error has-feedback');
		
		$('<span class="glyphicon glyphicon-remove form-control-feedback span-error" aria-hidden="true"></span>').insertAfter('input[name=password]');
		
	}
	
	function resetPsw(){
		$('.span-success').remove();
		$('.span-error').remove();
		$('#login-password').removeClass('has-success has-feedback has-error');
		$('#login-form input[name=password]').val('');
	}

	
	
	
	/************************************************************/
	/********************** Sign up *****************************/
	/************************************************************/	
	

	$("#loginSignup").on('click','#registration-form #btn-signup',function () {

		//before send request, check requirements
		var emptyInput = $("input").filter(function () {return $.trim($(this).val()).length == 0});	
		var gender_chk = $("input:radio[name='gender']").is(":checked");
		var country_chk = ($('#input-signup-country').val() !== "");
		
		//assume all ok
		$("#group-gender").removeClass('has-feedback has-error has-warning has-success');
		$("#group-gender").addClass('has-feedback has-success');
		$("#group-gender").find('span.form-control-feedback').remove();
		$("#group-gender").append('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
		
		$("input, select").each(function(){
			if($(this).attr('type') !== 'radio' && $(this).attr('id')!=='btn-signup')
				addSuccessToInput($(this));
		});
		
		
		//show error on empty inputs
		if (emptyInput.length > 0 || !gender_chk || !country_chk){ 
			
			if(!gender_chk){
				$("#group-gender").switchClass('has-success has-warning', 'has-error');
				$("#group-gender span.form-control-feedback").switchClass('glyphicon-ok','glyphicon-remove');
			}
			
			if(!country_chk) addErrorToInput($('#input-signup-country'), null, null);
			
			emptyInput.each(function() {	
				addErrorToInput($(this), null, null);
			});
			
			$('#signup-required-warning').show();
			return;


		} else{ //no empty inputs

			//check password confirmation
			if( $('#input-signup-password').val() !==  $('#input-signup-password-confirm').val())
				addErrorToInput($("#input-signup-password-confirm"), null, 'Password confirmation must match password');
			else{
		
				$.ajax({
					type: "POST",
					url: "../api/register.php",
					data: { firstname : $('#input-signup-firstname').val(),
							lastname : $('#input-signup-lastname').val(),
							birthdate :  $('#input-signup-birth').val(),
							email : $('#input-signup-email').val(),
							gender : $('#registration-form input[name=gender]:checked').val(),
							password :  $('#input-signup-password').val(),
							username :  $('#input-signup-username').val(),
							country : $('#registration-form select[name=country]').val(),
						  },
					success: function (){
						
						showInformationDialog('Thank you!', "Thank you for register! We sent you an email so you can confirm your account. If you don't receive any email from us shortly, please check your spam folder.", 'reload');
						
					},
					error: function(res, status) {
						console.log(res);
						console.log(status);
						
						//Check formats
						var json_response = jQuery.parseJSON(res.responseText);
						
						//warn user about format errors
						var type = json_response[0];
						//var items = json_response[1];
						console.log(type);
						
						for(var i = 1; i < json_response.length; i++) {
							var item = json_response[i];
							console.log(item);
							$.each(item, function(key, value){
								if(type === 'errors')
									addErrorToInput($('#input-signup-'+key), value.reason, value.help);
								else if (type === 'warnings')
									addWarningToInput($('#input-signup-'+key), value.reason, value.help);
							
							});
						}
						
						return false;
					}	
				});
			}
		}
	});


	function addWarningToInput(inputElem, warning, help){
		
		if(inputElem.parent().find('span.form-control-feedback').hasClass('glyphicon-warning-sign')) return;
		
		inputElem.parent().removeClass('has-feedback');
		inputElem.parent().addClass('has-feedback');
		
		inputElem.parent().switchClass('has-success has-error','has-warning');
		
		inputElem.parent().find('span.form-control-feedback').remove();
		$('<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>').insertAfter(inputElem);
		
		if(warning !== null){
			inputElem.parent().find('label').remove();
			$('<label class="control-label" for="'+inputElem.attr('id')+'">'+warning+'</label>').insertBefore(inputElem);
		}
		
		if(help !== null){
			inputElem.parent().find('span.help-block').remove();
			$('<span class="help-block">'+help+'</span>').insertAfter(inputElem);
		}
		
		
	}
	
	
	function addErrorToInput(inputElem, error, help){
		if(inputElem.parent().find('span.form-control-feedback').hasClass('glyphicon-remove')) return;
		
		inputElem.parent().removeClass('has-feedback');
		inputElem.parent().addClass('has-feedback');
		
		inputElem.parent().switchClass('has-success has-warning','has-error');
		
		inputElem.parent().find('span.form-control-feedback').remove();
		$('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>').insertAfter(inputElem);
		
		if(error !== null){
			inputElem.parent().find('label').remove();
			$('<label class="control-label" for="'+inputElem.attr('id')+'">'+error+'</label>').insertBefore(inputElem);
		}
		
		if(help !== null){
			inputElem.parent().find('span.help-block').remove();
			$('<span class="help-block">'+help+'</span>').insertAfter(inputElem);
		}
		
		
	}
	
	
	function addSuccessToInput(inputElem){
		if(inputElem.parent().find('span.form-control-feedback').hasClass('glyphicon-ok')) return;
		
		inputElem.parent().removeClass('has-feedback');
		inputElem.parent().addClass('has-feedback');
		
		inputElem.parent().switchClass('has-error has-warning', 'has-success');

		inputElem.parent().find('label').remove();
		
		var last_piece_id = inputElem.attr('id').substring(13);
		
		if(last_piece_id === 'password-confirm') last_piece_id = 'password confirmation';
		
		$('<label>'+ last_piece_id +' <span class="text-danger">*</span></label>').insertBefore(inputElem);
		
		inputElem.parent().find('span.form-control-feedback').remove();
		$('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>').insertAfter(inputElem);
		
		
		inputElem.parent().find('span.help-block').remove();
		
		
	}

	/************************************************************/
	/********************** Psw recover *************************/
	/************************************************************/	
	function reloadCaptcha()
    {
        $('#captcha').prop('src', '../lib/securimage/securimage_show.php?sid=' + Math.random());
    }
	
	$(document).on('click','#pswRecover',function(e){
		e.preventDefault();
		
		var dialog = document.getElementById("modal");
		
		$(dialog).find("#yesBtn").hide();
		$(dialog).find("#noBtn").text("Recover");
		var noBtn = $(dialog).find("#noBtn").removeAttr('data-dismiss');
		$(dialog).find("#noBtn").removeAttr('aria-hidden');
		$('#confirmation').parent().load('../templates/homepage/password_recovery_modal.tpl');
		
		$('#modal .modal-title').text('Recover your password');
		

		$(noBtn).on('click', function(e){
			
			var mail = $('#input-modal-email').val();
			var code = $('#input-modal-captcha').val();

			jQuery.ajax({
				url: "../api/recover_password.php",
				type: 'POST',
				data: {captcha: code, email: mail},
				success: function (res){
					console.log(res);
					$('#captchaDiv').attr('hidden');
					$('#captcha-error').hide();
					$('#captcha-success').removeAttr('hidden');
					
					$(dialog).find("#yesBtn").text("Ok");
					$(dialog).find("#yesBtn").on('click', function(e){
						$(dialog).modal('hide');
						
					});
					
					$(dialog).find("#noBtn").remove();
					$(dialog).find("#yesBtn").show();
				},
				error: function(res, status) {
					console.log(res);
					reloadCaptcha();
					$('#captcha-error').html('<i class="fa fa-close"></i> '+ res['responseText']);
					$('#captcha-error').removeAttr('hidden');
					$('#captcha-success').attr('hidden');
					return false;
				}

			});
		});
		
		
		$(dialog).modal('show');

	});
	
});

	