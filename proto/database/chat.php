<?php

include_once('social.php');

function getChatMessages($user1, $user2, $number_limit, $date_offset) {
	global $conn;
	try {
		$stmt = $conn->prepare('SELECT * FROM chat_message WHERE 
			((receiver = :user1 AND author = :user2) OR (receiver = :user2 AND author = :user1)) 
			AND date > :date_offset
			ORDER BY id DESC
			LIMIT :number_limit;			
		');
		$stmt->bindParam(':user1', $user1);
		$stmt->bindParam(':user2', $user2);
		$date_offset = date('Y-m-d H:m:s', $date_offset);
		$stmt->bindParam(':date_offset', $date_offset);
		$stmt->bindParam(':number_limit', $number_limit);
		
		$stmt->execute(); 
		
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}	

	return $stmt->fetchAll();
}


function sendChatMessage($author, $receiver, $message) {
	global $conn;
	try {
		$stmt = $conn->prepare('INSERT INTO chat_message(date, message, author, receiver) VALUES(?,?,?,?);');			
		
		$stmt->execute(array(date('Y-m-d H:m:s', time()), $message, $author, $receiver)); 
		
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}	

	return $stmt->fetch() !== false;
}


function getOnlineFriends($userId) {
	global $conn;
	try {
		$stmt = $conn->prepare('
			SELECT id, username, online, profile_image  FROM authenticated_user WHERE
			id IN (SELECT user1 FROM friend WHERE user2=?);
		');		
		$stmt->execute(array($userId));
		
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}	
	
	$r = $stmt->fetchAll();
	if ($r == false) $r = [];
	else {
		$limit = time() - 5*60;
		foreach($r as $i=>$e) {
			$r[$i]['isOnline'] = (strtotime($e['online']) > $limit);
		}
	}	
	return $r;
}


?>

