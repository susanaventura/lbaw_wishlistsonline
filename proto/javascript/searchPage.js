$(document).ready(function(){
	$('a.report').on('click', function(e){
		e.preventDefault();
		var receiver = $(this).parent().first().find('span').text();
		var dialog = document.getElementById("modal");
		$(dialog).find("#yesBtn").text("Report");
		$(dialog).find("#noBtn").text("Cancel");
		$( "#confirmation" ).parent().load('../templates/users/report_user_form.tpl');
		$('#modal .modal-title').text('Report user');

		

		$(dialog).find("#yesBtn").on('click', function(){
			var msg = $(modal).find('textarea').val();
			if(msg.length > 0){

				
				$.ajax({
				type: "POST",
				url: "../api/social/report_user.php",
				data: {'userId':receiver, 'message': msg },
				success: function (res, status){
					location.reload(true);
				},
				error: function(res, status) {
					console.log(res);
					console.log(status);
							
					return false;
				}
				});
			
		
			}
		});
		$(dialog).modal('show');
		
	});
	
	
	$('a.add_friend').on('click', function(){

		var receiver = $(this).parent().first().find('span').text();
	
		$.ajax({
				type: "POST",
				url: "../api/social/send_friend_req.php",
				data: {'userId':receiver, csrf_token:getContentByMetaTagName("token")},
				success: function (res, status){
					location.reload(true);
				},
				error: function(res, status) {
					console.log(res);
					console.log(status);
							
					return false;
				}
			});
	});
	
	
	$('a.remove_friend').on('click', function(){

		var receiver = $(this).parent().first().find('span').text();
	
		$.ajax({
				type: "POST",
				url: "../api/social/remove_friend.php",
				data: {'userId':receiver, csrf_token:getContentByMetaTagName("token") },
				success: function (res, status){
					location.reload(true);
				},
				error: function(res, status) {
					console.log(res);
					console.log(status);
							
					return false;
				}
			});
	});
	
	
	$('a.follow_user').on('click', function(){

		var receiver = $(this).parent().first().find('span').text();
	
		$.ajax({
				type: "POST",
				url: "../api/social/follow_unfollow.php",
				data: {'userId':receiver, 'follow':true, csrf_token:getContentByMetaTagName("token") },
				success: function (res, status){
					location.reload(true);
				},
				error: function(res, status) {
					console.log(res);
					console.log(status);
							
					return false;
				}
			});
	});
	
	$('a.unfollow_user').on('click', function(){

		var receiver = $(this).parent().first().find('span').text();
	
		$.ajax({
				type: "POST",
				url: "../api/social/follow_unfollow.php",
				data: {'userId':receiver, 'follow':false, csrf_token:getContentByMetaTagName("token") },
				success: function (res, status){
					location.reload(true);
				},
				error: function(res, status) {
					console.log(res);
					console.log(status);
							
					return false;
				}
			});
	});
	
	

	
});