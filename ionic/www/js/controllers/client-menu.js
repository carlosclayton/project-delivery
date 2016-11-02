angular.module('starter.controllers')
    .controller('ClientMenuCtrl', ['$scope', '$state', '$stateParams', 'User', '$ionicLoading', function ($scope, $state, $stateParams, User, $ionicLoading) {
        $scope.user = {
            name: ''
        }
        $ionicLoading.show({
            template: 'Carregando...'
        });

        User.authenticated({}, function (data) {
            $scope.user = data.data;
            $ionicLoading.hide();
        }, function(dataError){
            $ionicLoading.hide();
        })

    }]);