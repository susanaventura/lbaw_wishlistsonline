
<?php
	include_once('../config/init.php');
	include_once('../database/admin.php');
	include_once('../database/users.php');
	include_once('../database/subject_areas.php');

	if(!isset($_SESSION['username']) || !isset($_SESSION['userId']))
	{
		header('Location: '.$BASE_URL.'pages/homepage.php'); exit;
	}
	
	/* include templates */
	include_once("../templates/common/head.html");
	
	
	$smarty->assign('admin', isUserAdmin($_SESSION['username']));
	include_once("../api/getFriendReqNotifications.php");
	
	$smarty->assign('unresolved_reports', getNumberUnresolvedReports());
	$smarty->assign('number_unseen_messages', getNumberUnseenMessages());
	$smarty->display("../templates/admin/nav.tpl");
	

	if(!isset($_GET['section']))
		$section = 'dashboard';
	else $section = $_GET['section'];

	if(strcmp($section, 'manageusers') == 0){
		
		$smarty->assign('numberUsers', getNumberOfUsers());
		$smarty->assign('numberOfReports', getNumberOfReportedUsers());
		$smarty->assign('numberReportsUnresolvedUsers', getNumberUnresolvedReportsUser());
		
		$reports = getUserReports(0, 10);
		
		foreach ($reports as $key =>$report){
			$adminId = $reports[$key]['responsable_admin_id'];
			if($adminId != null)
				$reports[$key]['responsable_admin_user'] = getUsernameById($adminId);
		}
		
		
		$smarty->assign('reported_users', $reports);
		
		$smarty->display("../templates/admin/manage_users.tpl");
	} else if(strcmp($section, 'messages') == 0){ 
	
		$smarty->assign('subject_areas', getSubjectAreas());
		$smarty->assign('numberMessages', getNumberSupportMessages());
		$smarty->assign('support_messages', getSupportMessages());
	
		$smarty->display("../templates/admin/messages.tpl");
	}
	
	
	else
	$smarty->display("../templates/admin/dashboard.tpl");
	
	include_once("../templates/common/footer.html");
	
?>