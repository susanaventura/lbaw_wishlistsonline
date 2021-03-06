<?
	include_once('../../config/init.php');
	include_once('../../database/social.php');

	
	if (!isset($_SESSION['username']) || !isset($_SESSION['userId'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['userId']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}

	$friend = $_POST['userId'];

	removeFriend($_SESSION['userId'], $friend);
?>