				<!-- forum -->
				<div class="row forum">
					<span class="wishlistId" hidden>{$wishlist.id}</span>
					<div class="col-md-1 col-lg-1"><!--empty content--></div>
					{include file='./reply_form.tpl'}
					<!-- forum posts -->
					<div class="col-md-10 col-lg-10">
						{if {$forum_posts|@count} > 0}
						{foreach $forum_posts as $post}
							<div class="group-posts">
								<div class="row forum-post forum-post-main"><!-- forum post -->
									<span class="postId" hidden>{$post.id}</span>
									<!-- post rating -->
									<div class="col-md-2 col-lg-2" style="text-align:center;">
                                        {if !isset($post.img_owner) || $post.img_owner==""}
                                            <img class="img-circle" src="http://placehold.it/48x48" href="userpage.php"><br>
                                        {else}
                                            <img class="img-circle img-responsive" src="../images/profileImages/thumb_{$post.img_owner}" href="userpage.php" height="48" width="48"><br>
                                        {/if}
										<a href="#" class="post-action-author">{$post.owner}</a><br>
										<a href="#" class="post-action-time">{$post.creation_date}</a><br>
									</div><!-- /post rating -->
									<div class="col-md-9 col-lg-9 post-content">
										<p class="text-justify"> {$post.message} </p>
										<span style="position:absolute; bottom:0; right:0">
											<ul class="list-inline wishlist-view-options">
												<li class="pull-left"><span hidden>{if isset($post.replies)}{$post.replies|@count}{else}0{/if}</span><a href="#" class="forumPostOption option-hide">hide replies</a></li>
												<li class="pull-right"><a href="#" class="forumPostOption option-reply">reply</a></li>
											</ul>
										</span>
									</div>
									<div class="col-md-1 col-lg-1">
									
										<div class="forumRate forum-rate-positive {if $post.user_reputation == 1} marked {else} unmarked{/if}">	<span class="forumRateIcon forumRateIcon-up fa fa-thumbs-o-up fa-2x"></span> {$post.pos_reputation} </div>
										<div class="forumRate forum-rate-negative {if $post.user_reputation != null && $post.user_reputation == 0} marked {else} unmarked{/if}">	<span class="forumRateIcon forumRateIcon-down fa fa-thumbs-o-down fa-2x"></span> {$post.neg_reputation} </div>
									</div>
								</div><!-- /forum post -->
															
								{if isset($post.replies)}
									
									
									{foreach $post.replies as $reply}
									<hr>
									<!-- forum post reply -->
									<div class="row forum-post-reply forum-post">
										<span class="postId" hidden>{$reply.id}</span>
										<!-- post rating -->
										<div class="col-md-2 col-lg-2 post-author" style="text-align:center;">

                                            {if !isset($reply.img_owner) || $reply.img_owner==""}
                                                <img class="img-circle" src="http://placehold.it/48x48" href="userpage.php"><br>
                                            {else}
                                                <img class="img-circle img-responsive" src="../images/profileImages/thumb_{$reply.img_owner}" href="userpage.php" height="48" width="48"><br>
                                            {/if}
                                            <a href="#" class="post-action-author">{$reply.owner}</a><br>
											<a href="#" class="post-action-time">{$reply.creation_date}</a><br>
										</div><!-- /post rating -->
										<div class="col-md-9 col-lg-9 post-content">
											<p class="text-justify"> {$reply.message} </p>

										</div>
										<div class="col-md-1 col-lg-1">
											<div class="forumRate forum-rate-positive {if $reply.user_reputation == 1} marked {else} unmarked{/if}">	<span class="forumRateIcon forumRateIcon-up fa fa-thumbs-o-up fa-2x"></span> {$reply.pos_reputation} </div>
											<div class="forumRate forum-rate-negative {if $reply.user_reputation != null &&  $reply.user_reputation == 0} marked {else} unmarked{/if}">	<span class="forumRateIcon forumRateIcon-down fa fa-thumbs-o-down fa-2x"></span> {$reply.neg_reputation} </div>
										</div>

										
									</div><!-- /forum post reply-->

									{/foreach}

								{/if}
								</div>
							<hr class="style-one">
							
						{/foreach}
						{else}
						<div class="group-posts">
						</div>
						{/if}
						
					
					</div><!-- /forum posts-->
					<div class="col-md-1 col-lg-1"><!--empty content--></div>
				</div><!-- /forum -->