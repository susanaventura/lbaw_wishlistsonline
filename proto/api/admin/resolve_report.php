<?

	include_once('../../config/init.php');
	include_once('../../database/admin.php');
	include_once('../../database/users.php');

	if (!isset($_SESSION['username']) || !isset($_SESSION['userId']) || !isUserAdmin($_SESSION['username'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['reportId']) || !isset($_POST['resolve']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}
	
	
	$report = $_POST['reportId'];
	$resolve = $_POST['resolve'];

	if($resolve)
		resolveReport($_SESSION['userId'], $report);
	else unresolveReport($report);

	echo $_SESSION['username'];
	
	

?>