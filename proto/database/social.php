<?

	include_once('users.php');
	
	function getUserFriends($currentUser, $active){
		
		global $conn;
		
		
		try {
			$stmt = $conn->prepare('SELECT DISTINCT id, username, profile_image, first_name, last_name, user2 AS friend, followed, friend_request_notification.sender AS friend_req_sender
			FROM authenticated_user
			FULL JOIN friend ON
				friend.user1 = :currentUser AND friend.user2 = id
			FULL JOIN friend_request_notification ON
				friend_request_notification.sender = :currentUser
				AND id = (SELECT receiver FROM notification WHERE friend_request_notification.notification = notification.id)
			FULL JOIN follow ON
				follow.follower = :currentUser AND follow.followed = id
			WHERE 	friend.user1 = :currentUser AND friend.user2 = authenticated_user.id
					AND active = :active;');

			$stmt->bindParam(':currentUser', $currentUser);
			$stmt->bindParam(':active', $active);
			if (!$stmt) {
				echo "\nPDO::errorInfo():\n";
				print_r($db->errorInfo());
			}
			$stmt->execute();   
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}

	}
	
	function isFriend($user1, $user2) {
		global $conn;
		
		
		try {
			$stmt = $conn->prepare('SELECT user1 FROM friend WHERE (friend.user1 = :user1 AND friend.user2 = :user2)');

			$stmt->bindParam(':user1', $user1);
			$stmt->bindParam(':user2', $user2);
			if (!$stmt) {
				echo "\nPDO::errorInfo():\n";
				print_r($db->errorInfo());
			}
			$stmt->execute();   
			return ($stmt->fetch() !== false);
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
	}

	
	function getUsersFollowedBy($username){
		global $conn;
		
		$userId = getUserId($username);
		
		try {
			$stmt = $conn->prepare('SELECT followed FROM follow WHERE follower = ?');
			$stmt->execute(array($userId)); 
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	}

	function sendFriendRequestNotification($sender, $receiver, $date){
		global $conn;
		
		try {
			$conn->beginTransaction();
				
				$newNotification = $conn->prepare('INSERT INTO notification(date, seen, receiver) VALUES(?,?,?) RETURNING id');
				$newNotification->execute(array($date, 'false', $receiver));
				

				$notId = $newNotification->fetch()['id'];
				
				$newFriendNotification = $conn->prepare('INSERT INTO friend_request_notification(notification, sender) VALUES(?,?)');
				$newFriendNotification->execute(array($notId, $sender)); 

				$success = $newFriendNotification->fetch() !== false;
				
			if (!$success) { $conn->rollBack(); return []; }
			else { $conn->commit(); return $newFriendNotification->fetchAll(); }
			

			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	
	}
	
	
	
	function removeFriend($currentUser, $friend){
		global $conn;

		try{
			//delete friend
			$deleteFriend = $conn->prepare('DELETE FROM friend
									WHERE (user1 = ? AND user2 = ?)
											OR (user1 = ? AND user2 = ?)');
			 $deleteFriend->execute(array($currentUser, $friend, $friend, $currentUser));   
			 
			 $deleteFriend->fetch();
			
			$conn->beginTransaction();
			
				 //delete notification
				 $deleteFriendNot = $conn->prepare('DELETE FROM friend_request_notification WHERE sender = ? RETURNING notification');
				 $deleteFriendNot->execute(array($currentUser));
				 
				 $notId = $deleteFriendNot->fetch()['notification'];
				 
				 
				 $deleteFriendNot = $conn->prepare('DELETE FROM notification WHERE receiver = ? AND id = ?');
				 $deleteFriendNot->execute(array($friend, $notId));
				 
				 $deleteFriendNot->fetch();
				 
			 $conn->commit();
			
		}catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
	}
	
	
	function followUser($currentUser, $otherUser){
		global $conn;

		try{
			$stmt = $conn->prepare('INSERT INTO follow("follower", "followed")
									VALUES(?,?)');
			 $stmt->execute(array($currentUser, $otherUser));   
			 
			 $stmt->fetch();

		}catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
	}
	
	function unfollowUser($currentUser, $otherUser){
		global $conn;

		try{
			$stmt = $conn->prepare('DELETE FROM follow
									WHERE (follower = ? AND followed = ?)
											OR (follower = ? AND followed = ?)');
			 $stmt->execute(array($currentUser, $otherUser, $otherUser, $currentUser));   
			 
			 $stmt->fetch();

		}catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
	}
	
	function acceptFriend($friend, $currentUser, $friendRequestId){
		global $conn;

		try{
			$conn->beginTransaction();
				//mark notification as seen
				$updateNot = $conn->prepare('UPDATE notification SET seen = true WHERE id = ?');
				$updateNot->execute(array($friendRequestId));    
				$success = $updateNot->fetch()!== false;

				//become friend
				$friendship = $conn->prepare('INSERT INTO friend(user1, user2) VALUES(?,?)');
				$friendship->execute(array($currentUser, $friend));
				$success = $success && ($friendship->fetch()!== false);
				$friendship->execute(array($friend, $currentUser));
				$success = $success && ($friendship->fetch()!== false);
				
			if (!$success) { $conn->rollBack(); return false; }
			else { $conn->commit(); return true; }
		}catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
		
	}
	
	
?>