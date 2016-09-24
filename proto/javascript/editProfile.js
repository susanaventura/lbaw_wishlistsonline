
$(document).ready(function() 
{
	
	function addSuccessToInput(input){
		input.parent().removeClass('has-feedback');
		input.parent().addClass('has-feedback');
		
		input.parent().switchClass('has-error has-warning', 'has-success');

		input.parent().find('label').remove();
		
		input.parent().find('span.form-control-feedback').remove();
		$('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>').insertAfter(input);
		
		
		input.parent().find('span.help-block').remove();
	}
	
	function addErrorToInput(inputElem, error, help){
		if(inputElem.parent().find('span.form-control-feedback').hasClass('glyphicon-remove')){ return;}
		
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
	
	var firstTime = 1;
	$(document).on('click','#edit-profile-submit',function(e){ 
		e.preventDefault();
		
		//check requirements
		var emptyInput = $("input").filter(function () {return $.trim($(this).val()).length == 0;});	
		
		
		//assume all ok
		addSuccessToInput($('#input-editProfile-firstname'));
		addSuccessToInput($('#input-editProfile-lastname'));
		addSuccessToInput($('#input-editProfile-username'));
		addSuccessToInput($('#input-editProfile-email'));
		addSuccessToInput($('#input-editProfile-password'));
		addSuccessToInput($('#input-editProfile-confirm-password'));
		addSuccessToInput($('#input-editProfile-img'));
		$('#current-psw-confirm').hide();
		
		
		//check if psw is changing
		if ($('#input-editProfile-password').val().length > 0){ 
			
			if($('#input-editProfile-confirm-password').val() != $('#input-editProfile-password').val()){
				addErrorToInput($("#input-editProfile-confirm-password"), null, 'Password confirmation must match your new password');
				return;
			}
			

			
		} else if ($('#input-editProfile-confirm-password').val().length > 0){ 
			
			if($('#input-editProfile-password').val().length == 0){
				addErrorToInput($("#input-editProfile-password"), null, 'You must insert a password to match your password confirmation');
					return;
			}
		}


		var checkcurrentPsw = 0;
	  
	   if ($('#input-editProfile-password').val().length > 0)
	   {
		 
		   $('#current-psw-confirm').show();
		   if($('#input-editProfile-current_password').val().length > 0){
			checkcurrentPsw = 1;
}		else{  checkcurrentPsw = 0;}
	   }
		else{
			$('#current-psw-confirm').hide();
			checkcurrentPsw = 0;
		}
	   
	   var form = $('#edit-profile-form');
	   
	   
	   $.ajax({
				type: "POST",
				url: "../api/editProfile.php",
				data: { form: form.serialize(), check_current_psw: checkcurrentPsw, img: $('.dz-image').children('img').attr('alt'), csrf_token:getContentByMetaTagName("token")},
				success: function (res){
					if($('#input-editProfile-current_password').val().length > 0){
						addSuccessToInput($('#input-editProfile-current_password'));
}
					console.log(res);
					if(res === 'updated')
					{
						location.reload();
					}
					
				},
				error: function (res, status){
					console.log(res);
					console.log(status);
					//Check formats
					var json_response = jQuery.parseJSON(res.responseText);
					
					//warn user about format errors
					var type = json_response[0];
					//var items = json_response[1];
					console.log(type);
					var i;
					for(i = 1; i < json_response.length; i++) {
						var item = json_response[i];
						
						$.each(item, function(key, value){
							console.log(key);
							if(type === 'errors'){
								addErrorToInput($('#input-editProfile-'+key), value.reason, value.help);
}

						});
					}
					
				}
			});
				
	
	
	});
	
	
	
	$(document).on('click','#edit-profile-cancel',function(e){ 
		location.reload();
	});
	
	
	$(document).on('click', '#erase-account-link', function(e){
		var dialog = document.getElementById("modal");
		$(dialog).find("#yesBtn").text('Yes');
		$(dialog).find("#noBtn").text("No");
		$( "#confirmation" ).text( 'Do you really want to erase your account? All your wishlists will be lost. This action CANNOT be reversed!' );
		$('#modal .modal-title').text('Confirmation');
		
		
		$(dialog).find("#yesBtn").on('click', function(){
			 $.ajax({
				type: "POST",
				url: "../actions/erase_account.php",
				data: {csrf_token:getContentByMetaTagName("token")},
				success: function (res, status){
					$(dialog).modal("hide");
					window.location.replace("../pages/homepage.php");
				},
				error: function (res, status){
					console.log(res);
					console.log(status);
					
				}
			});
		});
		
		
		
		$(dialog).modal('show');
	});
	
	
  setupDropzoneProfile();
	
});

// add exists() function to $
$.fn.exists = function () {
    return this.length !== 0;
};


// Dropzone //
function setupDropzoneProfile(){
	
	Dropzone.autoDiscover = false;
	var i=0;
	
	$('.img-upload > .thumbnail').each(function () {
		++i;
		if($(this).children().size() == 0){
			
			var dropzoneItem = $("<form id=\"dropzone-form" + i +"\" action=\"../actions/uploadImage.php\"></form>");
			
			dropzoneItem.height(220);
			dropzoneItem.addClass("dropzone");
			dropzoneItem.width(210);
			$(this).append(dropzoneItem);
			var tempZone = dropzoneItem.dropzone({ url: "../actions/uploadImage.php?type=profile", thumbnailWidth: 210, thumbnailHeight: 220, maxFiles: 1, maxfilesexceeded: function(file) {this.removeAllFiles(); this.addFile(file);}});
      
      // If user has image //
      if($('#userHasImage').exists()){
       
        var img_location = '../images/profileImages/' + $('#userHasImage').attr('img');
        var thumb_location = '../images/profileImages/thumb_' + $('#userHasImage').attr('img');
        var file_to_add = { name: $('#userHasImage').attr('img'), size: 23456 };
        var myDropzone = tempZone[0].dropzone;
        
        $('#userHasImage').remove();
        
        // Call the default addedfile event handler
        myDropzone.emit("addedfile", file_to_add);

        // And optionally show the thumbnail of the file:
        myDropzone.emit("thumbnail", file_to_add, thumb_location);

        // Make sure that there is no progress bar, etc...
        myDropzone.emit("complete", file_to_add);
      
        $('.dz-image > img').css( 'width', '210px' );
        $('.dz-image > img').css( 'height', '220px' );
      
        myDropzone.on("addedfile", function(file) {
          var form = $('#dropzone-form1');
          if( form.children().size() == 3 ){
            form.children()[1].remove();
			}
        });
      
      }
      
		}
	});
	
}

