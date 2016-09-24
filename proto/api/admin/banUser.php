<?

	//send email to inform user
	include_once('../../config/init.php');
	include_once('../../lib/swiftmailer/lib/swift_required.php');
	include_once('../../config/util_functions.php');
	include_once('../../database/users.php');
	include_once('../../database/admin.php');
	
	if (!isset($_SESSION['username']) || !isset($_SESSION['userId']) || !isUserAdmin($_SESSION['username'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['banId']) || !isset($_POST['banUsername']) || !isset($_POST['ban']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}
	

	$userToBanId = $_POST['banId'];
	$username = $_POST['banUsername'];
	$email = getUserEmail($userToBanId);

	$ban = $_POST['ban'];
	
	if($ban)
	{
		$success = banUser($userToBanId);
	
		if($success){
			$info = array(
				'username' => $username,
				'email' => $email);

			sendGenericEmail('templates/admin/noreply_emails/ban_user_email', 'Your account has been inactivated', $info);
		}
		else http_response_code(500);
	} else{
		$success = unbanUser($userToBanId);
	
		if($success){
			$info = array(
				'username' => $username,
				'email' => $email);

			sendGenericEmail('templates/admin/noreply_emails/unban_user_email', 'Your account has been reactivated', $info);
		}
		else http_response_code(500);
	}




?>