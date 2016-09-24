
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
	
	/* include templates */

	$smarty->assign('username', $_SESSION['username']);
	$smarty->assign('userId', $_SESSION['userId']);
	include_once("../templates/common/head.html");
	
	$smarty->assign('admin', isUserAdmin($_SESSION['username']));
	include_once("../api/getFriendReqNotifications.php");
		
  $userinfo = getUserInfo($_SESSION['username']);
	$smarty->assign('userinfo', $userinfo);
  
	$smarty->display('main_template/main_col_left.tpl');
	

	$smarty->display('../templates/users/edit_profile.tpl');
	
	$smarty->assign('chatUsers', getOnlineFriends($currentUser));
	$smarty->display('../templates/main_template/chat/chatList.tpl');
	
	?><script type="text/javascript" src="../javascript/editProfile.js"></script> <?
	
	include_once("../templates/common/footer.html");
	

?>