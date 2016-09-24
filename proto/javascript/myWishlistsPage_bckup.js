var createWishlistItem;

$(document).ready(function(){
	
	//on load
	$('.page').first().parent().addClass("active");
	var currentIndex = 2; //first is <<
	var numPages = $('.page').length;

	var createWishlistTemplate = $('.create_wishlist_template');
	createWishlistItem = $('.wishlist-item').clone();
	
	//console.log(createWishlistTemplate.html());
	
	var setup = false;
	
	var currentEditWishlistId = -1;
	
	
	var maxPapersHeight = Math.max.apply(null, $("div.papers").map(function ()
	{
		return $(this).height();
	}).get());

	$('div.papers').height(maxPapersHeight);
	/** Modals **/
	
	function showEditConfirmDialog(title, body, okPhrase, closePhrase,jsonObjWishlist){
		var dialog = document.getElementById("modal");
		$(dialog).find("#yesBtn").text(okPhrase);
		$(dialog).find("#noBtn").text(closePhrase);
		$( "#confirmation" ).text( body );
		$('#modal .modal-title').text(title);
		

		
		$(document.body).on('click', '#modal #yesBtn', function(){
			$.ajax({
				type: "POST",
				url: "../api/edit_wishlist.php",
				data: {'wishlist':jsonObjWishlist, csrf_token:getContentByMetaTagName("token")},
				success: function (res, status){
					//loadWishlist(res['id']);
					location.reload();
				},
				error: function(res, status) {
					console.log(res);
					console.log(status);
							
					return false;
				}
			});
		});
		
		$(dialog).modal('show');
	};
	
	function showDeleteWishlistConfirmDialog(title, body, okPhrase, closePhrase,id){
		var dialog = document.getElementById("modal");
		$(dialog).find("#yesBtn").text(okPhrase);
		$(dialog).find("#noBtn").text(closePhrase);
		$( "#confirmation" ).text( body );
		$('#modal .modal-title').text(title);
		
		console.log(id);
		
		$(document.body).on('click', '#modal #yesBtn', function(){
			$.ajax({
				type: "POST",
				url: "../api/delete_wishlist.php",
				data: {'id':id, csrf_token:getContentByMetaTagName("token")},
				success: function (res, status){
					location.reload();				
				},
				error: function(res, status) {
					console.log(res);
					console.log(status);
							
					return false;
				}
			});
		});
		
		$(dialog).modal('show');
	};
	
	function showEditWishlist(){
		if($('.create_wishlist_template').is(':hidden')){
			$('.create_wishlist_template').show('slow');
			
			$('#btn-create-wishlist i').switchClass('fa-plus-circle', 'fa-minus-circle');

			$("html, body").animate({ scrollTop: 0 }, "slow");
			
			setupGrid();
		}
	}
	
	function showViewWishlist(){
		if($('.view_wishlist_template').is(':hidden')){
			
			$('.view_wishlist_template').show('slow');
			
			$("html, body").animate({ scrollTop: 0 }, "slow");
			
			$('#btn-create-wishlist i').switchClass('fa-minus-circle', 'fa-plus-circle');
		}
	}
	
	$(document.body).on('click', '#btn-create-wishlist', function(e){
		e.preventDefault();
		
		if($(this).find('i').hasClass('fa-plus-circle')){
			$('.create_wishlist_template').remove();
			$('.view_wishlist_template').remove();
			$(createWishlistTemplate.clone()).insertBefore('#wishlists_list');
			
			showEditWishlist();
			currentEditWishlistId = -1;
		}
		else if($(this).find('i').hasClass('fa-minus-circle')){
			setupGrid();
			$('.create_wishlist_template').hide('slow');
			$('#btn-create-wishlist i').switchClass('fa-minus-circle', 'fa-plus-circle');
		}
		
	});

	$(document.body).on('click', '.pagination li:last-child',function(e){
		e.preventDefault();
		if(currentIndex == numPages+1) return;
		var nextIndex = currentIndex+1;
		$('.pagination li:nth-child('+nextIndex+')>a').trigger('click');
	});
	
	$(document.body).on('click', '.pagination li:first-child', function(e){
		e.preventDefault();
		if(currentIndex == 2) return;
		var previousIndex = currentIndex-1;
		$('.pagination li:nth-child('+previousIndex+')>a').trigger('click');
	});
	
	$(document.body).on('click', '.page', function(e){
		e.preventDefault();
		var pageNum = $(this).text();
		var owner = $(document).find('#title').find('span').text();
		console.log(owner);
		$.ajax({
			type: "GET",
			url: "../api/list_user_wishlists.php",
			data: {page: pageNum, pageOwner: owner},
			success: function (res, status){
				currentIndex = ++pageNum;
				console.log(res);
				$('#wishlists_list').remove();
				var newContent = $(res).find('#wishlists_list');
				$(newContent).insertAfter($('.create_wishlist_template'));
				
				$('.pagination li').removeClass('active');
				$('.pagination li:nth-child('+currentIndex+')').addClass("active");
				
			},
			error: function(res, status) {
				console.log(res);
				console.log(status);
						
				return false;
			}
		});
		
	});
	
	function loadWishlist(id){
		$.ajax({
			type: "GET",
			url: "../api/load_wishlist.php",
			data: {'id':id, 'view':true },
			success: function (res, status){
				$('.create_wishlist_template').remove();
				$('.view_wishlist_template').remove();
				// console.log(res);
				$(res).insertBefore('#wishlists_list');

				showViewWishlist();
			},
			error: function(res, status) {
				console.log(res);
				console.log(status);
						
				return false;
			}
		});
	}

	$(document.body).on('click', '#wishlists_list div.papers-link', function(e){
		e.preventDefault();
		
		//load values
		var id = $(this).attr('href').substring(1);
		
		loadWishlist(id);
		
		
	});



	$(document).on('click',".btn-group-privacy button",function(){
		$('.btn-group-privacy button').removeClass('active');
		$(this).addClass("active");
		privacy = $(this).val();
		
	});
	
	
	
	
	
	$(document.body).on('click', '.editWishlist', function(e){
		var id = $(this).attr('href').substring(1);
		currentEditWishlistId = id;
		
		$.ajax({
			type: "GET",
			url: "../api/load_wishlist.php",
			data: {'id':id, 'view':false },
			success: function (res, status){
				$('.create_wishlist_template').remove();
				$('.view_wishlist_template').remove();
				
				$(res).insertBefore('#wishlists_list');
				showEditWishlist();
				//$('.create_wishlist_template').show('slow');
			
				if( $(res).find('.grid-stack').children().length == 0 )
					$('#wishlist-form').append('<div class="row" style="text-align: center;"><a href="javascript:void(0);" ><i id="AddFirstItem" class="fa fa-plus fa-2x form-icon-options" onclick="addNewItem(this)"></i></a></div>');

			},
			error: function(res, status) {
				console.log(res);
				console.log(status);
						
				return false;
			}
		});
		
		
		
	});
	
	
	$(document.body).on('click', '.deleteWishlist', function(e){
		var id = $(this).attr('href').substring(1);

		showDeleteWishlistConfirmDialog("Confirmation", "Are you sure you want to delete this wishlist and all its items?", "Yes", "No", id);
	});
	
	
	$(document.body).on('click', '#cancelEdit', function(){
		location.reload();
	})
	
	$(document.body).on('click', '#saveWishlist', function(){
		var id;
		if(currentEditWishlistId==-1) id = 0;
		else id = currentEditWishlistId;
		console.log("id: "+id);
		
		var title = $('#wishlistTitle').val();
		var occasion = $('#occasion').find(":selected").val();
		var privacy = $('#privacy').find(".active").val();
		

		
		jsonObjItems = [];
		$(".wishlist-item").each(function() {
	
			var img = $(this).find('.dz-image').children('img').attr('alt');
			var itemName = $(this).find('.item-name').val();
			var itemLink = $(this).find('.item-link').val();
			var itemPrice = $(this).find('.item-price').val();
			var itemRating = $(this).find('.item-rating').val();
			var itemNote = $(this).find('.item-note').val();
			
			item = {}
			item["name"] = itemName;
			item["image"] = img;
			item["link"] = itemLink;
			item ["note"] = itemNote;
			item["price"] = itemPrice;
			item["rating"] = itemRating;

      console.log(item);
      
			jsonObjItems.push(item);
		});

		//console.log(jsonObjItems);
		
		jsonObjWishlist=JSON.stringify({'id':id, 'title':title, 'privacy':privacy, 'occasion':occasion, 'items':jsonObjItems});
		
		//console.log(jsonObjWishlist);
		
		showEditConfirmDialog("Confirmation", "Are you sure you want to edit?", "Yes", "No", jsonObjWishlist);
	});
});

// Add new wishlist item //
function addNewItem(element){
	var grid = $('.grid-stack').data('gridstack');
	
	if( $(element).attr('id') === 'AddFirstItem' ){
		$('#pNoItems').remove();
		$('#AddFirstItem').parent().parent().remove();
		grid.add_widget(createWishlistItem.clone(), 0, 0, 0, 0, false);
	} else {
		var super_parent = $(element).parents('.grid-stack-item');
		grid.add_widget(createWishlistItem.clone(), 0, parseInt(super_parent.attr('data-gs-y'))+1, 0, 0, false);
	}
	setupDropzone();
}

// Remove the selected element //
function removeItem(element){
	var super_parent = $(element).parents('.grid-stack-item');
	var grid = $('.grid-stack').data('gridstack');
	grid.remove_widget(super_parent, true);
	
	// The grid has no more items
	if( $('.grid-stack').children().size() == 1 ){
		$('#wishlist-form').append('<div class="row" style="text-align: center;"><a href="javascript:void(0);" ><i id="AddFirstItem" class="fa fa-plus fa-2x form-icon-options" onclick="addNewItem(this)"></i></a></div>');
	}
}

// Gridstack //
function setupGrid() {
	
	var options = {
		draggable: {
			"handle": ".the-dragger"
		}
	};
	$('.grid-stack').gridstack(options);
	$('.grid-stack').data('gridstack').cell_height(400); // Maybe this should be changed to the actual value

	setupDropzone();
}

// Dropzone //
function setupDropzone(){
	Dropzone.autoDiscover = false;
	var i=0;
	$('.img-upload > .thumbnail').each(function () {
		++i;
		if($(this).children().size() == 0){
			var dropzoneItem = $("<form id=\"dropzone-form" + i +"\" action=\"../actions/uploadImage.php\"></form>");
			
			dropzoneItem.height(220);
			dropzoneItem.addClass("dropzone");
			dropzoneItem.width(210)
			$(this).append(dropzoneItem);
			dropzoneItem.dropzone({ url: "../actions/uploadImage.php?type=wishlistItem", thumbnailWidth: 210, thumbnailHeight: 220, maxFiles: 1, maxfilesexceeded: function(file) {this.removeAllFiles(); this.addFile(file);}});
		}
	});
}

