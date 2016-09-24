<?
	include_once('../config/init.php');
	include_once('../database/users.php');
	
  
	if(!isset($_SESSION['username']))
	{
		http_response_code(401);
		exit();
	}
	
	session_unset();
		
	
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
	
	header('Location: ' . $BASE_URL . 'pages/homepage.php');
	
?>