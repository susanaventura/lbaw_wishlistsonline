<div id="main_col" class="col-sm-8 col-lg-8 col-md-8"><!-- MAIN COLUMN -->
	<div class="row">
		<!--content-->
		<div class="panel panel-default">
			<div class="panel-body panel-wall panel-custom">
				
				{include file='./view_wishlist_template.tpl'}
				
				<!--wishlist options-->
				<div class="row">
					<div class="col-md-1 col-lg-1"><!--empty content--></div>
					<div class="col-md-10 col-lg-10">
						<ul class="list-inline pull-right wishlist-view-options">
							<li>
								<a class="forumPostComment forumPostOption option-share-wishlist">share</a>
								<span hidden>{$wishlist.id}</span>
								{if $wishlist.canSharePassword } <span hidden>{$wishlist.password}</span> {/if}
							</li>
							{if $username != NULL}
								<li><a class="forumPostReport forumPostOption">report</a></li>
							{/if}
							{if isset($forum_posts)} 
								<li><a class="forumPostReply forumPostOption option-add-main">comment</a></li>
							{/if}
						</ul>
					</div>
					<div class="col-md-1 col-lg-1"><!--empty content--></div>
				</div><!-- /wishlist options-->
					
				{if isset($forum_posts)} {include file='./forum/forum.tpl'} {/if}

			</div><!-- /panel-body-->
		</div><!-- /panel -->
	</div><!-- /row-->

</div> <!-- /MAIN COLUMN -->	
