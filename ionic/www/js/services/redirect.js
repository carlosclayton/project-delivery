angular.module('starter.services')
    .service('$redirect',['$state', 'UserData', 'appConfig', function ($state, UserData, appConfig) {
        this.redirecAfterLogin = function(){
        var user = UserData.get();
            $state.go(appConfig.redirectAfterLogin[user.role]);
        }
    }]);