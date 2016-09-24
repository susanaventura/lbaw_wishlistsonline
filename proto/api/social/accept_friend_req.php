<?

	include_once('../../config/init.php');
	include_once('../../database/social.php');

	
	if (!isset($_SESSION['username']) || !isset($_SESSION['userId'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['userId']) || !isset($_POST['notificationId']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}

	
	$otherUser = $_POST['userId'];
	$notification = $_POST['notificationId'];
	$date = date('Y-m-d H:i:se');
	$currentUser = $_SESSION['userId'];
	
	if(acceptFriend($otherUser, $currentUser, $notification)){
		//follow
		followUser($currentUser, $otherUser);
		followUser($otherUser, $currentUser);
		//send notification to new friend
		sendFriendRequestNotification($currentUser, $otherUser, $date);
	} else
		http_response_code(500);
	
	
?>