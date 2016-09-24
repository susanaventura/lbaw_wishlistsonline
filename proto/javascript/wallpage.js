$(document).ready(function() {
	
	//hide buttons on main col left
	$('#currentUserSocialOptions').remove();
	
	$(document).on('click', '.chkbox-mark-item', function(){
		var value;
		if($(this).is(':checked')) value = 1; else value = 0;
		var wishlistId = $(this).parent().find('.wishlist-id').text();
		var itemId = $(this).parent().find('.item-id').text();
		
		
		console.log(value);
		console.log(wishlistId);
		console.log(itemId);
		
		$.ajax({
				type: "POST",
				url: "../api/markItemToGive.php",
				data: {wishlistId:wishlistId, itemId: itemId, mark: value, csrf_token:getContentByMetaTagName("token")},
				success: function(status) {
					console.log(status);
				},
				error: function(res, status) {
					console.log(res);
					console.log(status);
							
					return false;
				}
			});
		
		
	})
	
	
	
	function getNewPostsFeed(){
        	
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
	

	$(document).find('#main_col > .row:last').attr('id', 'last-offset');
	$(document).find('#main_col> .row:first').attr('id', 'first-offset');
	
	var loadingMore = false;
	
	 function loadMore(where)
	 {
		var lastDate;
		var compare;
		if(where === 'before'){
			console.log('before1');
			lastDate =  $(document).find('#main_col > .row:first .header_date').text();
			compare = '>';
		} 
		else if(where === 'after') {
			console.log('after1');
			lastDate =  $(document).find('#main_col > .row:last .header_date').text();
			compare = '<';
		}
		
		loadingMore = true;
		
		
		
		$.ajax({
				type: "POST",
				url: "../actions/refresh_wall_content.php",
				data: {date: lastDate, compare: compare},
				success: function(res, status) {
					if(where === 'after'){
						console.log('after');
						$('#last-offset').removeAttr('id');
						$("#main_col").append($(res).children('.row')).fadeIn();
						$(document).find('#main_col > .row:last').attr('id', 'last-offset');
					}
					else if(where === 'before'){
						console.log('before');
						$('#first-offset').removeAttr('id');
						$("#main_col").prepend($(res).children('.row')).fadeIn();
						$(document).find('#main_col> .row:first').attr('id', 'first-offset');
					
					}
					
					loadingMore = false;
					$("html").css( 'cursor', 'default' );
				},
				error: function(res, status) {
					console.log(res);
					console.log(status);
					loadingMore = false;
					$("html").css( 'cursor', 'default' );
					return false;
				}
			});
	 }

	 
/*
	if(document.getElementById('last-offset') != null){
		new Waypoint({
		  element: document.getElementById('last-offset'),
		  handler: function(direction) {
		   console.log('coiso');
			if(direction == 'down') {
				console.log('down');
				loadMore('after');
			}
		  },
		  offset: 'bottom-in-view'
		})
	}
*/
	if(document.getElementById('first-offset') != null){	
		new Waypoint({
		  element: document.getElementById('first-offset'),
		  handler: function(direction) {
		   
			if(direction == 'up') {
				console.log('up');
				$("html").css("cursor", "wait");
				loadMore('before');
			}
			
		  },
		  offset: '5%'
		})
	}
	
$(window).scroll(function() {
	
	console.log($(window).scrollTop() + $(window).height());
	console.log($(document).height()*0.7);
	
   if($(window).scrollTop() + $(window).height() >= $(document).height()*0.5) {
     console.log('down');
	 if(!loadingMore) loadMore('after');
   }
   
   
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
			 $("html").css("cursor", "wait");
		}
   
});
	
	
});