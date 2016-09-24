<?
	include_once('../config/init.php');
	include_once('../database/users.php');
	
	if (!isset($_SESSION['username']) || !isset($_SESSION['userId'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}
	
	
	deleteUserAccount($_SESSION['username']);

	// Default info
	unset($_SESSION['username']);
	unset($_SESSION['userId']);
	unset($_SESSION['csrf_token']);
	unset($_SESSION['regenerate_index']);
  
  // FB info
  unset($_SESSION['FBID']);
  unset($_SESSION['FULLNAME']);
  unset($_SESSION['EMAIL']);
    
	session_destroy();
	
	//header('Location: ' . $BASE_URL . 'pages/homepage.php');

?>