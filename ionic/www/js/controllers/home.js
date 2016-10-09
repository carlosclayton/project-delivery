angular.module('Home', [])
    .controller('HomeCtrl', function($scope,$state,$stateParams) {
        $scope.state = $state.current;
        $scope.nome = $stateParams.nome;
    });

