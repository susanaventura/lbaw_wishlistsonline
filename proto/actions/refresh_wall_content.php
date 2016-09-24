<?
	include_once('../config/init.php');
	include_once('../database/wall.php');
	include_once('load_wall_content.php');
	
	
	$currentUser = $_SESSION['userId'];

	$date = $_POST['date'];
	$compare = $_POST['compare'];
	
	$newFeedContent = getFeed($_SESSION['userId'], $date, 4, $compare);
	
	$rows = getRows($newFeedContent);
	
	$smarty->assign('rows', $rows);
	$smarty->display('../templates/wishlist/feed_wishlist.tpl');
	
?>