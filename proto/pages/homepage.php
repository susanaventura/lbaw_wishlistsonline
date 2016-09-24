<?php 
include_once('../config/init.php'); 

if(isset($_SESSION['username']) && isset($_SESSION['userId'])) {
	header('Location: '.$BASE_URL.'pages/wallPage.php'); exit;
}

?>

<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8">
	<meta name="viewport"    content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author"      content="LBAW 65">
	
	<title>Wishlists Online</title>

	<!--<link rel="shortcut icon" href="assets/images/gt_favicon.png">-->
	
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet"  href="http://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="../lib/bootstrap/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="../css/homepage.css">
	<link rel="stylesheet" href="../css/login_registration_forms.css">
	<link rel="stylesheet" href="../css/customTooltip.css">
	<!-- custom styles for inputs -->
	<link href="../css/custom_input.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->

	
</head>

<body class="home">

		<!-- confirmation modal -->
		<div id="modal" class="modal fade">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <!-- dialog header -->
			  <div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				  <h4 class="modal-title">Confirmation</h4>
			  </div>
			  <!-- dialog body -->
			  <div class="modal-body">
				<p id="confirmation"></p>
			  </div>
			  <!-- dialog buttons -->
			  <div class="modal-footer">
				<button id="yesBtn" type="button" class="btn btn-primary">Yes</button>
				<button id="noBtn" type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true">No</button>
			</div>
			</div>
		  </div>
		</div>
	
	
	<!-- Header -->
	<header id="head">

		<div class="container-fluid">
			<!--<div class="row">-->
				<!-- Left heading text -->
				<div class="col-md-6 col-sm-6 intro-section">
					<h1 class="lead website-title">Wishlists Online</h1>		
				</div>
				<!-- Login/Resgistration forms -->
				<div class="col-md-6 col-sm-6" id="loginSignup" style="margin-bottom: 20px;"></div>
			<!--</div>-->
		</div>
	</header>
	<!-- /Header -->

	<!-- Intro -->
	<div class="container text-center">
		<br> <br>
		<h2 class="thin">Get always what you want. Always know what to give</h2>
		<p>
			Get rid of all worries about what you're going to give to other people on special occasions and be sure that you always receive what you really want
		</p>
	</div>
	<!-- /Intro-->
		
	<!-- Highlights - jumbotron -->
	<div class="jumbotron top-space">
		<div class="container">
			
			<h3 class="text-center thin">Features</h3>
			
			<div class="row">
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-cogs fa-5"></i>Custom and manageable wishlists</h4></div>
					<div class="h-body text-center">
						<p>Create <strong>cool and customized wishlists</strong> for any occasion you want.</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-circle-o fa-5"></i>Social network</h4></div>
					<div class="h-body text-center">
						<p>Wishlists Online is also a <strong>social network</strong>! <strong>Share items with your friends and family</strong>, so everyone knows what you want to receive, and <strong>always know what your friends also want</strong>.</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-comments-o fa-5"></i>Organize who gives what</h4></div>
					<div class="h-body text-center">
						<p>Discuss with your friends and family witch items you want to give by <strong>participate in a forum or mark those items</strong>.</p>
					</div>
				</div>
				<div class="col-md-3 col-sm-6 highlight">
					<div class="h-caption"><h4><i class="fa fa-smile-o fa-5"></i>Easy and free, with constant support</h4></div>
					<div class="h-body text-center">
						<p>Easy to use and totally free! Any trouble or suggestion? You get <strong>constant support</strong> for every need. </p>
					</div>
				</div>
			</div> <!-- /row  -->
		
		</div>
	</div>
	<!-- /Highlights -->
	
	<!-- container -->
	<div class="container">

		<h2 class="text-center top-space">Take a look</h2>
		<br>

		<div class="row">
			<div class="col-sm-6">
				<img src="../images/homepage/create_wishlist.png"></img>
			</div>
			<div class="col-sm-6">
				<h3>Manage your wishes</h3>
				<p>You have a personal page, where are all your wishlists, so you can easly edit them. To create a new wishlist, just click on the purple button. Choose your wishlit's privacy, the occasion, and add all the items you want. You can also upload a picture for each item, specify the price, how much you want that item, among other things</p>
			</div>
		</div> <!-- /row -->

		<div class="row" style="padding-top:15px">
			<div class="col-sm-6">
				<h3>Comment on forums</h3>
				<p>If you go to a specific wishlist's page (just click on a wishlist title) you can participate on that wishlist's forum. Click on "comment" to add a main post or "reply" to add a reply. You also can like or deslike a post.</p>
			</div>
			<div class="col-sm-6">
				<img src="../images/homepage/forum.png"></img>
			</div>
		</div> <!-- /row -->
		<div class="row" style="padding-top:15px">
			<div class="col-sm-6">
				<img src="../images/homepage/wall.png"></img>
			</div>
			<div class="col-sm-6">
				<h3>Consult your feed</h3>
				<p>All updates or comments from friends you're following will appear on your feed.</p>
			</div>
		</div> <!-- /row -->
		<div class="row" style="padding-top:15px">
			<div class="col-sm-6">
				<h3>Chat with your friends</h3>
				<p>You can chat with your friend by clicking on their nickname on the chat's list</p>
			</div>
			<div class="col-sm-6">
				<img src="../images/homepage/chat.png"></img>
			</div>
		</div> <!-- /row -->

	</div>	<!-- /container -->
	
	<!-- Social links. @TODO: replace by link/instructions in template -->
	<section id="social">
		<div class="container">
			<div class="wrapper clearfix">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_linkedin_counter"></a>
				<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
				</div>
				<!-- AddThis Button END -->
			</div>
		</div>
	</section>
	<!-- /social links -->


	<footer id="footer" class="top-space">

		<div class="footer2">
			<div class="container">
				<div class="row">
					<div class="col-md-12 widget">
						<div class="widget-body">
							<p class="text-right">
								Copyright &copy; 2015, Anwaar Hussein | Luis Reis | Rui Grandão | Susana Ventura
							</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

	</footer>	
		




	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="../javascript/homepage.js"></script>
	<!--<script src="assets/js/headroom.min.js"></script>-->
	<!--<script src="assets/js/jQuery.headroom.min.js"></script>-->
	<!--<script src="assets/js/template.js"></script>-->
</body>
</html>