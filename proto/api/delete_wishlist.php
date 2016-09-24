<?php
	include_once('../config/init.php');
	include_once($BASE_DIR .'database/wishlists.php');  
	
	
	if (!isset($_SESSION['username']) || !isset($_SESSION['userId'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['id']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}
	
	
	$id = 0 + $_POST['id'];
	
	// Credential Verification	
	$userId = getUserId($_SESSION['username']);

	$existing_wishlist = getWishlistHeader($id);
	
	if ($existing_wishlist == false) {
		http_response_code(404);
		exit('Wishlist not found.');
	}
	
	if ($existing_wishlist['owner'] !== $userId) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	// Delete wishlist
	deleteWishlist($id);
	http_response_code(200);
?>