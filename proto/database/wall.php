<?php

	function getVisibleWishlists(){
		global $conn;
		
		try {
			$stmt = $conn->prepare('CREATE OR REPLACE VIEW visible_wishlists AS
									SELECT id, owner FROM wishlist
										WHERE privacy != 0');
					
			$stmt->execute();   
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		
		
	}

	function getFeed($currentUser, $dateOffset, $limit, $compare){
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT feed.*
									FROM feed, wishlist
									WHERE feed.wishlist IN (SELECT id FROM visible_wishlists)
											AND wishlist.id = feed.wishlist
											AND ((:currentUser IN (SELECT follower FROM follow WHERE followed = wishlist.owner) AND wishlist.privacy = 1)
												  OR
												  (:currentUser IN 
													(SELECT follower FROM follow
													 WHERE followed = wishlist.owner OR followed = new_giver OR followed = old_giver OR followed = (SELECT owner FROM forum_post WHERE id = feed.post)
													)
													AND wishlist.privacy = 2
												   )
												  )
											AND wishlist.owner != :currentUser
											AND feed.date '. $compare .' :dateOffset
									ORDER BY feed.date DESC
									LIMIT :limit');

			$stmt->bindParam(':currentUser', $currentUser);
			$stmt->bindParam(':dateOffset', $dateOffset);
			$stmt->bindParam(':limit', $limit);			
			$stmt->execute();   
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		
	}



?>


