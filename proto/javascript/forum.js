$(document).ready(function() {
	
	
	//set comments height
	$('.post-content').outerHeight($('.post-content').parent().outerHeight());
	
	
	//textarea open
	var textarea = null;
	var isReplyFormVisible = false;
	
	$(document).on('click', '.forum-rate-positive', function(){
		var postId = $(this).closest('.forum-post').find('span.postId').text();
		var reputationDiv = $(this);
		var currentRep = $(this).text();

		
		$.ajax({
            type: "POST",
            url: "../api/forum/reputation.php",
			data: {post: postId, reputation: 1, action: 1, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
				location.reload();
				//$(reputationDiv).html('<span class="forumRateIcon forumRateIcon-up fa fa-thumbs-o-up fa-2x"></span> '+(1+currentRep*1));
				//$(reputationDiv).switchClass('unmarked','marked');
            },
            error: function(res, status){
				console.log(res);
				console.log(status);                
            }
        });

	});
	
	$(document).on('click', '.forum-rate-negative', function(){
		var postId = $(this).closest('.forum-post').find('span.postId').text();
		var reputationDiv = $(this);
		var currentRep = $(this).text();

		$.ajax({
            type: "POST",
            url: "../api/forum/reputation.php",
			data: {post: postId, reputation: 0, action: 1, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
				location.reload();
				//$(reputationDiv).html('<span class="forumRateIcon forumRateIcon-down fa fa-thumbs-o-down fa-2x"></span> '+(currentRep*1+1));
				//$(reputationDiv).switchClass('unmarked','marked');
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });

	});
	
	var replyFormOriginal = $('.forum-post-reply-form');
	
	$(document).on('click', '.option-reply', function(e){
		e.preventDefault();
        if(isReplyFormVisible) return;

		var postId = $(this).closest('.forum-post').find('span.postId').text();
		
		var parentDiv = $(this).closest('.forum-post');
		
		var replyForm = $(replyFormOriginal).clone();
		$(replyForm).show();
		$(replyForm).addClass('forum-post-reply ');
		$(replyForm).find('.option-comment').addClass('option-comment-reply');
		
		$(replyForm).insertAfter($(parentDiv));

        isReplyFormVisible = true;

	})
	
	
	$(document).on('click', '.forum-post-reply-form .option-cancel', function(e){
		e.preventDefault();
	
		var parentDiv = $(this).closest('.forum-post');

		$(parentDiv).remove();

        isReplyFormVisible = false;
	})
	
	$(document).on('click', '.forum-post-reply-form .option-comment.option-comment-reply', function(e){
		e.preventDefault();

		var parentDiv = $(this).closest('.forum-post');
		var postId = $(parentDiv).prev().find('span.postId').text();
		var wishlistId = $('.forum').find('span.wishlistId').text();
		console.log(postId);
		console.log(wishlistId);

		var text = $(parentDiv).find('textarea').val();
		console.log(text);
        if(text == "") {
            return;
        }
		
		
		$.ajax({
            type: "POST",
            url: "../api/forum/comment.php",
			data: {mainPost: postId, wishlist: wishlistId, msg: text, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
                isReplyFormVisible = false;
                location.reload();
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });

	})
	
	
	$(document).on('click', '.option-add-main', function(e){
		e.preventDefault();
		if(isReplyFormVisible) return;
		
		var forum = $('.forum');
		
		var replyForm = $(replyFormOriginal).clone();
		$(replyForm).removeAttr('hidden');
		$(replyForm).find('.option-comment').addClass('option-comment-main');
		
		$('.forum').find('.group-posts').first().parent().prepend($(replyForm));
        isReplyFormVisible = true;

	})
	
	

	$(document).on('click', '.forum-post-reply-form .option-comment.option-comment-main', function(e){
		e.preventDefault();

		var forum = $('.forum');
		var wishlistId = $(forum).find('span.wishlistId').text();
		console.log(wishlistId);
		
		var parentDiv = $(this).closest('.forum-post');
		var text = $(parentDiv).find('textarea').val();
		if(text == "") return;
        console.log(text);
		
		
		$.ajax({
            type: "POST",
            url: "../api/forum/comment.php",
			data: {wishlist: wishlistId, msg: text, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
                isReplyFormVisible = false;
                location.reload();
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });

	})
	
	
	$(document).on('click', '.option-hide', function(e){
		e.preventDefault();
	
		$(this).closest('.group-posts').find('.forum-post-reply').hide();
		$(this).closest('.group-posts').find('hr').hide();
		$(this).switchClass('option-hide', 'option-show');
		$(this).text('show replies ('+$(this).prev('span').text()+')');

	})
	
	$(document).on('click', '.option-show', function(e){
		e.preventDefault();
	
		$(this).closest('.group-posts').find('.forum-post-reply').show();
		$(this).closest('.group-posts').find('hr').show();
		$(this).switchClass('option-show', 'option-hide');
		$(this).text('hide replies');

	})
	
	
	
});