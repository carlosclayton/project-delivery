angular.module('starter.controllers.login', [])
    .controller('LoginCtrl', ['$scope', 'OAuth', '$cookies', '$ionicPopup', '$state', function ($scope, OAuth, $cookies, $ionicPopup, $state) {

        $scope.user = {
            username: '',
            password: ''
            };

        $scope.login = function () {
            OAuth.getAccessToken($scope.user)
                .then(function (data) {
                    $state.go('tab.dash');
                    console.log(data);
                    console.log($cookies.getObject('token'));
                }, function (responseError) {
                    $ionicPopup.alert({
                        title: 'Erro de autenticação',
                        template: 'Dados incorretos, tente novamente.'
                    })
                });
        }
    }]);
