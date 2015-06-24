var app = angular.module('myApp', ['ui.bootstrap', 'toaster']);

app.controller('myController', function ($scope, $sce, $http, $filter, $modal, toaster) {
    $scope.constant = {
        "menuItem" : $core.menuItem,
        "unitPrice" : $core.unitPrice,
        "deliveryFee" : $core.deliveryFee
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
