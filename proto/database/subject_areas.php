<?php

	function subjectAreaExists($area) {
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT id FROM support_msg_subject_areas WHERE name=? OR id=?');
			$stmt->execute(array($area, $area)); 
			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	

		$res = $stmt->fetch();
		if ($res == false) return false;
		else return $res['name'];
	}
 
	function getSubjectAreas() {
		global $conn;
		try {
			$stmt = $conn->prepare('SELECT * FROM support_msg_subject_areas');
			$stmt->execute(); 
			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	

		return $stmt->fetchAll();	
	}

?>