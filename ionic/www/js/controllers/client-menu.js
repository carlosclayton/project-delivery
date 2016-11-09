angular.module('starter.controllers')
    .controller('ClientMenuCtrl', ['$scope', '$state', '$stateParams', 'UserData', '$ionicLoading',
        function ($scope, $state, $stateParams, UserData, $ionicLoading) {
        $scope.user = UserData.get();
    }]);