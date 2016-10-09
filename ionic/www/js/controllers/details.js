angular.module('Details', [])
    .controller('ChatDetailCtrl', function($scope, $stateParams, Chats) {
        $scope.chat = Chats.get($stateParams.chatId);
    });