$(document).ready(function() {
	
/*
	 $(document).ajaxStart(function () {
        $("html").css("cursor", "wait");
    }).ajaxStop(function () {
        $("html").css( 'cursor', 'default' );
    });
	*/
	
	$('a').removeClass('active-menu');
	var selectedOption = 'a.'+getUrlParameter('section');
	
	$(selectedOption).addClass('active-menu');
	
	
	function getUrlParameter(sParam)
	{
		var sPageURL = window.location.search.substring(1);
		var sURLVariables = sPageURL.split('&');
		for (var i = 0; i < sURLVariables.length; i++) 
		{
			var sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam) 
			{
				return sParameterName[1];
			}
		}
	}       
	
	
	$(document).on('click', 'a.mark-resolved',function(e){
		e.preventDefault();
		var hrefParent = $(this).parent();
		var report = $(hrefParent).parent().attr('id');
		var href = $(this);
		

		$.ajax({
            type: "POST",
            url: "../api/admin/resolve_report.php",
			data: {reportId: report, resolve: 1, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
				$(href).remove();
				$(hrefParent).html(res+' <a href="" class="unmark-resolved"><i class="fa fa-close"></i></a>');
				$(hrefParent).parent().removeClass('warning');
				var unresolved = $('.warning').length;
				if(unresolved > 0)
				{
					$('.panel-heading>small').text('('+unresolved+' unresolved)');
					$('.panel-heading>small').show();
				}
				else $('.panel-heading>small').hide();
				
				$('#not-report span').text(unresolved);
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });
	})
		
	$(document).on('click', 'a.unmark-resolved',function(e){
		e.preventDefault();
		var hrefParent = $(this).parent();
		var report = $(hrefParent).parent().attr('id');
		var href = $(this);

		$.ajax({
            type: "POST",
            url: "../api/admin/resolve_report.php",
			data: {reportId: report, resolve: 0, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
				$(href).remove();
				$(hrefParent).html('<a href="" class="mark-resolved">Mark as resolved</a>');
				$(hrefParent).parent().addClass('warning');
				var unresolved = $('.warning').length;
				if(unresolved > 0)
				{
					$('.panel-heading>small').text('('+unresolved+' unresolved)');
					$('.panel-heading>small').show();
				}
				else $('.panel-heading>small').hide();
				
				$('#not-report span').text(unresolved);
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });
		
	})
	
	
	
	$('a.ban-user').on('click', function(e){
		e.preventDefault();
		var hrefParent = $(this).closest('td');
		var reported_user_id = $(hrefParent).parent().find('td.reportedUser>span.reported-userId').text();
		var reported_username = $(hrefParent).parent().find('td.reportedUser').text().substring(reported_user_id.length);
		var href = $(this);

		$.ajax({
            type: "POST",
            url: "../api/admin/banUser.php",
			data: {banId: reported_user_id, banUsername: reported_username, ban: 1, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
				console.log(res);
				var li = $(href).parent('li');
				$(href).remove();
				$(li).html('User banned');
				$(li).css('color','red');
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });
	})
	
	$('a.unban-user').on('click', function(e){
		e.preventDefault();
		var hrefParent = $(this).closest('td');
		var reported_user_id = $(hrefParent).parent().find('td.reportedUser>span.reported-userId').text();
		var reported_username = $(hrefParent).parent().find('td.reportedUser').text().substring(reported_user_id.length);
		var href = $(this);

		$.ajax({
            type: "POST",
            url: "../api/admin/banUser.php",
			data: {banId: reported_user_id, banUsername: reported_username, ban: 0, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
				console.log(res);
				var li = $(href).parent('li');
				$(href).remove();
				$(li).html('<a href="" class="ban-user">Ban user</a>');
				
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });
	})
	
	
	$(document).on('click', 'a.mark-seen',function(e){
		e.preventDefault();
		var hrefParent = $(this).parent();
		var msg = $(hrefParent).parent().attr('id');
		var href = $(this);
		

		$.ajax({
            type: "POST",
            url: "../api/admin/see_support_msg.php",
			data: {msgId: msg, see: true, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
				$(href).remove();
				$(hrefParent).html('<a href="" class="mark-unseen">Mark as unseen</a>');
				$(hrefParent).parent().removeClass('warning');
				var unresolved = $('.warning').length;
				var unseen = $('.warning').length;
				if(unseen > 0)
				{
					$('.panel-heading small').text('('+unseen+' not seen)');
					$('.panel-heading small').show();
				}
				else $('.panel-heading small').hide();
				
				$('#not-msg span').text(unseen);
				
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });
	})
		
	$(document).on('click', 'a.mark-unseen',function(e){
		e.preventDefault();
		var hrefParent = $(this).parent();
		var msg = $(hrefParent).parent().attr('id');
		var href = $(this);

		$.ajax({
            type: "POST",
            url: "../api/admin/see_support_msg.php",
			data: {msgId: msg, see: false, csrf_token:getContentByMetaTagName("token")},
            success: function(res, status){
				$(href).remove();
				$(hrefParent).html('<a href="" class="mark-seen">Mark as seen</i></a>');
				$(hrefParent).parent().addClass('warning');
				var unseen = $('.warning').length;
				if(unseen > 0)
				{
					$('.panel-heading small').text('('+unseen+' not seen)');
					$('.panel-heading small').show();
				}
				else $('.panel-heading small').hide();
				
				$('#not-msg span').text(unseen);
            },
            error: function(res, status){
				console.log(res);
				console.log(status);
                
            }
        });
		
	})
	
	
	
});