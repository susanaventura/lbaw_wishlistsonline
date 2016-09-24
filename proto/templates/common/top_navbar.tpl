<body> <!-- BODY -->

	<!-- confirmation modal -->
	<div id="modal" class="modal fade">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <!-- dialog header -->
		  <div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			  <h4 class="modal-title">Confirmation</h4>
		  </div>
		  <!-- dialog body -->
		  <div class="modal-body">
			<p id="confirmation"></p>
		  </div>
		  <!-- dialog buttons -->
		  <div class="modal-footer">
			<button id="yesBtn" type="button" class="btn btn-primary">Yes</button>
			<button id="noBtn" type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">No</button>
		</div>
		</div>
	  </div>
	</div>
	
	<!-- top nav -->
	<nav class="navbar navbar-default navbar-fixed-top" id="navbar-main-orange">
	  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" id="navbar-main-brand">Wishlists Online</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		
		<div class="collapse navbar-collapse">
		{if (isset($username) && $username != NULL)}
		  <form class="navbar-form navbar-left" role="search" style="padding-top:5px;">
			<div class="form-group">
				<div class="form-inline">
					<label class="sr-only" for="inputSearchUsers">Search users</label>
					<input id="inputSearchUsers" type="text" class="form-control form-control-custom" placeholder="Search users">
					<span>
						<button class="btn btn-default" type="button">Go</button>
					</span>
				</div>
			</div>
			<div class="form-group">
				<div class="form-inline">
					<label class="sr-only" for="inputSearchWishlists">Search wishlists</label>
					<input id="inputSearchWishlists" type="text" class="form-control" placeholder="Search wishlists" style="margin-left:10px;">
					<span>
						<button class="btn btn-default" type="button">Go</button>
					</span>
				</div>
			</div>
		  </form>
		  <ul class="nav navbar-nav navbar-right" id="navbar-links" style="padding-top:5px;">
			<li class="dropdown">
			  <a href="#" id="friend_req_not_link" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Friend Requests <span class="badge navbar-custom-badge">0</span></a>
			  <ul class="dropdown-menu tooltip-navbar top-bar-menu" role="menu" style="width: 180%;">
				{foreach $friend_notifications as $friend_not}
				
				<li {if !$friend_not.seen}class="notification-not-seen friend_not_item_list" {else} class="friend_not_item_list"{/if}>
					<div class="row" style="padding-bottom:10px">
						<div class="col-md-12">
							<div class="span4">
							  <!--<img src="http://placehold.it/64x64" class="img-round"/>  -->
							  <p class="date"><small>{$friend_not.date}</small></p>
							  <h5 class="username">{$friend_not.username}</h5>
							  {if $friend_not.friend == null}
							  <p style="text-align:center"><small>wants to be your friend</small></p>
							  <div class="btns">
								<div class="btn-group btn-group-sm" role="group" >
								  <button type="button" class="btn btn-default btn-accept"><span hidden class="sender_id">{$friend_not.sender}</span>Accept</button>
								  {if $friend_not.seen == 'true'}
								  <button type="button" class="btn btn-default btn-mark-seen" disabled><span hidden>{$friend_not.notification}</span>Seen</button>
								  {else}
								    <button type="button" class="btn btn-default btn-mark-seen"><span hidden>{$friend_not.notification}</span>Mark as seen</button>
								  {/if}
								</div>
							   </div>
							   {else}
							   <p style="text-align:center"><small>accepted your friend request</small></p>
							   <div class="btns">
								   <div class="btn-group btn-group-sm" role="group" >
									{if $friend_not.seen == 'true'}
									  <button type="button" class="btn btn-default btn-mark-seen" disabled><span hidden>{$friend_not.notification}</span>Seen</button>
									  {else}
										<button type="button" class="btn btn-default btn-mark-seen"><span hidden>{$friend_not.notification}</span>Mark as seen</button>
									 {/if}
								   </div>
								</div>
							   {/if}
							  <div style="clear:both"></div>
							</div>
						</div>
					</div>
				</li>
				<hr class="style-one separator">
				{/foreach}
				<li>
				<a href="#" style="text-align:center">See all</a>
				</li>
			  </ul>
			</li>
			<li><a href="#">Notifications <span class="badge navbar-custom-badge">0</span></a></li>
			<li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My account</a>
			  <ul class="dropdown-menu tooltip-navbar top-bar-menu" role="menu">
				<li><a href="#"><span class="fa fa-envelope-o icon-menu" aria-hidden="true"></span>Messages<span class="badge navbar-custom-badge" style="margin-left:5px;">0</span></a></li>
				<li><a href="../pages/editProfilePage.php"><span class="fa fa-cog icon-menu" aria-hidden="true"></span>Edit profile</a></li>
				<li><a href="../pages/searchPage.php?filter=friends"><span class="fa fa-users icon-menu" aria-hidden="true"></span>Manage friends</a></li>
				<li><a href="../pages/contactAdminPage.php"><span class="fa fa-paper-plane icon-menu" aria-hidden="true"></span>Contact administration</a></li>
				{if isset($admin) && $admin}
				<li><a href="../pages/adminPage.php?section=dashboard"><span class="fa fa-wrench icon-menu" aria-hidden="true"></span>Administration Area</a></li>
				{/if}
				<li class="divider"></li>
				<li><a href="../actions/logout.php"><span class="fa fa-power-off icon-menu" aria-hidden="true"></span>Logout</a></li>
			  </ul>
			</li>
		  </ul>
		{else}
		  <ul class="nav navbar-nav navbar-right" id="navbar-links" style="padding-top:5px;">
			<li> <a href="../pages/homepage.php" aria-expanded="false">Join wishlists online!</a> </li>
		  </ul>
		{/if}
		</div><!-- /.navbar-collapse -->
		
	  </div><!-- /.container-fluid -->
	</nav><!-- /top nav -->