
				<div id="main_col" class="col-sm-8 col-lg-8 col-md-8"><!-- MAIN COLUMN -->
					<div class="row">

						<div class="panel panel-default panel-custom">
							<div class="panel-body">
								<div style="overflow:hidden;">
									<p class="lead" id="title"><span hidden>{if $username === $page_owner}{$username}{else}{$page_owner}{/if}</span>{if {$username} == {$page_owner}}My wishlists{else}{$page_owner}'s Wishlists{/if}</p>
									{if $username == $page_owner}<a  href="" id="btn-create-wishlist"><i class="fa fa-plus-circle fa-4x"></i></a>{/if}
								</div>
								
								<hr class="style-one">
								
								
								{include file='../../wishlist/create_wishlists_template.tpl'}

								
								{include file='./wishlists_list_template.tpl'}
								
								<div class="row">
									<nav style="text-align:center;">
									  <ul class="pagination">
										<li>
										  <a href="" aria-label="Previous">
											<span aria-hidden="true">&laquo;</span>
										  </a>
										</li>
										{for $i = 1 to $numberPages}
										<li><a class="page" href="">{$i}</a></li>
										{/for}
										<li>
										  <a href="#" aria-label="Next">
											<span aria-hidden="true">&raquo;</span>
										  </a>
										</li>
									  </ul>
									</nav>
					
								</div><!--/row-->
								
							</div> <!-- /panel-body-->
						</div><!-- /panel-default-->
					</div><!--/row-->
					
				</div> <!-- /MAIN COLUMN -->