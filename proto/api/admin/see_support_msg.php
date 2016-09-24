<?

	include_once('../../config/init.php');
	include_once('../../database/admin.php');
	
	if (!isset($_SESSION['username']) || !isset($_SESSION['userId']) || !isUserAdmin($_SESSION['username'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['msgId']) || !isset($_POST['see']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}
	
	
	$msg = $_POST['msgId'];
	$see = $_POST['see'];


	seeSupportMsg($msg, $see);

?>