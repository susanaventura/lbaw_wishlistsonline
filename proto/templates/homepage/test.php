<? 

	//$jsonResponse = array('success' => true);
	
	
	$jsonResponse = array('success' => false, 'reason'=>'Invalid birth date!');
	echo json_encode($jsonResponse);

?>