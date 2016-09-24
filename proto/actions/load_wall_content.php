<?

	include_once('../config/init.php');

	include_once('../database/wishlists.php');
include_once('../database/users.php');
	include_once('../database/forum.php');
	include_once('../database/admin.php');
	include_once('../config/util_functions.php');
	
	 
	 
	function getkey($elements, $field, $value)
	{
	   foreach($elements as $key => $element)
	   {
		  if ( $element[$field] === $value )
			 return $key;
	   }
	   return false;
	} 
 
	function loadPanelWallContent($wishlistId, $msgHeader){
		global $smarty;
		
		$user = $_SESSION['userId'];
		$smarty->assign('USERID', $_SESSION['userId']);
		
		$wishlist = getWishlistHeader($wishlistId);
		$isOwner = ($user == $wishlist['owner']);
		
		$wishlist['owner'] = getWishlistOwnerUsername($wishlistId);
		$wishlist['last_edit_date'] = date("d", strtotime($wishlist['last_edit_date'])) . ' ' .date("M", strtotime($wishlist['last_edit_date'])) . ' ' . date("Y", strtotime($wishlist['last_edit_date']));
		
		


		$items = getWishlistItems($wishlistId);
		
		
		foreach($items as $key=>$item){
			$items[$key]['giver'] = getWishlistItemGiver($item['id'], $wishlistId);
		}
		

		$smarty->assign('items', $items);
		$smarty->assign('view_hidden', false);

		$smarty->assign('wishlistOccasionName', getOccasionName($wishlist['occasion'])['occasion_name']);
		
		

		$mainPosts = getMainPostsWishlist($wishlistId);
		$replyPosts = getReplyPostsWishlist($wishlistId);
		
		$completedForum = $mainPosts;
		

		
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
		
		
		$smarty->assign('canMarkItems', !$isOwner);
		
		
		$row = array(
			'wishlist' => $wishlist,
			'items' => $items,
			'forum_posts' => $completedForum,
			'msgHeader' => $msgHeader
		);
		
		
		return $row;
	}
	
	function getRows($wall){
		$rows = array();
	

		foreach ($wall as $elem){
			$time = formatDate(strtotime($elem['date']));
			$date = $elem['date'];
			
			
			if($elem['post'] != null){

                $postOwner = getUsernameById(getForumPostOwner($elem['post']));
				$msgHeader = array(
					'header_owner' => $postOwner,
                    'head_img' => getUserImg(getForumPostOwner($elem['post'])),
					'time' => $time,
					'date' => $date,
					'msg' => 'commented on forum');
				
				array_push($rows,loadPanelWallContent($elem['wishlist'], $msgHeader));
			}
			
			else if($elem['post'] == null && $elem['wishlist_edit'] == null && $elem['wishlist_create'] == null){
				

				if($elem['new_giver'] != null)
				{
					$msg = 'marked an item to give';	
					$giver = $elem['new_giver'];
				}
				else if($elem['old_giver'] != null){
					$msg = 'unmarked an item to give';
					$giver = $elem['old_giver'];
				}
				
				$msgHeader = array(
					'header_owner' => getUsernameById($giver),
                    'head_img' => getUserImg($giver),
					'time' => $time,
					'date' => $date,
					'msg' => $msg);
				
				array_push($rows,loadPanelWallContent($elem['wishlist'], $msgHeader));
			}
			else if($elem['post'] == null && $elem['new_giver'] == null){

				
				if(strtotime($elem['wishlist_edit']) == strtotime($elem['wishlist_create']))
					$msg = 'created a new wishlist';
				else $msg = 'updated a wishlist';

                $wishlistOwnerUsername = getWishlistOwnerUsername($elem['wishlist']);
				$msgHeader = array(
					'header_owner' => $wishlistOwnerUsername,
                    'head_img' => getUserImg(getUserId($wishlistOwnerUsername)),
					'time' => $time,
					'date' => $date,
					'msg' => $msg);
				
				array_push($rows,loadPanelWallContent($elem['wishlist'],$msgHeader));
			}

		}
			
		
		return $rows;
	}
	

?>