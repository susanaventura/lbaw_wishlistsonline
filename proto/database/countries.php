<?php

	function countryExists($country) {
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT id FROM country WHERE name=? OR id=?');
			$stmt->execute(array($country, $country)); 
			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	

		$res = $stmt->fetch();
		if ($res == false) return false;
		else return $res['id'];
	}
 
	function getCountries() {
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT * FROM country');
			$stmt->execute(array($country)); 
			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	

		return $stmt->fetchAll();	
	}

?>