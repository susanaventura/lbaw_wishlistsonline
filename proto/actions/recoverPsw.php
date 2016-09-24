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
	
	$savedKey = getPswRecoverKey($email);
	
	if(strpos($savedKey['confirmationkey'], $key) !== false){//correct
		
		//check date
		$now = new DateTime(date('Y-m-d'));
		$timestamp = strtotime($savedKey['date']);
		$keyDate = new DateTime(date("Y-m-d", $timestamp));
		$interval = $now->diff($keyDate);

			
		if($interval->format('%a') > 5){
			exit('Your new password has expired.');
		}
		
		confirmPswRecovery($email, $key, $savedKey['temp_psw']);
		

		header( "refresh:10;url='../pages/homepage.php" );
		echo 'Your have completed your password recovery process with success! Don\'t forget to change your password once you login on the website. You will be redirected to Wishlists Online soon.';
	}
	else{
		http_response_code(406);
		exit('Invalid key. This happened because: 1. Your key is invalid; 2. You already confirmed your new password; 3. Your new password has expired.');
	}
	
	
?>