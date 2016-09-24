<?php

	function generateRandomToken() { return md5( uniqid(time(), true) ); }
	
	function verifyCSRFToken($post_token) {
		if (!isset($_SESSION['csrf_token'])) return false;
		if ($post_token != $_SESSION['csrf_token']) return false;
		
		// regenerate token
		//$_SESSION['csrf_token'] = generateRandomToken();
		
		return true;
	}

?>