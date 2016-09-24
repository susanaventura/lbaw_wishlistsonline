<?php
	include_once('../config/init.php');
	include_once('../database/users.php');
	include_once('../database/countries.php');
	
	include_once('../lib/owasp-esapi-php/init.php');

	//check if user is registered
	$email = $_POST['email'];
	
	if(!userExists($email)){
		http_response_code(401);
		exit('This email is not registered. Please create an account.');
	}
	
	
	
	
	require_once('../lib/securimage/securimage.php');
	
	$securimage = new Securimage();
	
	$captcha = $_POST['captcha'];


	if ($securimage->check($captcha) == false) {
        http_response_code(401);
		exit('Incorrect security code entered.');
     }
	 

	//send confirmation email
	include_once ('../lib/swiftmailer/lib/swift_required.php');
	include_once ('../config/util_functions.php');

	$newPsw = randStrGen(8);
	$date = date('Y-m-d H:i:se');
	$userId = getUserId($email);
	$username = getUsernameById($userId);

	//put info into an array to send to the function
	$string_for_key = $email.$newPsw.$date;
	$key = sha1($string_for_key);

	$savedKey = saveRecoverKey($userId, $key, $newPsw, $date);
	if($savedKey === false) exit('cannot save key');

	$info = array(
		'username' => $username,
		'email' => $email,
		'key' => $key,
		'exp_date' => date('Y-m-d', strtotime("+5 days")),
		'temp_psw' => $newPsw);

	send_recover_psw_email($info);
 

	http_response_code(200);
	 

	

	
 
	
	

?>