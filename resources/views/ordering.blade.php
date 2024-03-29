<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
        <title>{!! APP_NAME !!}</title>
        <link rel="icon" type="img/ico" href="/favicon.ico?v={!! date('Ymd') !!}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='//fonts.googleapis.com/css?family=Roboto:500,100,300,700,400' rel='stylesheet' type="text/css">
        <link href="/assets/vendor/ng-toaster/toaster.css" rel="stylesheet">
		<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="/assets/css/ordering.css?v={!! date('Ymd') !!}" rel="stylesheet">
		<style>
			.main-background {
				background-image: url('/assets/img/chef1.jpg');
				background-size: cover;
			}

			.menu-item-as-background-image {
				min-height: 250px;
				background-image: url('{!! $images[0] !!}');
			}
		</style>
	</head>
	<body ng-app="myApp" ng-controller="myController" class="main-background">
		<toaster-container toaster-options="{'time-out': {!!TOASTER_FADE_OUT!!} }"></toaster-container>
		<div class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
			  	<div class="modal-content">
			      	<div class="modal-header menu-item-as-background-image">
			      		<a href="/" class="btn btn-xs pull-left" style="color:#5A5A5A;">
							<i class="fa fa-arrow-left"></i>
							Back
						</a>
			      	</div>
			      	<div class="modal-body row" style="padding-bottom:5px;">
			      		<form class="form col-md-12 center-block">
			      			<div class="form-group row">
			      				<div class="col-xs-12">
			      					<div class="input-group pull-right" style="max-width:25%;">
									  	<input ng-model="input.quantity" ng-disabled="loading" type="text" class="form-control" style="min-width:38px;margin-left:5px;" placeholder="1" valid-number>
										<span class="input-group-addon">serving(s)</span>
								  	</div>
			            			<h3 style="margin-top:0px;">{!! $title !!}</h3>
			            			<h5>{!! $subtitle !!}</h5>
			            		</div>
			      			</div>
			            	<div class="form-group row">
			            		<div class="col-sm-12">
			            			<span class="lead">
			            				Contact Information
			            			</span>
			            		</div>
			            		<div class="col-sm-7">
		            				<input ng-model="input.contactName" ng-disabled="loading" type="text" class="form-control" placeholder="Name">
			            		</div>
			            		<div class="col-sm-5">
		            				<select ng-model="input.deliveryTime" ng-disabled="loading" class="form-control">
		                                <option value="6.00pm">Deliver at around 6.00pm</option>
		                                <option value="6.15pm">Deliver at around 6.15pm</option>
		                                <option value="6.30pm">Deliver at around 6.30pm</option>
		                                <option value="6.45pm">Deliver at around 6.45pm</option>
		                                <option value="7.00pm">Deliver at around 7.00pm</option>
		                                {{--
		                                <option value="7.15pm">Deliver at around 7.15pm</option>
		                                <option value="7.30pm">Deliver at around 7.30pm</option>
		                            	<option value="7.45pm">Deliver at around 7.45pm</option>
	                                	--}}
	                                </select>
			            		</div>
			              	</div>
				            <div class="form-group row">
			            		<div class="col-sm-5">
		            				<input ng-model="input.contactNumber" ng-disabled="loading" type="text" class="form-control" placeholder="Phone number" valid-number-phone>
			            		</div>
			            		<div class="col-sm-7">
		            				<input ng-model="input.contactEmail" ng-disabled="loading" type="text" class="form-control" placeholder="Email">
			            		</div>
			              	</div>
				            <div class="form-group row">
				            	<div class="col-xs-12">
			            			<span class="lead">
			            				Delivery Address
			            			</span>
			            		</div>
			            	    <div class="col-xs-9">
		                            <input ng-model="input.addressLine1" ng-disabled="loading" type="text" class="form-control" placeholder="Street Address">
		                        </div>
		                        <div class="col-xs-3">
		                            <input ng-model="input.addressLine2" ng-disabled="loading" type="text" class="form-control" placeholder="Apt #">
		                        </div>
			              	</div>
				            <div class="form-group row">
		                        <div class="col-sm-6">
		                            <select ng-model="input.addressCity" ng-disabled="loading" class="form-control">
		                                <option value="Kitchener">Kitchener</option>
		                                <option value="Waterloo">Waterloo</option>
		                            </select>
		                        </div>
		                        <div class="col-sm-3 col-xs-6">
		                            <select ng-model="input.addressProvince" ng-disabled="true" class="form-control">
		                                <option value="Ontario">Ontario</option>
		                            </select>
		                        </div>
		                        <div class="col-sm-3 col-xs-6">
		                            <input ng-model="input.addressPostal" ng-disabled="loading" type="text" class="form-control" placeholder="Postal Code">
		                        </div>
		                    </div>
		                    <hr>
		                    <div class="form-group">
		                    	<p style="font-size:17px">
				                    <b>Food cost: </b>
				                    <span ng-bind="foodCost | currency" class="pull-right"></span>
				                </p>
				                <p style="margin-bottom:5px;font-size:17px">
				                    <b>Delivery fee: </b>
				                    <span ng-bind="{!!DELIVERY_FEE!!} | currency" class="pull-right" style="text"></span>
				                </p>
				                <p style="border-top:double;font-size:17px">
				                    <b>Payment due: </b>
				                    <span ng-bind="paymentDue | currency" class="pull-right"></span>
				                </p>
		                    </div>

				            <div class="form-group">
				              	<button ng-click="stripeRun($event)" ng-disabled="loading" class="btn btn-success btn-lg btn-block">
				              		<i class="fa fa-taxi"></i>
				              		Place Order
				              	</button>
			            	</div>
			          	</form>
			          	<div>
				          	<div class="col-md-6">
				          		<p>
					          		Delivers right to your door<br>
					        		<a href="http://williecheong.com">
					        			Need help?
					        		</a>
				        		</p>
				          	</div>
				          	<div class="col-md-6 text-right">
				          		<img src="/assets/img/payment-stripe.png" style="max-height:40px;">
				          	</div>	
				        </div>
			      	</div>
			  	</div>
		  	</div>
		</div>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.11.0/ui-bootstrap-tpls.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.20/angular-animate.min.js"></script>
        
        <script src="https://js.stripe.com/v2/" type="text/javascript"></script>
		<script src="https://checkout.stripe.com/checkout.js"></script>
        
        <script src="/assets/vendor/ng-toaster/toaster.js"></script>
        <script src="/assets/js/ordering.js?v={!! date('Ymd') !!}"></script>
        <script>
        	$core = {
		        "title" : "{!! $title !!}",
        		"image" : "{!! $images[0] !!}",
		        "menuItem" : "{!! $menuItem !!}",
		        "stripeKey" : "{!! env('STRIPE_PUBLISHABLE_KEY') !!}",
		    };
        </script>
        @if ($app->environment('production'))
        	@include('templates.analytics')
        @endif
	</body>
</html>
