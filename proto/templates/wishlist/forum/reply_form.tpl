
						<!-- forum reply form -->
						<div class="row forum-post forum-post-reply-form" hidden>
							<!-- post rating -->
							<div class="col-md-2 col-lg-2" style="text-align:center;">

                                {if !isset($profile_img) || $profile_img==""}
                                    <img class="img-round" src="http://placehold.it/48x48" href="userpage.php""> <br>
                                {else}
                                    <img class="img-round img-responsive" src="../images/profileImages/thumb_{$profile_img}" href="userpage.php" height="48" width="48""> <br>
                                {/if}

								<a href="#" class="post-action-author">{$USERNAME}</a><br>
							</div><!-- /post rating -->
							<div class="col-md-9 col-lg-9">
								<form class="text-justify">
									<div class="form-group">
										<textarea class="form-control form-control-custom" rows="3" placeholder="Add some text"></textarea>
									</div>
								
								</form>
								
								<ul class="list-inline wishlist-view-options">
									<li class="pull-right"><a href="#" class="forumPostOption option-comment">comment</a></li>
									<li class="pull-right"><a href="#" class="forumPostOption option-cancel">cancel</a></li>
								</ul>
							</div>
							<div class="col-md-1 col-lg-1">
								
							</div>

						</div><!-- /forum reply form -->
						
						