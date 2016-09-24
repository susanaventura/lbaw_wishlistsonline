<?

	include_once('users.php');
	
	
	function isUserAdmin($username){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT id FROM authenticated_user WHERE admin_rights = true AND username = ?');
			$stmt->execute(array($username)); 
			return $stmt->fetch() !== false;
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	}
	
	
	function getNumberOfUsers(){
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT COUNT(id) FROM authenticated_user');
			$stmt->execute(); 
			return $stmt->fetch()['count'];
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
	}

	function getNumberOfReportedUsers(){
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT COUNT(reported_user) FROM report WHERE reported_user IS NOT NULL');
			$stmt->execute(); 
			return $stmt->fetch()['count'];
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
	}

	
	function getUserReports($offset, $limit){
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT report.id, report.date, reason, author AS author_id,
									u_author.username AS author_user,
									responsable_admin AS responsable_admin_id, reported_user AS reported_user_id, u_reported.username AS reported_user_user, u_reported.active AS reported_user_active
									FROM report,
										(SELECT id, username FROM authenticated_user) AS u_author,
										(SELECT id, username, active FROM authenticated_user) AS u_reported
									WHERE reported_user IS NOT NULL
											AND u_reported.id = reported_user
											AND u_author.id = author
									ORDER BY report.date DESC
									OFFSET ? LIMIT ?');
			$stmt->execute(array($offset, $limit)); 
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
	}
	
	
	function resolveReport($admin, $report){
		global $conn;
		
		try {
			$stmt = $conn->prepare('UPDATE report SET responsable_admin = ? WHERE id = ?');
			$stmt->execute(array($admin, $report)); 
			return $stmt->fetch();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	}
	
	
	function unresolveReport($report){
		global $conn;
		
		try {
			$stmt = $conn->prepare('UPDATE report SET responsable_admin = null WHERE id = ?');
			$stmt->execute(array($report)); 
			return $stmt->fetch();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
	}
	
	
	function banUser($userId){
		global $conn;
		
		try {
			$stmt = $conn->prepare('UPDATE authenticated_user SET active = false WHERE id = ? AND active = true');
			if (!$stmt) {
				echo "\nPDO::errorInfo():\n";
				print_r($db->errorInfo());
			}
			return ($stmt->execute(array($userId)) && $stmt->fetch()!==false);
			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		
	}
	
	
	function unbanUser($userId){
		global $conn;
		
		try {
			$stmt = $conn->prepare('UPDATE authenticated_user SET active = true WHERE id = ? AND active = false');
			if (!$stmt) {
				echo "\nPDO::errorInfo():\n";
				print_r($db->errorInfo());
			}
			return ($stmt->execute(array($userId)) && $stmt->fetch()!==false);
			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}	
		
		
	}
	
	
	
	
	function getNumberUnresolvedReports(){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT count(id) FROM report WHERE responsable_admin IS NULL');
			$stmt->execute(); 
			return $stmt->fetch()['count'];
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
	}
	
	function getNumberUnresolvedReportsUser(){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT count(id) FROM report WHERE responsable_admin IS NULL AND reported_user IS NOT NULL');
			$stmt->execute(); 
			return $stmt->fetch()['count'];
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
	}

	
	function sendMsgToAdmin($msg, $subject, $area, $author){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare('INSERT INTO support_msg(date, message, author, subject_area, subject) VALUES(CURRENT_TIMESTAMP,?,?,?,?)');
			$stmt->execute(array($msg, $author, $area, $subject)); 
			return $stmt->fetch() !== false;
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}

	}
	
	function getNumberUnseenMessages(){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT count(id) FROM support_msg WHERE seen = false');
			$stmt->execute(); 
			return $stmt->fetch()['count'];
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
	}
	
	function getNumberSupportMessages(){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT count(id) FROM support_msg');
			$stmt->execute(); 
			return $stmt->fetch()['count'];
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
	}
	
	function getSupportMessages(){
		global $conn;
		
		try {
			$stmt = $conn->prepare('SELECT support_msg.*, authenticated_user.username AS author_username, authenticated_user.first_name AS author_first_name, authenticated_user.last_name AS author_last_name, authenticated_user.email AS author_email, support_msg_subject_areas.name AS subject_area_name
									FROM support_msg, authenticated_user, support_msg_subject_areas
									WHERE authenticated_user.id = support_msg.author
											AND support_msg_subject_areas.id = support_msg.subject_area');
			$stmt->execute(); 
			return $stmt->fetchAll();
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
	}
	
	
	
	function seeSupportMsg($msg, $see){
		
		global $conn;
		
		try {
			$stmt = $conn->prepare('UPDATE support_msg SET seen = ? WHERE id = ?');
			$stmt->execute(array($see, $msg)); 
			
		} catch (PDOException $e) {
			error_log( $e->getMessage() );
		}
		
	}
	
?>