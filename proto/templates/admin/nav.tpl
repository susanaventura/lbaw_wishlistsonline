<div id="wrapper">
	<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
		<div class="navbar-header-admin">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="navbar-brand">
				<a id="not-report" href="" style="color: white; padding-right:20px; font-size: 16px;"><i class="fa fa-bell-o fa-2x"></i><span class="badge">{$unresolved_reports}</span></a>
				<a id="not-msg" href="" style="color: white; font-size: 16px;"><i class="fa fa-envelope-o fa-2x"></i><span class="badge">{$number_unseen_messages}</span></a>
			</div>

		</div>
			<div style="color: white; padding: 15px 50px 5px 50px; float: right;font-size: 16px;"><a href="login.html" class="btn btn-danger square-btn-adjust"><span class="glyphicon glyphicon-send icon-menu" aria-hidden="true"></span>Send dynamic e-mail</a> </div>
	</nav>   
	   <!-- /. NAV TOP  -->
			<nav class="navbar-default navbar-side" role="navigation">
		<div class="sidebar-collapse">
			<ul class="nav" id="main-menu">
				<li class="text-center">
					<img class="img-circle" src="http://placehold.it/150x150" alt="" style="padding-top:10px;">
					<h3 style="color:#a5a5a5;">{$USERNAME}</h3>
					<h5 style="color:#808080;">Administrator</h5>
				</li>
			
				
				<li>
					<a class="active-menu dashboard"  href="../pages/adminPage.php?section=dashboard"><i class="fa fa-dashboard fa-3x"></i> Dashboard</a>
				</li>
				 <li>
					<a class="manageusers" href="../pages/adminPage.php?section=manageusers"><i class="fa fa-users fa-3x"></i> Manage users</a>
				</li>
				<li>
					<a  class="manageforums" href="#"><i class="fa fa-list-alt fa-3x"></i> Manage forums</a>
				</li>
				<li>
					<a class="statistics"  href="#"><i class="fa fa-bar-chart-o fa-3x"></i> Statistics</a>
				</li>	
				  <li  >
					<a  class="messages" href="../pages/adminPage.php?section=messages"><i class="fa fa-envelope fa-3x"></i> Messages</a>
				</li>
			</ul>
		   
		</div>
		
	</nav>  
	<!-- /. NAV SIDE  -->
	
	
	
