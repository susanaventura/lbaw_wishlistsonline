<?php
	include_once('users.php');
	include_once('social.php');

	
	function getWishlistOwnerUsername($id){
		global $conn;
		
		try {
			$stmt = $conn->prepare("SELECT username
									FROM wishlist, authenticated_user
									WHERE wishlist.id = ? AND wishlist.owner = authenticated_user.id");
			
			$stmt->execute(array($id));
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		return $stmt->fetch()['username'];
	}
	

	
	function getWishlistItems($id){
		global $conn;
		
		try {
			$stmt = $conn->prepare("SELECT id, wishlist, image, link, name, note, price, rating FROM wishlist_item WHERE wishlist = ? ORDER BY id ASC");
			
			$stmt->execute(array($id));
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		return $stmt->fetchAll();
		
	}
	
	
	function getWishlistItemGiver($itemId, $wishlist){
		global $conn;
		
		try {
			$stmt = $conn->prepare("SELECT username
									FROM wishlist_item, authenticated_user
									WHERE wishlist_item.id = ?
									AND wishlist_item.wishlist = ?
									AND authenticated_user.id = wishlist_item.giver");
			
			$stmt->execute(array($itemId, $wishlist));
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		return $stmt->fetch()['username'];
		
	}
	
	
	function getUserWishlistsHeader($username){
		global $conn;
		
		$userId = getUserId($username);
		
		try {
			$stmt = $conn->prepare("SELECT wishlist.*, username AS owner_username, authenticated_user.profile_image AS img_owner
									FROM wishlist, authenticated_user
									WHERE owner = ? AND authenticated_user.id = owner
									ORDER BY last_edit_date DESC"); //order by date
			
			$stmt->execute(array($userId));
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		return $stmt->fetchAll();
		
	}
	
	function getWishlistHeader($id){
		global $conn;

		try {
			$stmt = $conn->prepare("SELECT wishlist.*,authenticated_user.profile_image AS img_owner
                                    FROM wishlist, authenticated_user
                                    WHERE wishlist.id = ? AND authenticated_user.id = wishlist.owner");
			
			$stmt->execute(array($id));
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		return $stmt->fetch();		
	}
	
	function getWishlistsOccasions(){
		global $conn;
		
		try{
			$stmt = $conn->prepare("SELECT * FROM wishlist_occasion");
			$stmt->execute();
		}catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		return $stmt->fetchAll();
	}
	
	function getOccasionName($occasionId){
		global $conn;
		
		try{
			$stmt = $conn->prepare("SELECT occasion_name FROM wishlist_occasion WHERE id = ?");
			$stmt->execute(array($occasionId));
		}catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		return $stmt->fetch();
	}
	
	function randomStrGen($len) {
		$result = "";
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$charArray = str_split($chars);
		for($i = 0; $i < $len; $i++){
			$randItem = array_rand($charArray);
			$result .= "".$charArray[$randItem];
		}
		return $result;	
	}
	
	function saveWishlist($id, $owner, $privacy, $title, $occasion, $items) {
		global $conn;
		
		
		try {
			$new_wishlist = $conn->prepare("INSERT INTO Wishlist(owner,password,privacy,title,occasion) VALUES (?,?,?,?,?) RETURNING id;");
			$edit_wishlist = $conn->prepare("UPDATE Wishlist SET privacy=?, title=?, occasion=? WHERE id=?;");
			
			$delete_items = $conn->prepare("DELETE FROM Wishlist_Item WHERE wishlist=?;");
			$insert_item = $conn->prepare("INSERT INTO Wishlist_Item(id, wishlist, image, link, name, note, price, rating, giver) VALUES (?,?,?,?,?,?,?,?,?);");
			
			if ($id > 0) {
				$edit_wishlist->execute( array($privacy, $title, $occasion, $id) );
				if( $edit_wishlist->rowCount() < 1) return;
			} else {
				$new_wishlist->execute( array($owner, randomStrGen(8), $privacy, $title, $occasion) );
				$id = $new_wishlist->fetch()["id"];
			}
			
			$conn->beginTransaction();
				$delete_items->execute(array($id));
				$i = 0;
				foreach($items as $item) {
					$insert_item->execute(array($i, $id, $item["image"], $item["link"], $item["name"], $item["note"], $item["price"], $item["rating"], null));
					$i++;
				}			
			$conn->commit();
			
			return $id;
	
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
		return 0;
	}
	
	function deleteWishlist($id) {
		global $conn;
		
		try {
			$stmt = $conn->prepare("DELETE FROM wishlist WHERE id=?;");
			$stmt->execute( array($id) );
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
	}
	
	
	function getWishlistsHeaderSearch($searchInput){
		global $conn;
		
		try {
			$stmt = $conn->prepare("SELECT wishlist.*, username AS owner_username 
									FROM wishlist, authenticated_user
									WHERE wishlist.search_tsvector @@ plainto_tsquery(:input)
											AND authenticated_user.id = wishlist.owner
									ORDER BY last_edit_date DESC");
			$stmt->bindParam(':input', $searchInput);
			$stmt->execute();			
			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		return $stmt->fetchAll();		
	}
	
	
	
	function canViewWishlist($user, $owner, $privacy, $correctPassword) {
		if ($privacy == 2) return true;
		if ($privacy == 0) return ($user == $owner);
		
		return $user == $owner || $correctPassword || isFriend($user, $owner);	
	}


	function canMarkItem($user, $item, $wishlist){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare("SELECT giver
									FROM wishlist_item
									WHERE id=? AND wishlist = ?
									AND (giver IS NULL OR giver = ?);");
			$stmt->execute( array($item, $wishlist, $user) );
			return $stmt->fetchAll() !== false;
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
	}
	
	function markItem($giver, $item, $wishlist){
		global $conn;
		
		try {
			$stmt = $conn->prepare("UPDATE wishlist_item SET giver = ? WHERE wishlist = ? AND id = ?");
			$stmt->execute( array($giver, $wishlist, $item) );
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
	}
	
?>
