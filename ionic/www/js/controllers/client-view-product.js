angular.module('starter.controllers')
    .controller('ClientViewProductCtrl', [
        '$scope', '$state', 'appConfig', '$http', '$resource', 'Product', '$ionicLoading', '$cart', '$localStorage',
        function($scope, $state, appConfig, $http, $resource, Product, $ionicLoading, $cart, $localStorage) {

            /*
            console.log($localStorage.setObject('cart', {
            name: 'Ionic',
            version: '0.1'

        }));
        */


        //delete window.localStorage['cart'];
        $scope.products = [];

        $ionicLoading.show({
            template: 'Carregando...'
        });

        Product.query({}, function(data){
            console.log('Listagem');
            console.log(data);

            $scope.products = data.data;
            $ionicLoading.hide();

        }, function(dataError){
            $ionicLoading.hide();
        });

        $scope.addItem = function(item){
            item.qtd = 1;
            //$cart.items.push(item);
            $cart.addItem(item);
            $state.go('client.checkout');
        };

    }]);