<?php

	function reportWishlist($date, $reason, $author, $reported_wishlist){
		
	}
	
	function reportForumPost($date, $reason, $author, $reported_post){
		
	}
	
	function reportUser($date, $reason, $author, $reported_user){
		global $conn;
		
		
		try {
			$stmt = $conn->prepare('INSERT INTO report(date, reason, author, reported_user) VALUES(?,?,?,?)');

			
			$stmt->execute(array($date, $reason, $author, $reported_user));   
			return ($stmt->fetch() !== false);
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
	}
	
	function handleReport($admin, $report){
		//updates report adding the admin who handled it
	}
	
	function deleteReport($report){
		
	}

?>