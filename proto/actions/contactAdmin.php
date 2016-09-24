<?

	include_once('../config/init.php');
	include_once('../database/wishlists.php');
	include_once('../database/forum.php');
	include_once('../database/admin.php');
	include_once('../database/chat.php');
	include_once('../config/util_functions.php');



	
	$subjectArea = $_POST['subject_area'];
	$subject = $_POST['subject'];
	$msg = $_POST['msg'];
	
	
	
	
	if($subjectArea == -1) {
		$subjectArea = 5; //general
	}
	
	include_once("../templates/common/head.html");
	$smarty->assign('username', $_SESSION['username']);
	$smarty->assign('admin', isUserAdmin($_SESSION['username']));
	include_once("../api/getFriendReqNotifications.php");
	$smarty->display('main_template/main_col_left.tpl');
	
	if(sendMsgToAdmin($msg, $subject, $subjectArea, $_SESSION['userId'])){


		
		
		echo '  <div class="col-sm-8 col-lg-8 col-md-8"><!-- MAIN COLUMN -->
			<div class="row">
				<div class="panel panel-default panel-custom">
					<div class="panel-body">
						<!-- edit profile template -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<p class="lead text-center">Thank you!</p>
								<br>
								<p class="lead text-center">Your message was sent. You\'ll get a response from us as soon as possible.</p>
								<br>
								<p class="lead text-center" style="font-size:15px;">The Wishlists Online administration</p>
							</div>
						</div><!-- /edit profile template -->
					</div> <!-- /panel-body-->
				</div><!-- /panel-default-->
			</div><!--/row-->
						
		</div> <!-- /MAIN COLUMN -->';
		
		
		

		
	}
	else{
		echo '  <div class="col-sm-8 col-lg-8 col-md-8"><!-- MAIN COLUMN -->
			<div class="row">
				<div class="panel panel-default panel-custom">
					<div class="panel-body">
						<!-- edit profile template -->
						<div class="row">
							<div class="col-md-12 col-lg-12">
								<p class="lead text-center">Ooooops</p>
								<br>
								<p class="lead text-center">An error has occured :( Please try again</p>
							</div>
						</div><!-- /edit profile template -->
					</div> <!-- /panel-body-->
				</div><!-- /panel-default-->
			</div><!--/row-->
						
		</div> <!-- /MAIN COLUMN -->';
	}

	
	$smarty->assign('chatUsers', getOnlineFriends($currentUser));
	$smarty->display('../templates/main_template/chat/chatList.tpl');
	
	include_once("../templates/common/footer.html");
	
?>