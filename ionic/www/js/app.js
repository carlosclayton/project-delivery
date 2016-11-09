// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.services' is found in services.js
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['ionic','ionic.service.core', 'starter.services', 'starter.controllers', 'angular-oauth2', 'ngResource', 'ngCordova', 'starter.filters', 'uiGmapgoogle-maps', 'pusher-angular'])

    .constant('appConfig', {
        baseUrl: 'http://192.168.1.101:8000',
        //baseUrl: 'http://172.16.1.180:8000',
        pusherKey: '87930d54ca1c35677b31'
    })
    .value('meuValue', 'Carlos Clayton')
    .provider('minhaCalculadora', function () {
        var o = {
            calcular: function () {
                return this.largura * this.comprimento
            }
        };
        return {
            $get: function () {
                o.largura = this.largura;
                o.comprimento = this.comprimento;
                return o;
            }
        }
    })

    .factory('meuFactory', function () {
        return {
            largura: 40,
            comprimento: 40,
            minhaFuncao: function () {
                console.log(this.largura * this.comprimento);
            }
        };
    })
    .service('meuService', function () {
        this.largura = 40;
        this.comprimento = 40;
        this.minhaFuncao = function () {
            console.log(this.largura * this.comprimento);
        }
    })

    .service('cart', function () {
        this.items = [];
    })

    .run(function ($ionicPlatform, meuValue, meuService, meuFactory, $window, appConfig, $localStorage) {
        $window.client = new Pusher(appConfig.pusherKey);



        meuService.minhaFuncao();
        meuFactory.minhaFuncao();
        console.log(meuValue);
        $ionicPlatform.ready(function () {

            Ionic.io();
            var push = new Ionic.Push({
               debug: true,
                onNotification: function(message){
                    console.log(message);
                }

            });

            push.register(function(token){
                console.log(token);
                $localStorage.set('device_token', token.token);
            })
            // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
            // for form inputs)
            if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
                cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
                cordova.plugins.Keyboard.disableScroll(true);

            }
            if (window.StatusBar) {
                // org.apache.cordova.statusbar required
                StatusBar.styleDefault();
            }
        });
    })

    .config(function ($stateProvider, $urlRouterProvider, OAuthProvider, OAuthTokenProvider, minhaCalculadoraProvider, appConfig, $provide) {

        minhaCalculadoraProvider.largura = 80;
        minhaCalculadoraProvider.comprimento = 80;


        OAuthProvider.configure({
            baseUrl: appConfig.baseUrl,
            clientId: 'app01',
            clientSecret: 'secret', // optional
            grantPath: '/oauth/access_token'
        });

        OAuthTokenProvider.configure({
            name: 'token',
            options: {
                secure: false
            }
        });

        // Ionic uses AngularUI Router which uses the concept of states
        // Learn more here: https://github.com/angular-ui/ui-router
        // Set up the various states which the app can be in.
        // Each state's controller can be found in controllers.js
        $stateProvider
            // setup an abstract state for the tabs directive

            .state('menu', {
                url: '/menu',
                templateUrl: 'templates/menu.html',
                controller: function($scope){

                }
                /*
                controller: function($scope, $ionicSideMenuDelegate){
                    $scope.abrirEsquerdo = function(){
                        $ionicSideMenuDelegate.toggleLeft();
                    }
                    $scope.abrirDireito = function(){
                        $ionicSideMenuDelegate.toggleRight();
                    }

                }
                */
            })
            .state('menu.a', {
                url: '/a',
                template: '<ion-view>' +
                '<ion-content class="has-header">' +
                '<h1>Estamos na A </h1>' +
                '<a ui-sref="menu.b">Ir para B</a><br />' +
                '<a ui-sref="menu.a">Ir para A</a><br />' +
                '</ion-content>' +
                '</ion-view>',
                controller: function($scope){

                }
            })
            .state('menu.b', {
                url: '/b',
                template: '<ion-view>' +
                '<ion-content class="has-header">' +
                '<h1>Estamos na B </h1>' +
                '<a ui-sref="menu.a">Ir para A</a><br />' +
                '<a ui-sref="menu.c">Ir para C</a><br />' +
                '</ion-content>' +
                '</ion-view>',
                controller: function($scope){

                }
            })
            .state('menu.c', {
                url: '/c',
                template: '<ion-view>' +
                '<ion-content class="has-header">' +
                '<h1>Estamos na C </h1>' +
                '<a ui-sref="menu.a">Ir para A</a><br />' +
                '<a ui-sref="menu.b">Ir para B</a><br />' +
                '</ion-content>' +
                '</ion-view>',
                controller: function($scope){

                }
            })

            .state('login', {
                url: '/login',
                templateUrl: 'templates/login.html',
                controller: 'LoginCtrl'
            })
            .state('client', {
                abstract: true,
                cache: false,
                url: '/client',
                templateUrl: 'templates/client/menu.html',
                controller: 'ClientMenuCtrl'
            })

            .state('client.order', {
                url: '/order',
                templateUrl: 'templates/client/order.html',
                controller: 'ClientOrderCtrl'
            })
            .state('client.view_order', {
                url: '/view_order/:id',
                templateUrl: 'templates/client/view_order.html',
                controller: 'ClientViewOrderCtrl'
            })

            .state('client.view_delivery', {
                url: '/view_delivery/:id',
                templateUrl: 'templates/client/view_delivery.html',
                controller: 'ClientViewDeliveryCtrl'
            })

            .state('client.checkout', {
                cache: false,
                url: '/checkout',
                templateUrl: 'templates/client/checkout.html',
                controller: 'ClientCheckoutCtrl'
            })

            .state('client.checkout_item_detail', {
                url: '/checkout/detail/:index',
                templateUrl: 'templates/client/checkout_item_detail.html',
                controller: 'ClientCheckoutDetailCtrl'
            })

            .state('client.checkout_successful', {
                cache: false,
                url: '/checkout/successful',
                templateUrl: 'templates/client/checkout_successful.html',
                controller: 'ClientCheckoutSuccessfulCtrl'
            })

            .state('client.view_products', {
                url: '/view_products',
                templateUrl: 'templates/client/view_products.html',
                controller: 'ClientViewProductCtrl'
            })

            .state('deliveryman', {
                abstract: true,
                cache: false,
                url: '/deliveryman',
                templateUrl: 'templates/deliveryman/menu.html',
                controller: 'DeliverymanMenuCtrl'
            })
            .state('deliveryman.order', {
                url: '/order',
                templateUrl: 'templates/deliveryman/order.html',
                controller: 'DeliverymanOrderCtrl'
            })
            .state('deliveryman.view_order', {
                cache: false,
                url: '/view_order/:id',
                templateUrl: 'templates/deliveryman/view_order.html',
                controller: 'DeliverymanViewOrderCtrl'
            })

            .state('tab', {
                url: '/tab',
                abstract: true,
                templateUrl: 'templates/tabs.html'
            })

            // Each tab has its own nav history stack:

            .state('tab.dash', {
                url: '/dash',
                views: {
                    'tab-dash': {
                        templateUrl: 'templates/tab-dash.html',
                        controller: 'DashCtrl'
                    }
                }
            })
            .state('tab.home', {
                url: '/home/:nome',
                views: {
                    'tab-home': {
                        templateUrl: 'templates/tab-home.html',
                        controller: 'HomeCtrl'
                    }
                }
            })


            .state('tab.chats', {
                url: '/chats',
                views: {
                    'tab-chats': {
                        templateUrl: 'templates/tab-chats.html',
                        controller: 'ChatsCtrl'
                    }
                }
            })
            .state('tab.chat-detail', {
                url: '/chats/:chatId',
                views: {
                    'tab-chats': {
                        templateUrl: 'templates/chat-detail.html',
                        controller: 'ChatDetailCtrl'
                    }
                }
            })

            .state('tab.account', {
                url: '/account',
                views: {
                    'tab-account': {
                        templateUrl: 'templates/tab-account.html',
                        controller: 'AccountCtrl'
                    }
                }
            });


        // if none of the above states are matched, use this as the fallback
        $urlRouterProvider.otherwise('/login');

        $provide.decorator('OAuthToken', ['$localStorage', '$delegate', function ($localStorage, $delegate) {
            Object.defineProperties($delegate, {
                setToken: {
                    value: function (data) {
                        return $localStorage.setObject('token', data);
                    },
                    enumerable: true,
                    configurable: true,
                    writable: true
                },
                getToken: {
                    value: function (data) {
                        return $localStorage.getObject('token');
                    },
                    enumerable: true,
                    configurable: true,
                    writable: true
                }, removeToken: {
                    value: function (data) {
                        $localStorage.setObject('token', null);
                    },
                    enumerable: true,
                    configurable: true,
                    writable: true
                }
            });
            return $delegate;
        }]);
    });
