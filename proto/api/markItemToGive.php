<?

	
	include_once('../config/init.php');
	include_once('../config/util_functions.php');
	include_once('../database/wishlists.php');

	
	$wishlistId = $_POST['wishlistId'];
	$itemId = $_POST['itemId'];
	$mark = $_POST['mark'];
	
	$wishlist = getWishlistHeader($wishlistId);

	
	//verify is user can see wishlist
	var_dump($_SESSION);
	if(!canViewWishlist($_SESSION['userId'],$wishlist['owner'], $wishlist['privacy'], true))
	{
		http_response_code(401);
		exit('User do not have permission to see the wishlist');
	}
	
	//verify if user can mark item
	if(!canMarkItem($_SESSION['userId'], $itemId, $wishlistId))
	{
		http_response_code(401);
		exit('User cannot mark item');
	}
	
	if($mark)
		markItem($_SESSION['userId'], $itemId, $wishlistId);
	
		
	else markItem(null, $itemId, $wishlistId);

	http_response_code(200);
?>