angular.module('starter.controllers')
    .controller('ClientViewOrderCtrl', [
        '$scope', '$stateParams', 'appConfig', '$http', '$resource', 'Product', '$ionicLoading',  '$localStorage', 'ClientOrder',
        function($scope, $stateParams, appConfig, $http, $resource, Product, $ionicLoading, $localStorage, ClientOrder) {



        //delete window.localStorage['cart'];
        $scope.order = {};

        $ionicLoading.show({
            template: 'Carregando...'
        });

            ClientOrder.get({id: $stateParams.id, include: "items,cupom"}, function(data){

            $scope.order = data.data;
            $ionicLoading.hide();
        }, function(dataError){
            $ionicLoading.hide();
        });
    }]);