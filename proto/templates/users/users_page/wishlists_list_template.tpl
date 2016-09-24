<div id="wishlists_list" class="row">
									
	{foreach $wishlists as $wishlist}
		<div class="col-lg-4 col-md-6 col-xs-6 text-center papersElem">
			<div class="papers-link" href="#{$wishlist.id}">
				<div class="papers text-center">
					<h3>{$wishlist.title}</h3>
					

					<h3><small><strong>Last edit:</strong> {date("Y-m-d H:m:s", strtotime({$wishlist.last_edit_date}))}</small></h3>
					<h3><small><strong>Created on: </strong>{date("Y-m-d H:m:s", strtotime({$wishlist.creation_date}))}</small></h3>
					{if isset($display_author) && $display_author == true}<h5>Owner: {$wishlist.owner_username}</h5>{/if}

				</div>
			</div>


            {if isset({$wishlist.owner_username}) && ({$wishlist.owner_username} == $page_owner)}
                <div class="form-group" style="text-align: center;">
                    <a  href="#{$wishlist.id}" class="editWishlist"><i class="fa fa-pencil fa-2x form-icon-options"></i></a>
                    <a  href="#{$wishlist.id}" class="deleteWishlist"><i class="fa fa-trash-o fa-2x form-icon-options"></i></a>
                </div>
            {/if}
		</div>
	{/foreach}
										
</div>