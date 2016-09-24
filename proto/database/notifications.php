<?php

	function getFriendRequestsNotifications($currentUser){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT sender, notification, date, seen, authenticated_user.username, friend.user2 AS friend
									FROM friend_request_notification
									FULL JOIN notification ON
										friend_request_notification.notification = notification.id
									FULL JOIN authenticated_user ON
										authenticated_user.id = friend_request_notification.sender
									FULL JOIN friend ON
										friend.user1 = :currentUser AND friend.user2 = sender
									WHERE receiver = :currentUser AND notification IS NOT NULL
									ORDER BY notification.date DESC LIMIT 4');

											
			$stmt->bindParam(':currentUser', $currentUser);
			$stmt->execute();   
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
	}
	

	function markNotificationAsSeen($notId){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare('UPDATE notification SET seen = true WHERE id =?');

			$stmt->execute(array($notId));   
			$stmt->fetch();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
	}
	
	function createForumPostNotification(){
		
		global $conn;
		
		try {
			$conn->beginTransaction();
				
				$newNotification = $conn->prepare('INSERT INTO notification(date, seen, receiver) VALUES(?,?,?) RETURNING id');
				$newNotification->execute(array($date, 'false', $receiver));
				

				$notId = $newNotification->fetch()['id'];
				
				$newFriendNotification = $conn->prepare('INSERT INTO friend_request_notification(notification, sender) VALUES(?,?)');
				$newFriendNotification->execute(array($notId, $sender)); 

				$success = $newFriendNotification->fetch() !== false;
				
			if (!success) { $conn->rollBack(); return []; }
			else { $conn->commit(); return $newFriendNotification->fetchAll(); }
			
			
			
			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
	}
	
	
?>