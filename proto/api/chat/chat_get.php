<?
	include_once('../../config/init.php');
	include_once('../../database/users.php');
	include_once('../../database/chat.php');

	if (!isset($_SESSION['userId'])) {
		http_response_code(401);		
		exit('User not logged in!');
	}
	
	if (!isset($_POST['other'])) {				
		http_response_code(400);		
		exit('Missing Parameters!');
	}
	
	$user = $_SESSION['userId'];
	$other = getUserId($_POST['other']);
	if (isset($_POST['date'])) $date_offset = 0 + $_POST['date'];
	else $date_offset=0;
	
	$msgs = getChatMessages($user, $other, 20, $date_offset);
	if ($msgs === false) $msgs = [];
	
	$r['messages'] = $msgs;
	$r[$user] = $_SESSION['username'];
	$r[$other] = getUsernameById($other);
		
	echo json_encode($r);
	
?>