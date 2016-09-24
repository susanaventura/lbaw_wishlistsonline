<?php

	include_once($BASE_DIR . 'lib/owasp-esapi-php/src/ESAPI.php');
	include_once($BASE_DIR . 'lib/owasp-esapi-php/src/reference/DefaultValidator.php');
  
	$esapi = new ESAPI($BASE_DIR . 'lib/owasp-esapi-php/ESAPI.xml');
	$esapi = new ESAPI();
  
	$validator = ESAPI::getValidator();
	$encoder = ESAPI::getEncoder();
	
	function makeSafe($input) {
		global $encoder;
		return  $encoder->encodeForHTML($encoder->canonicalize($input));
	}
  
?>