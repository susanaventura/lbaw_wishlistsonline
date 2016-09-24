

				<div class="col-sm-2 col-lg-2 col-md-2"><!-- RIGHT COL -->
					<!--content-->
					<div class="panel panel-default" >
						<div class="panel-heading lead">Chat</div>
						<div class="panel-body">
							<div class="row">
								<!-- user -->
								<div class="col-md-12 col-lg-12">

									{foreach $chatUsers as $user}
									<div class="media">
									  <div class="media-left media-middle">
										<a href="#">
										  {if isset({$user.profile_image}) && $user.profile_image != ""}
										  <img class="media-object img-circle" src="../images/profileImages/thumb_{$user.profile_image}" href="myWishlistsPage.php?username={$user['username']}" width="24px" height="24px">
										  {else}
										  <img class="media-object img-circle" src="http://placehold.it/24x24" href="myWishlistsPage.php?username={$user['username']}">
										  {/if}
										</a>
									  </div>
									  <div class="media-body">
										<a href="" class="username-chat" style="font-size:15px">{$user['username']}</a>
											{if $user['isOnline']}
												<span class="forumRateIcon forumRateIcon-up fa fa-circle pull-right" style="margin-top:15px;"></span>
											{else}
												<span class="forumRateIcon forumRateIcon-down fa fa-circle pull-right" style="margin-top:15px;"></span>
											{/if}
									  </div>
									</div>
									<hr>

									{/foreach}							
								</div>
							</div>
						</div>
					</div><!--/content-->
				</div><!-- /RIGHT COL -->
			</div><!-- /MAIN CONTAINER ROW -->
		</div><!-- /MAIN CONTAINER-->

