	
<?php
	include_once('../config/init.php');
	include_once('../database/users.php');
	include_once('../database/chat.php');
	include_once('../database/admin.php');
	
	if(!isset($_SESSION['username']) || !isset($_SESSION['userId']))
	{
		header('Location: '.$BASE_URL.'pages/homepage.php'); exit;
	}
	$currentUser = $_SESSION['userId'];
	$pageOwner_username = $_GET['username'];

	
	include_once('../database/wishlists.php');
	

	/* include templates */
	
	include_once("../templates/common/head.html");
	$smarty->assign('username', $_SESSION['username']);
	$smarty->assign('userId', $_SESSION['userId']);
	$smarty->assign('admin', isUserAdmin($_SESSION['username']));
	include_once("../api/getFriendReqNotifications.php");

    $userinfo = getUserInfo($_SESSION['username']);
	$smarty->assign('userinfo', $userinfo);
	
	$smarty->display('main_template/main_col_left.tpl');
	
	$occasions = getWishlistsOccasions();
	$smarty->assign('occasions', $occasions);
	
	/* list users wishlists */	
	include_once('../api/list_user_wishlists.php');
	
	
	$smarty->assign('chatUsers', getOnlineFriends($currentUser));
	$smarty->display('../templates/main_template/chat/chatList.tpl');
	
	include_once("../templates/common/footer.html");
	
?>