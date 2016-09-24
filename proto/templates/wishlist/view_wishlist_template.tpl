				<!-- Wishlist view -->
				<div class="row view_wishlist_template" {if $view_hidden}hidden{/if}>
					<div class="col-md-1 col-lg-1"><!--empty content--></div>
					<div class="col-md-10 col-lg-10 wishlist-view">
						{if !$view_hidden}
						<div class="row post-header">
							<ol>
								<li style="float:right; margin-right:10px;">
                                    {if !isset($wishlist.img_owner) || $wishlist.img_owner==""}
                                        <img class="img-round" src="http://placehold.it/48x48" href="userpage.php" style="float:right;">
                                    {else}
                                        <img class="img-round img-responsive" src="../images/profileImages/thumb_{$wishlist.img_owner}" href="userpage.php" height="48" width="48" style="float:right;">
                                    {/if}

									<div class="post-header-info" style="float:right;">
										<a href="myWishlistsPage.php?username={$wishlist.owner}" class="post-action-author">{$wishlist.owner}</a><br>
										<p class="post-action-time">{$wishlist.last_edit_date}</p>
									</div>
								</li>
							</ol>
						</div>
						{/if}
						<div style="text-align:center;">
							<a style="color:#555555;" href="{$BASE_URL}pages/wishlistPage.php?id={$wishlist.id}"><h1> {$wishlist.title}<small style="font-size:12px; margin-left:10px;">for {$wishlistOccasionName}</small></h1></a>
						</div>
						<hr class="style-one">
						
						{if $items|@count == 0}
						<p class="text-center">No items</p>
						{/if}
						
						{foreach $items as $item}
						<!-- wishlist item -->
						<div class="row wishlist-view-item">
							<div class="col-md-3 col-lg-3">
								{if !isset($item.image) || $item.image==""}
								<img src="http://placehold.it/200x200" alt="itemImage" class="img-responsive media-object">
								{else}
								<img src="../images/wishlistItems/thumb_{$item.image}" alt="Image was not found!" class="img-responsive media-object">
								{/if}
							</div>
							<div class="col-md-7 col-lg-7">
								<div class="wishlist-view-item-info">
									<div class="form-group">
										<p class="item-name">{if isset($item.name)} {$item.name}{/if}</p>
									</div>
									{if isset($item.link)}
									<div class="form-group">
										<a href="#" class="text-italic">{$item.link}</a>
									</div>
									{/if}
									{if isset($item.price)}
									<div class="form-group">
										<p>Estimated price: {$item.price} €</p>
									</div>
									{/if}
									
									<!--<div class="form-group">
										<input {if isset($item.rating)}value="{$item.rating}"{else}value="0"{/if} type="number" class="rating" min=0 max=5 step=0.2 data-size="xs" disabled>
									</div>-->
									{if isset($item.rating)}
									<div class="form-group">
										<p>Rating: {$item.rating}</p>
									</div>
									{/if}
								</div>
							</div>
							
							<div class="col-md-2 col-lg-2" hidden>
								<div class="checkbox checkbox-lg wishlist-view-item-chkbox-centered">
									<label>
										<input type="checkbox" title="Give this item!">
									</label>
								</div>
							</div>
						</div><!-- /wishlist item -->
						{/foreach}
						<hr>

						
					</div>
					<div class="col-md-1 col-lg-1"><!--empty content--></div>
				</div><!-- /Wishlist view -->
				
