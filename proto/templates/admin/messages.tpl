<div id="page-wrapper" >
		<div id="page-inner">
			<div class="row">
				<div class="col-md-12">
					<h1 class="h1-admin">Manage Messages</h1>   
				</div>
			</div>              
			 <!-- /. ROW  -->
			  <hr/>
			<div class="row">
				<div class="col-md-3 col-sm-6 col-xs-6">           
					<div class="panel panel-back noti-box">
						<span class="icon-box bg-color-red set-icon">
							<i class="fa fa-envelope-o"></i>
						</span>
						<div class="text-box" >
							<p class="main-text p-admin">{$numberMessages} Message{if {$numberMessages}!=1}s{/if}</p>
						</div>
					 </div>
				</div>
			 <!-- /. ROW  -->
			<hr />                

			<div class="row">   
				<div class="col-md-12 col-sm-12 col-xs-12">                     
					<div class="panel panel-default">
						<div class="panel-heading">
						<div class="row">
							<div class="col-lg-9">
								Messages <small style="color:red"> ({$number_unseen_messages} not seen)</small>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
								   <label class="col-lg-4 control-label">Subject area filter:</label>
								   <div class="col-lg-8">
									  <select name="subject_area" class="btn btn-default form-control">
											<option value="-1"></option>
											{if isset($subject_areas)}
											{foreach $subject_areas as $area}
											<option value="{$area.id}">{$area.name}</option>
											{/foreach}
											{/if}
										</select>
								   </div>
								   
								</div>
							</div>
						</div><!-- row-->
						</div>
						<div class="panel-body">
						 <div class="table-responsive">
							<table class="table">
								<tr>
									<th>date</th>
									<th>area</th>
									<th>subject</th>
									<th>sender</th>
									<th>message</th>
									<th>mark as seen</th>
								</tr>
								{foreach $support_messages as $message}
								<tr {if !$message.seen}class="warning"{/if} id="{$message.id}">
									
									<td>{$message.date}</td>
									<td class="msgArea"><span class="msg-area-id" hidden>{$message.subject_area}</span>{$message.subject_area_name}</td>
									<td>{$message.subject}</td>
									<td class="msgAuthor">
										<ul style="list-style-type: none; padding-left:0">
											<li>{$message.author_first_name} {$message.author_last_name}</li>
											<li style="padding-left:10px"><span class="msg-author-id" hidden>{$message.author}</span><p><i>{$message.author_username}<i></p></li>
											<li><a href="#">{$message.author_email}</a></li>
										</ul>
									</td>
									<td style="word-wrap: break-word;min-width: 300px;max-width: 300px; white-space:normal;">{$message.message}</td>
									<td>{if !$message.seen}<a href="" class="mark-seen">Mark as seen</i></a>{else}<a href="" class="mark-unseen">Mark as unseen</a>{/if}</td>
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
