angular.module('starter.controllers')
    .controller('ClientCheckoutSuccessfulCtrl', ['$scope', '$state', '$cart', '$stateParams', function ($scope, $state, $cart, $stateParams) {
        var cart = $cart.get();
        $scope.items = cart.items;
        $scope.cupom = $cart.cupom;
        $scope.total = $cart.getTotalFinal();
        $cart.clear();


        $scope.openListOrder = function(){

        };
    }]);