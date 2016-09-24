<?

	include_once('../../config/init.php');
	include_once('../../database/reports.php');

	
	if(!isset($_SESSION['username'])) 
	{
		header('Location: '.'/homepage.php');
	}
	
	if(!isset($_POST['userId']) || !isset($_POST['message'])){
		http_response_code(400);		
		exit('Missing Parameters!');
	}
	
	$reported_user = $_POST['userId'];
	$date = date('Y-m-d H:i:se');
	$msg = $_POST['message'];
	
	if(!reportUser($date, $msg, $_SESSION['userId'], $reported_user)){
			http_response_code(500);
			exit('Could not send report');
	}
	
?>