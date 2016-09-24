<?

	include_once('../../config/init.php');
	include_once('../../database/social.php');

	
	if (!isset($_SESSION['username']) || !isset($_SESSION['userId'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['userId']) || !isset($_POST['follow']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}

	$otherUser = $_POST['userId'];
	$follow_flag = $_POST['follow'];

	if($follow_flag === 'true')
		followUser($_SESSION['userId'], $otherUser);
	else
		unfollowUser($_SESSION['userId'], $otherUser);
	

?>