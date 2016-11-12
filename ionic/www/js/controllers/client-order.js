angular.module('starter.controllers')
    .controller('ClientOrderCtrl', ['$scope', '$state', '$stateParams', 'ClientOrder', '$ionicLoading', '$ionicActionSheet', '$timeout',
        function ($scope, $state, $stateParams, ClientOrder, $ionicLoading, $ionicActionSheet, $timeout) {
            $scope.items = [];
            var page = 1;
            $scope.canMoreItems = true;
            /*
            $ionicLoading.show({
                template: 'Carregando...'
            });
            */

            $scope.doRefresh = function () {
                page = 1;
                $scope.items = [];
                $scope.canMoreItems = true;
                $scope.loadMore();
                $timeout(function(){
                    $scope.$broadcast('scroll.refreshComplete');
                }, 2000)

                /*
                getOrders().then(function (data) {
                    $scope.items = data.data;
                    $scope.$broadcast('scroll.refreshComplete');
                }, function (dataError) {
                    $scope.$broadcast('scroll.refreshComplete');
                })
                */
            };
            $scope.openOrderDetail = function (order) {
                $state.go('client.view_order', {id: order.id});
            };

            function getOrders() {
                return ClientOrder.query({
                    id: null,
                    page: page,
                    orderBy: 'created_at',
                    sortedBy: 'desc'
                }).$promise;
            };

            /*
            getOrders().then(function (data) {

                $scope.items = data.data;
                $ionicLoading.hide();
            }, function (dataError) {
                $ionicLoading.hide();
            });
             */

            $scope.showActionSheet = function (order) {
                $ionicActionSheet.show({
                    buttons: [
                        { text: '<b>Ver detalhes</b>' },
                        { text: 'Ver entrega' }
                    ],
                    titleText: '<h3>O que fazer?</h3>',
                    cancelText: 'Cancelar',
                    cancel: function() {
                        // add cancel code..
                    },
                    buttonClicked: function(index) {
                        switch (index){
                            case 0:
                                $state.go('client.view_order', {id: order.id});
                                break;
                            case 1:
                                $state.go('client.view_delivery', {id: order.id});
                                break;
                        }
                    }
                })
            };

            $scope.loadMore = function(){
                getOrders()
                    .then(function(data){
                        $scope.items = $scope.items.concat(data.data);
                        if($scope.items.length == data.meta.pagination.total){
                            $scope.canMoreItems = false;
                        }
                        page +=  1;
                        $scope.$broadcast('scroll.infiniteScrollComplete');
                    })
            };


        }]);