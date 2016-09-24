<?
	include_once('../../config/init.php');
	include_once('../../database/social.php');
	include_once('../../database/chat.php');
	
	if (!isset($_SESSION['userId'])) {
		http_response_code(401);		
		exit('User not logged in!');
	}
	
	if (!isset($_POST['receiver']) || !isset($_POST['message']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {				
		http_response_code(400);		
		exit('Invalid Request!');
	}
	
	if (strlen($_POST['message']) > 500) {
		http_response_code(403);		
		exit('Message excedes size limit!');
	}
	
	$author = $_SESSION['userId'];
	$receiver = getUserId($_POST['receiver']);
	
	if (!isFriend($author, $receiver)) {
		http_response_code(401);
		exit('Receiver not a friend!');
	}
	
	include_once('../../lib/owasp-esapi-php/init.php');
	$message = makeSafe(substr($_POST['message'], 0, 500));
	
	sendChatMessage($author, $receiver, $message);	
?>