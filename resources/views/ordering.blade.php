<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
        <title>Pineapple Kitchens</title>
        <link rel="icon" type="img/ico" href="/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='//fonts.googleapis.com/css?family=Roboto:500,100,300,700,400' rel='stylesheet' type="text/css">
		<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/css/styles.css" rel="stylesheet">
		<style>
			.background-image {
				min-height: 200px;
				background-image: url('{!! $images[0] !!}');
			}
		</style>
	</head>
	<body>
		<!--login modal-->
		<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
		  	<div class="modal-dialog">
			  	<div class="modal-content">
			      	<div class="modal-header background-image"></div>
			      	<div class="modal-body">
			          	<h1 class="text-center">
			          		{!! $title !!}
			          	</h1>
			          	<form class="form col-md-12 center-block">
			            	<div class="form-group">
			              		<input type="text" class="form-control input-lg" placeholder="Email">
				            </div>
				            <div class="form-group">
				              	<button class="btn btn-primary btn-lg btn-block">Place Order</button>
			            	</div>
			          	</form>
			      	</div>
			      	<div class="modal-footer">
			          	<div class="col-md-6 text-left">
			        		<a href="#">Need help?</a>
			          	</div>	
			          	<div class="col-md-6">
			        		<i class="fa fa-lock"></i>
			        		Secured with Stripe
			          	</div>	
			      	</div>
			  	</div>
		  	</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="/assets/js/bootstrap.min.js"></script>
	</body>
</html>