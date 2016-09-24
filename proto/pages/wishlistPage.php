<?

	include_once('../config/init.php');
	include_once('../database/wishlists.php');
	include_once('../database/users.php');
	include_once('../database/chat.php');
	include_once('../database/forum.php');
	include_once('../database/admin.php');
	include_once('../config/util_functions.php');
	 
	if (!isset($_GET['id'])) {
		header('Location: '.$BASE_URL.'pages/wallPage.php'); exit;
	}
	 
	if(isset($_SESSION['username']) && isset($_SESSION['userId'])) {
		// Authenticated User
		$currentUser = $_SESSION['userId'];
		$currentUsername = $_SESSION['username'];
	} else {
		//Guest
		$currentUser = 0; 
		$currentUsername = NULL;
	}
	
	if (isset($_GET['password'])) $password = $_GET['password']; else $password = NULL;
			
	
	$wishlistId = $_GET['id'];
	$wishlist = getWishlistHeader($wishlistId);
	
	if ($wishlist == false || !canViewWishlist($currentUser, $wishlist['owner'], $wishlist['privacy'], $password === $wishlist['password'])) {
		header('Location: '.$BASE_URL.'pages/wallPage.php');
		exit;
	}
	$isOwner = ($currentUser == $wishlist['owner']);
	
	
	/* include templates */
	$smarty->assign('username', $currentUsername);
    $smarty->assign('profile_img',getUserImg($_SESSION['userId']));
	include_once("../templates/common/head.html");
	
	$smarty->assign('admin', isUserAdmin($currentUsername));
	if ($currentUser != 0) {
		include_once("../api/getFriendReqNotifications.php");
    $userinfo = getUserInfo($_SESSION['username']);
    $smarty->assign('userinfo', $userinfo);
    
    $smarty->display('main_template/main_col_left.tpl');
	}
	else $smarty->display('../templates/common/top_navbar.tpl');
	
	

	
	$wishlist['owner'] = getWishlistOwnerUsername($wishlistId);
	$wishlist['last_edit_date'] = date("d", strtotime($wishlist['last_edit_date'])) . ' ' .date("M", strtotime($wishlist['last_edit_date'])) . ' ' . date("Y", strtotime($wishlist['last_edit_date']));
	
	
	$items = getWishlistItems($wishlistId);

	$smarty->assign('items', $items);
	$wishlist['canSharePassword'] =  $isOwner && $wishlist['privacy']!=2;
	$smarty->assign('wishlist', $wishlist);
	$smarty->assign('view_hidden', false);

	$smarty->assign('wishlistOccasionName', getOccasionName($wishlist['occasion'])['occasion_name']);
	
	// Forum
	if ($currentUser != 0 && !$isOwner) {
		$mainPosts = getMainPostsWishlist($wishlistId);
		$replyPosts = getReplyPostsWishlist($wishlistId);
		
		$completedForum = $mainPosts;
		
		function getkey($elements, $field, $value)
		{
		   foreach($elements as $key => $element)
		   {
			  if ( $element[$field] === $value )
				 return $key;
		   }
		   return false;
		}
		
		//add replies
		foreach ($replyPosts as $key =>$reply) {
			$keyMain = getkey($completedForum, 'id', $reply['main_post']);
					
			$reply['pos_reputation'] = getCountReputationPost($reply['id'], 1)['count'];
			$reply['neg_reputation'] = getCountReputationPost($reply['id'], 0)['count'];
			$reply['user_reputation'] = getReputationUserPost($reply['id'], $_SESSION['userId'])['reputation'];
			$date = strtotime($reply['creation_date']);
			$reply['creation_date'] = formatDate($date).' ago';
			
			if(!array_key_exists('replies',$completedForum[$keyMain]))
			{
				$completedForum[$keyMain]['replies'] = [];
				array_push($completedForum[$keyMain]['replies'], $reply);
			}
			else array_push($completedForum[$keyMain]['replies'], $reply);

		}
		
		//add reputations
		foreach($completedForum as $key=>$post){
			$completedForum[$key]['pos_reputation'] = getCountReputationPost($post['id'], 1)['count'];
			$completedForum[$key]['neg_reputation'] = getCountReputationPost($post['id'], 0)['count'];
			$completedForum[$key]['user_reputation'] = getReputationUserPost($post['id'], $_SESSION['userId'])['reputation'];
			$date = strtotime($completedForum[$key]['creation_date']);
			$completedForum[$key]['creation_date'] = formatDate($date).' ago';
		}
	
		$smarty->assign('forum_posts', $completedForum);
	}
		
	$smarty->assign('canMarkItems', !$isOwner);
	

	$smarty->display('../templates/wishlist/wishlist.tpl');
	
	if ($currentUser != 0) {
		$smarty->assign('chatUsers', getOnlineFriends($currentUser));
		$smarty->display('../templates/main_template/chat/chatList.tpl');
	}
	
	include_once("../templates/common/footer.html");

?>