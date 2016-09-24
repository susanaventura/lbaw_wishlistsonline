	<!-- create wishlist template -->
	<div class="row create_wishlist_template" hidden>
		<div class="col-lg-1 col-md-1 col-xs-1"></div>

		<div class="col-lg-10 col-md-10 col-xs-10">
			<div class="wishlist-view"><!-- wishlist border -->
				
				<form id="wishlist-form">
				
					<div class="text-center">
						<div class="btn-group text-center" role="group">
						  <div class="btn-group" role="group">
							<button type="button" class="btn btn-warning" id="cancelEdit">Cancel</button>
						  </div>
						  <div class="btn-group" role="group">
							<button type="button" class="btn btn-success" id="saveWishlist">Save</button>
						  </div>
						</div>
					</div>
					<div class="row">

						<div class="col-md-7">
							<!-- Title -->
							<div class="form-group">
								<label>Wishlist Title <span class="text-danger">*</span></label>
								<input type="text" class="form-control form-control-custom input-lg" id="wishlistTitle" {if isset($wishlist.title)}value="{$wishlist.title}"{/if}>
							</div><!-- /Title -->
						</div>
						

						<div class="col-md-3">				
							<!-- Occasion -->
							<div class="form-group">
								<label class="pull-right">Occasion <span class="text-danger">*</span></label>
								<select id="occasion" class="btn btn-default form-control input-lg">
									{if isset($occasions)}
									{foreach $occasions as $occasion}
									<option value="{$occasion.id}" {if isset($wishlist.occasion) && $wishlist.occasion eq {$occasion.id}}selected{/if}>{$occasion.occasion_name}</option>
									{/foreach}
									{/if}
								</select><!-- /Occasion -->
							</div>
						</div>
						
						<div class="col-md-2">
							<label class="pull-right">Privacy</label>		
							<div id="privacy" class="btn-group btn-group-justified" role="group">
							  <div class="btn-group btn-group-privacy"  role="group">
								<button type="button" value="0" class="btn btn-default form-control-custom input-lg {if isset($wishlist.privacy)}{if $wishlist.privacy == 0} active {/if} {else} active {/if}"><i class="fa fa-lock"></i></button>
							  </div>
							  <div class="btn-group btn-group-privacy" role="group">
								<button type="button" value="1" class="btn btn-default form-control-custom input-lg {if isset($wishlist.privacy)}{if $wishlist.privacy == 1} active {/if} {/if}" ><i class="fa fa-users"></i></button>
							  </div>
							  <div class="btn-group btn-group-privacy" role="group">
								<button type="button" value="2" class="btn btn-default form-control-custom input-lg {if isset($wishlist.privacy)}{if $wishlist.privacy == 2} active {/if} {/if}" ><i class="fa fa-globe"></i></button>
							  </div>
							</div>
						</div>
						
					</div>
					{if $items|@count == 0}
					<p id="pNoItems" class="text-center">No items</p>
					{/if}
					<div class="grid-stack">
						{foreach $items as $item}
						<!-- Input item area -->
						<div class="grid-stack-item wishlist-item" data-gs-no-resize="true" data-gs-x="0" data-gs-y="0" data-gs-min-width="12">
							<div class="grid-stack-item-content">
								<!-- edit area -->
								<div class="media" style="padding-top:20px;">
									
									<div class="media-left media-middle">
										<div class="form-group img-upload">
											<!-- Thumnail-->
											<a href="#" class="thumbnail">

											</a><!-- /Thumnail-->
										</div>
									</div>
									
									<div class="media-body">
										<div class="row" style="padding-top:20px;">
										  <div class="col-lg-12">
												<div class="input-group">
												  <span class="input-group-addon">Item Name<span class="text-danger"> *</span></span>
												  <input type="text" class="form-control form-control-custom item-name" {if isset($item.name)}value="{$item.name}"{/if}>
												</div>
											</div>
										</div>

										<!--Link and price -->
										<div class="row" style="padding-top:20px;">
										  <div class="col-lg-7">
											<div class="input-group">
											  <span class="input-group-addon">Item Link</span>
											  <input type="text" class="form-control form-control-custom item-link " {if isset($item.link)}value="{$item.link}"{/if}>
											</div>
										  </div><!-- /Link -->
										  <div class="col-lg-5">
											<div class="input-group">
											  <span class="input-group-addon" id="basic-addon1">Price (€)</span>
											  <input type="number" class="form-control form-control-custom item-price" {if isset($item.price)}value="{$item.price}"{/if} min="0" max="99999" step="0.1">
											</div>
										  </div><!-- /Price -->
										</div><!-- /Link and price -->
										
										<!-- Rating -->
										<div class="form-group" style="padding-top:20px;">
											<label>How much do you want the product?</label>
											<input id="btn-rating-input" {if isset($item.rating)}value="{$item.rating}"{else}value="1"{/if} type="range" class="item-rating" min=0 max=5>
										</div><!--/Rating-->
										
										<!-- Notes -->
										<div class="form-group">
											<textarea class="form-control form-control-custom item-note" rows="3" placeholder="Add some extra info about this item">{if isset($item.note)}{$item.note}{/if}</textarea>
										</div><!-- /Notes -->
										
									</div><!--/media-body-->
									

								</div><!-- /edit area -->

								<div class="row">
									<div class="col-md-12">
										<div class="form-group" style="text-align: center;">
											<a  href="#"><i class="fa fa-arrows-v fa-2x form-icon-options the-dragger"></i></a>
											<a  href="#"><i class="fa fa-pencil fa-2x form-icon-options"></i></a>
											<a  href="javascript:void(0);"><i class="fa fa-trash-o fa-2x form-icon-options" onclick="removeItem(this)"></i></a>
											<a  href="javascript:void(0);"><i class="fa fa-plus fa-2x form-icon-options" onclick="addNewItem(this)"></i></a>
										</div>
									</div>
								</div>
							</div>
							<hr>
						</div>
						
						{/foreach}
					</div>
				</form>
			</div><!-- /wishlist border -->
		</div>
	</div><!-- /create wishlist template -->
	
	
