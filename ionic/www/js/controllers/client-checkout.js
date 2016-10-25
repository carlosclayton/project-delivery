angular.module('starter.controllers')
    .controller('ClientCheckoutCtrl', ['$scope', '$state', '$cart', '$localStorage', '$ionicLoading', '$ionicPopup', 'Order', 'Cupom', '$cordovaBarcodeScanner',
        function ($scope, $state, $cart, $localStorage, $ionicLoading, $ionicPopup, Order, Cupom, $cordovaBarcodeScanner) {
            var cart = $cart.get();
            /*
             Cupom.get({code: 102}, function(data){

             $cart.setCupom(data.data.code, data.data.value);
             //$cart.removeCupom();
             console.log($cart.getTotalFinal());
             }, function(responseError){

             });
             */

            $scope.cupom = cart.cupom;
            $scope.items = cart.items;
            $scope.total = $cart.getTotalFinal();

            $scope.removeItem = function (i) {
                $cart.removeItem(i);
                $scope.items.splice(i, 1);
                $scope.total = $cart.get().total;
            };
            //console.log($localStorage.getObject('cart'));
            //console.log(cart);
            $scope.openProductDetail = function (i) {
                console.log(i);
                $state.go('client.checkout_item_detail', {index: i});
            };

            $scope.openListProducts = function () {
                $state.go('client.view_products');
            };

            $scope.save = function () {
                //var items = angular.copy($scope.items);
                var o = {items: angular.copy($scope.items)};
                angular.forEach(o.items, function (item) {
                    item.product_id = item.id;
                });

                $ionicLoading.show({
                    template: 'Carregando...'
                });
                if ($scope.cupom.value) {
                    o.cupom_code = $scope.cupom.code;
                }

                Order.save({id: null}, o, function (data) {
                    $ionicLoading.hide();
                    $state.go('client.checkout_successful');
                }, function (responseError) {
                    $ionicLoading.hide();
                    $ionicPopup.alert({
                        title: 'Erro',
                        template: 'Pedido não realizado, tente novamente.'
                    })

                });
            };

            $scope.readBarCode = function () {
                getValueCupom(102);
                /*
                $cordovaBarcodeScanner
                    .scan()
                    .then(function (barcodeData) {
                        getValueCupom(barcodeData.text);
                    }, function (error) {
                        $ionicPopup.alert({
                            title: 'Atenção',
                            template: 'Não foi possível ler o código de barra, tente novamente.'
                        })
                    });
                    */

            };

            $scope.removeCupom = function () {
                $cart.removeCupom();
                $scope.cupom = $cart.get().cupom;
                $scope.total = $cart.getTotalFinal();
            };

            //private methods

            function getValueCupom(code) {
                $ionicLoading.show({
                    template: 'Carregando...'
                });


                Cupom.get({code: code}, function (data) {
                    $cart.setCupom(data.data.code, data.data.value);
                    $scope.cupom = $cart.get().cupom;
                    $scope.total = $cart.getTotalFinal();
                    $ionicLoading.hide();
                }, function (responseError) {
                    $ionicLoading.hide();
                    $ionicPopup.alert({
                        title: 'Atenção',
                        template: 'Cupom inválido!.'
                    })

                });
            };

        }]);

