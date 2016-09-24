<?
	include_once('../config/init.php');
	include_once('../database/users.php');
	include_once('../lib/owasp-esapi-php/init.php');
	
	if (! (isset($_GET['email']) && isset($_GET['key']))) {
				
		http_response_code(400);		
		exit('Missing Parameters!');
	}
	
	$maxLenEmail = 48; $maxLenKey = 255;
	//$email = makeSafe(substr($_GET['email'], 0, $maxLenEmail));  //TODO
	$email = $_GET['email'];
	$key = makeSafe(substr($_GET['key'], 0, $maxLenKey));
	
	$savedKey = getConfirmKey($email);
	
	if(strpos($savedKey['confirmationkey'], $key) !== false){//correct
		activateUser($email, $key);
		
		//login user
        $userId = getUserId($email);
		$_SESSION['username'] = getUsernameById($userId);         // store the username
		$_SESSION['userId'] = $userId;
		$_SESSION['csrf_token'] = generateRandomToken(); // generate a auth token
		
		header( "refresh:4;url='../pages/wallPage.php" );
		echo 'Your account has been activated! You will be redirected to Wishlists Online soon.';
	}
	else{
		http_response_code(406);
		exit('Invalid key. Your key is invalid or your account is already activated.');
	}
	
	
?>