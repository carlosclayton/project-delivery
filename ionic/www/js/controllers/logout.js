angular.module('starter.controllers')
    .controller('LogoutCtrl', ['$scope', 'OAuth', 'OAuthToken', '$cookies', '$ionicPopup', '$state', '$q', 'UserData', 'User', '$localStorage', '$ionicHistory',
        function ($scope, OAuth, OAuthToken, $cookies, $ionicPopup, $state, $q, UserData, User, $localStorage, $ionicHistory) {

            OAuthToken.removeToken();
            UserData.set(null);
            $ionicHistory.clearCache();
            $ionicHistory.clearHistory();
            $ionicHistory.nextViewOptions({
                disableBack: true,
                historyRoot: true
            })
            $state.go('login');
}]);


