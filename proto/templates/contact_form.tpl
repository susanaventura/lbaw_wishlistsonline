  <div class="col-sm-8 col-lg-8 col-md-8"><!-- MAIN COLUMN -->
		<div class="row">
			<div class="panel panel-default panel-custom">
				<div class="panel-body">
					<!-- contact template -->
					<div class="row">
						<!-- contact column -->
						<div class="col-md-12 col-lg-12">
							<div class="row">
								<div class="col-md-12 col-lg-12">
									<p class="lead" id="editProfile-title">Contact us</p>
									
									<hr class="style-one">
								
									<div class="col-md-1 col-lg-1">
									</div>
									
									<div class="col-md-8 col-lg-8 ">
										
										<form class="form-horizontal" role="form" method="post" action="../actions/contactAdmin.php">
											<div class="form-group">
											   <label class="col-lg-4 control-label">Subject area:</label>
											   <div class="col-lg-8">
												  <select name="subject_area" class="btn btn-default form-control">
														<option value="-1"></option>
														{if isset($subject_areas)}
														{foreach $subject_areas as $area}
														<option value="{$area.id}">{$area.name}</option>
														{/foreach}
														{/if}
													</select>
													<small style="font-size:12px;">Please choose the subject area that better fits your subject, so you can get a response from us faster</small>
											   </div>
											   
											</div>
											<div class="form-group">
											   <label class="col-lg-4 control-label">Subject:</label>
											   <div class="col-lg-8">
												  <input class="form-control form-control-custom" type="text" name="subject">
											   </div>
											</div>
											<div class="form-group">
											   <label class="col-lg-4 control-label">Message:</label>
											   <div class="col-lg-8">
												  <textarea class="form-control form-control-custom" rows="12" name="msg"></textarea>
											   </div>
											</div>

											
										
											<div class="form-group">
												 <label class="col-md-4 control-label"></label>
												 <div class="col-md-8">
													   <input class="btn btn-success pull-right" value="Send" type="submit">
													  <input class="btn btn-default btn-SaveProfile pull-right" value="Cancel" type="reset">
													 
												 </div>
											</div>
										</form>
									</div>
									<div class="col-md-3 col-lg-3 ">
									</div>
								</div>
							</div>
							
						</div>
					</div><!-- /edit profile template -->
				</div> <!-- /panel-body-->
			</div><!-- /panel-default-->
		</div><!--/row-->
					
	</div> <!-- /MAIN COLUMN -->