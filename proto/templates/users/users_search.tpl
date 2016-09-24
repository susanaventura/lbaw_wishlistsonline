<div id="main_col" class="col-sm-8 col-lg-8 col-md-8"><!-- MAIN COLUMN -->
	<div class="panel panel-default panel-custom">
		<div class="panel-body">
			<div style="overflow:hidden;">
				<p class="lead" id="title">Results of users search</p>
			</div>
			
			<hr class="style-one">
			
			{if {$users|@count} > 0}
			<div class="row">
				{foreach $users as $user}
				<div class="col-sm-6 col-md-4">
					<a href="../pages/myWishlistsPage.php?username={$user.username}">
						<div class="thumbnail">
						  <!--<img src="{$user.profile_image}" alt="user image">-->
						  {if isset($user.profile_image)&& $user.profile_image != ""}
						  <img src="../images/profileImages/thumb_{$user.profile_image}" alt="user image"  class="img-responsive img-round" width="140" height="140">
						  {else}
						  <img src="http://placehold.it/140x140" alt="user image"  class="img-responsive img-round">
						  {/if}
						  <div class="caption text-center">
							<h3><span hidden>{$user.id}</span>{$user.username}</h3>
							<p>{$user.first_name} {$user.last_name}</p>
							{if $user.friend == null && $user.friend_req_sender == null}
							<a  href="" title="Send friend request" class="social add_friend"><i class="fa fa-user-plus fa-2x"></i></a>
							{elseif $user.friend == null && $user.friend_req_sender != null}
							<a  href="" title="Friend request pending" class="social request_friend_pending orange disabled"><i class="fa fa-user fa-2x"></i></a>
							{else}
							<a  href="" title="Remove friend" class="social red remove_friend"><i class="fa fa-user-times fa-2x"></i></a>
							{/if}
							{if $user.friend != null}
							{if $user.followed != null}
							<a href="" class="social red unfollow_user"><i class="fa fa-road fa-2x" title="Unfollow user"></i></a>
							{else}
							<a  href="" class="social follow_user"><i class="fa fa-road fa-2x" title="Follow user"></i></a>
							{/if}
							{/if}
							<a  href="" style="padding-right:10px;" title="Report user" class="social report"><i class="fa fa-bell"></i></a>
						  </div>
						</div>
					</a>
				</div>
				{/foreach}
			</div><!-- /row-->	
			{else}
			<div class="row">
				<div class="col-md-12 col-lg-12">
					<p class="lead text-center">No results</p>
				</div>
			</div><!-- /row -->
			{/if}
		</div> <!-- /panel-body-->
	</div><!-- /panel-default-->

</div> <!-- /MAIN COLUMN -->