<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    $repository = app()->make('Delivery\Repositories\CategoryRepository');
    return $repository->all();
});


Route::group(['middleware' => ['web']], function () {


});

Route::group(['prefix' => 'auth'], function () {

    Route::get('login', function () {
        return view('auth.login');
    });

    Route::get('register', function () {
        return view('auth.login');
    });

});


Route::group(['prefix' => 'admin', 'middleware' => 'auth.checkrole:admin'], function () {


    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'CategoriesController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'CategoriesController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'CategoriesController@store']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'CategoriesController@update']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'CategoriesController@edit']);
    });


    Route::group(['prefix' => 'products'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'ProductsController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'ProductsController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'ProductsController@store']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'ProductsController@update']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ProductsController@edit']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'ProductsController@destroy']);
    });

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'ClientsController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'ClientsController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'ClientsController@store']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'ClientsController@update']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'ClientsController@edit']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'ClientsController@destroy']);
    });

    Route::group(['prefix' => 'cupoms'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'CupomsController@index']);
        Route::get('create', ['as' => 'cupoms.create', 'uses' => 'CupomsController@create']);
        Route::post('store', ['as' => 'cupoms.store', 'uses' => 'CupomsController@store']);
        Route::post('update/{id}', ['as' => 'cupoms.update', 'uses' => 'CupomsController@update']);
        Route::get('edit/{id}', ['as' => 'cupoms.edit', 'uses' => 'CupomsController@edit']);
        Route::get('destroy/{id}', ['as' => 'cupoms.destroy', 'uses' => 'CupomsController@destroy']);
    });


    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', ['as' => 'index', 'uses' => 'OrdersController@index']);
        Route::get('create', ['as' => 'create', 'uses' => 'OrdersController@create']);
        Route::post('store', ['as' => 'store', 'uses' => 'OrdersController@store']);
        Route::post('update/{id}', ['as' => 'update', 'uses' => 'OrdersController@update']);
        Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'OrdersController@edit']);
        Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'OrdersController@destroy']);
    });
});

Route::group(['prefix' => 'customer'], function () {
    Route::group(['prefix' => 'orders'], function () {
        Route::get('/', ['as' => 'orders.index', 'uses' => 'CheckoutController@index']);
        Route::get('create', ['as' => 'orders.create', 'uses' => 'CheckoutController@create']);
    });
});


Route::group(['middleware' => 'cors'], function () {

    Route::post('oauth/access_token', function () {
        return Response::json(Authorizer::issueAccessToken());
    });


    Route::group(['prefix' => 'api', 'middleware' => 'oauth'], function () {

        Route::group(['prefix' => 'client', 'middleware' => 'oauth.checkrole:client'], function () {

            Route::resource('order',
                'Api\Client\ClientCheckoutController', ['except' => ['create', 'edit', 'destroy']
                ]);


            Route::get('products',['as' => 'api.client.products', 'uses' => 'Api\Client\ClientProductController@index']);

            /*
            Route::get('order', function () {
                return [
                    'Pegando dados'
                ];
            });

            Route::post('order', function () {
                return [
                    'Criando dados'
                ];
            });

            Route::patch('order', function () {
                return [
                    'Atualizando dados'
                ];
            });


            Route::delete('order', function () {
                return [
                    'Excluindo dados'
                ];
            });

            */


        });

        Route::group(['prefix' => 'deliveryman', 'middleware' => 'oauth.checkrole:deliveryman', 'as' => 'client.'], function () {

            Route::resource('order',
                'Api\Deliveryman\DeliveryCheckoutController', ['except' => ['create', 'edit', 'destroy']
                ]);


            Route::patch('order/{id}/update-status', ['uses' => 'Api\Deliveryman\DeliveryCheckoutController@updateStatus', 'as' => 'orders.update_status']);

            Route::get('pedidos', function () {
                return [
                    'id' => 1,
                    'client' => 'Entregador Carlos',
                    'total' => 10
                ];
            });

        });


        // Endpoint
        Route::get('authenticated', 'Api\UserController@authenticated');
        Route::get('cupom/{code}', 'Api\Cupom\CupomController@show');
    });
});





