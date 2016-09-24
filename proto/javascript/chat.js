
var receiverMsg;
var currentUser = $('#left_col').find('.currentUser').text();

var chat_index_refresh = 0;


function refreshChatMessages() {
	
		chatboxtitle = chatBoxes[chat_index_refresh];

		//console.log('title:' + chatboxtitle);
		if (typeof chatboxtitle == 'undefined') return;
		
		$.ajax({
			type: "POST",
			url: "../api/chat/chat_get.php",
			async: true,
			cache: false,
			timeout:50000, /* Timeout in ms */
			data: {
				"other": chatboxtitle
			},
			success: function(res, status){
				//console.log('title res:' + chatboxtitle);
				res = jQuery.parseJSON(res);
				res.messages.sort(function(a,b) { return a.id - b.id;});
				$("#chatBox").empty();
				$("#chatbox_"+chatboxtitle+" .chatboxcontent").empty();
				for(var i = 0; i < res.messages.length; i++) {
					var message = res.messages[i];	
					
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagedate">'+"["+message.date+"] " + ':&nbsp;&nbsp;</span><div class="chatboxmessage"><span class="chatboxmessagefrom">'+res[message.author]+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message.message+'</span></div>');
					
					//scrollDown
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
				}
				
				chat_index_refresh++;
				if(chat_index_refresh == chatBoxes.length) chat_index_refresh = 0;
				chatboxtitle = chatBoxes[chat_index_refresh];
			},
			error: function(res, status){
				location.reload();
				//console.log(res);
				//console.log(status);
			}
		});	
	}


function sendChatMessage(message) {
	$.ajax({
        type: "POST",
        url: "../api/chat/chat_send.php",
        async: true,
        cache: false,
        timeout:5000, /* Timeout in ms */
		data: {
			"receiver": receiverMsg,
			"message": message,
			csrf_token: getContentByMetaTagName("token")
		},
        success: function(res, status){
        },
        error: function(res, status){
			//console.log(res);
			//console.log(status);
        }
    });
}


$(document).ready(function(){
	
	
	$('#inputSendMessageText').keyup(function(e) {
		if (e.keyCode == 13) $(this).trigger("enterKey");
	});
	
	$('#inputSendMessageText').on('enterKey', function(){		
		sendChatMessage($(this).val());
		$(this).val('');
		refreshChatMessages();
	});
	
	$('#inputSendMessageButton').on('click', function(){		
		sendChatMessage($('#inputSendMessageText').val());
		$('#inputSendMessageText').val('');
		refreshChatMessages();
	});
	

	$(document).on('click', '.username-chat', function(e){
		e.preventDefault();
		receiverMsg = $(this).text();
		chatWith(receiverMsg);
		
		
	});
	
	refreshChatMessages();
	setInterval(function() {
		refreshChatMessages();
		//console.log("refresh");
		}, 3000);
	
	$(document).on('focus',".chatboxtextarea",function(){
		var n = $(this).closest('.chatbox').attr('id').substring(8);
		receiverMsg = n;
	});

	
});
