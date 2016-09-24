<?

	include_once('../../config/init.php');
	include_once('../../database/forum.php');
	

	if (!isset($_SESSION['username']) || !isset($_SESSION['userId'])) {
		http_response_code(403);
		exit('You do not have permission to do this.');
	}
	
	if (!isset($_POST['msg'])|| !isset($_POST['wishlist']) || !isset($_POST['csrf_token']) || !verifyCSRFToken($_POST['csrf_token'])) {
		http_response_code(400);
		exit('Invalid request.');
	}


	if(isset($_POST['mainPost']))
		$mainPost = $_POST['mainPost'];
	else $mainPost = null;
	
	
	$msg = $_POST['msg'];
	$date = date('Y-m-d H:i:se');
	$wishlist = $_POST['wishlist'];
	
	addPost($mainPost, $_SESSION['userId'], $msg, $wishlist, $date);
	
	
?>