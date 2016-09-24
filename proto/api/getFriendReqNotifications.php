<?
	include_once('../config/init.php');
	include_once('../database/notifications.php');
	
	if (!isset($_SESSION['username']) || !isset($_SESSION['userId'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	
	$currentUser = $_SESSION['userId'];	
	
	$notifications = getFriendRequestsNotifications($currentUser);
	
	
	$smarty->assign('username', $_SESSION['username']);
	$smarty->assign('friend_notifications', $notifications);
	
	$smarty->display('../templates/common/top_navbar.tpl');
	
?>