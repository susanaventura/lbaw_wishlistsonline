<?php
	include_once('../config/init.php');
	include_once($BASE_DIR .'database/wishlists.php');  
	include_once('../lib/owasp-esapi-php/init.php');
	
	
	
	
	if (!isset($_SESSION['username']) || !isset($_SESSION['userId'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['wishlist']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}
	

	$wishlist = json_decode($_POST['wishlist'], true);

	/*
		{
			"id" : 257,
			"title" : "This is a wishlist",
			"creationDate" : "2008-10-29 14:56:59", 
			"lastEditDate" : "2008-10-29 14:56:59",
			"privacy" : 0,
			"occasion" : 3
			"items" : [
				{
				"image" : null,
				"link" : null,
				"name" : "This is a wishlist item",
				"note" : "I want the pink one with blue dots",
				"price" : "10.00",
				"rating" : "4.5",
				"giver": 135
				}
			
			]
		}			
	*/
	
	// Parse values
	if (isset($wishlist['id'])) $id = 0+$wishlist['id']; else $id = 0;
	$maxLen = 128;
	$title = makeSafe(substr($wishlist['title'], 0, $maxLen));
	$privacy = 0 + $wishlist['privacy'];
	$occasion = 0 + $wishlist['occasion'];
	
	$items = array();
	foreach($wishlist["items"] as $i) {
		$item = array();
		
		if(isset($i['image']))
      $item['image'] = makeSafe(substr($i['image'], 0, $maxLen)); 
		else
      $item['image'] ="";
    
		$item['link'] = makeSafe(substr($i['link'], 0, $maxLen));
		$item['name'] = makeSafe(substr($i['name'], 0, $maxLen));
		$item['note'] = makeSafe(substr($i['note'], 0, $maxLen));
		$item['price'] = 0 + $i['price'];
		$item['rating'] = 0 + $i['rating'];
		$item['giver'] = null;
		
		$items[] = $item;
	}
	
	// Credential Verification
	
	$userId = getUserId($_SESSION['username']);

	if ($id > 0) {
		$existing_wishlist = getWishlistHeader($id);
		if ($existing_wishlist['owner'] !== $userId) {
			http_response_code(403);
			exit('You do not have permission to do this.');
		}
	}
	
	// Create/Update wishlist
	$wid = saveWishlist($id, $userId, $privacy, $title, $occasion, $items);
	echo json_encode( array( 'id' => $wid) );
	http_response_code(200);
?>