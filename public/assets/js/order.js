var app = angular.module('myApp', ['ui.bootstrap']);

app.controller('myController', function ($scope, $sce, $http, $filter, $modal) {
    $scope.constant = {
        "menuItem" : $core.menuItem,
        "unitPrice" : $core.unitPrice,
        "deliveryCharge" : $core.deliveryCharge
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
        $scope.foodCost = newValue * $scope.constant.unitPrice;
        $scope.paymentDue = $scope.foodCost + $scope.constant.deliveryCharge;
        if ($scope.input.quantity == 0) {
            $scope.paymentDue = 0;
        }
    });

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
