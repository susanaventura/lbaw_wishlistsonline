<?php
  
  
function createUser($first_name, $last_name, $birth_date, $email, $gender, $password, $username, $register_date, $country) {
global $conn;
 try {
	$stmt = $conn->prepare("INSERT INTO authenticated_user(birth_date, email, first_name, last_name, gender, password, profile_image, username, last_login, register_date, country) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
	
	$options = ['cost' => 12];
	$passwordhash = password_hash($password, PASSWORD_DEFAULT, $options);
	
	$stmt->execute(array($birth_date, $email, $first_name, $last_name, $gender, $passwordhash, NULL, $username, NULL, $register_date, $country));
} catch (PDOException $e) {
	error_log( $e->getMessage() );
}	

return $stmt->fetch() !== false;

}


function updateUser($firstname, $lastname, $password, $username, $email, $img){

	global $conn;
	 try {
		 if($password != null){
			$stmt = $conn->prepare("UPDATE authenticated_user SET first_name = ?, last_name = ?, password = ?, profile_image = ? WHERE email = ? AND username = ?");
			
			$options = ['cost' => 12];
			$passwordhash = password_hash($password, PASSWORD_DEFAULT, $options);
			
			$stmt->execute(array($firstname, $lastname, $passwordhash, $img, $email, $username));
		 } else{
			 $stmt = $conn->prepare("UPDATE authenticated_user SET first_name = ?, last_name = ?, profile_image = ? WHERE email = ? AND username = ?");

			$stmt->execute(array($firstname, $lastname, $img, $email, $username));
		 }
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}	

	return $stmt->fetch() !== false;

	
	
}


/*verify if a user exists with a given username or email*/
function userExists($user) {
	global $conn;
	try {
		$stmt = $conn->prepare('SELECT id FROM authenticated_user WHERE username = ? OR email = ?');
		$stmt->execute(array($user, $user)); 
		
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}	

	return $stmt->fetch() !== false;
}
 
function getUserId($usernameORemail) {
	global $conn;
	try {
		$stmt = $conn->prepare('SELECT id FROM authenticated_user WHERE username = ? OR email = ?');
		$stmt->execute(array($usernameORemail, $usernameORemail)); 
		
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}	
	
	return $stmt->fetch()['id'];
}

function getUserEmail($id) {
	global $conn;
	try {
		$stmt = $conn->prepare('SELECT email FROM authenticated_user WHERE id = ?');
		$stmt->execute(array($id)); 
		
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}	
	
	return $stmt->fetch()['email'];
}

function getUsernameById($id) {
	global $conn;
	try {
		$stmt = $conn->prepare('SELECT username FROM authenticated_user WHERE id = ?');
		$stmt->execute(array($id)); 
		
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}	
	
	return $stmt->fetch()['username'];
}


function isLoginCorrect($username, $password) {
	global $conn;
	
	try {
		 $stmt = $conn->prepare('SELECT password, active FROM authenticated_user WHERE username = ? OR email = ?');
		 $stmt->execute(array($username, $username));   
		 
		 $res = $stmt->fetch();
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}
		 
	if($res == false) return 'Invalid Username';
	else {
		if(password_verify($password, $res['password'])){
			if($res['active'] === true)
				return 'success';
			else return 'inactive account';
		}
			
		else return 'Invalid Password';
	}
	
}


function saveConfirmationKey($username, $key){
	global $conn;
	$user_id = getUserId($username);
	
	try {
		 $stmt = $conn->prepare('INSERT INTO email_confirmation(confirmationKey, auth_user) VALUES(?,?)');
		 $stmt->execute(array($key, $user_id));   
		 
		 $res = $stmt->fetch();
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}
	
	return $res !== false;	
}

function getConfirmKey($email){
	global $conn;
	
	$user_id = getUserId($email);
	
	try {
		 
		 $stmt = $conn->prepare('SELECT confirmationKey FROM email_confirmation WHERE auth_user = ?');
		 $stmt->execute(array($user_id));   
		 
		 $key = $stmt->fetch();
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}
	
	return $key;
}

function activateUser($email, $key){
	global $conn;
	
	
	try {
		//activate user
		 $stmt = $conn->prepare('UPDATE authenticated_user set active=true WHERE email = ?');
		 $stmt->execute(array($email));   
		 
		 $stmt->fetch();
		 
		 //delete data from emailConfirmation
		 $stmt = $conn->prepare('DELETE FROM email_confirmation WHERE confirmationKey = ?');
		 $stmt->execute(array($key));
		  
		 $stmt->fetch();
		  
		  
	} catch (PDOException $e) {
		error_log( $e->getMessage() );
	}
}


function getUserPicture($username){
	//SELECT profile_image FROM authenticated_user WHERE id = ?
}

function getUsersByUsernameOrEmail($usernameOrEmail, $active){
	global $conn;
	
	try{
		
		$stmt = $conn->prepare('SELECT id, username, profile_image, first_name, last_name FROM authenticated_user WHERE (username = ? OR email = ?) AND active = ?');
		$stmt->execute(array($usernameOrEmail, $usernameOrEmail, $active));   
		 
		return $stmt->fetchAll();
		
	}catch (PDOException $e) {
		error_log( $e->getMessage() );
	}
	
}


function getUsersBySearch($input, $currentUserId, $active){
	global $conn;
	$string = "%".$input."%";

	try{

		$stmt = $conn->prepare(
			"SELECT DISTINCT id, username, profile_image, first_name, last_name, user2 AS friend, followed, friend_request_notification.sender AS friend_req_sender
			FROM authenticated_user
			FULL JOIN friend ON
				friend.user1 = :currentUser AND friend.user2 = id
			FULL JOIN friend_request_notification ON
				friend_request_notification.sender = :currentUser
				AND id = (SELECT receiver FROM notification WHERE friend_request_notification.notification = notification.id)
			FULL JOIN follow ON
				follow.follower = :currentUser AND follow.followed = id
			WHERE 	search_tsvector @@ plainto_tsquery(:input) AND active = :active");
		
		//$stmt->bindParam(':text', $string);
		$stmt->bindParam(':input', $input);
		$stmt->bindParam(':active', $active);
		$stmt->bindParam(':currentUser', $currentUserId);
		
		if (!$stmt) {
				echo "\nPDO::errorInfo():\n";
				print_r($db->errorInfo());
			}
		
		$stmt->execute();   
		
		return $stmt->fetchAll();
		
	}catch (PDOException $e) {
		error_log( $e->getMessage() );
	}
	
}


	function updateOnlineState($username, $state){
		global $conn;
		
		
		try{
			
			$stmt = $conn->prepare('UPDATE authenticated_user set online=? WHERE username = ?');
			 $stmt->execute(array($state, $username));   
			 
			 $stmt->fetch();
			
		}catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
	}

	function saveRecoverKey($userId, $key, $temp_psw, $date){
		global $conn;
		

		$options = ['cost' => 12];
		$passwordhash = password_hash($temp_psw, PASSWORD_DEFAULT, $options);
	
		try {
			 $stmt = $conn->prepare('INSERT INTO password_recovery(auth_user, temp_psw, confirmationKey, date) VALUES(?,?,?,?)');
			 $stmt->execute(array($userId, $passwordhash, $key, $date));   
			 
			 $res = $stmt->fetch();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
		return $res !== false;	
	}


	function getPswRecoverKey($email){
		global $conn;
		
		$user_id = getUserId($email);
		
		try {
			 
			 $stmt = $conn->prepare('SELECT confirmationKey, temp_psw, date FROM password_recovery WHERE auth_user = ?');
			 $stmt->execute(array($user_id));   
			 
			 $key = $stmt->fetch();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
		return $key;
	}

	

	
	function confirmPswRecovery($email, $key, $temp_psw){
		global $conn;		
		
		try {
			//activate user
			 $stmt = $conn->prepare('UPDATE authenticated_user set password=? WHERE email = ?');
			 $stmt->execute(array($temp_psw, $email));   
			 
			 $stmt->fetch();
			 
			 //delete data from emailConfirmation
			 $stmt = $conn->prepare('DELETE FROM password_recovery WHERE confirmationKey = ?');
			 $stmt->execute(array($key));
			  
			 $stmt->fetch();
			  
			  
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
	}
	
	
	function userOnlineNow($userId) {
		global $conn;		
		
		try {
			 $stmt = $conn->prepare('UPDATE authenticated_user SET online=now() WHERE id = ?');
			 $stmt->execute(array($userId));   
			 
			 $stmt->fetch();
			  
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
	}


    function getUserImg($userId) {
        global $conn;

        try {
            $stmt = $conn->prepare('SELECT profile_image FROM authenticated_user WHERE id = ?');
            $stmt->execute(array($userId));

            return $stmt->fetch()['profile_image'];

        } catch (PDOException $e) {
            error_log( $e->getMessage() );
        }
    }


function getUserInfo($username){
		global $conn;

		try {
			 
			 $stmt = $conn->prepare('SELECT * FROM authenticated_user WHERE username = ?');
			 $stmt->execute(array($username));   
			 
			 $info = $stmt->fetch();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $info;

	}
	
	
	function deleteUserAccount($username){
		global $conn;

		try {
			 
			 $stmt = $conn->prepare('DELETE FROM authenticated_user WHERE username = ?');
			 $stmt->execute(array($username));   

			 if (!$stmt) {
				echo "\nPDO::errorInfo():\n";
				print_r($db->errorInfo());
			}
			 
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

	}

  
?>
