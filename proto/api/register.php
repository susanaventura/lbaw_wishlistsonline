<?php
	include_once('../config/init.php');
	include_once('../database/users.php');
	include_once('../database/countries.php');
	
	include_once('../lib/owasp-esapi-php/init.php');
	

	
	if (! (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) 
		&& isset($_POST['birthdate']) && isset($_POST['firstname']) && isset($_POST['lastname'])
		&& isset($_POST['gender']) && isset($_POST['country']) )) {
				
		http_response_code(400);		
		exit('Missing Parameters!');
	}

	$maxLen = 48;
	$username = makeSafe(substr($_POST['username'], 0, $maxLen)); 
	$password = makeSafe(substr($_POST['password'], 0, $maxLen));
	//$email = makeSafe(substr($_POST['email'], 0, $maxLen)); //TODO
	$email = $_POST['email'];
	$birthdate = $_POST['birthdate'];
	$firstname = makeSafe(substr($_POST['firstname'], 0, $maxLen));
	$lastname = makeSafe(substr($_POST['lastname'], 0, $maxLen));
	$gender = substr($_POST['gender'], 0, 1);
	
	$countryname = makeSafe(substr($_POST['country'],0,$maxLen));
	
	$country = countryExists($countryname);
	$birthTimeStamp = strtotime($birthdate);

	$errors =array('errors');

	//check formats
	if(!preg_match ("/^[a-zA-Z\._0-9]+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/", $email))
		array_push($errors, array('email' => array('reason' => 'Invalid email format!', 'help' => 'example@random.random')));
	
	if(!preg_match ("/^[A-Za-z0-9_]{4,10}$/", $username))
		array_push($errors, array('username' => array('reason' => 'Invalid username format!', 'help' => 'use only 4 to 10 numbers and letters')));
	
	if(!preg_match("/^[a-zA-Z]+$/", $firstname))
		array_push($errors, array('firstname' => array('reason' => 'Invalid firstname format!', 'help' => 'use only letters')));
	
	if(!preg_match("/^[a-zA-Z]+$/", $lastname))
		array_push($errors, array('lastname' => array('reason' => 'Invalid lastname format!', 'help' => 'use only letters')));
	
	if(!preg_match("/^.{5,}$/", $password))
		array_push($errors, array('password' => array('reason' => 'Invalid password format!', 'help' =>'password must have at least 5 characters')));
	if ($birthTimeStamp == false || $birthTimeStamp < strtotime('1900-01-01')){
		array_push($errors, array('birth' => array('reason' => 'Invalid birth date!', 'help' =>'minimum accepted year: 1900')));
	}
	
	if(count($errors) > 1){
		http_response_code(406);
		echo json_encode($errors);
		return;
	}
	
	
	$warnings = array('warnings');
	
	if (userExists($username)) {
		array_push($warnings, array('username' => array('reason' => 'This username already exists!', 'help' => null)));
	} 
	if (userExists($email)) {
		array_push($warnings, array('email' => array('reason' => 'This email address already exists!', 'help' => null)));
	} 
	if ((time() < strtotime('+12 years', $birthTimeStamp)) == 1) {
		array_push($warnings, array('birth' => array('reason' => 'You\'re too young!', 'help' => 'You must have at least 12 years old to register')));
	} 
	if ($country == false) {
		http_response_code(406);
		exit('Invalid country!');
	} 
	if ($gender !== 'M' && $gender !== 'F') {
		http_response_code(406);
		exit('Invalid gender!');
	} 

	
	
	if(count($warnings) > 1){
		http_response_code(406);
		echo json_encode($warnings);
	}
	else{
		$registerDate = date('Y-m-d H:i:se');
	
		createUser($firstname, $lastname, $birthdate, $email, $gender, $password, $username, $registerDate, $country);
		
	
		//send confirmation email
		include_once ('../lib/swiftmailer/lib/swift_required.php');
		include_once ('../config/util_functions.php');
		
		
		//put info into an array to send to the function
		$string_for_key = $username.$email.$registerDate;
		$key = sha1($string_for_key);
		
		$savedKey = saveConfirmationKey($username, $key);
		if($savedKey === false) exit('cannot save key');
		
		$info = array(
			'username' => $username,
			'email' => $email,
			'key' => $key);

		send_confirmation_email($info);
	}
 
	
	

?>