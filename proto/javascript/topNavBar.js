$(document).ready(function(){
		
	$('#inputSearchUsers').keyup(function(e) {
		if (e.keyCode == 13) $(this).trigger("enterKey");
	});
	$('#inputSearchUsers').on('enterKey', function(){		
		var input = $(this).val();
		window.location.assign("../pages/searchPage.php?searchType=users&inputSearch="+input);
	});
	$('#inputSearchUsers+span>button').on('click', function(){		
		var input = $('#inputSearchUsers').val();		
		window.location.assign("../pages/searchPage.php?searchType=users&inputSearch="+input);
	});
		
	
	$('#inputSearchWishlists').keyup(function(e) {
		if (e.keyCode == 13) $(this).trigger("enterKey");
	});
	$('#inputSearchWishlists').on('enterKey', function(){		
		var input = $(this).val();
		window.location.assign("../pages/searchPage.php?searchType=wishlists&inputSearch="+input);
	});
	$('#inputSearchWishlists+span>button').on('click', function(){		
		var input = $('#inputSearchWishlists').val();		
		window.location.assign("../pages/searchPage.php?searchType=wishlists&inputSearch="+input);
	});
	
	
	$('#navbar-main-brand').on('click', function(){
		 window.location.assign("../pages/wallPage.php");
	});
	
	function verifyFriendReqNotifications(){
        	
		$.ajax({
            type: "POST",
            url: "../api/getFriendReqNotifications.php",
            async: true,
            cache: false,
            timeout:50000, /* Timeout in ms */
            success: function(res, status){

				$('#friend_req_not_link+ul').remove();

				var newContent = $(res).find('#friend_req_not_link+ul');
				$(newContent).insertAfter('#friend_req_not_link');

				$('#friend_req_not_link>span').text($('#friend_req_not_link+ul li.notification-not-seen').length);
	
                setTimeout(
                    verifyFriendReqNotifications,
                    60000
                );
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                setTimeout(
                    verifyFriendReqNotifications, /* Try again after.. */
                    120000); /* milliseconds (15seconds) */
            }
        });
    };
	
	verifyFriendReqNotifications();
	
	
	$(document).on('click', '.btn-mark-seen', function(){
		var notId = $(this).find('span').text();
		
		var li = $(this).closest("li");
		console.log($(li));
		
		var btn = $(this);
		
		$.ajax({
            type: "POST",
            url: "../api/markNotificationSeen.php",
			data: {id: notId},
            success: function(res, status){
				$(li).removeClass("notification-not-seen");
				$('#friend_req_not_link>span').text($('#friend_req_not_link+ul li.notification-not-seen').length);
				$(btn).attr("disabled", true);
				$(btn).val('Seen');
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });
	});
	
	
	$(document).on('click', '.btn-accept', function(){
		var senderId = $(this).find('span').text();
		var notId = $(this).next().find('span').text();
		
		var li = $(this).closest("li");
		console.log($(li));
		console.log("notId: "+notId);
		
		$.ajax({
            type: "POST",
            url: "../api/social/accept_friend_req.php",
			data: {notificationId: notId, userId: senderId, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
				$(li).removeClass("notification-not-seen");
				$('#friend_req_not_link>span').text($('#friend_req_not_link+ul li.notification-not-seen').length);
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });
	});

});

