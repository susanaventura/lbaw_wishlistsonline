<?

	include_once('../config/init.php');
	include_once('../database/users.php');
	include_once('../database/chat.php');
	include_once('../database/social.php');
	include_once('../database/admin.php');
	include_once('../database/wishlists.php');
	 
	if(!isset($_SESSION['username']) || !isset($_SESSION['userId']))
	{
		header('Location: '.$BASE_URL.'pages/homepage.php'); exit;
	}
	$currentUser = $_SESSION['userId'];
	
	$active = true;
	
	/* include templates */
	include_once("../templates/common/head.html");
	
	$smarty->assign('username', $_SESSION['username']);
	$smarty->assign('page_owner', $_SESSION['username']);
	$smarty->assign('admin', isUserAdmin($_SESSION['username']));
	include_once("../api/getFriendReqNotifications.php");
  
  $userinfo = getUserInfo($_SESSION['username']);
	$smarty->assign('userinfo', $userinfo);
	
	$smarty->display('main_template/main_col_left.tpl');
			
	if(isset($_GET['filter'])){
		$filter = $_GET['filter'];
		if($filter == 'friends'){
			$resultUsers = getUserFriends($currentUser, $active);
			$smarty->assign('users', $resultUsers);
			$smarty->display('../templates/users/users_search.tpl');
		}
	} else {
		if (!isset($_GET['inputSearch'])) 	{
			header('Location: '.$BASE_URL.'pages/wallpage.php');
		}
		else{
			$input = $_GET['inputSearch'];
			if (!isset($_GET['searchType'])) 	{
				http_response_code(400);
				exit();
			}

			$searchType = $_GET['searchType'];
			
			if(strcmp($searchType, 'users') == 0){
				$resultUsers = getUsersBySearch($input, $currentUser, $active);
				
				$smarty->assign('users', $resultUsers);
				$smarty->display('../templates/users/users_search.tpl');
			}
			else if(strcmp($searchType, 'wishlists') == 0){
				$resultWishlists = getWishlistsHeaderSearch($input);
				$smarty->assign('wishlists', $resultWishlists);
				$smarty->assign('display_author', true);
				echo '<div id="main_col" class="col-sm-8 col-lg-8 col-md-8"><!-- MAIN COLUMN --><div class="row">

						<div class="panel panel-default panel-custom">
							<div class="panel-body">
								<div style="overflow:hidden;">
									<p class="lead" id="title">Results of wishlists search</p>
								</div>
								
								<hr class="style-one">';
				$smarty->display('../templates/users/users_page/wishlists_list_template.tpl');
				echo '	
							</div> <!-- /panel-body-->
						</div><!-- /panel-default-->
					</div><!--/row-->
					
				</div> <!-- /MAIN COLUMN -->';
			}
		}
			
	}
	 
	
	
	
	
	$smarty->assign('chatUsers', getOnlineFriends($currentUser));
	$smarty->display('../templates/main_template/chat/chatList.tpl');
	
	include_once("../templates/common/footer.html");

?>