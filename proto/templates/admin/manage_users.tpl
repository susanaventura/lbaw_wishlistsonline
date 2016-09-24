<div id="page-wrapper" >
		<div id="page-inner">
			<div class="row">
				<div class="col-md-12">
					<h1 class="h1-admin">Manage Users</h1>   
				</div>
			</div>              
			 <!-- /. ROW  -->
			  <hr/>
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-6">           
					<div class="panel panel-back noti-box">
						<span class="icon-box bg-color-red set-icon">
							<i class="fa fa-users"></i>
						</span>
						<div class="text-box" >
							<p class="main-text p-admin">{$numberUsers} User{if {$numberUsers}!=1}s{/if}</p>
						</div>
					 </div>
				</div>
				<div class="col-md-3 col-sm-6 col-xs-6">           
					<div class="panel panel-back noti-box">
						<span class="icon-box bg-color-brown set-icon">
							<i class="fa fa-bell"></i>
						</span>
						<div class="text-box" >
							<p class="main-text p-admin n-reports">{$numberOfReports} Reported User{if {$numberOfReports}!=1}s{/if}</p>
						</div>
					 </div>
				</div>
			</div>
			 <!-- /. ROW  -->
			<hr />                

			<div class="row">   
				<div class="col-md-12 col-sm-12 col-xs-12">                     
					<div class="panel panel-default">
						<div class="panel-heading">
							Reports <small style="color:red"> ({$numberReportsUnresolvedUsers} unresolved)</small>
						</div>
						<div class="panel-body">
						 <div class="table-responsive">
							<table class="table">
								<tr>
									<th>date</th>
									<th>reported user</th>
									<th>report author</th>
									<th>reason</th>
									<th>resolve</th>
									<th>resolved by</th>
								</tr>
								{foreach $reported_users as $reported_user}
								<tr {if $reported_user.responsable_admin_id == null}class="warning"{/if} id="{$reported_user.id}">
									
									<td>{$reported_user.date}</td>
									<td class="reportedUser"><span class="reported-userId" hidden>{$reported_user.reported_user_id}</span>{$reported_user.reported_user_user}</td>
									<td>{$reported_user.author_user}</td>
									<td style="word-wrap: break-word;min-width: 300px;max-width: 300px; white-space:normal;">{$reported_user.reason}</td>
									<td>
										<ul style="list-style-type: none; padding-left:0">
											{if $reported_user.reported_user_active}
											<li><a href="" class="ban-user">Ban user</a></li>
											{else}
											<li style="color:red">User banned<a href="" class="unban-user"> (Unban user)</a></li>
											{/if}
											<li><a href="#">Send message to reported user</a></li>
											<li><a href="#">Send message to report author</a></li>
										</ul>
									</td>
									<td>{if $reported_user.responsable_admin_id != null}{$reported_user.responsable_admin_user} <a href="" class="unmark-resolved"><i class="fa fa-close"></i></a>{else}<a href="" class="mark-resolved">Mark as resolved</a>{/if}</td>
								</tr>
								{/foreach}
							</table>
						  </div>
						</div>
					</div>            
				</div>
			</div>
			 <!-- /. ROW  -->
			
				  
		</div>
		 <!-- /. PAGE INNER  -->
		</div>
	 <!-- /. PAGE WRAPPER  -->
	</div>
 <!-- /. WRAPPER  -->
