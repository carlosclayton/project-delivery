angular.module('starter.controllers')
    .controller('LoginCtrl', ['$scope', 'OAuth', 'OAuthToken', '$cookies', '$ionicPopup', '$state', '$q', 'UserData', 'User', '$localStorage',
        function ($scope, OAuth, OAuthToken, $cookies, $ionicPopup, $state, $q, UserData, User, $localStorage) {

            $scope.user = {
                username: '',
                password: ''
            };
            /*
             function adiarExecucao(){
             var deffered = $q.defer();
             setTimeout(function(){
             deffered.resolve({name: 'ionic'});
             //deffered.reject({name: 'ionic'});
             });
             return deffered.promise;
             }

             var promise = adiarExecucao();
             */

            $scope.login = function () {
                var promise = OAuth.getAccessToken($scope.user);
                promise
                    .then(function (data) {
                        var token = $localStorage.get('device_token');
                        return User.updateDeviceToken({},{device_token: token }).$promise;
                    })
                    .then(function (data) {
                    return User.authenticated({include: 'client'}).$promise;
                })
                    .then(function(data){
                        console.log(data.data);
                        UserData.set(data.data);
                        $state.go('client.checkout');
                }, function (dataError) {
                        UserData.set(null);
                        OAuthToken.removeToken();
                        $ionicPopup.alert({
                            title: 'Erro de autenticação',
                            template: 'Dados incorretos, tente novamente.'
                        });
                        console.log(dataError);

                })
        }
}]);


