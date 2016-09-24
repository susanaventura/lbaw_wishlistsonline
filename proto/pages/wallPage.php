<?php
	include_once('../config/init.php');
	include_once('../config/util_functions.php');
	include_once('../database/admin.php');
	include_once('../database/users.php');
	include_once('../database/chat.php');
	include_once('../database/wall.php');
	include_once('../database/forum.php');
	include_once('../actions/load_wall_content.php');
	 
	if(!isset($_SESSION['username']) || !isset($_SESSION['userId']))
	{
		header('Location: '.$BASE_URL.'pages/homepage.php'); exit;
	}
	$currentUser = $_SESSION['userId'];
	 
	$wallContent = getFeed($_SESSION['userId'], date('Y-m-d H:i:s'), 4, '<');
	//printf("<pre>%s</pre>", json_encode($wall, JSON_PRETTY_PRINT));
	 
	/* include templates */

	$smarty->assign('username', $_SESSION['username']);
	$smarty->assign('userId', $_SESSION['userId']);
	include_once("../templates/common/head.html");
	
	$smarty->assign('admin', isUserAdmin($_SESSION['username']));
	include_once("../api/getFriendReqNotifications.php");
	
  $userinfo = getUserInfo($_SESSION['username']);
	$smarty->assign('userinfo', $userinfo);
	
	$smarty->display('main_template/main_col_left.tpl');
	
	$rows = getRows($wallContent);
	
	foreach($rows as $i=>$row) {
		$rows[$i]['canSharePassword'] =  false;
	}
	$smarty->assign('rows', $rows);
	$smarty->display('../templates/wishlist/feed_wishlist.tpl');
	
	$smarty->assign('chatUsers', getOnlineFriends($currentUser));
	$smarty->display('../templates/main_template/chat/chatList.tpl');
	
	include_once("../templates/common/footer.html");
	
?>