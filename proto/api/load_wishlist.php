<?

	include_once('../config/init.php');
	include_once('../database/wishlists.php');
	
	$occasions = getWishlistsOccasions();
	$smarty->assign('occasions', $occasions);

	$wishlist = getWishlistHeader($_GET['id']);
	$items = getWishlistItems($_GET['id']);

	$smarty->assign('items', $items);
	$smarty->assign('wishlist', $wishlist);
	$smarty->assign('view_hidden', true);


	$smarty->assign('wishlistOccasionName', getOccasionName($wishlist['occasion'])['occasion_name']);
	
	if($_GET['view'] === "true")
		$smarty->display('../templates/wishlist/view_wishlist_template.tpl');
	else
		$smarty->display('../templates/wishlist/create_wishlists_template.tpl');
	

?>