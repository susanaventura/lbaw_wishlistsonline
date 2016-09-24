
  <div class="col-sm-8 col-lg-8 col-md-8"><!-- MAIN COLUMN -->
		<div class="row">
			<div class="panel panel-default panel-custom">
				<div class="panel-body">
					<!-- edit profile template -->
					<div class="row">
						<!-- edit form column -->
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<div class="col-md-12 col-lg-12">
									<p class="lead" id="editProfile-title">Edit profile<small style="font-size:12px; margin-left:10px;">|Edit only the fields you want different and then click Save Changes</small></p>
									
									<hr class="style-one">
								
                  <div class="col-lg-1"></div>
									<div class="col-lg-2">
										<div class="text-center">
                      <div class="form-group img-upload">
                        <!-- Thumnail-->
                        <a href="#" class="thumbnail" style="width: 225px;"></a>
                        {if isset($userinfo.profile_image) || $userinfo.profile_image != ""}
                          <div id="userHasImage" img="{$userinfo.profile_image}"></div>
                        {/if}
                      </div>
										</div>
									</div>  
									
                  <div class="col-lg-1"></div>
                  
									<div class="col-md-8 col-lg-8  mycontent-right">
										<h3>Personal Details</h3>
										
										<form id="edit-profile-form" class="form-horizontal" role="form">
											<div class="form-group">
											   <label class="col-lg-4 control-label">First name:</label>
											   <div class="col-lg-8">
											    <!--firstname-->
												  <input class="form-control form-control-custom" value={$userinfo.first_name} type="text" name="firstname" id="input-editProfile-firstname">
											   </div>
											</div>
											<div class="form-group">
											   <label class="col-lg-4 control-label">Last name:</label>
												  <div class="col-lg-8">
													<!-- last name-->
													 <input class="form-control form-control-custom" value={$userinfo.last_name} type="text" name="lastname" id="input-editProfile-lastname">
												  </div>
											</div>
											<div class="form-group">
											  <label class="col-md-4 control-label">Username:</label>
											  <div class="col-md-8">
												  <input class="form-control form-control-custom" value={$userinfo.username} type="text" id="input-editProfile-username" name="username" readonly>
											  </div>
											</div>
											<div class="form-group">
											   <label class="col-lg-4 control-label">Email:</label>
												   <div class="col-lg-8">
														<input class="form-control form-control-custom" value={$userinfo.email} type="text" id="input-editProfile-email" name="email" readonly>
												   </div>
											</div>

											<div class="form-group">
												 <label class="col-md-4 control-label"><span>Password:</span></label>
												 <div class="col-md-8">
													 <input class="form-control form-control-custom" type="password" id="input-editProfile-password" name="password">
												 </div>
											</div>
											<div class="form-group">
												 <label class="col-md-4 control-label"><span>Password Confirmation:</span></label>
												 <div class="col-md-8">
													 <input class="form-control form-control-custom" type="password" id="input-editProfile-confirm-password" name="password_confirmation">
												 </div>
											</div>
											<div id="current-psw-confirm" hidden>
												<div class="form-group">
													 <div class="col-md-8">
														<p class="bg-warning">You are requiring a password change. Please insert your current password.</p>
													</div>
												</div>
												<div class="form-group">
													 <label class="col-md-4 control-label"><span>Current Password:</span></label>
													 <div class="col-md-8">
														 <input class="form-control form-control-custom" type="password" id="input-editProfile-current_password" name="current_password">
													 </div>
												</div>
											</div>
										
											<div class="form-group">
												 <label class="col-md-4 control-label"></label>
												 <div class="col-md-8">
													  <input class="btn btn-default btn-SaveProfile pull-right" value="Cancel" type="reset" id="edit-profile-cancel">
													  <input class="btn btn-success pull-right" value="Save Changes"id="edit-profile-submit">
												 </div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div id="erase-account-link" class="col-md-12 col-lg-12" style="text-align:center;">
									<i class="fa a-2x fa-trash-o erase-account-icon"></i><a href="#">Click here if you want to erase your account </a>
								</div>
							</div>
							
						</div>
					</div><!-- /edit profile template -->
				</div> <!-- /panel-body-->
			</div><!-- /panel-default-->
		</div><!--/row-->
					
	</div> <!-- /MAIN COLUMN -->
	
	