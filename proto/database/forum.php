<?php

	function getForumPostOwner($post){
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT owner FROM forum_post WHERE id = ?');
			$stmt->execute(array($post)); 
			return $stmt->fetch()['owner'];
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	

		
	}


	function getMainPostsWishlist($wishlistId){
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT forum_post.id, creation_date, message,authenticated_user.username AS owner, authenticated_user.profile_image AS img_owner
									FROM forum_post, authenticated_user
									WHERE wishlist = ? AND main_post IS NULL
										AND authenticated_user.id = forum_post.owner
									ORDER BY creation_date DESC');
			$stmt->execute(array($wishlistId)); 
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	

		
	}
	
	
	function getReplyPostsWishlist($wishlistId){
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT  forum_post.id, creation_date, message, authenticated_user.username AS owner, authenticated_user.profile_image AS img_owner, main_post
									FROM forum_post, authenticated_user
									WHERE wishlist = ? AND main_post IS NOT NULL
											AND authenticated_user.id = forum_post.owner
									ORDER BY creation_date DESC');
			$stmt->execute(array($wishlistId)); 
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	

		
	}
	
	
	function getReputationPost($post){
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT username, reputation
									FROM reputation, authenticated_user
									WHERE forum_post = ? AND authenticated_user.id = auth_user');
			$stmt->execute(array($post)); 
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	}
	
	
	function getCountReputationPost($post, $reputation){
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT COUNT(reputation)
									FROM reputation
									WHERE forum_post = ? AND reputation = ?');
			$stmt->execute(array($post, $reputation)); 
			return $stmt->fetch();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	}
	
	
	function addReputation($post, $user, $r){
		global $conn;
		
		removeReputation($post, $user);
		
		try {		
			$stmt = $conn->prepare('INSERT INTO reputation(auth_user, forum_post, reputation) VALUES(?,?,?)');
			$stmt->execute(array($user, $post, $r)); 
			$stmt->fetch();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}		
	}
	
	function removeReputation($post, $user){
		global $conn;
		try {
			
			
			$conn->beginTransaction();
				
				//delete notifications
				$deleteRatingNotification = $conn->prepare('DELETE FROM forum_post_rating_notification WHERE auth_user = ? AND forum_post = ? RETURNING notification');
				$deleteRatingNotification->execute(array($user, $post));
	
				$notId = $deleteRatingNotification->fetch()['notification'];
				var_dump($notId);
				
				$deletedNotification = $conn->prepare('DELETE FROM notification WHERE id = ?');
				$deletedNotification->execute(array($notId)); 
				$deletedNotification->fetch();

			
				$stmt = $conn->prepare('DELETE FROM reputation WHERE auth_user = ? AND forum_post = ?');
				$stmt->execute(array($user, $post)); 
				$stmt->fetch();
				

			$conn->commit();

		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	}
	
	
	
	function getReputationUserPost($post, $user){
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT reputation FROM reputation
									WHERE auth_user = ? AND forum_post = ?');
			$stmt->execute(array($user, $post)); 
			return $stmt->fetch();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	}

	
	function addPost($mainPost, $user, $msg, $wishlist, $date){
		global $conn;
		try {
			$stmt = $conn->prepare('INSERT INTO forum_post(creation_date, message, owner, wishlist, main_post) VALUES(?,?,?,?,?)');
			$stmt->execute(array($date, $msg, $user, $wishlist, $mainPost)); 
			return $stmt->fetch();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	}
	
	
	
?>