<div id="main_col" class="col-sm-8 col-lg-8 col-md-8"><!-- MAIN COLUMN -->

	{foreach $rows as $row}
	<div class="row">
		<!--content-->
		<div class="panel panel-default">
			<div class="panel-body panel-wall panel-custom">
				<header>
					<div class="row">
						<ol>
							<li>
                                {if !isset($row.msgHeader.head_img) || $row.msgHeader.head_img==""}
                                    <img class="img-round" src="http://placehold.it/64x64" href="userpage.php" style="float:left;">
                                {else}
                                    <img class="img-round img-responsive" src="../images/profileImages/thumb_{$row.msgHeader.head_img}" href="userpage.php" height="64" width="64" style="float:left;">
                                {/if}

								<div class="post-header-info">
									<a href="../pages/myWishlistsPage.php?username={$row.msgHeader.header_owner}" class="post-action-author">{$row.msgHeader.header_owner}</a><br>
									<p class="post-action-time">{if {$row.msgHeader.time}}{$row.msgHeader.time} ago{else}now{/if}<span class="header_date" hidden>{$row.msgHeader.date}</span></p>
									<a href="forumPost.php" class="post-action-action">{$row.msgHeader.msg}</a>
								</div>
							</li>
						</ol>
					</div>
				</header>
				<hr class="style-seven">
				
				{include file='./feed_view_wishlist_template.tpl'}
				
				<!--wishlist options-->
				<div class="row">
					<div class="col-md-1 col-lg-1"><!--empty content--></div>
					<div class="col-md-10 col-lg-10">
						<ul class="list-inline pull-right wishlist-view-options">
							<a class="forumPostComment forumPostOption option-share-wishlist">share</a>
								<span hidden>{$row.wishlist.id}</span>
							</li>
						</ul>
					</div>
					<div class="col-md-1 col-lg-1"><!--empty content--></div>
				</div><!-- /wishlist options-->
					
				{if isset($row.forum_posts)} {include file='./forum/feed_forum.tpl'} {/if}

			</div><!-- /panel-body-->
		</div><!-- /panel -->
	</div><!-- /row-->
	{/foreach}

</div> <!-- /MAIN COLUMN -->	

<script src="../javascript/wallpage.js"></script>