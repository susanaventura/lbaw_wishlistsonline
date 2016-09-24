$(document).ready(function(){
	
	$('.option-share-wishlist').on('click', function(){
		var url = "http://localhost/lbaw/wishlists-online/proto/pages/wishlistPage.php?id=";
		url += $(this).find('+span').val();
	
		var input = $("<input type=\"text\"></input>");
		input.val(url);
		input.select();
		$(this).replaceWith(input);		
	});	
	
	
});