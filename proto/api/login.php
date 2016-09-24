<?
	include_once('../config/init.php');
	include_once('../database/users.php');
	
	
	if (! (isset($_POST['username']) && isset($_POST['password'])) ) {
		http_response_code(400);		
		exit('Missing Parameters!');
	
	} else {
	
		$post_username = $_POST['username'];
		$post_password = $_POST['password'];
		
		
		//check correct login
		$login_correct = isLoginCorrect($post_username, $post_password);
		
		
		if(strpos($login_correct, 'success') !== false){
			
			//store username
			if (strpos($post_username, '@') !== false)
				$user = getUsername($post_username);
			else $user = $post_username;
	
			$_SESSION['username'] = $user;         // store the username
			$_SESSION['userId'] = getUserId($user);
			$_SESSION['csrf_token'] = generateRandomToken(); // generate a auth token
		
		}
		
		else{
			if(strpos($login_correct, 'Invalid Username') !== false){
				http_response_code(406);
				exit('Invalid Username');
			}
			else if(strpos($login_correct, 'Invalid Password') !== false){
				http_response_code(406);
				exit('Invalid Password');
			}
			else if(strpos($login_correct, 'inactive account') !== false){
				http_response_code(406);
				exit('inactive account');
			}
		}
	
	};	
	

?>