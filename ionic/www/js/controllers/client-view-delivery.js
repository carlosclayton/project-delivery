angular.module('starter.controllers')
    .controller('ClientViewDeliveryCtrl', ['$scope', '$state', '$stateParams', 'ClientOrder', '$ionicLoading', '$ionicActionSheet','UserData', '$ionicPopup', '$pusher', '$window', '$map',
        function ($scope, $state, $stateParams, ClientOrder, $ionicLoading, $ionicActionSheet, UserData, $ionicPopup, $pusher, $window, $map) {
            $scope.order = {};
            $scope.map = $map;
            $scope.markers = [];

            $ionicLoading.show({
                template: 'Carregando...'
            });

            ClientOrder.get({id: $stateParams.id, include: "items,cupom"}, function (data) {
                $scope.order = data.data;
                $ionicLoading.hide();

                if(parseInt($scope.order.status, 10) == 1){
                    initMarkers($scope.order);
                }else{
                    $ionicPopup.alert({
                        title: 'Atenção',
                        template: 'Pedido não está em status de entrega.'
                    })
                }

            }, function (dataError) {
                $ionicLoading.hide();
            });


            $scope.$watch('markers.length', function(value){
                console.log("Bounds");
                if(value == 2){

                    createBounds();

                }
            });

            function initMarkers(order){
                var client = UserData.get().client.data;
                var address = client.zipcode + ', ' +  client.address + ', ' + client.city + ' - ' + client.state;
                //var address = '326060188, R. João Paulo II, 100, Betim - MG';
                console.log(address);
                createMarkerClient(address);
                watchPositionDeliveryman(order.hash);
            }

            function createMarkerClient(address){
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    address: address
                }, function(results, status){
                    console.log(results);
                    console.log(status);

                    if(status == google.maps.GeocoderStatus.OK){
                        var lat = results[0].geometry.location.lat(),
                            long = results[0].geometry.location.lng();

                        $scope.markers.push({
                            id: 'client',
                            coords: {
                                latitude: lat,
                                longitude: long
                            }, options: {
                                title: 'Local de entrega'
                            }
                        })
                    }else{
                        $ionicPopup.alert({
                            title: 'Atenção',
                            template: 'Endereço inválido.'
                        })
                    }
                })
            }

            function watchPositionDeliveryman(channel){

                var pusher = $pusher($window.client);
                var channel = pusher.subscribe(channel);
                channel.bind('Delivery\\Events\\GetLocationDeliveryman', function(data){
                    console.log(data);
                    var lat = data.geo.lat, long = data.geo.long;

                    if($scope.markers.length == 1 || $scope.markers.length == 0){
                        console.log($scope.markers.length);
                        $scope.markers.push({
                            id: 'entregador',
                            coords: {
                                latitude: lat,
                                longitude: long
                            }, options: {
                                title: 'Local do entregador'
                            }
                        });
                    }
                    for(var key in $scope.markers){
                        if($scope.markers[key].id == 'entregador'){
                            $scope.markers[key].coords = {
                                latitude: lat,
                                longitude: long
                            };
                        }
                    }

                });
            };

            function createBounds(){
                var bounds  = new google.maps.LatLngBounds(),
                    latlng;

                angular.forEach($scope.markers, function(value){
                    latlng = new google.maps.LatLng(Number(value.coords.latitude), Number(value.coords.longitude));
                    bounds.extend(latlng);
                });

                $scope.map.bounds = {
                    northeast:{
                        latitude: bounds.getNorthEast().lat(),
                        longitude: bounds.getNorthEast().lng()
                    },
                    southwest:{
                        latitude: bounds.getSouthWest().lat(),
                        longitude: bounds.getSouthWest().lng()
                    }
                };
            }
        }])

    .controller('ClientViewDeliveryCtrlDescentralize', ['$scope', '$map', function($scope, $map){
        $scope.map = $map;
        $scope.fit = function(){
            console.log($scope.map);
            $scope.map.fit = !$scope.map.fit;
        }
    }])
    .controller('ClientViewDeliveryCtrlReload', ['$scope', '$window','$timeout', function($scope, $window,$timeout){
        $scope.reload = function(){
            $timeout(function(){
                $window.location.reload(true);
            }, 100);
        }
    }])
