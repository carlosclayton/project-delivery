angular.module('starter.controllers')
    .controller('ClientViewOrderCtrl', [
        '$scope', '$stateParams', 'appConfig', '$http', '$resource', 'Product', '$ionicLoading',  '$localStorage', 'Order',
        function($scope, $stateParams, appConfig, $http, $resource, Product, $ionicLoading, $localStorage, Order) {



        //delete window.localStorage['cart'];
        $scope.order = {};

        $ionicLoading.show({
            template: 'Carregando...'
        });

        Order.get({id: $stateParams.id, include: "items,cupom"}, function(data){

            $scope.order = data.data;
            $ionicLoading.hide();
        }, function(dataError){
            $ionicLoading.hide();
        });
    }]);