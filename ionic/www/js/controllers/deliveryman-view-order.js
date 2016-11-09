angular.module('starter.controllers')
    .controller('DeliverymanViewOrderCtrl', [
        '$scope', '$stateParams', 'appConfig', '$http', '$resource', 'Product', '$ionicLoading', '$localStorage', 'DeliverymanOrder', '$cordovaGeolocation','$ionicPopup',
        function ($scope, $stateParams, appConfig, $http, $resource, Product, $ionicLoading, $localStorage, DeliverymanOrder, $cordovaGeolocation, $ionicPopup) {
            var watch, lat = null,long;


            //delete window.localStorage['cart'];
            $scope.order = {};

            $ionicLoading.show({
                template: 'Carregando...'
            });

            DeliverymanOrder.get({id: $stateParams.id, include: "items,cupom"}, function (data) {

                $scope.order = data.data;
                $ionicLoading.hide();
            }, function (dataError) {
                $ionicLoading.hide();
            });

            /*
            DeliverymanOrder.updateStatus({id: $stateParams.id}, {status: 1}, function (data) {
                console.log(data);
            })

            DeliverymanOrder.geo({id: $stateParams.id}, {lat: -23.34234, long: -23 - 98798}, function (data) {
                console.log(data);
            })
            */

            $scope.goToDelivery = function(){
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'Para parar a localização dê Ok.'
                }).then(function(){
                    stopWatchPosition();
                });

                DeliverymanOrder.updateStatus({id: $stateParams.id}, {status: 1}, function(){
                    var whatchOptions = {
                        timeout: 3000,
                        enableHighAccuracy: false
                    }
                    watch = $cordovaGeolocation.watchPosition(whatchOptions);
                    watch.then(
                        null,
                        function(err) {
                            // error
                        },
                        function(position) {
                                if(!lat) {
                                    lat = position.coords.latitude;
                                    long = position.coords.longitude;
                                }else{
                                    long += 0.0020;
                                }
                            console.log(long);
                            DeliverymanOrder.geo({id: $stateParams.id}, {
                                lat  : lat,
                                long : long

                            })
                        }
                    )
                })
            };

            function stopWatchPosition(){
                if(watch && typeof  watch == 'object' && watch.hasOwnProperty('watchID')){
                    $cordovaGeolocation.clearWatch(watch.watchID);
                }
            }

        }]);