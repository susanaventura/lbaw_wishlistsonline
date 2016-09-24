<?php
	include_once('../config/init.php');
	include_once('../database/wishlists.php');
	include_once('../database/admin.php');


	
	if(isset($_GET['pageOwner']))
	{
		$smarty->assign('username', $_SESSION['username']);
		$smarty->assign('userId', $_SESSION['userId']);
		$smarty->assign('admin', isUserAdmin($_SESSION['username']));
		$pageOwner_username = $_GET['pageOwner'];
	}


	
	$userWishlists = getUserWishlistsHeader($pageOwner_username);
	
	$pageOwnerId = getUserId($pageOwner_username);
	
	if($pageOwnerId != $_SESSION['userId']){
		
		//filter wishlists
		$isFriend = isFriend($pageOwnerId, $_SESSION['userId']);
		
		foreach($userWishlists as $elementKey => $element) {
			
			if(($element['privacy'] == 1 && !$isFriend) || $element['privacy'] == 0)
				unset($userWishlists[$elementKey]);
			

		}
		
	}
	
	
	
	
	$wishlistsPerPage = 6;
	$numberPages = count($userWishlists)/$wishlistsPerPage;
	

	if(isset($_GET['page']))
		$offset = ($_GET['page']-1)*$wishlistsPerPage;
	else $offset = 0;

	
	$userWishlistsSlice = array_slice($userWishlists, $offset, $wishlistsPerPage, true);

	if(isset($_GET['pageOwner']))
		$smarty->assign('page_owner', $_GET['pageOwner']);
	else $smarty->assign('page_owner', $_GET['username']);
	$smarty->assign('view_hidden', true);
	$smarty->assign('wishlists', $userWishlistsSlice);
	$smarty->assign('numberPages', $numberPages);
	$smarty->assign('items', array('empty'));
	$smarty->display('../templates/users/users_page/my_wishlists_list.tpl');

?>

