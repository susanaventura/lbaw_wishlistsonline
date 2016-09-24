<?php
	include_once('../config/init.php');
	include_once('../database/users.php');
	include_once('../database/countries.php');
	
	
	include_once('../lib/owasp-esapi-php/init.php');


	
	
 	if (! (isset($_POST['form'])) || !isset($_POST['check_current_psw'])) {
				
		http_response_code(400);		
		exit('Missing Parameters!');
	}

	$params = array();
	parse_str($_POST['form'], $params);
	
	$maxLen = 48;
	$username = makeSafe(substr($params['username'], 0, $maxLen)); 
	$email = $params['email'];

	$firstname = makeSafe(substr($params['firstname'], 0, $maxLen));
	$lastname = makeSafe(substr($params['lastname'], 0, $maxLen));

	$errors =array('errors');

	//check formats

	if(!preg_match("/^[a-zA-Z]+$/", $firstname))
		array_push($errors, array('firstname' => array('reason' => 'Invalid firstname format!', 'help' => 'use only letters')));
	
	if(!preg_match("/^[a-zA-Z]+$/", $lastname))
		array_push($errors, array('lastname' => array('reason' => 'Invalid lastname format!', 'help' => 'use only letters')));
	
	$password = makeSafe(substr($params['password'], 0, $maxLen));
	if(strlen($password)>0){ //psw change

		if(!preg_match("/^.{5,}$/", $password))
		array_push($errors, array('password' => array('reason' => 'Invalid password format!', 'help' =>'password must have at least 5 characters')));
	
		else{
			if(isset($params['current_password']) && $_POST['check_current_psw'] == 1){
				$current_password = makeSafe(substr($params['current_password'], 0, $maxLen));

				$login_correct = isLoginCorrect($username, $current_password);
				if(strpos($login_correct, 'success') !== false){
					
				} else array_push($errors, array('current_password' => array('reason' => 'Wrong current password', 'help' =>'your current password must be correct')));
					
			}

		}
		
	}
	
	
	
	if(count($errors) > 1){
		http_response_code(406);
		echo json_encode($errors);
		return;
	}
	
	
	if (!userExists($username) || !userExists($email)) {
		http_response_code(500);
		exit('Could not update: invalid user or email');
	} 

	if(isset($_POST['img']))
		$img = $_POST['img'];
	else $img = null;

	if(strlen($password) > 0 && $_POST['check_current_psw'] == 1)
	{
		if(!updateUser($firstname, $lastname, $password, $username, $email, $img)){
			http_response_code(500);
			exit('Could not update');
		}
		echo 'updated';
		
	}	
	else if(strlen($password) == 0){
		
		if(!updateUser($firstname, $lastname, null, $username, $email, $img)){
			http_response_code(500);
			exit('Could not update');
		}
		echo 'updated';
	}
		

	
	

?>