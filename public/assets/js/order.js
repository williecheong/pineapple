var app = angular.module('myApp', ['ui.bootstrap', 'toaster']);

app.controller('myController', function ($scope, $sce, $http, $filter, $modal, toaster) {
    $scope.constant = {
        "title" : $core.title,
        "image" : $core.image,
        "menuItem" : $core.menuItem,
        "stripeKey" : $core.stripeKey,
    };

    $scope.input = {
        "quantity" : 1,
        "contactName" : "",
        "contactNumber" : "",
        "contactEmail" : "",
        "deliveryTime" : "6.00pm",
        "addressLine1" : "",
        "addressLine2" : "",
        "addressCity" : "Waterloo",
        "addressProvince" : "Ontario",
        "addressPostal" : "",
    };

    $scope.$watch("input.quantity", function(newValue, oldValue) {
        if (!newValue) { newValue = 0; }

        $http.get('/api/cost/' + $scope.constant.menuItem + '/' + newValue).success(function(data, status, headers, config) {
            $scope.foodCost = data.foodCost;
            $scope.paymentDue = data.paymentDue;
            return;
        }).error(function(data, status, headers, config) {
            toaster.pop('error', 'Error: ' + status, data.message);
            console.log(data);
            return;
        });
    });

    $scope.stripeRun = function(e) {
        if (!$scope.input.quantity || $scope.input.quantity == 0) {
            toaster.pop('error', 'Error', "Quantity must be a valid number");
            return;
        }
        
        if (!$scope.input.contactName) {
            toaster.pop('error', 'Error', "Name must not be empty");
            return;
        }

        if (!$scope.input.contactNumber || $scope.input.contactNumber.toString().length < 10) {
            toaster.pop('error', 'Error', "Contact number is invalid");
            return;
        }

        if (!$scope.validateEmail($scope.input.contactEmail)) {
            toaster.pop('error', 'Error', "Contact email is invalid");
            return;
        }

        if ( $scope.input.deliveryTime != '6.00pm' 
          && $scope.input.deliveryTime != '6.15pm' 
          && $scope.input.deliveryTime != '6.30pm' 
          && $scope.input.deliveryTime != '6.45pm' 
          && $scope.input.deliveryTime != '7.00pm' 
          && $scope.input.deliveryTime != '7.15pm' 
          && $scope.input.deliveryTime != '7.30pm' 
          && $scope.input.deliveryTime != '7.45pm' ) {
            toaster.pop('error', 'Error', "Invalid delivery time");
            return;
        }

        if (!$scope.input.addressLine1) {
            toaster.pop('error', 'Error', "Street address must be specified");
            return;
        }

        if ( $scope.input.addressCity != 'Kitchener' 
          && $scope.input.addressCity != 'Waterloo' ) {
            toaster.pop('error', 'Error', "Delivery not available in selected city");
            return;
        }

        if ($scope.input.addressProvince != 'Ontario') {
            toaster.pop('error', 'Error', "Delivery not available in selected province");
            return;
        }

        if ( !$scope.input.addressPostal 
          || !$scope.validateAlphaNumeric($scope.input.addressPostal) 
          || $scope.input.addressPostal.toString().length < 6) {
            toaster.pop('error', 'Error', "Postal code must be valid");
            return;
        }
        
        // Open Checkout with further options
        $scope.stripeHandler.open({
            name: 'Order for Tomorrow',
            image: $scope.constants.image,
            email: $scope.input.contactEmail,
            description : $scope.constants.title,
            amount : parseFloat($scope.paymentDue) * 100,
            currency : 'CAD',
            allowRememberMe : false
        });
        e.preventDefault();
    };

    $scope.stripeInitialize = function() {
        $scope.stripeHandler = StripeCheckout.configure({
            key: $scope.constants.stripeKey,
            image: $scope.constants.image,
            token: function(token) {
                // You can access the token ID with `token.id`
                $scope.loading = true;
                $http({
                    'method': 'POST',
                    'url': '/api/order',
                    'data': {
                        'stripeToken' : token.id,
                        'orderItem' : $scope.constant.menuItem,
                        'quantity' : $scope.input.quantity,
                        'contactName' : $scope.input.contactName,
                        'contactNumber' : $scope.input.contactNumber,
                        'contactEmail' : $scope.input.contactEmail,
                        'deliveryTime' : $scope.input.deliveryTime,
                        'addressLine1' : $scope.input.addressLine1,
                        'addressLine2' : $scope.input.addressLine2,
                        'addressCity' : $scope.input.addressCity,
                        'addressProvince' : $scope.input.addressProvince,
                        'addressPostal' : $scope.input.addressPostal,
                    }
                }).success(function(data, status, headers, config) {
                    toaster.pop('success', 'Success: ' + status, data.message);
                    $scope.stripeHandler.close();
                    setTimeout(function() {
                        window.location.href = '/';
                    }, 1500);
                
                }).error(function(data, status, headers, config) {
                    toaster.pop('error', 'Error: ' + status, data.message);
                    $scope.stripeHandler.close();
                    $scope.loading = false;
                });
            }
        });
    };

    $scope.validateEmail = function(email) {
        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        return re.test(email);
    }

    $scope.validateAlphaNumeric = function(input) {
        if ( /[^a-zA-Z0-9]/.test(input) ) {
           return false;
        }
        return true;     
     }

}).directive('validNumber', function() {
    return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
            if(!ngModelCtrl) {
                return; 
            }

            ngModelCtrl.$parsers.push(function(val) {
                var clean = val.replace( /[^0-9]+/g, '');
                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });

            element.bind('keypress', function(event) {
                if(event.keyCode === 32) {
                    event.preventDefault();
                }
            });
        }
    };

}).directive('validDecimal', function() {
    return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
            if(!ngModelCtrl) {
                return; 
            }
            ngModelCtrl.$parsers.push(function(val) {
                if (angular.isUndefined(val)) {
                    var val = '';
                }
                var clean = val.replace(/[^0-9\.]/g, '');
                var decimalCheck = clean.split('.');
                if(!angular.isUndefined(decimalCheck[1])) {
                    decimalCheck[1] = decimalCheck[1].slice(0,2);
                    clean =decimalCheck[0] + '.' + decimalCheck[1];
                }
                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });
            element.bind('keypress', function(event) {
            if(event.keyCode === 32) {
                event.preventDefault();
                }
            });
        }
    };
}).directive('validStripe', function() {
    return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
            if(!ngModelCtrl) {
                return; 
            }

            ngModelCtrl.$parsers.push(function(val) {
                var clean = val.replace( /[^0-9| |\/]+/g, '');
                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });

            element.bind('keypress', function(event) {
                if(event.keyCode === 32) {
                    event.preventDefault();
                }
            });
        }
    };

}).directive('validNumberPhone', function() {
    return {
        require: '?ngModel',
        link: function(scope, element, attrs, ngModelCtrl) {
            if(!ngModelCtrl) {
                return; 
            }

            ngModelCtrl.$parsers.push(function(val) {
                var clean = val.replace( /[^0-9|-]+/g, '');
                if (val !== clean) {
                    ngModelCtrl.$setViewValue(clean);
                    ngModelCtrl.$render();
                }
                return clean;
            });

            element.bind('keypress', function(event) {
                if(event.keyCode === 32) {
                    event.preventDefault();
                }
            });
        }
    };
    
});
