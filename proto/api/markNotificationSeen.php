<?
	include_once('../config/init.php');
	include_once('../database/notifications.php');

	if (!(isset($_POST['id']))) {
				
		http_response_code(400);		
		exit('Missing Parameters!');
	}
	
	$notificationId = $_POST['id'];
	markNotificationAsSeen($notificationId);
	
?>