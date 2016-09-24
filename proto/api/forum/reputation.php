<?
	
	include_once('../../config/init.php');
	include_once('../../database/forum.php');
	

	if (!isset($_SESSION['username']) || !isset($_SESSION['userId'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['reputation']) || !isset($_POST['post']) || !isset($_POST['action']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}
	
	$reputation = $_POST['reputation'];
	$post = $_POST['post'];
	$action = $_POST['action'];
	
	if($action == 1)
		addReputation($post, 1, $reputation);
	else if($action == 0)
		removeReputation($post,1);
?>