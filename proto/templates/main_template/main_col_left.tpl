
<div class="container-fluid" style="margin-top:40px;"><!--MAIN CONTAINER-->
	<!-- content -->                      
	<div class="row" style="margin-left:40px; margin-right:40px;"><!--MAIN CONTAINER ROW -->
		<div id="left_col" class="col-sm-2 col-lg-2 col-md-2"><!-- LEFT COL -->

			<!-- main col left --> 
			<div style="overflow:hidden;">
				<!--content-->
				<a href="../pages/myWishlistsPage.php?username={$username}">
					<div class="panel panel-default panel-custom" id="userPanel" >
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 text-center">
									<p class="lead currentUser">{$username}</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-center">
                                    {if !isset($userinfo.profile_image) || $userinfo.profile_image == ""}
                                        <img src="http://placehold.it/160x160" class="img-responsive img-round" class="img-responsive img-round">
                                    {else}
									    <img src="../images/profileImages/thumb_{$userinfo.profile_image}" class="img-responsive img-round" width="160" height="160">
                                    {/if}
								</div>
							</div>
							<!--<div class="row" id="currentUserSocialOptions">
								<div class="col-md-12 text-center">
									
									<a  href="#" style="padding-right:10px;" title="Send friend request"><i class="fa fa-user-plus fa-2x"></i></a>
									<a  href="#" style="padding-right:10px;" title="Remove friend"><i class="fa fa-user-times fa-2x"></i></a>
									<a  href="#" style="padding-right:10px;" title="Report user"><i class="fa fa-bell fa-2x"></i></a>
									<a  href="#"><i class="fa fa-road fa-2x" title="Follow user"></i></a>
									
									
								</div>
							</div>-->
						</div>
					</div>
				</a><!--/content-->
				
				
				
			</div>
		</div><!-- /LEFT COL -->